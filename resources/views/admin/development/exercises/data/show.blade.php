<div>
    @if($data->translatable == false)
        <span class="badge rounded-pill bg-light text-dark">CXT</span>
    @endif
    @isset($data->content['audio'])
        @include('admin.components.audio.play', ['audio' => $data->content['audio']])
    @endisset
    {!! \App\Library\StrUtils::normalize(Arr::get($data->content, 'value')) !!}

    @if(!empty($show_info))
        @can(\App\Library\Permissions::update_content)
            @isset($data->content['chunks'])
                <div class="small">
                    <span class="text-secondary me-3">Chunks:</span>
                    <h5 class="d-inline">
                        @foreach(\App\Library\StrUtils::splitChunks(Arr::get($data->content, 'chunks')) as $chunk)
                            <span class="badge rounded-pill bg-light text-secondary me-2 px-2">{{ $chunk }}</span>
                        @endforeach
                    </h5>
                </div>
            @endisset
            @isset($data->content['extra_chunks'])
                <div class="small">
                    <span class="text-secondary me-3">Extra chunks:</span>
                    <h5 class="d-inline">
                        @foreach(\App\Library\StrUtils::splitExtraChunks(Arr::get($data->content, 'extra_chunks')) as $chunk)
                            <span class="badge rounded-pill bg-light text-secondary me-2 px-2">{{ $chunk }}</span>
                        @endforeach
                    </h5>
                </div>
            @endisset
            @isset($data->content['capitalized_words'])
                <div class="small">
                    <span class="text-secondary me-3">Capitalized words:</span>
                    {{ Arr::get($data->content, 'capitalized_words') }}
                </div>
            @endisset
        @endcan
    @endif
</div>
