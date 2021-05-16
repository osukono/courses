<table class="table">
    <thead>
    <tr>
        @empty($editData)
            <th class="col"></th>
            <th class="text-right text-nowrap d-none d-md-table-cell col-auto">Last Modified</th>
            <th class="d-none d-md-table-cell col-auto"></th>
        @else
            <th class="col"></th>
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
                    data-href="{{ route('admin.translations.exercise.show', [$language, $exercise, 'data' => $data->id]) }}"
                    @endcan
                >
                    @include('admin.development.exercises.data.show')
                    @includeWhen(($translation = $data->translations->first()) != null, 'admin.translations.exercises.data.show')
                </td>
                @empty($editData)
                    <td class="text-nowrap text-right d-none d-md-table-cell">{{ $data->updated_at->diffForHumans() }}</td>
                    <td class="text-nowrap d-none d-md-table-cell">
                        @if($data->translations->first() != null)
                            <a class="mr-2 btn btn-sm btn-info" href="#"
                               onclick="event.preventDefault(); document.getElementById('translation-{{ $data->translations->first()->id }}-synthesize').submit();">
                                Text to Speech
                            </a>
                            <form id="translation-{{ $data->translations->first()->id }}-synthesize" class="d-none"
                                  action="{{ route('admin.translations.audio.synthesize', $data->translations->first()) }}"
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
