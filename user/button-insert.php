<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../new_main/index.php");
    exit;
}
?>

<?php

// Include config file
require_once "config.php";



    $jqueryVariable = $_POST['variable'];
    $visit_estimation = $_POST['var2'];
    echo $visit_estimation;
    $visit_userid = $_SESSION["id"];
    date_default_timezone_set("Europe/Athens");
    $visit_timestamp = date_create()->format('Y-m-d H:i:s');
    //echo $visit_timestamp;

    $visit_poiid = $jqueryVariable;
    $visit_est   = $visit_estimation;
    
   
  
        $insert_visit = "INSERT INTO myvisit(visit_userid, visit_poiid, visit_timestamp, visit_estimation)
        VALUES ('$visit_userid', '$visit_poiid', '$visit_timestamp' ,'$visit_estimation');";
    
    
    
    try {
    
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $insert_visit);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
       
       
       
        
        
    }
    catch (Exception $err) {
 
        die;
    }

    
    
   



?>