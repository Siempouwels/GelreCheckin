<?php 
session_start();
?>
<?php include_once 'functions/login.php'; ?>

<!DOCTYPE html>
<html>

<head>
    <title>Gelre Checkin - Login</title>
    <?php include_once 'components/head.php'; ?>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <?php include_once 'components/navbar.php'; ?>
    <section class="login-section">
        <div class="login-card">
            <h2>Login</h2>
            <?php
            if (isset($errorMessage)) {
                echo '<p class="error-message">' . $errorMessage . '</p>';
            }
            ?>
            <form action="/login.php" method="post">
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="passagier">Passagier</option>
                    <option value="medewerker">Medewerker</option>
                </select>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="unsafe-pass" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </section>
</body>

</html>