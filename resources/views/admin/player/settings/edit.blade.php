@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.player.settings.edit', $language) }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title mb-4">{{ $language->native }}</div>
            <form action="{{ route('admin.player.settings.update', $language) }}" method="post" autocomplete="off">
                @csrf
                @method('patch')

                @input(['name' => 'pause_after_exercise', 'label' => 'Pause after exercise', 'default' => $language->playerSettings->pause_after_exercise])
                @input(['name' => 'pause_between', 'label' => 'Pause between fields', 'default' => $language->playerSettings->pause_between])
                @input(['name' => 'pause_practice_1', 'label' => 'Pause in practice 1', 'default' => $language->playerSettings->pause_practice_1])
                @input(['name' => 'pause_practice_2', 'label' => 'Pause in practice 2', 'default' => $language->playerSettings->pause_practice_2])
                @input(['name' => 'pause_practice_3', 'label' => 'Pause in practice 3', 'default' => $language->playerSettings->pause_practice_3])

                @submit(['text' => 'Save'])
                @cancel(['route' => route('admin.languages.index')])
            </form>
        </div>
    </div>
@endsection
