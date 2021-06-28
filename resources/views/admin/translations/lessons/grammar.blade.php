@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.translations.lessons.grammar.edit', $language, $lesson) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">{{ $lesson->title }}</h5>
            <form action="{{ route('admin.translations.lesson.grammar.update', [$language, $lesson]) }}" method="post" autocomplete="off">
                @method('patch')
                @csrf

                @froala(['name' => 'grammar_point', 'label' => '', 'default' => $grammar_point])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.translations.lessons.show', [$language, $lesson])])
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            new FroalaEditor('#grammar_point_FroalaEditor', {
                placeholderText: 'Grammar Point',
                listAdvancedTypes: true,
                pastePlain: true,
            });
        });
    </script>
@endpush
