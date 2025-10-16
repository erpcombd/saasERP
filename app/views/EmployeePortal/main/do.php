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
		$_POST['expense_date']	= date('Y-m-d');
	
    		$$unique=$_SESSION['expense_no'] = $crud->insert();
			$crud   = new crud($table_details);
		    $max_id = rand(1000,1000000);
		
		if($_FILES['att_file']['tmp_name']!=''){
		
						$file_name= $_FILES['att_file']['name'];
			
						$file_tmp= $_FILES['att_file']['tmp_name'];
			
						$ext=end(explode('.',$file_name));
			
						$path='../vehicle_mod/files/fuel/';
						$path2 = 'files/fuel/';
						
						$uploaded_file = $path.$max_id.'.'.$ext;
						$uploaded_file2 = $path2.$max_id.'.'.$ext;
						
						$_POST['att_file'] = $uploaded_file2;
			
						move_uploaded_file($file_tmp, $uploaded_file);
		
					}
		  $_POST['entry_at']  = date('Y-m-d H:i:s');
		  $_POST['entry_by']  = $_SESSION['user_id'];
		  $_POST['expense_no']  =$_SESSION['expense_no'];
		  $_POST['expense_date']  =$_POST['expense_date'];
		  
        $xid = $crud->insert();
    		unset($$unique);
    		$type=1;
    		$msg = $title.'  No Created. (No :-'.$_SESSION['expense_no'].')';

		    
		} else {
		 
		$_POST['expense_no']		    =$_SESSION['expense_no'];
		
//db_query($conn, "update fuel_expense set expense_date='".$_POST['expense_date']."' where expense_no='".$_POST['expense_no']."'");		
		
		$crud->update($unique);
		$crud   = new crud($table_details);
	    $max_id = rand(1000,1000000);
		
		if($_FILES['att_file']['tmp_name']!=''){
		
						$file_name= $_FILES['att_file']['name'];
			
						$file_tmp= $_FILES['att_file']['tmp_name'];
			
						$ext=end(explode('.',$file_name));
			
						$path='../vehicle_mod/files/fuel/';
						$path2 = 'files/fuel/';
						
						$uploaded_file = $path.$max_id.'.'.$ext;
						$uploaded_file2 = $path2.$max_id.'.'.$ext;
						
						$_POST['att_file'] = $uploaded_file2;
			
						move_uploaded_file($file_tmp, $uploaded_file);
		
					}
		  $_POST['entry_at']  = date('Y-m-d H:i:s');
		  $_POST['entry_by']  = $_SESSION['user_id'];
		  $_POST['expense_no']  =$_SESSION['expense_no'];
		  $_POST['expense_date']  =$_POST['expense_date'];
        $xid = $crud->insert();
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
        $crud   = new crud($table_master);
		$crud->update($unique);
		$crud   = new crud($table_details);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION['expense_no']);
		unset($_SESSION['expense_no']);
		$type=1;
		$msg='Successfully Drafted.';
		?><script>window.location.href='do_unfinished.php';</script><?php 
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
		$_POST['entry_by']=$_SESSION['user_id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		


        $pp=$$unique;
		unset($$unique);
		unset($_SESSION['expense_no']);
		$type=1;

        $_SESSION['msg']='<span style="color:green; font-weight:bold">Bill Claimed Successfully.</span>';

?><script>window.location.href='home.php';</script><?  
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


if($$unique>0) $btn_name='Add More Items'; else $btn_name='Add Items';

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
<!--<?php if(isset($msg)){ ?><div class="alert alert-primary msg" role="alert"><?php echo @$msg; ?></div><?php } ?>-->
<!--<?php if(isset($emsg)){ ?><div class="alert alert-danger emsg" role="alert"><?php echo @$emsg; ?></div><?php } ?>-->
            


<div class="form-container_large">
<form action="do.php" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}" enctype="multipart/form-data">


<div class="form-group row">
            <div class="col-4"><label for="expense_no" class="col-form-label">Claim No:</label></div> <!--sk-->
            <div class="col-8 mb-1"><div class="col-sm-3"><? $field='expense_no';?><input  class="form-control border border-info" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" disabled="disabled"/></div></div>

           <div class="col-4"><label for="expense_no" class="col-form-label">Claim Date:</label></div> <!--sk-->
            <div class="col-8 mb-1"><div class="col-sm-3"><? $field='expense_date';?><input  class="form-control border border-info" name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" required/></div></div>
			
			<div class="col-4"><label for="expense_no" class="col-form-label">Vehicle:</label></div> <!--sk-->
            <div class="col-8 mb-1"><div class="col-sm-3"><? $field='vehicle';?><select  class="form-control border border-info" name="<?=$field?>" id="<?=$field?>" required>
			<option></option>
			<? foreign_relation('vehicle_info','vehicle_id','vehicle_name',$_POST['vehicle'],'1')?>
			</select>
			</div></div>
			
			<div class="col-4"><label for="expense_no" class="col-form-label">Items:</label></div> <!--sk-->
            <div class="col-8 mb-1"><div class="col-sm-3"><? $field='item_id';?><select  class="form-control border border-info" name="<?=$field?>" id="<?=$field?>" required>
			<option></option>
			<? foreign_relation('expense_head','id','expense_name',$_POST['item_id'],'1')?>
			</select>
			</div></div>
			
			<div class="col-4"><label for="expense_no" class="col-form-label">Qty:</label></div> <!--sk-->
            <div class="col-8 mb-1"><div class="col-sm-3"><? $field='qty';?><input  class="form-control border border-info" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
			</div></div>
			
			<div class="col-4"><label for="expense_no" class="col-form-label">Vendor:</label></div> <!--sk-->
            <div class="col-8 mb-1"><div class="col-sm-3"><? $field='vendor';?><input  class="form-control border border-info" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/></div></div>
			
			<div class="col-4"><label for="expense_no" class="col-form-label">Amount:</label></div> <!--sk-->
            <div class="col-8 mb-1"><div class="col-sm-3"><? $field='amount';?><input  class="form-control border border-info" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/></div></div>
			
			<div class="col-4"><label for="expense_no" class="col-form-label">Meter Reading:</label></div> <!--sk-->
            <div class="col-8 mb-1"><div class="col-sm-3"><? $field='mileage';?><input  class="form-control border border-info" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/></div></div>
			
			<div class="col-4"><label for="expense_no" class="col-form-label">Attach:</label></div> <!--sk-->
            <div class="col-8 mb-1"><div class="col-sm-3"><? $field='expense_no';?><input  class="form-control border border-info" name="att_file" type="file" id="att_file"/></div></div>
</div>    

</br>
 
<div class="form-group row mb-12">
    
            
			
			
			

            <div class="col-12">
                     <!--<input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>" required="required"/>  -->
                      <div class="form-group row">
                        <div class="col-sm-12 text-center">
                          <button name="new" type="submit" class="btn btn-info mt-1"><?=$btn_name?></button>
                        </div>
                      </div>
                
            </div>

</div> <!--Row end-->


<!--end-->
</form>




<? 
$res='select a.id,i.expense_name as name,a.qty as qty,a.rate as rate,a.amount as amt,a.att_file,a.vendor,"x" 
from '.$table_details.' a, expense_head i 
where i.id=a.item_id and a.expense_no='.$_SESSION['expense_no'].' order by a.id desc';
//echo link_report_add_del_auto($res,'',3,5);
?>


<table class="table table-striped" id="grp" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>Items</th>
		<th>Amount</th>
		<th>Attach</th>
		<th>X</th>
	</tr>
<?
$sl=1;
$query=db_query($conn, $res);
while($info=mysqli_fetch_object($query)){ ?>
<tr>
    <td><span class="ccc"><?=$info->name.'-'.$info->vendor?></span></td>
	<td><?=$info->amt?></td>
    <td><a href="../vehicle_mod/<?=$info->att_file?>" target="_blank">View</a></td>
    <td><a href="?del=<?=$info->id;?>" target="">X</a></td>
</tr>
<? 
$gamt +=$info->amt;
} ?>
<tr>
	<td colspan="1"><strong>Total Amount</strong></td>
    <td><strong><?=number_format($gamt,2)?></strong></td>
	<td><strong></strong></td> 
	<td><strong></strong></td>
</tr>    
</table>
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center"><button name="delete" type="submit" value="delete" class="btn btn-danger">Full Delete</button></td>
	  <td align="center"><button name="hold" type="submit" value="hold" class="btn btn-info">Draft</button></td>
      <td align="center"><button name="confirmm" type="submit" value="Bill Claim" class="btn btn-primary">Bill Claim</button></td>
    </tr>
  </table>
</form>

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