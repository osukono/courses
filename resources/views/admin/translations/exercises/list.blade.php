<table class="table">
    <thead>
    <tr>
        <th class=""></th>
        <th class="col-10"></th>
        <th class="text-right text-nowrap">Last Modified</th>
    </tr>
    </thead>
    <tbody>
    @foreach($exercises as $exercise)
        <tr>
            <td>{{ $exercise->index }}</td>
            <td class="clickable-row last-child-mb-0"
                data-href="{{ route('admin.translations.exercise.show', [$language, $exercise]) }}">
                @foreach($exercise->exerciseFields as $exerciseField)
                    @include('admin.content.exercises.fields.show')
                    @if($exerciseField->field->translatable && ($translation = $exerciseField->translations->first()) != null)
                        <div class="mb-1">
                            @include('admin.translations.exercises.fields.show')
                        </div>
                    @endif
                @endforeach
            </td>
            <td class="text-nowrap text-right">{{ $exercise->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
