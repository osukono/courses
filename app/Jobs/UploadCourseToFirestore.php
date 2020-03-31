<?php

namespace App\Jobs;

use App\Course;
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

        $this->setProgressMax(7);

        $firestoreCourse = FirebaseCourseRepository::findOrCreate($this->course);

        if (!isset($this->course->firebase_id)) {
            $this->course->firebase_id = $firestoreCourse->id();
            $this->course->save();
        }
        $this->incrementProgress();

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
         * Update course and translations fields at language
         */
        if (FirebaseLanguageRepository::updateCourseProperty($this->course->language) ||
            FirebaseLanguageRepository::updateTranslationsProperty($this->course->language)) {
            // Increment server_languages_version at Firebase's Remote Config.
            FirebaseLanguageRepository::incrementLanguagesVersion();
        };
        $this->incrementProgress();

        /*
         * Increment server_courses_version at Firebase's Remote Config
         */
        FirebaseCourseRepository::incrementCoursesVersion();
        $this->incrementProgress();

        $this->course->uploaded_at = Carbon::now();
        $this->course->save();
        $this->incrementProgress();
    }
}
