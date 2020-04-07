@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.app.locales.create') }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.app.locales.store') }}" method="post" autocomplete="off">
                @csrf

                @input(['name' => 'key', 'label' => 'Key',])
                @input(['name' => 'description', 'label' => 'Description'])
                @select(['name' => 'locale_group_id', 'label' => 'Group', 'options' => $localeGroups])
                @foreach($languages as $language)
                    @input(['name' => 'locale[' . $language->locale . ']', 'label' => $language->native])
                @endforeach

                @submit(['text' => 'Create'])
                @cancel(['route' => route('admin.app.locales.index')])
            </form>
        </div>
    </div>
@endsection
