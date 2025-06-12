<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Admin plošča</title>
</head>
<body>

<?php
include_once 'header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<p>Dostop zavrnjen. Samo admin lahko vidi to stran.</p>";
    include 'footer.php';
    exit();
}

// BRISANJE IGRALCA
if (isset($_POST['delete_player'])) {
    $id = (int)$_POST['id_pl'];
    mysqli_query($link, "DELETE FROM rating WHERE id_p = $id");
    mysqli_query($link, "DELETE FROM comments WHERE id_p = $id");
    mysqli_query($link, "DELETE FROM stats WHERE id_p = $id");
    mysqli_query($link, "DELETE FROM players WHERE id_pl = $id");
    echo "<p>Igralec izbrisan.</p>";
}

// BRISANJE KLUBA
if (isset($_POST['delete_club'])) {
    $id = (int)$_POST['id_c'];
    $players = mysqli_query($link, "SELECT id_pl FROM players WHERE id_c = $id");
    while ($p = mysqli_fetch_assoc($players)) {
        $pid = (int)$p['id_pl'];
        mysqli_query($link, "DELETE FROM rating WHERE id_p = $pid");
        mysqli_query($link, "DELETE FROM comments WHERE id_p = $pid");
        mysqli_query($link, "DELETE FROM stats WHERE id_p = $pid");
        mysqli_query($link, "DELETE FROM players WHERE id_pl = $pid");
    }
    mysqli_query($link, "DELETE FROM clubs WHERE id_c = $id");
    echo "<p>Klub izbrisan.</p>";
}

// DODAJ KLUB
if (isset($_POST['dodaj_klub'])) {
    $ime = mysqli_real_escape_string($link, $_POST['ime_kluba']);
    $datum = !empty($_POST['datum']) ? $_POST['datum'] : null;
    $lastnik = mysqli_real_escape_string($link, $_POST['lastnik']);
    $slika = '';

    if (!empty($_FILES['slika_kluba']['name'])) {
        $slika = basename($_FILES['slika_kluba']['name']);
        move_uploaded_file($_FILES['slika_kluba']['tmp_name'], "img/clubs/" . $slika);
    }

    $sql = "INSERT INTO clubs (name, date_of_establishent, owner, image) VALUES ('$ime', " . ($datum ? "'$datum'" : "NULL") . ", '$lastnik', '$slika')";
    mysqli_query($link, $sql);
    echo "<p>Klub dodan.</p>";
}

// DODAJ IGRALCA
if (isset($_POST['dodaj_igralca'])) {
    $ime = mysqli_real_escape_string($link, $_POST['ime']);
    $poz = mysqli_real_escape_string($link, $_POST['pozicija']);
    $visina = (int)$_POST['visina'];
    $teza = (int)$_POST['teza'];
    $spike = (int)$_POST['spike'];
    $block = (int)$_POST['block'];
    $klub = (int)$_POST['klub'];
    $slika = '';

    if (!empty($_FILES['slika']['name'])) {
        $slika = basename($_FILES['slika']['name']);
        move_uploaded_file($_FILES['slika']['tmp_name'], "img/players/" . $slika);
    }

    $sql = "INSERT INTO players (name, position, height, weight, max_spike_reach, max_block_reach, id_c, image)
            VALUES ('$ime', '$poz', $visina, $teza, $spike, $block, $klub, '$slika')";
    mysqli_query($link, $sql);
    echo "<p>Igralec dodan.</p>";
}

// DODAJ STATISTIKO
if (isset($_POST['dodaj_statistiko'])) {
    $id_igr = (int)$_POST['id_igralca'];
    $aces = (int)$_POST['aces'];
    $points = (int)$_POST['points'];
    $pass_err = (int)$_POST['passing_errors'];
    $hit_err = (int)$_POST['hitting_errors'];

    if ($aces < 0 || $points < 0 || $pass_err < 0 || $hit_err < 0) {
        echo "<p>Statistika ne sme vsebovati negativnih vrednosti.</p>";
    } else {
        $obstaja = mysqli_query($link, "SELECT * FROM stats WHERE id_p = $id_igr");
        if (mysqli_num_rows($obstaja) == 0) {
            $sql = "INSERT INTO stats (id_p, aces, points, passing_errors, hitting_errors)
                    VALUES ($id_igr, $aces, $points, $pass_err, $hit_err)";
            mysqli_query($link, $sql);
            echo "<p>Statistika dodana.</p>";
        } else {
            echo "<p>Statistika za tega igralca že obstaja.</p>";
        }
    }
}

// POSODOBI STATISTIKO
if (isset($_POST['posodobi_statistiko'])) {
    $id_igr = (int)$_POST['id_igralca'];
    $aces = (int)$_POST['aces'];
    $points = (int)$_POST['points'];
    $pass_err = (int)$_POST['passing_errors'];
    $hit_err = (int)$_POST['hitting_errors'];

    if ($aces < 0 || $points < 0 || $pass_err < 0 || $hit_err < 0) {
        echo "<p>Statistika ne sme vsebovati negativnih vrednosti.</p>";
    } else {
        $sql = "UPDATE stats SET aces = $aces, points = $points, passing_errors = $pass_err, hitting_errors = $hit_err WHERE id_p = $id_igr";
        mysqli_query($link, $sql);
        echo "<p>Statistika posodobljena.</p>";
    }
}
?>

<h2>Dodaj klub</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="ime_kluba" placeholder="Ime kluba" required><br><br>
    Datum ustanovitve: <input type="date" name="datum"><br><br>
    Lastnik: <input type="text" name="lastnik"><br><br>
    Logo/slika: <input type="file" name="slika_kluba"><br><br>
    <input type="submit" name="dodaj_klub" value="Dodaj">
</form>

<h2>Dodaj igralca</h2>
<form method="POST" enctype="multipart/form-data">
    Ime: <input type="text" name="ime" required><br>
    <label>Pozicija:</label><br>
    <select name="pozicija" required>
        <option value="">-- Izberi pozicijo --</option>
        <option value="Podajalec">Podajalec</option>
        <option value="Srednji bloker">Srednji bloker</option>
        <option value="Korektor">Korektor</option>
        <option value="Sprejemalec">Sprejemalec</option>
        <option value="Libero">Libero</option>
        <option value="Univerzalec">Univerzalec</option>
    </select><br>
    Višina: <input type="number" name="visina"><br>
    Teža: <input type="number" name="teza"><br>
    Max spike: <input type="number" name="spike"><br>
    Max block: <input type="number" name="block"><br>
    Slika: <input type="file" name="slika"><br>
    Klub:
    <select name="klub" required>
        <?php
        $klubi = mysqli_query($link, "SELECT * FROM clubs");
        while ($k = mysqli_fetch_assoc($klubi)) {
            echo "<option value='" . $k['id_c'] . "'>" . htmlspecialchars($k['name']) . "</option>";
        }
        ?>
    </select><br>
    <input type="submit" name="dodaj_igralca" value="Dodaj igralca">
</form>

<h2>Statistika</h2>

<h3>Dodaj statistiko igralcu</h3>
<form method="POST">
    Igralec:
    <select name="id_igralca" required>
        <?php
        $igralci = mysqli_query($link, "SELECT p.id_pl, p.name FROM players p LEFT JOIN stats s ON p.id_pl = s.id_p WHERE s.id_p IS NULL ORDER BY p.name");
        while ($igr = mysqli_fetch_assoc($igralci)) {
            echo "<option value='" . $igr['id_pl'] . "'>" . htmlspecialchars($igr['name']) . "</option>";
        }
        ?>
    </select><br><br>
    As servisi: <input type="number" name="aces" min="0" required><br>
    Točke: <input type="number" name="points" min="0" required><br>
    Napake pri podajah: <input type="number" name="passing_errors" min="0" required><br>
    Napake pri napadih: <input type="number" name="hitting_errors" min="0" required><br><br>
    <input type="submit" name="dodaj_statistiko" value="Dodaj statistiko">
</form>

<h3>Uredi statistiko</h3>
<form method="POST">
    Igralec:
    <select name="id_igralca" required>
        <?php
        $igralci = mysqli_query($link, "SELECT p.id_pl, p.name, s.aces, s.points, s.passing_errors, s.hitting_errors 
                                      FROM players p 
                                      JOIN stats s ON p.id_pl = s.id_p 
                                      ORDER BY p.name");
        while ($igr = mysqli_fetch_assoc($igralci)) {
            echo "<option value='" . $igr['id_pl'] . "'";
            if (isset($_POST['id_igralca']) && $_POST['id_igralca'] == $igr['id_pl']) {
                echo " selected";
            }
            echo ">" . htmlspecialchars($igr['name']) . "</option>";
        }
        ?>
    </select><br><br>
    
    <?php
    if (isset($_POST['id_igralca']) || isset($_GET['id'])) {
        $id_igr = isset($_POST['id_igralca']) ? (int)$_POST['id_igralca'] : (int)$_GET['id'];
        $statistika = mysqli_query($link, "SELECT * FROM stats WHERE id_p = $id_igr");
        $stat = mysqli_fetch_assoc($statistika);
        
        if ($stat) {
            echo "As servisi: <input type='number' name='aces' value='" . $stat['aces'] . "' min='0'><br>";
            echo "Točke: <input type='number' name='points' value='" . $stat['points'] . "' min='0'><br>";
            echo "Napake pri podajah: <input type='number' name='passing_errors' value='" . $stat['passing_errors'] . "' min='0'><br>";
            echo "Napake pri napadih: <input type='number' name='hitting_errors' value='" . $stat['hitting_errors'] . "' min='0'><br><br>";
        }
    } else {
        echo "As servisi: <input type='number' name='aces' min='0'><br>";
        echo "Točke: <input type='number' name='points' min='0'><br>";
        echo "Napake pri podajah: <input type='number' name='passing_errors' min='0'><br>";
        echo "Napake pri napadih: <input type='number' name='hitting_errors' min='0'><br><br>";
    }
    ?>
    <input type="submit" name="posodobi_statistiko" value="Posodobi statistiko">
</form>

<h2>Obstoječi igralci</h2>
<table border="1">
<tr><th>ID</th><th>Ime</th><th>Pozicija</th><th>Akcija</th></tr>
<?php
$igralci = mysqli_query($link, "SELECT * FROM players ORDER BY name");
while ($i = mysqli_fetch_assoc($igralci)) {
    echo "<tr>";
    echo "<td>" . $i['id_pl'] . "</td>";
    echo "<td>" . htmlspecialchars($i['name']) . "</td>";
    echo "<td>" . htmlspecialchars($i['position']) . "</td>";
    echo "<td>
        <form method='POST'>
            <input type='hidden' name='id_pl' value='" . $i['id_pl'] . "'>
            <input type='submit' name='delete_player' value='Izbriši'>
        </form>
    </td>";
    echo "</tr>";
}
?>
</table>

<h2>Obstoječi klubi</h2>
<table border="1">
<tr><th>ID</th><th>Ime kluba</th><th>Akcija</th></tr>
<?php
$klubi = mysqli_query($link, "SELECT * FROM clubs ORDER BY name");
while ($k = mysqli_fetch_assoc($klubi)) {
    echo "<tr>";
    echo "<td>" . $k['id_c'] . "</td>";
    echo "<td>" . htmlspecialchars($k['name']) . "</td>";
    echo "<td>
        <form method='POST'>
            <input type='hidden' name='id_c' value='" . $k['id_c'] . "'>
            <input type='submit' name='delete_club' value='Izbriši'>
        </form>
    </td>";
    echo "</tr>";
}
?>
</table>

<?php include_once 'footer.php'; ?>
</body>
</html>
