<?php 
include 'connectDB.php';

$meetId=$_GET["param2"];

$conn = connectToDB();
$sql = "select meet_name, meet_date1, meet_date2, per_event_charge,signup_deadline, min_eligible_age, swimmer_charge, max_per_kid_signup, max_individual_event, max_relay_event from meet where meet_id=$meetId";

$result = mysqli_query($conn,$sql);

$arr = array();
while ($row=mysqli_fetch_row ($result)){
    $arr[] = array("meet_name"=>$row[0],"meet_date1"=>$row[1],"meet_date2"=>$row[2],"per_event_charge"=>$row[3],"signup_deadline"=>$row[4],"min_eligible_age"=>$row[5],"swimmer_charge"=>$row[6],"max_per_kid_signup"=>$row[7],"max_individual_event"=>$row[8],"max_relay_event"=>$row[9]);
    
}

echo json_encode($arr);

?>