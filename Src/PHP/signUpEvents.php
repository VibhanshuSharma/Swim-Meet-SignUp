<?php 
include 'connectDB.php';
$conn = connectToDB();

$loginId = $_GET["loginId"];
$signedupEventsNumber = $_GET["signedupEventsNumber"];
$signedupEventsName = $_GET["signedupEventsName"];
$meetIdentifier = $_GET["meetIdentifier"];
$individualCharge = $_GET["individualCharge"];
$eventCharges = $_GET["eventCharges"];

$eventsNumberArr = explode("and",$signedupEventsNumber);
$eventsNameArr = explode("and",$signedupEventsName);
$totalPayment = $individualCharge;
$parentSignedUpForMeet = false;
$mysql = "select count(*) from signUpRecords where login_id='".$loginId."' and meet_id='".$meetIdentifier."'";
$row = fetchFromDB($conn, $mysql);
if($row[0]>0){
	$parentSignedUpForMeet = true;
}
if($parentSignedUpForMeet){
	$sql = "delete from signUpRecords where login_id='".$loginId."' and meet_id='".$meetIdentifier."'";
	UpdateDB($conn, $sql);
}
for($i=0;$i<sizeof($eventsNumberArr);$i++){
	$sql = "insert into signUpRecords(login_id,meet_id,event_number,event_name)values('".$loginId."','".$meetIdentifier."','".$eventsNumberArr[$i]."','".$eventsNameArr[$i]."')";
	UpdateDB($conn, $sql);
	$totalPayment = $totalPayment + $eventCharges;
}
$sql = "select event_number, event_name from signUpRecords where meet_id='".$meetIdentifier."' and login_id='".$loginId."'";
$result= mysqli_query($conn, $sql);

$checked_out_items = array();
while ($row = mysqli_fetch_row ($result)){
	array_push($checked_out_items, 	array("event_number"=>$row[0],"event_name"=>$row[1],"event_charge"=>$eventCharges,"swimmer_charge"=>$individualCharge,"totalPayment"=>$totalPayment));
}
echo json_encode($checked_out_items);	
?>