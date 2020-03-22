@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.create') }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">Create a new Content</h5>
            <form action="{{ route('admin.content.store') }}" method="post" autocomplete="off">
                @csrf

                @select(['name' => 'language_id', 'label' => 'Language', 'options' => $languages])
                @select(['name' => 'level_id', 'label' => 'Level', 'options' => $levels])
                @select(['name' => 'topic_id', 'label' => 'Topic', 'options' => $topics])
                @input(['name' => 'title', 'label' => 'Title'])
                @textarea(['name' => 'description', 'label' => 'Description'])

                @submit(['text' => 'Create'])
                @cancel(['route' => route('admin.content.index')])
            </form>
        </div>
    </div>
@endsection
