
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

.table{
  margin-top:10px;
}
.sidebar {
  margin: 0px;
  padding: 0px;
  padding-top:10vh;  
  border-right-width: 2px;
  border-right-style: solid;
  border-right-color: #dcdcdc;
  width: 210px;
  background-color:white;
  /* box-shadow: 3px 0 20px rgb(0,0,0, .40); */
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
  /* display: block;
  color: black;
  padding: 22px;
  height:10vh;
  text-decoration: none; */
  
    display: block;
    color: black;
    margin-top: 4px;
    padding: 5px 18px;
    height: 7vh;
    text-decoration: none;

}
 
.sidebar a.active {
  background-color: #04AA6D;
  color: white;
  border-left-width: 10px;
  padding: 5px ;
  border-left-style: solid;
  border-left-color: #18a689;
}

.sidebar a:hover:not(.active) {
  background-color: #18a689;
  color: white;
  height:fit-content;
  border-left-width: 10px;
  border-left-style: solid;
  border-left-color: orange;
  
 
}

.content {
  margin-left: 210px;
  
  /* margin-top: 66px; */ 
  /* sticky */
    padding: 12px 16px;
  /* padding-top: 14vh; */
  min-height:90%;
  background-color: rgba(10,10,10,0.01);
}

.navbar1{
  width:100%;
  /* float:right; */
  background-color:white;
  height:10vh;  
   position: relative;
  z-index:99999;
  /* box-shadow: 3px 0 20px rgb(0,0,0, .40); */
  /* -webkit-box-shadow: 0 8px 6px -6px #777;
       -moz-box-shadow: 0 8px 6px -6px #777;
            box-shadow: 0 8px 6px -6px #777; */
            border-bottom-width: 2px;
  border-bottom-style: solid;
  border-bottom-color: #dcdcdc;
  
}

.navbarContent{
  height:inherit;
    display: grid;
    grid-template-columns: 75% 25%;
  /* display:flex; */
  /* justify-content: Space-between; */
}
.navbar1-stl{  
    text-decoration: none;
    background-color:#18a689;
    color:whitesmoke;
    margin-left:5px;
    height: 35px;
    border-radius:4px;   
}
.navbar1-margin{  
    display: relative;
    /* float:right; */
    padding:9px;
    margin-right:10px;
    margin-top:10px;
    
}

.dashboard_username:hover{
  color:green !important;
}

.welcomeText{
  display:flex;
  
}
.afterWelcomeText{ 
  margin-top:18px;
    display: grid;
    grid-template-columns: 60% 40%;
}


.navbar1-margin:hover{
cursor:pointer;
}
.content-fit{
  height:max-content;
}
#here_we_go{
  margin-left:10px;
  font-weight:500;
}
button,input[type=submit]{
 background-color:#18A689;
 color:white;
 padding:5px 6px;
 margin-right:6px;
 margin-bottom:6px;
 border:0px;
 font-size:16px;
 border-radius: 3px;
}
button:hover,input[type=submit]:hover{
 background-color:#04AA6D;
}
h2,h3,h4,h5{
  color:#18A689;
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
<script>
//  removeClass();
  
  function removeClass()
  {
   var allElements = document.querySelectorAll(".active");
   for(i=0; i<allElements.length; i++)
   { 
    allElements[i].classList.remove('active');
   }
  }
</script>
<link rel="stylesheet" href="../css/fontawesome/css/all.css">
    

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
<div > 
  <!-- style="position: fixed;  top: 0;  width: 100%;" -->
  <div class="navbar1">
    <div class="navbarContent">
    <div class="navbar1-margin welcomeText">
    <?php
      if($_SESSION["role"]=="admin"){
        $url="admin";
      }
      else if($_SESSION["role"]=="patient"){
        $url="user";
      }
      else{
        $url="doctor";
      }
    ?>
    <span style="margin-right:100px;    margin-left: 40px;
      color: green;
      font-weight: 700;
      font-size:x-large" onclick="location.href='../<?=$url;?>'">Dr Sathi</span> 
      <img src="../images/userIcon.svg" alt="User Icon" style="margin-top:-7px;height:30px;margin-right:7px"> 
      <span style="margin-right:10px;" >Welcome</span> 
      <span class="dashboard_username" style="color:#18a689;margin-left:3px;hover:green" ><?php  echo ucwords ($username);?></span>
      </div>
  <span class="afterWelcomeText"><span><?php
      if($role!='admin'){
        if($role=='patient') echo "<a class='navbar1-stl navbar1-margin' href='../user/change_password.php';>Change Password</a>";
        else echo "<a class='navbar1-stl navbar1-margin' href='../doctor/change_password.php';>Change Password</a>";
      }
      ?></span>
      <span>
      <a class='navbar1-stl navbar1-margin' href="../login/logout.php">Log Out</a>
      </span>
      </span> 
      </div>
  </div>
</div>
<div class="sidebar" id='sidebar'>
  <script>
    // function selection(x){
    // console.log(x);
    removeClass();
    // x.classList.add("active");
  // }
  </script>
  <?php
    if($role=='admin'){
   ?>
     <a class='anchor' onclick="selection(this);" href="../admin/index.php"><i class="fa-solid fa-gauge fa-2x"></i><span id='here_we_go'>Dashboard</span></a>
     <a class='anchor' onclick="selection(this)" href="../admin/view_all_appointments.php">        <i class="fa-solid fa-calendar-check fa-2x"></i><span id='here_we_go'>All Appointments</span></a>
     <a class='anchor' onclick="selection(this)" href="../admin/list_doctors.php"><i class="fa-solid fa-user-doctor fa-2x"></i><span id='here_we_go'>Doctors</span></a>
     <a class='anchor' onclick="selection(this)" href="../admin/list_patients.php">
      <i class="fa-solid fa-user fa-2x"></i><span id='here_we_go'>Patients
    </span></a>
     <a class='anchor' onclick="selection(this)" href="../admin/search_history.php"><i class="fa-solid fa-magnifying-glass fa-2x"></i><span id='here_we_go'>Search</span></a>
     <a class='anchor' onclick="selection(this)" href="../admin/services.php"><i class="fa-solid fa-bed-pulse fa-2x"></i><span id='here_we_go'>Services</span></a>
     <a class='anchor' onclick="selection(this)" href="../admin/view_cancelled_appointments.php">
     <i class="fa-solid fa-rectangle-xmark fa-2x"></i><span id='here_we_go'>Cancelled appointments</span></a>
     
   <?php
    }
    else if($role=="doctor"){
    ?>
        <a class='anchor active'  href="../doctor/index.php"><i class="fa-solid fa-gauge fa-2x"></i><span id='here_we_go'>Dashboard</span></a>
        <a class='anchor' onclick="selection(this)" href="../doctor/add_working_days.php"><i class="fa-solid fa-plus fa-2x"></i><span id='here_we_go'>Add working days</span></a>
        <a class='anchor' onclick="selection(this)" href="../doctor/view_working_days.php"><i class="fa-solid fa-edit fa-2x"></i><span id='here_we_go'>Edit working days</span></a>
        <a class='anchor' onclick="selection(this)" href="../doctor/view_appointments.php"><i class="fa-solid fa-list fa-2x"></i><span id='here_we_go'>Appointments</span></a>
   <?php
    }
    else
    {
   ?>
      
      <a  class='anchor' onclick="selection(this)" href="../user/"><i class="fa-solid fa-gauge fa-2x"></i><span id='here_we_go'>Dashboard</span></a>
      <a class='anchor' onclick="selection(this)" href="../user/list_doctors.php"><i class="fa-solid fa-list fa-2x"></i><span id='here_we_go'>List doctors</span></a>
      <a  class='anchor' onclick="selection(this)" href="../user/book_appointment.php"><i class="fa-solid fa-calendar fa-2x"></i><span id='here_we_go'>Book appointment</span></a>
      <a  class='anchor' onclick="selection(this)" href="../user/profile.php"><i class="fa-solid fa-user fa-2x"></i><span id='here_we_go'>View profile</span></a>
      <a  class='anchor' onclick="selection(this)" href="../user/view_booked_appointments.php"><i class="fa-solid fa-history fa-2x"></i><span id='here_we_go'>Appointment History</span></a>
      <a class='anchor' onclick="selection(this)" href="../user/upcoming_appointments.php"><i class="fa-solid fa-bars"></i><span id='here_we_go'>Upcoming Appointments</span></a>
  <?php
    }
  ?>
 


</div>

<div class="content">
  
