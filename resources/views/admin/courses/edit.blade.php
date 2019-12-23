@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.courses.edit', $course) }}
@endsection

@section('content')
    <form action="{{ route('admin.courses.update', $course) }}" method="post" autocomplete="off">
        @method('patch')
        @csrf

        @textarea(['name' => 'description', 'label' => 'Description', 'default' => $course->description])
        @input(['name' => 'demo_lessons', 'label' => 'Number of Demo Lessons', 'default' => $course->demo_lessons])
        @input(['name' => 'price', 'label' => 'Price', 'default' => $course->price])
        @include('html.form.switch', ['name' => 'published', 'label' => 'Published', 'default' => $course->published])

        @submit(['text' => 'Save'])
        @cancel(['route' => route('admin.courses.show', $course)])
    </form>
@endsection
