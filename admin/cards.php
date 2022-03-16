    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <style>
        .card2-container{
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
        }
        .card2{
            background-color: azure;
            box-shadow: 2px 0px 16px rgba(0, 60, 60,0.8);
            width:280px;
            margin-top: 15px;
            margin-bottom: 20px;
            border-radius:3px;
            border-bottom-right-radius: 5px;
            border-top-left-radius: 6px;
        }
        .card2{
            display:grid;
            grid-template-columns: 30% 70%;
        }
        .card2-heading{
            padding-top: 14px;
        }
        .fa{
            color:black;
        }
       /* .card2-logo img{
           height:50px;
           width:50px;
       } */
        .card2-logo{
            /* margin-top:10%; */
            margin-left:8px;
            padding:14px 4px;
        }
        .card2-data{
            margin-left:80%;
            font-size: 20px;
        }
        @media screen and (max-width:900px) {
            .card2-container{
                grid-template-columns: 1fr 1fr ;
            }
        }

        @media screen and (max-width:700px) and (min-width:260px) {
            .card2-container{
                grid-template-columns: 1fr  ;
            }
        }
      
    </style>
    <div class="card2-container">
        <?php
            include_once "../classes/config.php";
            $conn=new DBConnect();
            $result1=$conn->total_rows("users","count(*)","where role='doctor'");
            $result2=$conn->total_rows("appointment","count(*)");
            $result3=$conn->total_rows("appointment","count(*)","where appointment_date='".date("Y/m/d")."'");
            $result4=$conn->own_query("Select count('service_charge') from appointment where payment<>0");
      ?>
            <div class="card2 ">
                <div class="card2-logo">
                <i class="fas fa-hospital-user fa-4x" ></i>
                </div>
                <div class="card2-body">
                    <div class="card2-heading"><h3>Total appointments</h3></div>
                    <div class="card2-data"><h4><?=$result2?></h4></div>
                </div>   
            </div>
            <div class="card2 ">
                <div class="card2-logo">
                <i class="fas fa-calendar-check fa-4x"></i>
                </div>
                <div class="card2-body">
                    <div class="card2-heading"><h3>Today's Appointment</h3></div>
                    <div class="card2-data"><h4><?=$result3?></h4></div>
                </div>   
            </div>
            <div class="card2 ">
                <div class="card2-logo">
                    
                    <i class="fa fa-user-md fa-4x"></i>
                </div>
                <div class="card2-body">
                    <div class="card2-heading"><h3>Total Doctors</h3></div>
                    <div class="card2-data"><h4><?=$result1?></h4></div>
                </div>          
            </div>
            <div class="card2 ">
                <div class="card2-logo">
                <i class="fa-solid fa-arrow-trend-up fa-4x"></i>
                </div>
                <div class="card2-body">
                    <div class="card2-heading"><h3>Total turnover</h3></div>
                    <div class="card2-data"><h4><?=$result4[0]["count('service_charge')"]?></h4></div>
                </div>   
            </div>
    </div>
