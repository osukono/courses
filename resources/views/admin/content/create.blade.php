@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.create') }}
@endsection

@section('content')
    <form action="{{ route('admin.content.store') }}" method="post" autocomplete="off">
        @csrf

        @select(['name' => 'language_id', 'label' => 'Language', 'options' => $languages])
        @select(['name' => 'level_id', 'label' => 'Level', 'options' => $levels])

        @submit(['text' => 'Create'])
        @cancel(['route' => route('admin.content.index')])
    </form>
@endsection
