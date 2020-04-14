<table class="table">
    <thead>
    <tr>
        <th class="col"></th>
        <th class="col-auto">Email</th>
        <th class="col-auto">Roles</th>
        <th class="text-right col-auto">Registered</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr class="clickable-row" data-href="{{ route('admin.users.show', $user) }}">
            <td class="text-nowrap">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td class="text-nowrap">
                @foreach($user->roles as $role)
                    <span class="mr-3 text-nowrap">{{ $role->name }}</span>
                @endforeach
            </td>
            <td class="text-nowrap text-right">{{ $user->created_at->diffForHumans() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
