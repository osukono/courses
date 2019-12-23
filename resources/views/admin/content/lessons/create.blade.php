@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.lessons.create', $content) }}
@endsection

@section('content')
    <form action="{{ route('admin.lessons.store', $content) }}" method="post" autocomplete="off">
        @csrf

        @input(['name' => 'title', 'label' => 'Title', 'autofocus' => true])

        @submit(['text' => 'Create'])
        @cancel(['route' => route('admin.content.show', $content)])
    </form>
@endsection
