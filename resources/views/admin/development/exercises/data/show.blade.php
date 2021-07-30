<div>
    @if($data->translatable == false)
        <span class="badge badge-pill badge-light">CXT</span>
    @endif
    @isset($data->content['audio'])
        @include('admin.components.audio.play', ['audio' => $data->content['audio']])
    @endisset
    {!! \App\Library\StrUtils::normalize(Arr::get($data->content, 'value')) !!}

        @can(\App\Library\Permissions::update_content)

    <splitter value="{{ Arr::get($data->content, 'value') }}"></splitter>

    @isset($data->content['extra_chunks'])
                <span class="text-secondary mr-3">Extra chunks:</span>
        <div class="h5 d-inline">
        @foreach(preg_split('/,/', Arr::get($data->content, 'extra_chunks')) as $chunk)
                <span class="badge rounded-pill bg-light text-secondary mr-2 px-2">
            {{ trim($chunk) }}
        </span>
            @endforeach
        @endisset
        </div>
        @isset($data->content['capitalized_words'])
            <div>
                <span class="text-secondary mr-3">Capitalized words:</span>{{ Arr::get($data->content, 'capitalized_words') }}
            </div>
        @endisset

            @endcan
</div>
