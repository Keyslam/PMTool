@for($i = 0; $i < count($tables); $i++)
    @if($i % 4 == 0)
        <div class="row">
    @endif

    <div class="col s3">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Tafel {{ $i + 1 }}</span>

                @foreach($tables[$i]["users"] as $user)
                    <b>{{ $user }}</b>
                    <br>
                @endforeach
            </div>
        </div>
    </div>

    @if($i % 4 == 3)
        </div>
    @endif
@endfor