<?php
require_once 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $geslo = password_hash($_POST['geslo'], PASSWORD_DEFAULT);

    
    $tipResult = mysqli_query($link, "SELECT u_type_id FROM user_type WHERE role = 'user'");
    $row = mysqli_fetch_assoc($tipResult);
    $u_type_id = $row['u_type_id'];


    $check = mysqli_query($link, "SELECT id_u FROM users WHERE username = '$username'");
    if (mysqli_num_rows($check) > 0) {
        echo "<p>Uporabniško ime že obstaja.</p>";
        header("refresh:3;url=registracija.php");
        exit();
    }


    $sql = "INSERT INTO users (username, email, password, u_type_id)
            VALUES ('$username', '$email', '$geslo', $u_type_id)";

    if (mysqli_query($link, $sql)) {
        echo "<p>Uspešno registriran. Preusmerjanje na prijavo...</p>";
        header("refresh:2;url=login.php");
    } else {
        echo "<p>Napaka: " . mysqli_error($link) . "</p>";
        header("refresh:4;url=registracija.php");
    }
}
?>
