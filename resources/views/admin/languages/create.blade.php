@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.languages.create') }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body mb-2">
            <h5 class="card-title mb-4">Language</h5>
            <form action="{{ route('admin.languages.store') }}" method="post" autocomplete="off">
                @csrf
                @input(['name' => 'name', 'label' => 'Name', 'autofocus' => true])
                @input(['name' => 'native', 'label' => 'Native name'])
                @input(['name' => 'code', 'label' => 'Regional Code'])
                @input(['name' => 'locale', 'label' => 'Locale Code'])
                @textarea(['name' => 'capitalized_words', 'label' => 'Capitalized Words', 'rows' => 5, 'helper' => 'List of capitalized words separated with comma'])

                @submit(['text' => 'Create'])
                @cancel(['route' => route('admin.languages.index')])
            </form>
        </div>
    </div>
@endsection
