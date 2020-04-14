@extends("Layouts.BaseLayout")

@section("title", "Login")

@section("constrained-content")
	<div class="row">
		<div class="col l10 offset-l1">
			<div class="card">
                <div class="card-content">
                    <form action="{{ router()->getCurrentUrl() }}/Home/LoginPOST" method="POST">
                        @csrf
                        <div class="input-field">
                            <input placeholder="Gebruikersnaam" id="username" name="username" type="text" class="validate" maxlength="64" required>
                            <label for="username">Gebruikersnaam</label>
                        </div>
                        <div class="input-field">
                            <input placeholder="Wachtwoord" id="password" name="password" type="password" class="validate" maxlength="64" required>
                            <label for="password">Wachtwoord</label>
                        </div>

                        @if (isset($flash["loginError"]))
                            @foreach($flash["loginErrors"] as $loginError)
                                <p>{{ $loginError }}</p>
                            @endforeach
                        @endif
                        <a href="{{ router()->getCurrentUrl() }}/Home/Register">Nog geen account? Klik hier!</a><br>
                        <button class="btn waves-effect waves-light" type="submit">Inloggen<i class="material-icons right">send</i></button>
                    </form>
                </div>
            </div>
		</div>
	</div>
@endsection