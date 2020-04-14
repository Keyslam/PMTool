<nav>
	<div class="nav-wrapper">
        <ul class="left">
            <li><a href="{{ router()->getCurrentUrl() }}">Regels</a></li>

            @if (Auth::isLoggedIn())
                @if (Auth::isAdmin())
                    <li><a href="{{ router()->getCurrentUrl() }}/Admin/ManageGames">Spellen beheren</a></li>
                    <li><a href="{{ router()->getCurrentUrl() }}/Admin/Statistics">Statistieken</a></li>
                @else
                    <li><a href="{{ router()->getCurrentUrl() }}/User/Signup">Aanmelden voor spel</a></li>
                    <li><a href="{{ router()->getCurrentUrl() }}/User/Statistics">Statistieken</a></li>
                @endif
            @else
                <li><a href="{{ router()->getCurrentUrl() }}/Home/Login">Inloggen</a></li>
            @endif

            
        </ul>

        <ul class="right">
            @if (Auth::isLoggedIn())
                @if (Auth::isAdmin())
                    <li><a href="{{ router()->getCurrentUrl() }}/Admin/LogoutGET">Uitloggen</a></li>
                @else
                    <li><a href="{{ router()->getCurrentUrl() }}/User/LogoutGET">Uitloggen</a></li>
                @endif

                <li><a href="{{ router()->getCurrentUrl() }}/Home/ActiveGame">Actieve spel</a></li>
            @endif
        </ul>
	</div>
</nav>