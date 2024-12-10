<x-layout>
    <table>
        <tr>
            <th>ID</th>
            <th>Chat_id</th>
            <th>User_id</th>
            <th>Type</th>
            <th>Content</th>
            <th>Sent_at</th>
            <th>Seen</th>
        </tr>
        @foreach ($messages as $message)
            <tr>
                <td>{{ $message->id }}</td>
                <td>{{ $message->chat_id }}</td>
                <td>{{ $message->user_id }}</td>
                <td>{{ $message->type }}</td>
                <td>{{ $message->content }}</td>
                <td>{{ $message->sent_at }}</td>
                <td>{{ $message->seen }}</td>
            </tr>
        @endforeach
    </table>
</x-layout>
