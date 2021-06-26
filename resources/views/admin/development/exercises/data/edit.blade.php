<form class="mb-3" action="{{ route('admin.dev.exercise.data.update', $data) }}" method="post" autocomplete="off"
      enctype="multipart/form-data">
    @method('patch')
    @csrf

    @input(['name' => 'value', 'label' => '', 'default' => Arr::get($data->content, 'value'), 'autofocus' => true, 'lg' => true])
    @input(['name' => 'extra_chunks', 'label' => '', 'default' => Arr::get($data->content, 'extra_chunks'), 'lg' => false, 'helper' => 'List of extra chunks (separated with commas) e.g. on, at, the'])

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
                  action="{{ route('admin.dev.exercise.data.audio.delete', $data) }}"
                  method="post">
                @method('patch')
                @csrf
            </form>
        @endpush
    @endisset
    <span id="audio-duration" class="ml-3 text-secondary"></span>
    @file(['name' => 'audio', 'label' => 'Audio'])
    <input type="hidden" name="duration" id="duration">
    @checkbox(['name' => 'context', 'label' => 'Context', 'default' => !$data->translatable])

    @submit(['text' => 'Save'])
    @cancel(['route' => route('admin.dev.exercises.show', $exercise)])
</form>

@push('scripts')
    @include('admin.components.audio.duration')
@endpush
