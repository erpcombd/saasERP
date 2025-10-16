<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Customer Information Setup';

$proj_id=$_SESSION['proj_id'];

//$inventory=find_a_field('config_group_class','inventory',"1");

do_datatable('table_head');

$now=time();

$unique='customer_id';

$unique_field='customer_name';

$table='service_customer';

$page="bill_info.php";

$crud=new crud($table);

$$unique = $_GET[$unique];



if(isset($_POST[$unique_field]))

{

$$unique = $_POST[$unique];

//for Record..................................



if(isset($_POST['record']))

{		

$_POST['entry_at']=date('Y-m-d H:i:s');

$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['ledger_name'] = $_POST['customer_name'];

$_POST['ledger_group_id']=$_POST['ledger_group'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$cy_id  = find_a_field('accounts_ledger','max(ledger_sl*1)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%05d", $cy_id);

$_POST['ledger_id'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];

$ledger_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);

if ($ledger_gl_found==0) {

   $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)

  

  VALUES("'.$_POST['ledger_id'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$_SESSION['user']['group'].'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';



db_query($acc_ins_led);

}



$crud->insert();



$type=1;



$msg='New Entry Successfully Inserted.';



unset($_POST);



unset($$unique);



}











//for Modify..................................







if(isset($_POST['modify']))



{

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['ledger_name'] = $_POST['customer_name'];
if($_POST['ledger_group']>0){
$_POST['ledger_group_id']=$_POST['ledger_group'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$cy_id  = find_a_field('accounts_ledger','max(ledger_sl*1)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%05d", $cy_id);

$_POST['ledger_id'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];

$ledger_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);

if ($ledger_gl_found==0) {

   $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)

  

  VALUES("'.$_POST['ledger_id'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$_SESSION['user']['group'].'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';



db_query($acc_ins_led);

}
}

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

}



//for Delete..................................







if(isset($_POST['delete']))



{		

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

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



?>



<script type="text/javascript">

function Do_Nav()

{

	var URL = 'pop_ledger_selecting_list.php';

	popUp(URL);

}

$(document).ready(function(){

	

	$("#form1").validate();	

});	

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

.style1 {color: #FFFFFF}

-->

</style>







<div class="container-fluid">

	<div class="row">

		<div class="col-sm-7">

			<div class="container p-0">

				<form id="form1" class="n-form1" name="form1"  method="post" action="">



					<div class="form-group row m-0 pl-3 pr-3">

						<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company</label>

						<div class="col-sm-9 p-0">

							<select name="group_for" required id="group_for" tabindex="7">



								<? foreign_relation('user_group','id','group_name',$group_for,'

															  id="'.$_SESSION['user']['group'].'"');?>

							</select>

						</div>

					</div>



					<div class="n-form-btn-class">

						<input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />

						<input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear" />

					</div>

				</form>

			</div>





			<div class="container n-form1">



				<table id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">

					<thead>

					<tr class="bgc-info">

						<th><span>SL</span></th>

						<th><span>Customer Name</span></th>
						<th><span>Short Name</span></th>
						<th><span>Customer Type</span></th>

						<th><span>Phone No.</span></th>

						<th><span>Address</span></th>

					</tr>

					</thead>



					<tbody>



					<?php





					if($_POST['group_for']!="")



						$con .= 'and b.group_for="'.$_POST['group_for'].'"';







					$rrr = "select * from service_customer where 1";



					$report = db_query($rrr);

					$i=0;

					while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

						<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

							<td><?=++$j;?></td>

							<td><?=$rp[1];?></td>
							<td><?=$rp[2];?></td>
							<td><?=$rp[3];?></td>
							<td><?=$rp[5];?></td>

							<td><?=$rp[4];?></td>

						</tr>

					<?php }?>





					</tbody>

				</table>





			</div>



		</div>





		<div class="col-sm-5 ">

			<form id="form1" class="n-form" name="form1" method="post" action="" onsubmit="return check()">

				<h4 align="center" class="n-form-titel1 text-uppercase"><?=$title?></h4>



				<div class="form-group row m-0 pl-3 pr-3 p-1 ">

					<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Customer Name </label>

					<div class="col-sm-9 p-0">

						<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

						<input name="customer_name" type="text" id="customer_name" value="<?php echo $customer_name;?>" required />

						<input name="group_for" type="hidden" id="group_for" value="<?php echo $_SESSION['user']['group'];?>" class="required" />

					</div>

				</div>



				<div class="form-group row m-0 pl-3 pr-3 p-1">

					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Short Name</label>

					<div class="col-sm-9  p-0">

						<input name="short_name" type="text" id="short_name" value="<?php echo $short_name;?>" required />

					</div>

				</div>

				<div class="form-group row m-0 pl-3 pr-3 p-1">

					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Customer Type</label>

					<div class="col-sm-9  p-0">

						<select name="cus_type" id="cus_type" required >
								<option></option>
								<option value="ERP"<?=$cus_type=='ERP'?'selected':''?>>ERP</option>
								<option value="Robi" <?=$cus_type=='Robi'?'selected':''?>>Robi</option>
						</select>

					</div>

				</div>

				<div class="form-group row m-0 pl-3 pr-3 p-1">

					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Phone No.</label>

					<div class="col-sm-9  p-0">

						<input name="phone_no" type="text" id="phone_no" value="<?php echo $phone_no;?>" class="required" />

					</div>

				</div>

                

                <div class="form-group row m-0 pl-3 pr-3 p-1">

					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Email</label>

					<div class="col-sm-9  p-0">

						<input name="email" type="text" id="email" value="<?php echo $email;?>" class="required" />

					</div>

				</div>

                

                <div class="form-group row m-0 pl-3 pr-3 p-1">

					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Address</label>

					<div class="col-sm-9  p-0">

						<input name="address" type="text" id="address" value="<?php echo $address;?>" class="required" />

					</div>

				</div>

				

				 <div class="form-group row m-0 pl-3 pr-3 p-1">

					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">BIN</label>

					<div class="col-sm-9  p-0">

						<input name="bin" type="text" id="bin" value="<?php echo $bin;?>" class="required" />

					</div>

				</div>

                

                

                

                

                <div class="form-group row m-0 pl-3 pr-3 p-1">

					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Ledger Group</label>

					<div class="col-sm-9  p-0">

						<?
						 $ledger_name=find_a_field('accounts_ledger','ledger_name','ledger_id='.$ledger_id);
						 if ($ledger_name=='') {?>

									<select name="ledger_group" required id="ledger_group" tabindex="9">
										<? foreign_relation('ledger_group','group_id','group_name',$ledger_group,'group_id=124003');?>
										</select>

								<? }?>



								<? if ($ledger_name!='') {?>

									<input name="ledger_id2" type="text" id="ledger_id2" tabindex="9" value="<?=$ledger_name.'-'.$ledger_id?>"  readonly=""  />

								<? }?>



					</div>

				</div>



				<div class="n-form-btn-class">

					<? if($$unique<1){?>

						<input name="record" type="submit" class="btn1 btn1-bg-submit" id="record" value="Save" onclick="return checkUserName()" />

					<? }?>



					<? if($$unique>0){?>

						<input name="modify" type="submit" class="btn1 btn1-bg-update" id="modify" value="update" />

					<? }?>



					<input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/>

					<!--<td><? if($_SESSION['user']['level']==5){?>

								          <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>

								          <? }?></td>-->



				</div>







			</form>



		</div>



	</div>









</div>













































<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%">

		<div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">



							<tr>



								    <td>

										<div class="box">

											<form id="form1" name="form1" method="post" action="">

												<table width="100%" border="0" cellspacing="2" cellpadding="0">





													<tr>



														<td width="40%" align="right"> Company:  </td>



														<td width="60%" align="right">



															<select name="group_for" required id="group_for" style="width:250px; float:left;" tabindex="7">



															  <? foreign_relation('user_group','id','group_name',$group_for,'

															  id="'.$_SESSION['user']['group'].'"');?>

															</select>



														</td>



													  </tr>









													  <tr>



														<td colspan="2">

															<div align="center">

																<input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />

																<input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear" />

															</div>

														</td>



													  </tr>



                                    </table>



								    </form>

										</div>

									</td>



						      </tr>

								  <tr>

									<td>

									<table id="table_head" class="table table-bordered" cellspacing="0">

									<thead>

							  <tr>

								<th bgcolor="#45777B"><span class="style1"> Group ID </span></th>

								<th bgcolor="#45777B"><span class="style1">Product Group</span></th>

								<th bgcolor="#45777B"><span class="style1">Description</span></th>

							  </tr>

								</thead>



								<tbody>



<?php





if($_POST['group_for']!="")



$con .= 'and b.group_for="'.$_POST['group_for'].'"';







	$rrr = "select b.customer_id,  b.group_name, b.description from service_customer b, user_group a where a.id=b.group_for  ".$con." ";



	$report = db_query($rrr);

	$i=0;

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

								<td><?=$rp[0];?></td>

								<td><?=$rp[1];?></td>

								<td><?=$rp[2];?></td>

							   </tr>

	<?php }?>

	</tbody>

							</table>									</td>

								  </tr>

		</table>



	</div>

	</td>

	  <td valign="top" width="40%" >

	<div class="rights">

		<form id="form1" name="form1" method="post" action="" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">

							  <tr>





                                  <td width="100%" colspan="2"><div class="box style2" style="width:400px;">



                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">





                                      <tr>



                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B" > <div align="center">

                                          <?=$title?>

                                        </div></th>

                                      </tr>

									</table>



                                  </div></td>

                                </tr>







                                <tr>

                                  <td width="100%" colspan="2"><div class="box style2" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      <tr>

                                        <td>Group  Name : </td>

                                        <td>



<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

<input name="group_name" type="text" id="group_name" value="<?php echo $group_name;?>" size="30" maxlength="100" style="width:250px;" class="required" />

<input name="group_for" type="hidden" id="group_for" value="<?php echo $_SESSION['user']['group'];?>" style="width:200px" maxlength="100" class="required" /></td>

									  </tr>





									  <tr>

                                        <td>Description : </td>

                                        <td>





<input name="description" type="text" id="description" value="<?php echo $description;?>" size="30" maxlength="100" style="width:250px;" class="required" />

</td>

									  </tr>

                                    </table>

                                  </div></td>

                                </tr>



                                <tr>

                                  <td colspan="2">&nbsp;</td>

                                </tr>











                                <tr>

                                  <td colspan="2">



								    <table width="100%" border="0" cellspacing="0" cellpadding="0">

								      <tr>

								        <td>&nbsp;</td>

								        <td>&nbsp;</td>



								        <td><? if($$unique<1){?>

								          <input name="record" type="submit" class="btn1 btn1-bg-submit" id="record" value="Record" onclick="return checkUserName()"  />

								          <? }?></td>

								        <td><? if($$unique>0){?>

								          <input name="modify" type="submit" class="btn1 btn1-bg-update" id="modify" value="Modify" />

								          <? }?></td>

								        <td><input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>

<!--								        <!--<td><? if($_SESSION['user']['level']==5){?>

								          <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>

								          <? }?></td>-->-->

							          </tr>

							        </table>

	  							  </td>

                                </tr>

                              </table>

    </form>



	</div>

	  </td>

  </tr>

</table><?php */?>







<script type="text/javascript">

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>