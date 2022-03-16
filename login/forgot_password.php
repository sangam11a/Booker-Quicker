
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
                    <form action="" class="sign-up-form" method="POST">
                        <h2 class="title">Forgot Password </h2>
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Email" name="email" id='email' required>
                        </div>
                       
                       <input type="submit" class="btn solid" name="btn_upload"  value="Forgot Password" name="submit"/>  

                    </form>
                    <?php
                        if(isset($_POST["btn_upload"])&&isset($_POST["email"])){
                            $email=trim($_POST["email"]);
                            // echo $email;
                            include_once "../classes/config.php";
                            $conn=new DBConnect();
                            $result=$conn->own_query("Select username,email from users where email='$email'");
                           if(count($result)=="0"){
                               echo "<p style='color:#20dbc2'>No given email is found</p>";
                           }
                           else{
                               include_once "../payment/mail.php";
                               include_once "../classes/index.php";
                               $headers="From:Dr sathi password reset";
                               $key2=substr(uniqid(),0,6).rand(100,10000);
                               echo $key2;
                               $result2=$conn->insertion("forgot_pass",["email","key2"],[$email,$key2]);
                               echo $result2;
                               $body="
                               This is an email sent to reset password of email: <b>$email</b>.Click link here to reset your password.<a href='http://localhost/new%20doctor%20sathi/login/new_password.php?key1=".encrypt2($email)."&key2=".encrypt2($key2)."'>http://localhost/new%20doctor%20sathi/login/new_password.php?key1=".encrypt2($email)."&key2=".encrypt2($key2)."</a>
                               ";
                               echo $body;
                               if(mails($email,"Forgot Password",$body,$headers)==1){
                                   echo "Email has been sent successfully";
                                   
                               }
                               else{
                                   echo "There is some problem sending email please try again later";
                               }
                           }
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    
                   
                </div>
                <img src="../images/signup.svg" alt="Signup" class="login-image">
            </div>
        </div>
        
       
        <script>
       
    </script>
    </body>
    </html>