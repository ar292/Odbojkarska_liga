<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$msg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT u.id_u, u.password, t.role 
            FROM users u 
            JOIN user_type t ON u.u_type_id = t.u_type_id 
            WHERE u.username = '$username'";

    $res = mysqli_query($link, $sql);

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id_u'];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];

           // preveri ce si asmin in preusmerja
            if ($row['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $msg = "Napačno geslo.";
        }
    } else {
        $msg = "Uporabnik ne obstaja.";
    }
}
?>

<?php include_once 'header.php'; ?>

<h2>Prijava</h2>
<?php if ($msg): ?>
    <p style="color:red;"><?php echo htmlspecialchars($msg); ?></p>
<?php endif; ?>

<form method="POST">
    Uporabniško ime:<br>
    <input type="text" name="username" required><br><br>

    Geslo:<br>
    <input type="password" name="password" required><br><br>

    <input type="submit" value="Prijavi se">
</form>

<a href="index.php">Nazaj na domov</a>

<?php include_once 'footer.php'; ?>
