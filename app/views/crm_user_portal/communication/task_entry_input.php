<?php

//



 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 

$title='Daily Task Entry';			// Page Name and Page Title

$page="task_entry.php";		// PHP File Name

$input_page="task_entry_input.php";

$root='communication';



$table='crm_comunication';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='overcome';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::







$crud      =new crud($table);

$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{





$$unique = $_POST[$unique];





if(isset($_POST['insert'])|| isset($_POST['insertn']))

{		



if($_FILES['comm_file']['tmp_name']!=''){







			$file_name= $_FILES['comm_file']['name'];







			$file_tmp= $_FILES['comm_file']['tmp_name'];







			$ext=end(explode('.',$file_name));







			$path='../../../crm_mod/files/';

            $random = rand();



            $upload_files = $path.$random.'.'.$ext;

			move_uploaded_file($file_tmp, $path.$random.'.'.$ext);







			}

			

			





$now		= time();



$_POST['attachment'] = $upload_files;

$_POST['entry_by'] = $_SESSION['employee_selected'];

$_POST['total_bill'] = $_POST['bus_bill']+$_POST['cng_bill']+$_POST['others_bill']+$_POST['food_bill']+$_POST['rickshaw_bill']+$_POST['bike_bill'];





$crud->insert();









$_POST['id'] = find_a_field('crm_comunication','max(id)','1');





$pbi_id = $_POST['PBI_ID'];

$tot_r_pbi =  count($_POST['PBI_ID']);

$total_bill = $_POST['total_bill'];



if($total_bill>0){

$jv_no=next_journal_sec_voucher_id();

$proj_id = 'Whiteshell';

$jv_date = $_POST['c_date']; 

$conveyance_ledger = find_a_field('config_group_class','conveyance_ledger','id="'.$_SESSION['user']['group'].'"');

$employee_name = find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_SESSION['employee_selected'].'"');

$narration_dr = 'Conveyance For '.$employee_name.', Date '.$jv_date.'';

$tr_from = 'Conveyance';

$tr_no = $_POST['id'];

$group_for = $_SESSION['user']['group'];

$employee_ledger = '10207000100000002';

//add_to_sec_journal($proj_id, $jv_no, $jv_date, $conveyance_ledger, $narration_dr, $total_bill, '0', $tr_from, $tr_no,'', $tr_id,$cc_code,$group_for);

//add_to_sec_journal($proj_id, $jv_no, $jv_date, $employee_ledger, $narration_dr, 0, $total_bill, $tr_from, $tr_no,'', $tr_id,$cc_code,$group_for);



}





$type=1;

$msg='New Entry Successfully Inserted.';



if(isset($_POST['insert']))

{

echo 'Bimol';

echo '<script type="text/javascript">

parent.parent.document.location.href = "../'.$root.'/'.$page.'";

</script>';

}

unset($_POST);

unset($$unique);





}





//for Modify..................................



if(isset($_POST['update']))

{



$pbi_id = $_POST['PBI_ID'];

$tot_r_pbi =  count($_POST['PBI_ID']);









if($_FILES['comm_file']['tmp_name']!=''){







			$file_name= $_FILES['comm_file']['name'];







			$file_tmp= $_FILES['comm_file']['tmp_name'];







			$ext=end(explode('.',$file_name));







			$path='../../../../crm_com_file/';







			move_uploaded_file($file_tmp, $path.$$unique.'.pdf');







			}











if($tot_r_pbi>0){



$delete = 'delete from crm_com_detail_emp where com_id="'.$_POST['id'].'"';

db_query($delete);



for($i=0;$i<$tot_r_pbi;$i++){

if($pbi_id[$i]>0){



$selects = 'select * from personnel_basic_info where PBI_ID="'.$pbi_id[$i].'" ';

$querys = db_query($selects);

$result = mysqli_fetch_object($querys);



$project_name = find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$result->PROJECT_ID.'"');





$insert = 'insert into crm_com_detail_emp set com_id="'.$_POST['id'].'", PROJECT_DESC="'.$project_name.'",project_desg="'.$result->project_desg.'",project_dept="'.$result->project_dept.'" ,  PBI_ID="'.$pbi_id[$i].'", entry_by="'.$_SESSION['employee_selected'].'"';

db_query($insert);

}



}

}







$unassign = $_POST['unassign'];

$tot_r_unass =  count($_POST['unassign']);



if($tot_r_unass>0){



$delete = 'delete from crm_com_detail_unassign where com_id="'.$_POST['id'].'"';

db_query($delete);



for($i=0;$i<$tot_r_unass;$i++){

if($unassign[$i]>0){



$selects = 'select * from crm_customer_info where dealer_code="'.$unassign[$i].'" ';

$querys = db_query($selects);

$result = mysqli_fetch_object($querys);



$project_name = find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$result->PROJECT_ID.'"');





 $insert = 'insert into crm_com_detail_unassign set com_id="'.$_POST['id'].'", PROJECT_DESC="'.$project_name.'",project_desg="'.$result->project_desg.'",project_dept="'.$result->project_dept.'" ,  dealer_code="'.$unassign[$i].'", entry_by="'.$_SESSION['employee_selected'].'"';

db_query($insert);

}



}

}









$dealer_code = $_POST['dealer_code'];

$tot_r_ar =  count($_POST['dealer_code']);



if($tot_r_ar>0){



$delete = 'delete from crm_com_detail where com_id="'.$_POST['id'].'"';

db_query($delete);



for($i=0;$i<$tot_r_ar;$i++){

if($dealer_code[$i]>0){



$selects = 'select * from crm_customer_info where dealer_code="'.$dealer_code[$i].'" ';

$querys = db_query($selects);

$result = mysqli_fetch_object($querys);



$project_name = find_a_field('crm_project','PROJECT_DESC','PROJECT_ID="'.$result->PROJECT_ID.'"');





$insert = 'insert into crm_com_detail set com_id="'.$_POST['id'].'", PROJECT_DESC="'.$project_name.'",project_desg="'.$result->project_desg.'",project_dept="'.$result->project_dept.'" ,  dealer_code="'.$dealer_code[$i].'", entry_by="'.$_SESSION['employee_selected'].'"';

db_query($insert);

}



}

}



$_POST['update_by'] = $_SESSION['employee_selected'];

$_POST['update_at'] = date('Y-m-d H:i:s');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

				echo '<script type="text/javascript">

parent.parent.document.location.href = "../'.$root.'/'.$page.'";

</script>';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		echo '<script type="text/javascript">

parent.parent.document.location.href = "../'.$root.'/'.$page.'";

</script>';

		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

//if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);



if($$unique>0){

    

  //  $attribute = 'readonly="readonly"';

}else{

    

    $attribute = '';

}



?>

<html style="height: 100%;"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

        

        <link href="../../css/css.css" rel="stylesheet">

		<link rel="stylesheet" href="bootstrap-select.min.css">

		<link rel="stylesheet" href="bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		

		<style>

		.openerp .oe_form .oe_form_group {

		margin-top: 0px !important;

}

.openerp td{

padding: 5px;

}



.openerp .oe_form input[type="text"], .openerp .oe_form input[type="password"], .openerp .oe_form input[type="file"], .openerp .oe_form select, .openerp .oe_form textarea{

padding: 3px;

}

		

		

		.bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){

		width: 100%;

		

		}

		.btn{

		padding: 3px;

		}

		

		.bootstrap-select .dropdown-toggle .filter-option-inner-inner{

		width: 330px;

		}

		.open>.dropdown-menu{

		width: 200px;

		}

		</style>

		

		

		

<script src="bootstrap.min.js"></script>

<script src="jquery-1.11.1.min.js"></script>

		<script type="text/javascript">

		

$(document).ready(function(){

    $('#lead_no').on('change',function(){

	var links = '';

	

	var uniques = "<?=$_GET['id']?>";

	

	if(uniques!=''){

	var sr_link = "communication_input.php?lead_no=" + $(this).val()+ " & id=" + uniques;

window.location = sr_link;

	}else{

	var sr_link = "communication_input.php?lead_no=" + $(this).val();

window.location = sr_link;

}

    });

});

</script>









		</head>

<body>

        <!--[if lte IE 8]>

        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>

        <script>CFInstall.check({mode: "overlay"});</script>

        <![endif]-->

       <form action="" method="post" enctype="multipart/form-data"> <div class="ui-dialog ui-widget ui-widget-content ui-corner-all oe_act_window ui-draggable ui-resizable openerp" style="outline: 0px none;  position: absolute; height: auto; width: 900px; display: block; /* [disabled]left: 217.5px; */ left: 16px; top: 21px;" tabindex="-1" role="dialog" aria-labelledby="ui-id-19">

          <? include('../../common/title_bar_popup.php');?>

      <div style="display: block; max-height: 464px; overflow-y: auto; width: auto; min-height: 82px; height: auto;" class="ui-dialog-content ui-widget-content" scrolltop="0" scrollleft="0">



            <div style="width:100%" class="oe_popup_form">

              <div class="oe_formview oe_view oe_form_editable" style="opacity: 1;">

                <div class="oe_form_buttons"></div>

                <div class="oe_form_sidebar" style="display: none;"></div>

                <div class="oe_form_container">

                  <div class="oe_form">

                    <div class="">

                      <? include('../../common/input_bar.php');?>

                      <div class="oe_form_sheetbg">

                        <div class="oe_form_sheet oe_form_sheet_width">

        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">

    </label>

          </h1><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr class="oe_form_group_row">

            <td class="oe_form_group_cell">

			

			<table width="100%" height="231" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">

              <tbody>

			

                <tr class="oe_form_group_row">

                  <td height="33" colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                  <td class="oe_form_group_cell oe_form_group_cell_label"> <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" /><input type="hidden"name="status" id="status" value="PENDING"></td>

                  <td height="33" colspan="1"  class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                  <td class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                </tr>

                

                <tr class="oe_form_group_row">

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Customer Name </td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">

				 

				  <select name="customer_name" id="customer_name" style="width:205px" class="selectpicker"   data-live-search="true" >

				  <? foreign_relation('crm_customer_info','dealer_code','organization',$customer_name)?>

				  </select>

				   </td>

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Service/Topic</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">

				  

				  

				  <input name="service_name" id="service_name"  class="form-control" value="<?=$service_name?>" style="width: 205px;" >

				  </td>

                </tr>

                <tr class="oe_form_group_row">

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Contact Person </td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">

				  

				  

				  

				  

				  <input name="contact_person" id="contact_person"  style="width:205px;" value="<?=$contact_person?>" class="form-control" ></td>

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Attachment</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">

				  <input type="file" name="comm_file" id="comm_file" class="form-control">				  </td>

                </tr>

				

				<tr class="oe_form_group_row">

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Feedback</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">

				 

				  <input name="overcome" id="overcome"  style="width:205px;" value="<?=$overcome?>" class="form-control" ></td>

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Lead Status</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">

				  <select name="lead_status" id="lead_status" class="form-control">

				    <option>Positive</option>

					<option>Negative</option>

				  </select></td>

                </tr>

				

				<tr class="oe_form_group_row">

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">From Address</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">

				 

				  <input name="from_address" id="from_address"  style="width:205px;" value="<?=$from_address?>" class="form-control" ></td>

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">To Address</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input name="to_address" id="to_address"  style="width:205px;" value="<?=$to_address?>" class="form-control" ></td>

                </tr>

                

                <!--<tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Headline: </td>

                  <td colspan="3" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"> <input type="text" name="c_reason" id="c_reason" value="<?=$c_reason?>" class="form-control" style="width: 650px;"> </td>

                  </tr>-->

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Remarks : </td>

                  <td colspan="3" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><textarea name="c_detail" id="c_detail" style="width: 650px; height: 80px" ><?=$c_detail?></textarea></td>

                  </tr>

				  

				  <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Bus Bill</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="text" name="bus_bill" id="bus_bill" value="<?=$bus_bill?>"  style="width:150px;" onChange="cal()" <?=$attribute?> ></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">CNG Bill </td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="text" name="cng_bill" id="cng_bill"  value="<?=$cng_bill?>"  width="150px" onChange="cal()" <?=$attribute?>></td>

                </tr>

				

				<tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Rickshaw</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="text" name="rickshaw_bill" id="rickshaw_bill" value="<?=$rickshaw_bill?>"  style="width:150px;" onChange="cal()" <?=$attribute?> ></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Bike</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="text" name="bike_bill" id="bike_bill"  value="<?=$bike_bill?>"  width="150px" onChange="cal()" <?=$attribute?>></td>

                </tr>

				

				<tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Other Transport Bill</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="text" name="others_bill" id="others_bill" value="<?=$others_bill?>"  style="width:150px;" onChange="cal()" <?=$attribute?> ></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Food Bill </td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="text" name="food_bill" id="food_bill"  value="<?=$food_bill?>"  width="150px" onChange="cal()" <?=$attribute?>></td>

                </tr>

				

				<tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Total Bill</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="text" name="total_bill" id="total_bill" value="<?=$total_bill?>"  style="width:150px; font-weight:bold;" readonly="readonly" ></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                </tr>

				

                <tr class="oe_form_group_row">

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Time </td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="time" name="c_time" id="c_time" value="<?=$c_time?>"  style="width:150px;" ></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">Date </td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"><input type="date" name="c_date" id="c_date"  value="<?=$c_date?>"  width="150px" required></td>

                </tr>

                <!--<tr class="oe_form_group_row">

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                </tr>

                <tr class="oe_form_group_row">

                  <td height="33" colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label"></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                </tr><tr class="oe_form_group_row">

                  <td height="33" colspan="4" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>

                  </tr>-->

				  <tr><td colspan="4">&emsp;</td></tr>

				  <tr><td colspan="4">&emsp;</td></tr>

				  

				  <tr>

				  

				  <td colspan="2"  width="500">

				  

				  				  </td>

				  <td colspan="2">

				  

				  				  </td>

				  </tr>

				  

				  <tr>

				  <td></td>

				  <td colspan="2">

				  

				  				  </td>

				  <td></td>

				  </tr>

                </tbody></table>

				

				

						

			<div class="row clearfix">

    	<div class="col-md-12 table-responsive">







			

			

			<table width="100%">

			

			<tr>

			

			<td>

			

			

			</td>

			<td>

			

			

			

			</td>

			

			</tr>

			

			<tr>

			

			<td colspan="2">

			

			

			</td>

			

			

			</tr>

			</table>

			

			

			

			

		</div>

	</div>

			

			

			

				

				

<br><br><br><br><br><br><br><br><br></td>

            </tr></tbody></table>

                        </div>

                      </div>

                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div class="ui-resizable-handle ui-resizable-n" style="z-index: 1000;"></div>

          <div class="ui-resizable-handle ui-resizable-e" style="z-index: 1000;"></div>

          <div class="ui-resizable-handle ui-resizable-s" style="z-index: 1000;"></div>

          <div class="ui-resizable-handle ui-resizable-w" style="z-index: 1000;"></div>

          <div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se ui-icon-grip-diagonal-se" style="z-index: 1000;"></div>

          <div class="ui-resizable-handle ui-resizable-sw" style="z-index: 1000;"></div>

          <div class="ui-resizable-handle ui-resizable-ne" style="z-index: 1000;"></div>

          <div class="ui-resizable-handle ui-resizable-nw" style="z-index: 1000;"></div>

          <div class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">



          </div>

        </div>

</form>

</body>



<script>



 function cal(){

  var bus_bill = (document.getElementById('bus_bill').value)*1;

  var cng_bill = (document.getElementById('cng_bill').value)*1;

  var others_bill = (document.getElementById('others_bill').value)*1;

  var food_bill = (document.getElementById('food_bill').value)*1;

  var rickshaw_bill = (document.getElementById('rickshaw_bill').value)*1;

  var bike_bill = (document.getElementById('bike_bill').value)*1;

  $total_bill = +bus_bill+cng_bill+others_bill+food_bill+rickshaw_bill+bike_bill;

  document.getElementById('total_bill').value = $total_bill;

 }

</script>

<script src="jquery.min.js"></script>

<script src="bootstraps.min.js"></script>

<script src="bootstrap-select.min.js"></script>









</html>

