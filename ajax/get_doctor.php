<?php
include_once "../classes/config.php";
$conn=new DBConnect();
if(isset($_GET['specialization'])){
    $specialization=$_GET['specialization'];
    $result=$conn->total_rows("users","username","where specialization='$specialization' and role='doctor';");
    // $result=$conn->select("users",['specialization','role'],[$specialization,'doctor']);
    $arr=array();
        foreach($result as $row)
        {
            array_push($arr,$row);
        }
    echo json_encode($arr);
}
    else{
        echo "Error";
    }
?>