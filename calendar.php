<style>
  td,th{
    text-align: center;
    width:10px;
  }
</style>
<?php
  function calendar($result){?>
    <form method="post" action="" name='calendar'>
 
    <select name="month" id="month">
      <?php
         $i=0;
         $array2=['01','02','03','04','05','06','07','08','09','10','11','12'];
         $array=['Jan','Feb','March','April','May','Jun','July','Aug','Sept','Oct','Nov','Dec'];
         for($i=0;$i<12;$i++){
           if(date("m")==$array2[$i]) echo "<option value='".$array2[$i]."' default>".$array[$i]."</option>";
            
          else echo "<option value='".$array2[$i]."'>".$array[$i]."</option>";
         }
      ?>
   
    </select>
    <select name="year" >
    <?php
     $today=date("Y");
     for($j=0;$j<10;$j++){
       echo "<option value='$today'>$today</option>";
       $today++;
     }
    ?>
    </select>
    <input type="submit" name="submit" class="btn btn-danger">
   </form> 
   </table>
   <table>
    <th><table >
   <thead>
    <div >   <th>Sun</th></div>
    <div >   <th>Mon</th></div>
    <div >   <th>Tue</th></div>
    <div >   <th>Wed</th></div>
    <div >   <th>Thurs</th></div>
    <div >   <th>Fri</th></div>
    <div >   <th>Sat</th></div>
   </thead>
    <tbody style="text-align:center;">
   <tr>
    <?php 
   if(isset($_POST['submit']))
   {
    $month= $_POST['month'];
    
   $year=$_POST['year'];}
   else{
     $month=date("m");
     $year=date("Y");}
  {$fontColor="black";
   $day='01';
   $endDate=date("t",mktime(0,0,0,$month,$day,$year));//Total days
     $s=date ("w", mktime (0,0,0,$month,1,$year));//Day starts after
   for ($ds=1;$ds<=$s;$ds++) {
   echo "<td style=\"font-family:arial;color:#B3D9FF\" align=center valign=middle bgcolor=\"#FFFFFF\">
   </td>";}
   for ($d=1;$d<=$endDate;$d++) {
     
        for($j=0;$j<count($result);$j++){
              if (date("w",mktime (0,0,0,$month,$d,$year)) == 0) { echo "<tr>"; }
                   $fontColor="green";
              if (date("Y/m/d",mktime (0,0,0,$month,$d,$year)) == $result[$j]) 
              { 
                $fontColor="red"; break;
            }
            else
              { $fontColor="green"; 
            }
          }
        echo "<td style=\"font-family:arial;color:#333333\" align=center valign=middle> <span style=\"color:$fontColor\">$d</span></td>";
     
      if (date("w",mktime (0,0,0,$month,$d,$year)) == 6) { echo "</tr>"; }}
     
    }
    ?>
    
    </tr>
   </tbody>                                             
           
   </table><?php
  }
?>