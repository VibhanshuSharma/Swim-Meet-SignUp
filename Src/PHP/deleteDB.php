
<?php 


include 'connectDB.php';
unset($_POST['extractpdfbutton']);

  $meet_id = $_POST['id'];
   $conn = connectToDB();
      $sql = "update meet set meet_status='Inactive' where meet_id=".$meet_id;
      $update = UpdateDB($conn, $sql);
   
?>