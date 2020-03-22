@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.lessons.edit', $lesson) }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $lesson->title }}</h5>
            <form action="{{ route('admin.lessons.update', $lesson) }}" method="post" autocomplete="off">
                @method('patch')
                @csrf

                @input(['name' => 'title', 'label' => 'Title', 'default' => $lesson->title])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.lessons.show', $lesson)])
            </form>
        </div>
    </div>
@endsection
