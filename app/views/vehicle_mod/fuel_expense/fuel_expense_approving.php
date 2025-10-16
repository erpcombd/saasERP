<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

$title='Fuel Expense Approving..';

$page = "fuel_expense_approving.php";

$ajax_page = "fuel_expense_ajax.php";

$page_for = 'Office Expense';

//do_calander('#expense_date','-10','0');

//do_calander('#expense_date');

$table_master='fuel_expense';

$table_details='fuel_expense_detail';

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

		$_POST['approved_by']=$_SESSION['user']['id'];

		$_POST['approved_at']=date('Y-m-d h:s:i');

		$_POST['status']='APPROVED';

		$crud   = new crud($table_master);
		$crud->update($unique);
		
		$crud   = new crud($table_details);
		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$_SESSION['msg']='Successfully Approved.';
		header('location:unapprove_f_expense.php');

}

if(isset($_POST['return']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['approved_by']=$_SESSION['user']['id'];

		$_POST['approved_at']=date('Y-m-d h:s:i');

		$_POST['status']='UNCHECKED';

		$crud   = new crud($table_master);
        $crud->update($unique);
		$crud   = new crud($table_details);
		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$_SESSION['msg']='Successfully Returned.';
		header('location:unapprove_f_expense.php');

}

/*if(isset($_POST['delete'])){
 if($$unique>0){
  mysql_query('delete from warehouse_other_issue where expense_no="'.$$unique.'" and issue_type="Damage Issue"');
  mysql_query('delete from warehouse_other_issue_detail where expense_no="'.$$unique.'" and issue_type="Damage Issue"');
  unset($_SESSION[$unique]);
  header('location:fuel_expense.php');
 }
}*/

if(isset($_POST['add'])&&($_POST[$unique]>0))

{
        
		$crud   = new crud($table_details);

		$iii=explode('#>',$_POST['item_id']);

		$_POST['item_id']=$iii[1];
		
		$max_id = find_a_field('fuel_expense_detail','max(id)+1','1');
		
		if($_FILES['att_file']['tmp_name']!=''){
		
						$file_name= $_FILES['att_file']['name'];
			
						$file_tmp= $_FILES['att_file']['tmp_name'];
			
						$ext=end(explode('.',$file_name));
			
						$path='../../files/expense/';
						
						$uploaded_file = $path.$max_id.'.'.$ext;
						
						$_POST['att_file'] = $uploaded_file;
			
						move_uploaded_file($file_tmp, $uploaded_file);
		
					}
					
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

auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','1','item_id');

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

</script>

<div class="form-container_large">



<? if($_SESSION[$unique]>0){?>

<form action="" method="post" name="codz2" id="codz2" autocomplete="off" enctype="multipart/form-data">
<? 
$res='select a.id,b.expense_name,a.expense_date,a.expense_no,a.rate as unit_price,a.qty ,a.uom as unit_name,a.amount,a.vendor,a.att_file,"x" from fuel_expense_detail a,expense_head b where  b.id=a.item_id and a.expense_no='.$expense_no;
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
        <th><div align="center">Expense NO</div></th>
		<th><div align="center">Date</div></th>
		<th><div align="center">Items</div></th>
		<th><div align="center">Qty</div></th>
		<th><div align="center">Amount</div></th>
		<th><div align="center">Attachment</div></th>
      </tr>
	  <?
	   while($data=mysqli_fetch_object($qrry)){
	  ?>
	  <tr>
	    <td style="padding:5px;"><?=$data->expense_no?></td>
		<td style="padding:5px;"><?=$data->expense_date?></td>
		<td style="padding:5px;"><?='Purchased '.$data->item_name.' From '.$data->vendor?></td>
		<td style="padding:5px;"><?=$data->qty?></td>
		<td style="padding:5px;"><?=$data->amount?></td>
		<td style="padding:5px;"><? if($data->att_file!=''){?><a href="../../../vehicle_mod/<?=$data->att_file?>" target="_blank">View Attachment</a><? } ?></td>
		<td style="padding:5px;"><a href="?del=<?=$data->id?>">X</a></td>
	  </tr>
	  <? } ?>
    </table>
  </form>

<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

  <table width="100%" border="0">

    <tr>

     
	  
	  
	  

      <td align="center"><input name="return" type="submit" class="btn1" value="Return To User" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:red;" /></td>
	   <td align="center">&nbsp;</td>
      <td align="center"><input name="confirmm" type="submit" class="btn1" value="Approve" style="width:270px; float:right; font-weight:bold; font-size:12px; height:30px; color:#090" /></td>
    </tr>
  </table>

</form>

<? }?>

</div>

<script>$("#codz").validate();$("#cloud").validate();</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>