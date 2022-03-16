<?php
include_once "../admin/dashboard.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/alert.css">
    <title>Admin Index</title>
</head>
<style>
  
</style>
<body>
    <div class="container">
        <div class="container2">
            <?php include_once "../admin/cards.php"; ?>
        </div>
       <?php
           include_once "../classes/config.php";
           include_once "../classes/alerts_own.php";
           $conn=new DBConnect();
           $statement=$conn->total_rows("users","*"," where viewed=0 order by created_on desc"); 
           if(count($statement)>0){
               echo "<h2>Notifications: <i>".count($statement)."</i></h2>";
                foreach($statement as $row){
                    if($row["username"]!="admin"){
                    if($row['role']=='doctor') alert_display("<p>A new doctor ".$row['username']." has registered. Please approve it now</p>","New Registration Warning",$row['id']);
                    if($row['role']=='patient') alert_display("<p>A new Patient(user) named <b><i>".$row["username"]."</i></b> has been added.</p>","New Patient added",$row['id']);    
                    }
           }
        }
           else{
            echo "<h3>No new notifications</h3>";
        }
           
           //   echo '<div class="wrapper-warning">';
          //   echo '<div class="card">';
          //     echo '<div class="icon"></div>';
          //       echo '<div class="subject"><h3>New Registration Warning</h3>';
          //      echo "<p>A new doctor ".$row['username']." has registered. Please approve it now</p>";
          //      echo '</div>';
          //      echo ' <div class="icon-times" style="color:red;margin-top:-12vh;" onclick="this.parentNode.parentNode.style.display=\'none\';">x</i></div>';
          //    echo '</div>';
          //  echo '</div>';
            // }
       ?>
    </div>
        <div style="margin-top:10px;" id="chart1"></div>
        <div id="chart2"></div>
</body>
</html>

<?php
include_once "../classes/config.php";
$conn=new DBConnect();
if(isset($_POST['id'])){
    $id=$_POST['id'];
    $result1=$conn->updation("users",['viewed'],[1],['id','viewed'],[$id,0]);
    if($result1) 
     echo"<script>location.href=location.href;</script>";
}
?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    
   function chart2(data1,data2,id,text,type,name){
          console.log(data1)
    var options = {
          series: [{
            name: name,
            data: data1
        }],
          chart: {
          height: 400,
          width:700,
          type: type,
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        title: {
          text: text,
          align: 'left'
        },
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.9
          },
        },
        xaxis: {
          categories: data2,
        }
        };

        var chart = new ApexCharts(document.querySelector(id), options);
        chart.render();
   }  
   
</script>
<script>
    function chart1(url,id,type,name1){
        var xhr = new XMLHttpRequest();
        // if(x==0) var url='';
        xhr.open('GET', url+id);
        xhr.send();
        xhr.onreadystatechange = function () {
                var DONE = 4; // readyState 4 means the request is done.
                var OK = 200; // status 200 is a successful return.
                if (xhr.readyState === DONE) {
                    if (xhr.status === OK) {
                        var data=JSON.parse(xhr.responseText);
                        var arr1=[],arr2=[];
                     console.log(data); // 'This is the returned text.'
                        for(i=0;i<data.length;i++){
                            arr1.push(data[i]["name"]);
                            arr2.push(data[i]["count"]);
                        }
                        console.log(arr2,arr1)
                      if(id=="1")  chart2(arr2,arr1,"#chart1","Number of appointments in graph",type,name1);
                        if(id=="2") chart2(arr2,arr1,"#chart2","Total turnovers till date",type,name1);
                    } else {
                        console.log('Error: ' + xhr.status); // An error occurred during the request.
                    }
                }
        };
    }
    chart1("charts.php?id=","1","line","Daily transaction");
    chart1("charts.php?id=","2","line","Total appointments in a day");
    
</script>