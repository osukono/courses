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
        <fieldset>
            <legend>Text to Speech</legend>
            @input(['name' => 'voice_name', 'label' => 'Voice Name', 'default' => optional($language->textToSpeechSettings)->voice_name])
            @input(['name' => 'speaking_rate', 'label' => 'Speaking Rate', 'default' => optional($language->textToSpeechSettings)->speaking_rate])
            @input(['name' => 'pitch', 'label' => 'Pitch', 'default' => optional($language->textToSpeechSettings)->pitch])
        </fieldset>

        @submit(['text' => 'Save'])
        @cancel(['route' => route('admin.languages.index')])
    </form>
@endsection
