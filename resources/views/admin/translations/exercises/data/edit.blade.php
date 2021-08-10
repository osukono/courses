<form class="mb-3" action="{{ route('admin.translations.exercise.data.update', $translation) }}" method="post"
      autocomplete="off"
      enctype="multipart/form-data">
    @method('patch')
    @csrf

    @input(['name' => 'value', 'label' => 'Translation', 'default' => Arr::get($translation->content, 'value'), 'autofocus' => true, 'lg' => true, 'lang' => $translation->language->code])

    @isset($translation->content['audio'])
        <span class="me-3">
            @include('admin.components.audio.play', ['audio' => $translation->content['audio']])
            @include('admin.components.audio.download', ['audio' => $translation->content['audio']])
        </span>

        <span>
            <a href="#audio-{{ $translation->id }}-modal-delete" data-bs-toggle="modal">
                <icon-delete></icon-delete>
            </a>
        </span>
        @include('admin.components.modals.confirmation', ['id' => 'audio-' . $translation->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => 'Audio']), 'form' =>  'delete-audio-' . $translation->id, 'action' => 'Delete'])
        @push('forms')
            <form class="d-none" id="delete-audio-{{ $translation->id }}"
                  action="{{ route('admin.translations.audio.delete', $translation) }}"
                  method="post">
                @method('patch')
                @csrf
            </form>
        @endpush
    @endisset
    <span id="audio-duration" class="ms-3 text-secondary"></span>
    @file(['name' => 'audio', 'label' => 'Audio'])
    <input type="hidden" name="duration" id="duration">

    @submit(['text' => 'Save'])
    @cancel(['route' => route('admin.translations.exercises.show', [$language, $exercise])])
</form>

@push('scripts')
    @include('admin.components.audio.duration')
@endpush
