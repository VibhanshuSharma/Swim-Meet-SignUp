<?php 
include 'connectDB.php';

$meetId=$_GET["param1"];

$conn = connectToDB();
$sql = "select event_number, event_name,eligibile_sex, eligible_age, event_date ,min_eligible_time, session_type, additional_info from event where meet_id=$meetId";

$result = mysqli_query($conn,$sql);

$arr = array();
$count = 1;
while ($row=mysqli_fetch_row ($result)){
    
    if($count == $row[0]){
    $arr[] = array("event_number"=>$row[0],"event_name"=>$row[1],"eligibile_sex"=>$row[2],"eligible_age"=>$row[3],"event_date"=>$row[4],"min_eligible_time"=>$row[5],"session_type"=>$row[6],"additional_info"=>$row[7]);
    $count++;
    }else{
     
        while($count != $row[0]){
       
        $arr[] = array("event_number"=>$count,"event_name"=>'-',"eligibile_sex"=>'-',"eligible_age"=>'-',"event_date"=>'-',"min_eligible_time"=>'-',"session_type"=>'-',"additional_info"=>'-');
         $count++;
       }
        $arr[] = array("event_number"=>$row[0],"event_name"=>$row[1],"eligibile_sex"=>$row[2],"eligible_age"=>$row[3],"event_date"=>$row[4],"min_eligible_time"=>$row[5],"session_type"=>$row[6],"additional_info"=>$row[7]);
        $count++;
    }
    
}

echo json_encode($arr);

?>