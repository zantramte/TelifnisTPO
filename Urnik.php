<?php
// Začnemo sejo
session_start();

// Preverimo, če je uporabnik prijavljen
if (!isset($_SESSION["prijavljen"]) || $_SESSION["prijavljen"] !== TRUE) {
    // Preusmerimo na login stran
    header("Location: StranLogin.htm");
    exit(); // Prekinemo izvajanje
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fitnes - Moj urnik vadb</title>
    <style>
          @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins';
            background: #497ae1;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Top Bar */
        .top-bar {
            background-color: #003cbc;
            padding: 25px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .top-bar .prijavljeni {
            color: white;
            font-size: 1.1rem;
        }

        .top-bar .links a {
            color: white;
            font-size: 1.1rem;
            margin: 0 15px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .top-bar .links a:hover {
            background-color: #ffffff;
            color: #003cbc;
            padding: 5px 15px;
            border-radius: 5px;
        }

        /* Hamburger menu */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
            height: 30px;
            width: 30px;
        }

        .hamburger div {
            height: 5px;
            background-color: white;
            width: 30px;
            border-radius: 5px;
        }

        /* Overlay Menu */
        .overlay {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #00116f;
            overflow-x: hidden;
            transition: 0.5s;
        }

        .overlay-content {
            position: relative;
            top: 25%;
            width: 100%;
            text-align: center;
        }

        .overlay a {
            padding: 8px;
            text-decoration: none;
            font-size: 36px;
            color: #ffffff;
            display: block;
            transition: 0.3s;
        }

        .overlay a:hover {
            color: #f1f1f1;
        }

        .overlay .closebtn {
            position: absolute;
            top: 20px;
            right: 45px;
            font-size: 60px;
            color: #ffffff;
        }

        @media screen and (max-width: 768px) {
            .top-bar .links {
                display: none; /* Skrij običajne povezave */
            }

            .hamburger {
                display: flex; /* Prikaži hamburger meni */
            }
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .content h1 {
            color: white;
            margin-bottom: 20px;
        }

        .table-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .scrollable-box {
            width: 90%;
            max-width: 1200px;
            max-height: 60vh;
            overflow-y: auto;
            border-radius: 10px;
            background-color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 15px;
            text-align: center;
            font-size: 0.9rem;
        }

        table th {
            background-color: #003cbc;
            color: white;
        }

        .cancel-button {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            font-family: 'Poppins';
        }

        .cancel-button:hover {
            background-color: darkred;
        }

        /* Sticky Footer */
        .footer {
            background-color: #003cbc;
            color: white;
            text-align: center;
            padding: 30px;
            position: relative;
            width: 100%;
            margin-top: auto;
        }

        .footer a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            color: #0b23a9;
            background: #fff;
            padding: 5px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="prijavljeni">
            <?php
            if (isset($_SESSION["prijavljen"]) && $_SESSION["prijavljen"] == TRUE) {
                echo "<strong>  {$_SESSION['Ime']}  {$_SESSION['Priimek']}</strong>";
            }
            ?>
        </div>
        <div class="hamburger" onclick="openNav()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="links">
            <a href="Dobrodosli.php">Domov</a>
            <a href="Stran.php">Izbira vadbe</a>
            <a href="Odjava.php">Odjava</a>
        </div>
    </div>

    <!-- Overlay Menu -->
    <div id="myNav" class="overlay" style="font-family: 'Poppins';">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="overlay-content">
            <a href="Dobrodosli.php">Domov</a>
            <a href="Stran.php">Izbira vadbe</a>
            <a href="Odjava.php">Odjava</a>
        </div>
    </div>

    <script>
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>

    <!-- Content -->
    <div class="content">
        <h1>Moj urnik vadb</h1>
        <div class="table-container">
            <div class="scrollable-box">
                <table>
                    <thead>
                        <tr>
                            <th>Vadba</th>
                            <th>Dan in ura</th>
                            <th>Trener</th>
                            <th>Rezervacija</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Povezava z bazo
                        $conn = new mysqli("localhost", "tpofitnes_tposkupina", "fujsjelegenda", "tpofitnes_projekt");

                        mysqli_set_charset($conn, "utf8mb4");

                        // Preveri povezavo
                        if ($conn->connect_error) {
                            die("Povezava ni uspela: " . $conn->connect_error);
                        }

                        // ID člana, ki je prijavljen
                        $id_clan = $_SESSION["ID"];

                        // SQL poizvedba za pridobivanje vadb
                        $sql = "
                            SELECT 
                                v.ID_Vadba AS id_vadbe,
                                p.Naziv_Program AS ime_vadbe, 
                                p.Urnik AS dan_in_ura, 
                                t.Ime AS ime_trenerja, 
                                t.Priimek AS priimek_trenerja
                            FROM vadba v
                            JOIN `osebni trener` t ON v.ID_Osebni_Trener = t.ID_Osebni_Trener
                            JOIN program p ON v.Program_ID_Program = p.ID_Program
                            WHERE v.ID_Clan = ?
                        "; 

                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id_clan);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['ime_vadbe']}</td>
                                    <td>{$row['dan_in_ura']}</td>
                                    <td>{$row['ime_trenerja']} {$row['priimek_trenerja']}</td>
                                    <td>
                                        <form method='post' action='Odpovej.php'>
                                            <input type='hidden' name='id_vadbe' value='{$row['id_vadbe']}'>
                                            <button type='submit' class='cancel-button'>Odpovej</button>
                                        </form>
                                    </td>
                                  </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Na urniku nimate vadb ...</td></tr>";
                        }

                        $stmt->close();
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sticky Footer -->
    <div class="footer">
        <p>
            <a href="mailto:Telifnis@gmail.com?subject=Vprašanje%20o%20vadbi&body=Pozdravljeni,%20rad%20bi%20imel%20več%20informacij%20o%20vadbi.">E-mail: Telifnis@gmail.com</a>
        </p>
    </div>
</body>
</html>