<table class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Permissions</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($assignedRoles as $role)
        <tr>
            <td class="text-nowrap">{{ $role->name }}</td>
            <td>
                @foreach($role->permissions as $permission)
                    <span class="mx-2 text-nowrap rounded">{{ $permission->name }}</span>
                @endforeach
            </td>
            <td class="text-right">
                <form id="role-{{ $role->id }}-remove" action="{{ route('admin.users.roles.remove', [$user, $role]) }}" method="post" autocomplete="off">
                    @csrf
                    @method('patch')
                    <input type="submit" value="Remove" class="btn btn-sm btn-link">
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
