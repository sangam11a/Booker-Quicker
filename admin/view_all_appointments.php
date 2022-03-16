<link rel="stylesheet" href="../css/table.css">
<style>
    .z_index{
        z-index: 9999;
        position: relative;
    }
</style>
<?php
include_once "../admin/dashboard.php";
include_once "../classes/config.php";
include_once "../classes/alerts.php";
$conn=new DBConnect();
$result=$conn->select("appointment",['status'],[0]);
$count=count($result);
if($count==0){
    include_once "../classes/alerts.php";
    small_alert("No appointments yet.");
}
else{$i=0;
   echo "<caption><h3 style='color:#008368;'>View All Appointments</h3></caption><table class='table'><tr><td>S.N</td><td>Patients Name</td><td>Doctors Name</td><td>Appointment Date</td><td>Appointment Time</td><td>Option</td></tr>";
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
             echo "<td>";
                echo "<button class='z_index' onclick='cancel_appt(\"".$row['id']."\",\"".$row['patient_name']."\",\"".$row['doctor_name']."\",\"".$row['appointment_date']."\",\"".$row['appointment_time']."\")'>Cancel Appointment</button>"
                ."<button class='z_index' onclick='gen_token(\"".$row['id']."\",\"".$row['patient_name']."\",\"".$row['doctor_name']."\",\"".$row['appointment_date']."\",\"".$row['appointment_time']."\")'>Generate Ticket</button>";
                if($row['payment_status']==0) echo "<button onclick='payment_modal(\"".$row['id']."\",\"".$row['service_charge']."\")'>Make payment</button>";
            echo "</td>";
        echo "<tr>";
    }
   echo "</table>";
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
print_r($array3);
$arr=explode("^",$array3);
$input="
        <form method='post' action=''>
            Patient Name<input type='text' name='' id='' value='".$arr[2]."' readonly>
           <br> Doctor Name<input type='text' name='' id='' value='".$arr[3]."' readonly>
           <br>Appointment Date <input type='text' name='' id='' value='".$arr[4]."' readonly>
           <br>Appointment Time<input type='text' name='' id='' value='".$arr[7]."' readonly>
           <br> Service:<input type='text' name='' id='' value='".$arr[5]."' readonly>
           <br>Service Charge <input type='text' name='' id='' value='".$arr[6]."' readonly>
           <br>Patient_reason<textarea type='text' name='' id='' value='' readonly>".$arr[9]."</textarea>
           <br> <button onclick=''>Cancel</button>
        </form>
    ";
    modal("View Appointment",$input);
}

if(isset($_POST['id22'])&&isset($_POST['service_charge'])){
    $id=$_POST['id22'];
    $price=$_POST['service_charge'];
    $input="
    <form method='post' action=''>
    <input type='hidden' name='id3' value='$id'>
     To pay:<input type='text' value='$price' readonly><br>
     Paying amount:<input type='number' name='payment' onkeyup='val(this.value,\"$price\")'>
     <br><button type='submit' id='pay' name='pay' disabled>Pay</button>
     <button onclick='this.parentNode.parentNode.style.display=\"none\";'>Cancel payment</button>
    </form>
    ";
    modal("Pay Service Charge",$input);
}
if(isset($_POST['pay'])&&isset($_POST['id3'])){
    $id=$_POST['id3'];
    $result=$conn->updation("appointment",['payment_status'],[date("Y/m/d")],['id'],[$id]);
    $gen="".md5(time());
    $gen= substr($gen,-6);
    include_once "../payment/setting.php";
    $result11=$conn->insertion("transactions",
    ["id","transaction_code","bill_number","payment_date"],
    [$id,$gen,$pid,date("Y/m/d")]
    );
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