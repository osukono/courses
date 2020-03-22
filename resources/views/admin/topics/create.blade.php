@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.topics.create') }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">Add a Topic</h5>
            <form action="{{ route('admin.topics.store') }}" method="post" autocomplete="off">
                @csrf

                @input(['name' => 'name', 'label' => 'Name'])
                @input(['name' => 'type', 'label' => 'Identifier'])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.topics.index')])
            </form>
        </div>
    </div>
@endsection
