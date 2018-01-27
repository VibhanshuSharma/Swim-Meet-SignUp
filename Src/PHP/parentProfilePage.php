<?php
include 'connectDB.php';
 session_start();
    if(!isset($_SESSION['login_user']))
    header("location:SwimMeetSignup.php");
if(isset($_SESSION['login_user']) && $_SESSION['user_role'] == 'Coach')
    header("location: HeadCoach.php");

// if(isset($_SESSION['login_user']) && $_SESSION['user_role'] == 'Parent')
//     header("location: ParentLandingPage.php");




$conn = connectToDB();
// $meetIdentifier=$_GET['a']; echo "<script>console.log('hey'+$login);</script>";
$loginId=$_GET['a'];

$sql = "select meet_id, event_number, event_name from signUpRecords where login_id='".$loginId."'";
$sql1 = "select first_name, last_name, gender, DOB from user where login_id='".$loginId."'";
$sql2 = "select meet_id, meet_status, meet_name from meet";
$result= mysqli_query($conn, $sql);
$result1= mysqli_query($conn, $sql1);
$result2= mysqli_query($conn, $sql2);
$meetArr = [];
while($rowS=mysqli_fetch_row ($result2)){ 
  array_push($meetArr, array($rowS[0],$rowS[1],$rowS[2]));
}
?>
<!DOCTYPE html>
  <html lang="en" ng-app="swimMeet" ng-init="meetId=('<?php echo $_SESSION['meetid']; ?>'); meetName=('<?php echo $_SESSION['name'] ?>'); signedUpDate=('<?php echo $_SESSION['deadline'] ?>')">
  <head>
    <title>COACH REPORT</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="usc.jpg" type="image/jpg">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      
      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://cdn.jsdelivr.net/jquery.typeit/4.4.0/typeit.min.js">
      </script>
      <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js"></script>
      <script src="../js/dirPagination.js"></script>
      <link href="../css/HCViewEventsCSS.css" rel="stylesheet">

    <style>
      #eventstable1{
        background-color: #fff;
        width: 30%;
        margin-left: 15%;
        margin-top: 2%;
        height: 200px;
        float: left;
        border: 2px solid #003973;
      }
      .pic{
        float: left;
        margin-left: 4%;
        width: 36%;
        /*border: 1px solid #003973;*/
      }
      .tabpic{
        width: 100%;
        height: 200px;
      }
      .pic img{
        height: 248px;
        width: 100%;
        margin-top: 6%;
      }
      #eventstable2{
        background-color: #fff;
        width: 70%;
        margin-left: 15%;
        margin-bottom: 2%;
        margin-top: 1%;
        overflow-x: auto;
        border: 2px solid #003973;
      }
      .profHead, .meetHead{
        margin-left: 15%;
        margin-top: 3%;
        font-size: 20px;
        color: #003973;
        font-weight: bold;
      }
      .brandimg{
        float: left;
        width: 34%;
      }
      .brandimg img{
        width: 100%;
        height: 50px;
      }
      @media only screen and (max-width: 768px){
        .pic{
          display: none;
        }
        #eventstable1, #eventstable2{
          width: 90%;
          margin-left: 5%;
        }
        .profHead, .meetHead{
          margin-left: 5%;
        }

        .brandimg{
          width: 17%;
        }
       } 
    </style>

</head>
<body ng-app="app">
  <!-- <div class="header">
        <div class="brandname">
          <a href="">Arcadia Riptides</a>
        </div>
        <ul id="navbar">
          <li><a href="HeadCoach.php">Meets</a></li>
          <li><a href="https://www.arcadiaswimclub.org/about-1/" target="_blank">About</a></li>
          <li><a href="https://www.arcadiaswimclub.org/contact/" target="_blank">Contact</a></li>
          <li><a onclick="location.href = 'logout.php';" href="">Logout</a></li>
        </ul>
    </div> --> 
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <div class="brandimg">
            <img src="../images/hawk1.png">
          </div>
          <span class="navbar-brand" id= "navbrn" href="#">ARCADIA RIPTIDES</span>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="ParentLandingPage.php">Events</a></li>
            <li><a href="https://www.arcadiaswimclub.org/about-1/" target="_blank">About</a></li>
            <li><a href="https://www.arcadiaswimclub.org/contact/" target="_blank">Contact</a></li>
            <li><a onclick="location.href = 'logout.php';" href="#"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>



      <div class="headreplace"></div>
      <div class="pageheading">
        <div class="headd"><span>PROFILE</span></div>
      </div>
<div ng-controller="mainController as main" class="content_div"  ng-controller="myData">
  
  <section class="profile">
    <div class="profHead">Personal Info</div>
    <div class="tabpic">
     <div id="eventstable1">
        <div class="table-responsive table-striped">          
            <table class="table">
      <?php
      while($row1=mysqli_fetch_row ($result1)){ 
      ?>
        <tr>
          <th>Name</th>
          <td><?php echo $row1[0].' '.$row1[1]; ?></td>
        </tr>
        <tr>
          <th>Sex</th>
          <td><?php echo $row1[2]; ?></td>
        </tr>
        <tr>
          <th>DOB</th>
          <td><?php echo $row1[3]; ?></td>
        </tr>
      </table>
      </div>
      </div>
      <?php 
      }
      ?>

      <div class="pic">
        <img src="../images/a.jpeg">
      </div>
      </div>

    </div>
   <br><br>
   <div class="meetHead">Signed Up Meets Info</div>
      <div id="eventstable2">
        <div class="table-responsive table-striped">          
            <table class="table">
        <thead>
          <tr>
            <th>Meet Name </th>
            <th>Event Number</th>
            <th>Event Name</th>
          </tr> 
        </thead>
        <?php
        while($row=mysqli_fetch_row ($result)){ 
          foreach ($meetArr as $value) {  
            if($row[0] == $value[0] && $value[1]=='Active'){
        ?>
          <tr>    
          <td><?php echo $value[2]; ?></td>
          <td><?php echo $row[1]; ?></td>
          <td><?php echo $row[2]; ?></td>
        </tr>
    
        <?php 
            }
          }
        }
        ?>
    </table>
    </div> 
    </div> 
    
  </section>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
</body>
</html>
