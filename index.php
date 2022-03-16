<!DOCTYPE html>
<html>
    
    <head><meta charset="utf-8" />
        <link rel="icon" href="https://www.logolynx.com/images/logolynx/d8/d8a2c6cf913465d6e4de9ef74c036fd1.png" />
        <link rel="stylesheet" href="../css/fontawesome/css/all.css">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>
            body{
                overflow-x: hidden;
                background-color: #f1f1f1;
            }
            *{
                margin: 0px;
                color:#44574F;
                
            }
            .navbar{
                height: 60px;
                width:100%;
                display: flex;
                align-items: center;
                background-color: #15D1B8 ;
                z-index:100;
                border: 2px solid #F3F8F8;
                position: sticky;
                top:0px;
             }
            .navbar .nav-left img{
                height: 40px;
                width: 80px;
                padding: 0px 40px;
            }
            .navbar .nav-right{
                display: flex;
                margin-left: 37%;
            }
            .navbar .nav-right  li{
                list-style-type: none;
            }
            .navbar .nav-right  li a{
                text-decoration: none;
                font-weight:540;
                color: white;
                font-size:17px;
                letter-spacing: 2px;
                padding:0px 30px;
            }
            .navbar .nav-right  li a:hover{
                color:wheat;
                /* text-decoration: underline; */
            }
            .app-div{
                margin-bottom: 30px;
            }
            .app-div img{
                    opacity:1;
                    z-index:10;
                    height:100%;
            }
            .app-div img:hover{
                    opacity:0.8;
            }
            .app-div .text-over{
                position: absolute;
                top:390px;
                left:50px;
                color: #44574F;
                z-index:50;
            }
            .app-div .text-over button{
                margin: 10px 0px;
                background-color: #15D1B8  ;
                border-radius: 8px;
                height:40px;
                width: 200px;
                border:2px solid rgb(160, 96, 96) ;
                font-weight: bold;
                letter-spacing: 1px;
                color:white;
            }
            .doctors{
                display: flex;
                margin:10px;
            }
            .doctors .prof{
                height: 300px;
                width:300px;
                margin:  20px 20px;
                border: 1px outset #F0F8F7;
            }
            .doctors .prof:hover{
                 border-radius: 10px;
                 background-color: #90B7B7;
            }
            .doctors .prof img{
                height: 150px;
                width:150px;
                border-radius: 50%;
                margin-top: 10px;
            }
            .doctors .prof .desc{
                margin-top: 20px;
            }
            .doctors .prof .desc span{
                padding-top: 15px;
            }
            .fa {
                padding:5px;
                width: 15px;
                height: 15px;
                text-align: center;
                text-decoration: none;
                margin: 5px 2px;
                border-radius: 50%;
            }
            .fa:hover {
                opacity: 0.7;
            }
            .fa-facebook {
            background: #3B5998;
            color: white;
            }
            .fa-twitter {
            background: #55ACEE;
            color: white;
            }
            .fa-google {
            background: #dd4b39;
            color: white;
            }
            .fa-linkedin {
            background: #007bb5;
            color: white;
            }
            .soc{
                margin-top: 10px;
            }
            .about .inside-about{
                margin:0px 250px;
            }
            .about .inside-about h4{
                letter-spacing: 1px;
                font-family: Arial, Helvetica, sans-serif;
            }
            .footer{
                margin-top: 10px;
                align-items: center;
                background-color: #353737;
                height: 50px;
            }
            .footer p{
                padding-top: 15px;
                color: #81CF9E;
            }
        </style>
        <title>DoctorSathi </title>
            <body> 
                <!-- Navbar -->
                <div class="navbar">
                    <div class="nav-left">
                        <!-- <a href="#"> -->
                        <span style="margin-left: 40px;
                            color: white;
                            font-weight: 700;
                            font-size:x-large" onclick="location.href='index.php'">Dr Sathi</span> 
                        <!-- <img style='opacity:40%;' src="https://www.logolynx.com/images/logolynx/d8/d8a2c6cf913465d6e4de9ef74c036fd1.png" /> -->
                        <!-- </a> -->
                    </div>
                    <div class="nav-right">
                        <li><a href="">Home</a></li>
                        <li><a href="#doctordiv">Doctors</a></li>
                        <li><a href="#aboutdiv">About Us</a></li>
                        <li><a href="login/">Log In</a></li>
                        <li><a href="login/users_reg.php">Sign Up</a></li>
                    </div>      
                </div>

                <!-- Appointment Image Div -->
                <div class="app-div">
                    <img src="https://gatewaychc.com/wp-content/uploads/2018/04/Appointment.jpg" height="500px" width="100%"/>
                    <div class="text-over">
                    <h3>Welcome to DoctorSathi... </h3><br/>
                    <h2><strong> BOOK ANY DOCTOR'S APPOINTMENT<br/> IN A SECOND </strong> </h><br>
                    <h4>Welcome to the online appointment booking system DoctorSathi.</br> Here we book your appintment faster than anyone and you may<br> reschedule or ccancel yur booked appointment as well.</h4>
                    <a href="user/book_appointment.php"><button>MAKE AN APPOINTMEMT</button></a>
                    </div>
                </div>

                <!-- Doctors-->
                <div  class="doctor-class" id="doctordiv">
                    <div class="doc-text">
                <center>
                <h3>Meet Our Professionals</h3><br/>
                <h2>Our Partnered Doctors</h2></center>
                    </div>
                <div class="doctors">
                    <?php
                        include_once "classes/config.php";
                        $conn=new DBConnect();
                        $result=$conn->select("users",["role"],["doctor"]);
                        if(count($result)>0){
                            foreach($result as $row){
                            ?>
                            <div class="prof">
                                    <center>                       
                                        <div class="desc">
                                            <strong><h3><?=ucfirst($row["username"])?></h3></strong> <br>
                                    
                                            <span><?=ucfirst($row["specialization"])?></span><br>
                                            <div class="soc">
                                            <a href="mailto:<?=$row["email"];?>" target="_blank" style='color:White;background-color:#dd4b39;text-decoration:none;border-radius:40%;padding:8px;font-size:20px;'>G</a>
                                            </div>
                                        </div>
                                        </center>
                            </div>
                            <?php
                            }
                        }
                        else{
                            echo "No doctors added till date.";
                        }
                    ?>
                   </div> 

                <div class="about" id="aboutdiv">
                    <div class="about-text">
                        <center>
                        <h3>About Our system</h3><br/>
                        </center>
                    </div>
                    <div class="inside-about">
                        <center>
                        <h4>
                            In a nutshell we have developed an online medical appointment booking system through which registered users can book appointments with available doctors in available time slots. Firstly, the doctor adds the schedule, their available date and time. In that time period, users/patients can choose an appropriate time slot and make payment. Doctors then on appointment can prescribe patients through their portal. Daily reports of doctors are also generated and stored in a database which is viewed by admin and can be used for assessment of the doctors. 
                            <br/>
                            If you havae any suggestions and queries feel free to contact us:<br/>
                            <a href="gmail.com">doctorsathi@medicare.np</a>
                        </h4>
                        </center>
                    </div>
                </div>

                <div class="footer">
                    <center>
                    <p>© 2022 DoctorSathi. All rights reserved.</p>
                </center>
                </div>
                 
            </body>
       
    </head>
</html>