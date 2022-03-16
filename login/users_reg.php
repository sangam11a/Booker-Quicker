<?php
include('users_reg_upload.php');
?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="../icons/css/all.min.css"> -->
        <link rel="stylesheet" href="../css/login-style.css">      
        <!-- <link rel="stylesheet" href="../fwd/bootstrap.min.css">   -->
        <title>Document</title>
        <script>
            function specialize(val){
                console.log(val);
                if(val=='doctor'){
                    document.getElementById('specialize').style.display='block';
                    filess(val)
                }
                else{
                    document.getElementById('specialization').value=0;
                }
            }
        </script>
    </head>

    <body>
        <div class="container">
            <div class="forms-container">
                <div class="signup">
                    <form action="" class="sign-up-form" method="POST" enctype="multipart/form-data">>
                        <h2 class="title">Sign Up </h2>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Full Name" name="username" id='name' required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Email" name="email" id='email' required>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-phone"></i>
                            <input type="tel" placeholder="Mobile No" id="mobile" minlength="10" maxlength="10" name="mobile-no" required>
                        </div>
                        <div class="input-field ">
                            <div class="radio">
                            <i style="font-style: normal;font-size:larger; color: rgb(121, 121, 121);padding-left: 15px;"> Gender</i>
                            <Label style="padding-left:10px ;">Male</Label><input type="radio" placeholder="Male" value="male" name="gender" required>
                            <Label>Female </Label><input type="radio" placeholder="feMale" value="female" name="gender" required>
                        </div>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-child"></i>
                            <input type="number" placeholder="age" name="age" min="10" max="70" required>
                        </div>
                        <div>
                           <select name="role" class='role' id="role" onchange="specialize(this.value)" required>
                               <option value="" >Select Role</option>
                               <option value="doctor">Doctor</option>
                               <option value="patient">Patient</option>
                           </select>
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" onkeyup="val(this.value)" placeholder="Password" name="password" required>
                            <!-- <i class="fas fa-eye eye-btn"></i> -->
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password"  placeholder="Re-Enter Password" name= "confirm-password"required>
                        </div>
                        <div id='specialize' class="input-field" style='display:none;'>
                        <i class="fas fa-user-md"></i>
                            <input type="text" placeholder="Specialization" name= "specialization" id="specialization" required>
                        </div>
                        
                        <div id="cert">
                        
                        </div>
                        <div id="message"></div>
                       <input type="submit" class="btn solid " id="s_btnn" name="btn_upload"  value="Register" name="submit"/>  

                    </form>
                </div>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Already have an Account?</h3>
                    <p>Why wait! </p>
                    <button class="btn transparent" onclick="location.href='index.php';">Sign In</button>
                </div>
                <img src="../images/signup.svg" alt="Signup" class="login-image">
            </div>
        </div>
        
       
        <script>
       document.getElementById("name").onkeydown = function(e) {name(e)};
            function name(e) {
            if (e.shiftKey || e.ctrlKey || e.altKey) {                
                e.preventDefault();                
                } else {                
                    var key = e.keyCode;                
                    if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                        e.preventDefault();                    
                    }
                }
            }
            document.getElementById("mobile").onkeydown = function(e) {number(e)};
            function number(e) {
            if (e.shiftKey || e.ctrlKey || e.altKey) {                
                e.preventDefault();                
                } else {                
                    var key = e.keyCode;                
                    if (( (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {                
                        e.preventDefault();                    
                    }
                }
            }
        function filess(x){
                if(x.toLowerCase()=="doctor"){
                    document.getElementById('cert').innerHTML="Certificate:<input  type='file' name='doctor_certificate' required>";
                    document.getElementById('cert').innerHTML+=' <div class="input-field"><i class="fas fa-user-md"></i><input type="text" placeholder="NMC number" name= "nmc_number"required></div>';
                }
            }
    </script>
    <script>
        function val(pw){
            var x="";
            if(pw == "") {  
                    x= "**Fill the password please!<br>";  
                  
                }                  
                if(pw.search("@")=="-1"){
                    x+="**Special character(@,$!) is missing!<br>";
                }
                if(pw.length < 6) {  
                    x+= "**Password length must be atleast 6 characters!!<br>";  
                   
                }  
                
                if(pw.length > 15) {  
                    x+= "**Password length must not exceed 15 characters!!<br>";  
                   
                } 
                if(x.length==0){            
                    
                    document.getElementById("message").innerHTML =" ";        
                    document.getElementById("s_btnn").disabled=false;
                }
                else{
                    document.getElementById("message").innerHTML =x;
                    document.getElementById("s_btnn").disabled=true;
                }
        }
    </script>
    </body>
    </html>