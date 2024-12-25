<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION["prijavljen"]) || $_SESSION["prijavljen"] !== TRUE)
{
    // Redirect to login page if the user is not logged in
    header("Location: StranLogin.htm");
    exit(); // Make sure to stop further script execution
}
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fitnes - glavna stran</title>
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
      
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
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

        /* Header Above Images */
        .image-header {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: white;
            margin-top: 40px;
            margin-bottom: 30px;
        }

        .image-header span {
            color: #ffbc00;
        }

        /* Image section styling */
        .images-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            width: 100%;
            overflow-x: hidden;
            flex-grow: 1;
            margin-top: 40px;
            margin-bottom: 60px;
            padding: 0 20px;
        }

        .images-row img {
            border-radius: 20px;
            transition: 0.3s;
            width: 32%;
            border: 7px solid #003cbc;
        }

        .images-row img:hover {
            opacity: 0.7;
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
             font-family: 'Poppins';
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

        /* Hamburger menu (hidden by default) */
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

        /* Mobile responsiveness */
        @media screen and (max-width: 768px) {
            .images-row {
                flex-direction: column;
                gap: 20px;
            }

            .images-row img {
                width: 100%;
            }

            .image-header {
                font-size: 1.5rem;
            }

            .top-bar .links {
                display: none; /* Hide links on small screens */
            }

            .hamburger {
                display: flex; /* Show hamburger on small screens */
            }
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
            font-family: 'Roboto', Arial, sans-serif;
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
            color: #818181;
            display: block;
            transition: 0.3s;
            color: #ffffff;
        }

        .overlay a:hover, .overlay a:focus {
            color: #f1f1f1;
        }

        .overlay .closebtn {
            position: absolute;
            top: 20px;
            right: 45px;
            font-size: 60px;
        }

        @media screen and (max-height: 450px) {
            .overlay a {font-size: 20px}
            .overlay .closebtn {
                font-size: 40px;
                top: 15px;
                right: 35px;
            }
        }
    </style>
</head>
<body>

    <!-- Top Bar with user info and navigation links -->
    <div class="top-bar">
        <div class="prijavljeni">
            <?php
                // Display logged-in user's name if logged in
                if (isset ($_SESSION["prijavljen"]) && $_SESSION["prijavljen"] == TRUE){
                    echo "<strong>{$_SESSION["Ime"]}  {$_SESSION["Priimek"]}</strong>";
                }
            ?>
        </div>
        <div class="hamburger" onclick="openNav()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="links">
            <a href="Stran.php">Izbira vadbe</a>
            <a href="Urnik.php">Urnik</a>
            <a href="Odjava.php">Odjava</a>
        </div>
    </div>

    <!-- Header Above Images -->
    <div class="image-header">
        <h3>Razgibajte svoje telo!</h3>
    </div>

    <!-- Image Row Section -->
    <div class="images-row">
        <img src="Images/Fitnes_gym.jpg" alt="Izvajanje treninga za dvigovanje uteži" data-message="Zdrav duh z dvigovanjem uteži." >
        <img src="Images/Fitnes_gymYoga.jpg" alt="Izvajanje Yoge" data-message="Zdrav duh z jogo." >
        <img src="Images/Fitnes_gym3.jpg" alt="Izvajanje kondicijskega treninga" data-message="Zdrav duh v fitnesu." >
    </div>

    <!-- Sticky Footer -->
    <div class="footer">
        <p>
            <a href="mailto:Telifnis@gmail.com?subject=Vprašanje%20o%20vadbi&body=Pozdravljeni,%20rad%20bi%20imel%20več%20informacij%20o%20vadbi.">E-mail: Telifnis@gmail.com</a>
        </p>
    </div>

    <!-- Overlay Menu -->
    <div id="myNav" class="overlay" style=" font-family: 'Poppins';">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="overlay-content">
            <a href="Stran.php">Izbira vadbe</a>
            <a href="Urnik.php">Urnik</a>
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
</body>
</html>