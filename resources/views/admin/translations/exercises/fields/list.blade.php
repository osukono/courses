<table class="table">
    <thead>
    <tr>
        <th class="col-11"></th>
        <th class="text-right text-nowrap">Last Modified</th>
    </tr>
    </thead>
    <tbody>
    @foreach($exerciseFields as $exerciseField)
        @if(isset($editedField) && $exerciseField->id == $editedField->id)
            <tr>
                <td colspan="2">
                    @include('admin.content.exercises.fields.show')
                    @include('admin.translations.exercises.fields.edit', ['translation' => $exerciseField->translations->first()])
                </td>
            </tr>
        @else
            <tr
                @if($exerciseField->field->translatable)
                class="clickable-row"
                data-href="{{ route('admin.translations.exercise.show', [$language, $exercise, 'field' => $exerciseField->id]) }}"
                @endif
            >
                <td>
                    @include('admin.content.exercises.fields.show')
                    @includeWhen($exerciseField->field->translatable && ($translation = $exerciseField->translations()->first()) != null, 'admin.translations.exercises.fields.show')
                </td>
                <td class="text-nowrap text-right">{{ $exerciseField->updated_at->diffForHumans() }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
