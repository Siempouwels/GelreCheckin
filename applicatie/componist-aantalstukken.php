<?php
require_once 'db_connectie.php';

// Maak verbinding met de database (zie db_connection.php)
$db = maakVerbinding();

// Haal alle componisten op en tel het aantal stukken
$query = 'SELECT * FROM Luchthaven';

$data = $db->query($query);

// Check if the query was successful
if ($data) {
    // Fetch the data and iterate through the results
    while ($row = $data->fetch(PDO::FETCH_ASSOC)) {
        // Now you can access individual columns of the result
        $luchthavencode = $row['luchthavencode'];
        $naam = $row['naam'];
        $land = $row['land'];

        // Do something with the data, e.g., print it
        echo "Luchthavencode: $luchthavencode, Naam: $naam, Land: $land<br>";
    }
} else {
    // Handle error if the query was not successful
    echo "Query failed: " . print_r($db->errorInfo(), true);
}

// Close the database connection
$db = null;
?>
