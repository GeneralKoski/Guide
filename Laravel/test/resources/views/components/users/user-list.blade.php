<nav>
    <ul class="list-group">
        @forelse ($users as $user)
        <li class="list-group-item">{{$loop->index+1}} {{$user->name}}</li>
        @empty
        <li>Hai passato un array vuoto</li>
        @endforelse
    </ul>
</nav>