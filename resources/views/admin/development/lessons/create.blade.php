@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.lessons.create', $content) }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body mb-2">
            <h5 class="card-title mb-4">Lesson</h5>
            <form action="{{ route('admin.dev.lessons.store', $content) }}" method="post" autocomplete="off">
                @csrf

                @input(['name' => 'title', 'label' => 'Title', 'autofocus' => true])

                @submit(['text' => 'Create'])
                @cancel(['route' => route('admin.dev.courses.show', $content)])
            </form>
        </div>
    </div>
@endsection
