<?php
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
$url = "https://";   
else  
$url = "http://";      
$url.= $_SERVER['HTTP_HOST'];   

$url.= $_SERVER['REQUEST_URI'];    

$array=explode("/",$url);
echo $array[4];
if($array[4]==$_SESSION["role"]||$array[5]==$_SESSION["role"]){
    echo "You dont have access to these.You are being redirected to where you belong;";
    // header( "refresh:5;url=../$array[4]" );
}
?>