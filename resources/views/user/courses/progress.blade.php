<div class="card mb-3 border-0">
    <div class="card-body">
        <div class="card-title">
            <h5 class="d-inline">
                @if($userCourse->demo && !$userCourse->course->free)
                    <span class="badge badge-info">{{ __('Demo') }}</span>
                @endif
                @if($userCourse->progress['lesson'] > $userCourse->course->latestContent->course_lessons_count)
                    <span class="badge badge-info">{{ __('Finished') }}</span>
                @endif
                {{ $userCourse->course->language . ' ' . $userCourse->course->level }}
            </h5>
            <span>
                @if($userCourse->progress['lesson'] <= $userCourse->course->latestContent->course_lessons_count)
                    <a href="{{ route('courses.practice', $userCourse->course) }}"
                       class="btn btn-outline-primary ml-2">{{ __('Continue the course') }}</a>
                @else
                    <a href="#" onclick="document.getElementById('reset-{{ $userCourse->course }}').submit();"
                       class="btn btn-link btn-outline-primary">{{ __('Reset progress') }}</a>
                    <form id="reset-{{ $userCourse->course }}" class="d-none"
                          action="{{ route('courses.progress.reset', $userCourse->course) }}" method="post">
                        @csrf
                    </form>
                @endif
            </span>
        </div>

        <table class="table mb-0">
            <tbody>
            @foreach($userCourse->course->latestContent->courseLessons as $courseLesson)
                <tr>
                    <td class="py-3 lead">
                        <span class="align-middle mr-4">{{ $courseLesson->number }}</span>
                        <span class="align-middle mr-2">{{ $courseLesson->title }}</span>
                        @if($userCourse->demo && $userCourse->course->demo_lessons >= $courseLesson->number)
                            <span class="align-middle badge badge-success">{{ __('Free') }}</span>
                        @endif
                    </td>
                    <td class="text-right">
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
