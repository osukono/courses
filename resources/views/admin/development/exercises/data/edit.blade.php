<form class="mb-3" action="{{ route('admin.dev.exercise.data.update', $data) }}" method="post" autocomplete="off"
      enctype="multipart/form-data">
    @method('patch')
    @csrf

    @input(['name' => 'value', 'label' => 'Text', 'default' => Arr::get($data->content, 'value'), 'autofocus' => true, 'lg' => true])
    @input(['name' => 'chunks', 'label' => 'Chunks', 'default' => Arr::get($data->content, 'chunks'), 'lg' => false, 'helper' => 'Chunks (separated with vertical bar) e.g. I | am | American.', 'lg' => true])
    @input(['name' => 'extra_chunks', 'label' => 'Extra Chunks', 'default' => Arr::get($data->content, 'extra_chunks'), 'lg' => false, 'helper' => 'Extra chunks (separated with comma) e.g. on, at, the'])
    @input(['name' => 'capitalized_words', 'label' => 'Capitalized Words', 'default' => Arr::get($data->content, 'capitalized_words'), 'lg' => false, 'helper' => 'List of capitalized words (separated with comma)'])

    @isset($data->content['audio'])
        <span class="me-3">
            @include('admin.components.audio.play', ['audio' => $data->content['audio']])
            @include('admin.components.audio.download', ['audio' => $data->content['audio']])
        </span>

        <span>
            <a href="#audio-{{ $data->id }}-modal-delete" data-bs-toggle="modal">
                <icon-delete></icon-delete>
            </a>
        </span>
        @include('admin.components.modals.confirmation', ['id' => 'audio-' . $data->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => 'Audio']), 'form' =>  'delete-audio-' . $data->id, 'action' => 'Delete'])
        @push('forms')
            <form class="d-none" id="delete-audio-{{ $data->id }}"
                  action="{{ route('admin.dev.exercise.data.audio.delete', $data) }}"
                  method="post">
                @method('patch')
                @csrf
            </form>
        @endpush
    @endisset
    <span id="audio-duration" class="ms-3 text-secondary"></span>
    @file(['name' => 'audio', 'label' => 'Audio'])
    <input type="hidden" name="duration" id="duration">
    @checkbox(['name' => 'context', 'label' => 'Context (without translation)', 'default' => !$data->translatable])

    @submit(['text' => 'Save'])
    @cancel(['route' => route('admin.dev.exercises.show', $exercise)])
</form>

@push('scripts')
    @include('admin.components.audio.duration')
@endpush
