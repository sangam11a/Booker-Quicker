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
        function modal(x){
            document.getElementById('array').value=x;
            document.getElementById('row_clicked').submit();
        }
    </script>
</head>
<body>
    <div class="container">
      
                <?php
                    include_once "../classes/config.php";
                    $conn=new DBConnect();
                     if(isset($_SESSION["username"])) $doctor_name=space_removal($_SESSION["username"]);
                    $i=0;
                    $result=$conn->select("appointment",["doctor_name","status"],["$doctor_name",'0']);
                    if(count($result)>0)
                    {?>
                        <caption><h2>Appointments</h2><span>Click on appointment to view and enter dagnosis</span></caption>
                         <table class="table">
                            <tr>
                                <td>S.N</td>
                                <td>Patient Name</td>
                                <td>Appointment Date</td>
                                <td>Appointment Time</td>
                                <td>Reason</td>
                            </tr>
               <?php
                        foreach($result as $row){
                            if($row['doctor_reason']=="0"){
                                $arr=implode("^",$row);
                                echo "<tr onclick='modal(\"".$arr."\")'>";
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
                                echo $row["patient_reason"];
                                echo "</td>";
                            echo "</tr>";
                            }
                        }
                    }
                    else{
                        include_once "../classes/alerts.php";
                        small_alert("No appointments yet!");
                    }
                ?>
        </tbody>
       </table>
        <div>
        <form action="" method="post" id='row_clicked'>
            <input type="hidden" name="array" id='array'>
        </form>
        </div>
    </div>
</body>
</html>
<?php
include_once "../classes/config.php";
include_once "../classes/modal.php";
echo "<script src='../classes/refresh.js'></script>";
if(isset($_POST['array'])){
$array=$_POST['array'];
$arr=explode("^",$array);
$result3=$conn->select("appointment",['status','patient_id'],[1,$arr[1]]);
$input="
        <form method='post' action=''>
        <input type='hidden' id='id' name='id' value='".$arr[0]."'>
            Patient Name<input type='text' name='patient_name' id='patient_name' value='".$arr[2]."' readonly>
           <br> Doctor Name<input type='text' name='doctor_name' id='doctor_name' value='".$arr[3]."' readonly>
           <br>Appointment Date <input type='text' name='' id='' value='".$arr[4]."' readonly>
           <br> Appointment Time<input type='text' name='' id='' value='".$arr[7]."' readonly>
           <br>Patient_reason<textarea type='text' name='' id='' value='' rows=10 cols=20 readonly>".$arr[9]."</textarea>
           <br>Doctor's Prescription(Diagnosis)<textarea name='doctor_reason' rows=10 cols=20></textarea>
           <br><input type='submit' name='diagnosed' id='diagnosed'>
            <button onclick='this.parentNode.parentNode.style.display=\"none\";'>Cancel</button>
        </form>
    ";
  if(count($result3)>0){
    $input.="<caption>Past History</caption><table><tr><td>S.N</td><td>Patient Reason</td><td>Doctor Reason</td></tr>";
    $j=0;
    foreach($result3 as $row3){

        $j++;
        $input.="
        <tr>
            <td>$j</td>
            <td>".$row3['patient_reason']."</td>
            <td>".$row3['doctor_reason']."</td>
        </tr>
        ";
    }
  }

    modal("Edit Appointment",$input);
}

if(isset($_POST['doctor_reason'])&&isset($_POST['diagnosed'])){
    $doctor_reason=$_POST['doctor_reason'];
    $id=$_POST["id"];
    $result=$conn->updation("appointment",['doctor_reason','status'],[$doctor_reason,1],['id'],[$id]);
    if($result){
        include_once "../classes/alerts.php";
        echo "<script src='../classes/refresh.js'></script>";
            small_alert("Prescription has been added. <h5>This page will automatically redirect in <span id='sec'></span> seconds.<script>refreshing(3);</script></h5>");
        }
    }   

?>