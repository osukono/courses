<div>
    @includeWhen(isset($translation->content['audio']), 'admin.components.audio.play', ['audio' => $translation->content['audio']])
    <span>{!! \App\Library\Str::normalize(Arr::get($translation->content, 'value')) !!}</span>
</div>
