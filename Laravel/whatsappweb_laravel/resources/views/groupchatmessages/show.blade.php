<x-layout>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
        </tr>

        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->username }}</td>
        </tr>

    </table>
</x-layout>
