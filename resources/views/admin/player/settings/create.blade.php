@extends('layouts.admin')

@section('breadcrumbs')
    {{ Breadcrumbs::render('admin.player.settings.create', $language) }}
@endsection

@section('content')
    <div class="card">
        <div class="card-body mb-2">
            <h5 class="card-title mb-4">{{ $language->native }}</h5>
            <form action="{{ route('admin.player.settings.store', $language) }}" method="post" autocomplete="off">
                @csrf

                @input(['name' => 'pause_after_exercise', 'label' => 'Pause after exercise'])
                @input(['name' => 'pause_between', 'label' => 'Pause between fields'])
                @input(['name' => 'pause_practice_1', 'label' => 'Pause in practice 1'])
                @input(['name' => 'pause_practice_2', 'label' => 'Pause in practice 2'])
                @input(['name' => 'pause_practice_3', 'label' => 'Pause in practice 3'])

                @submit(['text' => 'Create'])
                @cancel(['route' => route('admin.languages.index')])
            </form>
        </div>
    </div>
@endsection
