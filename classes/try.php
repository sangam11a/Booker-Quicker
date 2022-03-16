
<?php
if(is_uploaded_file($_FILES['doctor_certificate']['tmp_name']))
{
    $target_dir = "doctor_certificate/";
    $target_file = $target_dir . basename($_FILES["doctor_certificate"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["doctor_certificate"]["tmp_name"]);
    if($check !== false) {
        $ext = pathinfo($target_file, PATHINFO_EXTENSION);
        $stamp=time();
        $filename="doctor_certificate/$stamp.$ext";
            $uploadOk = 1;
        } else {
            echo "File is not an image.Please upload again";
            $uploadOk = 0;
        }
    }   
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
      } else {
        if (move_uploaded_file($_FILES["doctor_certificate"]["tmp_name"], $filename)) {
           $sql="Insert into doctor_certificate(file_name,doctor_id) values('$filename','".$last_id[0]["max(id)"]."')";
          
            if($conn->own_query($sql)=="1"){
                echo "Amenity added";
            }
            else{
                echo "Addition failed";
            }
        } else {
          echo "Sorry, there was an error uploading your file.";
        }
    }
   }
   ?>