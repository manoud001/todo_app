<?php
session_start();
require_once 'config.php';

// On vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Requête pour le filtrage des tâches
$status_filter = isset($_GET['filter']) ? $_GET['filter'] : 'toutes';

$sql = "SELECT * FROM tasks WHERE user_id = :user_id";

if ($status_filter === 'complétée') {
    $sql .= " AND status = 'complétée'";
} elseif ($status_filter === 'non_complétée') {
    $sql .= " AND status = 'non_complétée'";
}

$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

function getStatusClass($status) {
    return $status == 'complétée' ? 'bg-success' : 'bg-secondary';
}

// Traitement de la demande de mise à jour du statut

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['status_id']) && isset($_GET['current_status'])) {
    $status_id = $_GET['status_id'];
    $current_status = $_GET['current_status'];
    $new_status = ($current_status == 'non_complétée') ? 'complétée' : 'non_complétée';
    

    $update_sql = "UPDATE tasks SET status = :new_status WHERE id = :id AND user_id = :user_id";
    $update_stmt = $pdo->prepare($update_sql);
    $update_stmt->execute(['new_status' => $new_status, 'id' => $status_id, 'user_id' => $user_id]);

    header("Location: show_tasks.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tâches | TaskManager</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="show_tasks">
    <?php include 'navbar.php'; ?>
    <div class="container mt-5 text-center">
    <a href="add_task.php" class="btn btn-primary mt-3 ">Ajouter une Tâche</a>
    <hr>

        <form method="get" action="show_tasks.php" class="mb-3">
            <div class="form-group col-3">
                <select id="filter" name="filter" class="form-control" onchange="this.form.submit()">
                    <option value="toutes" <?php echo ($status_filter == 'toutes') ? 'selected' : ''; ?>>Toutes les tâches</option>
                    <option value="complétée" <?php echo ($status_filter == 'complétée') ? 'selected' : ''; ?>>Tâches complétées</option>
                    <option value="non_complétée" <?php echo ($status_filter == 'non_complétée') ? 'selected' : ''; ?>>Tâches non complétées</option>
                </select>
            </div>
        </form>
        <div class="row">
            <?php foreach ($tasks as $task): ?>
                <div class="col-md-4 mb-3">
                    <div class="card <?php echo getStatusClass($task['status']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($task['description']); ?></p>
                            <p class="card-text">Date de création : <?php echo htmlspecialchars($task['created_at']); ?></p>
                            <p class="card-text">Date d'échéance : <?php echo htmlspecialchars($task['due_date']); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                            <button 
                                class="btn btn-sm <?php echo ($task['status'] == 'complétée') ? 'btn-success' : 'btn-secondary'; ?>" 
                                onclick="changeStatus(<?php echo $task['id']; ?>, '<?php echo $task['status']; ?>')">
                                <?php echo ($task['status'] == 'complétée') ? 'Tâche complétée' : 'Tâche non complétée'; ?>
                            </button>
                                <div>
                                    <a href="edit_task.php?id=<?php echo $task['id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">
                                    <i class="bi bi-trash-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <hr>
    <?php include './layouts/footer.php'; ?>


<script>
        function changeStatus(taskId, currentStatus) {
            var newStatus = (currentStatus === 'non_complétée') ? 'complétée' : 'non_complétée';

            // Redirection pour changer le statut
            window.location.href = `show_tasks.php?status_id=${taskId}&current_status=${currentStatus}`;
        }
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
