<table class="table">
    <thead>
    <tr>
        <th class="col-{{ (Auth::getUser()->can(\App\Library\Permissions::update_content)) ? '10' : '11' }}"></th>
        <th class="text-right text-nowrap">Last Modified</th>
        @can(\App\Library\Permissions::update_content)
            <th></th>
        @endcan
    </tr>
    </thead>
    <tbody id="sortable">
    @foreach($exerciseData as $data)
        @if(isset($editData) && $data->id == $editData->id)
            <tr>
                <td colspan="3">
                    @include('admin.content.exercises.data.edit')
                </td>
            </tr>
        @else
            <tr data-id="{{ $data->id }}">
                <td class="clickable-row"
                    data-href="{{ route('admin.exercises.show', [$exercise, 'data' => $data->id]) }}">
                    @include('admin.content.exercises.data.show')
                </td>
                <td class="text-nowrap text-right">{{ $data->updated_at->diffForHumans() }}</td>
                @can(\App\Library\Permissions::update_content)
                    <td class="text-right">
                        <div class="text-nowrap">
                            <a class="mr-2" href="#" onclick="event.preventDefault(); document.getElementById('data-{{ $data->id }}-synthesize').submit();">Synthesize Audio</a>
                            <form id="data-{{ $data->id }}-synthesize" class="d-none"
                                  action="{{ route('admin.exercise.data.audio.synthesize', $data) }}" method="post">
                                @method('patch')
                                @csrf
                            </form>
                            <a href="#"
                               data-toggle="confirmation"
                               data-btn-ok-label="{{ __('admin.form.delete') }}"
                               data-title="{{ __('admin.form.delete_confirmation', ['object' => $data]) }}"
                               data-form="data-{{ $data->id }}-delete">
                                @include('admin.components.svg.delete')
                            </a>
                            <form id="data-{{ $data->id }}-delete" class="d-none"
                                  action="{{ route('admin.exercise.data.destroy', $data) }}" method="post">
                                @method('delete')
                                @csrf
                            </form>
                        </div>
                    </td>
                @endcan
            </tr>
        @endif
    @endforeach
    </tbody>
</table>

@includeWhen(\App\Library\Permissions::update_content, 'admin.components.sortable', ['route' => route('admin.exercise.data.move')])
