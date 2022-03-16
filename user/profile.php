<?php
include_once "../admin/dashboard.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body>
    <div class="container1 wrapper">
        <?php
            include_once "../classes/config.php";
            $conn=new DBConnect();
            $result=$conn->select("users",['username'],[$_SESSION['username']]);
            echo "<table><tr><td>Name</td><td>".$result[0]['username'] .            
            "</td></tr><tr><td>Email</td><td>".$result[0]['email'].
            "</td></tr><tr><td>Contact number</td><td>".$result[0]['mobile_no'].
            "</td></tr><tr><td>Gender</td><td>".$result[0]['gender'].
            "</td></tr><tr><td>Age</td><td>".$result[0]['age'].
            "</td></tr><tr><td>Created Date</td><td>".date("Y/m/d",$result[0]['created_on'])
            ."</td></tr></table>";
            
        ?>
    </div>
</body>
</html>