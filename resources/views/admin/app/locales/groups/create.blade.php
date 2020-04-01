@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.app.locale.groups.create') }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">Add a Group</h5>

            <form action="{{ route('admin.app.locale.groups.store') }}" method="post" autocomplete="off">
                @csrf

                @input(['name' => 'name', 'label' => 'Name', 'autofocus' => true])
                @submit(['text' => 'Create'])
                @cancel(['route' => route('admin.app.locale.groups.index')])
            </form>
        </div>
    </div>
@endsection
