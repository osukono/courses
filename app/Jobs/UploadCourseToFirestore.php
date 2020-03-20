<?php

namespace App\Jobs;

use App\Course;
use App\Library\Firebase;
use App\Repositories\FirebaseCourseRepository;
use App\Repositories\FirebaseLanguageRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Imtigger\LaravelJobStatus\Trackable;
use Kreait\Firebase\Exception\RemoteConfigException;

class UploadCourseToFirestore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    private Course $course;

    /**
     * Create a new job instance.
     *
     * @param Course $course
     */
    public function __construct(Course $course)
    {
        $this->prepareStatus();
        $this->course = $course;
    }

    public function getDisplayName()
    {
        return 'Uploading course to Firebase.';
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws RemoteConfigException
     * @throws Exception
     */
    public function handle()
    {
        $this->course->loadMissing([
            'language',
            'translation',
            'level',
            'topic',
            'courseLessons' => function (HasMany $query) {
                $query->orderBy('index');
            }
        ]);
        $this->course->loadCount('courseLessons');

        $this->setProgressMax(8);

        $firestore = Firebase::getInstance()->firestoreClient();

        $firestoreCourse = FirebaseCourseRepository::findOrCreate($this->course);

//        FirebaseCourseRepository::setIsUpdating($this->course);
        /*
         * Update course properties
         */
        FirebaseCourseRepository::updateProperties($this->course);
        $this->incrementProgress();

        /*
         * Delete old lessons and exercises
         */
        FirebaseCourseRepository::deleteContent($this->course);
        $this->incrementProgress();

        /*
         * Add new lessons and exercises
         */
        FirebaseCourseRepository::uploadContent($this->course);
        $this->incrementProgress();

        /*
         * Update course language: translations and course indicator
         */
        $translations = [];
        $firestoreLanguageCourses = $firestore->collection(Firebase::courses_collection)
            ->where('language', '=', $this->course->language->firebase_id)
            ->documents()->rows();
        foreach ($firestoreLanguageCourses as $firestoreLanguageCourse)
            if (!in_array($firestoreLanguageCourse->get('translation'), $translations))
                $translations[] = $firestoreLanguageCourse->get('translation');

        $firestoreLanguage = $firestore->collection(Firebase::languages_collection)
            ->document($this->course->language->firebase_id);
        $firestoreLanguage->set([
            'course' => true,
            'translations' => $translations
        ], ['merge' => true]);
        $this->incrementProgress();

//        FirebaseCourseRepository::setIsUpdating($this->course, false);

        /*
         * Increment server_languages_version at Firebase's Remote Config.
         * ToDo do not increment version if languages didn't change.
         */
        FirebaseLanguageRepository::incrementLanguagesVersion();
        $this->incrementProgress();

        /*
         * Increment server_courses_version at Firebase's Remote Config
         */
        FirebaseCourseRepository::incrementCoursesVersion();
        $this->incrementProgress();

        $this->course->uploaded_at = Carbon::now();
        if (!isset($this->course->firebase_id)) {
            $this->course->firebase_id = $firestoreCourse->id();
        }
        $this->course->save();
        $this->incrementProgress();
    }
}
