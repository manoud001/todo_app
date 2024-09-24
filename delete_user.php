<?php
session_start();
include 'config.php';

// Vérifiez si l'utilisateur est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Vérifiez si l'ID de l'utilisateur à supprimer est passé dans l'URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Préparer et exécuter la requête de suppression
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);

    // Rediriger vers la page users.php après la suppression
    header("Location: users.php");
    exit();
} else {
    echo "ID d'utilisateur manquant.";
}
?>
