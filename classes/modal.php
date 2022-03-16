
<script src='../classes/refresh.js'></script>
    <style>
    body{
        margin:0px;
        left:0;
        padding:0px;
    }
        .modal-container{
            background-color: rgba(37, 33, 33, 0.7);
            height:100vh;
            width:100vw;
            position:fixed;            
            top:0;
            left:0;
        }
        .modal{
            z-index:9999999999;
            position:relative;                        
            top:16vh;
            left:30vw;
            background-color: rgb(241, 240, 230);
            position:relative;
            border-radius:12px;
            box-shadow:2px 4px rgb(0, 0, 0,0.5);
            max-width:45vw;
            max-height:70vh;
            /* height: 60vh; */
            display: auto;
            overflow-x: scroll;
            overflow-x:hidden;
        }
        .modal-head{
            font-size:26px;
            font-weight:500;
            margin-bottom:3vh;
            padding-left: 4vw;
            padding-top:2vh;
        }
        .modal-body{
            font-size:20px;
            margin-bottom:3vh;
            padding-left:6vw;
        }
        .modal-footer{
            padding:8px 10px;
            float:right; position:absolute;
            bottom:3vh;right:3vw;
        }
        .cross{
            font-size:24px;
            color:rgb(241, 92, 92);
            float:right;
            margin-right:10px;
            
        }
        .cross:hover{
            font-size:27px;
            color:rgb(240, 0, 0);
            cursor: pointer;
            font-weight:500;
            animation-duration: 3s;
        }
        .footer-btn{
            border-radius: 6px;
            border-color: none;
            font-size:18px;
            padding:4px 7px;
        }
        .yellow{
            background-color: rgb(36, 8, 21);
            color:rgb(213, 211, 214);
        }
       
    </style>

<?php
    function modal($heading,$body,$footer=""){    
        echo '<div class="modal-container">';
            echo '<div class="modal">';
                echo '<span class="cross" onclick="this.parentNode.parentNode.style.display=\'none\';">&times;</span>';
                 echo '<div class="modal-head">';
                        echo $heading;
                     echo '</div>';
                 echo '<div class="modal-body">';
                         echo $body;
                     echo '</div>';
                 echo '<div class="modal-footer">';
                        //  echo "<button class='footer-btn yellow' onclick='this.parentNode.parentNode.style.display=\"none\";'>Cancel</button>";
                         if($footer!="") echo "<button class='footer-btn yellow '>$footer</button>";
                 echo '</div>
             </div>
         </div>';
     }
     function delete_modal($patient_name,$appointment_date,$appointment_time,$heading,$text,$footer=""){
        echo '<div class="modal-container ">';
        echo '<div class=" content-fit modal">';
            echo '<span class="cross" onclick="this.parentNode.parentNode.style.display=\'none\';">&times;</span>';
            echo '<div class="modal-head">';
                    echo $heading;
                echo '</div>';
            echo '<div class="modal-body">';
                     echo $text;
                echo '</div>';
            echo '<div class="modal-footer">';
                ?>
                <form action='' method='post' id='cancel_app'>
                <input type='hidden' id='pat_name' name='pat_name' value='<?=$patient_name?>'>
                <input type='hidden' id='appt_time' name='appt_time' value='<?=$appointment_time?>'>
                <input type='hidden' id='appt_date' name='appt_date'value='<?=$appointment_date?>'>
              <br>  <textarea name='reason' rows=10 cols=50 placeholder='Reasons if any'></textarea>
                </form>
                <?php
                     echo "<button onclick='del()'>$footer</button><button onclick='this.parentNode.parentNode.parentNode.style.display=\"none\";'>Cancel</button>";
            echo '</div>
        </div>
        </div>';    
       
   }
   if(isset($_POST["appt_time"])&&isset($_POST["appt_date"])&&isset($_POST["pat_name"])){
    include_once "../classes/config.php";
    $conn=new DBConnect();
    $pat_name=$_POST["pat_name"];
    $appt_date=$_POST["appt_date"];
    $appt_time=$_POST["appt_time"];
    $a1=[$pat_name,$appt_date,$appt_time];
    // echo $pat_name.$appt_date,$appt_time;
    echo "<script>alert('app time $pat_name,$appt_date,$appt_time');</script>";
   if(empty($_POST['reason']))  $reason=0;
   else $reason=$_POST['reason'];
    $result=$conn->deletion('appointment',['patient_name','appointment_date','appointment_time'],$a1);  
    echo $result;
    if($result){
            $result2=$conn->insertion(
                "cancelled_appointment",
            ['patient_name', 'appointment_date', 'appointment_time', 'cancelled_on','reason'],
            [$pat_name,$appt_date,$appt_time,time(),$reason]);
            include_once "../classes/alerts.php";
            small_alert("Appointment of $pat_name has been cancelled.<br>Refreshing 
            this page in <span id='sec'></span> seconds.<script>
            var timeout ;
            function refreshing(i) {
            document.getElementById('sec').innerHTML=i;
            timeout = setTimeout(refreshing, 1000,i-1);
            if(i==0) {
                clearTimeout(timeout);
                location.href=location.href;
             }
            }
            refreshing(4);</script>");
        }
    } 
?>
<script>

    function del(){ 
        document.getElementById('cancel_app').submit();
    }

</script>