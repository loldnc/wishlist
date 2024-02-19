<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "helper.php";


 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    login($_POST);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <form class="login" method="POST">
        Gebruikersnaam <input type="text" name="username"> <br>
        Wachtwoord <input type="password" name="password"> <br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
