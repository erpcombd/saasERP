<?php
session_start();
include 'config/db.php';
include 'config/crud.php';
include 'config/function.php';
include 'config/access.php';
$user_id	=$_SESSION['user_id'];

$page="sales_return";

include "inc/header.php";

if($_GET['pal']==2) { unset($$unique); unset($_SESSION['do_no2']); $type=1;}
//$dealer_code2 = $_GET['ss'];


$page_for           ='Sec Sales';
$table_master       ='ss_return_master';
$table_details      ='ss_return_details';
$unique             ='do_no';


if($_GET['do_no']>0) $_SESSION['do_no2']=$_GET['do_no'];



if(isset($_POST['new'])){

		$crud   = new crud($table_master);
		
		if(!isset($_SESSION['do_no2'])) {
		
		$_POST['entry_by']	=$_SESSION['username'];
		$_POST['entry_at']	=date('Y-m-d H:i:s');
		//$_POST['edit_by']	=$_SESSION['username'];
		//$_POST['edit_at']	=date('Y-m-d H:i:s');

	
	//  $_POST['warehouse_id']  = $_SESSION['warehouse_id'];
		
	//	$_POST['vendor_name']	= find1('select name from ledger_head where id="'.$_POST['dealer_code'].'"');
	
    		$$unique=$_SESSION['do_no2'] = $crud->insert();
    		unset($$unique);
    		$type=1;
    		$msg = $title.'  No Created. (No :-'.$_SESSION['do_no2'].')';

		    
		} else {
		 
		//$_POST['edit_by']	    =$_SESSION['username'];
		//$_POST['edit_at']	    =date('Y-m-d H:i:s');
		$_POST['do_no']		    =$_SESSION['do_no2'];
		
db_query($conn, "update ss_return_master set do_date='".$_POST['do_date']."' where do_no='".$_POST['do_no']."'");		
		
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}

    
} // end initiate

$$unique=$_SESSION['do_no2'];



if(isset($_POST['delete'])){

		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION['do_no2']);
		$type=1;
		$msg='Successfully Deleted.';
}

if(isset($_POST['hold'])){
		unset($$unique);
		unset($_SESSION['do_no2']);
		$type=1;
		$msg='Successfully Holded.';
		?><script>window.location.href='do.php?pal=2';</script><?php 
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
		$_POST['entry_by']=$_SESSION['username'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);


    $pp=$$unique;
		unset($$unique);
		unset($_SESSION['do_no2']);
		$type=1;

$msg='Successfully Forwarded.';

?><script>window.location.href='home.php';</script><?  
} // End confirm




if(isset($_POST['add'])&&($_POST[$unique]>0)){
		$crud   = new crud($table_details);
		//$iii=explode('##',$_POST['id']);
		//$_POST['item_id']=$iii[0];
		
		//$_POST['unit_name']     =$_POST['unit'];
		//$_POST['rate']          =$_POST['price'];
		//$_POST['warehouse_id']  =$_SESSION['warehouse_id'];
        

    if($_POST['item_id2']>0) {
		unset($_POST['id']);
		$_POST['item_id'] = find_a_field('item_info','item_id','finish_goods_code='.$_POST['item_id2']);
        $xid = $crud->insert();
    }


}


if($$unique>0){
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}


if($$unique>0) $btn_name='Update DO'; else $btn_name='Initiate';

if($_SESSION['do_no2']<1)
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
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">


<div class="form-group row">
            <div class="col-3"><label for="do_no" class="col-form-label">Secondary Sale Summary :</label></div> <!--sk-->
            <div class="col-3 mb-1"><div class="col-sm-3"><? $field='do_no';?><input  class="form-control border border-info" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" disabled="disabled"/></div></div>

            <div class="col-1"><label for="do_date" class="col-form-label">Date</label></div> 
            <div class="col-5"><? $field='do_date'; if($do_date=='') $do_date =date('Y-m-d'); ?><input  class="form-control border border-info" name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" required/></div>
</div>    

</br>
 
<div class="form-group row mb-2">
    
            <div class="col-2"><label for="shop" class="col-sm-2 col-form-label size-12">Memo Number:</label></div> 
            <div class="col-4"><? $field='memo_no';?>

                <? //if($_GET['ss']>0){?>
                    <!--<select class="form-control border border-info" name="<?=$field?>" id="<?=$field?>" autocomplete="off" required/>
                    <option value="<?=$_GET['ss']?>"><?=find1("select shop_name from ss_shop where dealer_code='".$_GET['ss']."'");?></option>
                    </select>-->
                <? //}else{ ?>
                    
                      <input class="form-control border border-info"  name="<?=$field?>" id="<?=$field?>" 
                      value="<?=$$field?>" autocomplete="off" required/>
                      <datalist id="party">
                    	
                    	<option value="<?=$$field?>"><?=$$field?></option>
                    	<?php optionlist('select dealer_code,shop_name from ss_shop where status="1" order by shop_name');?>
                      </datalist>
                    <?php //echo $party_name=find1('select shop_name from ss_shop where dealer_code="'.$$field.'"');?> 
                <? //} ?>
            </div>
			
			
			<div class="col-2"><label for="shop" class="col-sm-2 col-form-label size-12">Dealer:</label></div> 
            <div class="col-4">
				<input class="form-control border border-info" list="browsers" name="dealer_code" id="dealer_code" value="<?=$dealer_code?>" tabindex="1" autocomplete="off" required/>
    			<datalist id="browsers">
					<? foreign_relation('dealer_info','dealer_code','concat(dealer_name_e,"[",address_e,"]","[",mobile_no,"]")',$dealer_code,'dealer_type="Distributor" and canceled="Yes" and account_code>0');?>
    			</datalist>
            </div>
			
			
			<div class="col-2"><label for="shop" class="col-sm-2 col-form-label size-12">Sales Officer:</label></div> 
            <div class="col-4">
				<input class="form-control border border-info" list="employee_ids" name="employee_id" id="employee_id" value="<?=$employee_id?>" tabindex="1" autocomplete="off" required/>
    			<datalist id="employee_ids">
			<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME', $employee_id,'PBI_DESIGNATION="SO" ');?>
    			</datalist>
            </div>
			
			

            <div class="col-5">
                     <!--<input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>" required="required"/>  -->
                      <div class="form-group row">
                        <div class="col-sm-10 text-center">
                          <button name="new" type="submit" class="btn btn-info mt-1"><?=$btn_name?></button>
                        </div>
                      </div>
                
            </div>

</div> <!--Row end-->


<!--end-->
</form>







<?php 

if($_SESSION['do_no2']>0){ ?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">


<tr>
    <td colspan="2" align="center"><span class="style1">Item Name:</span></td>
    <td colspan="2" align="center" bgcolor="#CCCCCC">
    <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
    <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
    <input  name="do_date" type="hidden" id="do_date" value="<?=$do_date?>"/>
    <input  name="dealer_code" type="hidden" id="dealer_code" value="<?=$dealer_code?>"/>
    
    <input class="form-control border border-info" list="items" name="item_id2" id="item_id" tabindex="1" onChange="getData()" autocomplete="off"/>
    <datalist id="items">
    	<?php optionlist('select finish_goods_code,item_name from item_info where 1 and finish_goods_code>0 and status=1 and product_nature in ("Both","Salable") order by item_name');?>
    </datalist>
    </td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td align="center" bgcolor="#0099FF"><span class="style1"><strong>Unit</strong></span></td>
    <td align="center" bgcolor="#0099FF"><span class="style1"><strong>    </strong></span></td>
    <td align="center" bgcolor="#0099FF"><span class="style1"><strong>Quantity</strong></span></td> <!--SK-->
    <td align="center" bgcolor="#0099FF"><span class="style1"><strong>   </strong></span></td>
    <td></td>
    <td></td>
</tr>

<tr>
    <td align="center" bgcolor="#CCCCCC">
    <input name="unit_name" type="text" class="input3" id="unit_name" tabindex="2" style="width:50px;" value="Pcs" readonly="readonly"/>
    </td>
    
    <td align="center" bgcolor="#CCCCCC">
    <input name="unit_price" type="hidden" class="input3" id="unit_price" tabindex="4" style="width:80px;"  onChange="count()" autocomplete="off" readonly/>
    </td>
    
    
    <td align="center" bgcolor="#CCCCCC"><input name="total_unit" tabindex="5" type="number" class="input3" id="total_unit"  maxlength="100" style="width:60px;" onChange="count()" required autocomplete="off"/></td>
    <td align="center" bgcolor="#CCCCCC"><input name="total_amt" tabindex="6" type="hidden" class="input3" id="total_amt" style="width:90px;" readonly="readonly" required/></td>
    
    <td align="center" ><div class="button"><button name="add" type="submit" id="add" class="btn btn-warning" tabindex="7">ADD</button></div></td>
</tr>

</table>


<!--<p>Hello</p>-->


<? 
$res='select a.id,concat(i.finish_goods_code," ",i.item_name) as name,round(a.unit_price,0) as price,a.total_unit as qty,a.total_amt as amt,"x" 
from '.$table_details.' a, item_info i 
where i.item_id=a.item_id and a.do_no='.$do_no.' order by a.id desc';
//echo link_report_add_del_auto($res,'',3,5);
?>



<style>
.ccc {
  width: 10px !important; 
  /*border: 1px solid #000000;*/
  word-wrap: break-word;
}
</style>
<!--SK-->
<table class="table table-striped" id="grp" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<th>Name</th>
		<!--<th>Price</th>-->
		<th>Quantity</th>
		<!--<th>Amount</th>-->
		<th>X</th>
	</tr>
<?
$sl=1;
$query=db_query($conn, $res);
while($info=mysqli_fetch_object($query)){ ?>
<tr>
    <td><span class="ccc"><?=$info->name?></span></td>
    <?php /*?><td><?=$info->price?>*<?=$info->qty?></td><?php */?> <!--SK-->
	<?php /*?><td><?=$info->price?></td><?php */?> <!--SK-->
	<td><?=$info->qty?></td> <!--SK-->
    <?php /*?><td><?=$info->amt?></td><?php */?> <!--SK-->
    <td><a href="?del=<?=$info->id;?>">X</a></td>
</tr>
<? 
$gqty +=$info->qty; $gamt +=$info->amt;
} ?>
<tr>
	<td colspan="1"><strong>Total</strong></td>
	<!--<td><strong>  </strong></td>-->
	<td><strong><?=$gqty?></strong></td>
	<?php /*?><td><strong><?=$gamt?></strong></td><?php */?> <!--SK-->
	<td><strong></strong></td> <!--SK-->
</tr>    
</table>
<!--SK-->
</form>



<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center"><button name="delete" type="submit" value="delete" class="btn btn-danger">Full Delete</button></td>
	  <td align="center"><button name="hold" type="submit" value="hold" class="btn btn-info">Hold</button></td>
      <td align="center"><button name="confirmm" type="submit" value="CONFIRM" class="btn btn-primary">CONFIRM</button></td>
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