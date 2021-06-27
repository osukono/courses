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
        <div class="h5">
        @foreach(preg_split('/,/', Arr::get($data->content, 'extra_chunks')) as $chunk)
                <span class="badge rounded-pill bg-secondary text-light mr-2 px-2">
            {{ trim($chunk) }}
        </span>
            @endforeach
        @endisset
        </div>
        @isset($data->content['capitalized_words'])
            <div>
                <span class="text-secondary">Capitalized words:</span> {{ Arr::get($data->content, 'capitalized_words') }}
            </div>
        @endisset

            @endcan
</div>
