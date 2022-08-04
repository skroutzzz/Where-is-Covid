<?php 

require_once "config.php";

//$targetPath = "uploads/" . basename($_FILES["inpFile"]["name"]);
//move_uploaded_file($_FILES["inpFile"]["tmp_name"], $targetPath);

$jsondata = file_get_contents('uploads/generic.json');
$array = json_decode($jsondata, true);

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
    mysqli_stmt_close($stmt);
}


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
    mysqli_stmt_close($stmt);
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
    mysqli_stmt_close($stmt);
}


?>