  <?php
  include 'connectDB.php';
  $conn = connectToDB();
  $meetIdentifier=$_GET['a'];
  $loginId=$_GET['b'];
  $total_payment=$_GET['c'];
  $eventCharges=$_GET['d'];
  $swimmerCharges=$_GET['e']	
  echo "meetIdentifier".$meetIdentifier;
  echo "loginId".$loginId;
  $sql = "select event_number, event_name from signUpRecords where meet_id='".$meetIdentifier."' and login_id='".$loginId."'";
  $result= mysqli_query($conn, $sql);

  ?>

  <!DOCTYPE html>
  <html>
  <head>
    <title>Checkout</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="usc.jpg" type="image/jpg">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <!-- <script src="https://cdn.jsdelivr.net/jquery.typeit/4.4.0/typeit.min.js"></script> -->
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script> -->

      <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:400,500,300,700);
        @import url('https://fonts.googleapis.com/css?family=Cookie');
        html{
          
        }
        body{
          font-family: 'Roboto', sans-serif;
        }
        
        h1{
          width: 40%;
          height: 6vh;
          position: fixed;
          z-index: 3;
          margin-left: 30%;
          font-size: 28px;
          text-transform: uppercase;
          font-weight: 300;
          text-align: center;
          color: white;
          letter-spacing: 2px;
          margin-top: -7%;

           background: rgba(52,221,247,1);
          background: -moz-linear-gradient(left, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          background: -webkit-gradient(left top, right top, color-stop(0%, rgba(52,221,247,1)), color-stop(23%, rgba(14,21,235,1)), color-stop(48%, rgba(12,245,183,1)), color-stop(71%, rgba(24,240,182,1)), color-stop(100%, rgba(122,230,39,1)));
          background: -webkit-linear-gradient(left, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          background: -o-linear-gradient(left, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          background: -ms-linear-gradient(left, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          background: linear-gradient(to right, rgba(52,221,247,1) 0%, rgba(14,21,235,1) 23%, rgba(12,245,183,1) 48%, rgba(24,240,182,1) 71%, rgba(122,230,39,1) 100%);
          filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#34ddf7', endColorstr='#7ae627', GradientType=1 );
        }
        .sidenav{
          height: 100vh;
          width: 3.5%;
          top: 0;
          left: 0;
          /*margin-top: 10%; */
          background-color: black;  
          position: fixed;
          z-index: 1;
          padding-top: 21%;
          margin-left: 3%;

        }
        .topnav{
          height: 10vh;
          width: 100%;
          top: 0;
          left: 0; 
          margin-top: 1%;
          background-color: black;
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
        .club_name{
          position: fixed;
          z-index: 3;
          top: 0;
          left: 0;
          width: 25vh;
          height: 15vh;
          margin-left: 0%;
          background-color: black;
          /*border: 1px solid black;*/
          /*opacity: 0.9;*/
          color: white;
        }
        .temp{
          position: fixed;
          z-index: 0;
          left: 0;
          top: 0;
          width: 100%;
          height: 10vh;
          background-color: white;
        }
        .cn1{
          position: relative;
          z-index: 3;
          background-image: url('images/hawk1.png');
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
        a.focus{
          background-color: white;
          color: black;
        }
        .profile{
          width: 80%;
          height: 50vh;
          margin-left: 13%;
          margin-top: 18%;
        }
        table{
          width: 80%;
          margin-left: 6%;
          text-transform: uppercase;
          text-align: center;
          border-bottom: 1px solid black;
        }
        th{
          width: 20%;
          background-color: black;
          color: white;
          height: 7vh;
          font-weight: 300; 
          letter-spacing: 2px;
          margin-bottom: 2vh;
        }
        td{
          
          width: 20%;
          height: 7vh;
          margin-bottom: 2vh;

        }
        .child_pic{
          background-image: url('images/child.png');
          background-repeat: no-repeat;
          background-size: 40vh 25vh;
          width: 100%;
          height: 100%;
          margin-left: 34%;
        }
        .breadcrumb {
        background-color: white;
          /*padding: 10px 16px;*/
          list-style: none;
          margin-top: -5%;
          margin-left: 2.7%;
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
  <body ng-app="app">
    <div class="temp"></div>
    <div class="club_name">
      <div class="cn1"></div>
      <div class="cn2">Arcadia Riptides</div>
      <div class="cn3">SWIMMING CLUB</div>
    </div>

    <div class="topnav">
      <div class="page_links">
        <!-- <a href=""><i class="fa fa-home fa-lg" aria-hidden="true" style="padding-right: 4px;"></i>HOME</a> -->
        <a href="ParentLandingPage.php"><i class="fa fa-bars fa-lg" aria-hidden="true" style="padding-right: 4px;"></i>EVENTS</a>
        <!-- <a href="parentProfilePage.html" class="focus"><i class="fa fa-user fa-lg" aria-hidden="true" style="padding-right: 4px;"></i>CHECKOUT</a> -->
        
      </div>
      <div class="page_out_links">
        <a href="logout.php">LOGOUT</a>
      </div> 
    </div>
    <div class="sidenav"></div>
  <div ng-controller="mainController as main" class="content_div">
    <h1>CHECKOUT</h1>
    <section class="profile">
      <div>
    <ul class="breadcrumb">
        <li align="center"><a href="mainPage.php"><b>Home&nbsp;</b></a></li>
        <li align="center"><a href="#"><b>&nbsp;Event List</b></a></li>
    </ul>
        <table>
   <tr>
       <th>Event Number</th>
       <th>Event Name</th>
       <th>Price</th>
      </tr>     
    <?php while($row=mysqli_fetch_row ($result)){ 
       
      ?>
          <tr>
            <td><?php echo $row[0]?></td>
            <td><?php echo $row[1]?></td>
            <td><?php echo "$".$eventCharges?></td>
          </tr>
        <?php } ?>
          <tr style="">
            <th >Total</th>
            <td style="border-top: 1px solid black;"></td>
            <td style="border-top: 1px solid black;border-right: 1px solid black "><?php echo "$".$total_payment ?></td>
          </tr>
        </table>

      </div>
      <!-- <div class="child_pic"> -->
        
    
    </section>
  </div>
  </body>
  </html>
