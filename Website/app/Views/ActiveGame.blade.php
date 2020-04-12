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
		.done(function(response) {
			if (response.success) {
				$("#tables-container").html(response.html);
			} else {
				serverError(response);
			}
		})
		.fail(serverError);
	})
</script>
@endsection

