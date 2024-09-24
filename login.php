<?php
session_start();
require_once 'config.php';

if (isset($_SESSION['user_id'])) {
    // Redirection en fonction du rôle
    if ($_SESSION['role'] === 'admin') {
        header('Location: dashboard.php');
        exit();
    } else {
        header('Location: show_tasks.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = trim($_POST['password'],PASSWORD_DEFAULT);

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, name, password, role FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            // Redirection en fonction du rôle
            if ($user['role'] === 'admin') {
                header('Location: dashboard.php');
                exit();
            } else {
                header('Location: show_tasks.php');
                exit();
            }
        } else {
            $error = 'Identifiant ou mot de passe incorrect.';
        }
    } else {
        $error = 'Veuillez remplir tous les champs.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title> Connexion | TaskManager</title>
</head>
<body>
  <div class="wrapper">
    <div class="container main">
        <div class="row">
            <div class="col-md-6 side-image">
                       
            </div>

            <div class="col-md-6 right">
                
                <div class="input-box">
                   
                   <header>CONNEXION</header>
                   <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                   <?php endif; ?>
                   <form action="login.php" method="post">

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
                        <span>Pas encore de compte ? <a href="register.php">Inscrivez-vous ici</a></span>
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