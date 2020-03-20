@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.edit', $content) }}
@endsection

@section('content')
    <form action="{{ route('admin.content.update', $content) }}" method="post" autocomplete="off">
        @method('patch')
        @csrf

        @input(['name' => 'title', 'label' => 'Title', 'default' => $content->title])
        @textarea(['name' => 'description', 'label' => 'Description', 'default' => $content->description])
        @input(['name' => 'player_version', 'label' => 'Player Version', 'default' => $content->player_version])
        @input(['name' => 'review_exercises', 'label' => 'Review Exercises', 'default' => $content->review_exercises])

        @submit(['text' => 'Save'])
        @cancel(['route' => route('admin.content.show', $content)])
    </form>
@endsection
