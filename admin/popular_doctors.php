<?php
include_once "../classes/config.php";
$conn=new DBConnect();
$result=$conn->own_query("SELECT count(*),doctor_name FROM `appointment` group by doctor_name;");
echo json_encode($result);
?>