<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "dbconnect.php";

function showProducten(){
    $sql = "SELECT * FROM producten";
    $result = connect()->query($sql);
    $producten = $result->fetch_all();  
    return $producten;
}

function getCurrentUser()
{
    
    if (isset($_SESSION['user'])) {
        return $_SESSION['user'];
    } else {
        return null;
    }
}
function login($data) {
    if (isset($data['username']) && isset($data['password'])) {
        $username = $data['username'];
        $password = $data['password'];

        $conn = connect();

        if ($conn) {
            $uname = $conn->real_escape_string($username);
            $sql = "SELECT * FROM gebruikers WHERE gebruikersnaam = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $uname);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $gebruiker = $result->fetch_assoc();
                if (password_verify($password, $gebruiker['wachtwoord'])) {
                    $_SESSION['ingelogd'] = true;  
                    $_SESSION['user'] = $gebruiker;
                    header('Location: index.php');
                    exit;
                } else {
                    echo "Incorrect wachtwoord";
                }
            } else {
                echo "User niet gevonden";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Database connection niet gelukt";
        }
    }
}

function register($data) {
    if (!empty($data['gebruikersnaam']) && !empty($data['wachtwoord'])) {
        $gebruikersnaam = $data["gebruikersnaam"];
        $wachtwoord = password_hash($data["wachtwoord"], PASSWORD_DEFAULT);
        $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord) VALUES (?, ?)";

        try {
            $conn = connect();
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $gebruikersnaam, $wachtwoord);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            echo "Gebruiker Toegevoegd";
            performLogin($data);
        } catch (Exception $e) {
            $error = "Niet gelukt";
            die($error);
        }
    } else {
        echo "Vul beide velden in";
    }
}
function maken($data){
    if (!empty($data['naam']) && !empty($data['prijs']) && !empty($data['afbeelding']) && !empty($data['webshop'])) {
        $naam = $data["naam"];
        $prijs = $data["prijs"];
        $afbeelding = $data["afbeelding"];
        $webshop = $data["webshop"];

        try {
            $sql = "INSERT INTO producten (naam, prijs, afbeelding, webshop) VALUES ('$naam', '$prijs', '$afbeelding', '$webshop')";
            if (connect()->query($sql) === TRUE) {
                echo "Gebruiker Toegevoegd";
                header("Location: wishlist.php");
                exit();
            } else {
                echo "Fout bij toevoegen van gebruiker: " . connect()->error;
            }
            connect()->close();
        } catch (Exception $e) {
            $error = "Niet gelukt";
            die($error);
        }
    } else {
        echo "Vul alle velden in";
    }
}

function verwijderen($product_id){
    $conn = connect();
    $sql = "DELETE FROM producten WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    
    try {
        $stmt->execute();
        $stmt->close();
        echo "Product Verwijderd";
    } catch (Exception $e) {
        $error = "Fout bij verwijderen van product: " . $e->getMessage();
        die($error);
    } finally {
        $conn->close(); 
    }
}

?>
