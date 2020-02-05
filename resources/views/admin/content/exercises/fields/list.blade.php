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
    @foreach($exerciseFields as $exerciseField)
        @if(isset($editedField) && $exerciseField->id == $editedField->id)
            <tr>
                <td colspan="3">
                    @include('admin.content.exercises.fields.edit')
                </td>
            </tr>
        @else
            <tr data-id="{{ $exerciseField->id }}">
                <td class="clickable-row"
                    data-href="{{ route('admin.exercises.show', [$exercise, 'field' => $exerciseField->id]) }}">
                    @include('admin.content.exercises.fields.show')
                </td>
                <td class="text-nowrap text-right">{{ $exerciseField->updated_at->diffForHumans() }}</td>
                @can(\App\Library\Permissions::update_content)
                    <td class="text-right">
                        <div class="text-nowrap">
                            <a class="mr-2" href="#" onclick="event.preventDefault(); document.getElementById('field-{{ $exerciseField->id }}-synthesize').submit();">Synthesize Audio</a>
                            <form id="field-{{ $exerciseField->id }}-synthesize" class="d-none"
                                  action="{{ route('admin.exercise.fields.audio.synthesize', $exerciseField) }}" method="post">
                                @method('patch')
                                @csrf
                            </form>
                            <a class="mr-2" href="#" onclick="event.preventDefault(); document.getElementById('field-{{ $exerciseField->id }}-duration').submit();">Duration</a>
                            <form id="field-{{ $exerciseField->id }}-duration" class="d-none"
                                  action="{{ route('admin.exercise.fields.audio.duration', $exerciseField) }}" method="post">
                                @method('patch')
                                @csrf
                            </form>
                            <a href="#"
                               data-toggle="confirmation"
                               data-btn-ok-label="{{ __('admin.form.delete') }}"
                               data-title="{{ __('admin.form.delete_confirmation', ['object' => $exerciseField]) }}"
                               data-form="field-{{ $exerciseField->id }}-delete">
                                @include('admin.components.svg.delete')
                            </a>
                            <form id="field-{{ $exerciseField->id }}-delete" class="d-none"
                                  action="{{ route('admin.exercise.fields.destroy', $exerciseField) }}" method="post">
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

@includeWhen(\App\Library\Permissions::update_content, 'admin.components.sortable', ['route' => route('admin.exercise.fields.move')])
