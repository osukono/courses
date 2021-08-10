<table class="table">
    <thead>
    <tr>
        <th class="col-12"></th>
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
                    <div class="text-nowrap">{{ $permission->name }}</div>
                @endforeach
            </td>
            <td class="text-end">
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
