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
    <title>Update working days</title>
</head>
<script>
    function average_val(x){
        console.log(x);
    }
    function duration_validate(x,y){
        console.log(x,y);
        if(x<y){
            document.getElementById('validate').innerHTML='<span style="color:red;font-size:12px;">*New duration cannot be less than old one</span>';
            document.getElementById('editing_routine2').style.display="none";
        }
        else{
            document.getElementById('validate').innerHTML=' ';
            document.getElementById('editing_routine2').style.display="inline-block";
        }
    }
</script>
<body>
    <div class="container">      
               <?php
                include_once "../classes/config.php";
                include_once "../classes/modal.php";
                $doctor_name=$_SESSION["username"];
                $doctor_name=space_removal($doctor_name);
                $conn=new DBConnect();
                $result=$conn->total_rows($doctor_name,"*", "");
                if(count($result)>0){
                    ?>
                    <caption><h3>View Working Days</h3></caption>
                     <table class="table">
                            <tr>
                                <td>S.N</td>
                                <td>Days</td>
                                <td>Start Time(hh:mm:ss) </td>
                                <td>Duration(minutes)</td>
                                <td>Option</td>
                            </tr>
                <?php
                $i=0;
                // echo "<pre>";
                // print_r($result);
                    foreach($result as $row){
                        echo "<tr>";
                        echo "<td>";
                        echo ++$i;
                        echo "</td>";
                        echo "<td>";
                         echo $row["days"];
                        echo "</td>";
                        echo "<td>";
                         echo $row["start_time"];
                        echo "</td>";
                        echo "<td>";
                         echo $row["duration"];
                        echo "</td>";
                        echo "<td>";
                        //   echo "<button name='delete_modal' onclick='delete_working(\"".$row["id"]."\",\"".$row['days']."\")'>Delete</button>";  
                        $avgg=time_calc(explode(":",$row["start_time"]),$row["duration"]);
                        $avg=$avgg[0].":".$avgg[1].":00";                
                          echo "<button name='edit_modal'  onclick='edit_working(\"".$row["days"]."\",\"".$row["start_time"]."%^&".$avg."\",\"".$row["duration"]."\")'>Edit</button>";
                        echo "</form></td>";
                        echo "</tr>";
                    }
                }
                else{
                    include_once "../classes/alerts.php";
                    small_alert("No working days set Please set it first.<a href='add_working_days.php' style='color:white;'>Click here</a> to assign days. ");
                }
                ?>
           </tbody>
       </table>
    </div>
    <div>
    <form action='' id='edit_data' method='post'>
                <input type="hidden" name="days" id="days">
                <input type="hidden" name="start_time" id="start_time">
                <input type="hidden" name="duration" id="duration">
    </form>
    <form action="" method="post" id="delete_data">
        <input type="hidden" name="id1" id="id1">
        <input type="hidden" name="days1" id="days1">
        <input type="hidden" name="start_time1" id="start_time1">
    </form>
    </div>
    <script>
        function edit_working(days,start_time,duration){
            document.getElementById('days').value=days;
            document.getElementById('start_time').value=start_time;
            document.getElementById('duration').value=duration;
            document.getElementById('edit_data').submit();
        }
        
    </script>
</body>
</html>



<?php
$days="";
// if(isset($_POST['id1'])&&isset($_POST['days'])&&isset($_POST['start_time1'])){
//     $input="<form method='post' action=''>
//         <input type='hidden' name='id2' value='".$_POST['id1']."'>
//         <input type='hidden' name='days2' value='".$_POST['days']."'>
//         <input type='hidden' name='start_time2' value='".$_POST['start_time1']."'>
//         <input type='submit' value='Yes' name='submit3'>
//         <button onclick='this.parentNode.parentNode.style.display=\"none\";'>No</button>
//     </form>";
// modal("Delete Working Days","Are you sure you want to delete working day scheduled for ".$_POST['days']." ?".$input);
// }
// if(isset($_POST['submit3'])&&isset($_POST['id2'])&&isset($_POST['days2'])&&isset($_POST['start_time2'])){
// $id=$_POST['id2'];
// $days=$_POST['days2'];
// $start_time=$_POST['start_time2'];
// $result11=$conn->select($doctor_name,['id'],[$id]);
// $duration=$result11[0]['duration'];
// $result=$conn->deletion($doctor_name,['id'],[$id]);
// $result12=$conn->select("average",['doctor_name'],[$doctor_name]);
// $avg=$result12[0]['average'];
// $array=explode($start_time,":");
// for($i=0;$i<$patients;$i++){
//     $stop_time=time_calc(["$array[0]","$array[1]"],$avg);                   
//      $result22=$conn->deletion('availability',['doctor_name','available_day','start_time'],["$d_name","$days","$hours:$minutes:00"]);
//     if($result22==0) break;
//      $array[0]=$stop_time[0];
//     $array[1]=$stop_time[1];
// }
// if($result22){
//     small_alert("Time schedule deleted");
// }
// }

if(isset($_POST['days'])&&isset($_POST['start_time'])&&isset($_POST['duration'])){
$days=$_POST['days'];
$start_time=explode("%^&",$_POST['start_time'])[0];
$duration=$_POST['duration'];
$average=$conn->total_rows("average","average"," where doctor_name='".$doctor_name."'");
$input='<form method="post" action=" " id="editing_routine"><label for="days_new">Days<br>
<input type="date" id="days_new" name="days_new" value='.str_replace("/","-",$days).' ><br>
</label>
<label for="start_time_new">Start Time(HH:MM:SS) HH:0-23<br>
<input type="hidden" id="start_time_new" name="start_time_old" value='.$_POST['start_time'].'>
<input type="text" id="start_time_new" name="start_time_new" value='.$start_time.'><br>
</label>
<label for="duration_new">Duration<br>
<input type="text" id="duration_new" name="duration_new" value='.$duration.' onkeyup="duration_validate(this.value,\''.$duration.'\')" readonly><span id="validate"></span><br>
</label>
<label for="average">Average<br>
<input type="number" id="average" name="average" value='.$average[0]["average"].' onkeypress="average_val(\'this\')"><br>
</label>
<input type="hidden" value="'.$days.'" name="days">
<br><span id="editing_routine2"><input type="submit" value="Edit" name="editing_routine" ></span>
<button onclick="this.parentNode.parentNode.style.display=\'none\';">Cancel</button>
';

modal("Edit Working Days",$input,"");
}
if(isset($_POST['editing_routine'])){
    //print_r($_POST);
    $days=$_POST['days'];
    $days_new=str_replace("-","/",$_POST['days_new']);
    $start_time_new=$_POST['start_time_new'];
    $ttt=explode(":",$start_time_new);
    
    $average=$_POST['average'];
    $stop_time_new=time_calc([$ttt[0],$ttt[1]],"$average");
    $start_time_old=explode("%^&",$_POST['start_time_old']);
    $duration_new=$_POST['duration_new'];
    $loop=intval($duration_new/$average);
    // $old_loop=
    $result=$conn->updation($doctor_name,['days','start_time','duration'],[$days_new,$start_time_new,$duration_new],['days'],[$days]);
    if($result=="1"){
        $array1=explode(":",$start_time_new);
        include_once "../classes/alerts.php";
        $result1=100;

        // $result2=$conn->select("availability",['doctor_name','available_day'],[$doctor_name,$days]);  
        $sql11="select a.id, a.doctor_name, a.available_day, a.start_time, a.stop_time, a.status,ap.id, ap.patient_id, ap.patient_name, ap.doctor_name, ap.appointment_date, ap.service, ap.service_charge, ap.appointment_time, ap.status, ap.patient_reason, ap.doctor_reason, ap.payment_status, ap.payment, ap.doctor_seen, ap.patient_seen from availability a inner join appointment ap on a.available_day=ap.appointment_date where ap.status=0 and a.status=1;
        ";
        $result11=$conn->own_query($sql11);
        $result12=$conn->own_query("Select max(id) from availability");
        $max_id=intval($result12[0]["max(id)"]);
        $result14=$conn->own_query("Select id,start_time,stop_time from availability where available_day='$days' and start_time='$start_time_old[0]'");
        //print_r($result14);
        $min_id=intval($result14[0]["id"]);
        $diff=$max_id-$min_id;
        $result13=$conn->own_query("Select id,status,start_time,stop_time,available_day from availability where available_day='$days' and start_time>='$start_time_old[0]' and stop_time<='".explode("%^&",$_POST['start_time_old'])[1]."'");
        //print_r($result13); 
        $result2=$conn->generic_func("Delete from availability where available_day='$days' and start_time>='$start_time_old[0]' and stop_time<='".explode("%^&",$_POST['start_time_old'])[1]."'");
        // echo "Delete from availability where available_day='$days' and start_time>='$start_time_old[0]' and stop_time<='".explode("%^&",$_POST['start_time_old'])[1]."'";
        
        $hours=$array1[0];
        $minutes=$array1[1];
        for($i=0;$i<$loop;$i++){
            $stop_time=time_calc(["$hours","$minutes"],$average);                            
            $result2=$conn->insertion('availability',
            ['doctor_name','available_day','start_time','stop_time'],
            [space_removal($_SESSION["username"]),"$days","$hours:$minutes:00","$stop_time[0]:$stop_time[1]:00"]);
            $hours=$stop_time[0];
            $minutes=$stop_time[1];
        }
        //echo "<script>alert('".$i."')</script>";
        // for($j=0;$j<$$start_time_old[0]/$start_time_old[1];$j++){
        //     $new_id=intval($max_id)+$j+1;

        // }
        // $result15=$conn->select("availability",["start_time","stop_time"],[$start_time_new,$stop_time_new]);
        $result15=$conn->own_query("Select * from availability where available_day='$days' and start_time>='$start_time_new' and stop_time<='".$start_time_new."'");
        foreach($result13 as $row15){
            if($row15["status"]=="1"){
                $idd=intval($row15["id"])+1+$diff;
                //echo $idd;
                $result21=$conn->updation("availability",['status'],[1],['id'],[$idd]); 
                $result23=$conn->select("availability",['id'],[$idd]);
                //print_r($result23);
                $result22=$conn->updation("appointment",
                ["appointment_date","appointment_time"],[$result23[0]["available_day"],$result23[0]["start_time"]],
                ["appointment_date","appointment_time"],[$row15["available_day"],$row15["start_time"]]);
            }
        }
        $result11=$conn->updation("average",['average'],[$average],['doctor_name'],[$doctor_name]);  

       if($result11=="1"){
           echo "<script src='../classes/script.js'></script>";
         small_alert("Updation of working schedule on $days_new has been updated.<h5>This page will automatically refresh in <span id='sec'></span> seconds.<script>refreshing(3);</script></h5>");
        unset($_POST["days"]);
       unset ( $_POST['start_time']);
       unset($_POST['days_new']);
       }
       else{
           small_alert("Some error while updating data");
       }
    }
    else{
        small_alert("Updation failed");
    }
}
?>
