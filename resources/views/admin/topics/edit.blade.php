@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.topics.edit', $topic) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $topic }}</h5>
            <form action="{{ route('admin.topics.update', $topic) }}" method="post" autocomplete="off">
                @csrf
                @method('patch')

                @input(['name' => 'name', 'label' => 'Name', 'default' => $topic->name])
                @input(['name' => 'identifier', 'label' => 'Identifier', 'default' => $topic->identifier])
                @input(['name' => 'firebase_id', 'label' => 'Firebase ID', 'default' => $topic->firebase_id])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.topics.index')])
            </form>
        </div>
    </div>
@endsection
