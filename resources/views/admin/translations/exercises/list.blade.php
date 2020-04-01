<table class="table">
    <thead>
    <tr>
        <th class=""></th>
        <th class="col-11 col-md-10"></th>
        <th class="text-right text-nowrap d-none d-md-table-cell">Last Modified</th>
    </tr>
    </thead>
    <tbody>
    @foreach($exercises as $exercise)
        <tr>
            <td>{{ $exercise->index }}</td>
            <td class="clickable-row last-child-mb-0"
                data-href="{{ route('admin.translations.exercise.show', [$language, $exercise]) }}">
                @if($exercise->isDisabled($content->language) or $exercise->isDisabled($language))
                    <div>
                        @if($exercise->isDisabled($content->language))
                            <span class="badge badge-warning text-uppercase">Disabled</span>
                        @endif
                        @if($exercise->isDisabled($language))
                            <span class="badge badge-light text-uppercase">Disabled</span>
                        @endif
                    </div>
                @endif
                @foreach($exercise->exerciseData as $data)
                    @include('admin.content.exercises.data.show')
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
