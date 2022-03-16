<link rel="stylesheet" href="../css/table.css">
<style>
    .z_index{
        z-index: 9999;
        position: relative;
    }
</style>
<script>
    function change_details(v,w,x,y,z,a){
            if(a==undefined&&z==undefined)
            {
                a=0;z=0;
            }
            console.log(v,w,x,y,z,a);
            if(a!=0) document.getElementById('doctor_name').value=a;
           document.getElementById('id').value=v;
           document.getElementById('p_name').value=w;
           document.getElementById('appt_date').value=x;
           document.getElementById('appt_time').value=y;
           document.getElementById('action').value=z;           
           document.getElementById('changess').submit();

        }
    function getting_time(a,b,c,d,e){
        
        document.getElementById('reschedule').style.display='inline-block';
        document.getElementById('new_time').value=d;
        document.getElementById('new_id').value=a;
    }
</script>
<?php
include_once "../admin/dashboard.php";
include_once "../classes/config.php";
include_once "../classes/alerts.php";
$conn=new DBConnect();
$id2=generate_id("".$_SESSION["id"]);
$result=$conn->select("appointment",["patient_id"],[$id2]);
$count=count($result);
if($count==0){
    include_once "../classes/alerts.php";
    small_alert("No appointments yet.");
}

else{$i=0;
   echo "<caption><h3>Booking History</h3></caption>
   <p style='color:#007860'>Click on each row to get detailed information.</p>
   <table class='table'><tr>
   <td>S.N</td><td>Patients Name</td><td>Doctors Name</td>
   <td>Appointment Date</td><td>Appointment Time</td></tr>";//<td>Option</td>
    foreach($result as $row){
        $arr=implode("^",$row);
        echo "<tr>";
            echo "<td onclick='modal(\"".$arr."\")'>";
            echo ++$i;
            echo "</td>";
            echo "<td onclick='modal(\"".$arr."\")'>";
                echo ucfirst($row["patient_name"]);
            echo "</td>";
            echo "<td onclick='modal(\"".$arr."\")'>";
                echo ucfirst(str_replace("_"," ",$row["doctor_name"]));
            echo "</td>";
            echo "<td onclick='modal(\"".$arr."\")'>";
                echo $row["appointment_date"];
            echo "</td>";
            echo "<td onclick='modal(\"".$arr."\")'>";
                echo $row["appointment_time"];
            echo "</td>";
            //  echo "<td>";
            //     echo "<button class='z_index' onclick='cancel_appt(\"".$row['id']."\",\"".$row['patient_name']."\",\"".$row['doctor_name']."\",\"".$row['appointment_date']."\",\"".$row['appointment_time']."\")'>Cancel Appointment</button>"
            //     ."<button class='z_index' onclick='gen_token(\"".$row['id']."\",\"".$row['patient_name']."\",\"".$row['doctor_name']."\",\"".$row['appointment_date']."\",\"".$row['appointment_time']."\")'>Generate Ticket</button>";
            //     echo "<button onclick='change_details(\"".$row['id']."\",\"".$row["patient_name"]."\",\"".$row["appointment_date"]."\",\"".$row["appointment_time"]."\",\"reschedule\",\"".$row["doctor_name"]."\")'>Reschedule</button>";
            //    echo "</td>";
        echo "<tr>";
    }
   echo "</table>";
}

include_once "../classes/modal.php";
include_once "../classes/alerts.php";
if(isset($_POST['appt_date'])&&isset($_POST["appt_time"])&&isset($_POST['p_name'])&&isset($_POST["action"])){
    //    include_once "../classes/modal.php";
        $p_name=$_POST["p_name"];
        $id=$_POST["id"];
        $appt_date=str_replace("/","-",$_POST["appt_date"]);
        $appt_time=$_POST["appt_time"];
        $action=$_POST["action"];
        if($action=='reschedule'){
            $body="<form action='' method='post' id='update'>
            <input type='hidden' id='id1' name='id1' value='$id'>
            Name :<input type='text' name='p_name2' value='$p_name' readonly>
            <br> Doctor's Name: <input type='text' name='doctor_name' value='".$_POST['doctor_name']."' readonly>
            <br> Appointment Date: <input type='text' name='appt_date1' value='".$appt_date."' readonly>
            <br>New Appointment Date :<input type='date' name='appt_date2'  onchange='date_change(this.value,\"".$_POST['doctor_name']."\")'>
            <input type='hidden' name='appt_time5' value='".$appt_time."'>
            <br>Time :<input type='text' name='appt_time2' value='".$appt_time."'>
            <input type='hidden' id='new_time' name='new_time'>
            <input type='hidden' id='new_id' name='new_id'>
            <br><div id='result'></div>
            <br><input type='submit' name='reschedule' id='reschedule' value='Reschedule' style='display:none;'>
            <button onclick='this.parentNode.parentNode.style.display=\"none\";'>No</button>
           ";
            if($row['doctor_reason']!='0'){
               $body.= "<a href='pescription.php?id=".$id.">Prescriptions</a>";               }
           
            $body.="</form>";
            modal("Reschedule appointment",$body);
            
        }
        else{
            $input="Are you sure you want to cancel appointment in $appt_date?<br>
            <form action='' method='post' >        
            <input type='hidden' id='id2' name='id2' value='$id'>
            <input type='hidden' id='pat_name4' name='pat_name4' value='$p_name'>
            <input type='hidden' id='appt_time4' name='appt_time4' value='$appt_time'>
            <input type='hidden' id='appt_date4' name='appt_date4'value='$appt_date'>
          <br>  <textarea name='reason' rows=10 cols=40 placeholder='Reasons if any'></textarea>
          <br> <input type='submit' value='Yes' name='cancel'> 
          <button onclick='this.parentNode.parentNode.style.display=\"none\";'>No</button>
          </form>";
           modal("Cancel Appointment",$input);
            // delete_modal($p_name,$appt_date,$appt_time,"Cancel appointment","Are you sure you want to cancel appointment scheduled in $appt_date?");
        }
    }
?>

<form action="" method="post" id='row_clicked'>
    <input type="hidden" name="array3" id='array3'>
</form>

<script>
    function modal(x){
        document.getElementById('array3').value=x;
        document.getElementById('row_clicked').submit();
    }
    function cancel_appt(v,w,x,y,z){
        // console.log(v,w,x,y,z);
        // document.getElementById("id").value=v;  
        document.getElementById("patient_name").value=w;        
        document.getElementById("appointment_date").value=y;
        document.getElementById("appointment_time").value=z;
        document.getElementById('cancel_appointment').submit();
    }
    function gen_token(v,w,x,y,z){
        // console.log(v,w,x,y,z)
        // document.getElementById("id2").value=v;          
        // document.getElementById("doctor_name2").value=x;  
        // document.getElementById("patient_name2").value=w;        
        // document.getElementById("appointment_date2").value=y;
        // document.getElementById("appointment_time2").value=z;
        var url="../invoice/invoice-format.php?doctor_name="+x+"&patient_id="+v+"&appointment_date="+y+"&appointment_time="+z;
        console.log(url);
        window.open(url,'_blank');
    }
    function payment_modal(x,y){
        console.log(x,y);
            document.getElementById('id22').value=x;
            document.getElementById('service_charge').value=y;
            document.getElementById('payment_modal').submit();
        }
        function val(x,y){
            if(x==y){
                document.getElementById('pay').disabled=false;
            }
            else{
                document.getElementById('pay').disabled=true;
            }
        }
</script>
<form action="" method="post" id="cancel_appointment">    
   <!-- <input type="hidden" name="id1" id="id1"> -->
    <input type="hidden" name="patient_name" id="patient_name">
    <input type="hidden" name="appointment_date" id="appointment_date">
    <input type="hidden" name="appointment_time" id="appointment_time">
</form>
<form action="" method="post" id="generate_token">
    <input type="hidden" name="id2" id="id2">    
    <input type="hidden" name="doctor_name2" id="doctor_name2">
    <input type="hidden" name="patient_name2" id="patient_name2">
    <input type="hidden" name="appointment_date2" id="appointment_date2">
    <input type="hidden" name="appointment_time2" id="appointment_time2">
</form>
<form action="" method="post" id='payment_modal'>
            <input type="hidden" name="id22" id="id22">
            <input type="hidden" name="service_charge" id="service_charge">
        </form>
<?php
include_once "../classes/config.php";
include_once "../classes/modal.php";
echo "<script src='../classes/refresh.js'></script>";
if(isset($_POST['array3'])){
$array3=$_POST['array3'];

$arr=explode("^",$array3);
print_r($arr);
$input="
       
            Patient Name<input type='text' name='' id='' value='".$arr[2]."' readonly>
           <br> Doctor Name<input type='text' name='' id='' value='".$arr[3]."' readonly>
           <br>Appointment Date <input type='text' name='' id='' value='".$arr[4]."' readonly>
           <br>Appointment Time<input type='text' name='' id='' value='".$arr[7]."' readonly>
           <br> Service:<input type='text' name='' id='' value='".$arr[5]."' readonly>
           <br>Service Charge <input type='text' name='' id='' value='".$arr[6]."' readonly>
           <br>Patient_reason<textarea type='text' name='' id='' value='' readonly>".$arr[9]."</textarea>
           <br> <button onclick='this.parentNode.parentNode.parentNode.style.display=\"none\";'>Close Modal</button>";
           if($arr[10]=='0'){
               
               }
               else{
                $input.= "<br><a  href='pescription.php?id=".$arr[0]."'>Prescriptions</a>";               
            
               }
        // $input.= "</form>";
    //     </form>
    // ";
    modal("View Appointment",$input);
}
if(isset($_POST['reschedule'])){
    $p_name=$_POST["p_name2"];
    $new_id=$_POST['new_id'];
     $appt_date=$_POST['appt_date2'];
    // if(isset($_POST['appt_date2'])) $appt_date=$_POST["appt_date2"];
     $appt_time=$_POST["new_time"];
    $appt_date=str_replace("-","/",$appt_date);    
    // if(isset($_POST["new_time"])) $appt_time=$_POST["new_time"];  
    echo "<script src='../classes/refresh.js'></script>";
    $id=$_POST['id1'];
    echo $appt_date,$appt_time;
    $conn=new DBConnect();
    $result3=$conn->updation("appointment",['patient_name','appointment_date','appointment_time'],[$p_name,$appt_date,$appt_time],['id'],[$id]);
        $result4=$conn->updation("availability",['status'],['1'],['id'],[$new_id]);
        $result5=$conn->updation("availability",['status'],['0'],['start_time'],[$_POST['appt_time2']]);
        if($result3&$result4&$result5){
           small_alert("Appointment has been rescheduled to $appt_time successfully. The page will redirect in <span id='sec'></span> seconds.<script>refreshing(3);</script>");
        }
  }
if(isset($_POST['pay'])&&isset($_POST['id3'])){
    $id=$_POST['id3'];
    $result=$conn->updation("appointment",['payment_status'],[date("Y/m/d")],['id'],[$id]);
    echo "<Script src='../classes/refresh.js'></script>";
    if($result){
     small_alert("Payment of RS ".$_POST["payment"]." has been completed .This page will automatically refresh in <span id='sec'></span> seconds.<script>refreshing(2);</script>");
    }
}
if(isset($_POST['patient_name'])&&isset($_POST['appointment_date'])&&isset($_POST["appointment_time"])){
    $patient_name=$_POST["patient_name"];
    $appointment_date=$_POST["appointment_date"];
    $appointment_time=$_POST["appointment_time"];
    $input='
    <form action="" method="post" >    
    <input type="hidden" name="patient_name2" id="patient_name2" value="'.$patient_name.'">
    <input type="hidden" name="appointment_date2" id="appointment_date2" value="'.$appointment_date.'">
    <input type="hidden" name="appointment_time2" id="appointment_time2" value="'.$appointment_time.'">
    <br>  <textarea name="reason" rows=10 cols=40 placeholder="Reasons if any"></textarea>
    <br><input type="submit" value="Yes" name="del">
    <button onclick="this.parentNode.parentNode.style.display=\"none\";">No</button>
    </form>
    ';
    modal("Cancelled Appointment","Are you sure you want to cancel appointment of $patient_name scheduled in $appointment_date?".$input);
//    modal($patient_name,$appointment_date,$appointment_time,"Cancel appointment","Are you sure you want to cancel appointment of $patient_name at $appointment_date?","Cancel appointment");
   }
 
//    if(isset($_POST['patient_name2'])&&isset($_POST['appointment_date2'])&&isset($_POST["appointment_time2"])){
//     // include_once "../invoice/invoice-format.php";
//     $patient_name=$_POST["patient_name2"];
//     $appointment_date=$_POST["appointment_date2"];
//     $appointment_time=$_POST["appointment_time2"];
//     $id=$_POST["id2"];
//     $doctor_name=$_POST["doctor_name2"];
//     $url="../invoice/invoice-format.php?doctor_name=$doctor_name&patient_id=$id&appointment_date=$appointment_date&appointment_time=$appointment_time";
//     echo "<script>location.href='$url'</script>";
//     // header("Location:$url");
//     // $input2=invoice();
//     // $input2.="<br><button>Download Token</button><button onclick='this.parentNode.parentNode.parentNode.style.display=\"none\";'>Cancel</button>";
//     // modal("Generate token",$input2);
// //    modal($patient_name,$appointment_date,$appointment_time,"Cancel appointment","Are you sure you want to cancel appointment of $patient_name at $appointment_date?","Cancel appointment");
//    }
 
  if(isset($_POST['del'])){
    echo "<script src='../classes/refresh.js'></script>";
    $patient_name=$_POST["patient_name2"];
    $appointment_date=$_POST["appointment_date2"];
    $appointment_time=$_POST["appointment_time2"];
    $result11=$conn->deletion("appointment",['patient_name','appointment_date','appointment_time'],
    [$patient_name,$appointment_date,$appointment_time]);
    $result12=$conn->updation("availability",['status'],[0],['start_time','status'],[$appointment_time,1]);
    $result13=$conn->insertion("cancelled_appointment",
    ['patient_name','appointment_date','appointment_time','cancelled_on','reason'],
    [$patient_name,$appointment_date,$appointment_time,time(),$_POST['reason']]);
    if($result11&&$result12&&$result13){
        small_alert("Appointment scheduled on $appointment_date at $appointment_time has been successfully cancelled. <h5>This page will automatically refresh in <span id='sec'></span> seconds.<script>refreshing(3);</script></h5>");
    }
}
?>