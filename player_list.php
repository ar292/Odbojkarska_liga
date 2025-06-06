<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Seznam igralcev</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include_once 'header.php'; ?>

<h2>Seznam igralcev</h2>

<!-- Iskalna forma -->
<form method="GET" action="">
    <input type="text" name="search" placeholder="Išči igralca, pozicijo ali klub" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <input type="submit" value="Išči">
</form>

<?php
// Pripravi osnovni SQL
$search = '';
if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = mysqli_real_escape_string($link, trim($_GET['search']));

    // Poizvedba z iskalnim kriterijem po imenu, poziciji ali klubu (LIKE %search%)
    $sql = "
    SELECT p.id_pl, p.name, p.position, p.image, c.name AS club, AVG(r.value) AS avg_rating
    FROM players p
    LEFT JOIN clubs c ON p.id_c = c.id_c
    LEFT JOIN rating r ON p.id_pl = r.id_p
    WHERE p.name LIKE '%$search%' OR p.position LIKE '%$search%' OR c.name LIKE '%$search%'
    GROUP BY p.id_pl
    ORDER BY p.name
    ";
} else {
    // Osnovna poizvedba brez iskanja
    $sql = "
    SELECT p.id_pl, p.name, p.position, p.image, c.name AS club, AVG(r.value) AS avg_rating
    FROM players p
    LEFT JOIN clubs c ON p.id_c = c.id_c
    LEFT JOIN rating r ON p.id_pl = r.id_p
    GROUP BY p.id_pl
    ORDER BY p.name
    ";
}

$result = mysqli_query($link, $sql);

if (!$result) {
    die("Napaka v SQL: " . mysqli_error($link));
}
?>

<table border="1" cellpadding="5">
    <tr>
        <th>Slika</th>
        <th>Ime</th>
        <th>Pozicija</th>
        <th>Klub</th>
        <th>Povprečna ocena</th>
        <th>Podrobnosti</th>
    </tr>

<?php
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";

    // Slika
    if (!empty($row['image'])) {
        echo "<td><img src='img/players/" . htmlspecialchars($row['image']) . "' width='80' height='80'></td>";
    } else {
        echo "<td>Ni slike</td>";
    }

    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['position']) . "</td>";
    echo "<td>" . htmlspecialchars($row['club']) . "</td>";
    echo "<td>" . ($row['avg_rating'] !== null ? round($row['avg_rating'], 2) : "Ni ocen") . "</td>";
    echo "<td><a href='player_detail.php?id=" . $row['id_pl'] . "'>Podrobnosti</a></td>";
    echo "</tr>";
}
?>

</table>

<?php include_once 'footer.php'; ?>
</body>
</html>
