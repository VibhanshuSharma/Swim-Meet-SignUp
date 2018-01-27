<?php
      include 'connectDB.php';
    session_start();
    if(!isset($_SESSION['login_user']))
    header("location:SwimMeetSignup.php");

  if(isset($_SESSION['login_user']) && $_SESSION['user_role'] == 'Coach')
    header("location: HeadCoach.php");
 
      $conn = connectToDB();
      $sql = "select meet_name, meet_id from meet where meet_status='Active' and signup_deadline>CURRENT_DATE()-1 order by meet_date1,meet_id";
      $dob = $_SESSION['dob'];
      $sex = $_SESSION['sex'];
      $loginId = $_SESSION['loginId'];  
      $result = mysqli_query($conn, $sql);
    $result2 = $result; 
  ?>
<!DOCTYPE html>
  <html lang="en">
  <head>
    <title>ParentLanding</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="usc.jpg" type="image/jpg">
      <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      
      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="../css/style1.css" rel="stylesheet"> 

  </head>
  <body ng-app="app" ng-controller="mainController as main">
     
      <!-- <div class="header">
        <div class="brandname">
          <a href="">Arcadia Riptides</a>
        </div>
        <ul id="navbar">
        <li><a ng-click="main.viewProfile('<?php  $loginId?>')">Profile</a></li>
          <li><a href="https://www.arcadiaswimclub.org/about-1/" target="_blank">About</a></li>
          <li><a href="https://www.arcadiaswimclub.org/contact/" target="_blank">Contact</a></li>
          <li><div class="page_out_links" style="border-radius: 2px; margin-top: 13px;"  onclick="location.href = 'logout.php';">
        <button id="page_logout" style="font-size: 12px;letter-spacing: 1px;">LOGOUT</button>
      </div></li>
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
            <li><a ng-click="main.viewProfile('<?php echo $loginId?>')" href="#">Profile</a></li> 
            <li><a href="https://www.arcadiaswimclub.org/about-1/" target="_blank">About</a></li>
            <li><a href="https://www.arcadiaswimclub.org/contact/" target="_blank">Contact</a></li>
            <li><a onclick="location.href = 'logout.php';" href="#"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav> 


       <div class="headreplace"></div>
      <div class="imgbar">
        <img src="../Images/topBar1.jpg" class="pull-left" height="200px" width="20%">
        <img src="../Images/topBar2.jpg" class="pull-left" height="200px" width="20%">
        <img src="../Images/topBar3.jpg" class="pull-left" height="200px" width="20%">
        <img src="../Images/topBar4.jpg" class="pull-left" height="200px" width="20%">
        <img src="../Images/topBar5.jpg" class="pull-left" height="200px" width="20%">
      </div>
      <div class="main-content">      
      <div class="navbtns">
        <div class="dropdown">
          <button class="btn dropdown-toggle" id="drp" type="button" data-toggle="dropdown">
            Meets <span class="caret"></span> 
          </button>
          <ul class="dropdown-menu">
     <?php
       $counter = 0;
       if($result){
       
       // echo "<script>console.log('hey $result.length');</script>";  
          while($row = $result->fetch_row()){
           
            if($counter==0){
        
      ?>
            <li class="<?php echo $counter ?>"><a  ng-init="main.getMeetEvents(<?php echo $row[1]?>,'<?php echo $dob?>','<?php echo $sex?>','<?php echo $loginId?>',<?php echo $counter?>)" ng-click="main.getMeetEvents(<?php echo $row[1]?>,'<?php echo $dob?>','<?php echo $sex?>', '<?php echo $loginId?>',<?php echo $counter?>)" href="#">
      <?php echo $row[0]?></a></li>
           <?php
        $counter++;
            }
            else{
      ?> 
      <li class="<?php echo $counter ?>">
         <a ng-click="main.getMeetEvents(<?php echo $row[1]?>,'<?php echo $dob?>','<?php echo $sex?>', '<?php echo $loginId?>',<?php echo $counter?>)"  href="#">
      <?php echo $row[0]?></a>
     </li>
      <?php   
           $counter++;
      }
          } 
        }
      ?>
          </ul>
      </div>
       
       <!-- Trigger the modal with a button -->
      <div class="cartbtn"><button type="button" id="myBtn" class="btn"  ><i class="fa fa-shopping-cart fa-lg" aria-hidden="true"></i>&nbsp;&nbsp;{{main.length}}</button></div>
    </div>
    <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

        <!-- Modal Content-->
        <div class="modal-content">
              <div class="modal-header">
            <span data-dismiss="modal" class="close">&times;</span>
          </div>
              <div class="modal-body">
              <table>
              <tr ng-show="!main.EventsInTheCart()">
                  <td>You have no selected Events.</td>
              </tr>
            </table>  
            <table ng-show="main.EventsInTheCart()" >
                      <tr>
                        <th>Event</th>
                        <th>Price</th>
                        <th></th>
                      </tr> 
              <tr ng-repeat="item in main.items">
                <td>{{item.event_name}}</td>
                <td>{{eventCharges | currency}}</td>
                <td><button class="btn" id="addbtn" ng-click="main.removeFromCart(item)"><i class="fa fa-minus-square fa-lg symbol" aria-hidden="true"></i></button></td>
              </tr>
            </table>
       <div ng-show="main.showSignupButton() && signedUpEvents==0">
            <button onclick="myModal.style.display = 'none'" class="signup_button" ng-click="main.completeSignUp('<?php echo $loginId?>', main.items)">SignUp Events</button>
          </div>
       <div ng-show="signedUpEvents>0">
            <button data-dismiss="modal" class="signup_button" ng-click="main.completeSignUp('<?php echo $loginId?>', main.items)">Save and Continue</button>
          </div>
          <div class="msg" ng-show="msg!=''">
            <span>{{main.msg}}</span>
          </div>
     <div class="success" ng-show="info!=''">
            <span>{{main.info}}</span>
          </div>    
    </div>
        <div class="modal-footer">
         
        </div>        
      </div>
        </div>
   </div>   
      <div class="meetsinfo">
        <div class="meets">
          <ul>
       <?php
       $counter = 0;
    mysqli_data_seek($result, 0);   
       if($result2){
       
       // echo "<script>console.log('hey $result.length');</script>";  
          while($row = $result->fetch_row()){
           
            if($counter==0){
        
      ?>
            <li class="<?php echo $counter ?>"><a ng-init="main.getMeetEvents(<?php echo $row[1]?>,'<?php echo $dob?>','<?php echo $sex?>','<?php echo $loginId?>',<?php echo $counter?>)" ng-click="main.getMeetEvents(<?php echo $row[1]?>,'<?php echo $dob?>','<?php echo $sex?>', '<?php echo $loginId?>',<?php echo $counter?>)" href="#">
      <?php echo $row[0]?></a></li>
           <?php
        $counter++;
            }
            else{
      ?> 
      <li  class="<?php echo $counter?>">
         <a ng-click="main.getMeetEvents(<?php echo $row[1]?>,'<?php echo $dob?>','<?php echo $sex?>', '<?php echo $loginId?>',<?php echo $counter?>)" href="#">
      <?php echo $row[0]?></a>
     </li>
      <?php   
           $counter++;
      }
          } 
        }
      ?>
          </ul>
        </div>
        </div>
        <div class="meetinfo">  
          <div class="meetinfodata"><span>Swimmer may swim a <span style="color: #09ff09;">max {{maxSignUps}}</span> events for the meet, <span style="color: #09ff09;">{{maxindividualEvent}} individual</span> and <span style="color: #09ff09;">{{maxrelayEvent}} relay</span> per day.</span></div>
          <div class="meetinfosym"><span style="color: red;">Sign up deadline:</span> {{deadline}}</div>
        </div>
    <div ng-show='view!="Checkout"'>   
        <div class="eventlistheader">
          <span>EVENT LIST</span>          
        </div>
        <div class="eventlisttable">
          <div class="table-responsive">          
            <table class="table">
              <thead>
                <tr>
                  <th class="adbtn1">Select</th>
                  <th>Number</th>
                  <th>Name</th>
                  <th>Sex</th>
                  <th>age</th>
                  <th>Date</th>
                  <th>Min Eligible Time</th>
                  <th>Session</th>
                  <th class="adbtn2">Select</th>
                </tr>
              </thead>
              <tbody>
                <tr id="eve" ng-repeat="item in events" ng-if = "$index < eventLength-1">
                  <td ng-show="item.addButton" class="adbtn1"><button  class="btn"  ng-click="main.addToCart(item)" id="addbtn"><i class="fa fa-plus-square fa-2x  symbol" aria-hidden="true"></i></button></td>
                  <td class="green-text adbtn1" ng-show="!item.addButton">Selected</td>
                  <td>{{ item.event_number }}</td>
                  <td>{{ item.event_name }}</td>
                  <td>{{ item.eligibile_sex }}</td>
                  <td>{{ item.eligible_age }}</td>
                  <td>{{ item.event_date }}</td>  
                  <td>{{ item.min_eligible_time }}</td>
                  <td>{{ item.session_type }}</td>
                  <td ng-show="item.addButton" class="adbtn2"><button  class="btn"  ng-click="main.addToCart(item)" id="addbtn"><i class="fa fa-plus-square fa-2x  symbol" aria-hidden="true"></i></button></td>
                  <td class="green-text adbtn2" ng-show="!item.addButton">Selected</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    <div ng-show='view=="Checkout"'>  
        <div class="payeeinfo">
          <a href="#"><div class="piheader" data-toggle="collapse" data-target="#payee">Payee Information <span class="caret" style="float: right;margin-top: 2%;margin-right: 3%;"></span></div></a>
        </div> 
        <div class="collapse" id="payee" style="padding:3%;">
        <table id="innertable">
          <tr>
            <th>Make checks Payable to:</th>
            <td>{{payableTo}}</td>
          </tr>
          <tr>
            <th>Swimmer Charge:</th>
            <td>{{swimmerCharge | currency}}</td>
          </tr>
          <tr>
            <th>Per Event Charge:</th>
            <td>{{eventCharges|currency}}</td>
          </tr>
        </table>
       </div>  
        <div class="eventlistheader">
          <span>EVENT LIST</span>          
        </div>
        <div class="eventlisttable">
          <div class="" style="overflow-x: auto;height: 225px;">          
            <table class="" id="evntlisttab">
              <thead>
                <tr>
          <th>Event Number</th>
          <th>Event Name</th>
          <th>Price</th>
                </tr>
              </thead>
              <tbody>
               <tr ng-repeat="item in checkedOutItems">
                  <td>{{item.event_number}}</td>
                  <td>{{item.event_name}}</td>
                  <td>{{item.event_charge | currency}}</td>
                </tr>
      <tr>
        <th></th>
        <td>Swimmer Charge</td>
        <td>{{swimmerCharge | currency}}</td>
      </tr>   
      <tr>
        <th></th>
        <th>Total</th>
        <td>{{total_payment | currency}}</td>
      </tr>
              </tbody>
            </table>
        <div >
      
          </div>
          
      </div>
      <button class="signup_button1" ng-click="view='Events'" onclick="document.getElementById('<?php echo 'my'.$meetCounter;?>').click()">Edit Signups</button>
        </div>
      </div>    
      </div>
   <div ng-show='view!="Checkout"'>  
      <div class="cartInfo"> 
        <div class="cartHeader">
          <p>CART</p>
          <span>{{main.length}}</span>
      </div>  
    <table>
      <tr ng-show="!main.EventsInTheCart()">
          <td>You have no selected Events.</td>
      </tr>
      </table>  
            <div style="overflow-x: auto; height: 250px;">
            <table ng-show="main.EventsInTheCart()" >
              <tr>
                <th>Event</th>
                <th>Price</th>
                <th></th>
              </tr>
          
              <tr ng-repeat="item in main.items">
                <td>{{item.event_name}}</td>
                <td>{{eventCharges | currency}}</td>
                <td><button  class="btn" id="addbtn" ng-click="main.removeFromCart(item)"><i class="fa fa-minus-square fa-lg symbol" aria-hidden="true"></i></button></td>
              </tr>
            </table>
            </div>
       <div ng-show="main.showSignupButton() && signedUpEvents==0">
            <button class="signup_button" ng-click="main.completeSignUp('<?php echo $loginId?>', main.items)">SignUp Events</button>
          </div>
       <div ng-show="signedUpEvents>0" >
            <button class="signup_button" ng-click="main.completeSignUp('<?php echo $loginId?>', main.items)">Save and Continue</button>
          </div>
          <div class="msg" ng-show="msg!=''">
            <span>{{main.msg}}</span>
          </div>
     <div class="success" ng-show="info!=''">
            <span>{{main.info}}</span>
          </div>  
        </div>
    </div>
   <div ng-show='view=="Checkout"'>  
      <div class="cartInfo"> 
        <div class="cartHeader">
          <p>PAYMENT</p>
         
      </div>  
      <table class="payment">
        <tr>
          <th>Make checks Payable to: </th><td> {{payableTo}}</td>
        </tr>
        <tr>
          <th>
            Swimmer Charge: </th><td> {{swimmerCharge| currency}}</td>
        </tr>
        <tr>
          <th >Per Events Charge: </th><td>{{eventCharges|currency}}</td></tr>
        <tr>
          <th>Total Amount to be Payed: </th><td>{{total_payment| currency}}
          </td>
        </tr> 
      </table>  
              
        </div>
    </div>
  <script type="text/javascript">
    $(window).on("load resize ", function() {
      var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
      $('.tbl-header').css({'padding-right':scrollWidth});
    }).resize();
  </script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
  <script type="text/javascript">
    angular.module('app', []) 
      .controller('mainController', function($scope,$http) {  
      var _this = this;
       $scope.view="Events"; 
          _this.getMeetEvents = function(meetId, dob, sex, loginId, meetCounter){      
          _this.addButton = true;
          _this.eventInCart = false;
      _this.items = [];  
      $scope.view="Events";  
            $scope.meet_identifier = meetId;  
            $scope.login_identifier = loginId;
      $scope.meetCounter = meetCounter; 
      var buttons = document.getElementsByTagName('button');
      for (var i = 0; i < buttons.length; i++) {
          var button = buttons[i];
          button.style.backgroundColor = "black";
        
        
      }
      var buttons = document.getElementsByTagName('li');
      for (var i = 0; i < buttons.length; i++) {
          var button = buttons[i];
          button.style.backgroundColor = "black";
        
        
      }  
      
      var elem = document.getElementsByClassName(meetCounter);
      for (var i = 0; i < elem.length; i++) {
          var element = elem[i];
          element.style.backgroundColor = "#003973";
        
        
      }    
            $http({
                method: 'post',
                url: 'GetKidEvents.php',
                params: {
                  "dob": dob,
                  "sex": sex,
                  "meetId": meetId, 
                  "loginId": loginId
                }
             }).then(function(response) {
        _this.msg="";
        _this.info="";
        _this.firstDayIndividualEvents=0;
          _this.secondDayIndividualEvents=0;
          _this.firstDayRelayEvents=0;
          _this.secondDayRelayEvents=0;
        console.log("here");
                $scope.events = response.data;
                console.log($scope.events);
                $scope.eventLength = $scope.events.length;  
                var evLength = ($scope.eventLength-1);  
                var meet  = $scope.events[evLength];
        $scope.meetDate1 = meet.meetDate1;
        $scope.meetDate2 = meet.meetDate2;
                $scope.payableTo = meet.payableTo;
                $scope.eventCharges = meet.eventCharge;
                $scope.swimmerCharge = meet.swimmerCharge;
                $scope.maxSignUps = meet.maxSignUps;
        $scope.maxindividualEvent = meet.maxIndividualEvent;
        $scope.maxrelayEvent = meet.maxRelayEvent;
                $scope.deadline = meet.deadline;
        console.log("swimmer charge"+$scope.swimmerCharge);
                //items array contains events which are selected-will initially contain current signups.   
                _this.items = [];
                _this.length = 0;
                $scope.signedUpEvents = 0; 
                //Put signed up items in the cart
                for($scope.j=0; $scope.j<$scope.events.length;$scope.j++){
                  if($scope.events[$scope.j].addButton == false){
                    _this.length += 1;
          $scope.signedUpEvents +=1;
           var mySelectedItem = $scope.events[$scope.j];
                     _this.items.push($scope.events[$scope.j]);
             if(mySelectedItem.event_date==$scope.meetDate1){
             if(!mySelectedItem.isRelayEvent){
              _this.firstDayIndividualEvents++; 
             }
             else{
               _this.firstDayRelayEvents++;
             }
           }
           else{
             if(!mySelectedItem.isRelayEvent){
              _this.secondDayIndividualEvents++;  
             }
             else{
               _this.secondDayRelayEvents++;  
             }
           }             
                  }
                }
        
                //Put selected items in the cart

            });
          }
          _this.completeSignUp = function(loginId){
              $scope.signedupEventsNumber = "";
              $scope.signedupEventsName = "";
        _this.msg="";
              for($scope.i=0;$scope.i<_this.items.length;$scope.i++){
                $scope.a = _this.items[$scope.i].event_number;
                $scope.b = _this.items[$scope.i].event_name;
                
                if($scope.signedupEventsNumber==""){
                  $scope.signedupEventsNumber = $scope.a;
                  $scope.signedupEventsName = $scope.b;
                }
                else{
                  $scope.signedupEventsNumber = $scope.signedupEventsNumber+"and"+ $scope.a;
                  $scope.signedupEventsName = $scope.signedupEventsName+"and"+ $scope.b;
                }
              }
              $http({
                method: 'post',
                url: 'signUpEvents.php',
                params: {
                  "loginId": loginId,
                  "meetIdentifier":$scope.meet_identifier,
                  "signedupEventsNumber":$scope.signedupEventsNumber,
                  "signedupEventsName":$scope.signedupEventsName, 
                  "individualCharge":$scope.swimmerCharge,
                  "eventCharges":$scope.eventCharges 
                }
              }).then(function(response) {
                  $scope.total_payment = response.data;
          if(_this.items.length>0){
            
           $scope.checkedOutItems = response.data;
           $scope.total_payment =  $scope.checkedOutItems[$scope.checkedOutItems.length-1].totalPayment;
           $scope.view="Checkout"; 
                  }
          else{
            _this.info = "You have 0 signups currently.";
          }
                });
          
          }
          _this.viewProfile = function(loginId){
            location.href='ParentProfilePage.php?a='+loginId;
          }
          _this.showSignupButton = function() {
        if(_this.items.length==0){
                  return false;
                }  
        return true;
      }
      _this.EventsInTheCart = function() {
              if(_this.items.length == 0){
                return false;
              }
              return true;
          }
      _this.showSaveAndContinue = function() {
              if(_this.signedUpEvents>0){ 
        console.log("here");  
                return true;
              }
           return false;
          } 
          _this.addToCart = function(item) {
        var push = false;
              if(_this.items.length < ($scope.maxSignUps)){
         console.log(item.event_date);
         console.log($scope.meetDate1); 
         if(item.event_date==$scope.meetDate1){
           if(!item.isRelayEvent){
            if(_this.firstDayIndividualEvents==$scope.maxindividualEvent){
              _this.msg = "You have reached individual events limit for "+$scope.meetDate1;
           }
           else{
            _this.firstDayIndividualEvents++;
             push = true;
           }
          }
          else{
            if(_this.firstDayRelayEvents==$scope.maxrelayEvent){
              _this.msg = "You have reached relay events limit for "+$scope.meetDate1;
            }
            else{
              _this.firstDayRelayEvents++;
              push = true;
            }
            
            } 
         }
         else{
           if(!item.isRelayEvent){
            if(_this.secondDayIndividualEvents==$scope.maxindividualEvent){
              _this.msg = "You have reached individual events limit for "+$scope.meetDate2;
               }
            else{
              _this.secondDayIndividualEvents++;
              push = true;
            }
            }
           else{
             if(_this.secondDayRelayEvents==$scope.maxrelayEvent){
              _this.msg = "You have reached relay events limit for "+$scope.meetDate2;
               }
            else{
              _this.secondDayRelayEvents++;
              push = true;
            }
             
           }
          }
        if(push){
            _this.items.push(item);
                item.addedToCart = true;
                item.addButton = false;
                _this.length += 1;
        }
          
          } 
              else{
                _this.msg = "You can not add more events";
              }
          }
          _this.removeFromCart = function(item) {
              item.addButton = true;
              _this.msg = "";
              _this.length -= 1;
              var itemIndex = _this.items.indexOf(item);
         if(item.event_date==$scope.meetDate1){
           if(!item.isRelayEvent){
          
            _this.firstDayIndividualEvents--;
           }
          
          else{
            
              _this.firstDayRelayEvents--;
            }
         }
        else{
           if(!item.isRelayEvent){
            
              _this.secondDayIndividualEvents--;
             
           
            }
           else{
              _this.secondDayRelayEvents--;
            }
             
           }
        
              if (itemIndex > -1) {
                  _this.items.splice(itemIndex, 1);
              }
          }
      });
  </script>
  <script>
    //var modal = document.getElementById('myModal');
        var btn = document.getElementsByClassName("signup_button");
        //var span = document.getElementsByClassName("close")[0];
        /*btn.onclick = function() {
          modal.style.display = "none";
        }*/
        
        $(document).ready(function(){
          $("#myBtn").click(function(){
            $("#myModal").modal();
          });
        });
      
      /*$("document").ready(function(){
          setTimeout(function(){
            $("tr.eve:first-child").trigger('click');
          },10);

      });*/

  </script> 

 <script>
window.location.hash="no-back-button";
window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
window.onhashchange=function(){window.location.hash="";}
</script>
  </body>
  </html>