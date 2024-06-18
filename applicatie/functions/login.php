<?php

$errorMessage = ''; // Initialize the error message

if(
    isset($_SESSION['username']) ||
    isset($_SESSION['passagiernummer'])
) {
    header('Location: /');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedUsername = $_POST['username'];
    $submittedPassword = $_POST['password'];
    $role = $_POST['role'];

    require_once 'db_connectie.php';
    $db = maakVerbinding();
    

    if ($role === 'passagier') {
        try {
            // Check if the submitted passagier username and password match the Gebruiker table
            $passagierQuery = "SELECT COUNT(*) AS count FROM Gebruiker WHERE gebruikersnaam = :username AND wachtwoord = :password";
            $passagierStatement = $db->prepare($passagierQuery);
            $passagierStatement->bindParam(':username', $submittedUsername);
            $passagierStatement->bindParam(':password', $submittedPassword);
            $passagierStatement->execute();
            $passagierResult = $passagierStatement->fetch(PDO::FETCH_ASSOC);
    
            if ($passagierResult['count'] === '1') {
                // Retrieve passagiernummer from Gebruiker table
                $passagiernummerQuery = "SELECT passagiernummer FROM Gebruiker WHERE gebruikersnaam = :username";
                $passagiernummerStatement = $db->prepare($passagiernummerQuery);
                $passagiernummerStatement->bindParam(':username', $submittedUsername);
                $passagiernummerStatement->execute();
                $passagiernummer = $passagiernummerStatement->fetchColumn();
    
                $_SESSION['username'] = $submittedUsername; // Set the passagier's name
                $_SESSION['type'] = 'passagier';
                $_SESSION['passagiernummer'] = $passagiernummer; // Store passagiernummer in the session
                // Redirect to the root directory upon successful login
                header('Location: /'); // Replace with the appropriate root URL
                exit();
            } else {
                $errorMessage = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            // Handle database error
            $errorMessage = 'An error occurred while checking credentials';
        }
    } elseif ($role === 'medewerker') {
        require_once 'db_connectie.php'; // Include the database connection code
        
        try {
            $db = maakVerbinding(); // Establish a database connection
            
            // Check if the submitted medewerker username and password match the Balie table
            $query = "SELECT COUNT(*) AS count FROM Balie WHERE balienummer = :username AND wachtwoord = :password";
            $statement = $db->prepare($query);
            $statement->bindParam(':username', $submittedUsername);
            $statement->bindParam(':password', $submittedPassword);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] === '1') {
                $_SESSION['username'] = $submittedUsername; // Set the medewerker's name
                $_SESSION['type'] = 'medewerker';
                // Redirect to the root directory upon successful login
                header('Location: /');
                exit();
            } else {
                $errorMessage = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            // Handle database error
            $errorMessage = 'An error occurred while checking credentials';
        }
    } else {
        $errorMessage = 'Invalid role';
    }
}
