<div>
    @if($exerciseField->field->audible && isset($exerciseField->content['audio']))
        @if(isset($exerciseField->content['duration']))
            {{ $exerciseField->content['duration'] }}
        @endif
        @include('admin.components.audio.play', ['audio' => $exerciseField->content['audio']])
    @endif
    @if($exerciseField->field->dataType->type == \App\DataType::text)
        {!! Arr::get($exerciseField->content, 'value') !!}
    @elseif($exerciseField->field->dataType->type == \App\DataType::string)
        @if($exerciseField->field->translatable)
            {!! \App\Library\Str::normalize(Arr::get($exerciseField->content, 'value')) !!}
        @else
            <span
                class="text-muted">{!! \App\Library\Str::normalize(Arr::get($exerciseField->content, 'value')) !!}</span>
        @endif
    @endif
</div>
