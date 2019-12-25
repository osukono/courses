@extends('layouts.app')

@section('content')
    <h4 class="text-center">{{ $course->language . ' ' . $course->level }}</h4>
    <h5 class="mb-4 ml-3">{{ $title }}</h5>

    <div class="ml-md-5">
        @foreach($exercises as $exercise)
            <div class="mb-2">
                @foreach($exercise['fields'] as $field)
                    <div>
                        @include('admin.components.audio.play', ['audio' => $field['audio']])
                        {!! \App\Library\Str::normalize($field['value']) !!}
                    </div>
                    {{--@if($field['identifier'] == 'translation')
                        <div>
                            @include('admin.components.audio.play', ['audio' => $field['translation']['audio']])
                            {!! \App\Library\Str::normalize($field['translation']['value']) !!}
                        </div>
                    @endif--}}
                @endforeach
            </div>
        @endforeach
    </div>

    @include('courses.show')

    @push('scripts')
        @include('admin.components.audio.player')
    @endpush
@endsection
