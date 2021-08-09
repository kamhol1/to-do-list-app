<?php

require '../config/config.php';

if (isset($_POST['title'])) {
    $title = $_POST['title'];
    if (empty($title)) {
        header("Location: ../index.php?mess=error");
    } else {
        $query = $conn->prepare("INSERT INTO tasks (title) VALUES (?)");
        $query->execute([$title]);

        header("Location: ../index.php?mess=task_added");

        $conn = null;
        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}

?>