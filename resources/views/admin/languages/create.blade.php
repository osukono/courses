@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.languages.create') }}
@endsection

@section('content')
    <form action="{{ route('admin.languages.store') }}" method="post" autocomplete="off">
        @csrf
        @input(['name' => 'name', 'label' => 'Name'])
        @input(['name' => 'code', 'label' => 'Code'])
        <fieldset>
            <legend>Text to Speech</legend>
            @input(['name' => 'voice_name', 'label' => 'Voice Name'])
            @input(['name' => 'speaking_rate', 'label' => 'Speaking Rate'])
            @input(['name' => 'pitch', 'label' => 'Pitch'])
        </fieldset>

        @submit(['text' => 'Save'])
        @cancel(['route' => route('admin.languages.index')])
    </form>
@endsection
