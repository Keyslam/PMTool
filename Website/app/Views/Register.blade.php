@extends('Layouts.BaseLayout')

@section('title', 'Home')

@section('constrained-content')
    <div class="row">
        <div class="col s10 offset-s1">
            <div class="card">
                <div class="card-content">
                    <form action="{{ router()->getCurrentUrl() }}/Home/registerPost" method="POST">
                        @csrf
                        <div class="input-field">
                            <input placeholder="Gebruikersnaam" id="username" name="username" type="text" class="validate" maxlength="64" required>
                            <label for="username">Gebruikersnaam</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input placeholder="Wachtwoord" id="password" name="password" type="password" class="validate" maxlength="64" required>
                                <label for="password">Wachtwoord</label>
                            </div>
                            <div class="input-field col s6">
                                <input placeholder="Wachtwoord" id="password" name="rptPassword" type="password" class="validate" maxlength="64" required>
                                <label for="password">Herhaal Wachtwoord</label>
                            </div>
                        </div>
                        <div class="input-field">
                            <input placeholder="Admin Token" id="adminToken" name="adminToken" type="password"  maxlength="16">
                            <label for="password">Admin Token</label>
                        </div>

                        @if (isset($flash["registerErrors"]))
                            @foreach($flash["registerErrors"] as $error)
                            <p>{{ $error}}</p>
                            @endforeach
                        @endif

                        <button class="btn waves-effect waves-light" type="submit">Register<i class="material-icons right">send</i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection