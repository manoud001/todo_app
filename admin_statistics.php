<?php

session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


try {
    // Récupérer le nombre total d'utilisateurs
        $stmt_users = $pdo->query("SELECT COUNT(*) AS total_users FROM users");
        $total_users = $stmt_users->fetch(PDO::FETCH_ASSOC)['total_users'];
    // Récupérer le nombre total de tâches complétées
        $stmt_completed_tasks = $pdo->query("SELECT COUNT(*) AS completed_tasks FROM tasks WHERE status = 'complétée'");
        $completed_tasks = $stmt_completed_tasks->fetch(PDO::FETCH_ASSOC)['completed_tasks'];

    // Récupérer le nombre total de tâches non complétées
        $stmt_uncompleted_tasks = $pdo->query("SELECT COUNT(*) AS uncompleted_tasks FROM tasks WHERE status = 'non complétée'");
        $uncompleted_tasks = $stmt_uncompleted_tasks->fetch(PDO::FETCH_ASSOC)['uncompleted_tasks'];

    // Récupérer le nombre total de tâches
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks");
        $stmt->execute();
        $total_tasks = $stmt->fetchColumn();

    // Récupérer le nombre total de tâches dans le dernier mois
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)");
        $stmt->execute();
        $total_tasks_last_month = $stmt->fetchColumn();

    // Récupérer le nombre total de tâches dans la dernière année
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM tasks WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR)");
        $stmt->execute();
        $total_tasks_last_year = $stmt->fetchColumn();

    // Récupérer la moyenne du nombre total de tâches par mois dans l'année
        $stmt = $pdo->prepare("SELECT COUNT(*) / 12 as avg_tasks_per_month FROM tasks WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR)");
        $stmt->execute();
        $avg_tasks_per_month = $stmt->fetchColumn();

    // Récupérer le nombre total d'utilisateurs inscrits dans la dernière année
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 YEAR)");
        $stmt->execute();
        $total_users_last_year = $stmt->fetchColumn();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager | Statistiques Administrateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Statistiques Générales</h2>
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Utilisateurs</h5>
                    <p class="card-text"><?php echo htmlspecialchars($total_users); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tâches Complétées</h5>
                    <p class="card-text"><?php echo htmlspecialchars($completed_tasks); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tâches Non Complétées</h5>
                    <p class="card-text"><?php echo htmlspecialchars($uncompleted_tasks); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total de tâches</h5>
                    <p class="card-text"><?php echo htmlspecialchars($total_tasks); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total tâches dans le dernier mois</h5>
                    <p class="card-text"><?php echo htmlspecialchars($total_tasks_last_month ); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total tâches dernière année</h5>
                    <p class="card-text"><?php echo htmlspecialchars($total_tasks_last_year); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Moyenne tâches par mois</h5>
                    <p class="card-text"><?php echo htmlspecialchars($avg_tasks_per_month); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total d'utilisateurs dans la dernière année</h5>
                    <p class="card-text"><?php echo htmlspecialchars($total_users_last_year); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './layouts/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
