<x-layout>
    <table>
        <tr>
            <th>User_id</th>
            <th>Chat_id</th>
        </tr>
        @foreach ($chatusers as $chatuser)
            <tr>
                <td>{{ $chatuser->user_id }}</td>
                <td>{{ $chatuser->chat_id }}</td>
            </tr>
        @endforeach
    </table>
</x-layout>
