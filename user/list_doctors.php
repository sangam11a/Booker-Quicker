<link rel="stylesheet" href="../css/table.css">
<?php
include_once "../classes/config.php";
include_once "../admin/dashboard.php";
$conn=new DBConnect();
$total_rows="10";
$caption="List Doctors";
$title=["S.N","Doctor Name","Specialization"];
$values=["id","username","specialization"];
if (isset($_GET['pageno'])) {
                    $pageno = $_GET['pageno'];
                    } 
                    else {
                    $pageno = 1;
                    }         
        $no_of_records_per_page = 10;       
        $offset = ($pageno-1) * $no_of_records_per_page;
        $total_pages = ceil($total_rows / $no_of_records_per_page);
        $table_name="users";
        $sql="Select * from $table_name where role='doctor'";
        $result=$conn->own_query($sql."order by id LIMIT $offset,$no_of_records_per_page");
        // $result=$conn->total_rows($table_name,"*"," order by id LIMIT $offset, $no_of_records_per_page ");
        if($total_rows==0){
            print("<p style='color:red;font-size:19px;'>No data available</p>");
        }
        else{
            // echo "<input type='text' value='$values'>";
        echo " <caption><h3>$caption</h3></caption>
        <table class='table'><tr>
        ";
        for($i=0;$i<count($title);$i++){
            echo "<td>";
                echo "$title[$i]";
            echo "</td>";      
        }
        echo "</tr>";$pp=1;
                foreach($result as $row){
                    echo "<tr>";
                    for($j=0;$j<count($values);$j++){                   
                        if($title[$j]=='S.N') {echo "<td>".intval($offset)+$pp."</td>";$pp++;}                        
                       else if($title[$j]=='Created On') echo "<td>".date("Y/m/d H:i:s",$row[$values[$j]])."</td>";
                       else echo "<td>".$row[$values[$j]]."</td>";
                    }
                    if(count($title)!=count($values)){
                        echo "<td><button onclick='option_click(\"edit\",\"".implode('^',$row)."\")'>Edit</button>
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
?>