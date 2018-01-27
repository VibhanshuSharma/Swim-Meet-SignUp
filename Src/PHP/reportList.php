<?php 
include 'connectDB.php';

$meetId=$_GET["param1"];

$conn = connectToDB();
$sql = "select signUpRecords.signup_id,signUpRecords.login_id,signUpRecords.event_number, signUpRecords.event_name,user.first_name,user.last_name from signUpRecords INNER JOIN user on user.login_id = signUpRecords.login_id where meet_id=$meetId";

$result = mysqli_query($conn,$sql);

$arr = array();
while ($row=mysqli_fetch_row ($result)){
    $arr[] = array("signup_id"=>$row[0],"login_id"=>$row[1],"event_number"=>$row[2],"event_name"=>$row[3],"first_name"=>$row[4],"last_name"=>$row[5]);
    
}

echo json_encode($arr);

?>