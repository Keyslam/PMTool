<label for="playerlist">Spelers</label>
<ul class="collection" id="playerlist">
	@foreach ($players as $player)
		<li data-id="{{ $player['ID'] }}" data-name="{{ $player['UserName'] }}" class="collection-item"> 
			{{ $player["UserName"] }} 

			<label class="right">
				<input class="player-select" type="checkbox">
				<span> </span>
			</label>

			@if ($player['HasRebought'])
				<i class="material-icons right">attach_money</i>
			@endif
		</li>
	@endforeach
</ul>

<div class="row">
	<div class="col l6">
		<button id="button-rebuy" class="btn waves-effect waves-light" style="width: 100%">Rebuyen</button>
	</div>

	<div class="col l6">
		<button id="button-win-hand" class="btn waves-effect waves-light" style="width: 100%">Hand laten winnen</button>
	</div>
</div>

<script>
	$(document).ready(function() {
		$(".player-select").on("click", updateButtons);
		$("#button-win-hand").on("click", winHand);
		$("#button-rebuy").on("click", rebuy);

		updateButtons();
	})

	function rebuy() {
		$(".player-select").each(function() {
			if ($(this).prop("checked")) {
				let id = $(this).closest("li").data("id");
				let name = $(this).closest("li").data("name");
				
				$.ajax({
					method: "POST",
					url: "@asset('Table/Rebuy')",
					dataType: "json",
					data: {
						"id": id,
					}
				})
				.done(serverSuccess(function(response) {
					if (!response.reboughtSuccess) {
						alert(name + " heeft al opnieuw ingekocht.");
					}
				}))
				.fail(serverError);
			}

			wsc.send(JSON.stringify({
				"command": "userChanged",	
			}));
		});

		clearSelected();
	}

	function winHand() {
		 $(".player-select").each(function() {
			if ($(this).prop("checked")) {
				let id = $(this).closest("li").data("id");
				
				$.ajax({
					method: "POST",
					url: "@asset('Table/winHand')",
					dataType: "json",
					data: {
						"id": id,
					}
				})
				.done(serverSuccess(function(response) {}))
				.fail(serverError);
			}

			let id = $(this).closest("li").data("id");
				
			$.ajax({
				method: "POST",
				url: "@asset('Table/addHand')",
				dataType: "json",
				data: {
					"id": id,
				}
			})
			.done(serverSuccess(function(response) {}))
			.fail(serverError);
		});

		clearSelected();
	}

	function updateButtons() {
		var count = 0;

		$(".player-select").each(function() {
			if ($(this).prop("checked")) {
				count = count + 1;
			}
		});
			
		if (count > 0) {
			$("#button-rebuy").removeClass("disabled");
			$("#button-win-hand").removeClass("disabled");
		} else {
			$("#button-rebuy").addClass("disabled");
			$("#button-win-hand").addClass("disabled");
		}
	}

	function clearSelected() {
		$(".player-select").each(function() {
			$(this).prop("checked", false);
		});

		updateButtons();
	}
</script>