<?php
// Povezava z bazo
$conn = new mysqli("localhost", "tpofitnes_tposkupina", "fujsjelegenda", "tpofitnes_projekt");

if ($conn->connect_error) {
    die("Povezava z bazo ni uspela: " . $conn->connect_error);
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST["Email"]));
        $geslo = mysqli_real_escape_string($conn, htmlspecialchars($_POST["Geslo"]));

        if (empty($email) || empty($geslo)) {
            echo "<script>
                alert('Vsa polja morajo biti izpolnjena!');
                window.location.href = 'StranLogin.htm';
            </script>";
            exit();
        }

        if (!preg_match('/^.{8,20}$/', $geslo)) {
            echo "<script>
                alert('Geslo mora biti dolgo vsaj 8 znakov in manj kot 20!');
                window.location.href = 'StranLogin.htm';
            </script>";
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>
                alert('Napačen format e-pošte!');
                window.location.href = 'StranLogin.htm';
            </script>";
            exit();
        }

        $hashgeslo = hash('sha256', $geslo);
        $sql = "SELECT * FROM clan WHERE Geslo=? AND Email=? LIMIT 1";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Napaka pri pripravi poizvedbe: " . $conn->error);
        }

        $stmt->bind_param("ss", $hashgeslo, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            session_start();
            $user = $result->fetch_assoc();
            $_SESSION["Ime"] = $user["Ime"];
            $_SESSION["Priimek"] = $user["Priimek"];
            $_SESSION["prijavljen"] = TRUE;
            $_SESSION["ID"] = $user["ID_Clan"];
            echo "<script>
                alert('Prijava je uspešna!');
                window.location.href = 'Dobrodosli.php';
            </script>";
            exit();
        } else {
            echo "<script>
                alert('Prijava ni uspešna! Poskusite znova.');
                window.location.href = 'StranLogin.htm';
            </script>";
            exit();
        }
    }
} 

finally
{
    // Zapiranje povezave z bazo
    if ($conn) {
        $stmt->close();
        $conn->close();
    }
}
?>