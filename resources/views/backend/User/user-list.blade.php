<table>
    <thead>
    <tr>
        <th><b>Username</b></th>
        <th><b>Email</b></th>
        <th><b>Phone Number</b></th>
        <th><b>Role</b></th>
        <th><b>Joined Date</b></th>
        <th><b>Status</b></th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $index=>$user)
        <tr>
            <td>
                {{ $user->username }}
            </td>
            <td>
                {{ $user->email }}
            </td>
            <td>
                {{ $user->phone_number }}
            </td>
            <td>
                @if($user->role) {{ $user->role->display_name }} @endif
            </td>
            <td>
                {{ $user->created_at }}
            </td>
            <td>
                {{$user->is_active == 1 ? 'Active' : 'Not Active'}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
