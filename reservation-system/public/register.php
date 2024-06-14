<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];

    $url = 'http://localhost:8000/api/register';
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = 'Error:' . curl_error($ch);
    } else {
        $response = json_decode($result, true);
        if (isset($response['message']) && $response['message'] === 'User registered successfully') {
            echo '<p>Registration successful. Please <a href="login.php">login here</a>.</p>';
        } else {
            $error = 'Registration failed: ' . $response['message'];
        }
    }

    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/register.css">
    <title>Register</title>
    <style>
        body {
            background-image: url('../Mt_Blanc.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="register-container">
            <div class="register-form">
                <h2>Créer un compte</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="">
                    <div class="form-group">
                        <input type="text" name="username" class="form-style" placeholder="Nom d'utilisateur" id="username" autocomplete="off" required>  
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-style" placeholder="Email" id="email" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-style" placeholder="Mot de passe" id="password" autocomplete="off" required>
                    </div>
                    <button type="submit">Register</button>
                </form>
                <p class="login-link">Déjà un compte? <a href="login.php">Connexion</a></p>
            </div>
        </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
