<?php

// Povezava z bazo
$conn = new mysqli("localhost", "tpofitnes_tposkupina", "fujsjelegenda", "tpofitnes_projekt");


/*IZBIRA TRENERJA*/
$osebnitrener = mysqli_real_escape_string($conn, htmlspecialchars($_POST["osebnitrener"]));
$program = mysqli_real_escape_string($conn, htmlspecialchars($_POST["program"]));
$iduporabnika = mysqli_real_escape_string($conn, htmlspecialchars($_POST["idup"]));

$sql = "INSERT INTO vadba (ID_Osebni_Trener, Program_ID_Program, ID_Clan) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    if ($stmt === false)
    {
        die("Napaka pri pripravi poizvedbe: " . $conn->error);
    }

    $stmt->bind_param("iii", $osebnitrener, $program, $iduporabnika);

    if ($stmt->execute())
    {
        // Nastavi sporočilo o uspehu
        $message = "Vadba uspešno rezervirana!";
        
        $stmt->close();
        $conn->close();
    } 
    
    else 
    {
        $message = "Napaka pri rezervaciji. Poskusite znova.";
        $stmt->close();
        $conn->close();
    }
    
    echo "<script>
        alert('$message');
        window.location.href = 'Stran.php'; // Preusmeritev na ustrezno stran (ali obdrži uporabnika na trenutni strani)
    </script>";
?>


<!--php

$conn = new mysqli("localhost:3307", "root", "", "db") or die("unable to connect");
$_SESSION["program"]=$_POST["program"];
header("location: StranTri.php");

?>
