<?php
session_start();
require_once 'config.php';

// On v                                                                                                               érifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Veuillez vous connecter pour ajouter une tâche.");
}

$user_id = $_SESSION['user_id'];
$errors = [];

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
        // Préparation de l'insertion dans la base de données
        $sql = "INSERT INTO tasks (user_id, title, description, due_date, status) VALUES (:user_id, :title, :description, :due_date, 'non_complétée')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'title' => $title, 'description' => $description, 'due_date' => $due_date]);

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
    <title>TaskManager | Ajout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <body>
<?php include 'navbar.php'; ?>
    <div class="container text-center">
        <h2 class="mt-5">Ajouter une tâche</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <hr>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">

                <form method="post" action="add_task.php">
                    <div class="form-group m-3">
                        <label for="title">Titre</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group m-3">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group m-3">
                        <label for="due_date">Date d'échéance</label>
                        <input type="datetime-local" class="form-control" id="due_date" name="due_date" required>
                    </div>
                    <button type="submit" class="btn btn-primary m-3">Ajouter</button>
                </form>
                <hr>
            </div>
            <div class="col-2"></div>

        </div>
    </div>
    <?php include './layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
