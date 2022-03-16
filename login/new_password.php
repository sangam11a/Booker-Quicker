
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="../icons/css/all.min.css"> -->
        <link rel="stylesheet" href="../css/login-style.css">      
        <!-- <link rel="stylesheet" href="../fwd/bootstrap.min.css">   -->
        <title>Change Password</title>
        
    </head>

    <body>
        <div class="container">
            <div class="forms-container">
                <div class="signup">
                    <form action="" class="sign-up-form" method="POST">
                        <h2 class="title">Set New Password </h2>
                       
                       <?php
                       include_once "../classes/index.php";
                       include_once "../classes/config.php";
                       $conn=new DBConnect();
                            if(isset($_GET["key1"])&&isset($_GET["key2"])){
                                $email=decrypt2($_GET["key1"]);
                                $key2=decrypt2($_GET["key2"]);
                                $result=$conn->own_query("Select * from forgot_pass where email='$email' and key2='$key2' and used<>'1';");//select("forgot_pass",["email","key2","used"],[$email,$key2,0]);
                                if(count($result)>0){
                                ?>
                                <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="hidden" name="email2" value="<?=trim(decrypt2($key1));?>">
                                <input type="hidden" name="key2" value="<?=trim(decrypt2($key2));?>">
                                <input type="password" placeholder="Password" name="password" required>
                                <i class="fas fa-eye eye-btn"></i>
                            </div>
                            <div class="input-field">
                                <i class="fas fa-lock"></i>
                                <input type="password" placeholder="Re-Enter Password" name= "confirm-password"required>
                            </div>
                            <input type="submit" class="btn solid" name="btn_upload"  value="Submit" name="submit"/>  
                         <?php   }
                               else{
                                   echo "Link already Used";
                               } 
                            }
                         else{
                             echo "Invalid operation.";
                         }
                         if(isset($_POST["password"])&&isset($_POST["confirm-password"])){
                             if(trim($_POST["password"])==trim($_POST["confirm-password"])){
                                $result1=$conn->updation("forgot_pass",["used"],["1"],["email","key2"],[$email,$_POST["key2"]]);
                                $result2=$conn->updation("users",["password"],[trim($_POST["password"])],["email"],[$email]);
                                if($result1=="1"&&$result2=="1"){
                                    echo "Password successfully Changed";
                                }
                                else{
                                    echo "Some error occured";
                                }
                                
                             }
                             else{
                                 echo "Password does not matches with Confirm password";
                             }
                         }
                       ?>
                           
                       

                    </form>
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
        
       
        
    </body>
    </html>
