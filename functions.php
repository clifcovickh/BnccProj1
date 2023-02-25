<?php

$conn = mysqli_connect("localhost","root","","bncc");


function add($data){
    global $conn; 
    $task = htmlspecialchars($data["task"]);
    $date = $data["date"];

    $query = "INSERT INTO task
            VALUES
        ('','$task','$date')
        ";

mysqli_query($conn,$query);

return mysqli_affected_rows($conn); 
}

function register($data) {
    global $conn; 

    $name = strtolower(stripslashes($data["name"]));
    $username = strtolower(stripslashes($data["username"]));
    $password = $data["password"];
    $password2 = $data["password2"];

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('Username already used');
        </script>";
        
        return false;  
    }

    if ($password !== $password2) {
        echo "<script>
                alert('Confirmation password does not match');
        </script>";

        return false;  
    }
    //pass encrypt
    $password = password_hash($password, PASSWORD_DEFAULT);

    //update database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$name' , '$username' , '$password')");

    return mysqli_affected_rows($conn);
}

function delete($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM task WHERE id = $id");

    return mysqli_affected_rows($conn); 
}
function delete_completed_task($task_id) {
    global $conn;

    mysqli_query($conn, "DELETE FROM completed_tasks WHERE id = $task_id");
}

function restoreTask($task_id) {
    global $conn;

 
    $query = "SELECT * FROM completed_tasks WHERE id=$task_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $task = $row['task'];
        $date = $row['date'];

     
        $query = "DELETE FROM completed_tasks WHERE id=$task_id";
        mysqli_query($conn, $query);


        $query = "INSERT INTO tasks (task, date) VALUES ('$task', '$date')";
        mysqli_query($conn, $query);
    }
}


function restore($id) {
    global $conn;

    $sql = "DELETE FROM completed_tasks WHERE id=$id";
    mysqli_query($conn, $sql);

    $sql = "SELECT * FROM completed_tasks WHERE id=$id";
    $res = mysqli_query($conn, $sql);
    
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $task = $row['task'];
        $date = $row['date'];

        $sql = "INSERT INTO tasks (task, date) VALUES ('$task', '$date')";
        mysqli_query($conn, $sql);
    }
}

?>

