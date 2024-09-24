<?php
session_start();
require_once 'config.php';

// Vérifie si le formulaire est soumis

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Validation des champs
    if (empty($name) || empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "L'email n'est pas valide.";
    } elseif (strlen($password) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        // Vérifie si l'email est déjà utilisé
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error = "L'email est déjà utilisé.";
        } else {
            // Hash du mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insère l'utilisateur dans la base de données
            $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'user')";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute(['name' => $name, 'email' => $email, 'password' => $hashed_password])) {
                // Récupère l'ID de l'utilisateur nouvellement créé
                $user_id = $pdo->lastInsertId();

                // Démarre une session pour l'utilisateur
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $name;
                $_SESSION['role'] = 'user';
                

                // Redirige vers la page login.php
                header("Location: show_tasks.php");
                exit();
            } else {
                $error = "Une erreur s'est produite lors de l'inscription.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Inscription | TaskManager</title>
</head>
<body>
  <div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image">
                       
            </div>

            <div class="col-md-6 right">
                
                <div class="input-box">
                   
                   <header>INSCRIPTION</header>
                   <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                   <?php endif; ?>
                   <form action="register.php" method="post">

                       <div class="input-field">
                            <input type="text" class="input" id="name" name="name" required="" >
                            <label for="name">Nom</label> 
                        </div> 
                       <div class="input-field">
                            <input type="text" class="input" id="email" name="email" required="" >
                            <label for="email">Email</label> 
                        </div> 
                       <div class="input-field">
                            <input type="password" class="input" id="password" name="password" required>
                            <label for="pass">Mot de passe</label>
                        </div> 
                       <div class="input-field">
                            
                            <input type="submit" class="submit" name="submit" value="Sign Up">
                       </div> 
                       <div class="signin">
                        <span>Déjà connecté? <a href="login.php">Cliquez-ici</a></span>
                       </div>
                   </form>
                </div>  
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>