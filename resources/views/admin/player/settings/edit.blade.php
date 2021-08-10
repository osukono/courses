@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.player.settings.edit', $language) }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body mb-2">
            <h5 class="card-title mb-4">{{ $language->native }}</h5>
            <form action="{{ route('admin.player.settings.update', $language) }}" method="post" autocomplete="off">
                @csrf
                @method('patch')

                @input(['name' => 'pause_after_exercise', 'label' => 'Pause after exercise', 'default' => $language->playerSettings->pause_after_exercise])
                @input(['name' => 'listening_rate', 'label' => 'Listening rate', 'default' => $language->playerSettings->listening_rate])
                @input(['name' => 'practice_rate', 'label' => 'Practice rate', 'default' => $language->playerSettings->practice_rate])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.languages.index')])
            </form>
        </div>
    </div>
@endsection
