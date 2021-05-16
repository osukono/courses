<table class="table">
    <thead>
    <tr>
        <th class="col-auto"></th>
        <th class="col"></th>
        <th class="col-auto text-right text-nowrap d-none d-md-table-cell">Last Modified</th>
    </tr>
    </thead>
    <tbody>
    @foreach($exercises as $exercise)
        <tr class="clickable-row" data-href="{{ route('admin.translations.exercises.show', [$language, $exercise]) }}">
            <td>{{ $exercise->index }}</td>
            <td class="last-child-mb-0">
                @includeWhen($exercise->isDisabled($content->language), 'admin.components.disabled.content')
                @includeWhen($exercise->isDisabled($language), 'admin.components.disabled.translation')

                @foreach($exercise->exerciseData as $data)
                    @include('admin.development.exercises.data.show')
                    @if(($translation = $data->translations->first()) != null)
                        <div class="mb-1">
                            @include('admin.translations.exercises.data.show')
                        </div>
                    @endif
                @endforeach
            </td>
            <td class="text-nowrap text-right d-none d-md-table-cell">{{ $exercise->updated_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
