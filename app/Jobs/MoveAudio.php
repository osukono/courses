<?php

namespace App\Jobs;

use App\Content;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Imtigger\LaravelJobStatus\Trackable;

class MoveAudio implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    /** @var Content $content */
    private $content;

    /**
     * Create a new job instance.
     *
     * @param Content $content
     */
    public function __construct(Content $content)
    {
        $this->prepareStatus();
        $this->content = $content;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->content->loadMissing([
            'lessons',
            'lessons.exercises',
            'lessons.exercises.exerciseFields',
            'lessons.exercises.exerciseFields.translations'
        ]);

        $this->setProgressMax($this->content->lessons->count());

        foreach ($this->content->lessons as $lesson) {
            foreach ($lesson->exercises as $exercise) {
                foreach ($exercise->exerciseFields as $exerciseField) {
                    $content = $this->moveAudio($exerciseField->content);
                    $exerciseField->content = $content;
                    $exerciseField->save();
                    foreach ($exerciseField->translations as $translation) {
                        $content = $this->moveAudio($translation->content);
                        $translation->content = $content;
                        $translation->save();
                    }
                }
            }

            $this->incrementProgress();
        }
    }

    private function moveAudio($content)
    {
        if (isset($content['audio'])) {
            if (\Str::startsWith($content['audio'], 'audio/')) {
                $content['audio'] = substr($content['audio'], 6);
            }
        }

        return $content;
    }
}
