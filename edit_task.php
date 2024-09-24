<?php
session_start();
require_once 'config.php';

// On vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Veuillez vous connecter pour modifier une tâche.");
}

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'];
$errors = [];

// On Récupère les informations de la tâche à modifier
$sql = "SELECT * FROM tasks WHERE id = :id AND user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $task_id, 'user_id' => $user_id]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    die("Tâche non trouvée.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];

    // Validation des champs
    if (empty($title)) {
        $errors[] = "Le titre est obligatoire.";
    }

    $current_date = new DateTime();
    $due_date_obj = new DateTime($due_date);

    if ($due_date_obj <= $current_date) {
        $errors[] = "La date d'échéance doit être postérieure à la date actuelle.";
    }

    if (empty($errors)) {
        // Préparation de la mise à jour de la base de données
        $sql = "UPDATE tasks SET title = :title, description = :description, due_date = :due_date WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['title' => $title, 'description' => $description, 'due_date' => $due_date, 'id' => $task_id, 'user_id' => $user_id]);

        // Redirection vers la page des tâches
        header("Location: show_tasks.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager | Modifier tâche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="edit_task">
<?php include 'navbar.php'; ?>
    <div class="container text-center">
        <div class="mt-5"></div>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">

                <form method="post" action="edit_task.php?id=<?php echo $task_id; ?>">
                    <div class="form-group">
                        <label for="title" class="mt-2 mb-2">Titre</label>
                        <input type="text" class="form-control mb-2" id="title" name="title" value="<?php echo htmlspecialchars($task['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description" class="mt-2 mb-2">Description</label>
                        <textarea class="form-control mb-2" id="description" name="description"><?php echo htmlspecialchars($task['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="due_date" class="mt-2 mb-2">Date d'échéance</label>
                        <input type="datetime-local" class="form-control mb-2" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Modifier</button>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <?php include './layouts/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>

