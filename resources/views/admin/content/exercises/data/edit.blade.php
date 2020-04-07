<form class="mb-3" action="{{ route('admin.exercise.data.update', $data) }}" method="post" autocomplete="off"
      enctype="multipart/form-data">
    @method('patch')
    @csrf

    @input(['name' => 'value', 'label' => '', 'default' => Arr::get($data->content, 'value'), 'autofocus' => true, 'lg' => true])

    @isset($data->content['audio'])
        <span class="mr-3">
            @include('admin.components.audio.play', ['audio' => $data->content['audio']])
            @include('admin.components.audio.download', ['audio' => $data->content['audio']])
        </span>

        <span>
            <a href="#"
               data-toggle="confirmation"
               data-btn-ok-label="{{ __('admin.form.delete') }}"
               data-title="{{ __('admin.form.delete_confirmation', ['object' => 'Audio']) }}"
               data-form="delete-audio-{{ $data->id }}">
                <icon-delete></icon-delete>
            </a>
        </span>
        @push('forms')
            <form class="d-none" id="delete-audio-{{ $data->id }}"
                  action="{{ route('admin.exercise.data.audio.delete', $data) }}"
                  method="post">
                @method('patch')
                @csrf
            </form>
        @endpush
    @endisset
    @file(['name' => 'audio', 'label' => 'Audio'])
    @checkbox(['name' => 'translatable', 'label' => 'Translatable', 'default' => $data->translatable])

    @submit(['text' => 'Save'])
    @cancel(['route' => route('admin.exercises.show', $exercise)])
</form>
