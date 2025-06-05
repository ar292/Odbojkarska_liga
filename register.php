<?php
require_once 'db.php';
?>
<?php include_once 'header.php'; ?>

<h2>Registracija</h2>
<form method="post" action="registracija_v_bazo.php">
    Uporabniško ime:<br>
    <input type="text" name="username" required><br><br>

    Email:<br>
    <input type="email" name="email" required><br><br>

    Geslo:<br>
    <input type="password" name="geslo" required><br><br>

    <input type="submit" name="submit" value="Registriraj se">
</form>

<a href="index.php">Nazaj na domov</a>

<?php include_once 'footer.php'; ?>
