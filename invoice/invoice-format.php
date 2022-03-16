<?php
if(session_status()==PHP_SESSION_NONE){
    session_start();
}
?> 
   
<?php 
if(isset($_GET['doctor_name'])&&isset($_GET["patient_id"])&&isset($_GET["appointment_date"])&&isset($_GET["appointment_time"])){
    include_once "../classes/config.php";
    $conn=new DBConnect();
    $doctor_name=$_GET["doctor_name"];
    $appointment_date=$_GET["appointment_date"];
    $appointment_time=$_GET["appointment_time"];
    $result3=$conn->select("appointment",['doctor_name','appointment_date','appointment_time'],[$doctor_name,$appointment_date,$appointment_time]);
    $doctor_name=trim(remove_underscore($doctor_name));
    $patient_id=$result3[0]['patient_id']; 
    $patient_name=$result3[0]['patient_name'];
    $result=$conn->select("users",['username'],[$patient_name]);
    $result2=$conn->select("users",['username','role'],[$doctor_name,'doctor']);
    $specialization=$result2[0]["specialization"];
     // // $address=$result[0][""];
     
    $age=$result[0]["age"];
    $service=$result3[0]['service'];
    $service_charge=$result3[0]["service_charge"];
    
    $payment_status=$result3[0]["payment_status"];
    // print_r($result3);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="invoice-style.css">
    <title>Invoice</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
    <script>
        function print_invoice(){
            document.getElementById('buttons').style.display='none';
            document.getElementById('esewa_pay').style.display='none';
            console.log(window.print());            
            document.getElementById('buttons').style.display='block';
            document.getElementById('esewa_pay').style.display='block';
        }
    </script>
</head>
<body>
    <div class="invoice_main" id='content'>
                <div class="invoice_header">
                    <h1>Doctor Sathi Hospital</h1>
                    <p>Kathmandu-10,Nepal</p>

                </div>
                <div class="below_invoice_header">
                    <div class="invoice_date"><b>Date:</b> <?=date("Y/m/d")?></div>
                    <div class="invoice__id"><b>Invoice No:</b>
                    <?php 
                        include_once "../payment/setting.php";
                        echo $pid;
                    ?>
                    </div>
                </div>

                <div class="invoice_subject">
                  <b>  <p>Type: Appointment Eticket</p> </b>

                </div>
            <div class="invoice_table">
                <table >
                    <tr>
                        <th>Patient Name:</th>
                        <td><?=ucfirst($patient_name)?></td>
                        <td width="100px"></td>
                        <th>Patient Id</th>
                        <td> <?=$patient_id?></td>
                    </tr>
                    <tr>
                        <th>Service:</th>
                        <td><?=ucfirst($service)?></td>
                        <!-- <td><? //$address?></td> -->
                        <td width="100px"></td>
                        <th>Sex:</th>
                        <td>Male</td>
                    </tr>
                    <tr>
                        <th>Age:</th>
                        <td><?=$age?></td>
                        <td width="100px"></td>
                        <th>Email:</th>
                        <td><?=$result[0]["email"]?></td>
                    </tr>
                    <tr>
                        <th>Consulting Doctor :</th>
                        <td>Dr.<?=ucfirst($doctor_name)?></td>
                        <td width="100px"></td>
                        <th>Specialization:</th>
                        <td><?=$specialization?></td>
                    </tr>
                    <tr>
                        <th>Appiontment Date :</th>
                        <td><?=$appointment_date?></td>
                        <td width="100px"></td>
                        <th>Appointment Time:</th>
                        <td><?=$appointment_time?></td>
                    </tr>
                    <tr>
                        <th>Consultation Charge :</th>
                        <td><?=$service_charge?></td>
                        <td width="100px"></td>
                     </tr>
                     <tr>
                        <th>Payment Status :</th>
                        <td><?php 
                        $pp="<p style='color:white;width:fit-content;padding:6px 7px;border-radius:5px;";
                            if($payment_status=="0"){
                               $pp.="background-color:red;'>";   
                               $pp.="Unpaid"; 
                            }
                            else{
                                $pp.="background-color:green;'>"; 
                                $pp.="Paid"; 
                            }
                            $pp.="</p>";
                            echo $pp;
                            ?></td>
                        
                    </tr>
                    
                </table>
            </div>

            <div class="invoice_footer_note">
               Note: <i><p>1.This eticket is non transferable and must be presented at the time of visit</p>
                <p>2.Please bring you ID card for verification </p></i>
            </div>
            <div id="buttons">
                <button onclick='print_invoice()'>Print Invoice</button>
           
            </div>
            <?php
            if($_SESSION["role"]=="patient"&&$payment_status=="0"){
               
            
            ?>
                <div>
                                    <?php
                                        $tax=0.15*(float)$service_charge;
                                        $t_total=(float)$service_charge-$tax;
                                    ?>
                    
                        <form action="https://uat.esewa.com.np/epay/main" method="POST">
                                <input value="<?=floatval($service_charge);?>" name="tAmt" type="hidden" readonly>
                                <input value="<?php echo $t_total;?>" name="amt" type="hidden" readonly>
                                <input value="<?=$tax?>" name="txAmt" type="hidden" readonly>
                                <input value="0" name="psc" type="hidden">
                                <input value="0" name="pdc" type="hidden">
                                <input value="EPAYTEST" name="scd" type="hidden">
                                <input value="PP<?=$pid?>" name="pid" type="hidden">
                                <?php 
                                echo ' <input value="http://localhost/new doctor sathi/payment/success.php?id='.$_GET["patient_id"].'&bill_number='.$pid.'" type="hidden" name="su">
                                <input value="http://localhost/harke/allinonehotel/payment/failure.php?" type="hidden" name="fu">
                                ';
                                ?>
                                <input id="esewa_pay" value="Pay with Esewa" type="submit">
                        </form>
                    
                    

                </div>
           <?php } ?>
                  
        
</div>
</body>
</html>
<?php
}
else{
    echo "No details found";
}
?>
