<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Language;
use App\Lesson;
use Illuminate\Http\Request;

class PractiseController extends Controller
{
    public function listening(Language $language, Lesson $lesson) {
        $this->authorize('access', $lesson);
    }

    public function speaking(Language $language, Lesson $lesson) {
        $this->authorize('access', $lesson);
    }
}
