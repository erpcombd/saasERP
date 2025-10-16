<?php

    session_start();

    if(isset($_POST['get_userEmail'])){
		
		
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
		
		$userID = $_POST['get_userEmail'];

		$userEmail = find_a_field('user_activity_management', 'email', 'PBI_ID = "'.$userID.'"');

		echo $userEmail;
        
        exit;

	}
	
	
	if(isset($_POST['get_projectContacts'])){
		
		
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
		
		$projectID = $_POST['get_projectContacts'];
		$selected = $_POST['contactPerson'];

		$projectContactSql = "SELECT * FROM crm_lead_contacts WHERE project_id = '$projectID'";
		$projectContactRslt = db_query($projectContactSql);
        
        echo '<option value="">-- SELECT--</option>';
        
		while($projectContact = mysqli_fetch_object($projectContactRslt)){
		    
		    echo '<option value="'.$projectContact->id.'"';
		    if($selected == $projectContact->id){
		        echo ' selected>'.$projectContact->contact_name.'</option>';
		    }else{
		       echo '>'.$projectContact->contact_name.'</option>'; 
		    }
		    
		}
		
        
        exit;

	}
	
	

?>