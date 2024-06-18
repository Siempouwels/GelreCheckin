<?php
 
session_start();

require_once 'db_connectie.php';
if(
    !isset($_SESSION['username']) ||
    !isset($_SESSION['type']) ||
    $_SESSION['type'] != 'medewerker'
) {
    header("Location: /");
    exit();
}

// Establish a database connection (replace with your actual connection code)
$db = maakVerbinding();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get data from the form
    $vluchtnummer = $_POST["vluchtnummer"];
    $bestemming = $_POST["bestemming"];
    $gatecode = $_POST["gatecode"];
    $max_aantal = $_POST["max_aantal"];
    $max_gewicht_pp = $_POST["max_gewicht_pp"];
    $max_totaalgewicht = $_POST["max_totaalgewicht"];
    $vertrektijd_input = $_POST["vertrektijd"];
    $maatschappijcode = $_POST["maatschappijcode"];

    // Format the datetime value
    $vertrektijd = new DateTime($vertrektijd_input);
    $formatted_vertrektijd = $vertrektijd->format('Y-m-d H:i:s');

    try {
        // Insert new flight data into the database
        $query = "INSERT INTO Vlucht (vluchtnummer, bestemming, gatecode, max_aantal, max_gewicht_pp, max_totaalgewicht, vertrektijd, maatschappijcode)
                  VALUES (:vluchtnummer, :bestemming, :gatecode, :max_aantal, :max_gewicht_pp, :max_totaalgewicht, :vertrektijd, :maatschappijcode)";
        $statement = $db->prepare($query);
        $statement->bindParam(':vluchtnummer', $vluchtnummer);
        $statement->bindParam(':bestemming', $bestemming);
        $statement->bindParam(':gatecode', strtoupper($gatecode));
        $statement->bindParam(':max_aantal', $max_aantal);
        $statement->bindParam(':max_gewicht_pp', $max_gewicht_pp);
        $statement->bindParam(':max_totaalgewicht', $max_totaalgewicht);
        $statement->bindParam(':vertrektijd', $formatted_vertrektijd);
        $statement->bindParam(':maatschappijcode', $maatschappijcode);
        $statement->execute();

        // Redirect to the flight overview page after successful insertion
        header("Location: vluchten-overzicht.php");
        exit();
    } catch (PDOException $e) {
        // Handle database error
        echo "Error inserting new flight: " . $e->getMessage();
    }
}

// Retrieve data for dropdowns
try {
    $luchthavensQuery = "SELECT DISTINCT luchthavencode FROM IncheckenBestemming";
    $luchthavensResult = $db->query($luchthavensQuery);
    $luchthavens = $luchthavensResult->fetchAll(PDO::FETCH_COLUMN);

    $maatschappijenQuery = "SELECT maatschappijcode FROM IncheckenMaatschappij";
    $maatschappijenResult = $db->query($maatschappijenQuery);
    $maatschappijen = $maatschappijenResult->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    // Handle database error
    echo "Error retrieving dropdown data: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once 'components/head.php'; ?>
    <title>Gelre Checkin - Nieuwe Vlucht Toevoegen</title>
    <link rel="stylesheet" href="assets/css/nieuwe-vlucht.css">
</head>

<body>
    <?php include_once 'components/navbar.php'; ?>

    <div class="form-card">
        <h1>Nieuwe Vlucht Toevoegen</h1>
        <form action="/nieuwe-vlucht.php" method="POST">
            <label for="vluchtnummer">Vluchtnummer:</label>
            <input type="text" id="vluchtnummer" name="vluchtnummer" required><br>

            <label for="bestemming">Bestemming:</label>
            <select id="bestemming" name="bestemming" required>
                <?php foreach ($luchthavens as $luchthaven) : ?>
                    <option value="<?= $luchthaven ?>"><?= $luchthaven ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="gatecode">Gate:</label>
            <input type="text" id="gatecode" name="gatecode" required><br>

            <label for="max_aantal">Maximaal Aantal Passagiers:</label>
            <input type="number" id="max_aantal" name="max_aantal" required><br>

            <label for="max_gewicht_pp">Maximaal Gewicht per Passagier:</label>
            <input type="number" step="0.01" id="max_gewicht_pp" name="max_gewicht_pp" required><br>

            <label for="max_totaalgewicht">Maximaal Totaalgewicht:</label>
            <input type="number" step="0.01" id="max_totaalgewicht" name="max_totaalgewicht" required><br>

            <label for="vertrektijd">Vertrektijd:</label>
            <input type="datetime-local" id="vertrektijd" name="vertrektijd" required><br>

            <label for="maatschappijcode">Maatschappij:</label>
            <select id="maatschappijcode" name="maatschappijcode" required>
                <?php foreach ($maatschappijen as $maatschappij) : ?>
                    <option value="<?= $maatschappij ?>"><?= $maatschappij ?></option>
                <?php endforeach; ?>
            </select><br>

            <button type="submit">Vlucht Toevoegen</button>
        </form>
    </div>
</body>

</html>