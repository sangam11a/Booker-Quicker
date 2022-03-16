<?php
include_once "../admin/dashboard.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Index</title>
</head>
<style>
    
</style>
<body>
    <div class="container wrapper" > 
        <?php        
        $patient_name=$_SESSION["username"];
            include_once "../classes/alerts_own.php";
            include_once '../classes/config.php';
            $conn=new DBConnect();
            $result=$conn->own_query("Select * from appointment where patient_seen=0 and appointment_date>='".date("Y/m/d")."' and patient_id='".generate_id("".$_SESSION["id"])."' and appointment_time<'".date("H:i:s")."'");
           if (count($result)>0)
           {
                foreach($result as $row){
                    alert_display("There is an appointment dated :". $row['appointment_date']." at ".$row['appointment_time'],"Upcoming Appointment",$row["id"]);
                }
            }
            // print_r($result);
            $result1=$conn->own_query("Select * from appointment where patient_seen=0 and appointment_date<='".date("Y/m/d")."' and patient_id='".generate_id("".$_SESSION["id"])."' and appointment_time>'".date("H:i:s")."'");
            if (count($result1)>0)
            {
                 foreach($result1 as $row){
                     alert_display("Appointment dated :". $row['appointment_date']." at ".$row['appointment_time']."has been missed","Missed Appointment",$row["id"],"red");
                 }
             }
            if(count($result)==0&&count($result1)==0){
               include_once "../classes/alerts.php";
               small_alert("No appointments yet");
            }
        ?>
    </div>
</body>
</html>
<?php
include_once "../classes/config.php";
$conn=new DBConnect();
if(isset($_POST['id'])){
    $id=$_POST['id'];
    $result1=$conn->updation("appointment",['patient_seen'],[1],['id'],[$id]);
    if($result1) 
         echo"<script>location.href=location.href;</script>";
}
?>