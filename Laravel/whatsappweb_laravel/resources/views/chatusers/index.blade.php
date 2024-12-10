<x-layout>
    <table>
        <tr>
            <th>ID</th>
            <th>User_id</th>
            <th>Chat_id</th>
            <th>Added_at</th>
        </tr>
        @foreach ($chatusers as $chatuser)
            <tr>
                <td>{{ $chatuser->id }}</td>
                <td>{{ $chatuser->user_id }}</td>
                <td>{{ $chatuser->chat_id }}</td>
                <td>{{ $chatuser->added_at }}</td>
            </tr>
        @endforeach
    </table>
</x-layout>
