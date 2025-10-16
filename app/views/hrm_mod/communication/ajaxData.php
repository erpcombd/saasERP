<?php 

session_start();

 
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";



if(isset($_REQUEST["PROJECT_ID"]) && !empty($_REQUEST["PROJECT_ID"])){
    //Get all state data
    echo $query = db_query('select l.*,p.PROJECT_DESC from crm_lead_master l, crm_project p where 1 and l.project_id=p.PROJECT_ID and l.project_id="'.$_REQUEST['PROJECT_ID'].'"');
    
    //Count total number of rows
    $rowCount = mysqli_num_rows($query);
    
    //Display states list
    if($rowCount > 0){
        echo '<option value="">Select state</option>';
        while($row = mysqli_fetch_object($query)){ 
            echo '<option value="'.$row->lead_no.'">'.$row->lead_no.'</option>';
        }
    }else{
        echo '<option value="">State not available</option>';
    }
}
 
//if(isset($_POST["state_id"]) && !empty($_POST["state_id"])){
//    //Get all city data
//    $query = $db->query("SELECT * FROM cities WHERE state_id = ".$_POST['state_id']." AND status = 1 ORDER BY city_name ASC");
//    
//    //Count total number of rows
//    $rowCount = $query->num_rows;
//    
//    //Display cities list
//    if($rowCount > 0){
//        echo '<option value="">Select city</option>';
//        while($row = $query->fetch_assoc()){ 
//            echo '<option value="'.$row['city_id'].'">'.$row['city_name'].'</option>';
//        }
//    }else{
//        echo '<option value="">City not available</option>';
//    }
//}


?>