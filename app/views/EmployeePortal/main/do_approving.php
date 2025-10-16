<?php
session_start();
include 'config/db.php';
include 'config/crud.php';
include 'config/function.php';
include 'config/access.php';
$user_id	=$_SESSION['user_id'];

$page="do";

include "inc/header.php";

if($_GET['pal']==2) { unset($$unique); unset($_SESSION['expense_no']); $type=1;}
//$dealer_code2 = $_GET['ss'];


$page_for           ='Sec Sales';
$table_master       ='fuel_expense';
$table_details      ='fuel_expense_detail';
$unique             ='expense_no';


if($_GET['expense_no']>0) $_SESSION['expense_no']=$_GET['expense_no'];



if(isset($_POST['new'])){

		$crud   = new crud($table_master);
		
		if(!isset($_SESSION['expense_no'])) {
		
		$_POST['entry_by']	=$_SESSION['user_id'];
		$_POST['entry_at']	=date('Y-m-d H:i:s');
		//$_POST['edit_by']	=$_SESSION['username'];
		//$_POST['edit_at']	=date('Y-m-d H:i:s');

	
	//  $_POST['warehouse_id']  = $_SESSION['warehouse_id'];
		
	//	$_POST['vendor_name']	= find1('select name from ledger_head where id="'.$_POST['dealer_code'].'"');
	
    		$$unique=$_SESSION['expense_no'] = $crud->insert();
    		unset($$unique);
    		$type=1;
    		$msg = $title.'  No Created. (No :-'.$_SESSION['expense_no'].')';

		    
		} else {
		 
		//$_POST['edit_by']	    =$_SESSION['username'];
		//$_POST['edit_at']	    =date('Y-m-d H:i:s');
		$_POST['expense_no']		    =$_SESSION['expense_no'];
		
db_query($conn, "update fuel_expense set expense_date='".$_POST['expense_date']."' where expense_no='".$_POST['expense_no']."'");		
		
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}

    
} // end initiate

$$unique=$_SESSION['expense_no'];



if(isset($_POST['delete'])){

		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION['expense_no']);
		unset($_SESSION['expense_no']);
		$type=1;
		$msg='Successfully Deleted.';
}

if(isset($_POST['hold'])){

        $_POST['status'] = 'MANUAL';
		$_POST[$unique]=$$unique;
        $crud   = new crud($table_master);
		$crud->update($unique);
		$crud   = new crud($table_details);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION['expense_no']);
		unset($_SESSION['expense_no']);
		$type=1;
		$_SESSION['msg']='<span style="color:green; font-weight:bold">Returned Successfully.</span>';
		?><script>window.location.href='unapproved_fuel.php';</script><?php 
}




if($_GET['del']>0){

		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		
		$type=1;
		$msg='Successfully Deleted.';
		
}




if(isset($_POST['confirmm'])){
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['approved_by']=$_SESSION['user_id'];
		$_POST['approved_at']=date('Y-m-d H:i:s');
		$_POST['status']='APPROVED';
		$crud   = new crud($table_master);
		$crud->update($unique);


        $pp=$$unique;
		unset($$unique);
		unset($_SESSION['expense_no']);
		$type=1;

        $_SESSION['msg']='<span style="color:green; font-weight:bold">Approved Successfully.</span>';

?><script>window.location.href='unapproved_fuel.php';</script><?  
} // End confirm




if(isset($_POST['add'])&&($_POST[$unique]>0)){
		$crud   = new crud($table_details);
		$max_id = find_a_field('fuel_expense_detail','max(id)+1','1');
		
		if($_FILES['att_file']['tmp_name']!=''){
		
						$file_name= $_FILES['att_file']['name'];
			
						$file_tmp= $_FILES['att_file']['tmp_name'];
			
						$ext=end(explode('.',$file_name));
			
						$path='files/fuel/';
						
						$uploaded_file = $path.$max_id.'.'.$ext;
						
						$_POST['att_file'] = $uploaded_file;
			
						move_uploaded_file($file_tmp, $uploaded_file);
		
					}
		  $_POST['entry_at']  = date('Y-m-d H:i:s');
		  $_POST['entry_by']  = $_SESSION['user_id'];
        

		//$_POST['item_id'] = find_a_field('item_info','item_id','finish_goods_code='.$_POST['item_id2']);
        $xid = $crud->insert();
    }




if($$unique>0){
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}


if($$unique>0) $btn_name='Update DO'; else $btn_name='Initiate';

if($_SESSION['expense_no']<1)
$$unique=db_last_insert_id($table_master,$unique);

?>
<script language="javascript">
function focuson(id) {
  if(document.getElementById('id').value=='')
  document.getElementById('id').focus();
  else
  document.getElementById(id).focus();
}
</script>


<script language="javascript">
function count(){
                    var num=((document.getElementById('total_unit').value)*1)*((document.getElementById('unit_price').value)*1);
                    document.getElementById('total_amt').value = num.toFixed(2);
                    $("#add").show();
                    $('#total_unit').next().focus();
      
}
</script>







<!-- --------------- main page content ----------------- -->
<style>
body{
font-size: 14px;   
}    
</style>

<div class="main-container container">


<div class="form-container_large">


<?php 

if($_SESSION['expense_no']>0){ ?>


<? 
$res='select a.id,i.expense_name as name,a.expense_date,a.expense_no,a.qty as qty,a.rate as rate,a.amount as amt,a.att_file,a.vendor,"x" 
from '.$table_details.' a, expense_head i 
where i.id=a.item_id and a.expense_no='.$_SESSION['expense_no'].' order by a.id desc';
//echo link_report_add_del_auto($res,'',3,5);
?>


<table class="table table-striped" id="grp" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>Claim No.</th>
		<th>Date</th>
		<th>Items</th>
		<th>Amount</th>
		<th>Attach</th>
	</tr>
<?
$sl=1;
$query=db_query($conn, $res);
while($info=mysqli_fetch_object($query)){ ?>
<tr>
    <td><?=$info->expense_no?></td>
	<td><?=$info->expense_date?></td>
    <td><span class="ccc"><?=$info->name.'-'.$info->vendor?></span></td>
	<td><?=$info->amt?></td>
    <td><a href="../vehicle_mod/<?=$info->att_file?>" target="_blank">View</a></td>
</tr>
<? 
$gamt +=$info->amt;
} ?>
<tr>
	<td colspan="3"><strong>Total Amount</strong></td>
    <td><strong><?=number_format($gamt,2)?></strong></td>
	<td><strong></strong></td> 
</tr>    
</table>
<!--SK-->




<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
	  <td align="center"><button name="hold" type="submit" value="hold" class="btn btn-danger">Return To User</button></td>
      <td align="center"><button name="confirmm" type="submit" value="Bill Claim" class="btn btn-primary">Approve</button></td>
    </tr>
  </table>
</form>
<? } ?>
</div>



        
</div>
<!-- main page content ends -->
</main>
<!-- Page ends-->

<?php include "inc/footer.php"; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
 
<script>
function getData(){
    
var id = document.getElementById("item_id").value;

		jQuery.ajax({
			url:'ajax_json_price.php',
			type:'post',
			data:'id='+id,
			success:function(result){
				var json_data=jQuery.parseJSON(result);

				jQuery('#unit_name').val(json_data.unit);
				//jQuery('#stock').val(json_data.stock);
				//jQuery('#cost_rate').val(json_data.cost_rate);
				jQuery('#unit_price').val(json_data.price);

			}

		})
	
}
</script> 
 

<!--https://harvesthq.github.io/chosen/-->
<script>
jQuery('.party_list').chosen();
jQuery('.item_list').chosen();
</script>