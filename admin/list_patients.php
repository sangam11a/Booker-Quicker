<link rel="stylesheet" href="../css/table.css">

<?php
include_once "../admin/dashboard.php";
include_once "../classes/config.php";
$con=new DBConnect();
echo '<caption>
<h3 style="color:#008368">List Patients</h3>
</caption>';
$result=$con->select("users",['role'],['patient']);
if(count($result)==0){
include_once "../classes/alerts.php";
small_alert("No patients registered yet!");
}
else{
echo "<table class='table'>";
echo "<tr><td>S.N</td><td>Name</td><td>Date created</td><td>Status</td></tr>";
$i=0;
    foreach($result as $row){
        echo "<tr>";
            echo "<td>";
            echo ++$i;
            echo "</td>";
            
            echo "<td>";
                echo $row["username"];
            echo "</td>";
            
            echo "<td>";
                echo date("Y/m/d",$row["created_on"]);
            echo "</td>";
            
            echo "<td>";
            $img="<form method='post'>";
               if($row["status"]) {
                // $img="<img src='../images/tick.png' height=30 width=30>";
                $img.="<button name='inactive' type='submit' value='".$row["id"]."'>Active</button>";
               }
               else{
                //    $img="<img src='../images/cross.png'  height=30 width=30>";
                $img.="<button name='active' type='submit' value='".$row["id"]."'>Inactive</button>";
               }
               $img.="</form>";
               echo $img;
            echo "</td>";
        echo "</tr>";
    }
echo "</table>";
}
if(isset($_POST["inactive"])){
    $result=$con->updation("users",["status"],[0],["id"],[$_POST["inactive"]]);
    if($result){
        echo "<script>location.href=location.href;</script>";
    }
}
if(isset($_POST["active"])){    
    $result=$con->updation("users",["status"],[1],["id"],[$_POST["active"]]);
    if($result){
        echo "<script>location.href=location.href;</script>";
    }
}
?>
