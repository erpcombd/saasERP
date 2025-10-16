<?php



session_start();



ob_start();



require "../../config/inc.all.php";



require "../../template/main_layout.php";















/*if($_GET['PBI_ID']>0){







  $_SESSION['employee_selected'] = $_GET['PBI_ID'];



}*/



// ::::: Edit This Section :::::



$title='Performance Appraisal';		// Page Name and Page Title



$page="performance_appraisal.php";		// PHP File Name



$input_page="performance_appraisal_input.php";



$root='kpi';







$table='performance_appraisal';		// Database Table Name Mainly related to this page



$unique='id';			// Primary Key of this Database table



$shown='type';











// ::::: End Edit Section :::::







$employee = find_all_field('personnel_basic_info','','PBI_ID="'.$_GET['id'].'"');







$appraiser = find_all_field('personnel_basic_info','','PBI_ID="'.$_SESSION['employee_selected'].'"');







$crud      =new crud($table);







/*$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);



if($required_id>0)



$$unique = $_GET[$unique] = $required_id;

*/



$uniq_code = $_REQUEST['uniq'];















//if(isset($_POST[$shown]))



//{

$check = find_a_field('performance_appraisal','id','year="'.$_GET['year'].'" and PBI_ID="'.$_GET['id'].'" and status!="Done" and entry_by="'.$_SESSION['user']['id'].'"');

$$unique = $check;

if(isset($_POST['submit']))



	{

         $total_score = $_POST['total_score_2']+$_POST['pre_score'];

		 $update = 'update performance_appraisal set part_12="'.$_POST['part_12'].'",part_14="'.$_POST['part_14'].'",part_15="'.$_POST['part_15'].'",part_16="'.$_POST['part_16'].'",
		 part_18="'.$_POST['part_18'].'",part_20="'.$_POST['part_20'].'",part_23="'.$_POST['part_23'].'",part_24="'.$_POST['part_24'].'",

			part_25="'.$_POST['part_25'].'",part_3_comment="'.$_POST['part_3_comment'].'",part_4_comment="'.$_POST['part_4_comment'].'",part_5_comment="'.$_POST['part_5_comment'].'",
			achievements="'.$_POST['achievements'].'", 
			total_score="'.$total_score.'",total_score_2="'.$_POST['total_score_2'].'" where PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'" and uniq_code="'.$_GET['uniq'].'" ';







		mysql_query($update);







		echo '<script type="text/javascript">parent.parent.document.location.href = "performance_appraisal_last.php?id='.$_GET['id'].'&&year='.$_GET['year'].'&&uniq='.$uniq_code.'";</script>';







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



$color2 = '#00CCFF';







?>















	<script>











	  function avg(){











		



		   var ratingl = parseFloat(document.getElementById('part_12').value);



		   if(ratingl>0){



		     var rating12 = ratingl;



		   }else{



		   var rating12 = 0;



		   }



		 /*  var ratingm = parseFloat(document.getElementById('part_13').value);



		   if(ratingm>0){



		     var rating13 = ratingm;



		   }else{



		   var rating13 = 0;



		   }*/



		   var ratingn = parseFloat(document.getElementById('part_14').value);



		   if(ratingn>0){



		     var rating14 = ratingn;



		   }else{



		   var rating14 = 0;



		   }



		   var ratingo = parseFloat(document.getElementById('part_15').value);



		   if(ratingo>0){



		     var rating15 = ratingo;



		   }else{



		   var rating15 = 0;



		   }



		   var ratingp = parseFloat(document.getElementById('part_16').value);



		   if(ratingp>0){



		     var rating16 = ratingp;



		   }else{



		   var rating16 = 0;



		   }



/*var ratingq = parseFloat(document.getElementById('part_17').value);
if(ratingq>0){
var rating17 = ratingq;
}else{
var rating17 = 0;
}
*/


		   var ratingr = parseFloat(document.getElementById('part_18').value);



		   if(ratingr>0){



		     var rating18 = ratingr;



		   }else{



		   var rating18 = 0;



		   }


/*
		   var ratings = parseFloat(document.getElementById('part_19').value);



		   if(ratings>0){



		     var rating19 = ratings;



		   }else{



		   var rating19 = 0;



		   }*/



		   var ratingt = parseFloat(document.getElementById('part_20').value);



		   if(ratingt>0){



		     var rating20 = ratingt;



		   }else{



		   var rating20 = 0;



		   }

		   

		   

		    var ratingw = parseFloat(document.getElementById('part_23').value);



		   if(ratingw>0){



		     var rating23 = ratingw;



		   }else{



		   var rating23 = 0;



		   }

		   

		   

		    var ratingx = parseFloat(document.getElementById('part_24').value);



		   if(ratingx>0){



		     var rating24 = ratingx;



		   }else{



		   var rating24 = 0;



		   }

		   

		   

		    var ratingy = parseFloat(document.getElementById('part_25').value);



		   if(ratingy>0){



		     var rating25 = ratingy;



		   }else{



		   var rating25 = 0;



		   }

		   

		   

		   

		   



		   var pre = parseFloat(document.getElementById('pre_score').value);



		   if(pre>0){



		     var score = pre;



		   }else{



		   var score = 0;



		   }





          //rating13+rating17+rating19

		   var rating_sum = rating12+rating14+rating15+rating16+rating18+rating20+rating23+rating24+rating25;











		  //var avg = (rating_sum*13)/100;







		  document.getElementById('total_score_2').value=rating_sum.toFixed(0);



	  }



	</script>















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







		     <? //include('../../common/new_title.php');?>











                  </div>







				   <div class="x_panel">



				  <table width="100%" style="height:30px;" border="0" cellspacing="0" cellpadding="0" align="center">



				     <tr>



					    <td align="center" style="background:<?=$color?>;"><a href="performance_appraisal.php?id=<?=$_GET['id']?>&&year=<?=$_GET['year']?>&&uniq=<?=$_GET['uniq']?>">Step 1</a></td>



						<td align="center" style="background:<?=$color2?>;">Step 2</td>



						<!--<td align="center">Setp 3</td>-->



						<td align="center">Final</td>



					 </tr>



				  </table>



                  </div>







				  	 <div class="openerp openerp_webclient_container">



















                  <div class="x_content">























<form action="" method="post"  style="text-align:center" enctype="multipart/form-data">



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











		<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">



		<tr height="60">



		  <td>



		    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">







			<tr>



			   <td style="font-size:16px; padding:2px;"> ID NO : <strong><?=$employee->PBI_CODE?></strong></td>



			   <td style="font-size:16px; padding:2px;">NAME : <strong><?=$employee->PBI_NAME?></strong></td>



			    <td style="font-size:16px; padding:2px;">DESIGNATION :  <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$employee->PBI_DESIGNATION);?></strong></td>



			</tr>







			<tr>



			   <td style="font-size:16px; padding:2px;">DEPARTMENT :  <strong><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$employee->PBI_DEPARTMENT);?></strong></td>



			   <td style="font-size:16px; padding:2px;"> PROJECT NAME :  <strong><?=find_a_field('project','PROJECT_DESC','PROJECT_ID='.$employee->JOB_LOCATION);?></strong></td>



			    <td style="font-size:16px; padding:2px;">JOINING DATE :  <strong><?=date('d-M-Y',strtotime($employee->PBI_DOJ))?></strong></td>



			</tr>











			 <tr>



			   <td style="font-size:16px; padding:2px;">Name of Appraiser : <strong><?=$appraiser->PBI_NAME?></strong></td>







			   <td style="font-size:16px; padding:2px;">Designation of Appraiser : <strong><?=find_a_field('designation','DESG_DESC','DESG_ID='.$appraiser->PBI_DESIGNATION);?></strong></td>



			   <td></td>



			</tr>



			</table>



		  </td>







	 </tr>























</table>







<br />











<table width="100%" border="1" cellspacing="0" cellpadding="0" align="center">











	  <tr>



		<td style="padding:5px; width:5%;background-color:#87CEEB; text-align:center"><strong>Rating Scale</strong></td>



		<td style="padding:5px; width:30%;background-color:#87CEEB;text-align:center"><strong>Description</strong></td>



		<td style="padding:5px; width:5%;background-color:#87CEEB;text-align:center"><strong>Rating Scale</strong></td>



		<td style="padding:5px; width:30%;background-color:#87CEEB;text-align:center"><strong>Description</strong></td>







	  </tr>







	    <tr>



		<td style="padding:5px;text-align:center">0</td>



		<td style="padding:5px;">Performance does not meet minimum requirements of the job.</td>



		<td style="padding:5px;text-align:center">1</td>



		<td style="padding:5px;">Performance is inconsistent.  Meets requirements of the job occasionally.</td>



	  </tr>







	    <tr>



		<td style="padding:5px;text-align:center">2</td>



		<td style="padding:5px;">Performance is satisfactory. Meets requirements of the needs.</td>



		<td style="padding:5px;text-align:center">3</td>



		<td style="padding:5px;">Performance is consistent. Clearly meets job requirements.</td>



	  </tr>







	  <tr>



		<td style="padding:5px;text-align:center">4</td>

		<td style="padding:5px;">Performance is consistent and exceeds expectations.</td>
		
		
		<td style="padding:5px; text-align:center">5</td>
	<td style="padding:5px;">Performance is exceptional and far exceeds expectations. Demonstrates excellent standard.</td>







		<!--<td style="padding:5px;">5-Point</td>

<td style="padding:5px;">Performance is consistent and exceeds expectations</td>-->



	  </tr>















		</table>



<br /><br />







<br /><br />















   <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">







	 <!--Part-1-->



	  <?php /*?><tr>



		<td style="padding:5px; width:40%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'"');?>" /><strong></strong></td>



		<td style="padding:5px; width:10%" align="center"><strong><center>Rating</center></strong></td>



	  </tr><?php */?>







	  <?php /*?><tr>



		<td style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Process Improvement </span></td>



		<td style="padding:5px;">11.&nbsp;&nbsp;Seeks to continuously improve processes and work methods<br>সবসময় কাজের পদ্ধতি এবং প্রক্রিয়ার উন্নতি করতে চায় কি না</td>



		<td style="padding:5px;"><select name="part_11" id="part_11" onchange="avg()">



		  <option selected="selected" disabled="disabled">..Select One..</option>



		  <option>0</option>



		  <option>1</option>



		  <option>2</option>



	      <option>3</option>



		  <option>4</option>







		</select></td>



	   </tr><?php */?>







	     <tr style="background-color:#87CEEB">



		<td style="padding:5px; width:40%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score_1','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'" and uniq_code="'.$_GET['uniq'].'" ');?>" /><strong>PART III &nbsp;&nbsp;MANAGEMENT</strong></td>



		<td style="padding:5px; width:10%" align="center"><strong><center>Rating</center></strong></td>



	  </tr>







	   <tr>



		<th rowspan="2" style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Problem Solving </span></th>



		<td style="padding:5px;">12. Helps resolve problems on work-related matters.<br>

		 <span style="font-size:14px">কাজ সম্পর্কিত বিষয়ে সমস্যা সমাধান করতে পারে কি না।</span></td>



		<td style="padding:5px;text-align:center"><select name="part_12" id="part_12" onchange="avg()">



		 <option selected="selected" disabled="disabled">..Select One..</option>

		 

		 

		<option <?=($part_12==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_12==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_12==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_12==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_12==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_12==5)? 'selected' : ''?>>5</option>









		</select></td>



	  </tr>











	   <!--Part-1 End-->







	   <!--Part-2-->







	  <tr>






<?php /*?>
		<td style="padding:5px;">Handles problem situations effectively.<br><span style="font-size:14px">যে কোন সমস্যা সামনে আসলে তা সঠিকভাবে পরিচালনা করতে বা সামলাতে পারে কি না। </span></td>



		<td style="padding:5px;text-align:center"><select name="part_13" id="part_13" onchange="avg()">



		  <option selected="selected" disabled="disabled">..Select One..</option>



		<option <?=($part_13==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_13==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_13==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_13==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_13==4)? 'selected' : ''?>>4</option>







		</select></td>
<?php */?>


	   </tr>







	   <tr>



		<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Motivation of Staff</span> </th>



		<td style="padding:5px;">13. Is a positive role model for other staff.<br><span style="font-size:14px">অন্য কর্মীদের জন্য একজন আদর্শবান কর্মী কি না।</span></td>



		<td style="padding:5px;text-align:center"><select name="part_14" id="part_14" onchange="avg()">



		 <option selected="selected" disabled="disabled">..Select One..</option>



		<option <?=($part_14==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_14==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_14==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_14==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_14==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_14==5)? 'selected' : ''?>>5</option>









		</select></td>





	  </tr>











	  <tr>







		<td style="padding:5px;">14. Motivates team members to improve their quality of work.<br><span style="font-size:14px">দলের অন্যান্য সদস্যদের কাজের মান উন্নত করতে অনুপ্রাণিত করে কি না।</span></td>



		<td style="padding:5px;text-align:center"><select name="part_15" id="part_15" onchange="avg()">



		  <option selected="selected" disabled="disabled">..Select One..</option>



		 <option <?=($part_15==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_15==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_15==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_15==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_15==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_15==5)? 'selected' : ''?>>5</option>







		</select></td>



	   </tr>

	   

	   

	   <tr>



		<td style="padding:5px;" >Comments <br /> (Describe Each Point)</td>



		<td style="padding:5px;" colspan="2"><textarea name="part_3_comment" id="part_3_comment" cols="100" style="width:100%;" required="required"><?=$part_4_comment?></textarea></td>



	  </tr>





	    <tr style="background-color:#87CEEB">



		<td style="padding:5px; width:40%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score_1','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'" and uniq_code="'.$_GET['uniq'].'"');?>" /><strong>PART IV &nbsp;&nbsp; &nbsp; FAIRNESS</strong></td>



		<td style="padding:5px; width:10%" align="center"><strong><center>Rating</center></strong></td>



	  </tr>









	   <tr>



		<th rowspan="3"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Dependability / Responsibility</span></th>



		<td style="padding:5px;">15. Is able to work with limited supervision.<br><span style="font-size:14px">অল্পতেই কাজ বুঝিয়ে দিলে কাজ করতে সক্ষম কি না।</span></td>



		<td style="padding:5px;text-align:center"><select name="part_16" id="part_16" onchange="avg()">



		  <option selected="selected" disabled="disabled">..Select One..</option>



		 <option <?=($part_16==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_16==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_16==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_16==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_16==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_16==5)? 'selected' : ''?>>5</option>







		</select></td>



	   </tr>







	   <tr>
<?php /*?><td style="padding:5px;">Is trustworthy, responsible and reliable.<br><span style="font-size:14px">বিশ্বাসযোগ্য, দায়িত্ববান এবং নির্ভরযোগ্য কি না।</span></td>
<td style="padding:5px;text-align:center"><select name="part_17" id="part_17" onchange="avg()">
<option selected="selected" disabled="disabled">..Select One..</option>
<option <?=($part_17==0)? 'selected' : ''?>>0</option>
<option <?=($part_17==1)? 'selected' : ''?>>1</option>
<option <?=($part_17==2)? 'selected' : ''?>>2</option>
<option <?=($part_17==3)? 'selected' : ''?>>3</option>
<option <?=($part_17==4)? 'selected' : ''?>>4</option>
<option <?=($part_17==5)? 'selected' : ''?>>5</option>
</select></td><?php */?>
 </tr>







	   <tr>







		<td style="padding:5px;">16. Is adaptable and willing to accept new responsibilities.<br>

		<span style="font-size:14px">যে কোন নতুন পরিস্থিতিতে বা অবস্থায় মানিয়ে চলতে পারে এবং নতুন দায়িত্ব গ্রহণ করতে আগ্রহী কি না।</span></td>



		<td style="padding:5px;text-align:center"><select name="part_18" id="part_18" onchange="avg()">



		  <option selected="selected" disabled="disabled">..Select One..</option>



		 <option <?=($part_18==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_18==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_18==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_18==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_18==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_18==5)? 'selected' : ''?>>5</option>





		</select></td>



	   </tr>







	   <tr>



<th rowspan="2"  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Attendance/Punctuality</span></th>

<?php /*?><td style="padding:5px;">Has good attendance.<br>
<span style="font-size:14px">পর্যাপ্ত উপস্থিতি বা হাজিরা রয়েছে কি না।</span></td>
<td style="padding:5px;text-align:center"><select name="part_19" id="part_19" onchange="avg()">
<option selected="selected" disabled="disabled">..Select One..</option>
<option <?=($part_19==0)? 'selected' : ''?>>0</option>
<option <?=($part_19==1)? 'selected' : ''?>>1</option>
<option <?=($part_19==2)? 'selected' : ''?>>2</option>
<option <?=($part_19==3)? 'selected' : ''?>>3</option>
<option <?=($part_19==4)? 'selected' : ''?>>4</option>
</select></td><?php */?>

</tr>



	   <tr>







		<td style="padding:5px;">17. Is punctual and has good attendance.<br>

		<span style="font-size:14px">কর্মক্ষেত্রে সময়নিষ্ঠ  এবং পর্যাপ্ত উপস্থিতি বা হাজিরা রয়েছে কি না।</span></td>



		<td style="padding:5px;text-align:center"><select name="part_20" id="part_20" onchange="avg()">



		  <option selected="selected" disabled="disabled">..Select One..</option>



		  <option <?=($part_20==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_20==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_20==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_20==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_20==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_20==5)? 'selected' : ''?>>5</option>







		</select></td>



	   </tr>
	   
	   
	   
	   
	   
	   	<tr>
      <td style="padding:5px;font-family: Cambria,Georgia,serif; font-size: 18px;width:40%;background-color:#59B2EA" align="center" colspan="4">
	  <b>ATTENDANCE (Late and absenteeism) </b></td>
     
    </tr>
	

	
	<tr style="font-family: Cambria,Georgia,serif; font-size:18px">
     
      <td style="padding:5px;" colspan="4">Late : <?=find_a_field('salary_attendence_lock','sum(lt)','year="'.$_GET['year'].'" and PBI_ID='.$_GET['id']);?></td>
	 
 </tr>
	
	<tr style="font-family: Cambria,Georgia,serif; font-size:18px">
      <td style="padding:5px;" colspan="4">Absent : <?=find_a_field('salary_attendence_lock','sum(ab)','year="'.$_GET['year'].'" and PBI_ID='.$_GET['id']);?></td>

	  

    </tr>
	
	
	<!--Leave Status -->
	<?



$g_s_date= $_GET['year'].'-'.'01'.'-01'; //date('Y-01-01');
$g_e_date= $_GET['year'].'-'.'12'.'-31'; //date('Y-12-31');    

$hrm_leave_info=find_all_field('hrm_leave_info','','PBI_ID='.$_GET['id']);
 $leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type=1 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type=2 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type=3 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_marrige=find_a_field('hrm_leave_info','sum(total_days)','type=4 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_maternity=find_a_field('hrm_leave_info','sum(total_days)','type=5 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_paternity=find_a_field('hrm_leave_info','sum(total_days)','type=6 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_Hajj=find_a_field('hrm_leave_info','sum(total_days)','type=7 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date>="'.$g_s_date.'" and half_leave_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_EOL=find_a_field('hrm_leave_info','sum(total_days)','type=8 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_compensatory=find_a_field('hrm_leave_info','sum(total_days)','type="Compensatory Off" and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$leave_days_lwp=find_a_field('hrm_leave_info','sum(total_days)','type=9 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$dayoff=find_a_field('hrm_leave_info','sum(total_days)','type=10 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);
$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$leave_id);
$designation=find_all_field('designation','DESG_DESC','DESG_ID='.$personnel_basic_info->PBI_DESIGNATION);
$department=find_all_field('department','DEPT_DESC','DEPT_ID='.$personnel_basic_info->PBI_DEPARTMENT);
$hrm_leave_rull_manage=find_all_field('hrm_leave_rull_manage','','id='.$personnel_basic_info->LEAVE_RULE_ID);


?>
	
	
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#ccc">
    <tr>
    <td colspan="11"  bgcolor="#FFFFFF" style="padding:5px;font-family: Cambria,Georgia,serif; font-size: 18px;width:40%;background-color:#59B2EA">
	<div align="center" class="style1"><b>Individual Leave Status <?php echo $_GET['year'];?></b></div></td>
    </tr>

     <tr style="background:#f1f1f0" height="60">
     <td width="8%" align="center" valign="middle"><strong><span class="style10">
     <div align="center" style="margin-top:15px">Type</div></span></strong></td>
     <td width="8%" align="center" valign="middle"><strong><span class="style10">

      <div align="center" style="margin-top:15px">Casual Leave (CL)</div></span></strong></td>
      <td width="8%" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10"><div align="center">Sick Leave (SL)</div></span></strong></div></td>




      <td width="8%" align="center" valign="middle"><div align="center" style="margin-top:13px"><strong><span class="style10"><div align="center">Annual Leave (AL)</div></span></strong></div></td>



      <td width="8%" align="center" valign="middle"><strong><span class="style10">

      <div align="center" style="margin-top:15px">Short Leave (SHL)</div></span></strong></td>

	  

	   <td width="8%" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10"><div align="center"><strong>Marriage Leave</strong></div>  

      </span></strong></div></td>

	  

	  

	  <?

	      if($employee->PBI_SEX=="Female"){

	      ?>

	   <td width="10%" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Maternity Leave (ML)</span></strong></div> </td>

	   <? } else{?>

	   <td width="10%" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Paternity Leave (PL)</span></strong></div> </td>

	   <? } ?>

	  

	   <td width="10%" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Hajj Leave </span></strong></div></td>
	   
	   <td width="3%" align="center" valign="middle"><div align="center" style="margin-top:15px"><strong><span class="style10">Dayoff</span></strong></div></td>
	   


	  





      <td width="10%" align="center" valign="middle"><div align="center"><strong><span class="style10"><div align="center">Leave <br> 



      Without Pay (LWP)</div></span></strong></div></td>







      <td width="11%" align="center" valign="middle"><div align="center"><strong><span class="style10"><div align="center" style="margin-top:10px">Extra Ordinary Leave (EOL)</div></span></strong></div></td>

    </tr>

	

	

    <tr align="center">



      <td width="8%" height="10" align="center"  bgcolor="#FFFFFF"><div align="center" style="margin-top:15px;"><span class="style4"><strong>Entitlement</strong></span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF" ><div align="center" style="margin-top:20px;"><?=$casual=find_a_field('hrm_leave_type','yearly_leave_days','id=1');?></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;"><?=$sick_leave=find_a_field('hrm_leave_type','yearly_leave_days','id=2');?></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><div align="center" style="margin-top:15px;">


<?=$annual=find_a_field('hrm_leave_type','yearly_leave_days','id=3');?></div>



      </span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:15px;"><span class="style4">24</span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;"><?=$marrage=find_a_field('hrm_leave_type','yearly_leave_days','id=4');?></div></td>

 

  



      <?

	      if($employee->PBI_SEX=="Female"){

	      ?>

      <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;"><?=$Maternity=find_a_field('hrm_leave_type','yearly_leave_days','id=5');?></div></td>

   <? }else{?>

      <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;"><?=$paternity=find_a_field('hrm_leave_type','yearly_leave_days','id=6');?></div></td>

   <? } ?>

   

   <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;"><?=$hajj=find_a_field('hrm_leave_type','yearly_leave_days','id=7');?></div></td>

   <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:20px;"></div></td>

   <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"></span></div></td>
   <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center">As per Management Approval </div></td>
   
    

    </tr>



    <tr>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4"><strong>Availed</strong></span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">



        <?=$leave_days_casual?>



      </span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">



        <?=$leave_days_sick?>



      </span></div></td>




      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=$leave_days_annual?>

      </span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><?=$leave_days_half?></div></td>

	         <td width="125" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><?=$leave_days_marrige?></div></td>

			  <?

	      if($employee->PBI_SEX=="Female"){

	      ?>

      <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_maternity?></div></td>

     <? }else{ ?>

      <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_paternity?></div></td>

	  <? } ?>

      

      <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_Hajj?></div></td>


      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$dayoff?></div></td>


      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><?=$leave_days_lwp?></div></td>

     

   



      <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$leave_days_EOL?></span></div></td>

    </tr>



    <tr style="font-weight:bold;">



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><strong>Balance</strong></span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">



        <?=$casual-$leave_days_casual?>



      </span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">



        <?=$sick_leave-$leave_days_sick?>



      </span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">



        <?=$annual-$leave_days_annual?>



      </span></div></td>



      <td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4"><?=24-$leave_days_half?></span></div></td>

	  

	  <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" ><span class="style4">

        <?=$marrage-$leave_days_marrige?>

      </div></td>

	  

	   <?

	      if($employee->PBI_SEX=="Female"){

	      ?>

      <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$Maternity-$leave_days_maternity?></span></div></td>

   <? }else{ ?>

      <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$paternity-$leave_days_paternity?></span></div></td>

	  <? } ?>
<td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$hajj-$leave_days_Hajj?></span></div></td>
<td width="8%" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"></span></div></td>


      <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"></span></div></td>
	  
	   <td width="8%" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center"><span class="style4"><?=$leave_days_EOL?></span></div></td>

    </tr>



	



	<tr bgcolor="#2299C3">



      <td width="8%" height="23" align="center" valign="middle"><div align="center"></div></td>



      <td width="8%" align="center" valign="middle"><div align="center"><span class="style9"></span></div></td>



      <td width="8%"  ><div align="center"><span class="style9"></span></div></td>



      <td width="8%"  ><span class="style9"></span></td>



      <td width="8%" ><span class="style9"></span></td>



      <td width="8%"  ><span class="style9"></span></td>



      <td width="8%"  >&nbsp;</td>



      <td width="8%"  >&nbsp;</td>



      <td width="8%" >&nbsp;</td>
      <td width="8%"  >&nbsp;</td>
	  <td width="8%"  >&nbsp;</td>

    </tr>


</table>
	
	
<!-- Leave STATUS OFFFFFF -->

	
	   



   <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" style="font-size:16px;">


	   

	   <tr>



		<td style="padding:5px;" >Comments <br /> (Describe Each Point)</td>



		<td style="padding:5px;" colspan="2"><textarea name="part_4_comment" id="part_4_comment" cols="100" style="width:100%;" required="required"><?=$part_4_comment?></textarea></td>



	  </tr>

	   

	   

	   

	   <!--ADD New Section part v -->

	    <tr style="background-color:#87CEEB">



		<td style="padding:5px; width:40%" align="center" colspan="2"><input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" /><input type="hidden" name="pre_score" id="pre_score" value="<?=find_a_field(' performance_appraisal','total_score_1','PBI_ID="'.$_GET['id'].'" and year="'.$_GET['year'].'" and uniq_code="'.$_GET['uniq'].'"');?>" /><strong>PART V &nbsp;&nbsp; &nbsp; BEHAVIOUR</strong></td>



		<td style="padding:5px; width:10%" align="center"><strong><center>Rating</center></strong></td>



	  </tr>

	  

	  

	  <tr>



		<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Politeness/Respect</span></td>



		<td style="padding:5px;">18. Able to stay polite in any interaction and treat everybody with respect.<br>

		<span style="font-size:14px">যেকোনো পরিস্থিতিতে মার্জিত এবং সবার সাথে সম্মানের সাথে আচরণ করতে সক্ষম কি না।</span></td>



		<td style="padding:5px;text-align:center"><select name="part_23" id="part_23" onchange="avg()">



		  <option selected="selected" disabled="disabled">..Select One..</option>



		  <option <?=($part_23==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_23==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_23==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_23==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_23==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_23==5)? 'selected' : ''?>>5</option>









		</select></td>



	   </tr>

	   

	   

	   

	   

	   

	   <tr>



		<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Cooperation</span></td>



		<td style="padding:5px;">19. Willingness to work harmoniously with others in getting a job done.<br>

		<span style="font-size:14px">একটি কাজ সম্পন্ন করার জন্য অন্যদের সাথে তাল মিলিয়ে চলার ইচ্ছা শক্তি পোষণ করে কি না।</span></td>



		<td style="padding:5px;text-align:center"><select name="part_24" id="part_24" onchange="avg()">



		  <option selected="selected" disabled="disabled">..Select One..</option>



		  <option <?=($part_24==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_24==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_24==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_24==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_24==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_24==5)? 'selected' : ''?>>5</option>









		</select></td>



	   </tr>

	   

	   

	   

	   <tr>



		<td  style="padding:5px; background-color: #EAEAE8; font-weight:bold;text-align:center" ><span style="writing-mode: sideways-lr;">Emotional Intelligence</span></td>



		<td style="padding:5px;">20. Tries to understand others’ point of view before making judgments.<br>

		<span style="font-size:14px">সিদ্ধান্ত দেওয়ার আগে অন্যদের দৃষ্টিভঙ্গি বোঝার চেষ্টা করে কি না।</span></td>



		<td style="padding:5px;text-align:center"><select name="part_25" id="part_25" onchange="avg()">



		  <option selected="selected" disabled="disabled">..Select One..</option>



		  <option <?=($part_25==0)? 'selected' : ''?>>0</option>



		 <option <?=($part_25==1)? 'selected' : ''?>>1</option>



		 <option <?=($part_25==2)? 'selected' : ''?>>2</option>



	     <option <?=($part_25==3)? 'selected' : ''?>>3</option>



		 <option <?=($part_25==4)? 'selected' : ''?>>4</option>
		 
		 <option <?=($part_25==5)? 'selected' : ''?>>5</option>







		</select></td>



	   </tr>

	   

	   

	   

	   <!--END New Section part v -->







	    <tr>



		<td style="padding:5px;" >Comments <br /> (Describe Each Point)</td>



		<td style="padding:5px;" colspan="2"><textarea name="part_5_comment" id="part_5_comment" cols="100" style="width:100%;" required="required"><?=$part_5_comment?></textarea></td>



	  </tr>
	  
	  
	  <tr>



		<td style="padding:5px;" >Achievements <br /> (Only for reporting authorities)</td>



		<td style="padding:5px;" colspan="2"><textarea name="achievements" id="achievements" cols="100" style="width:100%;" required="required"><?=$achievements?></textarea></td>



	  </tr>



	   <tr>



		<td style="padding:5px;" >Total Score : </td>



		<td style="padding:5px;" colspan="2"><textarea name="total_score_2" id="total_score_2" cols="100" style="width:400px;" readonly="readonly"><?=$total_score_2?></textarea></td>



	  </tr>



	   <!--Part-2 End-->




</table>






		</table>



<br />







		<br />







<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">



    <tr>



	  <td align="center"><center><strong><input type="submit" name="submit" id="submit" value="NEXT STEP" style="background: skyblue;" /></strong></center></td>



	</tr>



</table>







		<br />







		<br />







		<br />







		<br />















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

