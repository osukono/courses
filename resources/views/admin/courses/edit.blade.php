@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.edit', $course) }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $course }}</h5>
            <form action="{{ route('admin.courses.update', $course) }}" method="post" autocomplete="off">
                @method('patch')
                @csrf

                @input(['name' => 'title', 'label' => 'Title', 'default' => $course->title])
                @textarea(['name' => 'description', 'label' => 'Description', 'default' => $course->description])
                @input(['name' => 'review_exercises', 'label' => 'Review Exercises', 'default' => $course->review_exercises])
                @input(['name' => 'version', 'label' => 'Version', 'default' => $course->minor_version])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.courses.show', $course)])
            </form>
        </div>
    </div>
@endsection
