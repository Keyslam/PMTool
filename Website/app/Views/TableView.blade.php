@extends("Layouts.BaseLayout")

@section("title", "Tafel")

@section("constrained-content")

<div class="row">
    <div class="col s3" id="fiches">
    </div>
    <div class="col s3" id="blinds">
    </div>
    <div class="col s3" id="playerslist">
        
    </div>
    <div class="col s3">
    </div>
</div>

@endsection
@section('scripts')

<script>
$(document).ready(function() {
    refreshfiches();
    refreshblinds();
    refreshplayers();
})

function refreshfiches() {
    $.ajax({
            method: "POST",
            url: "@asset('Table/getFiches')",
            dataType: "json"
        })
        .done(serverSuccess(function(response) {
            $('#playerslist').html(response.html)
        }))
        .fail(serverError);
}

function refreshblinds() {
    $.ajax({
            method: "POST",
            url: "@asset('Table/getBlinds')",
            dataType: "json"
        })
        .done(serverSuccess(function(response) {
            $('#playerslist').html(response.html)
        }))
        .fail(serverError);
}

function refreshplayers() {
    $.ajax({
            method: "POST",
            url: "@asset('Table/getPlayers')",
            dataType: "json"
        })
        .done(serverSuccess(function(response) {
            $('#playerslist').html(response.html)
        }))
        .fail(serverError);
}
</script>

@endsection