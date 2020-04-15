<div>
    @isset($translation->content['audio'])
        @include('admin.components.audio.play', ['audio' => $translation->content['audio']])
    @endisset
    <span>{!! \App\Library\Str::normalize(Arr::get($translation->content, 'value')) !!}</span>
</div>
