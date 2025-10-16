<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $paper_grade_type=$data[0];
   


?>


  	<select name="paper_grade" required id="paper_grade" style="width:250px;" tabindex="7" >
			<option></option>

            <? foreign_relation('paper_grade','id','paper_grade',$paper_grade,'paper_grade_type="'.$paper_grade_type.'" and status="Active"');?>
    </select>









