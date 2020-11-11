<table class="table">
    <thead>
    <tr>
        <th class="col-12 col-md-7"></th>
        <th class="d-none d-md-table-cell">Lessons</th>
        <th class="d-none d-md-table-cell">Player</th>
        <th class="text-right d-none d-md-table-cell">Committed</th>
        <th class="text-right d-none d-md-table-cell">Status</th>
        <th class="text-nowrap d-none d-md-table-cell">Firebase ID</th>
    </tr>
    </thead>
    <tbody>
    @foreach($courses as $course)
        <tr>
            <td class="clickable-row" data-href="{{ route('admin.courses.show', $course) }}">{{ $course }}</td>
            <td class="d-none d-md-table-cell">{{ $course->demo_lessons . ' | ' . $course->course_lessons_count }}</td>
            <td class="d-none d-md-table-cell">{{ $course->player_version }}</td>
            <td class="text-nowrap text-right d-none d-md-table-cell">
                @isset($course->committed_at)
                    {{ $course->committed_at->diffForHumans() }}
                @endisset
            </td>
            <td class="text-nowrap text-right d-none d-md-table-cell">
                @isset($course->firebase_id)
                    @if($course->is_updating)
                        Updating
                    @else
                        @isset($course->uploaded_at)
                            {{ 'Published ' . $course->uploaded_at->diffForHumans() }}
                        @endisset
                    @endif
                @else
                    New
                @endisset
            </td>
            <td class="d-none d-md-table-cell">
                {{ $course->firebase_id }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
