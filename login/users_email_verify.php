<?php
$error=0;
if(isset($_GET["hash"])&&isset($_GET["email"])){
    include_once "../classes/config.php";
    $conn=new DBConnect();
    $result=$conn->updation("users",["email_status"],[1],["email","email_status","hash"],[$_GET["email"],0,$_GET["hash"]]);
    if($result=="1"){
       echo " Email has been successfully verified.You will be redirected to login page in 2 seconds";
    }
    else{
        $error=11;
    }
}
else{
    $error=1;
}
if($error==1){
    echo "Invalid operation";
}
if($error==11){
    echo "Hash key does not match.";
}
?>