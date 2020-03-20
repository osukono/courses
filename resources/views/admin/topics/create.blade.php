@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.topics.create') }}
@endsection

@section('content')
    <form action="{{ route('admin.topics.store') }}" method="post" autocomplete="off">
        @csrf

        @input(['name' => 'name', 'label' => 'Name'])
        @input(['name' => 'type', 'label' => 'Identifier'])

        @submit(['text' => 'Save'])
        @cancel(['route' => route('admin.topics.index')])
    </form>
@endsection
