<?php
session_start();
require_once 'db_connectie.php';

// Establish a database connection (replace with your actual connection code)
$db = maakVerbinding();

$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'vluchtnummer';
$sortOrder = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'asc' : 'desc';
$toggleOrder = $sortOrder === 'asc' ? 'desc' : 'asc';

try {
    // Query the database to retrieve all flight information
    $query = "SELECT * FROM Vlucht ORDER BY $sortBy $sortOrder";
    $result = $db->query($query);
    $flights = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database error
    echo "Error retrieving flight information: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once 'components/head.php'; ?>
    <title>Gelre Checkin - Overzicht van Vluchten</title>
    <link rel="stylesheet" href="assets/css/vluchten-overzicht.css">
</head>

<body>
    <?php include_once 'components/navbar.php'; ?>
    <h1>Overzicht van Vluchten</h1>

    <?php if (!empty($flights)): ?>
        <div class="table-wrapper">
            <table>
                <tr>
                    <th>Vluchtnummer</th>
                    <th><a href="?sort=bestemming&order=<?= $toggleOrder ?>">Bestemming</a></th>
                    <th><a href="?sort=vertrektijd&order=<?= $toggleOrder ?>">Vertrektijd</a></th>
                    <th>Gate</th>
                    <th>Maximaal Aantal Passagiers</th>
                    <th>Maximaal Gewicht per Passagier</th>
                    <th>Maximaal Totaalgewicht</th>
                    <th>Maatschappij</th>
                </tr>
                <?php foreach ($flights as $flight): ?>
                    <tr>
                        <td><a href="detail.php?vluchtnummer=<?= $flight['vluchtnummer'] ?>"><?= $flight['vluchtnummer'] ?></a></td>
                        <td><?= $flight['bestemming'] ?></td>
                        <td><?= $flight['vertrektijd'] ?></td>
                        <td><?= $flight['gatecode'] ?></td>
                        <td><?= $flight['max_aantal'] ?></td>
                        <td><?= $flight['max_gewicht_pp'] ?></td>
                        <td><?= $flight['max_totaalgewicht'] ?></td>
                        <td><?= $flight['maatschappijcode'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php else: ?>
        <p>Geen vluchten gevonden.</p>
    <?php endif; ?>
</body>

</html>
