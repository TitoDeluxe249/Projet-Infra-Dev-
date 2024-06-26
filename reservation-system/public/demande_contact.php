<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des demandes de contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/demande.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="./accueil.html">AIR LAS</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto" style="font-size: 20px;">
                <li class="nav-item active">
                        <a class="nav-link" href="./accueil.html">Accueil <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./profil.html">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./flights.html">Réserver un vol</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./reservations.html">Mes réservations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="container mt-5 mb-5">Liste des demandes de contact</h2>
        <?php
        $host = '127.0.0.1';
        $db_name = 'reservation_system_db';
        $username = 'root';
        $password = '';
        $conn;
    
        function connect() {
            $this->conn = null;
    
            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }
    
            return $this->conn;
        }

        $sql = "SELECT * FROM demandes_contact ORDER BY date_demande DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<table class="table">';
            echo '<thead><tr><th scope="col">Email</th><th scope="col">Sujet</th><th scope="col">Message</th><th scope="col">Date</th></tr></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['sujet'] . '</td>';
                echo '<td>' . $row['message'] . '</td>';
                echo '<td>' . $row['date_demande'] . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo "Aucune demande de contact trouvée.";
        }

        $conn->close();
        ?>
    </div>

    <footer>
    © 2024 AIR LAS. Tous droits réservés.
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>