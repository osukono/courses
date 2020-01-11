@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.languages.edit', $language) }}
@endsection

@section('content')
    <form action="{{ route('admin.languages.update', $language) }}" method="post" autocomplete="off">
        @csrf
        @method('patch')
        @input(['name' => 'name', 'label' => 'Name', 'default' => $language->name])
        @input(['name' => 'code', 'label' => 'Code', 'default' => $language->code])

        @submit(['text' => 'Save'])
        @cancel(['route' => route('admin.languages.index')])
    </form>
@endsection
