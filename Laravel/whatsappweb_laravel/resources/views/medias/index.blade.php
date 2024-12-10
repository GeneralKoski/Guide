<x-layout>
    <table>
        <tr>
            <th>ID</th>
            <th>Message_id</th>
            <th>Media_type</th>
            <th>File_path</th>
            <th>File_size</th>
            <th>Uploaded_at</th>
        </tr>
        @foreach ($medias as $media)
            <tr>
                <td>{{ $media->id }}</td>
                <td>{{ $media->message_id }}</td>
                <td>{{ $media->media_type }}</td>
                <td>{{ $media->file_path }}</td>
                <td>{{ $media->file_size }}</td>
                <td>{{ $media->uploaded_at }}</td>
            </tr>
        @endforeach
    </table>
</x-layout>
