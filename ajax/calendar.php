<?php
if(isset($_GET['month'])&&isset($_GET['doctor_name'])&&isset($_GET['year'])){
    include_once "../classes/config.php";
    $username=$_GET['doctor_name'];
    $month=$_GET['month'];
    $year=$_GET['year'];
    if($month==0&&$year==0){
        $month=date('m');
        $year=date("Y");
    }
    $conn=new DBConnect();
    $arr=array();
    $endDate=date("t",mktime(0,0,0,$month,1,$year));//Total days
    $s=date ("w", mktime (0,0,0,$month,1,$year));//Day starts after
    array_push($arr,$s);    
    array_push($arr,$endDate);
    $result=$conn->total_rows("availability","distinct(available_day)","where doctor_name='$username';");
    foreach($result as $row){
        if(date("m",strtotime($row["available_day"]))==$month){
            array_push($arr,date("d",strtotime($row["available_day"])));
        }
    }
    echo json_encode($arr);
}
?>