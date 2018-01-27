 <?php
      include 'connectDB.php';
    session_start();
    if(!isset($_SESSION['login_user']))
    header("location:SwimMeetSignup.php");
 
      $conn = connectToDB();
      $sql = "select meet_name, meet_id from meet where meet_status='Active' and signup_deadline>CURRENT_DATE()-1 order by meet_date1,meet_id";
      $dob = $_SESSION['dob'];
      $sex = $_SESSION['sex'];
      $loginId = $_SESSION['loginId'];  
      $result = mysqli_query($conn, $sql);
  ?>
<!DOCTYPE html>
  <html>
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
        <style>
          @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
          @import url('https://fonts.googleapis.com/css?family=Cookie');
          html{
            overflow: scroll;
          }
          body{
            font-family: 'Roboto', sans-serif;
          }
          .topnav {
            
            background-color: #000;
            position: fixed;
            width: 100%;
          }
          .topnav a {
            float: right;
            display: block;
            color: #fff;
            text-align: center;
            padding: 22px 35px;
            text-decoration: none;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
          }
          .topnav a:hover {
            color: #f6734a;
          }
          a.active {
            color: #f6734a;
          }
          .topBar{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            margin-top: 61px;
          }
          .topBar img{
            width: 20%;
            height: 180px;
            float: left; 
          }
          .meetTabs{
            position: fixed;
            margin-top: 260px;
            margin-left: 35%;
            display: inline-block;
            width: 45%;
            color: white; 
          }
          .meetTabs li{
            float: left;
            text-decoration: none;
            list-style: none;
            padding: 18px 25px;
            background-color: black;
            color: white;  
          }
          .meetTabs a{
            padding-bottom: 18px;
          }
          .meetTabs a:hover{
            text-decoration: none;
            color: #f6734a;
            border-bottom: 2px solid #f6734a;
          }
          .activee{
            color: white;
            background-color: black;
          }
          .eventList{
            position: fixed;
            /*border-top: 1px solid black;*/
            margin-top: 330px;
            width: 100%;
            display: inline-block;
          }
          .meetInfo{
            float: left;
            width: 20%;
            background-color: black;
            text-align: center;
            margin-left: 5px;
            padding: 10px;
            color: white;
          }
          .tbl-header{
            float: left;
            width: 55%;
            background-color: black;
            text-align: center;
            margin-left: 10px;
            padding: 10px;
            color: white;
          }
          .cart{
            float: left;
            width: 23%;
            background-color: black;
            text-align: center;
            margin-left: 10px;
            padding: 10px;
            color: white;
          }
		  
        h1{
          font-size: 28px;
          color: #000;
          text-transform: uppercase;
          font-weight: 300;
          text-align: center;
          margin-bottom: 15px;
          background-color: black;
          opacity: 0.8;
          color: white;
          letter-spacing: 2px;
        }
        h2{
          font-size: 28px;
          text-transform: uppercase;
          font-weight: 300;
          text-align: left;
          margin-bottom: 15px;
          float: left;
          margin-top: -.5%;
          margin-left: 1%;
        }
        h3{
          margin-left: 70%;
          font-size: 28px;
          text-transform: uppercase;
          font-weight: 300;
          text-align: left;
          margin-bottom: 15px;
        }
        .class_count{
          background-color: black;
          opacity: 0.8;        
          color: white;
        }
        table{
          width:100%;
          table-layout: fixed;
          padding-top: 5px;
        }
        .tbl-header{
          background-color: rgba(255,255,255,0.3);
          width: 100%;
         }
        .tbl-content{
          height:100vh;
          margin-top: 0px;
          border: 1px solid rgba(255,255,255,0.3);
          width: 100%;
        }
        
        .cart{       
          width: 20%;
          float: left;
          margin-left: 59%;
          position: fixed;
          z-index: 1;
        }
        .cart_table{
          height:250px;
          overflow-x:auto;
        }
        .signup_button{
          background-color: black;
          color: white;
          width: 80%;
          height: 5vh;
          text-align: center;
          text-transform: uppercase;
          margin-left: 12%;
          font-size: 12px;
          letter-spacing: 2px;
          padding-top: 10px;
        }
        .signup_button a{
          text-decoration: none;
        }
        .signup_button button{
          background-color: black;
          color: white;
        }
        th{
          padding: 15px 15px;
          text-align: left;
          font-weight: 500;
          font-size: 12px;
          text-transform: uppercase;
        }
        td{
          padding: 15px;
          text-align: left;
          vertical-align:middle;
          font-weight: 300;
          font-size: 12px;
          color: #000;
          border-bottom: solid 1px rgba(255,255,255,0.1);
        }
        thead tr{
          color: white;
          background: rgba(52,221,247,1);
          background: -moz-linear-gradient(left, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          background: -webkit-gradient(left top, right top, color-stop(0%, rgba(52,221,247,1)), color-stop(23%, rgba(14,21,235,1)), color-stop(48%, rgba(12,245,183,1)), color-stop(71%, rgba(24,240,182,1)), color-stop(100%, rgba(122,230,39,1)));
          background: -webkit-linear-gradient(left, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          background: -o-linear-gradient(left, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          background: -ms-linear-gradient(left, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          background: linear-gradient(to right, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#34ddf7', endColorstr='#7ae627', GradientType=1 );
        }
        button{
          background-color: #fff;
          border: none;
        }
        .msg{
          color: red;
          margin-left: 8%;
          margin-top: 2%;
        }
        .content_div{
          width: 80%;
          margin-left: 20%;
          margin-top: 21%;
        }
        .sidenav{
          height: 100vh;
          width: 3.5%;
          top: 0;
          left: 0;
          background-color: black; 
          opacity: 0.9; 
          position: fixed;
          z-index: 1;
          padding-top: 21%;
          margin-left: 3%;
        }
        .sidenav a{
          text-decoration: none;
          color: white;
          display: block;
          font-size: 11px;
          letter-spacing: 2px;
          padding-top: 30px;
          padding-left: 45px;
        }
        .topnav{
          height: 10vh;
          width: 100%;
          top: 0;
          left: 0; 
          margin-top: 1%;
          background-color: black;
          opacity: 0.9;
          position: fixed;
          z-index: 2;
        }
        .page_links{
          margin-left: 37%;
        }
        .page_links a{
          text-decoration: none;
          color: white;
          display: block;
          font-size: 11px;
          margin-left: 4%;
          letter-spacing: 2px;
          margin-top: 2%;
          float: left;
          padding: 10px;
        }
        .page_links a:hover {
          background-color: white;
          color: black;
        }
        .page_out_links{
          float: right;
          margin-right: 4%;
          background-color: white;
          width: 15vh;
          height: 5vh;
          margin-top: 2.5vh;
          padding-top: 9px;
          text-align: center;
          cursor: pointer;
        }
        .page_out_links a{
          text-decoration: none;
          letter-spacing: 1px;
          color: black;
          font-size: 11px;
        }
        .scroll_meets{
          position: fixed;
          z-index: 1;
          left: 0;
          margin-left: 1%;
          padding-top: 20px;
          overflow-x: auto;
          height: 38vh;
          width: 25vh;
          background-color: black;
        }
        .scroll_meets a{
          width: 80%;
          margin-left: 10%;
        }
        .club_name{
          position: fixed;
          z-index: 3;
          top: 0;
          left: 0;
          width: 25vh;
          height: 15vh;
          margin-left: 0%;
          background-color: black;
          opacity: 0.9;
          color: white;
        }
        .temp{
          position: fixed;
          z-index: 1;
          left: 0;
          top: 0;
          width: 100%;
          height: 42vh;
          background-color: white;
        }
        .cn1{
          position: relative;
          z-index: 3;
          background-image: url('../images/hawk1.png');
          background-size: 70% 8vh;
          margin-left: 18%;
          height: 7vh;
          background-repeat: no-repeat;
        }
        .cn2{
          position: relative;
          z-index: 3;
          color: white;
          font-family: 'Cookie', cursive;
          margin-left: 17%;
          font-size: 25px;
        }
        .cn3{
          position: relative;
          z-index: 3;
          color: white;
          font-size: 10px;
          margin-left: 19%;
          letter-spacing: 3px;
          margin-top: -3%;
        }
        .topBar{
          position: fixed;
          z-index: 2;
          top: 0;
          left: 0;
          width: 94%;
          height: 26vh;
          margin-left: 6.5%;
          margin-top: 7.7%;
        }
        .topBar img{
          width: 20%;
          height: 26vh;
          padding-left: 2px;
          float: left; 
        }
        a.focus{
          background-color: white;
          color: black;
        }
        .scroll_meets button{
          background-color: white;
          border: 1px solid white;
          color: black;
          margin-top: 15%;
          margin-left: 10%;
          height: 5vh;
          width: 80%;
        } 
    .breadcrumb {
        background-color: white;
          padding: 10px 16px;
          list-style: none;
          margin-top: 0%;
          margin-left: -2%;
      }
      .breadcrumb li {
          display: inline;
          font-size: 100%;
      }
      .breadcrumb li+li:before {
           content: ">\00a0";
          color: black;
         
      }
      .breadcrumb li a {
        color: black;
          /*color: #0275d8;*/
          text-decoration: none;
      }
      .breadcrumb li a:hover {
          color: #01447e;
          text-decoration: none;
      }

      .breadcrumb >.active a {
     color: red;
  }
      </style>
  </head>
   <body ng-app="app" ng-controller="mainController as main">
      <div class="topnav">
        <a href="#">Contact</a>
        <a href="#">About</a>
        <a href="#" class="active">Home</a>
      </div>
      <div class="topBar">
        <img src="../images/topBar1.jpg">
        <img src="../images/topBar2.jpg">
        <img src="../images/topBar3.jpg">
        <img src="../images/topBar4.jpg">
        <img src="../images/topBar5.jpg">
      </div>
      <div class="meetTabs">
        <ul class="">
          <li class="activee"><a href="#">Meet 1</a></li>
          <li><a href="#">Meet 2</a></li>
          <li><a href="#">Meet 3</a></li>
          <li><a href="#">Meet 4</a></li>
        </ul>
      </div>
      <div class="eventList">
        
        <div class="meetInfo"> 
          <span class="meetInfoHead">MeetInfo</span>
        </div>
        
        <div class="tbl-header">
          <span class="eventListHead">Event List</span>
          <!-- table  cellpadding="0" cellspacing="0" border="0">
            <thead>
              <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Sex</th>
                <th>age</th>
                <th>Date</th>
                <th>Min Eligible Time</th>
                <th>Session</th>
                <th>Select</th>
              </tr>
            </thead>
          </table> -->
        </div>
        
          <div class="cart">
            <span class="cartHead">Cart</span>
          </div>
          
      </div>  
    </body>
  </html>        