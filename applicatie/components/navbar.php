<nav class="navbar">
    <a href="/" class="nav-logo">
        <img src="assets/images/logo.png" alt="Logo van Gelre checkin">
        <span>Gelre checkin</span>
    </a>
    <ul class="nav-links">
        <?php
            if(
                isset($_SESSION['username']) &&
                isset($_SESSION['type']) &&
                $_SESSION['type'] == 'medewerker'
            ) {
                echo '<li><a href="/nieuwe-vlucht.php">Nieuwe vlucht</a></li>';
            }
        ?>
        <?php
            if(
                isset($_SESSION['username']) &&
                isset($_SESSION['type']) &&
                $_SESSION['type'] == 'passagier'
            ) {
                echo '<li><a href="/mijn-vluchtgegevens.php">Nieuwe vlucht</a></li>';
            }
        ?>
        
        <li><a href="/vluchten-overzicht.php">Vluchtenoverzicht</a></li>
        <li><a href="/privacy-verklaring.php">Privacyverklaring</a></li>
        <?php if (isset($_SESSION['username'])) { ?>
            <li>
                <form action="/functions/logout.php" method="post">
                    <button type="submit" class="logout-button">Logout</button>
                </form>
            </li>
        <?php } else { ?>
            <li><a href="/login.php">Login</a></li>
        <?php } ?>
    </ul>
</nav>