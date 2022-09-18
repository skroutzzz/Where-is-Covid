<?php

require_once "config.php";

$sql = "SELECT * FROM `mypois`";

$query = mysqli_query($link, $sql);
$result_count = mysqli_num_rows($query);
/*
if ($result_count> 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($query)) {
      echo "LON: " . $row["longtitude"]. " - LAN: " . $row["latitude"]. "<br>";
    }
  } else {
    echo "0 results";
  }
  */

  $data = array();
    //echo "  [ " ;

for ( $x = 0; $x < $result_count; $x++) {
    $data[] = mysqli_fetch_assoc( $query);
    //echo " [ " , $data[ $x][ 'latitude' ], " , " , $data[ $x][ 'longtitude' ], " ] " ;
    if ( $x <= ( $result_count - 2) ) {
        //echo " , " ;
    }
}
    //echo " ]; " ;
?> 