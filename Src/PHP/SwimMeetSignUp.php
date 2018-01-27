<!DOCTYPE html>
<?php 
   include 'connectDB.php'; 
   session_start();
   $_SESSION['error_message'] = "";
   if(isset($_SESSION['login_user']))
   {
    header("location: SwimMeetSignup.php");
    if($_SESSION['user_role'] == 'Coach')
      header("location:HeadCoach.php");
    if($_SESSION['user_role'] == 'Parent')
      header("location:ParentLandingPage.php");
   
   }
   
   if(isset($_POST['submit'])){
    $loginId = $_POST['loginId']; 
    $loginPswd = $_POST['loginPswd'];
    $userRole = $_POST['user'];
    
    $conn = connectToDB();
    $query = "select count(*) from user where login_id = '".$loginId."' and login_pswd = '".$loginPswd."' and user_role = '".$userRole."'";
    $row = fetchFromDB($conn, $query);
    if($row[0]==1 && $userRole == "Coach")
    { 
      $_SESSION['login_user'] = $loginId;
      $_SESSION['user_role'] = 'Coach';
      header("location:HeadCoach.php");
    }
    
    if($row[0]==1 && $userRole == "Parent")
    {
    $_SESSION['login_user'] = $loginId;
      $query = "select DOB,login_id, gender from user where login_id = '".$loginId."' and user_role = '".$userRole."'";
      
      $row = fetchFromDB($conn, $query);
      $_SESSION['dob'] = $row[0];
      $_SESSION['loginId'] = $row[1];
      $_SESSION['sex'] = $row[2];
      $_SESSION['user_role'] = 'Parent';
      header("location:ParentLandingPage.php");
      
    }
    if($row[0] != 1)
    {
       $_SESSION['errMsg'] = "Invalid username or password. <br>Please try again.";
    }
   }
   
   ?>
<html lang="en">
   <head>
      <title> Swim Meet Signup </title>
  <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="usc.jpg" type="image/jpg">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <link href="../css/style3.css" rel="stylesheet"> 
      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="../js/dirPagination.js"></script>
      <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js"></script>
      <script src="https://cdn.jsdelivr.net/jquery.typeit/4.4.0/typeit.min.js"></script>
      <link rel="stylesheet" type="text/css" href="../css/homepage.css">
      <style>
         body {margin:0;}
         .topnav {
         overflow: hidden;
         background-color: none;
         float:right;
         }
         .topnav a {
         float: left;
         display: block;
         color: #f2f2f2;
         text-align: center;
         padding: 14px 16px;
         text-decoration: none;
         font-size: 17px;
         }
         .topnav a:hover {
         background-color: none;
         color: #f6734a;
         }
         .topnav .icon {
         display: none;
         }
         @media screen and (max-width: 600px) {
         .topnav a:not(:first-child) {display: none;}
         .topnav a.icon {
         float: right;
         display: block;
         }
         }
         @media screen and (max-width: 600px) {
         .topnav.responsive {position: relative;}
         .topnav.responsive .icon {
         position: absolute;
         right: 0;
         top: 0;
         }
         .topnav.responsive a {
         float: none;
         display: block;
         text-align: left;
         }
         }
      </style>
   </head>
   <body  style="margin:0;">
      <div id="mainDiv">
         <div class="background-image"></div>
         <div class="content">
            
              <!--
              <div class="topnav" id="myTopnav">
                <a href="#">Home</a>
               <a href="https://www.arcadiaswimclub.org/contact/" target="_blank">Contact</a>
               <a href="https://www.arcadiaswimclub.org/about-1/" target="_blank">About</a>
               <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a> 
                </div>-->
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
          <span class="navbar-brand" id= "navbrn">ARCADIA RIPTIDES</span>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
            <!-- <li><a href="HeadCoach.php">Meets</a></li> -->
            <li><a href="https://www.arcadiaswimclub.org/about-1/" target="_blank">About</a></li>
            <li><a href="https://www.arcadiaswimclub.org/contact/" target="_blank">Contact</a></li>
            <!-- <li><a onclick="location.href = 'logout.php';" href=""><span class="glyphicon glyphicon-log-in"></span> Logout</a></li> -->
          </ul>
          </div>
          </div>
        </nav>

            
        

            <!-- <ul class="tabs">
               <li id="associationName">ARCADIA RIPTIDES<br>
               <li style="margin-left:11%;margin-top:6.5%;letter-spacing:3px;opacity:0.8;position:absolute;color:#f6734a;margin-top: 8%;">SWIMMING CLUB</li>
               <li><a href="#" class="tab_selected" style="font-size: 115%;">Home</a></li>
               <li><a href="https://www.arcadiaswimclub.org/contact/" target="_blank" style="font-size: 115%;">Contact</a></li>
               <li><a href="https://www.arcadiaswimclub.org/about-1/" target="_blank" style="font-size: 115%;">About</a></li>
               
               </ul> -->
            <div id="coach" style="background: rgba(255,238,229,0.62);">
               <div style="background-color:#f6734a;width:100%;height:12%;">
               </div>
               <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
                  <div id="errMsg">
                     <?php if(!empty($_SESSION['errMsg'])) { echo $_SESSION['errMsg']; } else {echo " ";} ?>
                  </div>
                  <?php unset($_SESSION['errMsg']); ?>
                  <ul style="margin-top:8%;">
                     <input type="radio" name="user" value="Parent" checked style="color:#f4511e; background-color:#f4511e; margin-right:1%;">
                     <label style="margin-right:2%;">PARENT</label>
                     <input type="radio" name="user" value="Coach" style="margin-right:1%;margin-left:3%;"> 
                     <label style="margin-right:2%;">COACH</label>
                  </ul>
                  <input type="text" class="form-control" id="coachusr" name="loginId" placeholder='&#xF003;  Login Id' style="width:65%;height:45px;margin-top:6%;margin-left:15%;border-radius:15px; font-family:Arial, FontAwesome" required="" oninvalid="this.setCustomValidity('Please enter Login Id')" oninput="setCustomValidity('')">
                  <input type="password" class="form-control" id="coachpwd" name="loginPswd" placeholder="&#xF023;  Password" style= "width:65%;height:45px;margin-top:5%;margin-left:15%;border-radius:15px; font-family:Arial, FontAwesome" required="" oninvalid="this.setCustomValidity('Please enter Password')" oninput="setCustomValidity('')">
                  <br>
                  <button type="submit" name="submit" class="btn btn-primary" id="coachlogin" style="width:35%;height:40px;opacity:1.5;">Login</button>
               </form>
            </div>
         </div>
      </div>
      <script>
         var errorlength = document.getElementById("errMsg").innerHTML.trim().length;
         if(errorlength != 0)
         {
          document.getElementById("coachusr").style.borderColor = "red";
          document.getElementById("coachpwd").style.borderColor = "red";
          var x;
          x = setTimeout(showPage, 0);
         
         }
          
         
            $( "#coachusr" ).click(function() {
          document.getElementById("errMsg").innerHTML = " ";
          document.getElementById("coachusr").style.borderColor = "";
          document.getElementById("coachpwd").style.borderColor = "";
         
         });  
         
            $( "#coachpwd" ).click(function() {
          document.getElementById("errMsg").innerHTML = " ";
          document.getElementById("coachpwd").style.borderColor = "";
          document.getElementById("coachusr").style.borderColor = "";
         });  
          
         
         
      </script>  
      <script>
         function myFunction() {
             var x = document.getElementById("myTopnav");
             if (x.className === "topnav") {
                 x.className += " responsive";
             } else {
                 x.className = "topnav";
             }
         }
      </script>
       <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   </body>
</html>