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
    <div class="container" > 
        <?php        
            include_once "../classes/alerts_own.php";
            include_once '../classes/config.php';
            $doctor_name=$_SESSION["username"];
            $doctor_name=space_removal(trim($doctor_name));
            $conn=new DBConnect();
            // $result=$conn->select("appointment",['doctor_name'],[$doctor_name]);
            $result=$conn->own_query("Select * from appointment where doctor_seen=0 and doctor_name='".$doctor_name."' and appointment_date>='".date("Y/m/d")."'");
           if (count($result)>0)
           {
                foreach($result as $row){
                    alert_display("There is an appointment dated :". $row['appointment_date']." at ".$row['appointment_time']." with ".$row['patient_name'],"Upcoming Appointment",$row["id"]);
                }
            }
            else{
               include_once "../classes/alerts.php";
               small_alert("No appointments booked till date");
            }
            
            // $count= $row->rowCount();
        ?>
    </div>
</body>
</html>
<?php
include_once "../classes/config.php";
$conn=new DBConnect();
if(isset($_POST['id'])){
    $id=$_POST['id'];
    $result1=$conn->updation("appointment",['doctor_seen'],[1],['id'],[$id]);
    if($result1) 
         echo"<script>location.href=location.href;</script>";
}
?>
