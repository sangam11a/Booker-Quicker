<?php
include_once "../admin/dashboard.php";
include_once "../classes/config.php";
include_once "../classes/alerts.php";
$conn=new DBConnect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search patient</title>
    <script>
        function view_modal(x){
            document.getElementById('id1').value=x;
            document.getElementById('view_modal').submit();
        }
        function payment_modal(x,y){
            document.getElementById('id2').value=x;
            document.getElementById('service_charge').value=y;
            document.getElementById('payment_modal').submit();
        }

        function val(x,y){
            if(x==y){
                document.getElementById('pay').disabled=false;
            }
            else{
                document.getElementById('pay').disabled=true;
            }
        }

        function add_zero(y){
            if(y<=9){
                return "0"+y;
            }
            else 
            return y;
        }
        fetch_data("");
        function fetch_data(x){
            var xhttp=new XMLHttpRequest();
            // var data=document.getElementById('search').value;
            var url="../ajax/search.php?data="+x;
            console.log(url);
            xhttp.open("GET",url);
            var dat=new Date();
            var x=dat.getFullYear()+"/";
           x+=add_zero(dat.getDay());
           x+="/"+add_zero(dat.getDate());
            console.log(x)
            xhttp.onreadystatechange = function() {
                // Check if the request is compete and was successful
                if(this.readyState === 4 && this.status === 200) {
                    // Inserting the response from server into an HTML element
                        data=JSON.parse(this.responseText);
                        console.log(data);
                      if(data.length>0){
                        var table="<table><tr><td>S.N</td><td>Name</td><td>Appointment Date</td><td>Patient Reason</td><td>Prescription</td><td>Option</td></tr>";
                        for(var i=0;i<data.length;i++){
                            table+="<tr>";
                            table+="<td>"+Number(i+1)+"</td>";
                            table+="<td>"+data[i]["patient_name"][0].toUpperCase()+data[i]["patient_name"].substr(1,)+"</td>";
                            table+="<td>"+data[i]["appointment_date"]+"</td>";
                            if(data[i]["patient_reason"].length>30){
                             table+="<td>";                           
                                table+=data[i]["patient_reason"].substr(0,30)+".....";
                            table+="</td>";
                           }
                           else{
                            table+="<td>"+data[i]["patient_reason"]+"</td>";
                           }
                           var prescription=data[i]["doctor_reason"];
                           if(prescription!="0"){
                                if(prescription.length>30){
                                table+="<td>";                           
                                    table+=prescription.substr(0,30)+".....";
                                table+="</td>";
                            }
                            else{
                                table+="<td>"+prescription+"</td>";
                            }
                           }
                           else{
                            table+="<td>"+"No prescription yet"+"</td>";
                           }
                            table+="<td><button id='booking_btn' onclick='view_modal(\""+data[i]['id']+"\")'>View</button>";

                            if(data[i]["payment"]==0 && data[i]["payment_date"]>=x) 
                                table+="<button onclick='payment_modal(\""+data[i]['id']+"\",\""+data[i]['service_charge']+"\")'>Make payment</button>";
                            if(prescription!="0"){
                                table+="<a id='booking_btn' target='_blank' href='../user/pescription.php?id="+data[i]["id"]+"'>Pescription</a>";
                            }
                            table+="</td>";
                            table+="</tr>";
                        }
                        table+="</table>";
                        console.log(table);
                        document.getElementById('table').innerHTML=table;
                      }
                      else{
                        document.getElementById('table').innerHTML="No patients found";
                      }
                }
            }
            xhttp.send();
        }
    </script>
</head>
<body>
    <div class="container">
    <caption>
            <h3 style="color:#008368">Search History</h3>
    </caption>
        <span>
            <label for="">Search:</label>
            <input type="text" name="search" id="search" onkeyup="fetch_data(this.value)">
           
        </span>
        <div id="table">

        </div>
        <form action="" method="post" id='view_modal'>
            <input type="hidden" name="id1" id="id1">
        </form>
        <form action="" method="post" id='payment_modal'>
            <input type="hidden" name="id2" id="id2">
            <input type="hidden" name="service_charge" id="service_charge">
        </form>
    </div>
</body>
</html>
<?php
include_once "../classes/modal.php";
if(isset($_POST['id1'])){
$id=$_POST['id1'];
$result=$conn->select("appointment",['id'],[$id]);
$input="";
foreach($result[0] as $key=>$val){
    
    $input.="
    $key:<input type='text' value='$val' readonly><br>
    ";
}
$input.="<br><button onclick='this.parentNode.parentNode.parentNode.style.display=\"none\";'>Cancel modal</button>";
modal("View Appointment Details",$input);
}
if(isset($_POST['id2'])&&isset($_POST['service_charge'])){
$id=$_POST['id2'];
$price=$_POST['service_charge'];
$input="
<form method='post' action=''>
<input type='hidden' name='id3' value='$id'>
 To pay:<input type='text' value='$price' readonly><br>
 Paying amount:<input type='number' name='payment' onkeyup='val(this.value,\"$price\")'>
 <br><button type='submit' id='pay' name='pay' disabled>Pay</button>
 <button onclick='this.parentNode.parentNode.style.display=\"none\";'>Cancel payment</button>
</form>
";
modal("Pay Service Charge",$input);
}
if(isset($_POST['pay'])&&isset($_POST['id3'])){
    $id=$_POST['id3'];
    $result=$conn->updation("appointment",['payment_status'],[date("Y/m/d")],['id'],[$id]);
    echo "<Script src='../classes/refresh.js'></script>";
    if($result){
        small_alert("Payment of RS $result has been completed .This page will automatically refresh in <span id='sec'></span> seconds.<script>refreshing(2);</script>");
    }
}
?>