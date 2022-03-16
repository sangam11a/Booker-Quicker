<?php
    // include_once "../classes/index.php";
    // $conn=new DBConnect();    
    $result4=$conn->own_query("Select count(*) from transactions");
    if($result4[0]["count(*)"]!="0"){
        $idd=(float)$result4[0]["count(*)"]+1;
        $pid=generate_bill("$idd"); 
    }
    else{
        $pid=generate_bill("1");
    }
?>