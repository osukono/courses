@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.users.create') }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">Create a User</h5>

            <form action="{{ route('admin.users.store') }}" method="post" autocomplete="off">
                @csrf
                @input(['name' => 'name', 'label' => 'Name', 'autofocus' => true])
                @input(['name' => 'email', 'label' => 'Email'])

                @submit(['text' => 'Create'])
                @cancel(['route' => route('admin.users.index')])
            </form>
        </div>
    </div>
@endsection
