<div class="container-fluid">
    <div class="row pt-5 pb-4">
        <div class="d-none d-lg-table-cell col-lg-5">
            <img src="{{ URL::asset('/images/courses.svg') }}" class="w-100">
        </div>
        <div class="col-10 offset-1 col-lg-7 offset-lg-0">
            <div class="row mb-4">
                <div class="col"><h1 class="text-primary">{{ __('web.index.section.courses.header') }}</h1></div>
            </div>
            @foreach($courses as $course)
                <div class="row">
                    <div class="col">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-7 order-1">
                                <h2 class="text-dark text-nowrap">{{ $course->language->name . ' ' . $course->level->name }}</h2>
                            </div>
                            <div class="col-6 order-3 col-md order-md-2 text-right">
                                <a class="font-weight-bold text-nowrap align-middle" data-toggle="collapse"
                                   href="#course-{{ $course->id }}-lessons" role="button" aria-expanded="false"
                                   aria-controls="course-{{ $course->id }}-lessons">
                                    {{ __('web.index.section.courses.learn_more') }}
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M5.99987 4.97656L10.1249 0.851562L11.3032 2.0299L5.99987 7.33323L0.696533 2.0299L1.87487 0.851562L5.99987 4.97656Z"
                                            fill="currentColor"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="col-6 order-2 col-md order-md-3">
                                <button role="button" class="btn btn-outline-primary btn-lg rounded-pill"
                                        onclick="demo('{{ route('demo', [$course->language, $course->level, $course->topic]) }}', {{ $course->major_version }});">
                                    {{ __('web.index.section.courses.demo') }}
                                </button>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span class="lead">{!! nl2br(e($course->description)) !!}</span>
                            </div>
                        </div>
                        <div class="row collapse" id="course-{{ $course->id }}-lessons">
                            <div class="col pt-3">
                                <div class="row">
                                    <div class="col"><h5>{{ __('web.index.section.courses.lessons') }}</h5></div>
                                </div>
                                <div class="row">
                                    @foreach($course->courseLessons->chunk(ceil($course->courseLessons->count() / 2)) as $chunk)
                                        <div class="col-12 col-md-6">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tbody>
                                                @foreach($chunk as $courseLesson)
                                                    <tr>
                                                        <td>{{ $courseLesson->index . '. ' . $courseLesson->title }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @if(! $loop->last)
                            <div class="row my-2">
                                <div class="col">
                                    <hr>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div id="player-container"></div>

@push('scripts')
    <script>
        async function demo(url, version) {
            axios.get(url, {
                params: {
                    version: version
                }
            }).then(function (response) {
                $('#player-container').html(response.data);
                $('#player-modal').modal({
                    show: true
                })
            });
        }
    </script>
@endpush
