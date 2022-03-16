<link rel="stylesheet" href="../css/alert.css">
<?php
function alert_display($text,$heading="",$id='',$color=""){
   echo '<div class="wrapper-warning">';
          //  if($color=="red") echo '<div class="card" style="background-color:red;">';
           echo '<div class="card">';
              echo '<div class="icon"><img class="i_image bck_yellow" src="../images/image_i.png"/></div>';
              if($color=="red")  echo '<div class="subject" ><h3 style="color:red">'.$heading.'</h3>';
              else echo '<div class="subject" ><h3 style="color:royalblue;">'.$heading.'</h3>';
               echo "<p style='padding-left:6px;'>".$text." </P>";
               echo '</div>';
               echo ' <div class="icon-times"  onclick="this.parentNode.parentNode.style.display=\'none\';document.getElementById(\'id\').value=\''.$id.'\';document.getElementById(\'closed\').submit();">x</i></div>';
             echo '</div>';
           echo '</div>';
}
?>
<form action="" method="post" id='closed'>
    <input type="hidden" name="id" id="id">
</form>
