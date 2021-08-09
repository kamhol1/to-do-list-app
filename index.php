<?php

require 'config/config.php';

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>To-Do List App</title>
</head>
<body>
    <div class="main-section">
        <h2 class="title">To-Do List App</h2>
        <div class="add-tasks-section">
            <form action="app/add.php" method="POST" autocomplete="off">
                <input type="text" name="title" placeholder="Enter a task" autofocus="autofocus" required>
                <input type="submit" value="Add">
            </form>
        </div>
        <?php
        
        $tasks = $conn->query("SELECT * FROM tasks ORDER BY id DESC");
        
        ?>
        <div class="show-tasks-section">
            <?php if ($tasks->rowCount() <= 0) { ?>
                <div class="empty">
                    <h3>No tasks found.</h3>
                </div>
            <?php } ?>

            <?php while ($task = $tasks->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="task-item">
                    <?php if ($task['checked']) { ?>
                        <input type="checkbox" class="check-box" data-task-id="<?php echo $task['id']; ?>" checked>
                        <h3 class="checked"><?php echo $task['title']; ?></h3>
                    <?php } else { ?>
                        <input type="checkbox" class="check-box" data-task-id="<?php echo $task['id']; ?>">
                        <h3><?php echo $task['title']; ?></h3>
                    <?php } ?>
                    <input type="button" id="<?php echo $task['id']; ?>" value="x" class="delete-task-button"> <br>
                    <span class="create-time">Created: <?php echo $task['date_time']; ?></span>
                </div>
            <?php } ?>
        </div>
    </div>

    <script src="scripts/jquery-3.6.0.js"></script>
    <script>
        $(document).ready(function() {
            $('.delete-task-button').click(function() {
                const id = $(this).attr('id');

                $.post("app/delete.php",
                    {
                        id: id
                    },
                    (data) => {
                        if (data) {
                            $(this).parent().hide(500);
                        }
                    }
                );
            });
            
            $('.check-box').click(function() {
                const id = $(this).attr('data-task-id');
                
                $.post("app/check.php",
                    {
                        id: id
                    },
                    (data) => {
                        if (data != 'error') {
                            const h3 = $(this).next();
                            if (data === '1') {
                                h3.removeClass('checked');
                            } else {
                                h3.addClass('checked');
                            }
                        }
                    }
                );
            });
        });
    </script>

</body>
</html>