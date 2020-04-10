@extends("Layouts.ErrorLayout")

@section("title", "500 Internal Server Error")

@section("constrained-content")
    <div class="row">
        <div class="col s10 offset-s1">
            <div style="textalign: center;">
                <h2>500 Internal Server Error</h2>
                <p>Something went wrong...</p>
            </div>
        </div>
    </div>
@endsection
