@extends("Layouts.BaseLayout")

@section("constrained-content")
    <div id="tables-container">

	</div>
@endsection

@section("scripts")
<script>
	$(document).ready(function() {
		$.ajax({
			method: "POST",
            url: "@asset('Tournament/ListTables')",
        	dataType: "json",
		})
		.done(serverSuccess(function(response) {
			$("#tables-container").html(response.html);
		}))
		.fail(serverError);
	})
</script>
@endsection

