<link rel="stylesheet" href="../css/buttons.css">
<?php
include_once "../admin/dashboard.php";
include_once "../classes/config.php";
include_once "../calendar.php";         
    if(isset($_POST["id"])&&isset($_POST["doctor_name"])&&isset($_POST["start_time"])&&isset($_POST["stop_time"])){
        $service=$_POST["service"];
        $services=explode("%",$service);
        // print_r($services);
        $patient_name=$_SESSION["username"];
        $id=$_POST["id"];
        $doctor_name=space_removal($_POST["doctor_name"]);
        $start_time=$_POST["start_time"];
        $stop_time=$_POST["stop_time"];
        $date_book=$_POST["date_book"];
        $reason=$_POST['patient_reason'];
        $patient_id=generate_id("".$_SESSION['id']);
        $conn=new DBConnect();
        $result1=$conn->generic_func("Update availability set `status`=1 where `id`='$id' and `status`=0");
        $result2=$conn->insertion('appointment',['patient_id','patient_name','doctor_name','appointment_date','appointment_time','patient_reason','service','service_charge']
        ,[$patient_id,$patient_name,$doctor_name,$start_time,$stop_time,$reason,$services[0],$services[1]]);
        if($result2&&$result1){
            include_once "../classes/alerts.php";
            echo "<script src='../classes/refresh.js'></script>";
            small_alert("Appointment in $date_book has been booked.This page will automatically refresh in <span id='sec'></span> seconds.<script>refreshing(3);</script>");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book appointment</title>
    <style>
        input, select,textarea{
            left: 305px;
            position: absolute;
            margin-left: 38px;
        }
        .for_padding{
            padding-bottom:10px;
        }
        .container{
            padding-left: 15px;
        }
        .container2{
            display: grid;
            grid-template-columns:70% 30%;
        }
    </style>
</head>
<script>  
function get_doctor(x){
    var request = new XMLHttpRequest();
    var url="../ajax/get_doctor.php";
    console.log(url+"?specialization="+x);
    request.open("GET", url+"?specialization="+x);
    var select="<span class='for_padding'><label for=''>Select Doctor</label> <select id='d_name' onchange='doctor_name(this.value)'><option>Choose Doctor</option>";

    request.onreadystatechange = function() {
            // Check if the request is compete and was successful
            if(this.readyState === 4 && this.status === 200) {
                var data=JSON.parse(this.responseText);
                // Inserting the response from server into an HTML element
              if(data.length>=1) 
              {for(var i=0;i<data.length;i++){
                console.log(data[i]);   
                        select+="<option value='"+data[i]["username"]+"'>"+data[i]["username"]+"</option>";
                    }
                }
                select+="</select></span>";       
                      
                document.getElementById('d_name').innerHTML=select;    
            }
        // }
        };

        request.send();
}  
function calendar(x,y){
    if(x==undefined&&y==undefined){
        x=0;
        y=0;
    }
    var request = new XMLHttpRequest();
    var d_name=document.getElementById('r_d_name').value;
    d_name=d_name.replace(/\s/g, '_')+"_";
       var url="../ajax/calendar.php";
       url=url+"?month="+x+"&doctor_name="+d_name+"&year="+y;
       request.open("GET", url);
        var table="<h4>Available Time Slots for this month</h4><table border=1 cell-padding=1><tr style='background-color:royalblue;color:white;'><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thurs</td><td>Fri</td><td>Sat</td></tr>";
    // Defining event listener for readystatechange event
        request.onreadystatechange = function() {
            // Check if the request is compete and was successful
            if(this.readyState === 4 && this.status === 200) {
                var data=JSON.parse(this.responseText);
                console.log(data,url)
                // Inserting the response from server into an HTML element
              if(data.length>2) 
              {j=0;
                var arr="";
                for(i=1;i<=data[0];i++){
                    if(j==0) table+="<tr>";
                    table+="<td></td>";
                    j++;
                    if(j==7) table+="</tr>";
                    j=j%7;
                }
                var fontcolor="red";var k;
                for(i=1;i<=data[1];i++){
                    fontcolor="red";
                   arr=arr+"&"+data[i];
                    if(j==0) table+="<tr>";
                    for(k=2;k<=data.length;k++){
                        if(i==data[k]){
                            fontcolor="green";
                            break;
                        }
                    }
                    table+="<td style='background-color:"+fontcolor+";color:white;'>"+i+"</td>";
                    j++;
                    if(j==7) table+="</tr>";
                    j=j%7;
                }
                table+="</table>";                
                document.getElementById('calendar').innerHTML=table;    
            }
            else{
                document.getElementById('calendar').innerHTML="No appointments day confirmed yet";
            }
        }
        };

        request.send();
}
function doctor_name(d_name){
document.getElementById('r_d_name').value=d_name;
document.getElementById('date1').style.display='block';
document.getElementById('d_name1').style.display='block';
calendar(0,0,d_name);
} 
    function getting_time(v,w,x,y,z){
       document.getElementById("id").value=v;
       document.getElementById("start_time").value=x;
       document.getElementById("stop_time").value=y;
       document.getElementById("date_book").value=z;
       document.getElementById('patient_reason').style.display='block';
       document.getElementById('button_id').innerHTML=' <button type="submit" name="submit_data"  id="submit_data" class="" onclick="document.getElementById(\"getting_appointment\").submit()">Submit</button>';
    }
    function date_change(val){
        document.getElementById("result").innerHTML = "";
        document.getElementById("hide-show").display="none";
        var str="";
        str=val;
       str= str.replace("-","/");
       str= str.replace("-","/");
       var d_old_name=document.getElementById('r_d_name').value;
      document.getElementById("doctor_name").value=d_old_name;
      var d_name = d_old_name.replace(/\s/g, '_')+"_";
       var request = new XMLHttpRequest();
       var url="../ajax/doctor_avail.php";
       url=url+"?date="+str+"&doctor_name="+d_name;
       console.log(url);
       request.open("GET", url);
        var table="<h4>Available Time Slots:</h4><div class='ss'>";
    // Defining event listener for readystatechange event
        request.onreadystatechange = function() {
            // Check if the request is compete and was successful
            if(this.readyState === 4 && this.status === 200) {
                var data=JSON.parse(this.responseText);
                console.log(data);
                // Inserting the response from server into an HTML element
              if(data.length>0) 
              {j=0;
                var arr="";
                for(i=0;i<data.length;i++){
                   arr=arr+"&"+data[i]['available_day'];
                    // if(j==0) table+="<tr>";
                    table+="<button id='booking_btn' onclick='getting_time(\""+data[i]["id"]+"\",\""+d_name+"\",\""+str+"\",\""+data[i]["start_time"]+"\",\""+data[i]["stop_time"]+"\")'>"+data[i]['start_time']+" - "+data[i]['stop_time']+"</button>";
                    // j++;
                    // if(j==4) table+="</tr>";
                    // j=j%4;
                }
                table+="</div>";                
                document.getElementById("result").innerHTML =table;
                
              } 
                else document.getElementById("result").innerHTML ="<p style='color:red;font-size:16px;font-weight:600;'>No schedule of DR."+d_old_name+" in "+str+". Please choose another day.Green colored date indicates available working day.</p>";
            }
        };

        // Sending the request to the server
        request.send();
    }
</script>
<body>
    <div class="container2">
        <div class="first-half">
            <h2>Book Appointments</h2>
            <div class='for_padding ' id="d_spec1"  class="d_spec1">
                <label for=''>Specialization:</label> 
                <?php
                    $conn=new DBConnect();
                    $result1=$conn->total_rows("users","*","where role='doctor' group by specialization");
                    $select1="<select onchange='get_doctor(this.value)'><option>Choose Specialization</option>";
                    foreach($result1 as $row1){
                        $select1.="<option value='".$row1["specialization"]."'>".$row1["specialization"]."</option>";
                        }
                    $select1.="</select>";
                    echo $select1;
                ?>
            </div>
            <div class="container">
                <div id="d_name"></div>
            <div class='for_padding' id="d_name1" style='display:none;' class="d_name1">
                <label for=''>Doctor's Name:</label> <input type="text" name="r_d_name"  id="r_d_name" readonly>
            </div>
            <div class='for_padding' id="date1" class="date1" style="display:none;">
                        <label for="date1">Choose Date</label>
                        <input type="date"  name="date1"  id="date1"  onchange="date_change(this.value)" min="<?=date("Y-m-d")?>" max="<?php echo date("Y-m-t", strtotime(date("Y-m-d")));?>">
            </div>
            
            <div id="result">

            </div>
            <form action="" method="post" id="getting_appointment" name="getting_appointment">
                <input type="hidden" name="id" id="id">
                <!-- <input type="hidden" name="doctor_name" id="doctor_name">             -->
                
                <input type="hidden" name="doctor_name" id="doctor_name" >
                <input type="hidden" name="start_time" id="start_time">
                <input type="hidden" name="stop_time" id="stop_time">
                <input type="hidden" name="date_book" id="date_book">
                <span id='patient_reason' class="for_padding" style='display:none;'> 
                    <br><label for=''>Service</label>
                            <?php
                                $result3=$conn->select("services");
                                if(count($result3)>0){
                                    $select="<select name='service'>";
                                    foreach($result3 as $row3){
                                        $select.="<option value='".$row3['service_name']."%".$row3['price']."'>".$row3['service_name']."-".$row3['price']."</option>";
                                    }
                                    $select.="</select>";
                                    echo $select;
                                }
                                else{
                                    echo "No service available"."<Script>document.getElementById('button_id').style.display='none';</script>";
                                }
                            ?>
                            <br>
                                <span id="hide-show">
                                  Reason:<textarea rows=6 cols=30 name='patient_reason' ></textarea></span>
                                 <div id="button_id" style='padding-top:100px;'>
                    
                                  </div>
                               </span>
            </form>
          </div>
          <div class="second-half">
                <div id="calendar" >
                </div>
          </div>
       
  </div>       
</body>
</html>

