<?php
include_once "../admin/dashboard.php";
include_once "../classes/config.php";                            
    $conn=new DBConnect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Working days</title>
</head>
<body>
            <?php
                include_once "../classes/config.php";
                $doctor_name=$_SESSION["username"];
                $d_name=str_replace(" ","_",$doctor_name)."_";
                ?>
                <form action="" method="post">
                <caption><h2>Add Working Days</h2></caption>
                <table class="table">

            <tr>
                <td>Select Date</td>
                <td>
                        <!-- <select name="days" id="days">
                            <option value="">Select days</option>
                            <option value="Sun">Sun</option>
                            <option value="Mon">Mon</option>
                            <option value="Tue">Tue</option>
                            <option value="Wed">Wed</option>
                            <option value="Thurs">Thurs</option>
                            <option value="Fri">Fri</option>
                            <option value="Sat">Sat</option>
                        </select> -->
                        <input type="date" name="days" id="days">
                </td>
            </tr>
                <tr>
                    <td>Select Start time(Hr:Min)</td>
                <td>
                        <?php
                        echo '<select name="hours" id="hours" required><option>Select Hours</option>';
                            for($i=0;$i<=23;$i++){
                                if($i<=9) echo "<option value=0".$i.">$i</option>";
                                else echo "<option value=".$i.">$i</option>";
                            }
                            echo '</select>';
                        ?>
                <!-- </td>
            <tr> -->
                <td>
                        <?php
                        echo '<select name="minutes" id="minutes" required><option>Select Minutes</option>';
                            for($i=0;$i<=59;$i++){
                                if($i<=9) echo "<option value=0".$i.">$i</option>";
                                else echo "<option value=".$i.">$i</option>";
                            }
                            echo '</select>';
                        ?>
                </td>
            </tr>
            <tr>
                <td>Enter duration:</td>
                <td>
                        <input type="number" name="duration" id="duration" placeholder="Duration" required>
                </td>
            </tr>
            <tr>
                <td>Average Check Up Time</td>
                <?php
                    $result22=$conn->own_query("Select * from average where doctor_name='".$d_name."'");
                    if(count($result22)>0) {$avgg=$result22[0]["average"];}
                    else {$avgg=0;}
                ?>
                <td>
                      <input type="number" name="average" id="average" placeholder="Average checkup time in minutes" <?php echo "value='".$avgg."'"; if($avgg!="0") {echo "readonly";}?> >
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="Allocate Time" name='allocate'>
                </td>
            </tr>
                
                </table>
            </form>

            <?php
            if(isset($_POST['allocate'])){
                $days=$_POST['days'];
                $days=str_replace("-","/",$days);
                $hours=$_POST['hours'];
                $minutes=$_POST["minutes"];
                $duration=$_POST['duration'];
                $avg=$_POST["average"];
                
                $total=intval($hours)*60+intval($minutes);
                $result=$conn->create_tbl($doctor_name,$days,"$hours:$minutes:00",$duration);
                // $result= $conn->updation($d_name,['start_time','duration'],["$hours:$minutes:00","$duration"],['days'],[$days]);
               if($result=="1"){  
                $patients=intval($duration/$avg);
                $result11=$conn->updation("average",['average'],[$avg],['doctor_name'],[$d_name]);             
                for($i=0;$i<$patients;$i++){
                    $stop_time=time_calc(["$hours","$minutes"],$avg);                   
                    $result2=$conn->insertion('availability',
                    ['doctor_name','available_day','start_time','stop_time'],
                    ["$d_name","$days","$hours:$minutes:00","$stop_time[0]:$stop_time[1]:00"]);
                    $hours=$stop_time[0];
                    $minutes=$stop_time[1];
                }
                include_once "../classes/alerts.php";
                echo "<script src='../classes/refresh.js'></script>";
                small_alert("Working days has been added successfully.This page will refresh in <span id='sec'></span> seconds.<script>refreshing(3);</script>");
              }
            }
            ?>
</body>
</html>