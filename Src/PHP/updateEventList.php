<?php 
include 'connectDB.php';

$meetId=$_GET["meetId"];
$name=$_GET["name"];
$sex=$_GET["sex"];
$Age=$_GET["Age"];
$eventDate=$_GET["date"];        
$minEligibleTime=$_GET["elgTime"];                          
$addInfo=$_GET["additionalInfo"];                         
$sessionType=$_GET["session"];        
$eventId=$_GET["id"];   
                          

$conn = connectToDB();
$sql = "Update event SET event_name='".$name."', eligibile_sex='".$sex."', eligible_age='".$Age."', event_date='".$eventDate."',min_eligible_time='".$minEligibleTime."', session_type='".$sessionType."', additional_info='".$addInfo."' where event_number=$eventId AND meet_id=$meetId";

$res = mysqli_query($conn,$sql);

if($res){
    echo 'Updated Successfully...';
}else{
    echo 'Failed to Update';
}

?>