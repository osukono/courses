@extends('layouts.app')

@section('content')
    <h3 class="text-center mt-4 mb-5 font-weight-normal">{{ __('English Grammar in Use – :topic', ['level' => $course->level, 'topic' => $courseLesson->title]) }}</h3>

    <h5 class="mb-4 ml-3">{{ $course->language . ' ' . $course->level . ' › ' . $courseLesson->title }}</h5>

    <div class="ml-md-5">
        @foreach($exercises as $exercise)
            <div class="mb-3">
                @foreach($exercise['fields'] as $field)
                    <div>
                        @include('admin.components.audio.play', ['audio' => $field['audio']])
                        <span lang="{{ $course->language->code }}">
                        {!! \App\Library\Str::normalize($field['value']) !!}
                        </span>
                        @if($field['identifier'] == 'translation')
                            <span lang="{{ $course->translation->code }}" class="text-muted">
                                – {!! \App\Library\Str::normalize($field['translation']['value']) !!}
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>

    @include('courses.show')

    @push('scripts')
        @include('admin.components.audio.player')
    @endpush
@endsection
