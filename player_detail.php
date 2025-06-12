<?php
require 'db.php';
require 'header.php';

if (!isset($_GET['id'])) {
    echo "<p>Igralec ni določen.</p>";
    require 'footer.php';
    exit();
}

$id = intval($_GET['id']);

// Osnovni podatki o igralcu
$sql = "SELECT p.name, p.position, p.height, p.max_spike_reach, p.max_block_reach, p.weight, p.image, c.name AS club
        FROM players p
        LEFT JOIN clubs c ON p.id_c = c.id_c
        WHERE p.id_pl = $id";
$result = mysqli_query($link, $sql);
$player = mysqli_fetch_assoc($result);

if (!$player) {
    echo "<p>Igralec ne obstaja.</p>";
    require 'footer.php';
    exit();
}

echo "<h2>" . htmlspecialchars($player['name']) . "</h2>";

// Slika igralca (če obstaja)
if (!empty($player['image'])) {
    echo "<p><img src='img/players/" . htmlspecialchars($player['image']) . "' height='160' style='border:1px solid #ccc; padding:5px;'></p>";
}

// Osnovni podatki
echo "<h3>Osnovni podatki</h3>";
echo "<table border='1' cellpadding='6' cellspacing='0'>";
echo "<tr><td><strong>Pozicija:</strong></td><td>" . htmlspecialchars($player['position']) . "</td></tr>";
echo "<tr><td><strong>Klub:</strong></td><td>" . htmlspecialchars($player['club']) . "</td></tr>";
echo "<tr><td><strong>Višina:</strong></td><td>" . htmlspecialchars($player['height']) . " cm</td></tr>";
echo "<tr><td><strong>Max Spike Reach:</strong></td><td>" . htmlspecialchars($player['max_spike_reach']) . " cm</td></tr>";
echo "<tr><td><strong>Max Block Reach:</strong></td><td>" . htmlspecialchars($player['max_block_reach']) . " cm</td></tr>";
echo "<tr><td><strong>Teža:</strong></td><td>" . htmlspecialchars($player['weight']) . " kg</td></tr>";
echo "</table><br>";

// Statistika igralca
echo "<h3>Statistika</h3>";
$stats_sql = "SELECT * FROM stats WHERE id_p = $id";
$stats_result = mysqli_query($link, $stats_sql);

if (!$stats_result) {
    echo "<p style='color:red;'>Napaka pri pridobivanju statistike: " . mysqli_error($link) . "</p>";
} else {
    $stats = mysqli_fetch_assoc($stats_result);
    if (!$stats) {
        echo "<p>Za tega igralca ni statistike.</p>";
    } else {
        echo "<table border='1' cellpadding='6' cellspacing='0'>";
        echo "<tr><td><strong>As servisi:</strong></td><td>" . htmlspecialchars($stats['aces'] ?? '0') . "</td></tr>";
        echo "<tr><td><strong>Točke:</strong></td><td>" . htmlspecialchars($stats['points'] ?? '0') . "</td></tr>";
        echo "<tr><td><strong>Napake pri podajah:</strong></td><td>" . htmlspecialchars($stats['passing_errors'] ?? '0') . "</td></tr>";
        echo "<tr><td><strong>Napake pri napadih:</strong></td><td>" . htmlspecialchars($stats['hitting_errors'] ?? '0') . "</td></tr>";
        echo "</table><br>";
    }
}

// Povprečna ocena
$res = mysqli_query($link, "SELECT AVG(value) as povp FROM rating WHERE id_p = $id");
$avg = mysqli_fetch_assoc($res)['povp'];
echo "<p><strong>Povprečna ocena:</strong> " . ($avg ? round($avg, 2) : "Še ni ocen") . "</p>";

// Obrazec za oceno in komentar
if (isset($_SESSION['user_id'])) {
    if (isset($_POST['submit_feedback'])) {
        $uid = $_SESSION['user_id'];
        $val = intval($_POST['ocena']);
        $komentar = trim($_POST['komentar']);

        $chk = mysqli_query($link, "SELECT * FROM rating WHERE id_u=$uid AND id_p=$id");
        if (mysqli_num_rows($chk) == 0 && $val >= 1 && $val <= 5) {
            mysqli_query($link, "INSERT INTO rating (id_u, id_p, value) VALUES ($uid, $id, $val)");
            echo "<p style='color:green;'>Hvala za oceno!</p>";
        } else {
            echo "<p style='color:red;'>Igralca si že ocenil ali ocena ni veljavna.</p>";
        }

        if (!empty($komentar)) {
            $komentar_safe = mysqli_real_escape_string($link, $komentar);
            mysqli_query($link, "INSERT INTO comments (id_u, id_p, content, date_of_creation) VALUES ($uid, $id, '$komentar_safe', NOW())");
            echo "<p style='color:green;'>Hvala za komentar!</p>";
        }
    }

    echo "<h3>Oddaj oceno in komentar</h3>
    <form method='POST'>
        Ocena (1–5): <input type='number' name='ocena' min='1' max='5' required><br><br>
        Komentar:<br>
        <textarea name='komentar' rows='4' cols='50'></textarea><br><br>
        <button type='submit' name='submit_feedback'>Pošlji</button>
    </form>";
} else {
    echo "<p>Za oddajo ocene in komentarja se morate prijaviti.</p>";
}

// Komentarji
echo "<hr><h3>Komentarji</h3>";
$res = mysqli_query($link, "SELECT c.content, c.date_of_creation, u.username 
                          FROM comments c 
                          JOIN users u ON c.id_u = u.id_u 
                          WHERE c.id_p = $id 
                          ORDER BY c.date_of_creation DESC");
if (mysqli_num_rows($res) == 0) {
    echo "<p>Ni komentarjev.</p>";
} else {
    while ($c = mysqli_fetch_assoc($res)) {
        echo "<p><strong>" . htmlspecialchars($c['username']) . "</strong> (" . $c['date_of_creation'] . "):<br>";
        echo (htmlspecialchars($c['content'])) . "</p><hr>";
    }
}

require 'footer.php';
?>
