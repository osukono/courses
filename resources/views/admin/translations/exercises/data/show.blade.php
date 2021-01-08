<div>
    @isset($translation->content['audio'])
        @include('admin.components.audio.play', ['audio' => $translation->content['audio']])
    @endisset
    <span>{!! \App\Library\StrUtils::normalize(Arr::get($translation->content, 'value')) !!}</span>
</div>
