<?php

require '../config/config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if (empty($id)) {
        echo 'error.';
    } else {
        $query = $conn->prepare("SELECT id, checked FROM tasks WHERE id = ?");
        $query->execute([$id]);

        $task = $query->fetch();
        $uId = $task['id'];
        $checked = $task['checked'];

        $uChecked = $checked ? 0 : 1;

        $query = $conn->query("UPDATE tasks SET checked = $uChecked WHERE id = $uId");

        if ($query) {
            echo $checked;
        } else {
            echo 'error';
        }

        $conn = null;
        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}

?>