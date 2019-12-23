<form class="mb-3" action="{{ route('admin.exercise.fields.update', $exerciseField) }}" method="post" autocomplete="off"
      enctype="multipart/form-data">
    @method('patch')
    @csrf

    @if($exerciseField->field->dataType->type == \App\DataType::text)
        @froala(['name' => 'value', 'label' => '', 'default' => Arr::get($exerciseField->content, 'value')])
    @elseif($exerciseField->field->dataType->type == \App\DataType::string)
        @input(['name' => 'value', 'label' => '', 'default' => Arr::get($exerciseField->content, 'value'), 'autofocus' => true])
    @endif

    @if($exerciseField->field->audible)
        @if(isset($exerciseField->content['audio']))
            <span class="mr-3">
                @include('admin.components.audio.play', ['audio' => $exerciseField->content['audio']])
                @include('admin.components.audio.download', ['audio' => $exerciseField->content['audio']])
            </span>

            <span>
                <a href="#"
                   data-toggle="confirmation"
                   data-btn-ok-label="{{ __('admin.form.delete') }}"
                   data-title="{{ __('admin.form.delete_confirmation', ['object' => 'Audio']) }}"
                   data-form="delete-audio-{{ $exerciseField->id }}">
                    @include('admin.components.svg.delete')
                </a>
            </span>
            @push('forms')
                <form class="d-none" id="delete-audio-{{ $exerciseField->id }}"
                      action="{{ route('admin.exercise.fields.audio.delete', $exerciseField) }}"
                      method="post">
                    @method('patch')
                    @csrf
                </form>
            @endpush
        @endif
        @file(['name' => 'audio', 'label' => 'Audio'])
    @endif

    @submit(['text' => 'Save'])
    @cancel(['route' => route('admin.exercises.show', $exercise)])
</form>
