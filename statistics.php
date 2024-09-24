<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// On récupère les statistiques des tâches de l'utilisateur
$user_id = $_SESSION['user_id'];

// Total des tâches
$sql = "SELECT COUNT(*) FROM tasks WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$total_tasks = $stmt->fetchColumn();

// Tâches non complétées
$sql = "SELECT COUNT(*) FROM tasks WHERE user_id = :user_id AND status = 'non complétée'";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$incomplete_tasks = $stmt->fetchColumn();

// Tâches complétées
$sql = "SELECT COUNT(*) FROM tasks WHERE user_id = :user_id AND status = 'complétée'";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$completed_tasks = $stmt->fetchColumn();

// Moyenne des tâches inscrites par mois
$sql = "SELECT COUNT(*) / COUNT(DISTINCT DATE_FORMAT(created_at, '%Y-%m')) FROM tasks WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$average_tasks_per_month = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager | Statistiques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="statistics">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5 text-center">
        <h2>Statistiques</h2>
        <hr>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total des tâches</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($total_tasks); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Tâches non complétées</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($incomplete_tasks); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Tâches complétées</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($completed_tasks); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Moyenne de tâches par mois</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo number_format($average_tasks_per_month, 2); ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    </div>
    <?php include './layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
