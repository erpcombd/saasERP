<?php

//

//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

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



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Product Group:                                       </td>

                                        <td width="60%" align="right">

										<select name="item_group" id="item_group" style="width:250px; float:left"  onchange="getData2('item_sub_group_ajax.php', 'product_sub_group_src', this.value, 

document.getElementById('item_group').value);" >

                                          <option ></option>
										  <? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'1 order by group_name');?>
                                        </select>
										
										</td>

                                      </tr>
									
									
									

                                      <tr>

                                        <td width="40%" align="right">

		    Sub Group:                                       </td>

                                        <td width="60%" align="right">
										
										<span id="product_sub_group_src">


										<select name="src_sub_group_id" id="src_sub_group_id" style="width:250px; float:left">

										<option></option>

<?php

$a2="select sub_group_id, sub_group_name from item_sub_group where  1 order by sub_group_sl";

//echo $a2;

$a1=db_query($a2);



while($a=mysqli_fetch_row($a1))

{

if($a[0]==$src_sub_group_id)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

?></select></span></td>

                                      </tr>

                                    <!--  <tr>

                                        <td align="right">Product Name:                                      </td>

                                        <td align="right"><input name="src_item_id" style="width:250px; float:left" type="text" id="src_item_id" value="<?php echo $_SESSION['src_item_id']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td align="right"> Product Code:                                         </td>

                                        <td align="right"><input name="fg_code" type="text" id="fg_code" style="width:250px;  float:left" value="<?php echo $_SESSION['fg_code']; ?>" size="20" /></td>

                                      </tr>-->

                                      <tr>

                                        <td colspan="2"><div align="center">
                                          <input class="btn" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn" name="cancel" type="submit" id="cancel" value="Cancel" />
                                        </div></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td>&nbsp;</td>

								  </tr> <tr>

									<td>

<?

if($_SESSION['item_group']>0||$_SESSION['src_sub_group_id']>0||$_SESSION['src_item_id']!=''||$_SESSION['fg_code']>0){

?>

<table id="item_table" class="table table-bordered" cellspacing="0">
<thead>
<tr>

<th width="39" bgcolor="#45777B"><span class="style2"> Code </span></th>

<th width="133" bgcolor="#45777B"><span class="style2">Product Name</span></th>

<th width="83" bgcolor="#45777B"><span class="style2">Sub Group  </span></th>
<th width="42" bgcolor="#45777B"><span class="style2">Status</span></th>
</tr>
</thead>

<tbody>
<?php

 $td="select a.item_id,a.item_name,b.sub_group_name,a.item_description,a.finish_goods_code, a.status FROM item_info a, item_sub_group b where b.sub_group_id=a.sub_group_id ".$con." order by item_id";

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

<td><?=$rp[0];?></td>

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



	</div></td>

    <td valign="top"><div class="right">   <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

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
									
									
									

                                      <tr>

                                        <td width="33%">Item Code: </td>

                                        <td width="67%"><input name="item_name2" type="text" id="item_name2" value="<?=$$unique?>" size="30"  maxlength="100" class="required" readonly="readonly" /></td>

                                      </tr>

									  

									  <!--<tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>Product Code:</td>

                                        <td><input type="text" name="finish_goods_code" id="finish_goods_code" value="<?=$finish_goods_code?>" required /></td>

                                      </tr>-->

									  

                                      <tr>

                                        <td>Product Name:</td>

                                        <td>

                                        <input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

										<input name="item_name" type="text" id="item_name" value="<?php echo $item_name;?>"  size="30" maxlength="100" required />
										<input name="product_nature" type="hidden" id="product_nature" value="Salable" size="30" maxlength="100" class="required" />
										<input type="hidden" name="pack_size" id="pack_size" value="1" />
										<input type="hidden" name="product_type" id="product_type" value="Finish Goods" /></td>

									  </tr>
									  
									  
									  
									  <tr>

                                        <td> Short Name:</td>

                                        <td>
										<input name="item_short_name" type="text" id="item_short_name" value="<?php echo $item_short_name;?>"  size="30" maxlength="100"  />
										</td>

									  </tr>
									  
									  
									  
									  
									  
									  



                                      <tr>

                                        <td> Item Type:</td>

                                        <td>
										  <select name="item_type" id="item_type" style="width: float:left"  required>
                                            <option ></option>
                                            <? foreign_relation('item_type','id','item_type',$item_type,'1');?>
                                          </select>
										  <input name="item_description" type="hidden" id="item_description" value="<?php echo $item_description;?>"  size="30" maxlength="100"  />										</td>
									  </tr>
									  
									  
									  <!--<tr>

                                        <td> Company:</td>

                                        <td>
										<select name="group_for" id="group_for"   onchange="getData2('item_sub_group_ajaxxxxx.php', 'item_sub_group', this.value, document.getElementById('item_group').value);">

                                          <option ></option>
										  <? foreign_relation('user_group','id','group_name',$group_for,'1 order by id');?>
                                        </select>
										</td>

									  </tr>-->
									  
									  
									  <tr>

                                        <td> Product Group :</td>

                                        <td><select name="group_id" id="group_id" style="width: float:left"  onchange="getData2('product_group_ajax.php', 'product_sub_group', this.value, 

document.getElementById('group_id').value);" required>

                                          <option ></option>
										  <? foreign_relation('item_group','group_id','group_name',$group_id,'1');?>
                                        </select></td>

									  </tr>
									  
									  
									  
									 

                                      

                                      <tr>

                                        <td> Sub Group:</td>

                                        <td>
										
										<span id="product_sub_group">
										<?php



$a2="select sub_group_id, sub_group_name from item_sub_group where 1";

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
</td>

                                      </tr>

									  



									  

                                      <tr>

                                        <td>Product Type :</td>

                                        <td>

                                        <select name="product_type" id="product_type">

                                        <option value="<?=$product_type?>"><?=$product_type?></option>

                                        <option value="Finish Goods">Finish Goods</option>

                                        <option value="Raw Materials">Raw Materials</option>

                                        <option value="Spare Parts">Spare Parts</option>
										
										 <option value="Packing Materials">Packing Materials</option>
										 
										  <option value="Machineries">Machineries</option>

                                        </select></td>

                                      </tr>

                                      <tr>

                                        <td>Product Nature :</td>

                                        <td><select name="product_nature" id="product_nature">

                                          <option value="<?=$product_nature?>"><?=$product_nature?></option>

                                          <option value="Salable">Salable</option>

                                          <option value="Purchasable">Purchasable</option>

                                          <option value="Both">Both</option>

                                        </select></td>

                                      </tr>

                                      

                                      

                                      

                                      
				

                                      <tr>

                                        <td>Unit Name:</td>

                                        <td><?php



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

?></td>

                                      </tr>

									  


									  

                                      <tr>

                                        <td>Regular Price:</td>

                                        <td><input type="text" name="d_price" id="d_price" value="<?=$d_price?>" /></td>

                                      </tr>

                                      <tr>

                                        <td>Advance Price:</td>

                                        <td><input type="text" name="a_price" id="a_price" value="<?=$a_price?>" /></td>

                                      </tr>
									  
									  
									  <!--<tr>

                                        <td>Min Alert Qty:</td>

                                        <td><input type="text" name="min_stock" id="min_stock" value="<?=$min_stock?>" /></td>

                                      </tr>-->

                                     
									  
									  
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

								          <input name="record" type="submit" id="record" value="Save" onclick="return checkUserName()" class="btn" />

								          <? }?></td>

								        <td><? if($$unique>0){?>

								          <input name="modify" type="submit" id="modify" value="Modify" class="btn" />

								          <? }?></td>

								        <td><input name="clear" type="button" class="btn" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>

								        <td>&nbsp;</td>

							          </tr>

							        </table>

								  </div>								  </td>

                                </tr>

                              </table>

    </form>

							</div></td>

  </tr>

</table>

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

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>