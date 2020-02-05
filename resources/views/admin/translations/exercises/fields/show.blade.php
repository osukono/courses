<div>
    @if($exerciseField->field->audible && isset($translation->content['audio']))
        @if(isset($translation->content['duration']))
            {{ $translation->content['duration'] }}
        @endif
        @include('admin.components.audio.play', ['audio' => $translation->content['audio']])
    @endif
    @if($exerciseField->field->dataType->type == \App\DataType::text)
        {!! Arr::get($translation->content, 'value') !!}
    @elseif($exerciseField->field->dataType->type == \App\DataType::string)
        <span>{!! \App\Library\Str::normalize(Arr::get($translation->content, 'value')) !!}</span>
    @endif
</div>
