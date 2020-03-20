<table class="table">
    <thead>
    <tr>
        <th></th>
        <th class="col-10"></th>
        <th>Exercises</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lessons as $lesson)
        <tr class="clickable-row" data-href="{{ route('admin.courses.practice', [$course, $lesson]) }}">
            <td>{{ $lesson->index }}</td>
            <td>{{ $lesson->title }}</td>
            <td>{{ $lesson->exercises_count }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
