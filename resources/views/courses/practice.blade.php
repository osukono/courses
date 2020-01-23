@extends('layouts.app')

@section('content')
    <div class="col-lg-8 offset-lg-2">
        <course-player
            title="{{ $title }}"
            review="{{ json_encode($review) }}"
            exercises="{{ json_encode($exercises) }}"
            progress-url="{{ route('courses.progress.update', [$course, $key]) }}"
            continue-url="{{ route('courses.practice', $course) }}"
            storage-url="{{ Storage::url('.') }}"
            settings-url="{{ route('user.settings.save') }}"
            @isset(Auth::getUser()->settings['volume']) initial-volume="{{ Auth::getUser()->settings['volume'] }}" @endisset
            @isset(Auth::getUser()->settings['speed']) initial-speed="{{ Auth::getUser()->settings['speed'] }}" @endisset
            @isset($stage) initial-stage="{{ $stage }}" @endisset
            encoded-locale="{{ json_encode($locale) }}"
        >
        </course-player>
    </div>
@endsection
