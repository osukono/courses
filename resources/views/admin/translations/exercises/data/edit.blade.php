<form class="mb-3" action="{{ route('admin.translations.exercise.data.update', $translation) }}" method="post"
      autocomplete="off"
      enctype="multipart/form-data">
    @method('patch')
    @csrf

    @input(['name' => 'value', 'label' => '', 'default' => Arr::get($translation->content, 'value'), 'autofocus' => true, 'lg' => true, 'lang' => $translation->language->code])

    @isset($translation->content['audio'])
        <span class="mr-3">
            @include('admin.components.audio.play', ['audio' => $translation->content['audio']])
            @include('admin.components.audio.download', ['audio' => $translation->content['audio']])
        </span>

        <span>
            <a href="#"
               data-toggle="confirmation"
               data-btn-ok-label="{{ __('admin.form.delete') }}"
               data-title="{{ __('admin.form.delete_confirmation', ['object' => 'Audio']) }}"
               data-form="delete-audio-{{ $translation->id }}">
                <icon-delete></icon-delete>
            </a>
        </span>
        @push('forms')
            <form class="d-none" id="delete-audio-{{ $translation->id }}"
                  action="{{ route('admin.translations.audio.delete', $translation) }}"
                  method="post">
                @method('patch')
                @csrf
            </form>
        @endpush
    @endisset
    <span id="audio-duration" class="ml-3 text-secondary"></span>
    @file(['name' => 'audio', 'label' => 'Audio'])
    <input type="hidden" name="duration" id="duration">

    @submit(['text' => 'Save'])
    @cancel(['route' => route('admin.translations.exercises.show', [$language, $exercise])])
</form>

@push('scripts')
    @include('admin.components.audio.duration')
@endpush
