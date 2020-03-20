@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.practice', $course, $courseLesson) }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group">
            @isset($previous)
                @include('admin.components.menu.previous', ['route' => route('admin.courses.practice', [$course, $previous])])
            @endisset

            @isset($next)
                @include('admin.components.menu.next', ['route' => route('admin.courses.practice', [$course, $next])])
            @endisset
        </div>
    </div>
@endsection

@section('content')
    <div class="col-lg-8 offset-lg-2 my-5">
        <course-player
            title="{{ $title }}"
            exercises="{{ json_encode($exercises) }}"
            storage-url="{{ Storage::url('.') }}"
            settings-url="{{ route('user.settings.save') }}"
            @isset(Auth::getUser()->settings['volume']) initial-volume="{{ Auth::getUser()->settings['volume'] }}"
            @endisset
            @isset(Auth::getUser()->settings['speed']) initial-speed="{{ Auth::getUser()->settings['speed'] }}"
            @endisset
            encoded-locale="{{ json_encode($locale) }}"
        >
        </course-player>
    </div>
@endsection
