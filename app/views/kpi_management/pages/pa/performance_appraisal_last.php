<?php



session_start();



ob_start();



require "../../config/inc.all.php";



require "../../template/main_layout.php";


include ('../../../mail_function/mailer.php');















if($_GET['PBI_ID']>0){



  



  $_SESSION['employee_selected'] = $_GET['PBI_ID'];



}



// ::::: Edit This Section ::::: 



$title='Probation Progress';		// Page Name and Page Title



$page="confirmation.php";		// PHP File Name



$input_page="confirmation_input.php";



$root='hrm';







$table='confirmation_detail';		// Database Table Name Mainly related to this page



$unique='id';			// Primary Key of this Database table



$shown='suitable';	











// ::::: End Edit Section :::::




$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_GET['id'].'"');

$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');
$crud      =new crud($table);







/*$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);



if($required_id>0)



$$unique = $_GET[$unique] = $required_id;*/




if(isset($_POST['submit']))






{		

$probationary_check = find_all_field('performance_appraisal','','PBI_ID="'.$_GET['id'].'" and entry_by="'.$_SESSION['employee_selected'].'" and EMPLOYMENT_TYPE="Probationary" 
and status="DONE" and year="'.$_GET['year'].'"');

if($probationary_check->PBI_ID>0){

$delete = 'DELETE FROM `performance_appraisal` WHERE PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'" and entry_by="'.$_SESSION['employee_selected'].'" and status="DONE" and EMPLOYMENT_TYPE="Probationary"  and uniq_code!="'.$_GET['uniq'].'"';
mysql_query($delete);

}


  



    $update = 'update performance_appraisal set recommendation="'.$_POST['final'].'",category="'.$_POST['cat_status'].'",status="Done", extension_date="'.$_POST['extension_date'].'" where PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'" and uniq_code="'.$_GET['uniq'].'"';



	mysql_query($update);



//Mail Function


$to = 'hr@aksidcorp.com';

$subject = 'Performance Appraisal approved from reporting authority';
$str = 'AKSID Human Resources';
//$cc='hr@aksidcorp.com';
$cc='nrain798@gmail.com';

$str ="<span style='font-weight:bold; font-size:16px;'>New Performance Appraisal Submission</span><br>";

$str.='<table width="100%" border="1" cellspacing="1" cellpadding="1">

  <tr style="background:#abc4d6;">    

    <td width="5%"><div align="center" style="font-weight:bold; background:#abc4d6;">ID</div></td> 

    <td width="11%"><div align="center" style="font-weight:bold;">Name</div></td>

	<td width="10%"><div align="center" style="font-weight:bold;">Designation</div></td>
	
	<td width="15%"><div align="center" style="font-weight:bold;">Department/Job Location</div></td>

	<td width="10%"><div align="center" style="font-weight:bold;">Joining Date</div></td>

    <td width="20%"><div align="center" style="font-weight:bold;">Job Period</div></td>

	<td width="5%"><div align="center" style="font-weight:bold;">Total Mark</div></td>

    <td width="5%"><div align="center" style="font-weight:bold;">Category</div></td>

	<td width="15%"><div align="center" style="font-weight:bold;">Recommendation</div></td>

  </tr>';  

  $test = "select a.*,p.PBI_NAME,p.PBI_DOJ from performance_appraisal a, personnel_basic_info p where 
  a.PBI_ID=p.PBI_ID and a.PBI_ID='".$_GET['id']."' and year='".$_GET['year']."' and uniq_code='".$_GET['uniq']."'  ";
  


  $ss = mysql_query("select a.*,p.PBI_NAME,p.PBI_DOJ from performance_appraisal a, personnel_basic_info p where 
  a.PBI_ID=p.PBI_ID and a.PBI_ID='".$_GET['id']."'  and year='".$_GET['year']."' and uniq_code='".$_GET['uniq']."'");

	 $data = mysql_fetch_object($ss);
	 
	 
	

	 

	 $str.= '<tr align="center">';

     $str.= '<td>'.$data->PBI_CODE.'</td>';

     $str.= '<td>'.$data->PBI_NAME.'</td>';

     $str.= '<td>'.$data->designation.'</td>';
	 
	 $str.= '<td>'.$data->PBI_DEPARTMENT.''.$data->JOB_LOCATION.'</td>';

     $str.= '<td>'.date('d-M-Y',strtotime($data->PBI_DOJ)).'</td>';

     $str.= '<td>'.$data->job_period.'</td>';

	 $str.= '<td>'.$data->total_score.'</td>';

     $str.= '<td>'.$data->category.'</td>';

	 $str.= '<td>'.$data->recommendation.'</td>';

	 $str.= '</tr>';
	 
	 $headers = "MIME-Version: 1.0\r\n";
     $headers .= "Content-Type: text/html; charset=UTF-8\r\n";



     smtp_mailer($to,$subject,$str,$cc);
	 
	 //Mail end

	



	echo '<script type="text/javascript">parent.parent.document.location.href = "pa_view.php";</script>';








	}



	



	



		



/*$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);



if($required_id>0)



$$unique = $_GET[$unique] = $required_id;



else



$$unique = $_SESSION['employee_selected']=$_POST['PBI_ID'];*/







	//for Modify..................................



	







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



$color2 = '#00CCFF';



$color3 = '#00CCFF';



$color4 = '#00CCFF';











?>















	



    <style type="text/css">



<!--



.style1 {font-weight: bold}



-->



    </style>



	



	



	



	<div class="right_col" role="main">   <!-- Must not delete it ,this is main design header-->



          <div class="">



		  



		  



           



        <div class="clearfix"></div>







            <div class="row">



              <div class="col-md-12 col-sm-12 col-xs-12">



                <div class="x_panel">



				



				<h3 align="center">PERFORMANCE APPRAISAL</h3>



                 



		     <? include('../../common/new_title.php');?>



		 



                    



                  </div>



				  



				   <div class="x_panel">



				  <table width="100%" style="height:30px;" border="0" cellspacing="0" cellpadding="0" align="center">



				     <tr>



					    <td align="center" style="background:<?=$color?>;"><a href="performance_appraisal.php?id=<?=$_GET['id']?>&&year=<?=$_GET['year']?>&&uniq=<?=$_GET['uniq']?>">Step 1</a></td>



						<td align="center" style="background:<?=$color2?>;"><a href="performance_appraisal_2nd.php?id=<?=$_GET['id']?>&&year=<?=$_GET['year']?>&&uniq=<?=$_GET['uniq']?>">Step 2</a></td>



						<td align="center" style="background:<?=$color4?>;">Final</td>



					 </tr>



				  </table>



                  </div>



				  



				  	 <div class="openerp openerp_webclient_container">



                    



			



				  



				  



                  <div class="x_content">



	



	



	



	



    



<form action="" method="post"  style="text-align:center" enctype="multipart/form-data">



  <div class="oe_view_manager oe_view_manager_current">



    <? include('../../common/title_bar_data.php');?><br />



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



               



		



		<table width="90%" border="1" cellspacing="0" cellpadding="0" align="center">



		<tr height="60">



		  <td>



		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">



			



			<tr>



			   <td style="font-size:16px; padding:2px;"> ID NO : <strong><?=$employee->PBI_CODE?></strong></td>



			   <td style="font-size:16px; padding:2px;">NAME : <strong><?=$employee->PBI_NAME?></strong></td>



			    <td style="font-size:16px; padding:2px;">DESIGNATION :  <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></strong></td>



			</tr>



			



			<tr>



			   <td style="font-size:16px; padding:2px;">DEPARTMENT :  <strong><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></strong>,</td>



			   <td style="font-size:16px; padding:2px;"> PROJECT NAME :  <strong><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></strong>,   </td>



			    <td style="font-size:16px; padding:2px;">JOINING DATE :  <strong><?=$employee->PBI_DOJ?></strong></td>



			</tr>



			



			



			 <tr>



			   <td style="font-size:16px; padding:2px;">NAME OF APPRAISER : <strong><?=$appraiser->PBI_NAME?></strong></td>



			  



			   <td style="font-size:16px; padding:2px;">DESIGNATION OF APPRAISER : <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></strong></td>



			   <td style="font-size:16px; padding:2px;"> EMPLOYEE TYPE  :  <b><?=$emp_type=find_a_field('essential_info','EMPLOYMENT_TYPE','PBI_ID='.$employee->PBI_ID);?></b></td>



			</tr>



			</table>



		  </td>



		   



	 </tr>



	 



	



			



	 



	



</table>







<br />







<table  width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin:0 auto; font-size:16px;">



<tr>



  <td><div align="center"><span style="text-align:center; font-size:30px; color:#00CCCC;">Total Score : 

  <?=$tot_score=find_a_field('performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'" and uniq_code="'.$_GET['uniq'].'"');?></span></div></td>
  
  
  
 



</tr>







</table><br />



<!--Rating scale for Probational emp -->







<!--<table width="90%" border="1" cellspacing="0" cellpadding="0" align="center">



     



	



	  <tr>



		<td style="padding:5px; width:20%;background-color:#87CEEB;text-align:center"><strong>Rating Scale</strong></td>



		<td style="padding:5px; width:30%;background-color:#87CEEB;text-align:center"><strong>Description</strong></td>



		<td style="padding:5px; width:20%;background-color:#87CEEB;text-align:center"><strong>Rating Scale</strong></td>



		<td style="padding:5px; width:30%;background-color:#87CEEB;text-align:center"><strong>Description</strong></td>



		



	  </tr>



	  



	    <tr>



		<td style="padding:35px;text-align:center">87-100</td>



		<td style="padding:5px;" ><strong>Permanent With Incerment (Propose)</strong><br>Performance is exceptional and far exceeds expectations. Consistently demonstrates excellent standards in all job requirements.</td>



		<td style="padding:35px;text-align:center">73-86</td>



		<td style="padding:5px;" ><strong>Permanent With Incerment (Propose)</strong><br>Performance is consistent and exceeds expectations in all situations</td>



	  </tr>



	  



	    <tr>



		<td style="padding:35px;text-align:center">59-72</td>



		<td style="padding:5px;" ><strong>Permanent</strong><br>Performance is consistent. Clearly meets essential requirements of job.</td>



		<td style="padding:35px;text-align:center">45-58</td>



		<td style="padding:5px;" ><strong>Permanent</strong><br>Performance is satisfactory. Meets requirements of the job.</td>



	  </tr>



	  



	   <tr>



		<td style="padding:35px;text-align:center">31-44</td>



		<td style="padding:5px;" ><strong>Probationary Period Extension</strong><br>Performance is inconsistent. Meets requirements of the job occasionally. Supervision and trainig are required for most problem areas.</td>



		<td style="padding:35px;text-align:center">0-30</td>



		<td style="padding:5px;" ><strong>Discontinuation/Termination</strong><br>Performance does not meet the minimum  requirements of the job.</td>



	  </tr>



	  </table>-->



	  

	  

	  <!--Rating scale for permanent emp -->

	  

	  <table width="90%" border="1" cellspacing="0" cellpadding="0" align="center">



     



	



	  <tr>



		<td style="padding:5px; width:20%;background-color:#87CEEB;text-align:center"><strong>Rating Scale</strong></td>



		<td style="padding:5px; width:30%;background-color:#87CEEB;text-align:center"><strong>Description</strong></td>



		<td style="padding:5px; width:20%;background-color:#87CEEB;text-align:center"><strong>Rating Scale</strong></td>



		<td style="padding:5px; width:30%;background-color:#87CEEB;text-align:center"><strong>Description</strong></td>



		



	  </tr>



	  



	    <tr>



		<td style="padding:35px;text-align:center">87-100</td>



		<td style="padding:5px;" ><strong>Outstanding</strong><br>Performance is exceptional and far exceeds expectations. Consistently demonstrates excellent standards in all job requirements.</td>



		<td style="padding:35px;text-align:center">73-86</td>



		<td style="padding:5px;" ><strong>Very Good</strong><br>Performance is consistent and exceeds expectations in all situations</td>



	  </tr>



	  



	    <tr>



		<td style="padding:35px;text-align:center">59-72</td>



		<td style="padding:5px;" ><strong>Good</strong><br>Performance is consistent. Clearly meets essential requirements of job.</td>



		<td style="padding:35px;text-align:center">45-58</td>



		<td style="padding:5px;" ><strong>Fair</strong><br>Performance is satisfactory. Meets requirements of the job.</td>



	  </tr>



	  



	   <tr>



		<td style="padding:35px;text-align:center">31-44</td>



		<td style="padding:5px;" ><strong>Needs Improvement</strong><br>Performance is inconsistent. Meets requirements of the job occasionally. Supervision and trainig are required for most problem areas.</td>



		<td style="padding:35px;text-align:center">0-30</td>



		<td style="padding:5px;" ><strong>Unsatisfactory</strong><br>Performance does not meet the minimum  requirements of the job.</td>



	  </tr>



	  </table>

	  

	 



	  

       <!-- For probationary emp -->

	   

	   <? if($emp_type=='Probationary'){ ?>
	   
<? if($tot_score>=87 && $tot_score<=100){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Outstanding"/>
<? }elseif($tot_score>=73 && $tot_score<=86){  ?>
<input type="hidden" name="cat_status" id="cat_status" value="Very Good"/>
<? }elseif($tot_score>=59 && $tot_score<=72){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Good"/>
<? }elseif($tot_score>=45 && $tot_score<=58){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Fair"/>
<? }elseif($tot_score>=31 && $tot_score<=44){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Needs Improvement"/>
<? }elseif($tot_score>=0 && $tot_score<=30){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Unsatisfactory"/>
<? } ?>

	   

	  <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">



	  <tr>



	    <td>Recommendations</td>



	  </tr>



	   <tr>



	    <td><hr /></td>



	  </tr>



	  <?



	  if($tot_score>=73 && $tot_score<=100){?>



        <tr>



	    <td><strong><input type="radio" name="final" id="final" value="Permanent" checked="checked" />&nbsp;Permanent</strong>
		
		</td>



	  </tr>

	  

	  

	  <? }elseif($tot_score>=45 && $tot_score<=72){ ?>

	  

	    <tr>



	    <td><strong><input type="radio" name="final" id="final" value="Permanent" checked="checked" />&nbsp;Permanent </strong></td>



	  </tr>

	  

	  

	  



	  <? }elseif($tot_score>=31 && $tot_score<=44){ ?>



	   <tr>



	    <td><strong><input type="radio" name="final" id="final" value="Probation Period Extension" checked="checked" />&nbsp;Probation Period Extension</strong></td>
		
		<? //if($emp_type=="Probationary" && $tot_score>=31 && $tot_score<=44 ){ ?>
		
		<td align="right"> Extension Date : <strong><input type="date" name="extension_date" id="extension_date" value="" /></strong></td>
         <? //}?>



	  </tr>



	   <tr>



	    <td><strong><input type="radio" name="final" id="final" value="Discontinuation" checked="checked" />&nbsp;Discontinuation</strong></td>



	  </tr>



	  



	  <? }elseif($tot_score>=0 && $tot_score<=30){ ?>



	   <tr>



	    <td><strong><input type="radio" name="final" id="final" value="Discontinuation" checked="checked" />&nbsp;Discontinuation</strong></td>



	  </tr>
	  
	  
	



	  <? } ?>



</table>



<? }else{?>

	  

	  

	  <!--For permanent emp -->
	  
<? if($tot_score>=87 && $tot_score<=100){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Outstanding"/>
<? }elseif($tot_score>=73 && $tot_score<=86){  ?>
<input type="hidden" name="cat_status" id="cat_status" value="Very Good"/>
<? }elseif($tot_score>=59 && $tot_score<=72){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Good"/>
<? }elseif($tot_score>=45 && $tot_score<=58){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Fair"/>
<? }elseif($tot_score>=31 && $tot_score<=44){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Needs Improvement"/>
<? }elseif($tot_score>=0 && $tot_score<=30){ ?>
<input type="hidden" name="cat_status" id="cat_status" value="Unsatisfactory"/>
<? } ?>

	  
     
	  

	  <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">



	  <tr>



	    <td>Recommendations</td>



	  </tr>



	   <tr>



	    <td><hr /></td>



	  </tr>



	  <?



	  if($tot_score>=45 && $tot_score<=100){?>



        <tr>



	    <td><strong><input type="radio" name="final" id="final" value="Salary Increment (Propose)" checked="checked" />&nbsp;Salary Increment (Propose)</strong></td>
		



	  </tr>



	  <? }elseif($tot_score>=31 && $tot_score<=44){ ?>



	   <tr>



	    <td><strong><input type="radio" name="final" id="final" value="No Salary Increment" checked="checked" />&nbsp;No Salary Increment</strong></td>



	  </tr>



	  



	  



	  <? }elseif($tot_score>=0 && $tot_score<=30){ ?>



	   <tr>



	    <td><strong><input type="radio" name="final" id="final" value="Discontinuation" checked="checked" />&nbsp;Discontinuation</strong></td>



	  </tr>



	  <? } ?>

</table>

	  

	

	<? }?>  

	  

	  

	  

	  

	  <br />



	  



	   <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">



	   



	   <tr>



	    <td><strong><input type="submit" name="submit" id="submit" value="SUBMIT" style="background:#87CEEB;" /></strong></td>
		
		


	   </tr>



		</table>



		



<br /><br />











		<br />



		



		



		



<br /><br />







	 



	 



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







        <!-- /page content -->



<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>



<script>







$(document).ready(function(){



	$("#LINE_MANAGER_ID").keyup(function(){



		$.ajax({



		type: "POST",



		url: "auto_com.php",



		data:'keyword='+$(this).val(),



		beforeSend: function(){



			$("#LINE_MANAGER_ID").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");



		},



		success: function(data){



			$("#suggesstion-box").show();



			$("#suggesstion-box").html(data);



			$("#LINE_MANAGER_ID").css("background","#FFF");



		}



		});



	});



});







function selectCountry(val) {



$("#LINE_MANAGER_ID").val(val);



$("#suggesstion-box").hide();



}







</script>











<?



include_once("../../template/footer.php");



?>