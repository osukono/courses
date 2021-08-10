<div>
    @if($data->translatable == false)
        <span class="badge badge-pill badge-light">CXT</span>
    @endif
    @isset($data->content['audio'])
        @include('admin.components.audio.play', ['audio' => $data->content['audio']])
    @endisset
    {!! \App\Library\StrUtils::normalize(Arr::get($data->content, 'value')) !!}

    @can(\App\Library\Permissions::update_content)

        @if(Arr::has($data->content, 'chunks'))
            <div>
                <span class="text-secondary me-3">Chunks:</span>
                <h5 class="d-inline">
                    @foreach(\App\Library\StrUtils::splitChunks(Arr::get($data->content, 'chunks')) as $chunk)
                        <span class="badge rounded-pill bg-light text-secondary me-2 px-2">{{ $chunk }}</span>
                    @endforeach
                </h5>
            </div>
        @endif

        {{--    <splitter value="{{ Arr::get($data->content, 'value') }}"></splitter>--}}

        @isset($data->content['extra_chunks'])
            <div>
                <span class="text-secondary me-3">Extra chunks:</span>
                <div class="h5 d-inline">
                    @foreach(\App\Library\StrUtils::splitExtraChunks(Arr::get($data->content, 'extra_chunks')) as $chunk)
                        <span class="badge rounded-pill bg-light text-secondary me-2 px-2">{{ $chunk }}</span>
                    @endforeach
                </div>
            </div>
        @endisset
        @isset($data->content['capitalized_words'])
            <div>
                    <span
                        class="text-secondary me-3">Capitalized words:</span>{{ Arr::get($data->content, 'capitalized_words') }}
            </div>
        @endisset

    @endcan
</div>
