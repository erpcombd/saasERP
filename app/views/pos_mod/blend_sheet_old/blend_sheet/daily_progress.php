<?php

session_start();

ob_start();



require_once "../../../assets/support/inc.all.php";



$title='Record Daily Progress';

$page = "daily_progress.php";

$ajax_page = "daily_progress_ajax.php";

$page_for = 'Daily Progress';

do_calander('#entry_date');
do_calander('#target_finish_date');


$table_master='cons_daily_progress_master';

//$table_details='cons_daily_progress_details';

$unique='id';





if(isset($_POST['new']))

{

		$crud   = new crud($table_master);



		if(!isset($_SESSION[$unique])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;

		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}



$$unique=$_SESSION[$unique];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		$crud   = new crud($table_details);

		$condition=$unique."=".$$unique;		

		$crud->delete_all($condition);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Deleted.';

}



if($_GET['del']>0)

{

		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		

		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";

		mysql_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

		

}

if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='UNCHECKED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';

}



if(isset($_POST['add1']))

{

		$crud   = new crud('cons_daily_progress_worker_details');

		

		$_POST['entry_by']=$_SESSION['user']['id'];

		echo $_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);

}


if(isset($_POST['add2']))

{

		$crud   = new crud('cons_daily_progress_purchase_details');

		

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);

}



if(isset($_POST['add3']))

{

		$crud   = new crud('cons_daily_progress_material_details');

		

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);

}



if(isset($_POST['add4']))

{

		$crud   = new crud('cons_daily_progress_work_details');
		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);

}





if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update OS Information'; else $btn_name='Initiate OS Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item_id');

?>

<script language="javascript">

function focuson(id) {

  if(document.getElementById('item_id').value=='')

  document.getElementById('item_id').focus();

  else

  document.getElementById(id).focus();

}

window.onload = function() {

if(document.getElementById("warehouse_id").value>0)

  document.getElementById("item_id").focus();

  else

  document.getElementById("req_date").focus();

}

</script>

<script language="javascript">

function count(){
var num=(((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1))+((document.getElementById('tov_purchase_cost').value)*1);

document.getElementById('amount').value = num.toFixed(2);	
}


</script>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>


<div class="form-container_large">

<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td valign="top"><fieldset>

    <? $field='id';?>

      <div>

        <label for="<?=$field?>"> ID: </label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>

      </div>

	<? $field='entry_date'; if($date=='') $date =date('Y-m-d'); ?>

      <div>

        <label for="<?=$field?>">Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>

    <? $field='location';?>

      <div>

        <label for="<?=$field?>">Location:</label>

        <!--<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />-->
		
		
		<select name="<?=$field?>">
               <? foreign_relation('cons_location','id','location',$$field);?>
         </select>


      </div>
	  
	  
	  
	  
	  <? $field='target_work_time';?>

      <div>

        <label for="<?=$field?>">Target Work Time:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>
	  
	  
	  <? $field='target_finish_date';?>

      <div>

        <label for="<?=$field?>">Target Finish Date:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>
	  
	  
	  <? $field='worked_hour';?>

      <div>

        <label for="<?=$field?>">Worked Hour:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>
	  
	  
	  <? $field='reason';?>

      <div>

        <label for="<?=$field?>">Reason:</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

      </div>



    </fieldset></td>

    <td>

			<fieldset>

			



      <div>

        <label for="<?=$field?>">Project Name:</label>

        <!--<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />-->
		
		<select name="project_id">
               <? foreign_relation('cons_project','id','project_name',$project_id);?>
         </select>

      </div>

      <div></div>

      <? $field='supervisor_id'; ?>

      <div>

        <label for="<?=$field?>">Supervisor Name  :</label>

        <!--<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" =""/>-->
		
		<select name="<?=$field?>">
                    <? foreign_relation('cons_supervisor','id','name',$$field);?>
             </select>

      </div>

      <div>

        <? $field='time_of_arrival';?>

<div>

          <label for="<?=$field?>">Time of Arrival :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

        </div>

      </div>
	  
	  
	  <? $field='type_of_vehicle'; ?>

      <div>

        <label for="<?=$field?>">Type of Vehicle  :</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" =""/>

      </div>

      <div>

        <? $field='distance_travelled';?>

<div>

          <label for="<?=$field?>">Distance Travelled :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

        </div>

      </div>
	  
	  <? $field='client_contact_person'; ?>

      <div>

        <label for="<?=$field?>">Client Contact Person  :</label>

        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" =""/>

      </div>

      <div>

        <? $field='weather';?>

<div>

          <label for="<?=$field?>">Today's Weather :</label>

          <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />

        </div>

      </div>

			</fieldset>	</td>

  </tr>

  <tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">

      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />

    </div></td>

    </tr>

</table>

</form>

<? if($_SESSION[$unique]>0){?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">


                          <tr>
                            <td colspan="8" align="center" bordercolor="#F0F0F0" bgcolor="#3974E1"><span class="style1">Insert List of worker</span> </td>
                            <td  rowspan="3" align="center" bgcolor="#FF5828">
                              
                              <div class="button">
                                
                                <input name="add1" type="submit" id="add1" value="ADD" tabindex="12" class="update"/>                       
                            </div>						    </td>
                          </tr>
                      <tr>

                        <td align="center" bgcolor="#0099FF"><strong>Name of Worker </strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Dressed(Y/N)</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Start Time </strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>End Time </strong></td>

                        <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">TOV</span></td>
                        <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">TOV Cost </span></td>
                        <td align="center" bgcolor="#0099FF"><strong>Fooding</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Remarks</strong></td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="proj_id" type="hidden" id="proj_id" value="<?=$$unique?>"/>
<select name="worker_name">
                    <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$worker_name);?>
          </select></td>

<td align="center" bgcolor="#CCCCCC"><select name="dress" style="width:87px;">
<option value="Y">Y</option>
<option value="N">N</option>
</select></td>

<td align="center" bgcolor="#CCCCCC"><input name="start_time" type="text" class="input3" id="start_time"  style="width:50px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="finish_time" type="text" class="input3" id="finish_time"  style="width:50px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="worker_tov" type="text" class="input3" id="worker_tov"  style="width:50px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="worker_tov_cost" type="text" class="input3" id="worker_tov_cost"  style="width:50px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="fooding_expense" type="text" class="input3" id="fooding_expense" style="width:50px;"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="worker_remarks" type="text" class="input3" id="worker_remarks" style="width:90px;"/></td>
      </tr>
    </table>

					  <br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

$res='SELECT w.id, p.PBI_NAME as name, w.dress as dressed, w.start_time, w.finish_time, w.fooding_expense, w.worker_remarks,"X" FROM cons_daily_progress_worker_details w, personnel_basic_info p WHERE w.worker_name=p.PBI_ID and proj_id='.$$unique;
//echo $res;
echo link_report_add_del_auto($res,'','','');

?>

</div>

</td>

    </tr>

	
	</table>    	
<!--       -->
	

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                          <tr>
                            <td colspan="8" align="center" bordercolor="#FFFFFF" bgcolor="#3974E1"><span class="style1">Insert Local Purchase </span></td>
                            <td  rowspan="3" align="center" bgcolor="#FF5828">
                              
                              <div class="button">
                                
                                <input name="add2" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
                            </div>				        </td>
                          </tr>
                      <tr>

                        <td align="center" bgcolor="#0099FF"><strong>Description</strong></td>

                        <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">Brand</span></td>
                        <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">TOV</span></td>
                        <td align="center" bgcolor="#0099FF"><span style="font-weight: bold">TOV Cost </span></td>
                        <td align="center" bgcolor="#0099FF"><strong>Qty</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Rate</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Amount</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Purpose</strong><strong></strong></td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">


<input  name="proj_id" type="hidden" id="proj_id" value="<?=$$unique?>"/>

<!--<select name="description">
<option></option>
  <? //foreign_relation('cons_material','id','material_name',$description);?>
</select>-->
<input name="description" type="text" class="input3" id="description"  style="width:150px;" />
</td>

<td align="center" bgcolor="#CCCCCC"><input name="brand" type="text" class="input3" id="brand"  style="width:50px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="tov_purchase" type="text" class="input3" id="tov_purchase"  style="width:50px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="tov_purchase_cost" type="text" class="input3" id="tov_purchase_cost"  onkeyup="count()" style="width:50px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty" onkeyup="count()" style="width:50px;" /></td>

<td align="center" bgcolor="#CCCCCC"><input name="rate" type="text" class="input3" id="rate"  onkeyup="count()" style="width:50px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount"  style="width:50px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="purchase_remarks" type="text" class="input3" id="purchase_remarks"  style="width:90px;" /></td>
</tr>
    </table>

					  <br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

$res='SELECT d.id, d.description as material, d.brand, d.tov_purchase, d.tov_purchase_cost, d.qty, d.rate, d.amount, d.purchase_remarks,"X" FROM cons_daily_progress_purchase_details d WHERE proj_id='.$$unique;

//$res='SELECT d.id, m.material_name as material, d.brand, d.transport, d.qty, d.rate, d.amount, d.purchase_remarks,"X" FROM cons_daily_progress_purchase_details d, cons_material m WHERE m.id=d.description and proj_id='.$$unique;

//echo $res;
echo link_report_add_del_auto($res,'','6','8');

?>

</div>

</td>

    </tr>
	
	
	</table>  
	
	
	<!--        -->

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                          <tr>
                            <td colspan="4" align="center" bordercolor="#FFFFFF" bgcolor="#3974E1"><span class="style1">Insert Material Status </span></td>
                            <td  rowspan="3" align="center" bgcolor="#FF5828">
                              
                              <div class="button">
                                
                                <input name="add3" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
                            </div>				        </td>
                          </tr>
                      <tr>

                        <td align="center" bgcolor="#0099FF"><strong>Material / Particular </strong></td>

                        <td align="center" bgcolor="#0099FF"><strong> Qty </strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Available Qty </strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Purpose</strong><strong></strong></td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="proj_id" type="hidden" id="proj_id" value="<?=$$unique?>"/>
<select name="material">
<option></option>
  <? foreign_relation('item_info','item_id','item_name',$material,'sub_group_id=1096000300010000');?>
</select>
<!--<input name="material" type="text" class="input3" id="material"  style="width:320px;" />--></td>

<td align="center" bgcolor="#CCCCCC"><input name="required_qty" type="text" class="input3" id="required_qty"  style="width:100px;" /></td>

<td align="center" bgcolor="#CCCCCC"><input name="available_qty" type="text" class="input3" id="available_qty"  style="width:100px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="material_remarks" type="text" class="input3" id="material_remarks"  style="width:100px;" /></td>
</tr>
    </table>

					  <br /><br /><br /><br />





<table width="100%"  border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

$res='SELECT id, material, required_qty, available_qty, material_remarks,"X" FROM cons_daily_progress_material_details WHERE proj_id='.$$unique;

echo link_report_add_del_auto($res,'','','');

?>

</div>

</td>

    </tr>
	
	
	
	</table>  
	
	
	
	<!--          -->	
	
	
	
	
	<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                          <tr>
                            <td colspan="5" align="center" bordercolor="#FFFFFF" bgcolor="#3974E1"><span class="style1">Insert Work Progress </span></td>
                            <td  rowspan="3" align="center" bgcolor="#FF5828">
                              
                              <div class="button">
                                
                                <input name="add4" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
                            </div>				        </td>
                          </tr>
                      <tr>

                        <td align="center" bgcolor="#0099FF"><strong>Particular</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Location</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Percentage Done Today </strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Target of Tomorrow </strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Purpose</strong><strong></strong></td>
      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="proj_id" type="hidden" id="proj_id" value="<?=$$unique?>"/>

<input name="particular" type="text" class="input3" id="particular"  style="width:200px;" /></td>

<td align="center" bgcolor="#CCCCCC"><input name="location" type="text" class="input3" id="location"  style="width:150px;" /></td>

<td align="center" bgcolor="#CCCCCC"><input name="percentage_done_today" type="text" class="input3" id="percentage_done_today"  style="width:75px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="target_of_tomorrow" type="text" class="input3" id="target_of_tomorrow"  style="width:75px;" /></td>
<td align="center" bgcolor="#CCCCCC"><input name="work_remarks" type="text" class="input3" id="work_remarks"  style="width:100px;" /></td>
</tr>
    </table>

					  <br /><br /><br /><br />





<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <tr>

      <td>

<div class="tabledesign2">

<? 

$res='SELECT particular,location,percentage_done_today,target_of_tomorrow,work_remarks,"X" FROM cons_daily_progress_work_details WHERE proj_id='.$$unique;

echo link_report_add_del_auto($res,'',1,5);

?>

</div>

</td>

    </tr>
	
	
	
				



  </table>

</form>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

      <td align="center">&nbsp;</td>

      <td align="center">



      <input name="confirmm" type="submit" class="btn1" value="CONFIRM AND FORWARD OS" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />



      </td>

    </tr>

  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once "../../../assets/template/layout.bottom.php";

?>