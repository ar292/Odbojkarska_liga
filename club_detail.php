<?php
require 'db.php';
require 'header.php';

if (!isset($_GET['id'])) {
    echo "<p>Klub ni določen.</p>";
    require 'footer.php';
    exit();
}

$id = intval($_GET['id']);

// Podatki o klubu + slika
$sql = "SELECT name, date_of_establishent, owner, image FROM clubs WHERE id_c = $id";
$result = mysqli_query($link, $sql);
$club = mysqli_fetch_assoc($result);

if (!$club) {
    echo "<p>Klub ne obstaja.</p>";
    require 'footer.php';
    exit();
}

echo "<h2>" . htmlspecialchars($club['name']) . "</h2>";

// Slika kluba (če obstaja)
if (!empty($club['image'])) {
    echo "<p><img src='img/clubs/" . htmlspecialchars($club['image']) . "' height='160' style='border:1px solid #ccc; padding:5px;'></p>";
}

// Podatki o klubu
echo "<h3>Podatki o klubu</h3>";
echo "<table border='1' cellpadding='6' cellspacing='0'>";
echo "<tr><td><strong>Datum ustanovitve:</strong></td><td>" . ($club['date_of_establishent'] !== '0000-00-00' && $club['date_of_establishent'] !== null ? $club['date_of_establishent'] : 'Ni podatka') . "</td></tr>";
echo "<tr><td><strong>Lastnik:</strong></td><td>" . (!empty($club['owner']) ? htmlspecialchars($club['owner']) : 'Ni podatka') . "</td></tr>";
echo "</table><br>";

// Igralci v klubu
echo "<h3>Igralci v tem klubu</h3>";

$players_sql = "
    SELECT p.id_pl, p.name, p.position, p.image, AVG(r.value) AS avg_rating
    FROM players p
    LEFT JOIN rating r ON p.id_pl = r.id_p
    WHERE p.id_c = $id
    GROUP BY p.id_pl
    ORDER BY p.name
";

$players_result = mysqli_query($link, $players_sql);

if (mysqli_num_rows($players_result) === 0) {
    echo "<p>V tem klubu ni igralcev.</p>";
} else {
    echo "<table border='1' cellpadding='6' cellspacing='0'>";
    echo "<tr>
            <th>Slika</th>
            <th>Ime</th>
            <th>Pozicija</th>
            <th>Povprečna ocena</th>
            <th>Podrobnosti</th>
        </tr>";
    while ($row = mysqli_fetch_assoc($players_result)) {
        echo "<tr>";
        if (!empty($row['image'])) {
            echo "<td><img src='img/players/" . htmlspecialchars($row['image']) . "' width='70' height='70'></td>";
        } else {
            echo "<td>Ni slike</td>";
        }
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
        echo "<td>" . ($row['avg_rating'] !== null ? round($row['avg_rating'], 2) : "Ni ocen") . "</td>";
        echo "<td><a href='player_detail.php?id=" . $row['id_pl'] . "'>Poglej</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}

require 'footer.php';
?>
