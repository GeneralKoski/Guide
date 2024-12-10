<x-layout>
    <table>
        <tr>
            <th>ID</th>
            <th>Chat_id</th>
            <th>Message_id</th>
            <th>Seen_by_user</th>
            <th>Seen?</th>
        </tr>
        @foreach ($groupchatmessages as $groupchatmessage)
            <tr>
                <td>{{ $groupchatmessage->id }}</td>
                <td>{{ $groupchatmessage->chat_id }}</td>
                <td>{{ $groupchatmessage->message_id }}</td>
                <td>{{ $groupchatmessage->seen_by_user }}</td>
                <td>{{ $groupchatmessage->seen }}</td>
            </tr>
        @endforeach
    </table>
</x-layout>
