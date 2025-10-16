<?php
session_start();

 
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";



					$selects = 'select l.*,p.PROJECT_DESC from crm_lead_master l, crm_project p where 1 and l.project_id=p.PROJECT_ID and l.project_id="'.$_GET['PROJECT_ID'].'"';
					$querys = db_query($selects);
					
					while($row = mysqli_fetch_object($querys)){
					
					
					$new[] = "<option value='".$row->lead_no."'>".$row->lead_title."</option>";
					
					
					 } 
					 
					 echo json_encode($new);
					 
					 ?>


