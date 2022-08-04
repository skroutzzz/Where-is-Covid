<?php 

require_once "config.php";

$targetPath = "uploads/" . basename($_FILES["inpFile"]["name"]);
move_uploaded_file($_FILES["inpFile"]["tmp_name"], $targetPath);


$json = file_get_contents(FormData());
$data = json_decode($json);
echo $data[0];



//$filename = inpFile.files[0];  //NOT SURE
//$data = file_get_contents($filename);

//$array = json_decode($data, true);






?>