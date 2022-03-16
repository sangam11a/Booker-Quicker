
<?php
include_once "../classes/config.php";
include_once "../admin/dashboard.php";
include_once "../classes/modal.php";
$conn=new DBConnect();
$table_name="services";
$total_rows=$conn->total_rows("$table_name","count(*)"," ");
$title=["S.N","Service Name",
"Price","Created On","Option"];
include_once "../classes/dynamic_table.php";
$values=['id','service_name','price','created_on'];
echo '
<form action="" method="post">
<input type="submit" value="Add Service" name="add_services">
</form>
';
table("Services",$title,$values,$total_rows,"$table_name");
if(isset($_POST["add_services"])){
    $input='
    <form action="" method="post">
    Service Name: <input type="text" name="service_name" id="service_name" required>
   <br>Service Price: <input type="text" name="service_price" id="service_price" required>
    <br><input type="submit" value="Add Service" name="add_service" required>
    </form>
    ';
    modal("Add Services",$input);
}
if(isset($_POST['add_service'])){
include_once "../classes/alerts.php";
$service_name=$_POST["service_name"];
$service_price=$_POST["service_price"];
echo '<script src="../classes/refresh.js"></script>';
$result1=$conn->insertion("services",['service_name','price','created_on'],[$service_name,$service_price,time()]);
    if($result1){  
        small_alert('Service added.This page refreshes in <span id="sec"></span> seconds.<script>refreshing(3);</script>');
    }
    else{
        small_alert("Service addition Failed. This page refreshes in <span id='sec'></span> seconds.<script>refreshing(3);</script>");
    }
}
if(isset($_POST['id'])&&isset($_POST['service_name'])&&isset($_POST['price'])&&isset($_POST['opt'])){
   $id=$_POST['id'];
   $service_name=$_POST['service_name'];
   $price=$_POST['price'];
   $opt=$_POST['opt'];
    if($_POST['opt']=='edit'){
        $input='
        <form action="" method="post">
        <input type="hidden" name="id" value="'.$id.'">
            Service Name: <input type="text" name="service_name_2" id="service_name_2" value="'.$service_name.'">
                <br>Price:<input type="text" name="price_2" id="price_2" value="'.$price.'">
                <br><input type="submit" value="Edit" name="edit">
         </form>
        ';
        modal("Edit Services",$input);
    }
    else{
        $input='
        Are you sure you want to delete service named '.$service_name.'?
        <form action="" method="post">
        <input type="hidden" name="service_name_3" id="service_name_3" value="'.$service_name.'">
        <input type="hidden" name="price_3" id="price_3" value="'.$price.'">
            <br><input type="submit" value="Delete" name="delete">
            <button onclick="this.parentNode.parentNode.style.display=\'none\';">Cancel</button>
         </form>
        ';
        modal("Edit Services",$input);
    }
}
if(isset($_POST['delete'])){
$service_name=$_POST['service_name_3'];
$price=$_POST["price_3"];
$result12=$conn->deletion('services',['service_name','price'],[$service_name,$price]);
    if($result12){
        include_once "../classes/alerts.php";
        echo "<script src='../classes/refresh.js'></script>";
        small_alert("Delete operation of $service_name has been successfully conducted. This page will refresh in <span id='sec'></span> seconds.<script>refreshing(3);</script>");        
    }
    else{

    }
}
if(isset($_POST['edit'])){
    $id=$_POST['id'];
    $service_name=$_POST['service_name_2'];
    $price=$_POST["price_2"];
    $result13=$conn->updation('services',['service_name','price','created_on'],[$service_name,$price,time()],['id'],[$id]);
    if($result13){
            include_once "../classes/alerts.php";
            echo "<script src='../classes/refresh.js'></script>";
            small_alert("$service_name has been updated. This page will refresh in <span id='sec'></span> seconds.<script>refreshing(3);</script>");
    }
    else{

    }
}
?>
<script>
    function option_click(x,y){
        var values=y.split("^");
        document.getElementById('id').value=values[0];
        document.getElementById('service_name').value=values[1];        
        document.getElementById('price').value=values[2];
        document.getElementById('opt').value=x;
        document.getElementById('perform_crud').submit();
    }
</script>
<form action="" method="post" id="perform_crud">
    <input type="hidden" name="id" id="id">
    <input type="hidden" name="service_name" id="service_name">
    <input type="hidden" name="price" id="price">
    <input type="hidden" name="opt" id="opt">
</form>
