<?php
if(session_status()==PHP_SESSION_NONE){
 session_start();
 if(isset($_SESSION['username'])&&isset($_SESSION['role'])&&$_SESSION['status']){
    if($_SESSION['username']=='admin') header("Location:../admin/");
    else if($_SESSION['username']=='doctor') header("Location:../doctor/");
    else  header("Location:../user/");
 }
}
?>

   <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="../icons/css/all.min.css" > -->
        <link rel="stylesheet" href="../css/login-style.css">
        
        <title>Users Login</title>
    </head>
    <body>

        
        <div class="forbelowheader">
        <div class="container">
        <?php
                include_once "../classes/config.php";
                $conn=new DBConnect();
        if(count($_POST)>0) {
                // $conn = mysqli_connect("localhost","root","","drsathi");
                // $sql="SELECT email,username,password,status,role FROM users WHERE username='" . $_POST["username"] . "' and status='1' and password = '". $_POST["password"]."'";
                //     $result = mysqli_query($conn,$sql);
                //     echo $sql;
                include_once "../classes/alerts.php";
                
                include_once "../classes/index.php";
                if(count($conn->select("users"))==0){
                    // $sql="INSERT INTO `users` 
                    // (`username`, `email`, `mobile_no`, `gender`, `age`, `password`, `created_on`, `status`, `role`, `hash`, `viewed`, `patient_id`) VALUES
                    // ( '".encrypt2('admin')."','".encrypt2('admin@gmail.com')."','".encrypt2('')."','".encrypt2('Male')."','".encrypt2('22')."','".encrypt2('admin')."','".encrypt2(time().'')."','1','admin','1','1','".encrypt2('1')."'
                    // );";
                    $sql="INSERT INTO `users` 
                    (`username`, `email`, `mobile_no`, `gender`, `age`, `password`, `created_on`, `status`, `role`, `hash`, `viewed`, `patient_id`) VALUES
                    ( 'admin','admin@gmail.com','','Male','22','admin','".time()."','1','admin','1','1','1'
                    );";
                    $conn->generic_func($sql);
                    // $sql="INSERT into 'users' ('username','password') values('admin','Admin@1')";
                    // $conn->generic_func($sql);
                }
                $result=$conn->own_query("Select * from users where password='".trim($_POST['password'])."' and (username='".strtolower(trim($_POST['username']))."' or email='".strtolower(trim($_POST['username']))."')");
                // $result=$conn->select('users',['username','password'],[$_POST['username'],$_POST['password']]);
                // $result=$conn->select('users',['username','password'],[encrypt2("".$_POST['username']),encrypt2("".$_POST['password'])],1);
                    $count  = count($result);
                    // print_r($result);
            if($count==0) {
                small_alert("Username or password doesnot match.Login Failed");
            // echo '<script>alert("Incorrect")</script>';
            } else {
            if($_POST['username']=='admin'||$_POST['username']=='admin@gmail.com') {
                //    header("Location:../fwd");
            //    if($result["status"]=="1")
               {
                $_SESSION['username']='admin';
                $_SESSION['role']='admin';
                $_SESSION['status']='admin';
                header("Location:../admin/index.php");
               }         
                  
                
            }
                else {
                    
                    // header("Location:../fwduserpanel/userpanel.php");
                        if($result[0]["status"]=="1"&&$result[0]["email_status"]=="1"){
                            $_SESSION['username']=strtolower(trim($result[0]['username']));
                            $_SESSION["role"]=$result[0]['role'];
                            $_SESSION["status"]=$result[0]['status'];
                            if($_SESSION["role"]=="patient") {
                                $_SESSION['id']=trim($result[0]["id"]);
                                header("Location:../user/");
                            }
                            if($_SESSION["role"]=="doctor") {
                                $_SESSION['id']=trim($result[0]["id"]);
                                header("Location:../doctor/");
                            }
                         }
                         else{
                             if($result[0]["status"]!="1")
                            small_alert("Admin has not verified you yet .Please contact admin");
                            if($result[0]["email_status"]!="1")
                            small_alert("Email has not been verified yet .Please check email.");
                         }
                
                }
            }
}
?>
            <div class="forms-container">
                <div class="signin">
                    <form action="" class="sign-in-form" method="POST">
                        <h2 class="title">Sign In </h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="email" placeholder="Username" name="username" required>
                        </div>
                        <div>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" onkeyup="val(this.value)" placeholder="Password"  name="password" required>
                                
                            </div>
                            <span id="message" style="color:red;"></span>
                        </div>
                        <input type="submit" class="btn solid" id='login_btn'  value="login" name="submit"/>

                    </form>
                </div>
            </div>
        </div>

          
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New Here?</h3>
                    <p>Be a part of us </p>
                    <button class="btn transparent" onclick="location.href='users_reg.php'">Sign Up</button>
                </div>
                <img src="../images/signup.svg" alt="signup" class="login-image">
            </div>
        </div>
        </div>
        
    </body>
    </html>
    <script>
        function val(pw){
            
            console.log(pw)
            var x="";
            if(pw == "") {  
                    x= "**Fill the password please!<br>";  
                  
                }                  
                if(pw.search("@")=="-1"){
                    x+="**Special character(@,$!) is missing!<br>";
                }
                if(pw.length < 7) {  
                    x+= "**Password length must be atleast 7 characters!!<br>";  
                   
                }  
                
                if(pw.length > 15) {  
                    x+= "**Password length must not exceed 15 characters!!<br>";  
                   
                } 
                if(x.length==0){
                    
                    document.getElementById("message").innerHTML =" ";
                    document.getElementById("login_btn").disabled=false;
                }
                else{
                    document.getElementById("message").innerHTML =x;
                    document.getElementById("login_btn").disabled=true;
                }
        }
    </script>