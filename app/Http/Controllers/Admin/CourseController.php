<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CourseUpdateRequest;
use App\Repositories\CourseRepository;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $data['courses'] = CourseRepository::all()
            ->with([
                'latestContent' => function (HasOne $query) {
                    $query->withCount('courseLessons');
                },
                'language',
                'translation',
                'level'
            ])
            ->ordered()->get();

        return view('admin.courses.index')->with($data);
    }

    public function show(Course $course)
    {
        $data['course'] = $course;
        $data['courseContent'] = $course->latestContent;
        $data['lessons'] = $data['courseContent']->courseLessons;

        return view('admin.courses.show')->with($data);
    }

    public function edit(Course $course)
    {
        $data['course'] = $course;

        return view('admin.courses.edit')->with($data);
    }

    public function update(CourseUpdateRequest $request, Course $course)
    {
        $course->repository()->update($request->all());

        return redirect()->route('admin.courses.show', $course);
    }
}
