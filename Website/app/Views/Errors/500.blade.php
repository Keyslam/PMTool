@extends("Layouts.ErrorLayout")

@section("title", "500 Internal Server Error")

@section("constrained-content")
    <div class="row">
        <div class="col s10 offset-s1">
            <div style="textalign: center;">
                <h2>500 Internal Server Error</h2>
                <p>Something went wrong...</p>
                <input id="exception" hidden value="{{ $exception }}">

                {!!$exception["xdebug_message"]!!}
                @if (isset($exception["error_info"]))
                    {!!$exception["error_info"]!!}
                @endif
            </div>
        </div>
    </div>
@endsection

@section("script")
<script>
    $(document).ready(function() {
        console.log($("#exception").val());
    });
</script>
@endsection