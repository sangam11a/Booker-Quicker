<?php
class DBConnect{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "drsathi";
    private $dsn="";
    function __construct(){
        $sql="Create Database if not exists $this->dbname";
        $this->dsn='mysql:host=' . $this->host;
        try {
            $pdo = new PDO($this->dsn, $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $stmt=$pdo->prepare($sql);
            if($stmt->execute()){
                // echo "<script>console.log('Database created');</script>";
                $this->create_table();
            }
            else{
                // echo "<script>console.log('Database creation failed');</script>";
            }
        }
        catch (PDOException $e) {
            echo "<script>alert('DB Connection failed.Please contact DB administrator');</script>";
        }
    }

    public function create_table(){
        // $sql="CREATE TABLE if not exists `users` (
        //     `id` int(11) NOT NULL,
        //     `username` varchar(255) NOT NULL,
        //     `email` varchar(255) NOT NULL,
        //     `mobile_no` varchar(100) NOT NULL,
        //     `gender` varchar(14) NOT NULL,
        //     `age` varchar(11) NOT NULL,
        //     `password` varchar(255) NOT NULL,
        //     `created_on` varchar(32) NOT NULL,
        //     `status` varchar(11) NOT NULL DEFAULT '0',
        //     `role` varchar(32) NOT NULL,
        //     `specialization` varchar(30) NOT NULL DEFAULT '0',
        //     `hash` varchar(100) NOT NULL,
        //     `viewed` varchar(14) NOT NULL DEFAULT '0',
        //     `patient_id` varchar(32) NOT NULL DEFAULT '0'
        //   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        //   $statement=$this->prepare_stmt($sql);
        //   $statement->execute();
            include_once "index.php";
            // $sql="INSERT INTO `users` 
            // (`username`, `email`, `mobile_no`, `gender`, `age`, `password`, `created_on`, `status`, `role`, `hash`, `viewed`, `patient_id`) VALUES
            // ( ".encrypt2('admin').",".encrypt2('admin@gmail.com').",".encrypt2('').",".encrypt2('Male').",".encrypt2('22').",".encrypt2('admin').",".encrypt2(time().'').",".encrypt2('1').",".encrypt2('admin').",".encrypt2('1').",".encrypt2('1').",".encrypt2('1')."
            // );";
            // echo $sql;
        //     $statement=$this->prepare_stmt($sql);
        //     $statement->execute();
        $sql="create table if not exists availability(
            id int not null unique auto_increment,
            doctor_name varchar(100) not null,
              available_day varchar(14) not null,
              start_time varchar(16) not null,
              stop_time varchar(16) not null,
              status INT NULL DEFAULT '0'
            );";
          
           
              $sql.="create table if not exists appointment(
                id int not null auto_increment unique,
                patient_id VARCHAR(30) NOT NULL,
                patient_name varchar(100) not null ,
                doctor_name varchar(100) not null,
                appointment_date varchar(15) not null,
                appointment_time varchar(10) not null,
                service VARCHAR(50) NOT NULL,
                status int(2) not null DEFAULT 0,
                patient_reason varchar(350) not null,
                doctor_reason varchar(350) not null
              );";
              $sql.="create table if not exists services( id int not null auto_increment unique, service_name varchar(100) not null primary key, price double not null, created_on varchar(24) not null );";
              $sql.="create table if not exists cancelled_appointment( 
                  id int not null auto_increment unique, patient_name varchar(100) not null , 
                  appointment_date varchar(15) not null, appointment_time varchar(10) not null, cancelled_on varchar(20) not null, reason varchar(200) not null DEFAULT 0 );";
              $sql.="create table if not exists average(
                id int not null auto_increment unique,
                doctor_name varchar(100) ,
                average float not null
              );";
              $sql.="ALTER TABLE `users` MODIFY `user-id` int(11) NOT NULL AUTO_INCREMENT unique;";
              $sql.="CREATE TABLE if not exists `patient_record` ( `id` INT NOT NULL unique auto_increment,  `patient_name` VARCHAR(100) NOT NULL ,  `address` TEXT NOT NULL ,  `DOB` VARCHAR(15) NOT NULL ,  `Appointment_date` VARCHAR(14) NOT NULL ,  `doctors_name` VARCHAR(100) NOT NULL ,  `time` VARCHAR(20) NOT NULL ,  `photo` TINYTEXT NOT NULL ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;";
              $statement=$this->prepare_stmt($sql);
              $statement->execute();
    }
    public function connection(){
        try{
            $this->dsn='mysql:host=' . $this->host.';dbname='.$this->dbname;           
            $pdo=new PDO($this->dsn,$this->user,$this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);  
            return $pdo;          
        }
        catch(PDOException $e){
            echo "<script>alert('Database connectivity failed .Call administrator.');</script>";
        }
    }

    public function remove_connection(){
        $this->dsn=null;
    }

    private function prepare_stmt($sql){
        $statement=$this->connection()->prepare($sql);
        return $statement;
    }
    
    public function insertion($table_name,$array1,$array2,$encrypt=0){
        // if($encrypt!=0){
        //     include_once "index.php";
        //     $array2=encrypt1($array2);
        // }
        $return_data=100;
            $sql="Insert into $table_name(";
            if(count($array1)==count($array2)){
               $i=0;
               while($i<count($array1)-1){
                $sql.="`".$array1[$i++]."`,";
                
               }
               $sql.="`".$array1[$i]."`) values(";
               $i=0;
               while($i<count($array1)-1){
                   $sql.="?,";
                   $i++;
               }
               $sql.="?);";
              ////echo $sql;
               $statement=$this->prepare_stmt($sql);
            //    //echo $sql;
            //   if($statement->execute($array2)){
            //     echo "<script>console.log('Insertion successfull')</script>";            
            //    $return_data=1;
            //    }
            //    else{
            //        echo "<script>console.log('Insertion failed')</script>";               
            //    $return_data=0;
            //    }
               try{
               if( $statement->execute($array2))
                $return_data=1;
               }
               catch(PDOException $e){
                   echo "Error occured: ";
                    // print_r($statement->errorInfo());
                //    echo "<br>";

               }
            }
       
        return $return_data;
    }

    public function select($table_name,$key=[],$value=[],$decrypt=0){
        
        $sql="Select * from $table_name ";
       
        if(count($key)==count($value)&&count($key)!=0){
            $sql.="where ";
            $i=0;
            while($i<count($key)-1){
                $sql.=" $key[$i]"."='".$value[$i]."' and ";
                $i++;
            }
            $sql.=$key[$i]."='".$value[$i]."' ";//order by id asc;
            // echo $sql;
        }
        try{
            $statement=$this->connection()->query($sql);
            $return=$statement->fetchAll();            
            // echo json_encode($return);
        }
        catch(PDOException $e){
            // //echo $sql;
            echo "Error occured Selection :";
            $return=["error_occured"];
        }
        // if($decrypt!=0){
        //     include_once "index.php";
        //     $arr2=array();
        //     foreach($return as $row2){
        //         $arr3=array(
        //             "id"=>$row2["id"],
        //             "username"=>decrypt2("".$row2["username"]),
        //             "email"=>decrypt2("".$row2["email"]),
        //             "mobile_no"=>decrypt2("".$row2["mobile_no"]),
        //             "gender"=>decrypt2("".$row2["gender"]),
        //             "age"=>decrypt2("".$row2["age"]),
        //             "password"=>decrypt2("".$row2["password"]),
        //             "created_on"=>decrypt2("".$row2["created_on"]),
        //             "status"=>$row2["status"],
        //             "role"=>decrypt2("".$row2["role"]),
        //             "specialization"=>decrypt2("".$row2["specialization"]),
        //             "hash"=>$row2["hash"],
        //             "viewed"=>$row2["viewed"],
        //             "patient_id"=>decrypt2("".$row2["patient_id"])
        //         );
        //         array_push($arr2,$arr3);
        //     }
        //     return $arr2;
        // }
        // else
        {
        return $return;
            }
    }
   public function deletion($table_name,$key,$value){
        $sql="Delete from $table_name ";
       $return_data=0;
        if(count($key)==count($value)&&count($key)!=0){
            $sql.="where ";
            $i=0;
            echo $value[$i];
            while($i<count($key)-1){
                $sql.=" $key[$i]"."='".$value[$i]."' and ";
                $i++;
            }
            $sql.="$key[$i]='$value[$i]'";
        }
        //echo $sql;
        $statement=$this->prepare_stmt($sql);
        try{
            $statement->execute();            
            $return_data=1;
        }
        catch(PDOException $e){
            echo "Error occured Deletion".$e;
            
        }
        return $return_data;
    }
    public function updation($table_name,$key,$value,$init_key,$init_value){
        $sql="Update `$table_name` ";
        $return_data=0;
        if(count($key)==count($value)&&count($key)!=0){
            $sql.="set ";$i=0;
            while($i<count($key)-1){
                $sql.=$key[$i]."='".$value[$i]."' , ";$i++;
            }
            $sql.=$key[$i]."='".$value[$i]."' where ";
            $i=0;
            while($i<count($init_key)-1){
                $sql.=$init_key[$i]."='".$init_value[$i]."' and ";$i++;
            }
            $sql.=$init_key[$i]."='".$init_value[$i]."';";
            try{
                $statement=$this->prepare_stmt($sql);
                
                // echo $sql;     
                $statement->execute();       
                $return_data=1;
            }
            catch(PDOException $e){
                echo "Error occured Updation :".$e;                
            }
            return $return_data;
        }
    }

    public function total_rows($table_name,$param="*",$condition=""){
        $sql="Select $param from $table_name $condition";
        // echo $sql;
        $statement=$this->connection()->query($sql);
        $result=$statement->fetchAll();
        if($param=="count(*)") {
            return $result[0]['count(*)'];
        }
        else return $result;
    }

    public function create_tbl($d_name,$days=0,$start_time=0,$duration=0){
        $d_name=space_removal($d_name);    
        $sql="Create table if not exists $d_name(
            id int not null auto_increment unique,
            days varchar(14) not null primary key,
            start_time varchar(14) not null default 0,
            duration varchar(14) not null default 0
        );";
        $days=str_replace("-","/",$days);
       if($days!=0&&$start_time!=0&&$duration!=0) 
        $sql.="Insert into $d_name (`days`,`start_time`,`duration`) values('$days','$start_time','$duration')";
        $return=0;
        ////echo $sql;
        try{$statement=$this->prepare_stmt($sql);
            $statement->execute();
            $return=1;
        }
        catch(PDOException $e){
            echo "Error while creating table user ";
        }
        return $return;
    }
    public function generic_func($sql){
        $statement=$this->prepare_stmt($sql);
        try{$statement->execute();return 1;}
        catch(PDOException $e){
            return 0;
        }
    }

    public function own_query($sql){
        $statement=$this->connection()->query($sql);
        $result=$statement->fetchAll();
         return $result;
    }
    

}
        // Testing each function
                    // $ram=new DBConnect();
                    // echo $ram->create_tbl("sangam thapa");
                    // $update=$ram->updation('users',['id'],['23'],['id'],['2']);
                    // echo "<br>".$update;
                    // $delete=$ram->deletion('users',['id'],['truncate table rooms']);
                    // echo $delete;
                    // $array1=['id','name','conn_id','available'];
                    // $array2=['2','sangam','3345','1'];
                    // $ins=$ram->insertion('users',$array1,$array2);
                    // echo $ins;
                    // $select=$ram->select('users',[],[]);
                    // if($select!=false){
                    //     print_r($select);
                    // }
                    // else{
                    //     echo "Np record found";
                    // }


function space_removal($doctor_name){
    $array=explode(" ",$doctor_name);
        $d_name="";
        foreach($array as $row){
            $d_name.="$row"."_";
        }
        return $d_name;
}

function remove_underscore($doctor_name){
    $array=explode("_",$doctor_name);
    $d_name="";
    foreach($array as $row){
        $d_name.="$row"." ";
    }
    return $d_name;
}
function hr2min($start,$dur,$avg){
$loop=(int)$dur/$avg;
$st=explode(":",$start);
$st1="";
for($i=0;$i,$loop;$i++){
        $st[1]+=$avg;
        if($avg>59){
            $st[1]=intval($st[1])-59;
            $st[0]=intval($st[0])+1;
        }
        //print_r($st1);
    }
    if($st[0]<=9) $st[0]=add_zeros($st[0]);
    if($st[1]<=9) $st[1]=add_zeros($st[1]);
    return implode(":",$st);
}
function time_calc($arr,$duration){
    $total=0;
    $total=intval($arr[0])*60+intval($arr[1]);
    $total+=intval($duration);
    // echo $total;
    $hr1=$total/60;
    $hr2=intval($hr1);
    if($hr2<=9){
        $hr2=add_zeros($hr2);    }
    $total=round(($hr1-$hr2)*60);
    if($total<=9){
        $total=add_zeros($total);
    }
    $array=[$hr2,$total];
    return $array;
}

function add_zeros($num){
return "0$num";
}
// $r=time_calc(["2","12"],"20");
// print_r($r);

function generate_id($id){
        $loop=strlen($id);
        $str="DRS000000";
        $count_str=strlen($str);
        $j=0;
        while($j!=strlen($id)){
            $str[$count_str-$loop]=$id[$j];
            $j++;
            $loop--;
        }
        return $str;
}
function generate_bill($id){
    $loop=strlen($id);
    $str="IN00000";
    $count_str=strlen($str);
    $j=0;
    while($j!=strlen($id)){
        $str[$count_str-$loop]=$id[$j];
        $j++;
        $loop--;
    }
    return $str;
}
?>
