<table class="table">
    <thead>
    <tr>
        <th></th>
        <th class="col-9"></th>
        <th></th>
        <th>Exercises</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lessons as $lesson)
        <tr>
            <td>{{ $lesson->number }}</td>
            <td>{{ $lesson->title }}</td>
            <td>{{ $course->demo_lessons >= $lesson->number ? 'Free' : '' }}</td>
            <td>{{ $lesson->exercises_count }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
