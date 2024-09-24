<?php
session_start();

require_once 'config.php';

// On Vvérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Veuillez vous connecter pour accéder à cette page.");
}

// On vérifie si un ID de tâche est fourni
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de tâche invalide.");
}

$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Suppression de la tâche
$delete_sql = "DELETE FROM tasks WHERE id = :id AND user_id = :user_id";
$delete_stmt = $pdo->prepare($delete_sql);

if ($delete_stmt->execute(['id' => $task_id, 'user_id' => $user_id])) {
    header("Location: show_tasks.php");
    exit();
} else {
    die("Erreur lors de la suppression de la tâche.");
}
?>
