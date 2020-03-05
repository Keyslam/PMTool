<nav>
    <div class="nav-wrapper">
    
    <ul id="nav-mobile" class="left hide-on-med-and-down">
        <li class="<? if ($active_page === "home")       { echo "active "; } ?>"><a href="index.php"> Home</a></li>
        <li class="<? if ($active_page === "signup")     { echo "active "; } ?>"><a href="signup.php">Aanmelden</a></li>
        <li class="<? if ($active_page === "statistics") { echo "active "; } ?>"><a href="stats.php"> Statistiek</a></li>
    </ul>

    <a class="right" href="active-game.php">Huidig spel</a>

    <a class="right" href="private/src/logout.php">Log uit</a>
</nav>