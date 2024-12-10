<x-layout>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Created_at</th>
        </tr>
        @foreach ($chats as $chat)
            <tr>
                <td>{{ $chat->id }}</td>
                <td>{{ $chat->name }}</td>
                <td>{{ $chat->type }}</td>
                <td>{{ $chat->created_at }}</td>
            </tr>
        @endforeach
    </table>
</x-layout>
