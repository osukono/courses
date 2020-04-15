<table class="table">
    <thead>
    <tr>
        <th class="col"></th>
        <th class="col-auto"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($assignedContents as $content)
        <tr>
            <td>{{ $content }}</td>
            <td>
                <form action="{{ route('admin.users.content.access.remove', [$user, $content]) }}"
                      method="post">
                    @csrf
                    @method('patch')
                    <button type="submit" class="btn btn-link btn-sm">Remove</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
