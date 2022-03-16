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
</head>
<body>
    <div class="container">
      
                <?php
                    include_once "../classes/config.php";
                    $conn=new DBConnect();
                    $doctor_name=space_removal($_SESSION["username"]);
                    $i=0;
                    $result=$conn->select("cancelled_appointment");
                    if(count($result)>0)
                    {?>

                         <table class="table">
                            <!-- <tr>
                                <td>S.N</td>
                                <td>Patient Name</td>
                                <td>Cancelled Date</td>
                                <td>Reason</td>
                            </tr> -->

               <?php
               include_once "../classes/dynamic_table.php";
               table("See Cancelled Appointments",["S.N","Patient Name","Cancelled On","Reasons"],["id","patient_name","cancelled_on","reason"],"10","cancelled_appointment");
                        // foreach($result as $row){
                        //     echo "<tr>";
                        //         echo "<td>";
                        //         echo ++$i;
                        //         echo "</td>";
                        //         echo "<td>";
                        //         echo $row["patient_name"];
                        //         echo "</td>";
                        //         echo "<td>";
                        //         echo date("Y/m/d",$row["cancelled_on"]);
                        //         echo "</td>";
                        //         echo "<td>";
                        //         if ($row["reason"]==0) $row["reason"]="No reason";
                        //         echo $row["reason"];
                        //         echo "</td>";
                        //     echo "</tr>";
                        // }
                    }
                    else{
                        include_once "../classes/alerts.php";
                        small_alert("No cancelled appointments yet!");
                    }
                ?>
        </tbody>
       </table>
        
    </div>
</body>
</html>