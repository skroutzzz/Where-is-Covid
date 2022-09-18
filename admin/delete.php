<?php
 
 session_start();
 include "config.php";

 if(isset($_POST['deleteALL'])) {

    $sql ="DELETE FROM mypois";

    if (mysqli_query($link, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($link);
    }
    mysqli_close($link);
}
?>