@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.app.locale.groups.edit', $localeGroup) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $localeGroup }}</h5>

            <form action="{{ route('admin.app.locale.groups.update', $localeGroup) }}" method="post" autocomplete="off">
                @csrf
                @method('patch')

                @input(['name' => 'name', 'label' => 'Name', 'default' => $localeGroup->name, 'autofocus' => true])
                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.app.locale.groups.index')])
            </form>
        </div>
    </div>
@endsection
