<?php
session_start();
session_destroy();
header('location: SwimMeetSignup.php');
exit();
?>