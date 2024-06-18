<?php
session_start();
require_once 'db_connectie.php';

// Establish a database connection (replace with your actual connection code)
$db = maakVerbinding();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $flightNumber = $_POST["flightNumber"];

    try {
        // Query the database to retrieve relevant flight information
        $query = "SELECT * FROM Vlucht WHERE vluchtnummer = :flightNumber";
        $statement = $db->prepare($query);
        $statement->bindParam(':flightNumber', $flightNumber);
        $statement->execute();
        $flight = $statement->fetch(PDO::FETCH_ASSOC);
        var_dump($flight);
    } catch (PDOException $e) {
        // Handle database error
        echo "Error retrieving flight information: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zelf-service Inchecken - Gelre Checkin</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>Zelf-service Inchecken - Gelre Checkin</h1>
    </header>

    <main>
        <section class="check-in-section">
            <h2>Inchecken</h2>
            <form action="zelf-inchecken.php" method="post">
                <label for="flightNumber">Vluchtnummer:</label>
                <input type="text" id="flightNumber" name="flightNumber" required>
                <button type="submit">Inchecken</button>
            </form>
        </section>

        <?php if (isset($flight)) : ?>
            <?php var_dump($flight) ?>
            <section class="flight-details-section">
                <h2>Details voor vlucht <?php echo $flightNumber; ?></h2>
                <p>Bestemming: <?php echo $flight['bestemming']; ?></p>
                <p>Vertrektijd: <?php echo $flight['vertrektijd']; ?></p>
                <!-- Add more flight details as needed -->
            </section>
        <?php endif; ?>
    </main>
</body>

</html>