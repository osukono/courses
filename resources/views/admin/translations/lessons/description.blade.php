@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.lessons.description.edit', $language, $lesson) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body mb-2">
            <h5 class="card-title mb-4">{{ $lesson->title }}</h5>
            <form action="{{ route('admin.translations.lesson.description.update', [$language, $lesson]) }}"
                  method="post" autocomplete="off">
                @method('patch')
                @csrf

                @textarea(['name' => 'description', 'label' => 'Description', 'default' => $description])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.translations.lessons.show', [$language, $lesson])])
            </form>
        </div>
    </div>
@endsection

