<?php


try {

    $pdo = new PDO("mysql:host=localhost;dbname=todo_app", 'root', '');

} catch (PDOException $e) {
    
    die("Erreur : " . $e->getMessage());
}

?>
