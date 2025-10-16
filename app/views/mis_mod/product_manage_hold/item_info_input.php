<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Product Item Information';

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

$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);



$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);



$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);

$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);

if(isset($_POST['record']))

{

$_POST['entry_at']=time();

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



		$_POST['edit_at']=time();

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

if($_REQUEST['item_group']>0){$_SESSION['item_group'] = $_REQUEST['item_group'];}

if($_REQUEST['src_sub_group_id']>0){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}

if($_REQUEST['item_brand_n']!=""){$_SESSION['item_brand_n'] = $_REQUEST['item_brand_n'];}

if($_REQUEST['src_item_id']!=''){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}

if($_REQUEST['fg_code']!=''){$_SESSION['fg_code'] = $_REQUEST['fg_code'];$_SESSION['fg_code'] = $_REQUEST['fg_code'];}



if(isset($_REQUEST['cancel'])){unset($_SESSION['item_group']); unset($_SESSION['item_brand_n']); unset($_SESSION['src_sub_group_id']);unset($_SESSION['src_item_id']);unset($_SESSION['fg_code']);}




if($_SESSION['item_group']>0){

$item_group = $_SESSION['item_group'];

$con .=' and g.group_id="'.$item_group.'" ';}



if($_SESSION['src_sub_group_id']>0){

$src_sub_group_id = $_SESSION['src_sub_group_id'];

$con .='  and a.sub_group_id="'.$src_sub_group_id.'" ';}


if($_SESSION['item_brand_n'] !=""){

$item_brand_n = $_SESSION['item_brand_n'];

$con .=' and a.item_brand="'.$item_brand_n.'" ';}


if($_SESSION['src_item_id']!=''){

$src_item_id = $_SESSION['src_item_id'];

$con .='  and a.item_name like "%'.$src_item_id.'%" ';}



if($_SESSION['fg_code']>0){

$fg_code = $_SESSION['fg_code'];

$con .='  and a.finish_goods_code="'.$fg_code.'" ';}

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


        <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
        
				  
				  
	<div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Item Code:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
   <input name="item_name2" class="form-control" type="text" id="item_name2" value="<?=$$unique?>"   readonly="readonly" required />
      </div>
    </div>
  </div>
  
  
  
  <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Item  Name:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
  <input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />
  <input name="item_name" type="text"  id="item_name" value="<?php echo $item_name;?>"  class="form-control" />
      </div>
    </div>
  </div>
  
   <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Item Description:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
 <textarea name="item_description" id="item_description" class="form-control"><?php echo $item_description;?></textarea>
      </div>
    </div>
  </div>
  
  
  <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Item Sub Group:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
 <?php



$a2="select sub_group_id, sub_group_name from item_sub_group";



$a1=db_query($a2);

echo "<select name=\"sub_group_id\" id=\"sub_group_id\"\">";

while($a=mysqli_fetch_row($a1))

{

	echo "<option></option>";

    if($a[0]==$sub_group_id){
        echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";
    }else{
        echo "<option value=\"".$a[0]."\">".$a[1]."</option>";
    }
}

echo "</select>";

?>
      </div>
    </div>
  </div>
  
  
  
  <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Consumable Type:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
  <select name="consumable_type" class="form-control" id="consumable_type">
                          <option value="<?=$consumable_type?>">
                          <?=$consumable_type?>
                          </option>
                          <option value="Consumable">Consumable</option>
                          <option value="Non-Consumable">Non-Consumable</option>
                          <option value="Service">Service</option>
                        </select>
      </div>
    </div>
  </div>
  
  
  <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Product Nature:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
  <select name="product_nature" class="form-control" id="product_nature">
                          <option value="<?=$product_nature?>">
                          <?=$product_nature?>
                          </option>
                          <option value="Salable">Salable</option>
                          <option value="Purchasable">Purchasable</option>
                          <option value="Both">Both</option>
                        </select>
      </div>
    </div>
  </div>
  
  
   <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">FG Code:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input type="text" class="form-control" name="finish_goods_code" id="finish_goods_code" value="<?=$finish_goods_code?>" />
      </div>
    </div>
  </div>
  
  
  <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">FG Group:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<select name="sales_item_type"  class="form-control" id="sales_item_type">
                          <option value="<?=$sales_item_type?>">
                          <?=$sales_item_type?>
                          </option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="C">C</option>
                          <option value="D">D</option>
                        </select> 
      </div>
    </div>
  </div>
  
    <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Unit Name :</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<?php



$a2="select unit_name, unit_name from unit_management";



$a1=db_query($a2);

echo "<select name=\"unit_name\" id=\"unit_name\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysqli_fetch_row($a1))

{

if($a[0]==$unit_name){
echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";
}
echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?>
      </div>
    </div>
  </div>
  
  
  
   <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Sale Unit Name:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<?php



$a2="select unit_name, unit_name from unit_management";


$a1=db_query($a2);

echo "<select name=\"pack_unit\" id=\"pack_unit\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysqli_fetch_row($a1))

{

    if($a[0]==$pack_unit){
        echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";
    } else{
        echo "<option value=\"".$a[0]."\">".$a[1]."</option>";
}
}

echo "</select>";

?>
      </div>
    </div>
  </div>
  
  
  
   <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Sale Unit Size:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input type="text" name="pack_size" class="form-control" id="pack_size" value="<?=$pack_size?>" />
      </div>
    </div>
  </div>
  
  <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Sale (Sub) Unit Size:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input type="text" name="sub_pack_size" class="form-control" id="sub_pack_size" value="<?=$sub_pack_size?>" />
      </div>
    </div>
  </div>
  
  
  <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Buy Unit Name:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<?php



$a2="select unit_name, unit_name from unit_management";



$a1=db_query($a2);

echo "<select name=\"purchase_unit\" id=\"purchase_unit\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysqli_fetch_row($a1))

{

    if($a[0]==$purchase_unit){
    echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";
    } else{
        echo "<option value=\"".$a[0]."\">".$a[1]."</option>";
    }
}

echo "</select>";

?>
      </div>
    </div>
  </div>
  
  
   <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Buy Unit Size:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input type="text" name="purchase_size" class="form-control" id="purchase_size" value="<?=$purchase_size?>" />
      </div>
    </div>
  </div>
  
  
   <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Net Price:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input type="text" name="d_price" class="form-control" id="d_price" value="<?=$d_price?>" />
      </div>
    </div>
  </div>
  
  
  <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Trade Price:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input type="text" name="t_price" class="form-control" id="t_price" value="<?=$t_price?>" />
      </div>
    </div>
  </div>
  
   <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Market Price:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input type="text" name="m_price" class="form-control" id="m_price" value="<?=$m_price?>" />
      </div>
    </div>
  </div>
  
    <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label">Purchase  Price:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
<input type="text" name="cost_price" class="form-control" id="cost_price" value="<?=$cost_price?>" />
      </div>
    </div>
  </div>




   <div class="form-group row">
 <label for="inputEmail3MD" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
               <? if($$unique<1){?>
                        <input name="record" type="submit" id="record" value="Record" onclick="return checkUserName()" class="btn btn-success" />
                        <? }?>
						
						<? if($$unique>0){?>
                        <input name="modify" type="submit" id="modify" value="Modify" class="btn btn-primary" />
                        <? }?>
						
						
						<input name="clear" type="button" class="btn btn-info" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/>
      </div>
    </div>
  </div>

         <?php /*?>   <tr>
              <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><div class="box1">
                  <table class="w-100" border="0">
                      <th></th>
                    <tr>
                      <td><? if($$unique<1){?>
                        <input name="record" type="submit" id="record" value="Record" onclick="return checkUserName()" class="btn" />
                        <? }?></td>
                      <td><? if($$unique>0){?>
                        <input name="modify" type="submit" id="modify" value="Modify" class="btn" />
                        <? }?></td>
                      <td><input name="clear" type="button" class="btn" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </div></td>
            </tr>
          </table><?php */?>
        </form>

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
