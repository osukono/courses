@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.languages.edit', $language) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $language }}</h5>
            <form action="{{ route('admin.languages.update', $language) }}" method="post" autocomplete="off">
                @csrf
                @method('patch')
                @input(['name' => 'name', 'label' => 'Name', 'default' => $language->name])
                @input(['name' => 'native', 'label' => 'Native name', 'default' => $language->native])
                @input(['name' => 'code', 'label' => 'Regional Code', 'default' => $language->code])
                @input(['name' => 'locale', 'label' => 'Locale Code', 'default' => $language->locale])
                @textarea(['name' => 'capitalized_words', 'label' => 'Capitalized Words', 'rows' => 5, 'default' => $language->capitalized_words, 'helper' => 'List capitalized words separating them by comma'])
                @input(['name' => 'firebase_id', 'label' => 'Firebase ID', 'default' => $language->firebase_id])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.languages.index')])
            </form>
        </div>
    </div>
@endsection
