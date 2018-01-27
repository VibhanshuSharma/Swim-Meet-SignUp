<?php 
		session_start();
        if(!isset($_SESSION['login_user'])) 
    header("location: SwimMeetSignup.php");
 if(isset($_SESSION['login_user']) && $_SESSION['user_role'] == 'Parent')
    header("location: ParentLandingPage.php");
		if(isset($_POST['meet_id'])){
		    $_SESSION['meetid'] = $_POST['meet_id'];
		    $_SESSION['name'] = $_POST['meet_name'];
		    $_SESSION['deadline'] = $_POST['signup_deadline'];
		    header('Location:HCreport.php');
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
      <link href="../css/style3.css" rel="stylesheet"> 
      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://cdn.jsdelivr.net/jquery.typeit/4.4.0/typeit.min.js">
      </script>
      <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.10.0.js"></script>
      <script src="../js/dirPagination.js"></script>
	  <link href="../css/HCViewEventsCSS.css" rel="stylesheet">
      
      <style type="text/css">

      </style>
  </head>
  <body>
     
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
            <li><a href="HeadCoach.php">Meets</a></li>
            <li><a href="https://www.arcadiaswimclub.org/about-1/" target="_blank">About</a></li>
            <li><a href="https://www.arcadiaswimclub.org/contact/" target="_blank">Contact</a></li>
            <li><a onclick="location.href = 'logout.php';" href=""><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
       
      <div class="headreplace"></div>
      <div class="pageheading">
        <div class="headd"><span>REPORT</span></div>
      </div>
      <div class="meetinfo">
        <div class="meetname"><?php echo $_SESSION['name'] ?></div>
        <div class="meetactions">
            <a href="createPDF.php?meetid=<?php echo $_SESSION['meetid']; ?>&deadline=<?php echo $_SESSION['deadline']; ?>&meetname=<?php $name=$_SESSION['name'];$name=str_replace("&", "%26", $name); echo $name; ?>" target="_blank"><button>Generate Report</button></a>
        </div>
      </div>
       <div class="pagup">
        <ul class="pagination">
              <dir-pagination-controls direction-links="true" boundary-links="true"></dir-pagination-controls>
        </ul>
      </div> 
      <div class="eventlistheader">
          <span>SIGNED UP EVENT LIST</span>          
        </div>
      <div id="eventstable"  ng-controller="myData">
        <div class="table-responsive table-striped">          
            <table class="table">
              <thead>
                <tr>
                  <th>Login Id</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Event Number</th>
                  <th>Event Name</th>
                  <th>Action</th>    
                </tr>
              </thead>
              <tbody>
                <tr  dir-paginate="z in reports|itemsPerPage:2">
                    <td class="text-center">{{z.login_id}}</td>
				        <td class="text-center">{{z.first_name}}</td>
                        <td class="text-center">{{z.last_name}}</td>
                        <td class="text-center">{{z.event_number}}</td>
                        <td class="text-center">{{z.event_name}}</td>
                        <td><button type="button" class="btn btn-primary" ng-click='confirmDelete(z)'><i class="fa fa-trash-o" aria-hidden="true" style="color:black;"></i></button></td>
                </tr>
              <tr ng-if="(!reports || reports.length === 0)">
		              <td></td><td></td><td></td><td>No Signed Up Events</td><td></td><td></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      <div class="pagdown">
          <ul class="pagination">
                <dir-pagination-controls direction-links="true" boundary-links="true"></dir-pagination-controls>
          </ul>
      </div> 

      		<script>
		          
				var app = angular.module("swimMeet", ['ui.bootstrap','angularUtils.directives.dirPagination']);
				  
				  app.controller("myData", function($modal, $scope, $http) {
				      
				      $http({
				          method: 'post',
				          url: 'reportList.php',
				          params: {
				            "param1": $scope.meetId
				          }
				        }).then(function(response) {
				             
				          $scope.reports = response.data;
				          console.log($scope.reports);
				        });
		              
		              $scope.confirmDelete = function(obj){
		                
		                  console.log(obj.signup_id);
		                  $scope.signupId = obj.signup_id;
		                  $scope.confirm = confirm('Are you Sure you want to Delete ?');
		                  
		                  if($scope.confirm == true){
		                      
		                      $http({
				                  method: 'post',
				                  url: 'deleteSignedUpEvents.php',
		                          params:{
		                           "signId": obj.signup_id
		                       }
				              }).then(function(response) {
		                           $scope.check = $.trim(response.data).toString();
		                           console.log($scope.check);
				                  window.location.reload(); 
				              });
		                  }
		              };
		        });
				</script> 
      
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
  </body>
  </html>  