<table class="table">
    <thead>
    <tr>
        <th class="col-10"></th>
        <th class="text-right text-nowrap">Last Modified</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($exerciseFields as $exerciseField)
        @if(isset($editedField) && $exerciseField->id == $editedField->id)
            <tr>
                <td colspan="3">
                    @include('admin.content.exercises.fields.show')
                    @include('admin.translations.exercises.fields.edit', ['translation' => $exerciseField->translations->first()])
                </td>
            </tr>
        @else
            <tr>
                <td
                    @if($exerciseField->field->translatable)
                    class="clickable-row"
                    data-href="{{ route('admin.translations.exercise.show', [$language, $exercise, 'field' => $exerciseField->id]) }}"
                    @endif
                >
                    @include('admin.content.exercises.fields.show')
                    @includeWhen($exerciseField->field->translatable && ($translation = $exerciseField->translations->first()) != null, 'admin.translations.exercises.fields.show')
                </td>
                <td class="text-nowrap text-right">{{ $exerciseField->updated_at->diffForHumans() }}</td>
                <td class="text-nowrap">
                    @if($exerciseField->translations->first() != null)
                        <a class="mr-2" href="#"
                           onclick="event.preventDefault(); document.getElementById('translation-{{ $exerciseField->translations->first()->id }}-synthesize').submit();">
                            Synthesize Audio
                        </a>
                        <form id="translation-{{ $exerciseField->translations()->first()->id }}-synthesize" class="d-none"
                              action="{{ route('admin.translations.audio.synthesize', $exerciseField->translations->first()) }}"
                              method="post">
                            @method('patch')
                            @csrf
                        </form>
                        <a class="mr-2" href="#"
                           onclick="event.preventDefault(); document.getElementById('translation-{{ $exerciseField->translations->first()->id }}-duration').submit();">
                            Duration
                        </a>
                        <form id="translation-{{ $exerciseField->translations()->first()->id }}-duration" class="d-none"
                              action="{{ route('admin.translations.audio.duration', $exerciseField->translations->first()) }}"
                              method="post">
                            @method('patch')
                            @csrf
                        </form>
                    @endif
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
