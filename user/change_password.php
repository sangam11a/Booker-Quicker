<?php
include_once "../admin/dashboard.php";
?>
<style>
    .paddng{
        padding-left:200px;
        display: flex;
        margin-top:-18px;
        padding-bottom: 9px;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>
</head>
<body>
    <div class="container">
        <h3>Change Password</h3>
        <form action="" method="post">
            <div>
                <label for="old_">Old Password</label>
               <span class='paddng'><input  type="password" name="old_password" id="old_password" class=''>
                </span> 
            </div>
            <div>
                <label for="password">New Password</label>
               <span class='paddng'><input  type="password" name="new_password" id="new_password" class=''>
                </span> 
            </div>
            <div>
                <label for="password">Confirm New Password</label>
               <span class='paddng'><input  type="password" name="confirm_password" id="confirm_password" class=''>
                 </span> 
            </div>
            <div>
                <input type="submit" name="change_password" value="Change Password" class=''>
            </div>
        </form>
        <div id="error" style='color:red;font-size:18px;font-style:italic;font-weight:400;'></div>
    </div>
</body>
</html>
<?php
include_once "../classes/config.php";
if(isset($_POST["change_password"])){
    $old_password=$_POST["old_password"];
    $new_password=$_POST["new_password"];
    $con=new DBConnect();
    if($_SESSION['role']=="patient") $usr=$_SESSION['username'];
    else if($_SESSION['role']=="doctor") $usr=remove_underscore($_SESSION['username']);
    $result=$con->select("users",['username'],[$usr]);
    if(count($result)>0){
        $e=0;$error=" ";
        if($old_password!=$result[0]["password"]){
            $error.="Incorrect Old password<br>";$e=1;
        }
        if($new_password!=$_POST["confirm_password"]){
            $error.="New password does not matches with Old password.<br>";$e=1;
        }
        if($e==0){
            $result2=$con->updation("users",["password"],[$new_password],['username'],[$usr]);
            echo "<script>document.getElementById('error').innerHTML='Password successfully Changed';</script>";
        }
        else{
            echo "<script>document.getElementById('error').innerHTML='$error';</script>";
        }
    }
    else{
        echo "No such user exists";
    }
}
?>