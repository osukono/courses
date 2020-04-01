@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.app.locales.edit', $appLocale) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">
                @if($appLocale->group != null)
                    {{ $appLocale->group->name }} /
                @endif
                {{ $appLocale->key }}
            </h5>

            <form action="{{ route('admin.app.locales.update', $appLocale) }}" method="post" autocomplete="off">
                @csrf
                @method('patch')

                @input(['name' => 'key', 'label' => 'Key', 'default' => $appLocale->key])
                @input(['name' => 'description', 'label' => 'Description', 'default' => $appLocale->description])
                @select(['name' => 'locale_group_id', 'label' => 'Group', 'options' => $localeGroups, 'default' => $appLocale->locale_group_id])
                @foreach($languages as $language)
                    @input(['name' => 'locale[' . $language->locale . ']', 'label' => $language->native, 'default' => Arr::get($appLocale->values, $language->locale)])
                @endforeach

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.app.locales.index')])
            </form>
        </div>
    </div>
@endsection
