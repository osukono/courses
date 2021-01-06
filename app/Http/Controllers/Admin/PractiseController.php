<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Language;
use App\Lesson;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PractiseController extends Controller
{
    /**
     * @param Language $language
     * @param Lesson $lesson
     * @throws AuthorizationException
     */
    public function listening(Language $language, Lesson $lesson) {
        $this->authorize('access', $lesson);
    }

    /**
     * @param Language $language
     * @param Lesson $lesson
     * @throws AuthorizationException
     */
    public function speaking(Language $language, Lesson $lesson) {
        $this->authorize('access', $lesson);
    }
}
