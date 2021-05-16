<table class="table">
    <thead>
    <tr>
        @empty($editData)
            <th class="col"></th>
            <th class="text-right text-nowrap col-auto">Last Modified</th>
            @can(\App\Library\Permissions::update_content)
                <th></th>
            @endcan
        @else
            <th class="col"></th>
        @endempty
    </tr>
    </thead>
    <tbody id="{{ can(\App\Library\Permissions::update_content, 'sortable') }}"
           data-route="{{ route('admin.exercise.data.move') }}">
    @foreach($exerciseData as $data)
        @if(isset($editData) && $data->id == $editData->id)
            <tr>
                <td colspan="3">
                    @include('admin.development.exercises.data.edit')
                </td>
            </tr>
        @else
            <tr data-sortable="{{ $data->id }}">
                <td
                    @can(\App\Library\Permissions::update_content)
                    class="clickable-row"
                    data-href="{{ route('admin.exercises.show', [$exercise, 'data' => $data->id]) }}"
                    @endcan
                >
                    @include('admin.development.exercises.data.show')
                </td>
                @empty($editData)
                    <td class="text-nowrap text-right">{{ $data->updated_at->diffForHumans() }}</td>
                    @can(\App\Library\Permissions::update_content)
                        <td class="text-right">
                            <div class="text-nowrap">
                                <a class="mr-2 btn btn-sm btn-info" href="#"
                                   onclick="event.preventDefault(); document.getElementById('data-{{ $data->id }}-synthesize').submit();">
                                    Text to Speech
                                </a>
                                <form id="data-{{ $data->id }}-synthesize" class="d-none"
                                      action="{{ route('admin.exercise.data.audio.synthesize', $data) }}" method="post">
                                    @method('patch')
                                    @csrf
                                </form>
                                <a href="#"
                                   data-toggle="modal" data-target="{{ '#data-' . $data->id . '-modal-delete' }}">
                                    <icon-delete></icon-delete>
                                </a>
                                @include('admin.components.modals.confirmation', ['id' => 'data-' . $data->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $data]), 'form' =>  'data-' . $data->id . '-delete', 'action' => 'Delete'])
                                <form id="data-{{ $data->id }}-delete" class="d-none"
                                      action="{{ route('admin.exercise.data.destroy', $data) }}" method="post">
                                    @method('delete')
                                    @csrf
                                </form>
                            </div>
                        </td>
                    @endcan
                @endempty
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
