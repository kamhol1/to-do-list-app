<?php

require '../config/config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if (empty($id)) {
        echo 0;
    } else {
        $query = $conn->prepare("DELETE FROM tasks WHERE id = ?");
        $query->execute([$id]);

        echo 1;

        $conn = null;
        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}

?>