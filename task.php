<?php
session_start();

require 'functions.php';

if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['mark_done'])){
    $task_id = $_POST['task_id'];

  
    $result = mysqli_query($conn, "SELECT task, date FROM task WHERE id = $task_id");
    $row = mysqli_fetch_assoc($result);
    $task_name = $row['task'];
    $task_date = $row['date'];


    $query = "INSERT INTO completed_tasks (task, date) VALUES ('$task_name', '$task_date')";
    mysqli_query($conn, $query);

   
    delete($task_id);

   
    echo "<script>
    alert('Task $task_name finished!');
    </script>";
}
$res = mysqli_query($conn, "SELECT * FROM task");
    //add
if(isset($_POST["submit"])){
    if(add($_POST)>0){
        
        echo "<script>
        alert('New Task Added successfully!');
    </script>";
    } else{
        echo mysqli_error($conn);
    }
    }

    $res = mysqli_query($conn, "SELECT * FROM task");

    if (isset($_POST['restore'])) {
        $task_id = $_POST['restore_task_id'];
        restoreTask($task_id);
    }
    
    if(isset($_POST['restore'])) {
        $restore_task_id = $_POST['restore_task_id'];
        restore($restore_task_id);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>todolist</title>
    <link rel="stylesheet" href="main.css?v=<?php echo time(); ?>">
</head>
<body>
    <button type="submit" name="logout" class="logoutbtn"><a href="login.php">Logout</a></button>
        <div class="container">
            <h3>- Add New Task -</h3>
            <form action="" method="post">
                <!-- <ul style="list-style-type: none;">
            <li> -->
                <label for="task">Add Your Task</label>
                <input type="text" name="task" id="task">
            <!-- </li>
            <li> -->
                <label for="deadline">Deadline</label>
                <input type="date" name="date" id="date">
            <!-- </li>
            <li> -->
                <button type="submit" name="submit">Submit</button>
            <!-- </li>
        </ul> -->
    </form>
        </div>
        <h2>Task</h2>
<?php while($row = mysqli_fetch_assoc($res)): ?>
    <div class="task">
        <p><?= $row["task"]; ?></p>
        <form action="task.php" method="post">
            <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
            <button type="submit" name="mark_done">Done</button>
        </form>
        <form action="delete.php" method="post">
        <a href="delete.php?id=<?= $row["id"]; ?>">
            <button type="button">Delete</button>
        </form>
    </div>
<?php endwhile; ?>

<?php if(mysqli_num_rows($res) == 0): ?>
    <p>No tasks found</p>
<?php endif; ?>

<style>
    .task {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
        margin-bottom: 10px;
    }

    .task p {
        margin: 0;
    }

    .task button {
        margin-left: 10px;
    }
</style>


    <h2>Completed Task</h2>
<?php
$query = "SELECT * FROM completed_tasks ORDER BY date DESC";
$res = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($res)):
?>
    <p style="text-decoration: line-through"><?= $row['date'] ?> <?= $row['task'] ?></p>
    <form action="" method="post">
        <input type="hidden" name="restore_task_id" value="<?= $row['id'] ?>">
        <button type="submit" name="restore">Restore</button>
    </form>
<?php endwhile; ?>
</body>
</html>