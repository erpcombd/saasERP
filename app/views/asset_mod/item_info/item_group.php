<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Product Group';

$proj_id=$_SESSION['proj_id'];

//$inventory=find_a_field('config_group_class','inventory',"1");


do_datatable('table_head');



$now=time();

$unique='group_id';

$unique_field='group_name';

$table='fa_item_group';

$page="item_group.php";

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

$_POST['ledger_group_id']=$inventory;

//$sub_ledger_id=number_format(next_sub_ledger_id($inventory), 0, '.', '');

//sub_ledger_create($sub_ledger_id,$group_name, $inventory, '', $now, $proj_id);





$min=number_format(($inventory*1000000000000)+100000000, 0, '.', '');

$max=number_format(($inventory*1000000000000)+1000000000000, 0, '.', '');

$_POST[$unique]=number_format(next_value('group_id','fa_item_group','100000000',$min,$min,$max), 0, '.', '');



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

while (list($key, $value)=each($data))

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

						<th><span> Group ID </span></th>

						<th><span>Product Group</span></th>

						<th><span>Description</span></th>

					</tr>

					</thead>



					<tbody>



					<?php


					$rrr = "select b.group_id,  b.group_name, b.description from fa_item_group b, user_group a where a.id=b.group_for ".$con." ";



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

				</table>





			</div>



		</div>





		<div class="col-sm-5">

			<form id="form1" class="n-form" name="form1" method="post" action="" onsubmit="return check()">

				<h4 align="center" class="n-form-titel1"><?=$title?></h4>



				<div class="form-group row m-0 pl-3 pr-3">

					<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Group Name </label>

					<div class="col-sm-9 p-0">

						<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

						<input name="group_name" type="text" id="group_name" value="<?php echo $group_name;?>" class="required" />

						<input name="group_for" type="hidden" id="group_for" value="<?php echo $_SESSION['user']['group'];?>" class="required" />

					</div>

				</div>



				<div class="form-group row m-0 pl-3 pr-3">

					<label for="description" class="col-sm-3 pl-0 pr-0 col-form-label">Description</label>

					<div class="col-sm-9  p-0">

						<input name="description" type="text" id="description" value="<?php echo $description;?>" class="required" />

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







	$rrr = "select b.group_id,  b.group_name, b.description from fa_item_group b, user_group a where a.id=b.group_for  ".$con." ";



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