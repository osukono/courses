@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.edit', $content) }}
@endsection

@section('content')
    <form action="{{ route('admin.content.update', $content) }}" method="post" autocomplete="off">
        @method('patch')
        @csrf

        @textarea(['name' => 'description', 'label' => 'Description', 'default' => $content->description])

        @submit(['text' => 'Save'])
        @cancel(['route' => route('admin.content.show', $content)])
    </form>
@endsection
