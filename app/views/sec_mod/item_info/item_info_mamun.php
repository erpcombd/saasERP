<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Product Information Setup';

do_datatable('item_table');

$proj_id=$_SESSION['proj_id'];



$now=time();

$unique='item_id';

$unique_field='item_name';

$table='item_info';

$page="item_info_mamun.php";

$crud      =new crud($table);

$$unique = $_GET[$unique];





if(isset($_POST[$unique_field]))

{

$$unique = $_POST[$unique];

//for Record..................................

$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);

//$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);



$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);



$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);

$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);





$_POST['group_for'] = find_a_field('item_sub_group','group_for','sub_group_id='.$_POST['sub_group_id']);

if(isset($_POST['record']))

{

$_POST['entry_at']=date('Y-m-d H:i:s');

$_POST['entry_by']=$_SESSION['user']['id'];



$min=number_format($_POST['sub_group_id'] + 1, 0, '.', '');

$max=number_format($_POST['sub_group_id'] + 10000, 0, '.', '');

$_POST[$unique]=number_format(next_value('item_id','item_info','1',$min,$min,$max), 0, '.', '');

$crud->insert();



$type=1;

$msg='New Entry Successfully Inserted.';



unset($_POST);

unset($$unique);

}



//for Modify..................................



if(isset($_POST['modify']))

{

		

$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);

$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);



$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);



$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);

$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);



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

	foreach ($data as $key => $value){ $$key=$value;}

}





//for Modify..................................



if($_REQUEST['src_sub_group_id']>0){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}

if($_REQUEST['src_item_id']!=''){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}

if($_REQUEST['item_group']!=''){$_SESSION['item_group'] = $_REQUEST['item_group'];$_SESSION['item_group'] = $_REQUEST['item_group'];}

if($_REQUEST['fg_code']!=''){$_SESSION['fg_code'] = $_REQUEST['fg_code'];$_SESSION['fg_code'] = $_REQUEST['fg_code'];}



if(isset($_REQUEST['cancel'])){unset($_SESSION['item_group']);unset($_SESSION['src_sub_group_id']);unset($_SESSION['src_item_id']);unset($_SESSION['fg_code']);}



if($_SESSION['item_group']>0){

$item_group = $_SESSION['item_group'];

$con .='and b.group_id="'.$item_group.'" ';}


if($_SESSION['src_sub_group_id']>0){

$src_sub_group_id = $_SESSION['src_sub_group_id'];

$con .='and a.sub_group_id="'.$src_sub_group_id.'" ';}



if($_SESSION['src_item_id']!=''){

$src_item_id = $_SESSION['src_item_id'];

$con .='and a.item_name like "%'.$src_item_id.'%" ';}



if($_SESSION['fg_code']>0){

$fg_code = $_SESSION['fg_code'];

$con .='and a.finish_goods_code="'.$fg_code.'" ';}

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
.style2 {color: #FFFFFF}

-->

</style>







	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6">
				<div class="container p-0">
					<form id="form1" name="form1" class="n-form1" method="post" action="">


						<div class="form-group row m-0 pl-3 pr-3 p-1">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Product Group</label>
							<div class="col-sm-9 p-0">
								<select name="item_group" id="item_group" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value,document.getElementById('item_group').value);">

									<option ></option>
									<? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'1 and group_for="'.$_SESSION['user']['group'].'" order by group_name');?>
								</select>
							</div>
						</div>


						<div class="form-group row m-0 pl-3 pr-3 p-1">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Sub Group</label>
							<div class="col-sm-9 p-0">

								<select name="src_sub_group_id" id="src_sub_group_id">

									<option></option>

									<?php

									$a2="select sub_group_id, sub_group_name from item_sub_group where 1 and group_for='".$_SESSION['user']['group']."'";

									//echo $a2;

									$a1=db_query($a2);



									while($a=mysqli_fetch_row($a1))

									{

										if($a[0]==$src_sub_group_id)

											echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

										else

											echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

									}

									?></select>
							</div>
						</div>


						<div class="form-group row m-0 pl-3 pr-3 p-1">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Product Name</label>
							<div class="col-sm-9 p-0">
								<input name="src_item_id" class="m-0" type="text" id="src_item_id" value="<?php echo $_SESSION['src_item_id']; ?>" />
							</div>
						</div>


						<div class="form-group row m-0 pl-3 pr-3 p-1">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Product Code</label>
							<div class="col-sm-9 p-0">
								<input name="fg_code" class="m-0" type="text" id="fg_code"  value="<?php echo $_SESSION['fg_code']; ?>" />
							</div>
						</div>


						<div class="n-form-btn-class">
							<input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
							<input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear" />
						</div>

					</form>

				</div>


				<div class="container n-form1">


						<?

						if($_SESSION['item_group']>0||$_SESSION['src_sub_group_id']>0||$_SESSION['src_item_id']!=''||$_SESSION['fg_code']>0){

							?>

							<table id="item_table" class="table table-striped table-bordered table-hover table-sm" cellspacing="0">
								<thead class="thead1">
								<tr class="bgc-info">
									<th><span class="style2">Product Code </span></th>
									<th><span class="style2">Product Name</span></th>
									<th><span class="style2">UOM</span></th>
									<th><span class="style2">Category </span></th>
									<th><span class="style2">Status</span></th>
								</tr>
								</thead>

								<tbody>
								<?php

								 $td="select a.item_id,a.item_name,b.sub_group_name,a.item_description,a.finish_goods_code, a.status,a.unit_name FROM item_info a, item_sub_group b where b.sub_group_id=a.sub_group_id ".$con." order by item_id";

								$report=db_query($td);

								while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

									<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

										<td><?=$rp[4];?></td>

										<td><?=$rp[1];?></td>
										<td><?=$rp[6];?></td>

										<td><?=$rp[2];?></td>
										<td><?=$rp[5];?></td>
									</tr>

								<?php }?>
								</tbody>
							</table>

						<? }?>


				</div>

			</div>


			<div class="col-sm-6">

				<form id="form1" name="form1" class="n-form" method="post" action="" enctype="multipart/form-data" onsubmit="return check()">
					<h4 align="center" class="n-form-titel1 text-uppercase"> <?=$title?> </h4>


<!--					<div class="form-group row m-0 pl-3 pr-3">-->
<!--						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Item Code</label>-->
<!--						<div class="col-sm-9 p-0">-->
<!--							<input name="item_name2" type="text" id="item_name2" value="--><?//=$$unique?><!--" class="required" readonly="readonly" />-->
<!--						</div>-->
<!--					</div>-->



					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> Product Code</label>
						<div class="col-sm-9 p-0">
							<input type="text" name="finish_goods_code" class="m-0" id="finish_goods_code" value="<?=$finish_goods_code?>" required />
						</div>
					</div>

					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Product Name </label>
						<div class="col-sm-9 p-0">
							<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

							<input name="item_name" class="m-0" type="text" id="item_name" value="<?php echo $item_name;?>"  required />
							<input name="product_nature" type="hidden" id="product_nature" value="Salable"  class="required m-0" />

						</div>
					</div>

					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Description  </label>
						<div class="col-sm-9 p-0">

							<input name="item_description" class="m-0" type="text" id="item_description" value="<?php echo $item_description;?>" />

						</div>
					</div>



<!--					<div class="form-group row m-0 pl-3 pr-3 p-1">-->
<!--						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Product Group  </label>-->
<!--						<div class="col-sm-9 p-0">-->
<!---->
<!--							<select name="group_id" id="group_id" style="width: float:left"  onchange="getData2('product_group_ajax.php', 'product_sub_group', this.value,document.getElementById('group_id').value);" required>-->
<!---->
<!--								<option ></option>-->
<!--								--><?// foreign_relation('item_group','group_id','group_name',$group_id,'1');?>
<!--							</select>-->
<!---->
<!--						</div>-->
<!--					</div>-->


					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Category </label>
						<div class="col-sm-9 p-0">

							<span id="product_sub_group">
										<?php



										$a2="select sub_group_id, sub_group_name from item_sub_group where 1 and group_for='".$_SESSION['user']['group']."'";

										//echo $a2;

										$a1=db_query($a2);

										echo "<select name=\"sub_group_id\" id=\"sub_group_id\"\" required>";
										echo "<option></option>";
										while($a=mysqli_fetch_row($a1))

										{



											if($a[0]==$sub_group_id)

												echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

											else

												echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

										}

										echo "</select>";

										?>




										</span>

						</div>
					</div>



					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Product Nature </label>
						<div class="col-sm-9 p-0">

							<select name="product_nature" id="product_nature" required="required">

						<option value="<?=$product_nature?>"><?=$product_nature?></option>
								<option value="Salable">Saleable</option>

								<option value="Purchasable">Purchasable</option>

								<option value="Both">Both</option>

							</select>

						</div>
					</div>







					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Unit Name  </label>
						<div class="col-sm-9 p-0">

								<?php

								$a2="select unit_name, unit_name from unit_management where 1 order by id";

								//echo $a2;

								$a1=db_query($a2);

								echo "<select name=\"unit_name\" id=\"unit_name\"\">";

								echo "<option value=\"\" selected></option>";

								while($a=mysqli_fetch_row($a1))

								{

									if($a[0]==$unit_name)

										echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

									echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

								}

								echo "</select>";

								?>
						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Pack Size  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="pack_size" id="pack_size" value="<?=$pack_size?>" />

						</div>
					</div>
					
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">SQM </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="sqm" id="sqm" value="<?=$sqm?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Square Feet</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="square_feet" id="square_feet" value="<?=$square_feet?>" />

						</div>
					</div>
					
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">KG/SQM</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="kg_sqm" id="kg_sqm" value="<?=$kg_sqm?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Yards</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="yards" id="yards" value="<?=$yards?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">GSM</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="item_gsm" id="item_gsm" value="<?=$item_gsm?>" />

						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Buy Unit  </label>
						<div class="col-sm-9 p-0">

							<?php



							$a2="select unit_name, unit_name from unit_management";

							//echo $a2;

							$a1=db_query($a2);

							echo "<select name=\"purchase_unit\" id=\"purchase_unit\"\">";

							echo "<option value=\"\" selected></option>";

							while($a=mysqli_fetch_row($a1))

							{

								if($a[0]==$purchase_unit)

									echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

								else

									echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

							}

							echo "</select>";

							?>

						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Buy Unit Size  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="purchase_size" id="purchase_size" value="<?=$purchase_size?>" />

						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Cost Price  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="cost_price" id="cost_price" value="<?=$cost_price?>" />

						</div>
					</div>



					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Sale Price  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="d_price" id="d_price" value="<?=$d_price?>" />

						</div>
					</div>



					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Min Alert Qty </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="min_stock" id="min_stock" value="<?=$min_stock?>" />

						</div>
					</div>
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Status </label>
						<div class="col-sm-9 p-0">

							<select name="status" id="status" required="required">

								<option value="<?=$status?>"><?=$status?></option>

								<option value="Active">Active</option>

								<option value="Inactive">Inactive</option>


							</select>

						</div>
					</div>


































					<div class="n-form-btn-class">
						<? if($$unique<1){?>

							<input name="record" type="submit" id="record" value="Save" onclick="return checkUserName()" class="btn1 btn1-bg-submit" />

						<? }?>


						<? if($$unique>0){?>

							<input name="modify" type="submit" id="modify" value="Update" class="btn1 btn1-bg-update" />

						<? }?>

						<input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/>


					</div>


				</form>

			</div>

		</div>




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

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>