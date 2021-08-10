<table class="table">
    <thead>
    <tr>
        @empty($editData)
            <th class="col-12"></th>
            <th class="text-end text-nowrap d-none d-md-table-cell">Last Modified</th>
            <th class="d-none d-md-table-cell border-bottom-0"></th>
        @else
            <th></th>
        @endempty
    </tr>
    </thead>
    <tbody>
    @foreach($exerciseData as $data)
        @if(isset($editData) && $data->id == $editData->id)
            <tr>
                <td colspan="3">
                    @include('admin.development.exercises.data.show')
                    @include('admin.translations.exercises.data.edit', ['translation' => $data->translations->first()])
                </td>
            </tr>
        @else
            <tr>
                <td
                    @can(\App\Library\Permissions::update_translations)
                    class="clickable-row"
                    data-href="{{ route('admin.translations.exercises.show', [$language, $exercise, 'data' => $data->id]) }}"
                    @endcan
                >
                    @include('admin.development.exercises.data.show')
                    @includeWhen(($translation = $data->translations->first()) != null, 'admin.translations.exercises.data.show')
                </td>
                @empty($editData)
                    <td class="text-nowrap text-end d-none d-md-table-cell">{{ $data->updated_at->diffForHumans() }}</td>
                    <td class="text-nowrap d-none d-md-table-cell">
                        @if($data->translations->first() != null)
                            <a class="me-2 btn btn-sm btn-info" href="#"
                               onclick="event.preventDefault(); document.getElementById('translation-{{ $data->translations->first()->id }}-synthesize').submit();">
                                Text to Speech
                            </a>
                            <form id="translation-{{ $data->translations->first()->id }}-synthesize" class="d-none"
                                  action="{{ route('admin.translations.data.audio.synthesize', $data->translations->first()) }}"
                                  method="post">
                                @method('patch')
                                @csrf
                            </form>
                        @endif
                    </td>
                @endempty
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
