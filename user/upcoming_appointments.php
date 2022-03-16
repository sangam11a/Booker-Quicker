<link rel="stylesheet" href="../css/buttons.css">
<?php
include_once "../admin/dashboard.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/table.css">
    <title>Doctor index</title>
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
    </script>
</head>
<body>
    <div class="container">
      
                <?php
                    include_once "../classes/config.php";
                  
                    $conn=new DBConnect();
                    $patient_name=$_SESSION["username"];
                    $i=0;
                    $result=$conn->select("appointment",["patient_name","status"],["$patient_name",'0']);
                    if(count($result)>0)
                    {?>
                        <caption><h3>Upcoming Appointments</h3></caption>
                         <table class="table">
                            <tr>
                                <td>S.N</td>
                                <td>Patient Name</td>
                                <td>Appointment Date</td>
                                <td>Appointment Time</td>
                                <td>Options</td>
                            </tr>

               <?php
                        foreach($result as $row){
                            echo "<tr>";
                                echo "<td>";
                                echo ++$i;
                                echo "</td>";
                                echo "<td>";
                                echo $row["patient_name"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["appointment_date"];
                                echo "</td>";
                                echo "<td>";
                                echo $row["appointment_time"];
                                echo "</td>";
                                echo "<td>";
                                echo "<button id='booking_btn' onclick='change_details(\"".$row['id']."\",\"".$row["patient_name"]."\",\"".$row["appointment_date"]."\",\"".$row["appointment_time"]."\",\"reschedule\",\"".$row["doctor_name"]."\")'>Reschedule</button>
                                <button id='booking_btn' onclick='change_details(\"".$row["patient_name"]."\",\"".$row["appointment_date"]."\",\"".$row["appointment_time"]."\",\"cancel\")'>Cancel Appointments</button>";
                                
                                echo "<button id='booking_btn' class='z_index' onclick='gen_token(\"".$row['id']."\",\"".$row['patient_name']."\",\"".$row['doctor_name']."\",\"".$row['appointment_date']."\",\"".$row['appointment_time']."\")'>Generate Ticket</button>";echo "</td>";

                            echo "</tr>";
                        }
                    }
                    else{
                        include_once "../classes/alerts.php";
                        small_alert("No appointments yet!");
                    }
                ?>
        </tbody>
       </table>
        <form action="" method="post" id='changess'>
            <input type="hidden" name="id" id="id" >
            <input type="hidden" name="p_name" id="p_name" >
            <input type="hidden" name="appt_date" id="appt_date">
            <input type="hidden" name="appt_time" id="appt_time">
            <input type="hidden" name="doctor_name" id='doctor_name'>
            <input type="hidden" name="action" id="action">
        </form>
    </div>
    
</body>
</html>
<?php
include_once "../classes/config.php";
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
      
        </form>
        ";
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
// if(isset($_POST["appt_time2"])&&isset($_POST['p_name2'])&&isset($_POST["action2"])){
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
  if(isset($_POST['cancel'])){
  $id=$_POST['id2'];
    $p_name=$_POST["pat_name4"];
    $appt_date=$_POST["appt_date4"];    
    $appt_time=$_POST["appt_time4"];    
    if(isset($_POST['reason'])) $reason=$_POST['reason'];
   else $reason=0;
   echo $id,$p_name,$appt_date,$appt_time;
    $result5=$conn->deletion("appointment",['patient_name','appointment_date','appointment_time'],[$id,$p_name,$appt_date]);
    $result6=$conn->updation("availability",['status'],[0],['start_time','status'],[$appt_date,1]);
    $result7=$conn->insertion("cancelled_appointment",
    ['patient_name','appointment_date','appointment_time','cancelled_on','reason'],
    [$id,$patient_name,$appt_date,time(),$reason]);
    if($result5&$result6&$result7){  echo "<script src='../classes/refresh.js'></script>";
        small_alert("Appointment scheduled for $appt_date at $appt_time has been cancelled.This page will redirect in <span id='sec'></span> seconds.<script>refreshing(3);</script>");
    }
  }
?>

<script>
    function date_change(val,val2){
        document.getElementById("result").innerHTML = "";
        var str="";
        str=val;
       var d_old_name=val2;
      document.getElementById("doctor_name").value=d_old_name;
      var d_name = d_old_name;//.replace(/\s/g, '_')+"_";
       var request = new XMLHttpRequest();
       var url="../ajax/doctor_avail.php";
       request.open("GET", url+"?date="+str+"&doctor_name="+d_name);
        var table="<h5>Available Time Slots:</h5><div style='display:grid;grid-template-columns:50% 50%;'>";
    // Defining event listener for readystatechange event
        request.onreadystatechange = function() {
            // Check if the request is compete and was successful
            if(this.readyState === 4 && this.status === 200) {
                var data=JSON.parse(this.responseText);
                console.log(data);
                // Inserting the response from server into an HTML element
              if(data.length>0) 
              {j=0;
                for(i=0;i<data.length;i++){
                    // if(j==0) table+="<tr>";
                    table+="<a id='booking_btn' onclick='getting_time(\""+data[i]["id"]+"\",\""+d_name+"\",\""+str+"\",\""+data[i]["start_time"]+"\",\""+data[i]["stop_time"]+"\")'>"+data[i]['start_time']+" - "+data[i]['stop_time']+"</a>";
                    // j++;
                    // if(j==4) table+="</tr>";
                    // j=j%4;
                }
                table+="</div>"
                document.getElementById("result").innerHTML =table;
              } 
                else document.getElementById("result").innerHTML ="No schedule of DR."+d_old_name+" in "+str+"Please choose another day";
            }
        };

        // Sending the request to the server
        request.send();
    }
    function getting_time(a,b,c,d,e){
        
        document.getElementById('reschedule').style.display='inline-block';
        document.getElementById('new_time').value=d;
        document.getElementById('new_id').value=a;
    }
</script>