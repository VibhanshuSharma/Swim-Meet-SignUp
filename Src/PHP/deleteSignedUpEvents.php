<?php 

include 'connectDB.php';

    $signup_id = $_GET["signId"];
    $conn = connectToDB();
    $sql = "DELETE FROM signUpRecords where signup_id=".$signup_id;
    $res = mysqli_query($conn,$sql);

    if($res){
        echo 1;
    }else{
        echo 2;
    }
   
?>