@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.lessons.grammar', $lesson) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body mb-2">
            <h5 class="card-title mb-4">{{ $lesson->title }}</h5>
            <form action="{{ route('admin.dev.lessons.grammar.update', $lesson) }}" method="post" autocomplete="off">
                @method('patch')
                @csrf

                @froala(['name' => 'grammar_point', 'label' => '', 'default' => $grammar_point])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.dev.lessons.show', $lesson)])
            </form>
        </div>
    </div>
@endsection
