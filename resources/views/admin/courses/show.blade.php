@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.show', $course) }}
@endsection

@section('toolbar')
    <div class="d-flex">
        <div class="btn-group" role="group">
            @isset($course->firebase_id)
                @if($course->is_updating)
                    <button class="btn btn-info" type="button" data-toggle="tooltip" data-title="Switch to published"
                            onclick="$('#course-{{ $course->id }}-updating').submit();">
                        Updating
                    </button>
                @else
                    <button class="btn btn-info" type="button" data-toggle="tooltip" data-title="Switch to updating"
                            onclick="$('#course-{{ $course->id }}-updating').submit();">
                        Published
                    </button>
                @endif
                <form id="course-{{ $course->id }}-updating"
                      action="{{ route('admin.courses.updating.switch', $course) }}" method="post" autocomplete="off">
                    @csrf
                </form>
            @endisset
            <div class="btn-group" role="group">
                <button class="btn btn-info dropdown-toggle" type="button" id="more" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    @include('admin.components.svg.more-vertical')
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more">
                    @can(\App\Library\Permissions::publish_courses)
                        <button role="button" class="dropdown-item"
                                onclick="$('#upload-course-{{ $course->id }}').submit();">
                            Upload to Firestore
                        </button>
                        <form class="d-none" id="upload-course-{{ $course->id }}"
                              action="{{ route('admin.courses.firestore.upload', $course) }}"
                              method="post" autocomplete="off">
                            @csrf
                        </form>
                        <button role="button" class="dropdown-item"
                                onclick="$('#firestore-update-course-{{ $course->id }}').submit();">
                            Update Firestore
                        </button>
                        <form class="d-none" id="firestore-update-course-{{ $course->id }}"
                              action="{{ route('admin.courses.firestore.update', $course) }}"
                              method="post" autocomplete="off">
                            @csrf
                        </form>
                    @endcan
                    @can(\App\Library\Permissions::update_courses)
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('admin.courses.edit', $course) }}" class="dropdown-item">Properties</a>
                    @endcan
                    <div class="dropdown-divider"></div>
                    <button role="button" class="dropdown-item text-danger"
                            data-toggle="confirmation"
                            data-btn-ok-label="{{ __('admin.form.delete') }}"
                            data-title="{{ __('admin.form.delete_confirmation', ['object' => $course]) }}"
                            data-form="course-{{ $course->id }}-delete">Delete Course
                    </button>
                    <form class="d-none" id="course-{{ $course->id }}-delete"
                          action="{{ route('admin.courses.delete', $course) }}"
                          method="post" autocomplete="off">
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                    @isset($course->image)
                        <img width="208" height="117" class="border rounded shadow-sm" src="{{ $course->image }}" alt="Course Image"
                             onclick="$('#course-{{ $course->id }}-image').click();" style="cursor: pointer;">
                    @else
                        <div class="text-center border rounded bg-white align-middle d-table-cell"
                             style="width: 208px; height: 117px;">
                            <button type="button" class="btn btn-info btn-sm"
                                    onclick="$('#course-{{ $course->id }}-image').click();">
                                Upload Image
                            </button>
                        </div>
                    @endisset
                    <form class="d-none" id="course-{{ $course->id }}-upload-image"
                          action="{{ route('admin.courses.image.upload', $course) }}"
                          method="post" autocomplete="off" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="course-{{ $course->id }}-image" name="image" accept="image/png"
                               onchange="$('#course-{{ $course->id }}-upload-image').submit();">
                    </form>
                </div>
                <div class="col">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text">{{ $course->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $course }}</h5>
            @include('admin.courses.lessons')
        </div>
    </div>

    @if (Session::has('job'))
        @push('progress')
            <job-status job-id="{{ Session::get('job') }}"
                        job-status-url="{{ route('admin.jobs.status', Session::get('job')) }}"
            ></job-status>
        @endpush
    @endif
@endsection
