@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.content.create') }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ __('admin.development.courses.create.title') }}</h5>
            <form action="{{ route('admin.content.store') }}" method="post" autocomplete="off">
                @csrf

                @select(['name' => 'language_id', 'label' => __('admin.development.courses.create.fields.language'), 'options' => $languages])
                @select(['name' => 'level_id', 'label' => __('admin.development.courses.create.fields.level'), 'options' => $levels])
                @select(['name' => 'topic_id', 'label' => __('admin.development.courses.create.fields.topic'), 'options' => $topics])
                @input(['name' => 'title', 'label' => __('admin.development.courses.create.fields.title')])

                @submit(['text' => __('admin.form.create')])
                @cancel(['route' => route('admin.content.index')])
            </form>
        </div>
    </div>
@endsection
