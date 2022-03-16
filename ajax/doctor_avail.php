<?php
include_once "../classes/config.php";
if(isset($_GET["doctor_name"])){
    $date=$_GET["date"];
    $date=str_replace("-","/",$date);
    $doctor_name=$_GET["doctor_name"];
    $conn=new DBConnect();
    $array=array();
    $result=$conn->total_rows("availability","*","where doctor_name='$doctor_name' and available_day='$date';");
    if(count($result)>0){
        foreach($result as $row){
         if($row['status']==0) array_push($array,$row);
        }
        echo json_encode($array);
    }
    else{
        echo "0";
    }
}
else{
    echo "100";
}
?>