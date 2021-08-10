<table class="table">
    <thead>
    <tr>
        <th class="col-12"></th>
        <th>Email</th>
        <th>Roles</th>
        <th class="text-end">Registered</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr class="clickable-row" data-href="{{ route('admin.users.show', $user) }}">
            <td class="text-nowrap">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td class="text-nowrap">
                @foreach($user->roles as $role)
                    <span class="me-3 text-nowrap">{{ $role->name }}</span>
                @endforeach
            </td>
            <td class="text-nowrap text-end">{{ $user->created_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
