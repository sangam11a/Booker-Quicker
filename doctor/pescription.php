
<?php
if(isset($_GET["id"])){
    include_once "../classes/config.php";
    $conn=new DBConnect();
    $result=$conn->select("appointment");
    if(count($result)>0){
        $row=$result[0];
    ?>
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/pescription.css">
            <title>Invoice</title>
        </head>
        <body>
            <div class="invoice_main">
                        <div class="invoice_header">
                            <h1>Doctor Sathi Hospital</h1>
                            <p>Kathmandu-10,Nepal</p>

                        </div>
                        <div style="display:grid;grid-template-columns:70% 30%; margin-top:25px;">
                            <div style="margin-left:15px;">
                                <div class="invoice_date" ><b>Date:</b><?=$row["appointment_date"]?></div><br>
                                <div >
                                    <b>Patient Name</b>:<?=$row["patient_name"]?>
                                </div>
                            </div>
                        <div>
                            <div id="doctor_name" style="margin-left:20px;"><b><?=$row["doctor_name"]?>:</b>:asgdasgd</div><br>
                            <div id="NMCnumber"><b>License Number:</b>23784362</div>
                            
                        </div>
                        </div>
                    <div>
                        <!-- <div style="margin-left:15px;">
                            <b>Patient Name</b>:asjdgsajdgsa
                        </div> -->
                    </div>
                    <div class="invoice_subject">
                        <h2>  <p>Digital Prescription</p> </h2>

                        </div>
                    <div style="
                    width: 40vw;
                    margin-left: 30vw;
                    margin-top: 5vh;
                    padding: 20px 26px;
                    border: 1px solid black;
                    height: 40vh;">
                            <div>
                                <h4>
                                    Patient Reason:
                                </h4>
                                <div>
                                    <?=ucfirst($row["patient_reason"])?>
                                </div>
                            </div>
                            <div>
                                <h4>
                                    Doctor's Reason
                                </h4>
                                <div>
                                <?=$row["doctor_reason"]?>
                                </div>
                            </div>
                    </div>

                    <div class="invoice_footer_note">
                    Note: <i><p>1.This is digital pescription available to patients</p>
                        <p>2.This pescription shall not be used for forgery case </p></i>
                    </div>
                
            </div>
        </body>
    </html>

<?php
    }
}
else{
    echo "Invalid response";
}
?>