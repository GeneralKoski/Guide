<x-layout>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
            </tr>
        @endforeach
    </table>
</x-layout>
