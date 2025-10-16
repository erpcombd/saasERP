<?php

session_start();

ob_start();



require_once "../../../assets/support/inc.all.php";



$title='Set Blend Sheet';

$page = "set_blend_sheet.php";

$ajax_page = "blend_sheet_ajax.php";

$page_for = 'Blend Sheet';

do_calander('#blend_date');
do_calander('#target_finish_date');


$table_master='blend_sheet_master';

$table_details='blend_sheet_details';
/*
if($_POST['project']>0)
$project_id=$_SESSION['project'] = $_POST['project'];
elseif($_SESSION['project']>0)
$project_id=$_POST['project']=$_SESSION['project'];*/
$unique='blend_id';








if(isset($_POST['new']))

{
//echo "OK";
		$crud   = new crud($table_master);
		
		if(!isset($_SESSION[$unique])) {
		if(isset($_POST['blend_id'])){
		$$unique = $_SESSION[$unique] = $_POST['blend_id'];}
		
		$_POST['status']='MANUAL';

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
		$project_id=$_POST['project']=$_POST['prj_id'];

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}





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

		//$crud   = new crud($table_master);

		//$crud->update($unique);
		
		
		$sqll='update blend_sheet_master set status="UNCHECKED" where blend_id='.$_SESSION[$unique];
		mysql_query($sqll);

		unset($$unique);

		unset($_SESSION[$unique]);
		
		unset($_POST[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';
		
		echo"<script>
		window.location.assign('select_blend_sheet.php');
		</script>";

}
//echo 'OK'.$$unique  =  find_a_field('blend_sheet_master','max(blend_id)+1','1');
if($_SESSION[$unique]>0){
$$unique=$_SESSION[$unique];}

elseif($_SESSION[$unique]<1){
$$unique  =  find_a_field('blend_sheet_master','max(blend_id)+1','1');}

else{
$$unique=$_POST[$unique];}

//$mjr=$_POST['blend_section_id'];

if(isset($_POST['add1']))

{


		$crud   = new crud('blend_sheet_details');
		
		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[1];
		
		$gi=explode('#>',$_POST['garden_id']);
		
		$_POST['garden_id']=$gi[1];
		
		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);

}





if(isset($_POST['add12']))

{

		$crud   = new crud('blend_sheet_section');
		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['oi_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);

}


if($_GET['del_m_task']>0)

{

		$crud   = new crud('blend_sheet_section');

		$condition="id=".$_GET['del_m_task'];		

		$crud->delete_all($condition);
		
		
		
		 $sql = "delete from blend_sheet_details where blend_section_id =".$_GET['bmid']." and blend_id=".$$unique;

		mysql_query($sql);
		
		

		$type=1;

		$msg='Successfully Deleted.';

		
}


if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		while (list($key, $value)=each($data))

		{ $$key=$value;}

		

}

if($_POST[$unique]>0 || $_SESSION[$unique]>0) $btn_name='Update Blend Sheet Information'; else $btn_name='Initiate Blend Sheet Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

auto_complete_start_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1 and sub_group_id="1096000300010000"','item_id');

auto_complete_start_from_db('tea_garden','garden_name','concat(garden_name,"#>",garden_id)','1 ','garden_id');

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

function count2()

{

var num=((document.getElementById('pkgs').value)*55)-((document.getElementById('sam_qty').value)*1);

document.getElementById('qty').value = num.toFixed(2);	

}



function count()

{

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}



window.onload = function() {
  document.getElementById("sale_no").focus();
};

</script>

<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td valign="top"><fieldset>
          <? $field='blend_id';?>
          <div>
            <label for="<?=$field?>">Blend ID: </label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$unique?>"/>
          </div>
          <? $field='blend_date'; if($blend_date=='') $blend_date =date('Y-m-d'); ?>
          <div>
            <label for="<?=$field?>">Blend Date:</label>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
          </div>
         
          </fieldset></td>
		  
		  
		  
        <td><fieldset>
         
          <div>
            <label for="<?=$field?>">From:</label>
            <input name="warehouse_id" type="hidden" id="warehouse_id"  value="<?=$_SESSION['user']['depot']?>" />
            <input name="warehouse_from3" type="text" id="warehouse_from3" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" />
          </div>
          <div></div>
		  
		  
          <div>
            <label for="<?=$field?>">Blend  Name  :</label>
           <input name="line_id" type="hidden" id="line_id"  value="<?=$line_id=($_POST['line_id']>0)?$_POST['line_id']:$line_id?>" />
            <input name="warehouse_from4" type="text" id="warehouse_from4" style="width:155px;" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>" />
          </div>
          </fieldset></td>
      </tr>
      <tr>
        <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
            <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
          </div></td>
      </tr>
    </table>
    <? if($btn_name=='Update Blend Sheet Information'){?>
    <table  width="50%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
      <tr>
        <td colspan="3" align="center" bgcolor="#CCCCCC">
		<input  name="blend_id" type="hidden" id="blend_id" value="<?=$$unique?>"/>
          <select name="blend_section">
            <option>Select Section Name</option>
			<option value="1" <?php echo ($_POST['blend_section']||$_POST['blend_section_id']==1)?'selected':''?> >Blend Section 1</option>
			<option value="2"  <?php echo ($_POST['blend_section']||$_POST['blend_section_id']==2)?'selected':''?>>Blend Section 2</option>
			<option value="3"  <?php echo ($_POST['blend_section']||$_POST['blend_section_id']==3)?'selected':''?>>Blend Section 3</option>
			<option value="4"  <?php echo ($_POST['blend_section']||$_POST['blend_section_id']==4)?'selected':''?>>Blend Section 4</option>
			<option value="5"  <?php echo ($_POST['blend_section']||$_POST['blend_section_id']==5)?'selected':''?>>Blend Section 5</option>
			
			<option value="6"  <?php echo ($_POST['blend_section']||$_POST['blend_section_id']==6)?'selected':''?>>Blend Section 6</option>
			<option value="7"  <?php echo ($_POST['blend_section']||$_POST['blend_section_id']==7)?'selected':''?>>Blend Section 7</option>
			<option value="8"  <?php echo ($_POST['blend_section']||$_POST['blend_section_id']==8)?'selected':''?>>Blend Section 8</option>
           
          </select></td>
		  <!--<td align="center" bgcolor="#CCCCCC"><input placeholder="Labour Rate" name="lab_rate" type="text" class="input3" id="lab_rate"  style="width:90px;" /></td>-->
        <td align="center" bgcolor="#FF0000"><div class="button">
            <input name="add12" type="submit" id="add12" value="ADD" tabindex="12" class="update"/>
          </div></td>
      </tr>
    </table>
    <? }?>
  </form>
  <br />
  <br />
  <? //if($_SESSION[$unique]>0){

$budg_master=mysql_query('select m.*  from blend_sheet_section m where m.blend_id='.$$unique.'  order by m.id DESC');

while($budg_data=mysql_fetch_object($budg_master)){
?><br /><br />
  <form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
    <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
      <tr bgcolor="#108CC121">
        <td width="6%" align="center"><strong>Sale No</strong> </td>
        <td width="5%" align="center"><strong>Lot No </strong></td>
        <td width="15%" align="center"><strong>Garden Name</strong> </td>
        <td width="7%" align="center"><strong>Invoice No </strong></td>
        <td width="9%" align="center"><strong>Item Gread </strong></td>
        <td width="7%" align="center"><strong>Stock</strong></td>
        <td width="7%" align="center"><strong>Pkgs</strong><?=$budg_data->mjr_task?></td>
        <td width="8%" align="center"><strong>Sample</strong></td>
        <td width="7%" align="center"><strong>Sam Qty</strong></td>
        <td width="7%" align="center"><strong>Total Kgs </strong></td>
        <td width="5%" align="center"><strong>Rate</strong></td>
        <td width="7%" align="center"><strong>Amount</strong></td>
        <td colspan="2" align="center"><a onclick="return confirm('Are You Sure, You Want to Delete this TASK!!')" href="?del_m_task=<?=$budg_data->id?>&bmid=<?=$budg_data->blend_section?>" >Delete This Task</a></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#CCCCCC"><input  name="sale_no" type="text" class="input3" id="sale_no" style="width:30px;"/>
		<input  name="" type="hidden" class="input3" id="" style="width:70px;"  onblur="getData2('stock_view.php', 'stock_view',document.getElementById('garden_id').value,document.getElementById('item_id').value);"/></td>
        <td align="center" bgcolor="#CCCCCC"><input  name="lot_no" type="text" class="input3" id="lot_no" style="width:35px;"/></td>
        <td align="center" bgcolor="#CCCCCC"><input  name="garden_id" type="text" class="input3" id="garden_id" style="width:100px;"/></td>
        <td align="center" bgcolor="#CCCCCC"><input  name="invoice_no" type="text" class="input3" id="invoice_no" style="width:40px;"/></td>
        <td align="center" bgcolor="#CCCCCC"><input  name="item_id" type="text" class="input3" id="item_id" style="width:70px;"  onblur="getData2('stock_view.php', 'stock_view',document.getElementById('garden_id').value,document.getElementById('item_id').value);"/></td>
        <td align="center" bgcolor="#CCCCCC"><span id="stock_view"><input  name="stock" type="text" class="input3" id="stock"  maxlength="100" style="width:50px;" required="required"/></span></td>
        <td align="center" bgcolor="#CCCCCC"><input  name="blend_id" type="hidden" id="blend_id" value="<?=$$unique?>"/>
		<input  name="blend_id" type="hidden" id="blend_id" value="<?=$$unique?>"/>
          <input  name="blend_section_id" type="hidden" id="blend_section_id" value="<?=$budg_data->blend_section?>"/>
          <input  name="pkgs" type="text" class="input3" id="pkgs" style="width:35px;" onkeyup="count2()"/></td>
        <td align="center" bgcolor="#CCCCCC"><select name="sam_pay" id="sam_pay" style="width:40px;" onfocus="count2()">
          <option></option>
          <option>Yes</option>
		  <option>No</option>
        </select></td>
        <td align="center" bgcolor="#CCCCCC"><input  name="sam_qty" type="text" class="input3" id="sam_qty" style="width:35px;"  onkeyup="count2(),count()"/></td>
        <td align="center" bgcolor="#CCCCCC"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" style="width:50px;" onchange="count()" /></td>
        <td align="center" bgcolor="#CCCCCC"><input name="rate" type="text" class="input3" id="rate" style="width:35px;" onkeyup="count()" /></td>
        <td align="center" bgcolor="#CCCCCC"><input name="amount" type="text" class="input3" id="amount" style="width:60px;" /></td>
        <!--<td width="7%" align="center" bgcolor="#CCCCCC"><input  name="total_volume" type="text" class="input3" id="total_volume" style="width:70px;"/></td>-->
        <td width="10%" align="center" bgcolor="#FF0000"><div class="button">
            <input name="add1" type="submit" id="add1" value="ADD" tabindex="12" class="update"/>
        </div></td>
      </tr>
    </table>
   
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div class="tabledesign2">
            <? 
$res='SELECT b.id, b.sale_no, b.lot_no, g.garden_name, b.invoice_no, i.item_name, b.pkgs, b.sam_pay, b.sam_qty, b.qty, b.rate, b.amount, "X" from blend_sheet_details b, item_info i, tea_garden g where g.garden_id=b.garden_id and i.item_id=b.item_id  and b.blend_section_id='.$budg_data->blend_section.' and b.blend_id='.$$unique;

//echo $res;
echo link_report_add_del_auto($res,'',10,12);

?>
          </div></td>
      </tr>
    </table>
  </form>
<? }?>
  <form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    <table width="100%" border="0">
      <tr>
	  
	  
	  <td align="center">



      <input name="delete"  type="submit" class="btn1" value="DELETE AND CANCELED" style="width:270px; font-weight:bold; font-size:12px;color:#F00; height:30px" />



      </td>
	  
	  
	  
	  
        <td align="center"><div align="center">
            <input name="confirmm" type="submit" class="btn1" value="CONFIRM BLEND SHEET" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#090" />
          </div></td>
      </tr>
    </table> 
  </form>
  <? //}?>
</div>
<script>$("#codz").validate();$("#cloud").validate();</script>
<?

require_once "../../../assets/template/layout.bottom.php";

?>
