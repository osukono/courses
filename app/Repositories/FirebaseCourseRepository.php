<?php


namespace App\Repositories;


use App\Course;
use App\Library\Firebase;
use Exception;
use Google\Cloud\Firestore\DocumentReference;
use Kreait\Firebase\Exception\RemoteConfigException;

class FirebaseCourseRepository
{
    /**
     * @param Course $course
     * @return DocumentReference
     * @throws Exception
     */
    public static function findOrCreate(Course $course): DocumentReference
    {
        $firestore = Firebase::getInstance()->firestoreClient();

        if (isset($course->firebase_id)) {
            return $firestore->collection(Firebase::courses_collection)->document($course->firebase_id);
        }

        FirebaseLanguageRepository::validateFirebaseID($course->language);
        FirebaseTopicRepository::validateFirebaseID($course->topic);
        FirebaseLanguageRepository::validateFirebaseID($course->translation);

        $course->loadCount('courseLessons');

        $courses = $firestore->collection(Firebase::courses_collection)
            ->where('language', '=', $course->language->firebase_id)
            ->where('level', '=', $course->level->scale)
            ->where('topic', '=', $course->topic->firebase_id)
            ->where('translation', '=', $course->translation->firebase_id)
            ->limit(1)
            ->documents();

        if (!$courses->isEmpty()) {
            return $courses->rows()[0]->reference();
        }

        return $firestore->collection(Firebase::courses_collection)
            ->add([
                'is_updating' => true,
                'hidden' => false,
                'audio_storage' => 'https://yummy-lingo.s3.eu-central-1.amazonaws.com/',
                'course_version' => $course->minor_version,
                'description' => $course->description,
                'icon' => $course->image,
                'language' => $course->language->firebase_id,
                'level' => $course->level->scale,
                'level_name' => $course->level->name,
                'player_version' => $course->player_version,
                'review_exercises' => $course->review_exercises,
                'title' => $course->title,
                'topic' => $course->topic->firebase_id,
                'translation' => $course->translation->firebase_id,
                'lessons_count' => $course->course_lessons_count
            ]);
    }

    /**
     * @param Course $course
     * @param bool $is_updating
     * @throws Exception
     */
    public static function setIsUpdating(Course $course, bool $is_updating = true)
    {
        FirebaseCourseRepository::validateFirestoreID($course);

        $firestore = Firebase::getInstance()->firestoreClient();

        $firestore->collection(Firebase::courses_collection)->document($course->firebase_id)->set([
            'is_updating' => $is_updating
        ], ['merge' => true]);
    }

    /**
     * @param Course $course
     * @throws Exception
     */
    public static function updateProperties(Course $course)
    {
        FirebaseCourseRepository::validateFirestoreID($course);

        $course->loadCount('courseLessons');

        $firestore = Firebase::getInstance()->firestoreClient();

        $firestore->collection(Firebase::courses_collection)->document($course->firebase_id)
            ->set([
                'audio_storage' => 'https://yummy-lingo.s3.eu-central-1.amazonaws.com/',
                'course_version' => $course->minor_version,
                'description' => $course->description,
                'image' => $course->image,
                'player_version' => $course->player_version,
                'review_exercises' => $course->review_exercises,
                'title' => $course->title,
                'lessons_count' => $course->course_lessons_count
            ], ['merge' => true]);
    }

    /**
     * @param Course $course
     * @throws Exception
     */
    public static function deleteContent(Course $course)
    {
        FirebaseCourseRepository::validateFirestoreID($course);

        $firestore = Firebase::getInstance()->firestoreClient();

        $firestoreLessons = $firestore->collection(Firebase::lessons_collection)
            ->where('course', '=', $course->firebase_id)
            ->documents()->rows();

        foreach ($firestoreLessons as $firestoreLesson) {
            $batch = $firestore->batch();

            $firestoreExercises = $firestore->collection(Firebase::exercises_collection)
                ->where('lesson_id', '=', $firestoreLesson->id())
                ->documents()->rows();
            foreach ($firestoreExercises as $firestoreExercise)
                $batch->delete($firestoreExercise->reference());

            $batch->delete($firestoreLesson->reference());
            $batch->commit();
        }
    }

    /**
     * @param Course $course
     * @throws Exception
     */
    public static function uploadContent(Course $course)
    {
        FirebaseCourseRepository::validateFirestoreID($course);

        $firestore = Firebase::getInstance()->firestoreClient();

        foreach ($course->courseLessons as $courseLesson) {
            $batch = $firestore->batch();

            $newLesson = $firestore->collection(Firebase::lessons_collection)->newDocument();
            $batch->create($newLesson, [
                'course' => $course->firebase_id,
                'order' => $courseLesson->index - 1,
                'title' => $courseLesson->title,
                'image' => $courseLesson->image,
                'description' => $courseLesson->description,
            ]);

            $content = $courseLesson->content;

            foreach ($content['exercises'] as $exercise) {
                $dataArray = [];
                foreach ($exercise['data'] as $exerciseData) {
                    $data = [];
                    $data['c_value'] = $exerciseData['value'];
                    $data['c_audio'] = $exerciseData['audio'];
                    $data['c_duration'] = (int) $exerciseData['duration'];
                    if (isset($exerciseData['extra_chunks']))
                        $data['c_extra_chunks'] = $exerciseData['extra_chunks'];
                    if (isset($exerciseData['capitalized_words']))
                        $data['c_capitalized_words'] = $exerciseData['capitalized_words'];
                    if (isset($exerciseData['translation'])) {
                        $data['t_value'] = $exerciseData['translation']['value'];
                        $data['t_audio'] = $exerciseData['translation']['audio'];
                        $data['t_duration'] = (int) $exerciseData['translation']['duration'];
                    }
                    $dataArray[] = $data;
                }

                $newExercise = $firestore->collection(Firebase::exercises_collection)->newDocument();
                $batch->create($newExercise, [
                    'course' => $course->firebase_id,
                    'lesson_id' => $newLesson->id(),
                    'order' => $exercise['index'] - 1,
                    'data' => $dataArray
                ]);
            }

            $batch->commit();
        }
    }

    /**
     * @param Course $course
     * @throws Exception
     */
    public static function validateFirestoreID(Course $course)
    {
        if (! isset($course->firebase_id))
            throw new Exception($course . '. Firebase ID is not set.');
    }

    /**
     * @throws RemoteConfigException
     */
    public static function incrementCoursesVersion()
    {
        Firebase::incrementConfigParameter(Firebase::server_courses_version);
    }
}
