<?php
include_once "../admin/dashboard.php";
include_once "../classes/modal.php";
include_once "../classes/alerts.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/table.css">
    <link rel="stylesheet" href="../css/buttons.css">
    <script src="../classes/refresh.js"></script>
    <title>List Doctors</title>
    <style>
    .pagination_buttons{
        background-color:rgba(0,123,255,0.6);
        border-radius: 5px;
        color:white;
        padding:9px;
        margin-right:14px;
        text-decoration: none;
    }
    a:hover{
        text-decoration: none;        
        background-color:rgba(130,123,255,0.6);
        color:wheat;
    }
    .options{
        display: grid;
        width:5%;
        grid-template-columns: 1fr 1fr 1fr 1fr;
    }
    </style>
    <script>
        function submit_form(val){
            console.log(val)
        }
        function verification(x){
            document.getElementById('d_name').value=x;
            document.getElementById('form_submit').submit();
        }
    </script>
   </head>
<body>
    <div class="container">
        <!-- <form action="" id='' method="post">
            <select name="pagination" onchange='submit_form(this.value)'>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </form> -->
        <caption>
            <h3 style="color:#008368">List Doctors</h3>
        </caption>
        <table class="table">
            <tr>
                <td>S.N</td>
                <td>Name</td>
                <td>Specialization</td>
                <td>Status</td>
                <td>License Number</td>
                <td>Option</td>
            </tr>
                <?php
                $i=0;
                include_once "../classes/config.php";
                if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                    } 
                    else {
                    $pageno = 1;
                    }
                $conn=new DBConnect();                
                $no_of_records_per_page = 10;
                // if(isset($_POST["pagination"])) $no_of_records_per_page = $_POST["pagination"];              
                $total_rows=$conn->total_rows('users',"count(*)",'where role="doctor"');
               
                $offset = ($pageno-1) * $no_of_records_per_page;
                $total_pages = ceil($total_rows / $no_of_records_per_page);   
                $sql = "and role='doctor' LIMIT $offset, $no_of_records_per_page ";
                // $result=$conn->total_rows("users","*",$sql) ;
                $result=$conn->own_query("SELECT u.id, u.username, u.email, u.mobile_no, u.gender, u.age, u.password, u.created_on, u.status, u.role, u.specialization, u.hash, u.viewed, u.patient_id, u.email_status,d.file_name,d.license from users u inner join doctor_certificate d on d.doctor_id=u.id ".$sql);
                    // $row=$conn->select('users',['role'],['doctor']);
                    foreach($result as $each_data){
                        echo "<tr>";
                        echo "<td>";
                        echo ++$i;
                        echo "</td>";
                        echo "<td>";
                        echo $each_data['username'];
                        echo "</td>";
                        echo "<td>";
                        echo $each_data['specialization'];
                        echo "</td>";
                        echo "<td>";
                        echo $each_data['license'];
                        echo "</td>";
                        echo "<td>";
                        if($each_data['status']!=0){
                            $status="
                            <form method='post' action=''>
                                <input type='hidden' name='id' value='".$each_data['id']."'>
                                 <button id='booking_btn' type='submit' name='activate'>Active</button>
                            </form>
                            ";
                            // $img="<img src='../images/tick.png' height=30 width=30>";
                           }
                           else{
                            $status="
                            <form method='post' action=''>
                                 <input type='hidden' name='id' value='".$each_data['id']."'>
                                 <button  id='booking_btn' type='submit' name='inactivate'>Inactive</button>
                            </form>
                            ";
                            //    $img="<img src='../images/cross.png'  height=30 width=30>";
                           }
                        echo $status."</td><td>
                        <div class='options'>
                        <form method='post' id='1' action=''>                        
                            <input type='hidden' name='id' value='".$each_data['id']."'>
                            <button  id='booking_btn' type='submit' name='edit'>Edit</button>
                        </form>
                        <form method='post' id='2' action=''>                           
                            <input type='hidden' name='id' value='".$each_data['id']."'>
                            <button  id='booking_btn' type='submit' name='view'>View</button>
                        </form>
                        <form method='post' id='3' action=''>                           
                            <input type='hidden' name='id' value='".$each_data['id']."'>
                            <input type='hidden' name='username' value='".$each_data['username']."'>
                            <button  id='booking_btn' type='submit' name='delete'>Delete</button>
                        </form>
                        <a id='booking_btn' href='../doctor/doctor_certificate/".$each_data["file_name"]."' target='_blank'>Document</a>
                        </div>
                        ";                        
                        echo "</td>";
                        echo "</tr>";
                    }
                    $conn->remove_connection();
                ?>
        </table>
        <ul class="pagination">
        <li><a class='pagination_buttons' href="?pageno=1"  <?php if($pageno === 1){ echo 'disabled'; } ?>>First</a></li>
        <li <?php if($pageno <= 1){ echo 'disabled'; } ?>>
            <a class='pagination_buttons' href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>>
            <a class='pagination_buttons' href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a class='pagination_buttons' href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
    </div>
    <div>
            <form method='post' action='' id='form_submit'>
              <input type='hidden' name='d_name' id='d_name'>
            </form>
    </div>
</body>
</html>

<?php
if(isset($_POST['d_name'])){
    include_once "../classes/modal.php";
    $doctor_name=$_POST['d_name'];
    $result3=$conn->select("users",['role','username'],['doctor',$doctor_name]);
    if(count($result3)>0){
        foreach($result3 as $row){
            $input="
            <form method='post' action=''>
                Name:<input type='text' value=''>
                <br>Specialization:<input type='text' value=''>
                <br>Age:<input type='text'>
            </form>
            ";
            modal("Verify Doctor",$input);
        }
    }
    else{
        small_alert("Some error in doctor's verification");
    }
}
if(isset($_POST['activate'])){
$result4=$conn->updation("users",['status'],[0],['id'],[$_POST['id']]);
    if($result4){
       echo "<script>location.href=location.href;</script>";
    }
}
if(isset($_POST['inactivate'])){
    $result4=$conn->updation("users",['status'],[1],['id'],[$_POST['id']]);
    if($result4){
       echo "<script>location.href=location.href;</script>";
    }
}
if(isset($_POST['edit'])){
    include_once "../classes/modal.php";
    $id=$_POST['id'];
    $result4=$conn->select("users",['id'],[$id]);
    print_r($result4);
    $input='
    <form action="" method="post">
    <input type="hidden" id="id" name="id" value="'.$id.'">
    <input type="hidden" name="old" id="old" value="'.$result4[0]['username'].'" >
    Username; <input type="text" name="username" id="username" value="'.$result4[0]['username'].'" >
   <br> Age: <input type="text" name="age" id="age" value="'.$result4[0]['age'].'" >
   <br> Contact: <input type="text" name="contact" id="contact" value="'.$result4[0]['mobile_no'].'" >
   <br> Specialization:<input type="text" name="specialization" id="specialization" value="'.$result4[0]['specialization'].'" >
    <br><input type="submit" name="editing" value="Edit">
    <button onclick="this.parentNode.parentNode.style.display=\"none\";">Cancel</button>
   </form>
    ';
    modal("Edit Form",$input);
}
if(isset($_POST['editing'])&&isset($_POST['username'])&&isset($_POST['age'])
&&isset($_POST['contact'])&&isset($_POST['specialization'])&&isset($_POST['id'])){
    $old=str_replace(" ","_",$_POST["old"])."_";
    $id=$_POST["id"];
    $username=$_POST['username'];
    $age=$_POST['age'];
    $contact=$_POST["contact"];
    $spec=$_POST['specialization'];
    $result1=$conn->updation("users",['username','mobile_no','age','specialization'],
    [$username,$contact,$age,$spec],['id','role'],[$id,'doctor']);
    $result11=$conn->updation("appointment",["doctor_name"],[str_replace(" ","_",$username)."_"],["doctor_name"],[$old]);
    $result12=$conn->updation("availability",["doctor_name"],[str_replace(" ","_",$username)."_"],["doctor_name"],[$old]);
    $result13=$conn->updation("average",["doctor_name"],[str_replace(" ","_",$username)."_"],["doctor_name"],[$old]);
    $result2=$conn->generic_func("ALTER TABLE $old RENAME TO ".str_replace(" ","_",$username)."_");
    echo "ALTER TABLE $old RENAME TO ".str_replace(" ","_",$username)."_";
    if($result1=="1"&&$result11=="1"&&$result12=="1"&&$result13=="1"&&$result2=="1"){
        small_alert("Information of doctor $username has been updated.
        This page will automatically redirect in <span id='sec'></span> seconds.<script>refreshing(3);</script>");
    }
}
if(isset($_POST['view'])){
    $id=$_POST['id'];    
    $result4=$conn->select("users",['id'],[$id]);
    print_r($result4);
   foreach($result4 as $row){
    $input='
    <form action="" method="post">
       Username; <input type="text" name="username" id="username" value="'.$row['username'].'" readonly>
      <br> Age: <input type="text" name="age" id="age" value="'.$row['age'].'" readonly>
      <br> Contact: <input type="text" name="contact" id="contact" value="'.$row['mobile_no'].'" readonly>
      <br> Specialization:<input type="text" name="specialization" id="specialization" value="'.$row['specialization'].'" readonly>
    </form>
    <button onclick="this.parentNode.parentNode.parentNode.style.display=\'none\';">Cancel</button>
    ';
    modal("View Form",$input);
   }
}
if(isset($_POST['delete'])){
    $id=$_POST['id'];
    modal("Delete Doctor","Are you sure you want to delete doctor named ".$_POST["username"].
    " ?   <form method='post' action=''>
                <input type='hidden' name='id' value='$id'>
                <input type='submit' name='confirm_del' value='Yes'>                
                <button onclick='this.parentNode.parentNode.style.display=\"none\";'>No</button>
            </form>
    ");
}
if(isset($_POST['confirm_del'])){
$id=$_POST['id'];
    if($conn->deletion("users",['id'],[$id])){
        small_alert("Doctor deleted successfully.This page will automatically refresh in <span id='sec'></span> seconds.<script>refreshing(3)</script>");
    }
    else{
        small_alert("Deletion Failed.This page will automatically refresh in <span id='sec'></span> seconds.<script>refreshing(2)</script>");
        }
}

?>