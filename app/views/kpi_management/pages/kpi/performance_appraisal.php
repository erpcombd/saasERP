<?php

session_start();

ob_start();

require "../../config/inc.all.php";

require "../../template/main_layout.php";







/*if($_GET['PBI_ID']>0){

  

  $_SESSION['employee_selected'] = $_GET['PBI_ID'];

}*/

// ::::: Edit This Section ::::: 

$title='Key Performance Indicator (KPI)';		// Page Name and Page Title

$page="performance_appraisal.php";		// PHP File Name

$input_page="performance_appraisal_input.php";

$root='kpi';



$table='kpi_task';	

$table2= 'kpi_task_temporary';	

$unique='id';			

$shown='task_name';	





// ::::: End Edit Section :::::



$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_GET['id'].'"');



$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');



$crud      =new crud($table);



$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;







			

//if(isset($_POST[$shown]))

//{	

if(isset($_POST['add']))

	{

	

			$_REQUEST['entry_by']=$_SESSION['employee_selected'];

			$_REQUEST['week']=$_SESSION['week_name'];
			
			$_REQUEST['mon']=$_SESSION['month_name'];
			
			$_REQUEST['week_new']=$_SESSION['week_new'];

			$_REQUEST['year']=date('Y');

			$inserted = $crud->insert();

			

			$type=1;

			

			$in = 'INSERT INTO `kpi_task_temporary` (`PBI_ID`, `task_name`, `week`, `year`, `entry_by`) 
			VALUES ("'.$_GET['id'].'", "'.$_POST['task_name'].'", "'.$_SESSION['week_name'].'", "'.date('Y').'", "'.$_SESSION['employee_selected'].'")';

			mysql_query($in);

			$msg='New Entry Successfully Inserted.';

			//unset($_POST);

			//unset($$unique);

			



	}

	

	if(isset($_POST['submit']))

	{

	

	     $ssql = 'select * from kpi_task_temporary where PBI_ID="'.$_GET['id'].'" and year="'.date('Y').'"';

		 $qr = mysql_query($ssql);

		 

		 while($task_data=mysql_fetch_object($qr)){

		       

			   $saturday = $_POST['saturday_'.$task_data->task_id];

			   $sunday = $_POST['sunday_'.$task_data->task_id];

			   $monday = $_POST['monday_'.$task_data->task_id];

			   $tuesday = $_POST['tuesday_'.$task_data->task_id];

			   $wednesday = $_POST['wednesday_'.$task_data->task_id];

			   $thursday = $_POST['thursday_'.$task_data->task_id];

			   $friday = $_POST['friday_'.$task_data->task_id];

		       $score = $_POST['score_'.$task_data->task_id];

	  

	      $insert = 'INSERT INTO `kpi_task_details` (`PBI_ID`, `task_id`, `saturday`, `sunday`, `monday`, `tuesday`, `webnesday`, `thursday`, `friday`, `point`,`week`,`year`) VALUES ("'.$_GET['id'].'", "'.$task_data->task_id.'", "'.$saturday.'", "'.$sunday.'", "'.$monday.'", "'.$tuesday.'", "'.$wednesday.'", "'.$thursday.'", "'.$friday.'", "'.$score.'","'.$_SESSION['week_name'].'","'.date('Y').'")';

		  

		  mysql_query($insert);

	

		echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_2nd.php?id='.$_GET['id'].'";</script>';

	}

	

	}

	

	if($_GET['del']>0)

	{

	

			

			

			$del = 'delete from kpi_task_temporary where task_id="'.$_GET['del'].'"';

			mysql_query($del);

			

			echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal.php?id='.$_GET['id'].'";</script>';

			



	}



	

	

		

/*$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;

else

$$unique = $_SESSION['employee_selected']=$_POST['PBI_ID'];*/



	//for Modify..................................

	if(isset($_POST['update']))

	{

		$path='../../pic/staff';

		$_POST['pic']=image_upload($path,$_FILES['pic']);

		

		if($_FILES['emp_pic']['tmp_name']!=''){

			$file_name= $_FILES['emp_pic']['name'];

			$file_tmp= $_FILES['emp_pic']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../pic/staff/';

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.jpeg');

			}

			

			if($_FILES['nid_pic']['tmp_name']!=''){

			$file_name= $_FILES['nid_pic']['name'];

			$file_tmp= $_FILES['nid_pic']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../pic/nid/';

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.jpeg');

			}

			

			if($_FILES['pass_pic']['tmp_name']!=''){

			$file_name= $_FILES['pass_pic']['name'];

			$file_tmp= $_FILES['pass_pic']['tmp_name'];

			$ext=end(explode('.',$file_name));

			$path='../../pic/passport/';

			move_uploaded_file($file_tmp, $path.$_SESSION['employee_selected'].'.jpeg');

			}

			

		    $_POST['PBI_ID']=$_SESSION['employee_selected'];

			$inserted = $crud->insert();

			$type=1;

			$msg='New Entry Successfully Inserted.';

			unset($_POST);

			unset($$unique);

			echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/confirmation_list.php";</script>';

	}

	

	if(isset($_POST['reset']))

	{

		echo '<script type="text/javascript">parent.parent.document.location.href = "../'.$root.'/confirmation_list.php";</script>';

	}

//}



if(isset($_POST['delete']))



{		$condition=$unique."=".$$unique;		$crud->delete($condition);



		unset($$unique);



		echo '<script type="text/javascript">



parent.parent.document.location.href = "../'.$root.'/'.$page.'";



</script>';



		$type=1;



		$msg='Successfully Deleted.';



}





if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

while (list($key, $value)=each($data))

{ $$key=$value;}

}



$data = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);



$color = '#00CCFF';





?>





<style>

.skill-bar {

    width: 100%;

    float: left;

    height: 15px;

    

    position: relative;

   

    

}

.skill-bar span {

    background: #00CCFF;

    height: 30px;

    border-radius: 5px;

    display: inline-block;

}

.skill-bar span {

    animation: w70 1s ease forwards;

}

.skill-bar .w70 {

    width:100%;

}

@keyframes w70 {

    from { width: 0%; }

    to { width: 100%; }

}

</style>



<script>

    

	function cal(id){

	

	 

	  var saturday = document.getElementById('saturday_'+id).value;

	  var sunday = document.getElementById('sunday_'+id).value;

	  var monday = document.getElementById('monday_'+id).value;

	  var tuesday = document.getElementById('tuesday_'+id).value;

	  var wednesday = document.getElementById('wednesday_'+id).value;

	  var thursday = document.getElementById('thursday_'+id).value;

	  var friday = document.getElementById('friday_'+id).value;

	  

	  //var ex_score = parseFloat(document.getElementById('total_score').value);

	  

	  var per_row_column = parseFloat(document.getElementById('per_row_column_'+id).value);

	  

	      if(saturday=='YES' || saturday=='LEAVE' || saturday=='PUBLIC HOLIDAY'){

		    var sat_score = per_row_column;

			    

		  }else{

		    sat_score = 0;

		  }

		  

		  if(sunday=='YES' || sunday=='LEAVE' || sunday=='PUBLIC HOLIDAY'){

		    var sun_score = per_row_column;

			

			

		  }else{

		    sun_score = 0;

			

		  }

		  

		  if(monday=='YES' || monday=='LEAVE' || monday=='PUBLIC HOLIDAY'){

		    var mon_score = per_row_column;

			

		  }else{

		    mon_score = 0;

		  }

		  

		  if(tuesday=='YES' || tuesday=='LEAVE' || tuesday=='PUBLIC HOLIDAY'){

		    var tue_score = per_row_column;

			

		  }else{

		    tue_score = 0;

		  }

		  

		  if(wednesday=='YES' || wednesday=='LEAVE' || wednesday=='PUBLIC HOLIDAY'){

		    var wed_score = per_row_column;

			

		  }else{

		    wed_score = 0;

		  }

		  

		  if(thursday=='YES' || thursday=='LEAVE' || thursday=='PUBLIC HOLIDAY'){

		    var th_score = per_row_column;

			

		  }else{

		    th_score = 0;

		  }

		  

		  if(friday=='YES' || friday=='LEAVE' || friday=='PUBLIC HOLIDAY'){

		    var fri_score = per_row_column;

			

			

		  }else{

		    fri_score = 0;

			

		  }

		  

		  

		  var total_score = sat_score+sun_score+mon_score+tue_score+wed_score+th_score+fri_score;

		  document.getElementById('score_'+id).value = total_score.toFixed(2);

		   

		  // var ex_score = parseFloat(document.getElementById('total_score').value);

		   

		    //ex_score = ex_score+total_score;

		   

		   //document.getElementById('total_score').value = ex_score.toFixed(2);

		   

		  

		  

	}

	

	

  

</script>

	

	

	<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->

          <div class="">

		  

		  

           

        <div class="clearfix"></div>



            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

				

				<h3 align="center" style="text-transform:uppercase;"><?=$title?></h3>

                 

		     <? //include('../../common/new_title.php');?>

		 

                    

                  </div>

				  

				  <div class="x_panel">

				  <table width="100%" style="height:30px;" border="0" cellspacing="0" cellpadding="0" align="center">

				     <tr>

					    <td align="center" class="skill-bar"><span class="w70" style="color: #fff;">Step-1</span></td>

						<td align="center" ><!--<a href="performance_appraisal_2nd.php?id=<?=$_GET['id']?>"></a>-->Step-2</td>

						<td align="center">Final</td>

					 </tr>

				  </table>

                  </div>

				  

				  	 <div class="openerp openerp_webclient_container">

                    

			

				  

				  

                  <div class="x_content">

	

	

	

	

    

<form action="" method="post"  style="text-align:center" enctype="multipart/form-data" onsubmit="return confirm('Do you really want to execute this?');">

  <div class="oe_view_manager oe_view_manager_current">

    <? //include('../../common/title_bar_data.php');?><br />

    <div class="oe_view_manager_body">

      <div  class="oe_view_manager_view_list"></div>

      <div class="oe_view_manager_view_form">

        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

          <div class="oe_form_buttons"></div>

          <div class="oe_form_sidebar"></div>

          <div class="oe_form_pager"></div>

        

            

                <?  //include('../../common/input_bar.php'); ?>

                

                  

                    

                  <div class="container" style="margin-top:1%;">

				 <br />

                <div class="oe_chatter">

                  <div class="oe_followers oe_form_invisible">

                    <div class="oe_follower_list"></div>

                  </div>

               

		 <div style="border: 1px solid #337AB7;padding: 3px; margin-top: -20px;">

		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">

		<tr height="60">

		  <td>

		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">

			

			<tr>

			   <td style="font-size:16px; padding:2px;"> ID NO : <strong><?=$employee->PBI_ID?></strong></td>

			   <td style="padding:2px;">Name : <strong><?=$employee->PBI_NAME?></strong>  </td>

			    <td style="padding:2px;">Designation :  <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></strong></td>

				<td rowspan="3"><img src="../../../hrm_mod/pic/staff/<?=$_GET['id']?>.jpeg" style="height:100px; width:100px;" /></td>

			</tr>

			

			<tr>

			   <td style="padding:2px;">Department :  <strong><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></strong></td>

			   <td style="padding:2px;"> Project Name :  <strong><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></strong> </td>

			    <td style="padding:2px;">Joining Date :  <strong><?=date('d-M-Y',strtotime($employee->PBI_DOJ))?></strong></td>

				

			</tr>

			

			

			 <tr>

			   <td style="padding:2px;">KPI Authorised Person: <strong><?=$appraiser->PBI_NAME?></strong></td>

			  

			   <td style="padding:2px;">Designation of Authorised Person : <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></strong></td>

			   <td>Service Length : <strong><?php

										  

		  $interval = date_diff(date_create(date('Y-m-d')), date_create($employee->PBI_DOJ));

		echo $interval->format("%Y Year, %M Months, %d Days");

		  ?></strong></td>

			   

			</tr>

			</table>

		  </td>

		   

	 </tr>

	 

	

			

	 

	

</table>



<br />



<table width="100%" border="1" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">

           <tr>

		   

	      <td colspan="9" style="background:#337AB7; color:#FFFFFF;"><div align="center" style="font-size:16px; font-weight:bold;">Daily Task</div></td>

	   </tr>

	   

	   </table><br />

	   <table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">

	   <tr>

		  

	      <td colspan="9"><div align="center" style="font-size:16px; font-weight:bold;"><input type="text" name="task_name" id="task_name" style="width:200px;height: 40px;width: 25%; border-radius: 0px; margin-top: -1px;border-color: #337AB7;" />&nbsp;&nbsp;<input type="submit" name="add" value="ADD" style="width:100px; width: 100px; border-radius: 0px; height: 40px;background:#337AB7; color:#FFFFFF;" /><input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_GET['id']?>"/></div></td>

	   </tr>

      </table><br />

       <table width="100%" border="1" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">

		

	 

	  <?

	    $ssql = 'select * from kpi_task_temporary where PBI_ID="'.$_GET['id'].'" and year="'.date('Y').'"';

		$qr = mysql_query($ssql);

		 $count = find_a_field('kpi_task_temporary','count(PBI_ID)','PBI_ID="'.$_GET['id'].'" and year="'.date('Y').'"');

		 $per_row = 40/$count;

		 $per_row_column = $per_row/6;

		while($task_data=mysql_fetch_object($qr)){

		  

		  

		

	  ?>

	 

	  <tr>

	      <td colspan="9" style="background:#00CCFF"><div align="center" style="font-size:16px; font-weight:bold;"><?=$task_data->task_name?></div></td>

	   </tr>

	 <tr>

		 

		  <td width="11%"><div align="center">Saturday</div></td>

		  <td width="11%"><div align="center">Sunday</div></td>

		  <td width="11%"><div align="center">Monday</div></td>

		  <td width="11%"><div align="center">Tuesday</div></td>

		  <td width="11%"><div align="center">Wednesday</div></td>

		  <td width="11%"><div align="center">Thursday</div></td>

		  <td width="11%"><div align="center">Friday</div></td>

		  <td width="11%"><div align="center">Score/Points</div></td>

		  <td width="11%"><div align="center">Action</div></td>

	 </tr>

	  <tr>

	     

		  <td><div align="center"><select name="saturday_<?=$task_data->task_id?>" id="saturday_<?=$task_data->task_id?>" style="width: 100%; border-radius: 0px;height: 30px;" onchange="cal(<?=$task_data->task_id?>)">

		           <option></option>

				   <option>YES</option>

				   <option>NO</option>

				   <option>LEAVE</option>

				   <option>PUBLIC HOLIDAY</option>

				   <option>ABSENT</option>

				   <option>DAYOFF</option>

				   <option>HOLIDAY</option>

				   <option>NOT APPLICABLE</option>

				   </select>

				     <input type="hidden" name="per_row_column_<?=$task_data->task_id?>" id="per_row_column_<?=$task_data->task_id?>" value="<?=$per_row_column?>" />

				   </div></td>

		  <td><div align="center">

		    <select name="sunday_<?=$task_data->task_id?>" id="sunday_<?=$task_data->task_id?>" style="width: 100%; border-radius: 0px;height: 30px;" onchange="cal(<?=$task_data->task_id?>)">

              <option></option>

              <option>YES</option>

              <option>NO</option>

              <option>LEAVE</option>

              <option>PUBLIC HOLIDAY</option>

              <option>ABSENT</option>

              <option>DAYOFF</option>

              <option>HOLIDAY</option>

			  <option>NOT APPLICABLE</option>

            </select>

		    <input type="hidden" name="per_row_column_<?=$task_data->task_id?>" id="per_row_column_<?=$task_data->task_id?>" value="<?=$per_row_column?>" />

		  </div></td>

		  <td><div align="center"><select name="monday_<?=$task_data->task_id?>" id="monday_<?=$task_data->task_id?>" style="width: 100%; border-radius: 0px;height: 30px;" onchange="cal(<?=$task_data->task_id?>)">

		           <option></option>

				   <option>YES</option>

				   <option>NO</option>

				   <option>LEAVE</option>

				   <option>PUBLIC HOLIDAY</option>

				   <option>ABSENT</option>

				   <option>DAYOFF</option>

				   <option>HOLIDAY</option>

				   <option>NOT APPLICABLE</option>

		  </select>

		  <input type="hidden" name="per_row_column_<?=$task_data->task_id?>" id="per_row_column_<?=$task_data->task_id?>" value="<?=$per_row_column?>" />

		  </div></td>

		  <td><div align="center"><select name="tuesday_<?=$task_data->task_id?>" id="tuesday_<?=$task_data->task_id?>" style="width: 100%; border-radius: 0px;height: 30px;" onchange="cal(<?=$task_data->task_id?>)">

		           <option></option>

				   <option>YES</option>

				   <option>NO</option>

				   <option>LEAVE</option>

				   <option>PUBLIC HOLIDAY</option>

				   <option>ABSENT</option>

				   <option>DAYOFF</option>

				   <option>HOLIDAY</option>

				   <option>NOT APPLICABLE</option>

		  </select>

		  <input type="hidden" name="per_row_column_<?=$task_data->task_id?>" id="per_row_column_<?=$task_data->task_id?>" value="<?=$per_row_column?>" />

		  </div></td>

		  <td><div align="center"><select name="wednesday_<?=$task_data->task_id?>" id="wednesday_<?=$task_data->task_id?>" style="width: 100%; border-radius: 0px;height: 30px;" onchange="cal(<?=$task_data->task_id?>)">

		           <option></option>

				   <option>YES</option>

				   <option>NO</option>

				   <option>LEAVE</option>

				   <option>PUBLIC HOLIDAY</option>

				   <option>ABSENT</option>

				   <option>DAYOFF</option>

				   <option>HOLIDAY</option>

				   <option>NOT APPLICABLE</option>

		  </select>

		  <input type="hidden" name="per_row_column_<?=$task_data->task_id?>" id="per_row_column_<?=$task_data->task_id?>" value="<?=$per_row_column?>" />

		  </div></td>

		  <td><div align="center"><select name="thursday_<?=$task_data->task_id?>" id="thursday_<?=$task_data->task_id?>" style="width: 100%; border-radius: 0px;height: 30px;" onchange="cal(<?=$task_data->task_id?>)">

		           <option></option>

				   <option>YES</option>

				   <option>NO</option>

				   <option>LEAVE</option>

				   <option>PUBLIC HOLIDAY</option>

				   <option>ABSENT</option>

				   <option>DAYOFF</option>

				   <option>HOLIDAY</option>

				   <option>NOT APPLICABLE</option>

		  </select>

		  <input type="hidden" name="per_row_column_<?=$task_data->task_id?>" id="per_row_column_<?=$task_data->task_id?>" value="<?=$per_row_column?>" />

		  </div></td>

		  <td><div align="center"><select name="friday_<?=$task_data->task_id?>" id="friday_<?=$task_data->task_id?>" style="width: 100%; border-radius: 0px;height: 30px;" onchange="cal(<?=$task_data->task_id?>)">

		           <option></option>

				   <option>YES</option>

				   <option>NO</option>

				   <option>LEAVE</option>

				   <option>PUBLIC HOLIDAY</option>

				   <option>ABSENT</option>

				   <option>DAYOFF</option>

				   <option>HOLIDAY</option>

				   <option>NOT APPLICABLE</option>

		  </select>

		  <input type="hidden" name="per_row_column_<?=$task_data->task_id?>" id="per_row_column_<?=$task_data->task_id?>" value="<?=$per_row_column?>" />

		  </div></td>

		  <td><div align="center"><input type="text" name="score_<?=$task_data->task_id?>" id="score_<?=$task_data->task_id?>" style="width: 100%; border-radius: 0px;height: 30px; text-align:center; font-weight:bold;" /></div></td>

		   <td><div align="center"><a href="?del=<?=$task_data->task_id?>&&id=<?=$_GET['id']?>" onclick="show_alert();"><span style=" border-radius: 0px; background:#FF3300; color:#FFFFFF;">Delete</span></a></div></td>

	 </tr>

	 <tr>

	   <td colspan="9">&nbsp;</td>

	 </tr>

	 <? } ?>

	    </table>

       <br />

		<!--<table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">

			<tr>

			

			   <td colspan="9"><div align="center"><strong> Daily Task Score:</strong> <input type="button" name="calculation" id="calculation" value="=" onclick="change()" style="width:30px;" />

			       <input type="text" name="total_score" value="0" id="total_score" style="width: 15%; border-radius: 0px; height: 40px;border-color:#337AB7;" /></div></td>

			</tr>

	 

	

</table>--><br />

		<table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">

			<tr>

			   <td colspan="9"><div align="center"><input type="submit" name="submit" value="Confirm" style="width:100px; width: 15%; border-radius: 0px; height: 40px;background:#337AB7; color:#FFFFFF;" /></div></td>

			</tr>

	 

	

</table>

	

</div>



</form>





 

		   </div>

		   

		   

		   </div>

		    </div>

            </div>

			</div>

			</div>

			 </div>

              </div>

          

          </div>

        </div>

      </div>

    </div>

  </div>





    </div>









<?

include_once("../../template/footer.php");

?>