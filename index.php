<?php
require_once 'db.php';
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Seznam klubov</title>
</head>
<body>

<?php include_once 'header.php'; ?>

<h2>Seznam klubov</h2>

<form method="GET" action="">
    <input type="text" name="search" placeholder="Išči klub ali lastnika" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
    <input type="submit" value="Išči">
</form>
<br>

<?php
$search = '';
if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = mysqli_real_escape_string($link, trim($_GET['search']));
    $sql = "
        SELECT id_c, name, date_of_establishent, owner, image
        FROM clubs
        WHERE name LIKE '%$search%' OR owner LIKE '%$search%'
        ORDER BY name
    ";
} else {
    $sql = "SELECT id_c, name, date_of_establishent, owner, image FROM clubs ORDER BY name";
}

$result = mysqli_query($link, $sql);
if (!$result) {
    die("Napaka v SQL: " . mysqli_error($link));
}
?>

<table border="1" cellpadding="6" cellspacing="0">
<tr>
    <th>Slika</th>
    <th>Ime kluba</th>
    <th>Datum ustanovitve</th>
    <th>Lastnik</th>
    <th>Podrobnosti</th>
</tr>

<?php
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    // Slika kluba
    if (!empty($row['image'])) {
        echo "<td><img src='img/clubs/" . htmlspecialchars($row['image']) . "' width='60' height='60' alt='Slika kluba'></td>";
    } else {
        echo "<td><img src='img/clubs/default.png' width='60' height='60' alt='Ni slike'></td>";
    }
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . ($row['date_of_establishent'] !== '0000-00-00' ? $row['date_of_establishent'] : 'Ni podatka') . "</td>";
    echo "<td>" . (!empty($row['owner']) ? htmlspecialchars($row['owner']) : 'Ni podatka') . "</td>";
    echo "<td><a href='club_detail.php?id=" . $row['id_c'] . "'>Poglej</a></td>";
    echo "</tr>";
}
?>

</table>

<br>

<?php include_once 'footer.php'; ?>
</body>
</html>
