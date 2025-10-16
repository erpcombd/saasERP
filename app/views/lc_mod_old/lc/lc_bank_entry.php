<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='L/C Bank Entry';


  create_combobox('do_no');
  
     $pi_reference 		= $_REQUEST['pi_reference'];

do_calander('#invoice_date');
do_calander('#lc_expiry_date');
do_calander('#shipment_date');
do_calander('#shipment_expiry_date');
do_calander('#cover_note_date');
do_calander('#ammendment_date');

function createSubLedger($code,$name,$tr_from,$tr_id,$ledger_id,$type){

  $insert = 'insert into general_sub_ledger set sub_ledger_id="'.$code.'",sub_ledger_name="'.$name.'",tr_from="'.$tr_from.'",tr_id="'.$tr_id.'",ledger_id="'.$ledger_id.'",type="'.$type.'",entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$_SESSION['user']['id'].'",group_for="'.$_SESSION['user']['group'].'"';
db_query($insert);
return db_insert_id();

}


 $data_found = $pi_reference;

if ($data_found==0) {
 create_combobox('pi_reference');
  }

$config_all = find_all_field('config_group_class','*','group_for="'.$_SESSION['user']['group'].'"'); 	

if(prevent_multi_submit()){

if(isset($_REQUEST['confirmit']))

{


		$lc_issue_date=$_POST['invoice_date'];
		$group_for=$_SESSION['user']['group'];
		$pi_reference=$_POST['pi_reference'];
		$po_no=$_POST['po_no'];
		$ledger_group=$_POST['ledger_group'];
		$bank_lc_no=$_POST['bank_lc_no'];
		$pi_no=$_POST['pi_no'];
		$lc_expiry_date=$_POST['lc_expiry_date'];
		$tolerance=$_POST['tolerance'];
		$insurance_cover_note_no=$_POST['insurance_cover_note_no'];
		$shipment_date=$_POST['shipment_date'];
		$shipment_expiry_date=$_POST['shipment_expiry_date'];
		$lc_af_no=$_POST['lc_af_no'];
		$shipment_expiry_date=$_POST['shipment_expiry_date'];
		$bank_name=$_POST['bank_name'];
		$lc_type=$_POST['lc_type'];
		$lc_value=$_POST['lc_value'];
		$mode_of_transport=$_POST['mode_of_transport'];
		$cover_note_date=$_POST['cover_note_date'];
		$ammendment_date=$_POST['ammendment_date'];
		$remarks=$_POST['remarks'];
		
		$tenor_days=$_POST['tenor_days'];
		
		$entry_by= $_SESSION['user']['id'];
		$entry_at = date('Y-m-d H:i:s');
		
		
		
		
$ledger_gl_found = find_a_field('lc_number_setup','ledger_id','pi_reference='.$pi_reference);
$gl_group = find_all_field('ledger_group','','group_id='.$ledger_group); 		
if ($ledger_gl_found==0) {

$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$ledger_group)+1;

$_POST['ledger_sl'] = sprintf("%06d", $cy_id);




$_POST['ledger_name'] = 'Goods in Transit - L/C No. '.$bank_lc_no;

//$new_ledger_id=find_a_field('accounts_ledger','max(ledger_id)','1')+1;
$custome_codes = find_a_field('lc_number_setup','max(sub_ledger_id)','1');
if($custome_codes>0){
	$custome_code = $custome_codes+1;
	}
	else{
	$custome_code = 60000001;
	}



//      $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_sl, ledger_name, ledger_group_id,acc_class,acc_sub_class,acc_sub_sub_class,  balance_type,  proj_id)
//  
//  VALUES( "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$ledger_group.'","'.$gl_group->acc_class.'","'.$gl_group->acc_sub_class.'","'.$gl_group->acc_sub_sub_class.'", "Both", "'.$proj_id.'")';
//
//db_query($acc_ins_led);

//$last_id=db_insert_id();

//$_POST['ledger_id'] = $last_id;

        $lc_num_ins = 'INSERT INTO lc_number_setup (lc_number, ledger_group_id, ledger_id, pi_reference, po_no, group_for, lc_type, status, entry_at, entry_by,sub_ledger_id)
  
  VALUES("'.$_POST['ledger_name'].'", "'.$ledger_group.'", "'.$_POST['account_code'].'", "'.$pi_reference.'", "'.$po_no.'", "'.$_SESSION['user']['group'].'", "'.$lc_type.'", "CHECKED", "'.$entry_at.'", "'.$entry_by.'","'.$custome_code.'")';

db_query($lc_num_ins);


$lc_no_ins_id = db_insert_id();


$ledger_gl_found = find_a_field('general_sub_ledger','sub_ledger_id','sub_ledger_name='.$_POST['ledger_name']);
if ($ledger_gl_found==0) {
createSubLedger($custome_code,$_POST['ledger_name'],'LC',$lc_no_ins_id,$_POST['account_code'] ,'');
}


}

	
		
		$tr_no = next_transection_no($group_for,$lc_issue_date,'lc_bank_entry','tr_no');



	 	     $ins_invoice = 'INSERT INTO lc_bank_entry (tr_no, lc_issue_date, pi_reference_no, lc_no, lc_number, po_no, group_for, bank_lc_no, pi_no, lc_expiry_date, tolerance, insurance_cover_note_no, shipment_date, shipment_expiry_date, lc_af_no, bank_name, lc_type, lc_value, mode_of_transport, cover_note_date, ammendment_date, remarks, status, entry_at, entry_by,tenor_days)
  
  VALUES("'.$tr_no.'", "'.$lc_issue_date.'",  "'.$pi_reference.'", "'.$lc_no_ins_id.'", "'.$_POST['ledger_name'].'", "'.$po_no.'", "'.$group_for.'", "'.$bank_lc_no.'", "'.$pi_no.'", "'.$lc_expiry_date.'", "'.$tolerance.'", "'.$insurance_cover_note_no.'", "'.$shipment_date.'", "'.$shipment_expiry_date.'", "'.$lc_af_no.'", "'.$bank_name.'", "'.$lc_type.'", "'.$lc_value.'", "'.$mode_of_transport.'", "'.$cover_note_date.'", "'.$ammendment_date.'", "'.$remarks.'", "CHECKED", "'.$entry_at.'", "'.$entry_by.'","'.$tenor_days.'")';

db_query($ins_invoice);


  $up_sql = 'update lc_purchase_master set lc_no="'.$lc_no_ins_id.'" where po_no = '.$po_no;
 db_query($up_sql);
		


?>

<script language="javascript">
window.location.href = "pending_pi_for_lc.php";
</script>

<?	

}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}






?>

<script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }



	function update_value(pi_id)



	{



var pi_id=pi_id; // Rent


var lc_no=(document.getElementById('lc_no').value);


var flag=(document.getElementById('flag_'+pi_id).value); 

var strURL="lc_update_ajax.php?pi_id="+pi_id+"&lc_no="+lc_no+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+pi_id).style.display='inline';

						document.getElementById('divi_'+pi_id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	



}


function sum_sum(id){
var tot_due_amt = (document.getElementById('tot_due_amt_'+id).value)*1;

document.getElementById('payment_amt_'+id).value = tot_due_amt;

}







</script>






<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 200px;
    height: 38px;
    border-radius: 0px !important;
}


table thead  {
  / Important /
  background-color: red;
  position: sticky;
  z-index: 100;
  top: 0;
}


</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">


<? if($pi_reference>0){ ?>


<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px; text-transform:uppercase;">

								  <tr>

								 <td width="18%">LC ISSUE DATE:</td>

									<td width="18%">
											 
			<input style="width:220px; height:32px;"  name="invoice_date" type="text" id="invoice_date"  value="<?=($invoice_date!='')?$invoice_date:date('Y-m-d')?>"   required />									</td>
									<td width="16%">PI NO:</td>
									<td width="17%">
									
									<? $pi_data = find_all_field('lc_number_setup','','id='.$pi_reference); 
								
									$po_data = find_all_field('lc_purchase_master','*','pi_reference='.$pi_reference); 
						
	
									?>
									
					<input name="po_no" type="hidden" id="po_no"  readonly="" style="width:220px; height:32px;" value="<?=$po_data->po_no;?>"  required tabindex="105" />
									
					<input name="group_for" type="hidden" id="group_for"  readonly="" style="width:220px; height:32px;" value="<?=$po_data->group_for;?>"  required tabindex="105" />
					
					<input name="pi_reference" type="hidden" id="pi_reference"  readonly="" style="width:220px; height:32px;" value="<?=$pi_reference;?>"  required tabindex="105" />
									
					<input name="pi_no" type="text" id="pi_no"   style="width:220px; height:32px;" value="<?=$po_data->pi_no;?>"  readonly="" required tabindex="105" />
								</td>
									<td width="13%">COMPANY:</td>
									<td width="18%">
									
									<table>
		  	<tr>

				<td><input name="company" type="text" id="company"  readonly="" style="width:220px; height:32px;" value="<?=find_a_field('user_group','group_name','id='.$po_data->group_for); ?>"   tabindex="105" />	</td>
			</tr>
		  </table>									</td>
								  </tr>
								  
								
								  <tr>

								 <td>LC NO:</td>

									<td>

									<input name="bank_lc_no" type="text" id="bank_lc_no"   style="width:220px; height:32px;" value=""  required tabindex="105" />									</td>
									<td>shipment date:</td>
									<td>
							
									<input name="shipment_date" type="text" id="shipment_date"  style="width:220px; height:32px;" value=""  required tabindex="105" />									</td>
									<td>lc type: </td>
									<td>
									
									<select name="lc_type" id="lc_type" required="required" style="width:220px;">
									<option></option>
									  
									  <? foreign_relation('lc_type','id','lc_type',$_POST['lc_type'],'1');?>
									</select>									</td>
								  </tr>
								  
								  
								  
								  
								  <tr>

								 <td>GL Configuration:</td>

									<td>

									<select name="account_code" required="required" id="account_code" style="width:220px; font-size:12px;" tabindex="2">
	
											  <option></option>
                                              <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$account_code,'ledger_group_id in ('.$config_all->lc_goods_in_transit.','.$config_all->lc_machinary_in_transit.')'); ?>
                                            </select>	
											<?php //echo 'select * from accounts_ledger where ledger_group_id in ('.$config_all->lc_goods_in_transit.','.$config_all->lc_machinary_in_transit.')' ?>								</td>
									<td>shipment expiry date:</td>
									<td>
							
									<input name="shipment_expiry_date" type="text" id="shipment_expiry_date"  style="width:220px; height:32px;" value=""  required tabindex="105" />									</td>
									<td>lc value (usd$):</td>
									<td>
									
									<input name="lc_value" type="text" id="lc_value"  style="width:220px; height:32px;" value=""  required tabindex="105" />									</td>
								  </tr>
								  <tr>
								    <td>LC EXPIRY DATE:</td>
								    <td><input name="lc_expiry_date" type="text" id="lc_expiry_date"   style="width:220px; height:32px;" value=""  required tabindex="105" /></td>
								    <td>lc af no:</td>
								    <td><input name="lc_af_no" type="text" id="lc_af_no"  style="width:220px; height:32px;" value=""  required tabindex="105" /></td>
								    <td>mode of transport: </td>
								    <td>
									<select name="mode_of_transport" id="mode_of_transport" required="required" style="width:220px;">
									<option></option>
									  
									  <? foreign_relation('mode_of_transport','id','mode_of_transport',$_POST['mode_of_transport'],'1');?>
									</select>
									</td>
							      </tr>
								  <tr>
								    <td>tolerance:</td>
								    <td><input name="tolerance" type="text" id="tolerance"   style="width:220px; height:32px;" value=""  required tabindex="105" /></td>
								    <td>bank name:</td>
								    <td><!--<input name="bank_name" type="text" id="bank_name"  style="width:220px; height:32px;" value=""  required tabindex="105" />-->
										<select name="bank_name" id="bank_name" required="required" style="width:220px;">
											<option></option>
									  
									  <? foreign_relation('bank_sellers','bank_id','bank_name',$_POST['bank_name'],'1');?>
										</select>
									</td>
								    <td>ammendment date: </td>
								    <td><input name="ammendment_date" type="text" id="ammendment_date"  style="width:220px; height:32px;" value=""   tabindex="105" /></td>
							      </tr>
								  <tr>
								    <td>insurance cover note no: </td>
								    <td><input name="insurance_cover_note_no" type="text" id="insurance_cover_note_no"   style="width:220px; height:32px;" value=""  required tabindex="105" /></td>
								    <td>cover note date: </td>
								    <td><input name="cover_note_date" type="text" id="cover_note_date"  style="width:220px; height:32px;" value=""  required tabindex="105" /></td>
								    <td>REMARKS:</td>
								    <td><input name="remarks" type="text" id="remarks"  style="width:220px; height:32px;" value=""   tabindex="105" /></td>
							      </tr>
								  <tr>
								    <!--<td>Bill of Entry: </td>
								    <td><input name="bill_entry" type="text" id="bill_entry"   style="width:220px; height:32px;" value=""  required tabindex="105" /></td>-->
								    <td>Tenor: </td>
								    <td><select name="tenor_days" id="tenor_days" required style="width:220px;">
	
										<option></option>
								
										 <? foreign_relation('tenor_days','tenor_days','tenor_type',$tenor_days,'1 order by id');?>
									</select></td>
								    
							      </tr>
								</table>

    </div>
	
	<? }?>



<? if($pi_reference>0){ ?>


<br /> <br />

<table width="100%" border="0">






<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirmit" type="submit" class="btn1" value="SAVE & NEW" style="width:220px; font-weight:bold; float:right; background:#6699FF; font-size:12px; height:30px; color: #000000;" /></td>

</tr>



</table>




<? }?>








<p>&nbsp;</p>

</form>

</div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>