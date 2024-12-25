<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION["prijavljen"]) || $_SESSION["prijavljen"] !== TRUE) {
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
    <title>Fitnes - Izbira trenerja in vadbe</title>
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
         
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Poppins';
            background: #497ae1;
            color: #fff;
            display: flex;
            flex-direction: column;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Distribute space evenly between top and bottom */
        }

        .top-bar {
            background-color: #003cbc;
            padding: 25px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .top-bar .prijavljeni {
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

        h1 {
            font-size: 40px;
            text-align: center;
            margin: 20px 0;
        }

        /* Centering and Responsiveness for the Form */
        form {
            
            flex-grow: 1; /* Allow the form to take up remaining vertical space */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            margin: 70px auto; /* Center the form vertically and horizontally */
          background: linear-gradient(to bottom, #497ae1 0%, #0037ba 50%, #497ae1 100%);
            border-radius: 20px; /* Optional: rounded corners */
        }

        form table {
            width: 100%;
        }

        form th,
        form td {
            padding: 10px 5px;
            text-align: left;
        }

        form th {
            font-size: 16px;
            text-align: right;
        }

        form select,
        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background: #00116f;
            color: #ffffff;
            font-weight: bold;
            margin-top: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 20px;
            border-radius: 10px;
        }

        form input[type="submit"]:hover {
            background: #ffffff;
            color: #00116f;
        }

        /* Mobile responsiveness */
@media screen and (max-width: 768px) {
    form {
        max-width: 90%; /* Allow the form to take up 90% of the screen width */
        margin: 30px auto; /* Center the form with margins on the left and right */
    }

    form select,
    form input[type="submit"] {
        font-size: 14px; /* Slightly smaller font on mobile */
    }
}


        /* Flexbox for images */
        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            margin: 30px auto;
            padding: 0 20px; /* Odmik od robov */
            max-width: 1200px;
        }

        .column {
            flex: 1;
            max-width: 32%;
            margin-bottom: 20px;
        }

        .column img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            transition: opacity 0.3s ease;
        }

        .column img:hover {
            opacity: 0.7;
        }

        /* Sticky Footer */
        .footer {
            background-color: #003cbc;
            color: white;
            text-align: center;
            padding: 30px;
            width: 100%;
            position: relative;
        }
        
         select {
            font-family: 'Poppins';
            font-size: 16px; /* Dodaj velikost pisave, če je potrebno */
        }

        /* Spremeni pisavo za opcije */
        select option {
            font-family: 'Poppins', sans-serif;
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
            .row {
                flex-direction: column;
                gap: 20px;
                padding: 0 10px; /* manjši odmiki za mobilne naprave */
            }

            .column {
                max-width: 100%;
                flex: 1;
            }

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
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="prijavljeni">
            <?php
                if (isset($_SESSION["prijavljen"]) && $_SESSION["prijavljen"] == TRUE) {
                    echo "<strong>{$_SESSION['Ime']} {$_SESSION['Priimek']}</strong>";
                }
            ?>
        </div>
        <div class="links">
            <a href="Dobrodosli.php">Domov</a>
            <a href="Urnik.php">Urnik</a>
            <a href="Odjava.php">Odjava</a>
        </div>
        <!-- Hamburger Menu Icon -->
        <div class="hamburger" onclick="openNav()">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <form method="post" action="IzbiraTrenerja.php">
        <input type="hidden" name="idup" value="<?php echo htmlspecialchars($_SESSION["ID"]); ?>">
        <table>
            <tr>
                <h1>Izbor vadbe</h1>
            </tr>
            <tr>
                <th>Trener:</th>
                <td>
                    <select name="osebnitrener" style="font-family: 'Poppins';">
                        <option value="0">Tom Lut</option>
                        <option value="1">Matija Novak</option>
                        <option value="2">Ana Pula</option>
                        <option value="3">Mia Lotes</option>
                        <option value="4">Nejc Detar</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Program:</th>
                <td>
                    <select name="program" style="font-family: 'Poppins';">
                        <option value="0">Yoga - Ponedeljek (15:00 - 16:30) - 20€</option>
                        <option value="1">Calisthenics - Torek (15:00 - 16:30) - 25€</option>
                        <option value="2">Dvigovanje uteži - Petek (12:00 - 14:00) - 25€</option>
                        <option value="3">Kondicijski trening - Sreda (12:00 - 13:45) - 30€</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" style="font-family: 'Poppins';" name="submit" value="Potrdi izbor">
                </td>
            </tr>
        </table>
    </form>

    <!-- Sticky Footer -->
    <div class="footer">
        <p>
            <a href="mailto:Telifnis@gmail.com?subject=Vprašanje%20o%20vadbi&body=Pozdravljeni,%20rad%20bi%20imel%20več%20informacij%20o%20vadbi.">E-mail: Telifnis@gmail.com</a>
        </p>
    </div>

    <!-- Overlay Menu -->
    <div id="myNav" class="overlay" style="font-family: 'Poppins';">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="overlay-content">
            <a href="Dobrodosli.php">Domov</a>
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