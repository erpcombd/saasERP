<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Bill Type Setup';
$proj_id=$_SESSION['proj_id'];
//$inventory=find_a_field('config_group_class','inventory',"1");

do_datatable('table_head');
do_calander("#billing_cycle");
$now=time();
$unique='id';
$unique_field='customer';
$table='bill_assign';
$page="bill_assign.php";
$crud      =new crud($table);
$$unique = $_GET[$unique];

if(isset($_POST[$unique_field]))
{
$$unique = $_POST[$unique];
//for Record..................................

if(isset($_POST['record']))
{		
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];
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
						<th><span>Customer</span></th>
						<th><span>Service</span></th>
						<th><span>Fee</span></th>
						<th><span>Next Bill</span></th>
						<th><span>Status</span></th>
					</tr>
					</thead>

					<tbody>

					<?php


					if($_POST['group_for']!="")

						$con .= 'and b.group_for="'.$_POST['group_for'].'"';



					$rrr = "select b.id,c.customer_name,a.type,b.service_charge,b.billing_cycle,b.status from bill_assign b left join service_customer c on c.customer_id=b.customer left join acc_bill_type a on a.id=b.service_id where 1";

					$report = db_query($rrr);
					$i=0;
					while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
						<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
							<td><?=$rp[1];?></td>
							<td><?=$rp[2];?></td>
							<td><?=$rp[3];?></td>
							<td><?=$rp[4];?></td>
							<td><?=$rp[5];?></td>
						</tr>
					<?php }?>


					</tbody>
				</table>


			</div>

		</div>


		<div class="col-sm-5">
			<form id="form1" class="n-form" name="form1" method="post" action="" onsubmit="return check()">
				<h4 align="center" class="n-form-titel1 text-uppercase"><?=$title?></h4>

				<div class="form-group row m-0 pl-3 pr-3 p-1">
					<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Customer </label>
					<div class="col-sm-9 p-0">
						<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />
						<select name="customer" id="customer" class="required" required>
                          <option></option>
                          <? foreign_relation('service_customer','customer_id','customer_name',$customer,'1')?>
                        </select>
					</div>
				</div>

				<div class="form-group row m-0 pl-3 pr-3 p-1">
					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Service Type</label>
					<div class="col-sm-9  p-0">
						<select name="service_id" id="service_id" class="required" required>
                          <option></option>
                          <? foreign_relation('acc_bill_type','id','type',$service_id,'1')?>
                        </select>
					</div>
				</div>
                
                
				<div class="form-group row m-0 pl-3 pr-3 p-1">
					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Service Charge</label>
					<div class="col-sm-9  p-0">
						<input name="service_charge" type="text" id="service_charge" value="<?php echo $service_charge;?>" class="required" />
					</div>
				</div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Billing Period</label>
					<div class="col-sm-9  p-0">
						<input name="billing_cycle" type="text" id="billing_cycle" value="<?php echo $billing_cycle;?>" class="required" required />
					</div>
				</div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Billing Cycle</label>
					<div class="col-sm-9  p-0">
						<select name="cycle" id="cycle" required>
						<option></option>
						 <option <?=($cycle=='monthly')?'selected':''?> value="monthly">Monthly</option>
						 <option <?=($cycle=='yearly')?'selected':''?> value="yearly">Yearly</option>
						 <option <?=($cycle=='quarterly')?'selected':''?>value="quarterly">Quarterly</option>
						 <option <?=($cycle=='license')?'selected':''?>value="license">License</option>
						</select>
					</div>
				</div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Status</label>
					<div class="col-sm-9  p-0">
						<select name="status" id="status" class="required" required>
							<option value="Active" <?php if ($status == 'Active') echo 'selected'; ?>>Active</option>
							<option value="Inactive" <?php if ($status == 'Inactive') echo 'selected'; ?>>Inactive</option>
						</select>
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



	$rrr = "select b.id,  b.group_name, b.description from bill_assign b, user_group a where a.id=b.group_for  ".$con." ";

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