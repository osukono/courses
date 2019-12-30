<div class="card mb-3 border-0">
    <div class="card-body">
        <div class="card-title">
            <h4 class="d-inline">
                {{ $userCourse->course->language . ' ' . $userCourse->course->level }}
                @if($userCourse->demo && !$userCourse->course->free)
                    <span class="badge badge-pill badge-info ml-2">{{ __('Demo') }}</span>
                @endif
                @if($userCourse->course->free)
                    <span class="badge badge-pill badge-success ml-2">{{ __('Free') }}</span>
                @endif
                @if($userCourse->progress['lesson'] > $userCourse->course->latestContent->course_lessons_count)
                    <span class="badge badge-pill badge-info ml-2">{{ __('Finished') }}</span>
                @endif
            </h4>
            @if($userCourse->progress['lesson'] <= $userCourse->course->latestContent->course_lessons_count)
                <a href="{{ route('courses.practice', $userCourse->course) }}"
                   class="btn btn-outline-primary ml-2 d-none d-md-inline-block">{{ __('Continue the course') }}</a>
                <div class="text-center d-md-none">
                    <a href="{{ route('courses.practice',  $userCourse->course) }}"
                       class="btn btn-lg btn-outline-primary my-3">{{ __('Continue the course') }}</a>
                </div>
            @else
                <a href="#" onclick="document.getElementById('reset-{{ $userCourse->course }}').submit();"
                   class="btn btn-outline-primary ml-2 d-md-inline-block">{{ __('Reset progress') }}</a>
                <div class="text-center d-md-none">
                    <a href="#" onclick="document.getElementById('reset-{{ $userCourse->course }}').submit();"
                       class="btn btn-lg btn-outline-primary my-3">{{ __('Reset progress') }}</a>
                </div>
                <form id="reset-{{ $userCourse->course }}" class="d-none"
                      action="{{ route('courses.progress.reset', $userCourse->course) }}" method="post">
                    @csrf
                </form>
            @endif
        </div>

        <table class="table mb-0">
            <tbody>
            @foreach($userCourse->course->latestContent->courseLessons as $courseLesson)
                <tr>
                    <td class="py-3 lead">
                        <span class="align-middle mr-4">{{ $courseLesson->number }}</span>
                        <span class="align-middle mr-2">{{ $courseLesson->title }}</span>
                        @if(!$userCourse->course->free && $userCourse->demo && $userCourse->course->demo_lessons >= $courseLesson->number)
                            <span class="align-middle badge badge-success">{{ __('Free') }}</span>
                        @endif
                    </td>
                    <td class="text-right align-middle">
                        @if($courseLesson->number < $userCourse->progress['lesson'])
                            <a href="{{ route('courses.practice.lesson', [$userCourse->course, $courseLesson->number]) }}"
                               class="btn btn-outline-primary">{{ __('Repeat lesson') }}</a>
                        @elseif($courseLesson->number == $userCourse->progress['lesson'])
                            <a href="{{ route('courses.practice', $userCourse->course) }}"
                               class="btn btn-outline-primary">{{ ($userCourse->progress['part'] == 1) ? __('Start lesson') : __('Continue lesson') }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
