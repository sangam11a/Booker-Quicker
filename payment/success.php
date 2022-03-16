<?php
$error=1;
if(count($_GET)>="5"){
    // if(){}
// if(($_GET["oid"]&&$_GET["amt"]&&$_GET["refid"]&&$_GET["id"]&&$_GET["cin"]&&$_GET["cout"]&&$_GET["package"]&&$_GET["pkg_price"])){
    $oid=$_GET["oid"];
    $amt=$_GET["amt"];
    $refId=$_GET["refId"];
    $id=$_GET["id"];
    $bill_number=$_GET["bill_number"];
    include_once "../classes/config.php";
    $conn=new DBConnect();
   $result1=$conn->select("appointment",["id"],[$id]);
   if(count($result1)>0){
    if($result1[0]["service_charge"]==$amt)
        {
            $result=$conn->updation("appointment",
            ['payment_status'],
            [date("Y/m/d")],
            ['id'],
            [$id]);
            if($result=="1"){
                $error=0;
                $result12=$conn->insertion("transactions",["id","transaction_code","bill_number","payment_date"],[$id,$refId,$bill_number,time()]);
                if($result12=="0"){
                    $error=11;
                }
                else  $error=0;
            }
        }

   
    
    }
    // echo "<script src='../classes/refresh.js'></script>";
    if($error==0){
        include_once "../classes/alerts.php";        
        small_alert("Payment has been conducted successfully.You will now be redirected to dashboard in 3 seconds.");
        echo header( "refresh:3;url=../user/");
    }
    
    else if(count($_GET)<="4"){
        echo "Invalid Operation. You will now be redirected to dashboard in 3 seconds.";
        echo header( "refresh:3;url=../user/");
    }
    else if($error==11){
        echo "Payment has already been conducted successfully.";
        echo header( "refresh:1;url=../user/");
    }
    else {
        include_once "../classes/alerts.php";
        small_alert("Payment operation has failed because transaction amt is not equal to paid amount. You will now be redirected to dashboard in 3 seconds.");
        echo header( "refresh:3;url=../user/");
    }
}
?>