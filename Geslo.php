<?php
// Povezava z bazo
$conn = new mysqli("localhost", "tpofitnes_tposkupina", "fujsjelegenda", "tpofitnes_projekt");

if ($conn->connect_error) {
    die("Unable to connect to database: " . $conn->connect_error);
}

// Spremenljivka za prikaz sporočil
$message = "";

try {
    // Preveri, če je obrazec poslan
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Pridobi podatke iz obrazca
        $geslo = mysqli_real_escape_string($conn, htmlspecialchars($_POST["Geslo"]));
        $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST["Email"]));

        // Preveri, ali so polja prazna
        if (empty($geslo) || empty($email)) {
            $message = "Vsa polja morajo biti izpolnjena!";
            echo "<script>
            alert('$message');
            window.location.href = 'StranRegister.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
            </script>";
            exit();
        }

        // Preveri geslo
        elseif (!preg_match('/^.{8,20}$/', $geslo)) {
            $message = "Geslo mora vsebovati vsaj 8 znakov!";
            echo "<script>
            alert('$message');
            window.location.href = 'StranRegister.htm'; // Preusmeritev na ustrezno stran
            </script>";
            exit();
        }

        // Preveri, ali je email v pravilnem formatu
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "Napačen format e-pošte!";
            echo "<script>
            alert('$message');
            window.location.href = 'StranRegister.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
            </script>";
            exit();
        }

        else {
            $hashgeslo = hash('sha256', $geslo);

            // Preveri, ali uporabnik že obstaja
            $sql_check = "SELECT * FROM clan WHERE Email = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($result_check->num_rows > 0) {
                // Posodobi geslo, ker uporabnik obstaja
                $sql = "UPDATE clan SET Geslo=? WHERE Email=?";
                $stmt = $conn->prepare($sql);

                if ($stmt === false) {
                    die("Napaka pri pripravi poizvedbe: " . $conn->error);
                }

                $stmt->bind_param("ss", $hashgeslo, $email);

                if ($stmt->execute()) {
                    $message = "Posodobitev gesla je uspešna!";
                    echo "<script>
                    alert('$message');
                    window.location.href = 'StranLogin.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
                    </script>";
                    exit();
                } else {
                    $message = "Posodobitev gesla ni uspešna!";
                    echo "<script>
                    alert('$message');
                    window.location.href = 'StranRegister.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
                    </script>";
                    exit();
                }
            } else {
                $message = "Uporabnik z vpisanim elektronskim naslovom ne obstaja!";
                echo "<script>
                alert('$message');
                window.location.href = 'StranGeslo.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
                </script>";
                exit();
            }
        }
    }
}
finally {
    // Zapiranje povezave z bazo
    if (isset($stmt_check) && $stmt_check !== false) {
        $stmt_check->close();
    }
    if (isset($stmt) && $stmt !== false) {
        $stmt->close();
    }
    if ($conn) {
        $conn->close();
    }
}
?>
