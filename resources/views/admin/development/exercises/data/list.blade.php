<table class="table">
    <thead>
    <tr>
        @empty($editData)
            <th class="col-12"></th>
            <th class="text-end text-nowrap">Last Modified</th>
            @can(\App\Library\Permissions::update_content)
                <th></th>
            @endcan
        @else
            <th class="col"></th>
        @endempty
    </tr>
    </thead>
    <tbody
        @if(isset($editData) == false)
        id="{{ can(\App\Library\Permissions::update_content, 'sortable') }}"
        data-route="{{ route('admin.dev.exercise.data.move') }}"
        @endif
    >
    @foreach($exerciseData as $data)
        @if(isset($editData) && $data->id == $editData->id)
            <tr>
                <td colspan="3">
                    @include('admin.development.exercises.data.edit')
                </td>
            </tr>
        @else
            <tr
                @if(isset($editData) == false)
                data-sortable="{{ $data->id }}"
                @endif
            >
                <td
                    @can(\App\Library\Permissions::update_content)
                    class="clickable-row"
                    data-href="{{ route('admin.dev.exercises.show', [$exercise, 'data' => $data->id]) }}"
                    @endcan
                >
                    @include('admin.development.exercises.data.show', ['show_info' => true])
                </td>
                @empty($editData)
                    <td class="text-nowrap text-end">{{ $data->updated_at->diffForHumans() }}</td>
                    @can(\App\Library\Permissions::update_content)
                        <td class="text-end">
                            <div class="text-nowrap">
                                <a class="me-2 btn btn-sm btn-info" href="#"
                                   onclick="event.preventDefault(); document.getElementById('data-{{ $data->id }}-synthesize').submit();">
                                    Text to Speech
                                </a>
                                <form id="data-{{ $data->id }}-synthesize" class="d-none"
                                      action="{{ route('admin.dev.exercise.data.audio.synthesize', $data) }}"
                                      method="post">
                                    @method('patch')
                                    @csrf
                                </form>
                                <a href="#"
                                   data-bs-toggle="modal" data-bs-target="{{ '#data-' . $data->id . '-modal-delete' }}">
                                    <icon-delete></icon-delete>
                                </a>
                                @include('admin.components.modals.confirmation', ['id' => 'data-' . $data->id . '-modal-delete', 'title' => __('admin.form.delete_confirmation', ['object' => $data]), 'form' =>  'data-' . $data->id . '-delete', 'action' => 'Delete'])
                                <form id="data-{{ $data->id }}-delete" class="d-none"
                                      action="{{ route('admin.dev.exercise.data.destroy', $data) }}" method="post">
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
