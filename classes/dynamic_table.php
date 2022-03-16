<link rel="stylesheet" href="../css/table.css">

<?php
function table($caption,$title,$values,$total_rows,$table_name,$total_pages="10"){
  
   include_once "../classes/config.php";
   $conn=new DBConnect();
        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
            } 
            else {
            $pageno = 1;
        }         
        $no_of_records_per_page = $total_pages;       
        $offset = ($pageno-1) * $no_of_records_per_page;
        $temp_count=$conn->own_query("Select count(*) from $table_name");
        $total_rows=$temp_count[0]["count(*)"];
        $total_pages = ceil($total_rows / $no_of_records_per_page);
        $result=$conn->total_rows($table_name,"*"," order by id LIMIT $offset, $no_of_records_per_page ");
        // $id=$offset;
        if($total_rows==0){
            print("<p style='color:red;font-size:19px;'>No data available</p>");
        }
        else{
            // echo "<input type='text' value='$values'>";
        echo " <caption><h3>$caption</h3></caption>
        <table class='table'><tr>
        ";$can=0;
        $reason=0;//reason
        for($i=0;$i<count($title);$i++){
            echo "<td>";
                echo "$title[$i]";
                if($title[$i]=="Cancelled On"){
                    $can=$i;
                }
                if($title[$i]=="Reasons"){
                    $reason=1;
                }
            echo "</td>";      
        }
        echo "</tr>";
        $pp=1;
                foreach($result as $row){
                    echo "<tr>";
                    
                    if($title[0]=='S.N') {echo "<td>".intval($offset)+$pp."</td>";$pp++;}
                    for($j=1;$j<count($values);$j++){
                        
                        if($can==$j) {
                            echo "<td>".date("Y/m/d H:i:s",$row[$values[$j]])."</td>";
                           }
                       else if($title[$j]=='Created On') echo "<td>".date("Y/m/d H:i:s",$row[$values[$j]])."</td>";
                      else if($reason==1){
                          echo "<td>";
                                if(strlen($row[$values[$j]])<30){
                                    echo $row[$values[$j]];
                                }
                                else{
                                    echo substr($row[$values[$j]],0,30).".....";
                                }
                          echo "</td>";
                      } 
                       else echo "<td>".$row[$values[$j]]."</td>";
                    }
                    if(count($title)!=count($values)){
                        echo "<td><button class='edit_btn1' onclick='option_click(\"edit\",\"".implode('^',$row)."\")'>Edit</button>
                        <button  onclick='option_click(\"delete\",\"".implode('^',$row)."\")'>Delete</button></td>";
                    }
                    echo "</tr>";
                }
        echo" </table>";
        

?>
<ul class="pagination">
        <li><a class='pagination_buttons <?php if($pageno==1) echo'disabled'; else echo 'enabled'; ?>' href="?pageno=1">First</a></li>
        <li>
            <a class="pagination_buttons <?php if($pageno <= 1){ echo 'disabled'; } else echo 'enabled';?>" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="">
            <a class="pagination_buttons <?php if($pageno >= $total_pages){ echo 'disabled'; } else echo 'enabled'; ?>" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a class='pagination_buttons <?php if($pageno==1 || $pageno==$total_pages) echo'disabled'; else echo 'enabled'; ?>' href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
<?php
}
}
?>
