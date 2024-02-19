<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "helper.php";



function registerUser($username, $password) {
    $conn = connect();

    if ($conn) {
        $uname = $conn->real_escape_string($username);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $uname, $hashedPassword);

        if ($stmt->execute()) {
            return true;
        } else {
            return "Registreren niet gelukt: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $result = registerUser($username, $password);

        if ($result === true) {
            echo "Gebruiker Toegevoegd";
        } else {
            echo $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <form action="" method="POST">
        Gebruikersnaam <input type="text" name="username"> <br>
        Wachtwoord <input type="password" name="password"> <br>
        <input type="submit" name="register" value="Register">
    </form>
</body>
</html>
