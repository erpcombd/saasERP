<?php

session_start();

ob_start();

require_once "../../../assets/template/layout.top.php";

$title='Product Information';

do_datatable('item_table');

$proj_id=$_SESSION['proj_id'];



$now=time();

$unique='item_id';

$unique_field='item_name';

$table='item_info';

$page="item_info.php";

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

	while (list($key, $value)=each($data)){ $$key=$value;}

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
			<div class="col-sm-7">
				<div class="container p-0">
					<form id="form1" name="form1" class="n-form1" method="post" action="">


						<div class="form-group row m-0 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Product Group</label>
							<div class="col-sm-9 p-0">
								<select name="item_group" id="item_group" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value,document.getElementById('item_group').value);">

									<option ></option>
									<? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'1 order by group_name');?>
								</select>
							</div>
						</div>


						<div class="form-group row m-0 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Sub Group</label>
							<div class="col-sm-9 p-0">

								<select name="src_sub_group_id" id="src_sub_group_id">

									<option></option>

									<?php

									$a2="select sub_group_id, sub_group_name from item_sub_group where 1";

									//echo $a2;

									$a1=mysql_query($a2);



									while($a=mysql_fetch_row($a1))

									{

										if($a[0]==$src_sub_group_id)

											echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

										else

											echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

									}

									?></select>
							</div>
						</div>


						<div class="form-group row m-0 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Product Name</label>
							<div class="col-sm-9 p-0">
								<input name="src_item_id" class="m-0" type="text" id="src_item_id" value="<?php echo $_SESSION['src_item_id']; ?>" />
							</div>
						</div>


						<div class="form-group row m-0 pl-3 pr-3">
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
								<thead>
								<tr class="bgc-info">
									<th><span class="style2">Product Code </span></th>
									<th><span class="style2">Product Name</span></th>
									<th><span class="style2">Category </span></th>
									<th><span class="style2">Status</span></th>
								</tr>
								</thead>

								<tbody>
								<?php

								$td="select a.item_id,a.item_name,b.sub_group_name,a.item_description,a.finish_goods_code, a.status FROM item_info a, item_sub_group b where b.sub_group_id=a.sub_group_id ".$con." order by item_id";

								$report=mysql_query($td);

								while($rp=mysql_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

									<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

										<td><?=$rp[4];?></td>

										<td><?=$rp[1];?></td>

										<td><?=$rp[2];?></td>
										<td><?=$rp[5];?></td>
									</tr>

								<?php }?>
								</tbody>
							</table>

						<? }?>


				</div>

			</div>


			<div class="col-sm-5">

				<form id="form1" name="form1" class="n-form" method="post" action="" enctype="multipart/form-data" onsubmit="return check()">
					<h4 align="center" class="n-form-titel1"> <?=$title?> </h4>


<!--					<div class="form-group row m-0 pl-3 pr-3">-->
<!--						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Item Code</label>-->
<!--						<div class="col-sm-9 p-0">-->
<!--							<input name="item_name2" type="text" id="item_name2" value="--><?//=$$unique?><!--" class="required" readonly="readonly" />-->
<!--						</div>-->
<!--					</div>-->



					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> Product Code</label>
						<div class="col-sm-9 p-0">
							<input type="text" name="finish_goods_code" class="m-0" id="finish_goods_code" value="<?=$finish_goods_code?>" required />
						</div>
					</div>

					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Product Name </label>
						<div class="col-sm-9 p-0">
							<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

							<input name="item_name" class="m-0" type="text" id="item_name" value="<?php echo $item_name;?>"  required />
							<input name="product_nature" type="hidden" id="product_nature" value="Salable"  class="required m-0" />

						</div>
					</div>

					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Description  </label>
						<div class="col-sm-9 p-0">

							<input name="item_description" class="m-0" type="text" id="item_description" value="<?php echo $item_description;?>" />

						</div>
					</div>



<!--					<div class="form-group row m-0 pl-3 pr-3">-->
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


					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Category </label>
						<div class="col-sm-9 p-0">

							<span id="product_sub_group">
										<?php



										$a2="select sub_group_id, sub_group_name from item_sub_group where 1";

										//echo $a2;

										$a1=mysql_query($a2);

										echo "<select name=\"sub_group_id\" id=\"sub_group_id\"\" required>";
										echo "<option></option>";
										while($a=mysql_fetch_row($a1))

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


<!--					<div class="form-group row m-0 pl-3 pr-3">-->
<!--						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Consumable Type </label>-->
<!--						<div class="col-sm-9 p-0">-->
<!---->
<!--							<select name="consumable_type" id="consumable_type">-->
<!---->
<!--								<option value="--><?//=$consumable_type?><!--">--><?//=$consumable_type?><!--</option>-->
<!---->
<!--								<option value="Consumable">Consumable</option>-->
<!---->
<!--								<option value="Non-Consumable">Non-Consumable</option>-->
<!---->
<!--								<option value="Service">Service</option>-->
<!---->
<!--							</select>-->
<!---->
<!--						</div>-->
<!--					</div>-->
<!---->
<!---->
<!--					<div class="form-group row m-0 pl-3 pr-3">-->
<!--						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Material Nature </label>-->
<!--						<div class="col-sm-9 p-0">-->
<!---->
<!--							<select name="product_nature" id="product_nature">-->
<!---->
<!--								<option value="--><?//=$product_nature?><!--">--><?//=$product_nature?><!--</option>-->
<!---->
<!--								<option value="Salable">Salable</option>-->
<!---->
<!--								<option value="Purchasable">Purchasable</option>-->
<!---->
<!--								<option value="Both">Both</option>-->
<!---->
<!--							</select>-->
<!---->
<!--						</div>-->
<!--					</div>-->







					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Unit Name  </label>
						<div class="col-sm-9 p-0">

								<?php

								$a2="select unit_name, unit_name from unit_management where 1 order by id";

								//echo $a2;

								$a1=mysql_query($a2);

								echo "<select name=\"unit_name\" id=\"unit_name\"\">";

								echo "<option value=\"\" selected></option>";

								while($a=mysql_fetch_row($a1))

								{

									if($a[0]==$unit_name)

										echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

									echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

								}

								echo "</select>";

								?>
						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Pack Size  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="pack_size" id="pack_size" value="<?=$pack_size?>" />

						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Buy Unit  </label>
						<div class="col-sm-9 p-0">

							<?php



							$a2="select unit_name, unit_name from unit_management";

							//echo $a2;

							$a1=mysql_query($a2);

							echo "<select name=\"purchase_unit\" id=\"purchase_unit\"\">";

							echo "<option value=\"\" selected></option>";

							while($a=mysql_fetch_row($a1))

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




					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Buy Unit Size  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="purchase_size" id="purchase_size" value="<?=$purchase_size?>" />

						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Cost Price  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="cost_price" id="cost_price" value="<?=$cost_price?>" />

						</div>
					</div>



					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Sale Price  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="d_price" id="d_price" value="<?=$d_price?>" />

						</div>
					</div>



					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Min Alert Qty </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="min_stock" id="min_stock" value="<?=$min_stock?>" />

						</div>
					</div>



					<div class="form-group row m-0 pl-3 pr-3">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Status </label>
						<div class="col-sm-9 p-0">

							<select name="status" id="status">

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













<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top">
		<div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td>
										<div class="box">
											<form id="form1" name="form1" method="post" action="">

												<table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Product Group:                                       </td>

                                        <td width="60%" align="right">

										<select name="item_group" id="item_group" style="width:250px; float:left"  onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value,document.getElementById('item_group').value);">

                                          <option ></option>
										  <? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'1 order by group_name');?>
                                        </select>
										
										</td>

                                      </tr>
									
									
									

                                      <tr>

                                        <td width="40%" align="right">

		    Sub Group:                                       </td>

                                        <td width="60%" align="right">
										
										<span id="item_sub_group">


										<select name="src_sub_group_id" id="src_sub_group_id" style="width:250px; float:left">

										<option></option>

<?php

$a2="select sub_group_id, sub_group_name from item_sub_group where 1";

//echo $a2;

$a1=mysql_query($a2);



while($a=mysql_fetch_row($a1))

{

if($a[0]==$src_sub_group_id)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

?></select></span></td>

                                      </tr>

                                      <tr>

                                        <td align="right">Product Name:                                      </td>

                                        <td align="right"><input name="src_item_id" style="width:250px; float:left" type="text" id="src_item_id" value="<?php echo $_SESSION['src_item_id']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td align="right"> Product Code:                                         </td>

                                        <td align="right"><input name="fg_code" type="text" id="fg_code" style="width:250px;  float:left" value="<?php echo $_SESSION['fg_code']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td colspan="2"><div align="center">
                                          <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />
                                        </div></td>

                                      </tr>

                                    </table>

								    </form>
										</div>
									</td>

						      </tr>

								  <tr>

									<td>&nbsp;</td>

								  </tr>
								<tr>
									<td>

<?

if($_SESSION['item_group']>0||$_SESSION['src_sub_group_id']>0||$_SESSION['src_item_id']!=''||$_SESSION['fg_code']>0){

?>

<table id="item_table" class="table table-bordered" cellspacing="0">
<thead>
<tr>

<th bgcolor="#45777B"><span class="style2">Product Code </span></th>

<th bgcolor="#45777B"><span class="style2">Product Name</span></th>

<th bgcolor="#45777B"><span class="style2">Category </span></th>
<th bgcolor="#45777B"><span class="style2">Status</span></th>
</tr>
</thead>

<tbody>
<?php

 $td="select a.item_id,a.item_name,b.sub_group_name,a.item_description,a.finish_goods_code, a.status FROM item_info a, item_sub_group b where b.sub_group_id=a.sub_group_id ".$con." order by item_id";

$report=mysql_query($td);

while($rp=mysql_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

<td><?=$rp[4];?></td>

<td><?=$rp[1];?></td>

<td><?=$rp[2];?></td>
<td><?=$rp[5];?></td>
</tr>

<?php }?>
</tbody>
</table>

<? }?>

									<div id="pageNavPosition"></div>									</td>
								  </tr>

		</table>



	</div>
	</td>

    <td valign="top">
		<div class="right">
			<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box style2" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>

                                  <td width="100%" colspan="2"><div class="box" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
									
									
									

                                      <!--<tr>

                                        <td>Item Code: </td>

                                        <td><input name="item_name2" type="text" id="item_name2" value="<?=$$unique?>" size="30" maxlength="100" class="required" readonly="readonly" /></td>

                                      </tr>-->

									  

									  <tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>Product Code:</td>

                                        <td><input type="text" name="finish_goods_code" id="finish_goods_code" value="<?=$finish_goods_code?>" required /></td>

                                      </tr>

									  

                                      <tr>

                                        <td>Product Name:</td>

                                        <td>

                                        <input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

										<input name="item_name" type="text" id="item_name" value="<?php echo $item_name;?>" size="30" maxlength="100" required />
										<input name="product_nature" type="hidden" id="product_nature" value="Salable" size="30" maxlength="100" class="required" /></td>

									  </tr>
									  
									  
									  
									  
									  
									  



                                      <tr>

                                        <td> Description:</td>

                                        <td>
										<input name="item_description" type="text" id="item_description" value="<?php echo $item_description;?>" size="30" maxlength="100"  />
										</td>

									  </tr>
									  
									  
									  <!--<tr>

                                        <td> Product Group :</td>

                                        <td><select name="group_id" id="group_id" style="width: float:left"  onchange="getData2('product_group_ajax.php', 'product_sub_group', this.value, 

document.getElementById('group_id').value);" required>

                                          <option ></option>
										  <? foreign_relation('item_group','group_id','group_name',$group_id,'1');?>
                                        </select></td>

									  </tr>-->
									  
									  
									  
									 

                                      

                                      <tr>

                                        <td> Category:</td>

                                        <td>
										
										<span id="product_sub_group">
										<?php



$a2="select sub_group_id, sub_group_name from item_sub_group where 1";

//echo $a2;

$a1=mysql_query($a2);

echo "<select name=\"sub_group_id\" id=\"sub_group_id\"\" required>";
	echo "<option></option>";
while($a=mysql_fetch_row($a1))

{



if($a[0]==$sub_group_id)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?>




										</span>
</td>

                                      </tr>

									  

									  

									  

									  

									  

									  

									  

                                      <!--<tr>

                                        <td>Consumable Type :</td>

                                        <td>

                                        <select name="consumable_type" id="consumable_type">

                                        <option value="<?=$consumable_type?>"><?=$consumable_type?></option>

                                        <option value="Consumable">Consumable</option>

                                        <option value="Non-Consumable">Non-Consumable</option>

                                        <option value="Service">Service</option>

                                        </select></td>

                                      </tr>-->

                                      <!--<tr>

                                        <td>Material Nature :</td>

                                        <td><select name="product_nature" id="product_nature">

                                          <option value="<?=$product_nature?>"><?=$product_nature?></option>

                                          <option value="Salable">Salable</option>

                                          <option value="Purchasable">Purchasable</option>

                                          <option value="Both">Both</option>

                                        </select></td>

                                      </tr>-->

                                      

                                      

                                      

                                      
				

                                      <tr>

                                        <td>Unit Name:</td>

                                        <td><?php



$a2="select unit_name, unit_name from unit_management where 1 order by id";

//echo $a2;

$a1=mysql_query($a2);

echo "<select name=\"unit_name\" id=\"unit_name\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysql_fetch_row($a1))

{

if($a[0]==$unit_name)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?></td>

                                      </tr>

									  

									  

									  <tr>

                                        <td>Pack Size:</td>

                                        <td><input type="text" name="pack_size" id="pack_size" value="<?=$pack_size?>" /></td>

                                      </tr>

									  

									  

                                                                     
									  
									  
									  <tr>

                                        <td>Buy Unit:</td>

                                        <td><?php



$a2="select unit_name, unit_name from unit_management";

//echo $a2;

$a1=mysql_query($a2);

echo "<select name=\"purchase_unit\" id=\"purchase_unit\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysql_fetch_row($a1))

{

if($a[0]==$purchase_unit)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?></td>

                                      </tr>

                                      <tr>

                                        <td>Buy Unit Size:</td>

                                        <td><input type="text" name="purchase_size" id="purchase_size" value="<?=$purchase_size?>" /></td>

                                      </tr>
									  
									  

                                      <tr>

                                        <td>Cost Price:</td>

                                        <td><input type="text" name="cost_price" id="cost_price" value="<?=$cost_price?>" /></td>

                                      </tr>

                                      <tr>

                                        <td>Sale Price:</td>

                                        <td><input type="text" name="d_price" id="d_price" value="<?=$d_price?>" /></td>

                                      </tr>
									  
									  
									  <tr>

                                        <td>Min Alert Qty:</td>

                                        <td><input type="text" name="min_stock" id="min_stock" value="<?=$min_stock?>" /></td>

                                      </tr>

                                     
									  
									  
									  <tr>

                                        <td>Status:</td>

                                        <td><select name="status" id="status">

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="Active">Active</option>

                                          <option value="Inactive">Inactive</option>


                                        </select></td>

                                      </tr>

                                    

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>

                                      </tr>

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>

                                      </tr></table>

                                  </div></td>

                                </tr>

                                

                                <tr>

                                  <td colspan="2">&nbsp;</td>

                                </tr>

                                <tr>

                                  <td colspan="2">

								  <div class="box1">

								    <table width="100%" border="0" cellspacing="0" cellpadding="0">

								      <tr>

								        <td><? if($$unique<1){?>

								          <input name="record" type="submit" id="record" value="Save" onclick="return checkUserName()" class="btn1 btn1-bg-submit" />

								          <? }?></td>

								        <td><? if($$unique>0){?>

								          <input name="modify" type="submit" id="modify" value="Modify" class="btn1 btn1-bg-update" />

								          <? }?></td>

								        <td><input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>

								        <td>&nbsp;</td>

							          </tr>

							        </table>

								  </div>								  </td>

                                </tr>

                              </table>

    </form>

		</div>
	</td>

  </tr>

</table><?php */?>

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

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>