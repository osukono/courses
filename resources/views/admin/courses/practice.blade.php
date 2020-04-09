@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.practice', $course, $courseLesson) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($previous)
            <v-button route="{{ route('admin.courses.practice', [$course, $previous]) }}">
                <template v-slot:icon>
                    <icon-chevron-left></icon-chevron-left>
                </template>
            </v-button>
        @endisset
        @isset($next)
            <v-button route="{{ route('admin.courses.practice', [$course, $next]) }}">
                <template v-slot:icon>
                    <icon-chevron-right></icon-chevron-right>
                </template>
            </v-button>
        @endisset
    </v-button-group>
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
