<table class="table">
    <thead>
    <tr>
        <th></th>
        <th class="col-11 col-md-10"></th>
        <th class="d-none d-md-table-cell">Exercises</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lessons as $lesson)
        <tr class="clickable-row" data-href="{{ route('admin.courses.practice', [$course, $lesson]) }}">
            <td><div class="lead">{{ $lesson->index }}</div></td>
            <td>
                <div class="row">
                    @isset($lesson->image)
                        <div class="col-auto">
                            <img src="{{ $lesson->image }}" width="160" height="90" class="rounded"
                                 alt="{{ $lesson->title }}"/>
                        </div>
                    @endisset
                    <div class="col h6">{{ $lesson->title }}</div>
                    <div>{!! nl2br($lesson->description) !!}</div>
                </div>

            </td>
            <td class="d-none d-md-table-cell">{{ $lesson->exercises_count }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
