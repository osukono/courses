<div class="card mb-3 border-0">
    <div class="card-body">
        <div class="card-title">
            <h5>
                {{ $course->language . ' ' . $course->level }}
                @if($course->free)
                    <span class="badge badge-success ml-2">{{ __('Free') }}</span>
                @endif
                <a rel="nofollow" href="{{ route('courses.practice', $course) }}"
                   class="btn btn-outline-primary ml-2">{{ __('Practice') }}</a>
            </h5>
        </div>
        <p class="card-text mx-3" lang="{{ $course->translation->code }}">{{ $course->description }}</p>
        <h5>{{ __('Course topics') }}</h5>
        <div class="row ml-3">
            @foreach($course->latestContent->courseLessons->chunk(ceil($course->latestContent->courseLessons->count() / 2)) as $chunk)
                <div class="col-12 col-lg-4 col-md-6 px-0">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                        @foreach($chunk as $courseLesson)
                            <tr>
                                <td class="text-right" style="min-width: 30px">{{ $courseLesson->number . '. ' }}</td>
                                <td class="col-11">
                                    <a href="{{ route('courses.show.lesson', [$course, $courseLesson->number]) }}">{{ $courseLesson->title }}</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
        {{--<div class="ml-3">
            <h5>{{ __('Course topics') }}</h5>
            <table class="table table-sm table-borderless ml-3">
                <tbody>
                @foreach($course->latestContent->courseLessons as $courseLesson)
                    <tr>
                        <td class="text-right">{{ $courseLesson->number . '. ' }}</td>
                        <td class="col-11">
                            <a href="{{ route('courses.show.lesson', [$course, $courseLesson->number]) }}">{{ $courseLesson->title }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>--}}
    </div>
</div>
