<?php
include_once "../classes/config.php";
$conn=new DBConnect();
$arr1=array();
if(isset($_GET["id"])){
    if($_GET["id"]=="1")
    {$result1=$conn->own_query("SELECT count(*),appointment_date FROM `appointment` group by appointment_date;");
        foreach($result1 as $arr){
            array_push($arr1,array("count"=>$arr["count(*)"],"name"=>$arr["appointment_date"]));
        }
        echo json_encode($arr1);
    }
    else{
        $result1=$conn->own_query("SELECT sum(service_charge),appointment_date FROM `appointment` group by appointment_date;");
        foreach($result1 as $arr){
            array_push($arr1,array("count"=>$arr["sum(service_charge)"],"name"=>$arr["appointment_date"]));
        }
        echo json_encode($arr1);
    }
}
?>