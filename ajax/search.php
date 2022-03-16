<?php
if(isset($_GET['data'])){
    include_once "../classes/config.php";
    $conn=new DBConnect();
    $data=$_GET['data'];
    $result=$conn->total_rows("appointment","*","where patient_name LIKE '%$data%' or  patient_id LIKE '%$data%';");
    $arr=array();
    foreach($result as $row){
        array_push($arr,$row);
    }
    echo json_encode($arr);
}
else{
echo "Error";
}
?>