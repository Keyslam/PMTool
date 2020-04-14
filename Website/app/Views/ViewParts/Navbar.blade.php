<nav>
    <div class="nav-wrapper">
        <ul class="left hide-on-med-and-down">
            <li><a href="{{ path() }}">Regels</a></li>

            @if (Auth::isLoggedIn())
                @if (Auth::isAdmin())
                    <li><a href="{{ path() }}/Admin/ManageGames">Spellen beheren</a></li>
                @else
                    <li><a href="{{ path() }}/User/Signup">Aanmelden voor spel</a></li>
                    <li><a href="{{ path() }}/User/Statistics">Statistieken</a></li>
                @endif
            @else
                <li><a href="{{ path() }}/Home/Login">Inloggen</a></li>
            @endif


        </ul>

        <ul class="right hide-on-med-and-down">
            @if (Auth::isLoggedIn())
                @if (Auth::isAdmin())
                    <li><a href="{{ path() }}/Admin/LogoutGET">Uitloggen</a></li>
                @else
                    <li><a href="{{ path() }}/User/LogoutGET">Uitloggen</a></li>
                @endif
            @endif

            <li><a href="{{ path() }}/Home/ActiveGame">Actieve spel</a></li>
        </ul>

        <a class="right dropdown-trigger hide-on-large-only" data-target="mobile-nav" style="padding-right: 10px;"><i
                    class="material-icons">menu</i></a>
        <ul id="mobile-nav" class="dropdown-content">
            <li><a href="{{ path() }}">Regels</a></li>
            @if (Auth::isLoggedIn())
                @if (Auth::isAdmin())
                    <li><a href="{{ path()}}/Admin/ManageGames">Spellen beheren</a></li>
                @else
                    <li><a href="{{ path() }}/User/Signup">Aanmelden voor spel</a></li>
                    <li><a href="{{ path() }}/User/Statistics">Statistieken</a></li>
                @endif
            @else
                <li><a href="{{ path() }}/Home/Login">Inloggen</a></li>
            @endif
            @if (Auth::isLoggedIn())
                @if (Auth::isAdmin())
                    <li><a href="{{ path() }}/Admin/LogoutGET">Uitloggen</a></li>
                @else
                    <li><a href="{{ path() }}/User/LogoutGET">Uitloggen</a></li>
                @endif
            @endif
            <li><a href="{{ path() }}/Home/ActiveGame">Actieve spel</a></li>
        </ul>
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.dropdown-trigger');
        var instances = M.Dropdown.init(elems, options);
    });

</script>