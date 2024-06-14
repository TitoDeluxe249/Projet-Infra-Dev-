<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de la recherche - AIR LAS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
        <a class="navbar-brand" href="accueil.html">Air Las</a>
        </div>
        <nav>
            <a href="./accueil.html">Accueil</a>
            <a href="./profil.html">Profil</a>
            <a href="./flights.html">Réserver un vol</a>
            <a href="./reservations.html">Mes réservations</a>
            <a href="./contact.php">Contact</a>
            <a href="./cart.html">Mon Panier</a>
        </nav>
    </header>
    <main>
        <h1>Résultats de la recherche de vols</h1>
        <?php
        // Vérifier si des paramètres de recherche ont été envoyés
        if (isset($_GET['departure']) && isset($_GET['destination']) && isset($_GET['departure_date']) && isset($_GET['return_date'])) {
            // Récupérer les paramètres de recherche depuis l'URL
            $departure = $_GET['departure'];
            $destination = $_GET['destination'];
            $departure_date = $_GET['departure_date'];
            $return_date = $_GET['return_date'];

            // Connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "reservation_system_db";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Requête SQL pour récupérer les vols correspondants
            $sql = "SELECT * FROM flights WHERE departure = '$departure' AND arrival = '$destination' AND date = '$departure_date'";
            $result = $conn->query($sql);

            // Vérifier s'il y a des résultats
            if ($result->num_rows > 0) {
                // Afficher les résultats
                echo "<h2>Résultats de votre recherche :</h2>";
                echo "<div class='flights-container'>";
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='flight-card'>";
                    echo "<h4><i><u>" . $row['airline'] . "</u></i></h4>";
                    echo "<p><strong>Flight Number:</strong> " . $row['flight_number'] . "</p>";
                    echo "<p><strong>Departure:</strong> " . $row['departure'] . "</p>";
                    echo "<p><strong>Arrival:</strong> " . $row['arrival'] . "</p>";
                    echo "<p><strong>Date:</strong> " . $row['date'] . "</p>";
                    echo "<p><strong>Departure Time:</strong> " . $row['departure_time'] . "</p>";
                    echo "<p><strong>Arrival Time:</strong> " . $row['arrival_time'] . "</p>";
                    echo "<p><strong>Price:</strong> $" . $row['price'] . "</p>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>Aucun vol trouvé pour votre recherche.</p>";
            }

            // Fermer la connexion à la base de données
            $conn->close();
        } else {
            echo "<p>Veuillez entrer des paramètres de recherche valides.</p>";
        }
        ?>
    </main>
    <footer>
        <a href="aide.html">Aide</a>
        <a href="GénéralCondition.html">Conditions Générales</a>
        <a href="Confidentiality.html">Politique de Confidentialité</a>
        <div class="contact-info">
            <p>mail:</p><a href="#">contactbusiness@airlas.com</a>
        </div>
        <div class="newsletter">
            <input type="email" placeholder="Votre email">
            <input type="submit" value="S'inscrire">
        </div>
        <br>
        <p>© 2024 Air LAS. Tous droits réservés.</p>
    </footer>
</body>
</html>
