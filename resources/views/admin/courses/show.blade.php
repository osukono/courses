@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.show', $course) }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group" role="group">
            <div class="btn-group" role="group">
                <button class="btn btn-info dropdown-toggle" type="button" id="more" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    @include('admin.components.svg.more-vertical')
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more">
                    @can(\App\Library\Permissions::update_courses)
                        <a href="{{ route('admin.courses.edit', $course) }}" class="dropdown-item">Properties</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @includeWhen(isset($course->description), 'admin.components.description', ['description' => $course->description])

    @include('admin.courses.lessons')
@endsection
