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
$sql = "Insert into event values ($eventId, $meetId, '".$name."', '".$sex."', '".$Age."', '".$eventDate."', '".$minEligibleTime."', '".$sessionType."', '".$addInfo."')";

$res = mysqli_query($conn,$sql);

if($res){
    echo 1;   //Success
}else{
    echo 2;    //Failure
    
}

?>