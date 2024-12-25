<?php
// Povezava z bazo
$conn = new mysqli("localhost", "tpofitnes_tposkupina", "fujsjelegenda", "tpofitnes_projekt");

if ($conn->connect_error) {
    die("Povezava ni uspela: " . $conn->connect_error);
}

$message = ""; // Sporočilo za JS alert

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_vadbe = intval($_POST["id_vadbe"]);

    // Poizvedba za brisanje
    $sql = "DELETE FROM vadba WHERE ID_Vadba = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_vadbe);

    if ($stmt->execute()) {
        $message = "Vadba uspešno odpovedana!";
    } else {
        $message = "Napaka pri odpovedi vadbe!";
    }

    $stmt->close();
}

$conn->close();

// Izpišemo JS alert in preusmerimo uporabnika
echo "<script>
        alert('$message');
        window.location.href = 'Urnik.php';
      </script>";
exit();
?>
