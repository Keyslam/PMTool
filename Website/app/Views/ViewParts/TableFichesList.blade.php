<label for="ficheslist">Fiches</label>
<ul class="collection" id="ficheslist">
	@foreach ($chipsList as $chip=>$value)
		<li class="collection-item">
			<b>{{ $chip }}: </b>
			{{ $value }}
		</li>
	@endforeach
</ul>