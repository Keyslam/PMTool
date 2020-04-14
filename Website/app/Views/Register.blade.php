@extends('Layouts.BaseLayout')

@section('title', 'Home')

@section('constrained-content')
    <div class="row">
        <div class="col l10 offset-l1">
            <div class="card">
                <div class="card-content">
                    <form action="{{ router()->getCurrentUrl() }}/Home/registerPost" method="POST">
                        @csrf
                        <div class="input-field">
                            <input placeholder="Gebruikersnaam" id="username" name="username" type="text" class="validate" maxlength="64" required>
                            <label for="username">Gebruikersnaam*</label>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input placeholder="Wachtwoord" id="password" name="password" type="password" class="validate" maxlength="64" required>
                                <label for="password">Wachtwoord*</label>
                            </div>
                            <div class="input-field col s6">
                                <input placeholder="Herhaal wachtwoord" id="password" name="rptPassword" type="password" class="validate" maxlength="64" required>
                                <label for="password">Herhaal Wachtwoord*</label>
                            </div>
                        </div>
                        
                         <label>
                            <input id="admin-checkbox" type="checkbox"/>
                            <span>Ik ben een administrator</span>
                        </label>

                        <br>

                        <div id="admin-token-container" class="hide">
                            <div class="input-field">
                                <input placeholder="Admin Token" id="adminToken" name="adminToken" type="password"  maxlength="16">
                                <label for="password">Admin Token</label>
                            </div>
                        </div>


                        @if (isset($flash["registerErrors"]))
                            @foreach($flash["registerErrors"] as $error)
                            <p>{{ $error}}</p>
                            @endforeach
                        @endif

                        <br>
                        
                        <button class="btn waves-effect waves-light" type="submit">Register<i class="material-icons right">send</i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
<script>
    $(document).ready(function() {
        $("#admin-checkbox").on("click", function(event) {
            state = $(event.target).prop("checked");
            updateAdminTokenContainer(state);
        })

        updateAdminTokenContainer(false);
    })

    function updateAdminTokenContainer(visible) {
        if (visible) {
            $("#admin-token-container").removeClass("hide");
        } else {
            $("#admin-token-container").addClass("hide");
        }
    }
</script>
@endsection()