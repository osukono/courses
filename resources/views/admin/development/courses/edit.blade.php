@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.courses.edit', $content) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $content }}</h5>
            <form action="{{ route('admin.dev.courses.update', $content) }}" method="post" autocomplete="off">
                @method('patch')
                @csrf

                @input(['name' => 'title', 'label' => 'Title', 'default' => $content->title])
                @input(['name' => 'player_version', 'label' => 'Player Version', 'default' => $content->player_version])
                @input(['name' => 'review_exercises', 'label' => 'Review Exercises', 'default' => $content->review_exercises])
                @textarea(['name' => 'capitalized_words', 'label' => 'Capitalized Words', 'default' => $content->capitalized_words, 'helper' => 'List capitalized words separating them with commas'])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.dev.courses.show', $content)])
            </form>
        </div>
    </div>
@endsection
