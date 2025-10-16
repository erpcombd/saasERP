<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

$title='Tools Maintenance Entry';

$page = "tools_entry.php";

$ajax_page = "fuel_expense_ajax.php";

$page_for = 'Tools Maintenance';

//do_calander('#expense_date','-10','0');

do_calander('#expense_date');

$table_master='tool_maintenance';

$table_details='tool_maintenance_detail';

$unique='expense_no';

if($_GET['mhafuz']==2)
unset($_SESSION[$unique]);

if($_GET['expense_no']>0)
$_SESSION[$unique]=$_GET['expense_no'];



if(isset($_POST['new']))

{

		$crud   = new crud($table_master);



		if(!isset($_SESSION[$unique])) {

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$$unique=$_SESSION[$unique]=$crud->insert();

		unset($$unique);

		$type=1;

		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';

		}

		else {

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

		}

}



$$unique=$_SESSION[$unique];



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

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='UNCHECKED';

		$crud   = new crud($table_master);
		$crud->update($unique);
		
		$crud   = new crud($table_details);
		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Forwarded.';

}

if(isset($_POST['draft']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:s:i');

		$_POST['status']='MANUAL';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Drafted.';

}

/*if(isset($_POST['delete'])){
 if($$unique>0){
  mysql_query('delete from warehouse_other_issue where expense_no="'.$$unique.'" and issue_type="Damage Issue"');
  mysql_query('delete from warehouse_other_issue_detail where expense_no="'.$$unique.'" and issue_type="Damage Issue"');
  unset($_SESSION[$unique]);
  header('location:tools_entry.php');
 }
}*/

if(isset($_POST['add'])&&($_POST[$unique]>0))

{
        
		$crud   = new crud($table_details);

		

		
		
		$max_id = rand(1000,1000000);
		
		if($_FILES['att_file']['tmp_name']!=''){
		
						$file_name= $_FILES['att_file']['name'];
			
						$file_tmp= $_FILES['att_file']['tmp_name'];
			
						$ext=end(explode('.',$file_name));
			
						$path='../../files/fuel/';
						$path2='files/fuel/';
						
						$uploaded_file = $path.$max_id.'.'.$ext;
						$uploaded_file2 = $path2.$max_id.'.'.$ext;
						
						$_POST['att_file'] = $uploaded_file2;
			
						move_uploaded_file($file_tmp, $uploaded_file);
		
					}
					$_POST['entry_by'] = $_SESSION['user']['id'];
					$_POST['entry_at'] = date('Y-m-d H:i:s');
					$xid = $crud->insert();

		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['expense_date'],0,$_POST['qty'],$page_for,$xid,$_POST['rate'],'',$$unique);

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update Expense Information'; else $btn_name='Initiate Expense Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



//auto_complete_from_db($table,$show,$id,$con,$text_field_id);

$depot_type = find_a_field('warehouse','use_type','warehouse_id="'.$_SESSION['user']['depot'].'"');

//if($depot_type =='SD')

//auto_complete_from_db('tools','concat(driver_name,"#>",driver_id','concat(driver_name,"#>",driver_id)','1','driver_id');

//else

//auto_complete_from_db('item_info','finish_goods_code','concat(item_name,"#>",item_id)','1','item_id');

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

function count()

{

var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);

document.getElementById('amount').value = num.toFixed(2);	

}

function total_amtt(){

var qty=$("#qty").val();
var rate=$("#rate").val();

$("#amount").val(qty*rate);

}

</script>

<div class="form-container_large">

<form action="tools_entry.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}" enctype="multipart/form-data">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

  <div class="row ">
    
	
	     <div class="col-md-3 form-group" align="center">
            <label for="do_no" >Expense No: </label>
            <input   name="expense_no" type="text" class="form-control" id="expense_no" value="<? if($expense_no>0) echo $expense_no; else echo (find_a_field($table_master,'max('.         $unique_master.')','1')+1);?>" readonly/>
          </div>
		  
		  
	  
   </div>

  <tr>

    <td colspan="2"><div class="buttonrow" style="margin-left:40%;">

      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />

    </div></td>

    </tr>
	
	<tr>
	  <td class="2" align="center"><?=$msg;?></td>
	</tr>

</table>

</form>

<? if($_SESSION[$unique]>0){?>

<form action="" method="post" name="codz2" id="codz2" autocomplete="off" enctype="multipart/form-data">
    
    <table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
      <tr>
        <td align="center" width="10%" bgcolor="#0099FF"><strong>Tools List</strong></td>
        <td align="center" width="10%" bgcolor="#0099FF">Vehicle </td>
        <td align="center" width="25%" bgcolor="#0099FF"><span style="font-weight: bold">Vendor</span></td>
        <td align="center" width="15%" bgcolor="#0099FF">Entry  Date </td>
        <td align="center" width="10%" bgcolor="#0099FF">Qty</td>
		<td align="center" width="15%" bgcolor="#0099FF">Rate</td>
        <td align="center" width="15%" bgcolor="#0099FF"><strong>Amount</strong></td>
		<td align="center" width="15%" bgcolor="#0099FF"><strong>Attachment</strong></td>
        <td  rowspan="2" width="11%" align="center" bgcolor="#FF0000"><div class="button">
            <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update" onclick="stock_check();"/>
          </div></td>
      </tr>
      <tr>
        <td align="center" bgcolor="#CCCCCC"><div align="center">
            <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>

  <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>


            <!--<input  name="item_id" type="text" id="item_id" value="<?=$item_id?>" style="width:98%;" required onblur="getData2('fuel_expense_ajax.php', 'pr', this.value, document.getElementById('item_id').value);"/>-->
			<select  name="item_id" type="text" id="item_id" style="width:98%;" required>
			<option></option>
			<? foreign_relation('tools','driver_id','driver_name',$item_id,'1');?>
			</select>
      
          </div></td>
		              <td align="center" bgcolor="#CCCCCC"><select name="vehicle" id="vehicle" class="input3" style="width:98%;" required>
			<option></option>
			 <? foreign_relation('vehicle_info','vehicle_id','vehicle_name',$_POST['vehicle'],'1');?>
			</select></td> 
			
			<td align="center" bgcolor="#CCCCCC"><input name="vendor" type="text" class="input3" id="vendor"  maxlength="100" style="width:98%;" required/></td>
            <td align="center" bgcolor="#CCCCCC"><input name="expense_date" type="text" class="input3" id="expense_date"  maxlength="100" style="width:98%;" required/></td>
            <td bgcolor="#CCCCCC" align="center"><input name="qty" type="text" class="input3" id="qty"  style="width:115px;" required  onkeyup="total_amtt()"/></td>
			<td bgcolor="#CCCCCC" align="center"><input name="rate" type="text" class="input3" id="rate"  style="width:115px;" required  onkeyup="total_amtt()"/></td>
            <td bgcolor="#CCCCCC" align="center"><input name="amount" type="text" class="input3" id="amount"  style="width:115px;" required  onkeyup="total_amtt()"/></td>
			<td bgcolor="#CCCCCC" width="33%"><input name="att_file" type="file" class="input3" id="att_file"  maxlength="100" style="width:98%;" /></td>
      </tr>
    </table>
    <br />
    <br />
    <br />
    <br />
    <? 



//$res='select a.id,b.finish_goods_code as code,b.item_name,b.unit_name,FLOOR(a.total_unit/b.pack_size) as total_qty,a.total_unit%b.pack_size as pcs_qty,"X" from production_issue_detail a,item_info b where b.item_id=a.item_id and a.pi_no='.$$unique_master.' order by a.id';


 $res='select a.id,b.driver_name as item_name,a.rate as unit_price,a.vendor,a.qty,a.rate ,a.uom as unit_name,a.amount,a.att_file,v.vehicle_name,"x" from tool_maintenance_detail a,tools b,vehicle_info v where  b.driver_id=a.item_id and a.vehicle=v.vehicle_id and a.expense_no='.$expense_no;

$qrry = db_query($res);

?>
    <table width="100%" border="1" style="border-collapse:collapse;" cellspacing="0" cellpadding="0">
      <!--<tr>
        <td><div class="tabledesign2">
            <? 

echo link_report_add_del_auto($res,'',4,6);

		?>
          </div></td>
      </tr>-->
      <tr bgcolor="#215470" style="color:#FFFFFF;">
        <th><div align="center">SL</div></th>
		<th><div align="center">Items</div></th>
		<th><div align="center">Vehicle</div></th>
		<th><div align="center">Qty</div></th>
		<th><div align="center">Rate</div></th>
		<th><div align="center">Amount</div></th>
		<th><div align="center">Attachment</div></th>
		<th><div align="center">Action</div></th>
      </tr>
	  <?
	   while($data=mysqli_fetch_object($qrry)){
	  ?>
	  <tr>
	    <td style="padding:5px;"><?=++$i?></td>
		<td style="padding:5px;"><?='Purchased '.$data->item_name.' From '.$data->vendor?></td>
		<td style="padding:5px;"><?=$data->vehicle_name?></td>
		<td style="padding:5px;"><?=$data->qty?></td>
		<td style="padding:5px;"><?=$data->rate?></td>
		<td style="padding:5px;"><?=$data->amount?></td>
		<td style="padding:5px;"><? if($data->att_file!=''){?> <a href="../../../vehicle_mod/<?=$data->att_file?>" target="_blank">View Attachment</a> <?}?></td>
		<td style="padding:5px;"><a href="?del=<?=$data->id?>">X</a></td>
	  </tr>
	  <? } ?>
    </table>
  </form>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

     
	  
	  
	  

      <td align="center"><input name="delete" type="submit" class="btn1" value="Delete This" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:red;" /></td>
	   <td align="center"><input name="draft" type="submit" class="btn1" value="Draft" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>
      <td align="center"><input name="confirmm" type="submit" class="btn1" value="Claim Bill Now" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>
    </tr>
  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>