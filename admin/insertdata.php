<?php 

require_once "config.php";

header('Content-Type: text/plain');

if(isset($_POST['formData'])){
    $received = utf8_encode($_POST['formData']);
    $pois = json_decode($received);
   // print_r($pois);
 
    

    foreach($pois as $temp){
        $poi_id = $temp->id;
        $poi_name = $temp->name;
        $poi_address = $temp->address;
        $rating = $temp->rating;
        $rating_n = $temp->rating_n;
        $populartimes = json_encode($temp->populartimes);
        $latitude = $temp->coordinates->lat;
        $longtitude = $temp->coordinates->lng;
        //$types = json_decode($temp->types);
        
        $poi_types = json_encode($temp->types);
        $i = 0;
        foreach($poi_types as $types){
            $poi_types = $types[$i];
            $i++;
        }
       
       $insert_pois = "INSERT INTO mypois(poi_id, poi_name, poi_address, rating, rating_n, populartimes, latitude, longtitude)
        VALUES ('$poi_id', '$poi_name', '$poi_address', '$rating', '$rating_n', '$populartimes', $latitude, $longtitude);";

       $insert_types = "INSERT INTO mypois_type(poi_type_id, poi_type_name)
       VALUES ('$poi_id','$poi_types');";
     
     try {
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $insert_pois);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "[SQL Success]";
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $insert_types);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo "[SQL Success]";
    }
    catch (Exception $err) {
        echo "[SQL Failed]";
        die;
    }

    }


   
}




/*


$targetPath = "uploads/" . basename($_FILES["inpFile"]["name"]);
move_uploaded_file($_FILES["inpFile"]["tmp_name"], $targetPath);

$mygetter = $_POST["FormData"];

$jsondata = file_get_contents($mygetter);
//$jsondata = file_get_contents('uploads/generic.json');
$array = json_decode($jsondata, true);
print_r($array);

//INSERT INTO MYPOIS

$stmt = $mysqli -> prepare("
    INSERT INTO mypois(poi_name, poi_address, rating, rating_n, populartimes)
    VALUES(?,?,?,?,?)

");

$stmt -> bind_param("ssiis", $poi_name, $poi_address, $rating, $rating_n, $populartimes);

foreach($array as $temp){
    $poi_name = $temp["name"];
    $poi_address = $temp["address"];
    $rating = $temp["rating"];
    $rating_n = $temp["rating_n"];
    $populartimes = $temp["populartimes"];

    $stmt -> execute();
    $mysqli -> close();
}

*/

/*
//INSERT INTO MYCOORD

$stmt = $mysqli -> prepare("
    INSERT INTO mycoord(latitude, longtitude)
    VALUES(?,?)
");

$stmt -> bind_param("dd", $latitude, $longtitude);

foreach($array as $temp){
    $latitude = $temp["latitude"];
    $longtitude = $temp["longtitude"];

    $stmt -> execute();
    $mysqli -> close();
}


//INSERT INTO MYPOISTYPE

$stmt = $mysqli -> prepare("
    INSERT INTO mypois_type(poi_type_name)
    VALUES(?)
");

$stmt -> bind_param("s", $poi_type_name);

foreach($array as $temp){
    $poi_type_name = $temp["types"];
    $stmt -> execute();
    $mysqli -> close();
}

*/
?>