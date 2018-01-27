	<?php 
		
		include 'connectDB.php';

		function convert_dob_to_timestamp($dob){
	    	$dob_data = explode("/", $dob);
	    	$dob_month = $dob_data[0];
	    	$dob_date = $dob_data[1];
	    	$dob_year = $dob_data[2];
	    	return $dob_year."-".$dob_month."-".$dob_date;
		}	    
 		
		function checkIfRelayEvent($meetName){
			if(strpos($meetName,"Relay")){
				return true;
			}
			return false;
		}

		function calculateAge($a,$b){
			$conn = $GLOBALS['conn'];
			$sql = "select TIMESTAMPDIFF(YEAR,'".$a."',"."'".$b."')";
			$row = fetchFromDB($conn, $sql);	
			return $row[0];
		}
      	
		function checkIfAtDeskSignUpEvent($additionalInfo){
			$deskEvents = array("Deck","Permitting","Entered","Time");
			foreach($deskEvents as $event){
    			if(strpos($additionalInfo, $event)!==false) 
					return true;
			}
			return false;
		}

		$conn = connectToDB();
		$dob = $_GET["dob"];
		$sex = $_GET["sex"];
		$meetId = $_GET["meetId"];
		$loginId = $_GET["loginId"];
		$GLOBALS['conn'] = $conn;
		//To get selected events
		$sqlSelected = "select event_number from signUpRecords where meet_id='".$meetId."' and login_id='".$loginId."'";
		$resultSelected = mysqli_query($conn, $sqlSelected);
		$selectedEventArr = array();
		while($rowSelect = mysqli_fetch_row ($resultSelected)){
			array_push($selectedEventArr, $rowSelect[0]);
		}
		//To get selected events

		$sqlMeetInfo = "select meet_date1, meet_date2, payable_to, per_event_charge, max_per_kid_signup, signup_deadline, min_eligible_age,swimmer_charge,max_individual_event,max_relay_event from meet where meet_id=$meetId";
		$meetResult = mysqli_query($conn, $sqlMeetInfo);
		$meetArr = array();
		
		while($meetRow=mysqli_fetch_row ($meetResult)){ 
	   		$meetArr= array("meetDate1"=>$meetRow[0],"meetDate2"=>$meetRow[1],"payableTo"=>$meetRow[2],"eventCharge"=>$meetRow[3],"maxSignUps"=>$meetRow[4],"deadline"=>$meetRow[5],"min_eligible_age"=>$meetRow[6],"swimmerCharge"=>$meetRow[7],"maxIndividualEvent"=>$meetRow[8],"maxRelayEvent"=>$meetRow[9]);
		  	$meet1Date = $meetRow[0];
	  		$meet2Date = $meetRow[1];	
	  		$min_eligible_age = $meetRow[6];	
		}

		$sqlEvent = "select event_number, event_name,eligibile_sex, eligible_age, event_date ,min_eligible_time, session_type, additional_info from event where meet_id=$meetId";
		$dob =  convert_dob_to_timestamp($dob);
		$kidsAgeAtFirstMeet = calculateAge($dob, $meet1Date);
		$kidsAgeAtSecondMeet = calculateAge($dob, $meet2Date);
		$result = mysqli_query($conn,$sqlEvent);
		$filteredEvents = array();
		$count=0;
		while ($row = mysqli_fetch_row ($result)){ 
			$count++;	
	  		$eligible_age = $row[3];
		  	$eligible_sex = $row[2];
		  	$eventDate = $row[4];	
		    if($eventDate == $meet1Date){
		 		$kidsAge = $kidsAgeAtFirstMeet;
	  		}
	  		else{
		  	$kidsAge = $kidsAgeAtSecondMeet;	
	  		}	
			$isRelayEvent = false;
			if(!checkIfAtDeskSignUpEvent($row[7])){
	  			if($eligible_sex == $sex || $eligible_sex=="Mixed"){
					if(checkIfRelayEvent($row[1])){
						$isRelayEvent = true;
					}
	  			if(in_array($row[0], $selectedEventArr)){
	  				array_push($filteredEvents, array("event_number"=>$row[0],"event_name"=>$row[1],"eligibile_sex"=>$row[2],"eligible_age"=>$row[3],"event_date"=>$row[4],"min_eligible_time"=>$row[5],"session_type"=>$row[6],"additional_info"=>$row[7],"isRelayEvent"=>$isRelayEvent,"addButton"=>false));
	  			}
	  			else{
		  			if($eligible_age!="OPEN"){
			  		//get range of eligible ages
			  			if(strpos($eligible_age, "-")==true){
				    		$ageRange = explode("-",$eligible_age);
							$minAge = $ageRange[0];
							$maxAge = $ageRange[1];  
				  		}
			   			if(strpos($eligible_age, "&")==true){
						    $ageRange = explode("&",$eligible_age);
							$minAge = $ageRange[0];
							$maxAge = $ageRange[1];  
						}
		  			}
					if($eligible_age=="OPEN" && $kidsAge>$min_eligible_age){
						array_push($filteredEvents, array("event_number"=>$row[0],"event_name"=>$row[1],"eligibile_sex"=>$row[2],"eligible_age"=>$row[3],"event_date"=>$row[4],"min_eligible_time"=>$row[5],"session_type"=>$row[6],"additional_info"=>$row[7],"isRelayEvent"=>$isRelayEvent,"addButton"=>true));
					}
					else{	
						if($kidsAge >=$minAge){
		         			if(is_numeric($maxAge[0])){
					 			if($kidsAge<=$maxAge){
						 			array_push($filteredEvents, array("event_number"=>$row[0],"event_name"=>$row[1],"eligibile_sex"=>$row[2],"eligible_age"=>$row[3],"event_date"=>$row[4],"min_eligible_time"=>$row[5],"session_type"=>$row[6],"additional_info"=>$row[7],"isRelayEvent"=>$isRelayEvent,"addButton"=>true));
					 			}
		      				}
							else{
					 			//It will be Up or O. In that case kid satisfies the criteria by satisfying min Age criteria only.
								array_push($filteredEvents, array("event_number"=>$row[0],"event_name"=>$row[1],"eligibile_sex"=>$row[2],"eligible_age"=>$row[3],"event_date"=>$row[4],"min_eligible_time"=>$row[5],"session_type"=>$row[6],"additional_info"=>$row[7],"isRelayEvent"=>$isRelayEvent,"addButton"=>true));
				 			}			
						}
					}
				}
	  		}
			}
		}
		array_push($filteredEvents, $meetArr);  	
		echo json_encode($filteredEvents);	
	?>