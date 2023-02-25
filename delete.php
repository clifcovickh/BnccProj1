<?php

require 'functions.php';

$id = $_GET["id"];

    if(delete($id)>0){
        echo "
            <script>
                alert('Task Deleted successfully!');
                document.location.href = 'task.php';
            </script>
        ";
    } else{
        echo "
            <script>
                alert('Failed to delete!');
                document.location.href = 'task.php';
            </script>
        ";
    }


    $res = mysqli_query($conn, "SELECT * FROM task");



?>