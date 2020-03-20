<div>
    @unless($data->translatable)
        <span class="badge badge-pill badge-light">CXT</span>
    @endunless
    @isset($data->content['audio'])
        @include('admin.components.audio.play', ['audio' => $data->content['audio']])
    @endif
    {!! \App\Library\Str::normalize(Arr::get($data->content, 'value')) !!}
</div>
