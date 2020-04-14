@for($i = 0; $i < count($tables); $i++)
    @if($i % 4 == 0)
        <div class="row">
    @endif

    <div class="col s3">
        <div class="card hoverable table-select" data-num="{{ $i }}">
            <div class="card-content">
                <span class="card-title">Tafel {{ $i + 1 }}</span>

                @foreach($tables[$i] as $user)
                    <b>{{ $user["UserName"] }}</b>
                    <br>
                @endforeach
            </div>
        </div>
    </div>

    @if($i % 4 == 3)
        </div>
    @endif
@endfor

@if(count($tables) == 0)
    <b>Er zijn nog geen tables ingedeeld</b>
@endif

<script>
    $(document).ready(function() {
        $(".table-select").on("click", function(event) {
            let elem = $(event.target).closest(".table-select");
            let tableNum = elem.data("num");

            $.ajax({
            	method: "POST",
				url: "@asset('Table/Select')",
				dataType: "json",
                data: {
                    "table_num": tableNum,
                }
			})
			.done(serverSuccess(function(response) {
				window.location.href = "http://localhost/PMTool/Website/Table";
			}))
			.fail(serverError);         
        })
    })
</script>