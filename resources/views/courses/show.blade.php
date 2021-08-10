<div class="card mb-3 border-0">
    <div class="card-body">
        <div class="card-title">
            <h4 class="d-inline">
                <span>{{ $course->language . ' ' . $course->level }}</span>
                @if($course->free)
                    <span class="badge badge-pill badge-success ms-2 d-inline">{{ __('Free') }}</span>
                @endif
            </h4>
            <a rel="nofollow" href="{{ route('courses.practice', $course) }}"
               class="btn btn-outline-primary ms-2 d-none d-md-inline-block text-uppercase">{{ __('web.course.practice') }}</a>
        </div>
        <div class="text-center d-md-none">
            <a rel="nofollow" href="{{ route('courses.practice', $course) }}"
               class="btn btn-lg btn-outline-primary my-3 text-uppercase">{{ __('web.course.practice') }}</a>
        </div>
        <p class="card-text mx-3" lang="{{ $course->translation->code }}">{{ $course->description }}</p>
        <h5>{{ __('web.course.topics') }}</h5>
        <div class="row ms-3">
            @foreach($course->latestContent->courseLessons->chunk(ceil($course->latestContent->courseLessons->count() / 2)) as $chunk)
                <div class="col-12 col-lg-4 col-md-6 px-0">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                        @foreach($chunk as $courseLesson)
                            <tr>
                                {{--<td class="text-end" style="min-width: 30px">{{ $courseLesson->number . '. ' }}</td>
                                <td class="col-11">
                                    <a href="{{ route('courses.show.lesson', [$course, $courseLesson->number]) }}">{{ $courseLesson->title }}</a>
                                </td>--}}
                                <td>{{ $courseLesson->number . '. ' . $courseLesson->title }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
        {{--<div class="ms-3">
            <h5>{{ __('Course topics') }}</h5>
            <table class="table table-sm table-borderless ms-3">
                <tbody>
                @foreach($course->latestContent->courseLessons as $courseLesson)
                    <tr>
                        <td class="text-end">{{ $courseLesson->number . '. ' }}</td>
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
