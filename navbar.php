<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">    
</head>
<body>
<nav class=" container-fluid navbar navbar-expand-lg navbar-light bg-light me-3">
    <a class="navbar-brand ms-5 h1" href="index.php">TaskManager</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item dropdown">
                    <button class="btn btn-success dropdown-toggle me-5" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if ($_SESSION['role'] === 'user'): ?>

                            <!-- Liens pour les utilisateurs -->
                            <li><a class="dropdown-item" href="show_tasks.php">Voir les tâches</a></li>
                            <li><a class="dropdown-item" href="statistics.php">Statistiques</a></li>
                        <?php elseif ($_SESSION['role'] === 'admin'): ?>
                            
                            <!-- Liens pour les administrateurs -->
                            <li><a class="dropdown-item" href="dashboard.php">Tableau de bord</a></li>
                            <li><a class="dropdown-item" href="admin_statistics.php">Statistiques Administrateur</a></li>
                            <li><a class="dropdown-item" href="users.php">Liste des Utilisateurs</a></li>
                        <?php endif; ?>
                        <li><a class="dropdown-item" href="logout.php">Déconnexion</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="nav-item ms-3 me-3">
                    <a class="btn btn-outline-primary me-2" role="button" href="login.php">Connexion</a>
                </li>
                <li class="nav-item me-3 ms-3">
                    <a class="btn btn-outline-primary me-2" role="button" href="register.php">Inscription</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
