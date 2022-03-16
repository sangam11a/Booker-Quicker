
<?php
	include_once "../classes/config.php";
	include_once "../classes/index.php";
	if (isset($_POST["btn_upload"]) == "submit")
	{	//print_r($_FILES);
		$username=strtolower(trim($_POST["username"]));
		$email=strtolower(trim($_POST["email"]));
		$mobile_no=$_POST["mobile-no"];
		$gender=$_POST["gender"];
		$age=$_POST["age"];
		$pass=$_POST["password"];
		$confirm_pass=$_POST["confirm-password"];
		$role=$_POST["role"];
		$hash = uniqid()."a".rand(100,9999);

			if($pass==$confirm_pass)
			{$conn=new DBConnect();
				$specializaion=0;
				if(isset($_POST['specialization'])) $specializaion=$_POST['specialization'];
				$array1=['username','email','mobile_no','gender','age','password','created_on','hash','role','specialization'];
				$array2=[$username,$email,$mobile_no,$gender,$age,$pass,time(),$hash,$role,$specializaion];
				$result=$conn->insertion("users",$array1,$array2,1);
				$last_id=$conn->own_query("Select max(id) from users");
				if($role=='doctor') {
					$result1=$conn->create_tbl($username);/// create table named by doctor
					$result2=$conn->insertion("average",['doctor_name'],[space_removal(trim($username))]);
						if(is_uploaded_file($_FILES['doctor_certificate']['tmp_name']))
						{
							$target_dir = "doctor_certificate/";
							$target_file = $target_dir . basename($_FILES["doctor_certificate"]["name"]);
							$uploadOk = 1;
							$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
							// Check if image file is a actual image or fake image
							// if(isset($_POST["submit"])) {
							// $check = getimagesize($_FILES["doctor_certificate"]["tmp_name"]);
							// // if($check !== false)
							// //  {
								$ext = pathinfo($target_file, PATHINFO_EXTENSION);
								$stamp=time();
								$filename="$stamp.$ext";
							// // 		$uploadOk = 1;
							// // 	} else {
							// // 		echo "File is not an image.Please upload again";
							// // 		$uploadOk = 0;
							// // 	}
							// }   
							if ($uploadOk == 0) {
								echo "Sorry, your file was not uploaded.";
							  } else {
								if (move_uploaded_file($_FILES["doctor_certificate"]["tmp_name"], "../doctor/doctor_certificate/".$filename)) {
								   $sql="Insert into doctor_certificate(file_name,doctor_id,license) values('$filename','".$last_id[0]["max(id)"]."','".$_POST["nmc_number"]."')";
								  
									$result21=$conn->generic_func($sql);									
								} else {
								  echo "Sorry, there was an error uploading your file.";
								}
							}
						   }
					
					
				}if($result==1){
					if($role=='patient') {
						$result11=$conn->select("users",['email'],[$email],1);
						if($last_id[0]["max(id)"]==NULL){
							$get_id=generate_id("1");
						}
						else{
							$get_id=generate_id("".$last_id[0]["max(id)"]);
						}
						$result4=$conn->updation("users",['patient_id'],[$get_id],['email'],[$email]);
					}
					include_once "../classes/alerts.php";
					// echo "<script>mailing('".$email."','".$username."');</script>";
					small_alert('Success','Username '.$username.' created successfully');					
            		$receiver = "$email";
						$subject = "Email Verification From Dr Sathi";
						$body = "Thanks for signing up!
						Please click this link to activate your account:
						http://localhost/new doctor sathi/login/users_email_verify.php?hash=$hash&email=$email
						";
						$sender = "From:Doctor sathi";
						if(mail($receiver, $subject, $body, $sender)){
							echo "<script>alert('A verification link has been sent to your email. Verify your email and we will email you after validation of your submission.');</script>";
							}else{
							echo "<script>alert('Error in sending verification email.');</script>";
							
						}
            		}
           
				}
				else{
				echo "<script>alert('Your password dont match.Try again');</script>";
					
					}

    }
          
       
			
	
?>