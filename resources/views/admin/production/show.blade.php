@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.show', $course) }}
@endsection

@section('toolbar')
    <v-button-group>
        @isset($course->firebase_id)
            <v-button tooltip="{{ $course->is_updating ? 'Switch to published' : 'Switch to updating' }}"
                      submit="#course-{{ $course->id }}-updating"
                      enabled="{{ Auth::getUser()->can(\App\Library\Permissions::publish_courses) }}">
                {{ $course->is_updating ? 'Updating' : 'Published' }}
                @push('forms')
                    <form id="course-{{ $course->id }}-updating"
                          action="{{ route('admin.courses.updating.switch', $course) }}" method="post"
                          autocomplete="off">
                        @csrf
                    </form>
                @endpush
            </v-button>
        @endisset

        <v-dropdown>
            <template v-slot:icon>
                <icon-more-vertical></icon-more-vertical>
            </template>
            <v-dropdown-group>
                <v-dropdown-item label="Upload to Firestore"
                                 submit="#course-{{ $course->id }}-upload"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::publish_courses) }}">
                    @push('forms')
                        <form class="d-none" id="course-{{ $course->id }}-upload"
                              action="{{ route('admin.courses.firestore.upload', $course) }}"
                              method="post" autocomplete="off">
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-item>
                <v-dropdown-item label="Update Firestore"
                                 submit="#course-{{ $course->id }}-firestore-update"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::publish_courses) }}">
                    @push('forms')
                        <form class="d-none" id="course-{{ $course->id }}-firestore-update"
                              action="{{ route('admin.courses.firestore.update', $course) }}"
                              method="post" autocomplete="off">
                            @csrf
                        </form>
                    @endpush
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-item label="Properties"
                                 route="{{ route('admin.courses.edit', $course) }}"
                                 enabled="{{ Auth::getUser()->can(\App\Library\Permissions::update_courses) }}">
                </v-dropdown-item>
            </v-dropdown-group>

            <v-dropdown-group>
                <v-dropdown-modal label="Delete Course"
                                  modal="course-{{ $course->id }}-modal-delete">
                    @push('forms')
                        <form class="d-none" id="course-{{ $course->id }}-delete"
                              action="{{ route('admin.courses.delete', $course) }}"
                              method="post" autocomplete="off">
                            @csrf
                            @method('delete')
                        </form>
                    @endpush
                </v-dropdown-modal>
            </v-dropdown-group>
        </v-dropdown>
    </v-button-group>
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-auto">
                    @isset($course->image)
                        <img width="208" height="117" class="rounded" src="{{ $course->image }}"
                             alt="Course Image"
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
                        <input type="file" id="course-{{ $course->id }}-image" name="image" accept="image/svg+xml"
                               onchange="$('#course-{{ $course->id }}-upload-image').submit();">
                    </form>
                </div>
                <div class="col">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text">{!! nl2br(e($course->description)) !!}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $course }}</h5>
            @include('admin.production.lessons')
        </div>
    </div>

    @include('admin.components.modals.confirmation', ['id' => 'course-' . $course->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $course]), 'form' =>  'course-' . $course->id . '-delete', 'action' => 'Delete'])
@endsection
