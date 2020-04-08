<nav>
	<div class="nav-wrapper">
	    <a href="#" class="brand-logo">Logo</a>
        
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="{{ router()->getCurrentUrl() }}">Home</a></li>

            @if (Auth::isLoggedIn() && !Auth::isAdmin())
                <li><a href="{{ router()->getCurrentUrl() }}/User/LogoutPOST">Logout</a></li>
            @elseif (Auth::isLoggedIn() && Auth::isAdmin())
                <li><a href="{{ router()->getCurrentUrl() }}/Admin/LogoutPOST">Logout</a></li>
            @else
                <li><a href="{{ router()->getCurrentUrl() }}/Home/Login">Login</a></li>
            @endif

            <li><a href="#">Active Game</a></li>
        </ul>
	</div>
</nav>