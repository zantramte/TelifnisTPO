<?php
// Povezava z bazo
$conn = new mysqli("localhost", "tpofitnes_tposkupina", "fujsjelegenda", "tpofitnes_projekt");

if ($conn->connect_error) {
    die("Unable to connect to database: " . $conn->connect_error);
}

// Spremenljivka za prikaz sporočil
$message = "";

try
{
// Preveri, če je obrazec poslan
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Pridobi podatke iz obrazca
    $FirstName = mysqli_real_escape_string($conn, htmlspecialchars($_POST["FirstName"]));
    $LastName = mysqli_real_escape_string($conn, htmlspecialchars($_POST["LastName"]));
    $geslo = mysqli_real_escape_string($conn, htmlspecialchars($_POST["Geslo"]));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($_POST["Email"]));
    $Telefon = mysqli_real_escape_string($conn, htmlspecialchars($_POST["Telefon"]));
    

    // Preveri, ali so polja prazna
    if (empty($FirstName) || empty($LastName) || empty($geslo) || empty($email) || empty($Telefon))
    {
        $message = "Vsa polja morajo biti izpolnjena!";
        echo "<script>
        alert('$message');
        window.location.href = 'StranRegister.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
    </script>";
    exit();
    }
    
    
    elseif (!preg_match('/^.{8,20}$/', $geslo)) 
    {
    $message = "Geslo mora biti dolgo vsaj 8 znakov in manj kot 20!";
    echo "<script>
    alert('$message');
    window.location.href = 'StranRegister.htm'; // Preusmeritev na ustrezno stran
    </script>";
    exit();
    }
    
    
    // Preveri, ali je email v pravilnem formatu
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $message = "Napačen format e-pošte!";
        echo "<script>
        alert('$message');
        window.location.href = 'StranRegister.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
    </script>";
    exit();
    }
    
    
    else
    {
        $hashgeslo = hash('sha256', $geslo);
        // Preveri, ali uporabnik že obstaja
        $sql_check = "SELECT * FROM clan WHERE Email = ? OR Telefon = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ss", $email, $Telefon);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0)
        {
            // Nastavi sporočilo o napaki
            $message = "Uporabnik z danimi podatki že obstaja. Poskusite z drugimi podatki!";
             echo "<script>
        alert('$message');
        window.location.href = 'StranRegister.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
    </script>";
    exit();
        } 
        
        
        else
        {
            // Vstavi podatke v bazo
            $sql = "INSERT INTO clan (Ime, Priimek, Geslo, Email, Telefon) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die("Napaka pri pripravi poizvedbe: " . $conn->error);
            }

            $stmt->bind_param("sssss", $FirstName, $LastName, $hashgeslo, $email, $Telefon);

            if ($stmt->execute()) 
            {
                // Nastavi sporočilo o uspehu
                $message = "Registracija je uspešna!";
                    echo "<script>
        alert('$message');
        window.location.href = 'StranLogin.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
    </script>";
    exit();
            } 
            
            else
            {
                $message = "Napaka pri registraciji. Poskusite znova.";
                    echo "<script>
        alert('$message');
        window.location.href = 'StranRegister.htm'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
    </script>";
    exit();
            }
        }
    }
}
}

finally
{
    // Zapiranje povezave z bazo
    if ($conn) {
        $stmt_check->close();
        $stmt->close();
        $conn->close();
    }
}
?>