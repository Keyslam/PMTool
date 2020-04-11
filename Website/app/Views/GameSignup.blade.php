@extends("Layouts.BaseLayout")

@section("title", "Join Tournament")

@section("constrained-content")
    <div class="row">
        <div class="col s3">
            <label for="scheduled-games">Ingeplande spellen</label>
            <ul id="scheduled-games">

            </ul>
            <button id="game-list-refresh" class="btn  modal-trigger waves-effect waves-light"
                    style="width: 100%">Refresh
            </button>
        </div>

        <div id="game-info">

        </div>
    </div>
@endsection

@section("scripts")
    <script>
        $(document).ready(function () {
            updateScheduledGames();
            $("#game-list-refresh").on("click", updateScheduledGames);
            $("#scheduled-games").on("click", "li", selectGame);

        });

        function updateScheduledGames() {
            $.ajax({
                method: "POST",
                url: "@asset('Tournament/ListScheduled')",
                dataType: "html",
            })
                .done(function (data) {
                    $("#scheduled-games").html(data);
                })
                .fail(function () {
                    alert("Something went wrong ;-;");
                });
        }

        function selectGame(event) {
            $.ajax({
                method: "POST",
                url: "@asset('Tournament/SelectGame')",
                dataType: "html",
                data: {
                    "id": $(event.target).closest("li").data("id")
                }
            }).done(function (data) {
                $("#game-info").html(data);
            }).fail(function () {
                alert('De toernooi data kon niet worden opgehaald');
            })
        }
    </script>
@endsection
