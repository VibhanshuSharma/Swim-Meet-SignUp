<?php 
include 'connectDB.php';

$meetId=$_GET["meetId"];
$deadline=$_GET["deadline"];
$pay=$_GET["pay"];
$date1=$_GET["date1"];
$Age=$_GET["Age"];
$date2=$_GET["date2"];        
$charge=$_GET["charge"];                          
$noOfKids=$_GET["noOfKids"];                         
$MaxInd=$_GET["MaxInd"];        
$Relay=$_GET["Relay"];
  
                          

$conn = connectToDB();
$sql = "Update meet SET per_event_charge='".$pay."', signup_deadline='".$deadline."',meet_date1='".$date1."', meet_date2='".$date2."',min_eligible_age='".$Age."', swimmer_charge='".$charge."',max_per_kid_signup='".$noOfKids."', max_individual_event='".$MaxInd."',max_relay_event='".$Relay."'  where meet_id=$meetId";

$res = mysqli_query($conn,$sql);

if($res){
    echo 1;   //Success
}else{
    echo 2;    //Failure
}
?>