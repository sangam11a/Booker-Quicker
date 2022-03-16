
<?php
date_default_timezone_set("Asia/Kathmandu");   
if(session_status()==PHP_SESSION_NONE){
  session_start();
              if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
              $url = "https://";   
              else  
              $url = "http://";      
              $url.= $_SERVER['HTTP_HOST'];   

              $url.= $_SERVER['REQUEST_URI'];    

              $array=explode("/",$url);
              if($_SESSION["role"]=='patient') $roles="user";
              else $roles=$_SESSION["role"];
              if($array[4]==$roles){   
              }else{
                include_once "../classes/alerts.php";  
                echo "<script>var timeout ;
                function refreshing1(i) {
                document.getElementById('sec').innerHTML=i;
                timeout = setTimeout(refreshing1, 1000,i-1);
                if(i==0) {
                    clearTimeout(timeout);
                 }
                }
                </script>";              
                echo "<div style='left:0;padding:10px 12px;font-size:22px;font-weight:500;position:relative;z-index:1000000;height:100vh;width:100vw;background-color:white;'>";
                echo " This page cannot be accessed.You will be redirected in <span id='sec' style='color:red;font-weight:700;'></span> second to where you belong.<script>refreshing1(3);</script>";
                echo "</div>";
                if($_SESSION['role']=='patient') $redirect="user";
                else $redirect=$_SESSION["role"];
                if(strlen($array[5])>0) {
                  // echo "<div style='leftt:0;position:relative;z-index:1000000;height:100vh;width:100vw;background-color:white;'>";
                  
                  // echo "../../</div>";
                  header( "refresh:3;url=../$redirect" );
                }
                else {
                  // echo "<div style='leftt:0;position:relative;z-index:1000000;height:100vh;width:100vw;background-color:white;'>";
                  //  echo "../</div>";
                  header( "refresh:3;url=../$redirect" );
                }
              }
    
  if(!(isset($_SESSION['username'])&&isset($_SESSION["role"]))){
     header("Location:../login/");
  }
  else{
    $username=$_SESSION["username"];
     $role=$_SESSION["role"];
  }
 }
 
?>
<!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@320&display=swap" rel="stylesheet"> -->
<!-- <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet"> -->
<!-- <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'> -->
<style>
body {
  margin: 0;
  padding:0;
  top:0;
  left:0;
  right:0;bottom:0;
  font-family:'Poppins', sans-serif; 
  font-size:16px;
}

.sidebar {
  margin: 0px;
  padding: 0px;  
  padding-top:16vh;
  width: 200px;
  background-color:white;
  box-shadow: 3px 0 20px rgb(0,0,0, .40);
  position: fixed;
  height: 100%;
  overflow: auto;
  left:0;
  top:0;
}
.selected{
background-color: rgb(245,245,255);
}

.sidebar a {
  display: block;
  color: black;
  padding: 16px;
  text-decoration: none;
}
 
.sidebar a.active {
  background-color: #04AA6D;
  color: white;
}

.sidebar a:hover:not(.active) {
  background-color: #555;
  color: white;
}

.content {
  margin-left: 200px;
  /* padding-top: 14vh; */
  padding: 12vh 16px;
  min-height:75%;
  background-color: rgba(25,10,10,0.10);
}

.navbar1{
  width:100%;
  background-color:white;
  height:10vh;  
   position: fixed;
  z-index:99999;
  box-shadow: 3px 0 20px rgb(0,0,0, .40); 
  /* box-shadow: 1px 1px white; */
}
.navbar1-stl{  
    text-decoration: none;
    height:fit-content;
    background-color: #18a689;
    color:whitesmoke;   
}
.navbar1-st1:hover{
 background-color:  #41a124;
}
.navbar1-margin{  
    display: relative;
    float:right;
    margin:0;
    padding:0;
    padding:5px 6px;
    margin-right:10px;
    margin-top:10px; 
    margin-bottom:10px; 
}
.navbar1-margin:hover{
cursor:pointer;
}
.content-fit{
  height:max-content;
}
.welcomeText{
  padding:0;
  margin:0;
  margin-right:10px;
  text-align: center;
  float:right;
  
}
.afterWelcomeText{
  display:flex;
  float:right;
}


@media screen and (max-width: 400px) {
  .sidebar a {
    text-align: center;
    float: none;
  }
}
/* .sticky {
  position: fixed;
  top: 0;
  width: 100%;
} */
</style>

<!-- <div class="navbar1 ">
  <a class='navbar1-stl navbar1-margin ' href="../login/logout.php">Log Out</a>
  <span class="navbar1-margin">Welcome <?php  echo $username;?></span>
  <?php
    // if($role!='admin'){
    //   if($role=='patient') echo "<a class='navbar1-stl navbar1-margin' href='../user/change_password.php';>Change Password</a>";
    //   else echo "<a class='navbar1-stl navbar1-margin' href='../doctor/change_password.php';>Change Password</a>";
    // }
  ?>
</div> -->
<div class="navbar1">
  <div class="navbarContent">
    <span><img src="../images/logo1.png" alt="Logo"  style="z-index:99999;height:80px;width:170px;"></span>
  <div class="navbar1-margin welcomeText">
     <span style="margin-right:10px;" >Welcome</span> <img src="../images/userIcon.svg" alt="User Icon" style="margin-top:5px;height:30px"> <span style="color:#18a689;margin-left:3px;" ><?php  echo ucwords ($username);?></span>
    </div>
 <span class="afterWelcomeText"><p><?php
    if($role!='admin'){
      if($role=='patient') echo "<a class='navbar1-stl navbar1-margin' href='../user/change_password.php';>Change Password</a>";
      else echo "<a class='navbar1-stl navbar1-margin' href='../doctor/change_password.php';>Change Password</a>";
    }
    ?></p>
    <a class='navbar1-stl navbar1-margin' href="../login/logout.php">Log Out</a>
    </span> 
    </div>
</div>
<div class="sidebar" id='sidebar'>
  <?php
    if($role=='admin'){
   ?>
     <a class='anchor' onclick="selection(this)" href="../admin/index.php">Dashboard</a>
     <a class='anchor' href="../admin/view_all_appointments.php">All Appointments</a>
     <a class='anchor' href="../admin/list_doctors.php">Doctors</a>
     <a class='anchor' href="../admin/list_patients.php">Patients</a>
     <a class='anchor' href="../admin/search_history.php">Search Patient</a>
     <a class='anchor' href="../admin/services.php">Services</a>
     <a class='anchor' href="../admin/view_cancelled_appointments.php">Cancelled appointments</a>
     
   <?php
    }
    else if($role=="doctor"){
    ?>
        <a class='anchor'  href="../doctor/index.php">Dashboard</a>
        <a class='anchor' href="../doctor/add_working_days.php">Add working days</a>
        <a class='anchor' href="../doctor/view_working_days.php">Edit working days</a>
        <a class='anchor' href="../doctor/view_appointments.php">Diagnosis</a>
   <?php
    }
    else
    {
   ?>
      
      <a  class='anchor' href="../user/">Dashboard</a>
      <a class='anchor' href="../user/list_doctors.php">List doctors</a>
      <a  class='anchor' href="../user/book_appointment.php">Book appointment</a>
      <a  class='anchor' href="../user/profile.php">View profile</a>
      <a  class='anchor' href="../user/view_booked_appointments.php">Appointment History</a>
      <a class='anchor' href="../user/upcoming_appointments.php">Upcoming Appointments</a>
  <?php
    }
  ?>
 


</div>

<div class="content">
  
