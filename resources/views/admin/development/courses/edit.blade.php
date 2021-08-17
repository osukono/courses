@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.dev.courses.edit', $content) }}
@endsection

@section('content')
    <div class="card shadow-sm">
        <div class="card-body mb-2">
            <h5 class="card-title mb-4">{{ $content }}</h5>
            <form action="{{ route('admin.dev.courses.update', $content) }}" method="post" autocomplete="off">
                @method('patch')
                @csrf

                @input(['name' => 'title', 'label' => 'Title', 'default' => $content->title])
                @input(['name' => 'player_version', 'label' => 'Player Version', 'default' => $content->player_version])
                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.dev.courses.show', $content)])
            </form>
        </div>
    </div>
@endsection
{{--@push('scripts')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            new FroalaEditor('#capitalized_words_FroalaEditor', {--}}
{{--                placeholderText: 'Capitalized Words',--}}
{{--                pastePlain: true,--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}
