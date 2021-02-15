<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="/index.php">winlott</a>
        <button data-toggle="collapse" data-target="#navbarResponsive" class="navbar-toggler navbar-toggler-right"
                type="button" data-toogle="collapse" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="nav navbar-nav ml-auto text-uppercase">
                <li class="nav-item" id="play-link">
                    <a class="nav-link js-scroll-trigger text-light" href="#">Play</a>
                </li>
                <li class="nav-item hide-links">
                    <a class="nav-link js-scroll-trigger text-light" href="/lucky.php">Lucky Numbers</a>
                </li>

                <li class="nav-item hide-links">
                    <a class="nav-link js-scroll-trigger text-light" href="/saves.php">Save Numbers</a>
                </li>
                <li class="nav-item hide-links">
                    <a class="nav-link js-scroll-trigger text-light" href="/delta.php">Delta System</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger text-light" href="/results.php">Results</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link js-scroll-trigger text-light" href="/contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <?php

                    if (isset($_SESSION['winlott-valid-name']) || (isset($_COOKIE['winlott-user']) && isset($_COOKIE['remember-me']))) {
                        echo "<a href='/photoFrame.php' class='nav-link js-scroll-trigger text-light'>Account</a>";
                    } else {
                        echo "<div class='login-btn-container ml-3'><a href='/login.php' class='nav-link login-badge'>Login</a></div>";
                    }

                    ?>
                </li>
                <li class="nav-item">
                    <div class="login-btn-container ml-3">
                        <?php

                        if (isset($_SESSION['winlott-valid-name']) || (isset($_COOKIE['winlott-user']) && isset($_COOKIE['remember-me']))) {
                            echo "<a href='/outTheDoor.php' class='nav-link login-badge'><span class='fa fa-sign-out'></span></a>";
                        }

                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container" id="play-nav-container">
    <div class="navbar fixed-top" id="play-nav">
        <ul class="mx-auto">
            <li class="nav-item">
                <a class="nav-link text-light" href="/lucky.php">Lucky Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/saves.php">Save Numbers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="/delta.php">Delta System</a>
            </li>
        </ul>
    </div>
</div>

