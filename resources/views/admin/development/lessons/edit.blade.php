@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.lessons.edit', $lesson) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $lesson->title }}</h5>
            <form action="{{ route('admin.dev.lessons.update', $lesson) }}" method="post" autocomplete="off">
                @method('patch')
                @csrf

                @input(['name' => 'title', 'label' => 'Title', 'default' => $lesson->title])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.dev.lessons.show', $lesson)])
            </form>
        </div>
    </div>
@endsection
