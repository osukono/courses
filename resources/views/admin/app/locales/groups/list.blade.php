<table class="table">
    <thead>
    <tr>
        <th class="col-11">Name</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($localeGroups as $localeGroup)
        <tr>
            <td>{{ $localeGroup->name }}</td>
            <td>
                <a href="{{ route('admin.app.locale.groups.edit', $localeGroup) }}">
                    <icon-edit></icon-edit>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
