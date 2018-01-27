<?php 
		session_start();
		if(!isset($_SESSION['login_user']))
		  header("location:SwimMeetSignup.php");

		if(isset($_SESSION['login_user']) && $_SESSION['user_role'] == 'Parent')
    header("location: ParentLandingPage.php");

		if(isset($_POST['meet_id'])){
		    $_SESSION['meetid'] = $_POST['meet_id'];
		    $_SESSION['name'] = $_POST['meet_name'];
		    $_SESSION['deadline'] = $_POST['signup_deadline'];
		    header('Location:HCViewEvents.php');
		}
?>
<!DOCTYPE html>
  <html lang="en" ng-app="swimMeet" ng-init="meetId=('<?php echo $_SESSION['meetid']; ?>'); meetName=('<?php echo $_SESSION['name'] ?>'); signedUpDate=('<?php echo $_SESSION['deadline'] ?>')">
  <head>
    <title>COACH EVENTS</title>
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
      <link href="../css/HCViewEventsCSS.css" rel="stylesheet"> 
			
      

      <!-- <style type="text/css">

      </style> -->
  </head>
  <body ng-controller="myData">
     
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
      </div>  -->
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
        <div class="headd"><span>EVENTS</span></div>
      </div>
      <div class="meetinfo">
        <div class="meetname"><?php echo $_SESSION['name'] ?></div>
        <div class="meetactions">
          <button ng-click="viewMeetInfo()">Meet Information</button>
          <button ng-click="addEvent()">Add Event</button>
        </div>
      </div>
      <div class="pagup">
        <ul class="pagination" id="pagin">
          <dir-pagination-controls direction-links="true" boundary-links="true"></dir-pagination-controls>
        </ul>
      </div>
      <div class="eventlistheader">
          <span>EVENT LIST</span>          
        </div>
      <div id="eventstable">
        <div class="table-responsive table-striped table-condensed">          
            <table class="table">
              <thead>
                <tr>
                  <th>Event Number</th>
                  <th>Event Name</th>
                  <th>Eligible Sex</th>
                  <th>Eligible Age</th>
                  <th>Event Date</th>
                  <th>Min Eligible Time</th>
                  <th>Session</th>
                  <th>Additional Info</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr dir-paginate="z in events|itemsPerPage:20" class="event_name-{{ z.event_name }}">
                <td>{{z.event_number}}</td>
                <td>{{z.event_name}}</td>
				<td>{{z.eligibile_sex}}</td>
				<td>{{z.eligible_age}}</td>
                <td>{{z.event_date}}</td>
				<td>{{z.min_eligible_time}}</td>
				<td>{{z.session_type}}</td>
				<td>{{z.additional_info}}</td>
                  <td><button class="btn btn-primary" ng-click="open(z)">Edit</button></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="pagdown">
          <ul class="pagination" id="pagin2">
            <dir-pagination-controls direction-links="true" boundary-links="true"></dir-pagination-controls>
          </ul>
      </div>

      
        <script id="myModalContent.html" type="text/ng-template">
				      <div class="modal-header">
				          <h3 class="modal-title">Edit Event Details</h3>
				      </div>
				     
				      
				       <form id = "addFriendForm">
	               <br>
				        <label id="lab">Event Number:&nbsp;&nbsp;</label><input id="inp" ng-model = "event.event_number" class="form-control" type = "text" readonly/>
				        <label id="lab">Event Name:&nbsp;&nbsp;</label><input id="inp" ng-model = "event.event_name" class="form-control" type = "text" />
				        <label id="lab">Eligible Sex:&nbsp;&nbsp;</label>
	                
	                <select id="inp" class="form-control" id="sel" ng-model="event.eligibile_sex" >
	                    <option ng-selected="event.eligibile_sex == Men" >Men</option>
	                    <option ng-selected="event.eligibile_sex == Mixed" >Mixed</option>
	                    <option ng-selected="event.eligibile_sex == Women">Women</option>
	                </select>
                    
				        <label id="lab">Eligible Age:&nbsp;&nbsp;</label><input id="inp" ng-model = "event.eligible_age" class="form-control" type = "text" />
				        <label id="lab">Event Date:&nbsp;&nbsp;</label>
                        
                        <input id="inp" ui-date="{ dateFormat: 'yyyy-mm-dd' }" ng-model = "event.event_date" class="form-control" type = "date" value="{{event.event_date}}" min="{{event.event_date | date: 'yyyy-MM-dd'}}"/>
				        
                        <label id="lab">Min Eligible Time:&nbsp;&nbsp;</label><input id="inp" ng-model = "event.min_eligible_time" class="form-control" type = "text" />
				        <label id="lab">Session:&nbsp;&nbsp;</label>
	                
	                <select id="inp" class="form-control" id="sel" ng-model="event.session_type" >
	                    <option ng-model="Morning" ng-selected="event.session_type == Morning" >Morning</option>
	                    <option ng-selected="event.session_type == Afternoon" value="Afternoon">Afternoon</option>
	                </select>
	                
	                
			        <label id="lab">Additional Info:&nbsp;&nbsp;</label><input id="inp" ng-model = "event.additional_info" class="form-control" type = "text" />
			        <br>
							      </form>
				      
				      <div class="modal-footer">
				          <button class="btn btn-primary" ng-click="ok(event)">OK</button>
				          <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
				      </div>
				</script> 
		    
		        <script id="myNewModalContent.html" type="text/ng-template">
				<div class="modal-header">
			          <h3 class="modal-title">Add New Event</h3>
			      </div>
			     
			      
			       <form id = "addFriendForm">
			        <label id="lab">Event Number* :&nbsp;&nbsp;</label><input id="inp" ng-model = "event_number" class="form-control" type = "text" />
	                <div id="err" ng-show="myValue">Please Enter a unique Event Number</div>
                    <div id="err" ng-show="EId">Please Enter a value in the field.</div>
	                <label id="lab">Event Name* :&nbsp;&nbsp;</label><input id="inp" ng-model = "event_name" class="form-control" type = "text" />
	                <div id="err" ng-show="EName">Please Enter a value in the field.</div>
			        <label id="lab">Eligible Sex* :&nbsp;&nbsp;</label>
	                
	                <select id="inp" class="form-control" id="sel" ng-model="eligibile_sex" >
	                    <option ng-model="Men" ng-selected="eligibile_sex == Men" >Men</option>
	                    <option ng-selected="eligibile_sex == Mixed" value="Mixed">Mixed</option>
	                    <option ng-selected="eligibile_sex == Women">Women</option>
	                </select>
	                <div id="err" ng-show="ESex">Please Enter a value in the field.</div>
			        <label id="lab">Eligible Age* :&nbsp;&nbsp;</label><input id="inp" ng-model = "eligible_age" class="form-control" type = "text" />
                    <div id="err" ng-show="EAge">Please Enter a value in the field.</div>
			        <label id="lab">Event Date* :&nbsp;&nbsp;</label>
                    
                    <input id="inp" ng-model = "event_date" class="form-control" type="date" min="{{minDate | date: 'yyyy-MM-dd'}}" />
                    
                    <div id="err" ng-show="EDate">Please Enter a value in the field.</div>
			        <label id="lab">Min Eligible Time:&nbsp;&nbsp;</label><input id="inp" ng-model = "min_eligible_time" class="form-control" type = "text" />
                    <label id="lab">Session* :&nbsp;&nbsp;</label>
	                <select id="inp" class="form-control" id="sel" ng-model="session_type" >
	                    <option ng-model="Morning" ng-selected="session_type == Morning" >Morning</option>
	                    <option ng-selected="session_type == Afternoon" value="Afternoon">Afternoon</option>
	                </select>
	                <div id="err" ng-show="ESession">Please Enter a value in the field.</div>
	                <label id="lab">Additional Info:&nbsp;&nbsp;</label><input id="inp" ng-model = "additional_info" class="form-control" type = "text" />
			        
			      </form>
			      
			      <div class="modal-footer">
			          <button class="btn btn-primary" ng-click="ok(event_number,event_name,eligibile_sex,eligible_age,event_date,min_eligible_time,session_type,additional_info)">OK</button>
			          <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
			      </div>
				</script> 
		        
	<script id="mySecondModalContent.html" type="text/ng-template">
			      <div class="modal-header">
			          <h3 class="modal-title">Meet Information</h3>
			      </div>
			     
			      
			       <form id = "addFriendForm">
                   <br>
			        <label id="lab">Meet Name:&nbsp;&nbsp;</label><input inp="inp" ng-model = "meet.meet_name" class="form-control" readonly/>
	                <div id="err" ng-show="myValue">Please Enter a unique Event Number or Please fill all the details</div>
	                <label id="lab">Meet Date 1:&nbsp;&nbsp;</label><input id="inp" ng-model = "meet.meet_date1" class="form-control" type = "text" />
	                <label id="lab">Meet Date 2:&nbsp;&nbsp;</label><input id="inp" ng-model = "meet.meet_date2" class="form-control" type = "text" />
			        <label id="lab">Per Event Charge:&nbsp;&nbsp;</label><input id="inp" ng-model = "meet.per_event_charge" class="form-control" type = "text" />
                    
			        <label id="lab">Sign Up Deadline:&nbsp;&nbsp;</label>
                    
                    <input ui-date="{ dateFormat: 'yyyy-mm-dd' }" id="inp" ng-model = "meet.signup_deadline" class="form-control" type = "date" value="{{meet.signup_deadline}}" min="{{meet.signup_deadline | date: 'yyyy-MM-dd'}}" />
	                
                    <label id="lab">Min Eligible Age:&nbsp;&nbsp;</label><input id="inp" ng-model = "meet.min_eligible_age" class="form-control" type = "text" />
	                <label id="lab">Swimmer Charge:&nbsp;&nbsp;</label><input id="inp" ng-model = "meet.swimmer_charge" class="form-control" type = "text" />
	                <label id="lab">Max Per Kid Signup:&nbsp;&nbsp;</label><input id="inp" ng-model = "meet.max_per_kid_signup" class="form-control" type = "text" />
	                <label id="lab">Max Individual Event:&nbsp;&nbsp;</label><input id="inp" ng-model = "meet.max_individual_event" class="form-control" type = "text" />
	                <label id="lab">Max Relay Event:&nbsp;&nbsp;</label><input id="inp" ng-model = "meet.max_relay_event" class="form-control" type = "text" />
			       
			      </form>
			      
			      <div class="modal-footer">
			          <button class="btn btn-primary" ng-click="ok(meet)">OK</button>
			          <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
			      </div>
			</script>      
      
      
      		<script>
				  var app = angular.module("swimMeet", ['ui.bootstrap','angularUtils.directives.dirPagination']);
				  
				  
            app.controller("myData", function($modal, $scope, $http) {
				      
                $http({
				          method: 'post',
				          url: 'eventList.php',
				          params: {
				            "param1": $scope.meetId
				          }
				        }).then(function(response) {
				             
				          $scope.events = response.data;
				        console.log($scope.events);
				        });
	           $http({
			          method: 'post',
			          url: 'meetInfo.php',
			          params: {
			            "param2": $scope.meetId
			          }
			        }).then(function(response) {
			             
			          $scope.meets = response.data;
				    });
                      
                      
                      
		              $scope.addEvent = function(){
		             
		                  var modalinstance = $modal.open({
				              templateUrl: 'myNewModalContent.html',
				              controller: 'ModalInstance',
				          });
				      };
		                         
		             $scope.open = function(obj) {
				  
				          var modalinstance = $modal.open({
				              templateUrl: 'myModalContent.html',
				              controller: 'ModalInstanceCtrl',
				              resolve: {
				                  event: function(){ return obj},
				              }
				          });
				      };  
                      
                      $scope.viewMeetInfo = function(){
	                  console.log('re');
	                  var modalinstance = $modal.open({
			              templateUrl: 'mySecondModalContent.html',
			              controller: 'meetModalInstance',
	                      resolve: {
			                  meet: function(){ return $scope.meets},
			              }
			          });
	                  
	              };
	            
			    });
				  
				  angular.module("swimMeet").controller('ModalInstanceCtrl', function ($scope, $filter, $modalInstance, $http, event) {
				      
				      $scope.event = event;
				      $scope.selected = {
				          event: $scope.event[0]
				      };
				      
				      
				      $scope.ok = function (obj) {
				          $modalInstance.close($scope.selected.item);
				          
                            $scope.id = obj.event_number;
				            $scope.name = obj.event_name;
				            $scope.sex = obj.eligibile_sex;
				            $scope.Age = obj.eligible_age;
				            $scope.date = obj.event_date;
				            $scope.elgTime = obj.min_eligible_time;
				            $scope.addInfo = obj.additional_info;
				            $scope.session = obj.session_type;
				          
                          var date = $scope.date;
                            $scope.d = $filter('date')(date, 'yyyy-MM-dd'); 
                          
                          
				          $http({
				          method: 'post',
				          url: 'updateEventList.php',
				          params: {
				                        "name": $scope.name,
				                        "sex": $scope.sex,
				                        "Age": $scope.Age,
				                        "date": $scope.d,
				                        "elgTime": $scope.elgTime,
				                        "additionalInfo": $scope.addInfo,
				                        "session": $scope.session,
				                        "id": $scope.id,
				                        "meetId": $scope.meetId
				          }
				        }).then(function(response) {
				             
				          $scope.events = response.data;
                            window.location.reload();
	                });
			      };

			      $scope.cancel = function () {
			          $modalInstance.dismiss('cancel');
	                  window.location.reload();
			      };
				  //window.location.reload();        
				        });
	 
                angular.module("swimMeet").controller('meetModalInstance', function ($scope, $modalInstance, $http, meet) {
			      
	            
	            $scope.meet = meet[0];
	            $scope.selected = {
			          meet: $scope.meet[0]
				      };
                        
	           $scope.ok = function (obj) {
			          $modalInstance.close($scope.selected.item);
			     
			            $scope.pay = obj.per_event_charge;
			            $scope.deadline = obj.signup_deadline;
			            $scope.date1 = obj.meet_date1;
			            $scope.date2 = obj.meet_date2;
			            $scope.age = obj.min_eligible_age;
			            $scope.charge = obj.swimmer_charge;
			            $scope.noOfKids = obj.max_per_kid_signup;
	                    $scope.MaxInd = obj.max_individual_event;
			            $scope.Relay = obj.max_relay_event;
                   
                        var date = $scope.deadline;
                        $scope.dead = $filter('date')(date, 'yyyy-MM-dd'); 
                          
	                 
			          $http({
			          method: 'post',
			          url: 'updateMeetInfo.php',
			          params: {
			                        "pay": $scope.pay,
			                        "deadline": $scope.dead,
			                        "Age": $scope.age,
			                        "date1": $scope.date1,
			                        "date2": $scope.date2,
			                        "charge": $scope.charge,
			                        "noOfKids": $scope.noOfKids,
			                        "MaxInd": $scope.MaxInd,
	                                "Relay": $scope.Relay,
			                        "meetId": $scope.meetId
			          }
			        }).then(function(response) {
			             
			          $scope.meets = response.data;
	                      console.log($scope.meets);
			          window.location.reload();
	                      
	                      
			        });
			      };

				      $scope.cancel = function () {
				          $modalInstance.dismiss('cancel');
	                       window.location.reload();
				         
				      };
				  });
		            
		        
		            angular.module("swimMeet").controller('ModalInstance', function ($scope, $filter, $modalInstance, $http) {
				     
                        $scope.minDate = new Date();
                        $scope.formats = ['dd-MM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
                        $scope.format = $scope.formats[0];
                                             
				      $scope.ok = function (event_number, event_name, eligibile_sex, eligible_age, event_date, min_eligible_time, session_type, additional_info) {
				          
                          
				            $scope.id = event_number;
                            $scope.name = event_name;
				            $scope.sex = eligibile_sex;
				            $scope.Age = eligible_age;
				            $scope.date = event_date;
				            $scope.elgTime = min_eligible_time;
				            $scope.addInfo = additional_info;
				            $scope.session = session_type;
                            var date = $scope.date;
                            $scope.d = $filter('date')(date, 'yyyy-MM-dd') 
                          
                            console.log($scope.d);
                          
                            if(!$scope.id){  
                                $scope.EId = true;
                            }
                            if(!$scope.name){  
                                $scope.EName = true;
                            }
                            if(!$scope.sex){  
                                $scope.ESex = true;
                            }
                            if(!$scope.Age){  
                                $scope.EAge = true;
                            }
                            if(!$scope.d){  
                                $scope.EDate = true;
                            }
                            if(!$scope.session){  
                                $scope.ESession = true;
                            }
                            if(!$scope.addInfo){  
                                $scope.addInfo = 'N/A';
                            }
                            if(!$scope.elgTime){  
                                $scope.elgTime = 'N/A';
                            }
                           
                        if($scope.id && $scope.name && $scope.sex && $scope.Age && $scope.date && $scope.session){  
				          $http({
				          method: 'post',
				          url: 'addEvent.php',
				          params: {
				                        "name": $scope.name,
				                        "sex": $scope.sex,
				                        "Age": $scope.Age,
				                        "date": $scope.d,
				                        "elgTime": $scope.elgTime,
				                        "additionalInfo": $scope.addInfo,
				                        "session": $scope.session,
				                        "id": $scope.id,
				                        "meetId": $scope.meetId
				          }
				        }).then(function(response){
		                      
		                      $scope.events = $.trim(response.data).toString();
		                      
		                      if(angular.equals($scope.events,'1')){
		                          console.log("fateh");
		                          $modalInstance.dismiss();
		                          window.location.reload();
		                      }
		                      if(!angular.equals($scope.events,'1')){
		                          console.log("fateh not"+response.data);
		                          $scope.myValue = true;
		                      }
		                      
		                  });
                      }
		                  //window.location.reload();  
				      };

				      $scope.cancel = function () {
				          $modalInstance.dismiss('cancel');
				         
				      };
				  });
                    
                angular.module('ui.bootstrap').config(function ($provide) {
    $provide.decorator('$modal', function ($delegate) {
        var open = $delegate.open;

        $delegate.open = function (options) {
            options = angular.extend(options || {}, {
                backdrop: 'static',
                keyboard: false
            });

            return open(options);
        };
        return $delegate;
    })
});    

				</script> 
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
  </body>
  </html>  