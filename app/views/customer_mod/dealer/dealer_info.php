<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 


$title='CUSTOMER INFORMATION';			// Page Name and Page Title







do_datatable('vendor_table');



$user_to_dealer = find_a_field('user_activity_management','dealer_code','user_id="'.$_SESSION['user']['id'].'"');



$page="dealer_info.php";		// PHP File Name















$table='dealer_info';		// Database Table Name Mainly related to this page







$unique='dealer_code';			// Primary Key of this Database table







$shown='dealer_name_e';				// For a New or Edit Data a must have data field















// ::::: End Edit Section :::::




//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);















$$unique = $_GET[$unique];







if(isset($_POST[$shown]))







{







$$unique = $_POST[$unique];







//for Insert..................................







if(isset($_POST['insert']))







{	







//if ($_POST['dealer_found']==0) {}



	







$proj_id			= $_SESSION['proj_id'];







$_POST['entry_by']=$_SESSION['user']['id'];



$_POST['entry_at']=date('Y-m-d h:i:s');







//$wh_data = find_all_field('warehouse','','warehouse_id='.$_POST['depot']); 







$_POST['ledger_group_id']=$_POST['ledger_group'];







$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group_id'])+1;



$_POST['ledger_sl'] = sprintf("%04d", $cy_id);



$_POST['account_code'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];



$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 



$_POST['ledger_name'] = $_POST['dealer_name_e'];



$crud->insert();



$ledger_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);





if ($ledger_gl_found==0) {



   $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, acc_sub_sub_class, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)



  

  VALUES("'.$_POST['account_code'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'",  

  "'.$gl_group->acc_sub_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$_POST['group_for'].'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';





db_query($acc_ins_led);



}



		



		



	



		



$type=1;







$msg='New Entry Successfully Inserted.';







unset($_POST);







unset($$unique);



















}























//for Modify..................................















if(isset($_POST['update']))







{















		$crud->update($unique);







		



		 $dealer_code =$_POST['dealer_code'];



		 $account_code = $_POST['account_code'];







	  $sql1 = 'update accounts_ledger set ledger_name="'.$_POST['dealer_name_e'].'" 



	  where ledger_id = '.$account_code;



		db_query($sql1);



















		$type=1;







		$msg='Successfully Updated.';







}







//for Delete..................................















if(isset($_POST['delete']))







{		$condition=$unique."=".$$unique;		$crud->delete($condition);







		unset($$unique);







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







if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);







?>







<script type="text/javascript">







$(function() {







		$("#fdate").datepicker({







			changeMonth: true,







			changeYear: true,







			dateFormat: 'yy-mm-dd'







		});







});







function Do_Nav()







{







	var URL = 'pop_ledger_selecting_list.php';







	popUp(URL);







}



















function DoNav(theUrl)







{







	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;







}







function popUp(URL) 







{







	day = new Date();







	id = day.getTime();







	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");







}







</script>







<style type="text/css">







<!--







.style1 {color: #FF0000}



.style2 {



	font-weight: bold;



	color: #000000;



	font-size: 14px;



}



.style3 {color: #FFFFFF}







-->







</style>































	<!--dealer info-->



	<div class="form-container_large">







		<h4 class="text-center bg-titel bold pt-2 pb-2"> <?=$title?> </h4>











		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">







			<div class="container-fluid bg-form-titel">







				<div class="row">



					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Customer Name:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">







								<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />







								<input name="group_for" required type="hidden" id="group_for" tabindex="1" value="<?=$_SESSION['user']['group'];?>">







								<input name="dealer_name_e" required type="text" id="dealer_name_e" tabindex="1" value="<?=$dealer_name_e?>">



















							</div>



						</div>







					</div>







					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Propritor Name:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="propritor_name_e" type="text" id="propritor_name_e" tabindex="2" value="<?=$propritor_name_e?>" />



							</div>



						</div>



					</div>







					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Customer Type :</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<select name="dealer_type" required id="dealer_type" tabindex="3">



									<option></option>



									<? foreign_relation('dealer_type','id','dealer_type',$dealer_type,'1');?>



								</select>







							</div>



						</div>



					</div>







					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Mobile:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="contact_no" type="text" id="contact_no" tabindex="4" value="<?=$contact_no?>" />



							</div>



						</div>



					</div>











					<!--<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">SMS Phone:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="sms_mobile_no" type="text" id="sms_mobile_no" tabindex="5" value="<?=$sms_mobile_no?>" />



							</div>



						</div>



					</div>-->















					<!--<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Fax No:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="fax_no" type="text" id="fax_no" tabindex="6" value="<?=$fax_no?>" />



							</div>



						</div>



					</div>-->











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Email:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="email" type="text" id="email" tabindex="7" value="<?=$email?>" />



							</div>



						</div>



					</div>











					<!--<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">CC Email:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="cc_email" type="text" id="cc_email" tabindex="8" value="<?=$cc_email?>"  />



							</div>



						</div>



					</div>-->











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">A/C Configuration:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">





<input name="account_code" type="text" id="account_code" tabindex="9" value="<?=$account_code?>" readonly="readonly"  style="width:95%; font-size:12px;" />



					







							</div>



						</div>



					</div>











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-end align-items-center pr-1 bg-form-titel-text">Region:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<select name="region_code" id="region_code" tabindex="9"



										onchange="getData2('dealer_zone_ajax.php', 'dealer_zone_find', this.value,  document.getElementById('region_code').value);">







									<option></option>



									<? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$region_code,'1');?>



								</select>



							</div>



						</div>



					</div>











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-end align-items-center pr-1 bg-form-titel-text">Zone:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



										<span id="dealer_zone_find">



											<select name="zone_code" id="zone_code" tabindex="9"



													onchange="getData2('dealer_area_ajax.php', 'dealer_area_find', this.value,  document.getElementById('zone_code').value);">







												<option></option>



												<? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_code,'REGION_ID="'.$region_code.'"');?>



											</select>



										</span>



							</div>



						</div>



					</div>







					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex vendor_label_text justify-content-end align-items-center pr-1 bg-form-titel-text">Area:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



										<span id="dealer_area_find">



											<select name="area_code" id="area_code" tabindex="9">







												<option></option>



												<? foreign_relation('area','AREA_CODE','AREA_NAME',$area_code,'ZONE_ID="'.$zone_code.'"');?>



											</select>



										</span>



							</div>



						</div>



					</div>











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Address:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="address_e" type="text" id="address_e" tabindex="14" value="<?=$address_e?>" />



							</div>



						</div>



					</div>











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Credit Limit:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="credit_limit" type="text" id="credit_limit" tabindex="14" value="<?=$credit_limit?>" />



							</div>



						</div>



					</div>











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Depot:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<select name="depot" required="required" id="depot" tabindex="9">



									<option></option>



									<? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'1');?>



								</select>



							</div>



						</div>



					</div>











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Contact Person:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="contact_person_name" type="text" id="contact_person_name" tabindex="16" value="<?=$contact_person_name?>" />



							</div>



						</div>



					</div>











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Job Title:</label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="contact_person_designation" type="text" id="contact_person_designation" tabindex="17" value="<?=$contact_person_designation?>" />



							</div>



						</div>



					</div>











					<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



						<div class="form-group row m-0">



							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Contact Person Phone: </label>



							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



								<input name="contact_person_mobile" type="text" id="contact_person_mobile" tabindex="18" value="<?=$contact_person_mobile?>" />







							</div>



						</div>



					</div>







				</div>











				<hr>



				<div class="n-form-btn-class">







								<? if(!isset($_GET[$unique])){?>



								<?php /*?>	<input name="insert" type="submit" id="insert" value="SAVE &amp; NEW" class="btn1 btn1-bg-submit" /><?php */?>



								<? }?>







								<? if(isset($_GET[$unique])){?>



									<input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />



								<? }?>







		<?php /*?>	<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" /><?php */?>















				</div>











			</div>



		</form>



		<?







		//if(isset($_POST['search'])){







		?>







		<div class="container-fluid pt-5 p-0 ">











			<table id="vendor_table" class="table1  table-striped table-bordered table-hover table-sm">



				<thead class="thead1">



				<tr class="bgc-info">



					<th>ID</th>



					<th>Customer Name</th>



					<th>GL Code</th>



					<th>Address</th>







					<th>Action</th>



				</tr>



				</thead>



				<tbody class="tbody1">







				<?php











				if($_POST['group_for']!="")







					$con .= 'and a.group_for="'.$_POST['group_for'].'"';







				if($_POST['depot']!="")







					$con .= 'and a.depot="'.$_POST['depot'].'"';



























				 $td='select a.'.$unique.',  a.'.$shown.',   a.address_e, a.account_code from '.$table.' a, user_group u



				where   a.group_for=u.id and a.'.$unique.'="'.$user_to_dealer.'" and a.group_for="'.$_SESSION['user']['group'].'"    '.$con.' order by a.dealer_code ';







				$report=db_query($td);







				while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>







					<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');" bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">



						<td><? foreign_relation('dealer_info','dealer_code','','dealer_code="'.$user_to_dealer.'"');?></td>







						<td style="text-align:left"><?=$rp[1];?></td>







						<td><?=$rp[3];?></td>



						<td style="text-align:left"><?=$rp[2];?></td>



						<td><input type="button" class="btn1 btn1-bg-update" value="Edit"></td>



					</tr>







				<?php }?>



				</tbody>



			</table>







		</div>







		<? //}?>



	</div>



















































<script type="text/javascript"><!--







    var pager = new Pager('grp', 10000);







    pager.init();







    pager.showPageNav('pager', 'pageNavPosition');







    pager.showPage(1);







//-->







	document.onkeypress=function(e){







	var e=window.event || e







	var keyunicode=e.charCode || e.keyCode







	if (keyunicode==13)







	{







		return false;







	}







}







</script>



















<script>











function duplicate(){







var dealer_code_2 = ((document.getElementById('dealer_code_2').value)*1);







var customer_id = ((document.getElementById('customer_id').value)*1);















   if(dealer_code_2>0)



  {



  



alert('This customer code already exists.');



document.getElementById('customer_id').value='';











document.getElementById('customer_id').focus();







  } 




}



</script>



<?

require_once SERVER_CORE."routing/layout.bottom.php";


?>