
<?php
//Step1
function connectToDB(){
 $conn = mysqli_connect('localhost','root','mysql123','SwimMeetSignup') or die('Error connecting to MySQL server.');
 return $conn;
}
 
function fetchFromDB($conn, $query){
	 
mysqli_query($conn, $query) or die('Error querying database.');

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
return $row;
	
 }

function UpdateDB($conn, $query){
	
//echo "heyyy query: ". $query;	

if (mysqli_query($conn, $query)) {
   // echo "New record created successfully";
} else {
    echo "Error: <br>" . mysqli_error($conn);
}

	
}

function closeDBConnection($conn)
{
	
mysqli_close($conn);
}
?>
