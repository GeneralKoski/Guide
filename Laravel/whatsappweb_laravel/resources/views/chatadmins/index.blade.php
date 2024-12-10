<x-layout>
    <table>
        <tr>
            <th>ID</th>
            <th>Admin Chat_id</th>
            <th>Admin User_id</th>
        </tr>
        @foreach ($admins as $admin)
            <tr>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->Achat_id }}</td>
                <td>{{ $admin->Auser_id }}</td>
            </tr>
        @endforeach
    </table>
</x-layout>
