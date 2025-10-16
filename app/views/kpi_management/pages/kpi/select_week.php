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



$table='kpi_task';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

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

	/*  $check_point  = find_a_field('kpi_task','count(task_id)','week_name="'.$_POST['week'].'" and mon = "'.$_POST['mon'].'" and PBI_ID="'.$employee->PBI_ID.'" ');

		 if($check_point>0){
		 
		   $msg = "User data already exists";
		   
		 
		 
		 }else{	}*/

		

		 $_SESSION['week_name'] = $_POST['week'];
		 
		 $_SESSION['month_name'] = $_POST['mon'];
		 
		

    echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_2nd.php?id='.$_GET['id'].'";</script>';
  
	 
	 
	}

	

	

	

	if($_GET['del']>0)

	{

	

			

			

			$del = 'delete from kpi_task where task_id="'.$_GET['del'].'"';

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

        

            

                <? //include('../../common/input_bar.php');?>

                

                  

                    

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





	   <table width="100%" border="0" cellspacing="5" cellpadding="2" align="center" style="padding:5px;">
	   
	  <?php /*?> <tr><td>

	   <div class="alert alert-danger"><?=$check_point  = find_a_field('kpi_task','count(task_id)','week_name="'.$_POST['week'].'" and mon = "'.$_POST['mon'].'"  ');?></div>
	
	   
	   </td></tr><?php */?>

	   <tr>

		  

	      <td colspan="9"><div align="center" style="font-size:16px; font-weight:bold;">
		  
		  
		  <select name="week" id="week" style="width:200px;height: 40px;width: 25%; border-radius: 0px; margin-top: -1px;border-color: #337AB7;" required>
          <option></option>
           <option value="Week 1">Week 1</option>
		   <option value="Week 2">Week 2</option>
		   <option value="Week 3">Week 3</option>
		   <option value="Week 4">Week 4 & 5</option>
		
	

		  </select>
		  
		  

	<?php /*?>	  <?

		    $sql = 'select * from hrm_weeks where 1 order by s_date';

			$query = mysql_query($sql);

			while($data = mysql_fetch_object($query)){

			  $check = find_a_field('kpi_final_score','WEEK','WEEK="'.$data->week_name.'" and PBI_ID="'.$_GET['id'].'"');

			  if($check==''){

			 ?>

			

			<option value="<?=$data->week_name?>"><?=$data->week_name.' '.date('d-M-Y',strtotime($data->s_date)).' To '.date('d-M-Y',strtotime($data->e_date))?></option>

			  

			<? } }

		  ?>

		  </select><?php */?>&nbsp;&nbsp;
		  
		  
		  
		  <select name="mon" id="mon" style="width:200px;height: 40px;width: 25%; border-radius: 0px; margin-top: -1px;border-color: #337AB7;" required>
          <option></option>
           <option value="01">Jan</option>
		   <option value="02">Feb</option>
		   <option value="03">Mar</option>
		   <option value="04">Apr</option>
		   <option value="05">May</option>
		   <option value="06">Jun</option>
		   <option value="07">Jul</option>
		   <option value="08">Aug</option>
		   <option value="09">Sep</option>
		   <option value="10">Oct</option>
		   <option value="11">Nov</option>
		   <option value="12">Dec</option>

		  </select>&nbsp;&nbsp;
		  
				  
		  

	          <input type="submit" name="add" value="SELECT MONTH" style="Width: 150px; border-radius: 0px; height: 40px;background:#337AB7; color:#FFFFFF;" />

	          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_GET['id']?>"/></div></td>

	   </tr>

      </table>

	   <br />

      

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