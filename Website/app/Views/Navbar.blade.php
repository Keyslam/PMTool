<nav>
	<div class="nav-wrapper">
	    <a href="#" class="brand-logo">Logo</a>
        
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="{{ router()->getCurrentUrl() }}">Home</a></li>

            @if (Auth::isLoggedIn())
                @if (Auth::isAdmin())
                    <li><a href="{{ router()->getCurrentUrl() }}/Admin/ManageGames">Mangage Games</a></li>
                    <li><a href="{{ router()->getCurrentUrl() }}/Admin/Statistics">Statistics</a></li>
                    <li><a href="{{ router()->getCurrentUrl() }}/Admin/LogoutPOST">Logout</a></li>
                @else
                    <li><a href="{{ router()->getCurrentUrl() }}/User/Signup">Signup</a></li>
                    <li><a href="{{ router()->getCurrentUrl() }}/User/Statistics">Statistics</a></li>
                    <li><a href="{{ router()->getCurrentUrl() }}/User/LogoutPOST">Logout</a></li>
                @endif
            @else
                <li><a href="{{ router()->getCurrentUrl() }}/Home/Login">Login</a></li>
            @endif

            <li><a href="#">Active Game</a></li>
        </ul>
	</div>
</nav>