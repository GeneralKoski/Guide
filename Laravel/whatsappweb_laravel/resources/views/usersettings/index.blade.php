<x-layout>
    <table>
        <tr>
            <th>ID</th>
            <th>User_id</th>
            <th>Setting_name</th>
            <th>Setting_value</th>
            <th>Updated_at</th>
        </tr>
        @foreach ($usersettings as $usersetting)
            <tr>
                <td>{{ $usersetting->id }}</td>
                <td>{{ $usersetting->user_id }}</td>
                <td>{{ $usersetting->setting_name }}</td>
                <td>{{ $usersetting->setting_value }}</td>
                <td>{{ $usersetting->updated_at }}</td>
            </tr>
        @endforeach
    </table>
</x-layout>
