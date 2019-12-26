@extends('layouts.app')

@section('content')
{{--    <h3 class="text-center mt-4 mb-5">{{ $course->language . ' ' . $course->level }}</h3>--}}
    <h5 class="mb-4 ml-3">{{ $course->language . ' ' . $course->level . ' › ' . $title }}</h5>

    <div class="ml-md-5">
        @foreach($exercises as $exercise)
            <div class="mb-2">
                @foreach($exercise['fields'] as $field)
                    <div>
                        @include('admin.components.audio.play', ['audio' => $field['audio']])
                        <span>
                        {!! \App\Library\Str::normalize($field['value']) !!}
                        </span>
                        @if($field['identifier'] == 'translation')
                            <span class="text-muted">
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
