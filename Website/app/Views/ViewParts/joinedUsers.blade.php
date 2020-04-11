<ul class="collection">
    @foreach ($users as $user)
        <li class="collection-item">{{ $user["UserName"] }}</li>
    @endforeach
</ul>