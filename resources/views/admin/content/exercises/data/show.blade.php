<div>
    @if($data->translatable == false)
        <span class="badge badge-pill badge-light">CXT</span>
    @endif
    @includeWhen(isset($data->content['audio']), 'admin.components.audio.play', ['audio' => $data->content['audio']])
    {!! \App\Library\Str::normalize(Arr::get($data->content, 'value')) !!}
</div>
