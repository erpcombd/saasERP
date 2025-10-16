<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='FG Requisition Approval';


do_calander('#need_by','0','0');

$table_master='requisition_fg_master';
$table_details='requisition_fg_order';
$unique='req_no';

if($_GET[$unique]>0) $_SESSION[$unique]=$_GET[$unique];

if($_GET['mhafuz']>0) unset($_SESSION[$unique]);



if(isset($_POST['new'])){
    
    
		$crud   = new crud($table_master);
		
		if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Requisition No Created. (Req No :-'.$_SESSION[$unique].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');
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


if(isset($_POST['go_back'])){
    

$req_no = $_REQUEST['req_no'];

$sql3 = 'update requisition_fg_master set status="CANCELED" where req_no = '.$req_no;

mysql_query($sql3);

	
?>
<script language="javascript">
window.location.href = "select_unapproved_mr.php";
</script>
<?



}




if($_GET['del']>0)
{
		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
}



if(isset($_POST['confirmm']))
{
		unset($_POST);
		
		$_POST[$unique]=$$unique;
		$_POST['checked_by']=$_SESSION['user']['id'];
		$_POST['checked_at']=date('Y-m-d H:i:s');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		
    // check wid
    $master_wid= find_all_field('requisition_fg_master','','req_no="'.$$unique.'"');
    //findall("select warehouse_id,warehouse_to from requisition_fg_master where req_no='".$$unique."'");
    $details_wid=  find_all_field('requisition_fg_order','','req_no="'.$$unique.'"');
   // findall("select warehouse_id,warehouse_to from requisition_fg_order where req_no='".$$unique."' order by id desc limit 1");
    
    if($master_wid->warehouse_id==$details_wid->warehouse_id && $master_wid->warehouse_to==$details_wid->warehouse_to){		
		$crud->update($unique);
		
		unset($$unique);
		unset($_SESSION[$unique]);
		
		$type=1;
		$msg='Successfully Forwarded for Approval.';
		//redirect('select_unapproved_mr.php');
		header("Location: select_unapproved_mr.php");
    }else{
        die('Error');
    }	
		
		
}



// if(isset($_POST['add'])&&($_POST[$unique]>0))
// {
// 		$_POST['qty']=($_POST['qty_ctn']*$_POST['pack_size'])+$_POST['qty_pcs'];
// 		$crud   = new crud($table_details);

// 		$_POST['entry_by']=$_SESSION['user']['id'];
// 		$_POST['entry_at']=date('Y-m-d H:i:s');
// 		$_POST['edit_by']=$_SESSION['user']['id'];
// 		$_POST['edit_at']=date('Y-m-d H:i:s');
		
		
// 		if($_POST['qty']>0){
// 		    $crud->insert();
// 		}
// }

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		//while (list($key, $value)=each($data))
		
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update Requsition Information'; else $btn_name='Initiate Requsition Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
//auto_complete_from_db('item_info','finish_goods_code','concat(item_name,"#>",item_description,"#>",item_id)','product_nature="Salable"','item_id');
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




<div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<div class="container">

<div class="row from-control">
        <div class="col-md-2">Req No:</div>
        <div class="col-md-2">
            <? $field='req_no';?>
            <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>
        </div>
        <div class="col-md-2">Req Date:</div>
        <div class="col-md-2">
        <? $field='req_date'; if($req_date=='') $req_date =date('Y-m-d');?>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required readonly=""/>
        </div>
        
        <div class="col-md-2">Need within:</div>
        <div class="col-md-2">
        <? $field='need_by';?>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?$$field:date('Y-m-d');?>" autocomplete="off" readonly/>
        </div>
        
</div><!--end row-->

<div class="row from-control mt-1">
        <div class="col-md-2">Req From:</div>
        <div class="col-md-2">
            <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
  <!--      <input name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>" />-->
		<!--<input name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>" readonly="" />-->
		
		<select name="warehouse_id" id="warehouse_id"  required>
        	  <? if($$field!=''){ ?><option value="<?=$$field?>"><?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$$field.'"');?></option> <? }?>
        	  <!--<option></option>-->
        	  <? //foreign_relation('warehouse','warehouse_id','warehouse_name','','1 and warehouse_id!="'.$_SESSION['user']['depot'].'" and use_type="WH"');?>
        </select>
        </div>
        <div class="col-md-2">Req To:</div>
        <div class="col-md-2">
        <? $field='warehouse_to'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
             <select name="warehouse_to" id="warehouse_to"  required>
        	  <? if($$field!=''){ ?><option value="<?=$$field?>"><?=find_a_field('warehouse','warehouse_name','warehouse_id="'.$$field.'"');?></option> <? }?>
        	  <!--<option></option>-->
        	  <? //foreign_relation('warehouse','warehouse_id','warehouse_name','','1 and warehouse_id!="'.$_SESSION['user']['depot'].'" and use_type="WH"');?>
        	  </select>
        </div>
        
        <div class="col-md-2">Company:</div>
        <div class="col-md-2">
        <? $field='group_for';?>
            <select  id="group_for" name="group_for" class="form-control" required>
            <? if($$field>0){ ?>
            <option value="<?=$$field?>"><?=find_a_field('user_group','group_name','id="'.$$field.'"');?></option> 
            <? }else{ ?>
            <option></option>
            <? foreign_relation('user_group','id','group_name',$group_for,'1 order by group_name');?>
            <? } ?>
            </select>
        </div>
        
</div><!--end row-->


<div class="row from-control mt-1">
    
            <div class="col-md-2">Note:</div>
        <div class="col-md-2">
        <? $field='req_note';?>
            <input id="req_note" name="req_note" class="form-control" value="<?=$req_note?>">
        </div>
    
</div><!--end row-->    


<div class="row from-control mt-1">
   <div class="col-md-12 text-center">
      <input name="new" type="submit" class="btn btn-primary" value="<?=$btn_name?>" />
    </div> 
</div><!--end row-->
  
  
    
</div><!--end container-->
</form>




<? if($_SESSION[$unique]>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<?php /*?><table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">
<tr>
<td align="center" bgcolor="#0099FF"><strong>Item Code</strong></td>
<td align="center" bgcolor="#0099FF"><strong>Item Name</strong></td>
<td align="center" bgcolor="#0099FF"><strong>Pack Size</strong></td>
<td align="center" bgcolor="#0099FF"><strong>Unit Name </strong></td>
<td align="center" bgcolor="#0099FF"><strong>Stock </strong></td>
<td align="center" bgcolor="#0099FF"><strong>Ctn</strong></td>
<td align="center" bgcolor="#0099FF"><strong>Pcs</strong></td>
<td align="center" bgcolor="#0099FF"><strong>Note</strong></td>

<td  rowspan="2" align="center" bgcolor="#FF0000">
<div class="button">
<input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
</div></td>
</tr>

<tr>
<td align="center" bgcolor="#CCCCCC">
<input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
<input  name="sub_depot" type="hidden" id="sub_depot" value="<?=$sub_depot?>"/>
<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>
<input  name="req_date" type="hidden" id="req_date" value="<?=$req_date?>"/>

<input list="items" name="item_id" type="text" class="input3"  value="" id="item_id" style="width:100px;" onChange="getData()" autocomplete="off" required autofocus/>
 <datalist id="items">
     <?=foreign_relation('item_info','item_id','concat(finish_goods_code," # ",item_name)',$item_id,'1 and group_for="'.$group_for.'" order by item_name');?>  
     
 
 </datalist>
</td>
<td align="center" bgcolor="#CCCCCC"><input name="item_name" type="text" class="input3" id="item_name"  style="width:150px;" readonly="readonly"/></td>
<td align="center" bgcolor="#CCCCCC"><input name="pack_size" type="text" class="input3" id="pack_size"  style="width:80px;" readonly="readonly"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="unit_name" type="text" class="input3" id="unit_name"  style="width:80px;" onfocus="focuson('qty_ctn')" readonly="readonly"/></td>
<td align="center" bgcolor="#CCCCCC"><input type="text" class="input3" id="stock"  style="width:80px;" readonly="readonly"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty_ctn" type="text" class="input3" id="qty_ctn"  maxlength="100" style="width:120px;" value="0" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="qty_pcs" type="text" class="input3" id="qty_pcs"  maxlength="100" style="width:120px;" required/></td>
<td align="center" bgcolor="#CCCCCC"><input name="item_note" type="text" class="input3" id="item_note"  style="width:190px;" /></td>
      
      </tr>
    </table><?php */?>
<br/><br/><br/><br/>



<? 
//echo link_report_add_del_auto($res,1,6,7,8);
?>

<div class="tabledesign2">
<table class="table table-striped table-bordered table-sm" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<th>S/L</th>
<th>FG Code</th>
<th>Item Name</th>
<th>Pack Size</th>
<th>Unit Name</th>
<th>Ctn</th>
<th>Pcs</th>
<th>Total Pcs</th>
<th>Note</th>
<th>X</th>
</tr>
<?
$sl=1;
$res='select a.id, b.finish_goods_code as fg_code, concat(b.item_name) as item_name,b.pack_size,a.unit_name, 
(a.qty DIV b.pack_size) as ctn,(a.qty MOD b.pack_size) as pcs,a.qty as Total_Pcs,a.item_note as note,"x" 

from requisition_fg_order a,item_info b 
where b.item_id=a.item_id and a.req_no='.$req_no;
$query=db_query($res);
while($info=mysqli_fetch_object($query)){
?>
<tr>
    <td><?=$sl++?></td>
    <td><?=$info->fg_code?></td>
    <td><?=$info->item_name?></td>
    <td><?=$info->pack_size?></td>
    <td><?=$info->unit_name?></td>
    <td><?=$info->ctn; $gctn+=$info->ctn;?></td>
    <td><?=$info->pcs; $gpcs+=$info->pcs;?></td>
    <td><?=$info->Total_Pcs; $gtotal+=$info->Total_Pcs;?></td>
    <td><?=$info->note?></td>
    <td><a href="?del=<?=$info->id;?>"><i class="fa fa-trash" style="color:red"></i></a></td>
</tr>
<? } ?>
<tr style="font-weight:700;">
    <td colspan="5">Total: </td>
    <td><?=$gctn?></td>
    <td><?=$gpcs?></td>
    <td><?=$gtotal?></td>
    <td></td>
    <td></td>
</tr>

</table>
</div>
</form>




<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center">
<input  name="req_no" type="hidden" id="req_no" value="<?=$req_no?>"/>
      <input name="go_back"  type="submit" class="btn btn-danger" value="Cancel Requisition" style="width:270px; font-weight:bold; font-size:12px;color:#ffff; height:30px" />

      </td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn btn-success" value="APPROVE AND FORWARD REQUSITION" style="width:300px; font-weight:bold; font-size:12px; height:30px; color:#ffff" />

      </td>
    </tr>
  </table>
</form>
<? }?>
</div>


<script>
function getData(){
    
var id = document.getElementById("item_id").value;

		jQuery.ajax({
			url:'ajax_requisition.php',
			type:'post',
			data:'id='+id,
			success:function(result){
				var json_data=jQuery.parseJSON(result);

				jQuery('#item_name').val(json_data.item_name);
				jQuery('#unit_name').val(json_data.unit);
                jQuery('#pack_size').val(json_data.pack_size);
			}

		})
	
}
</script> 

<script>$("#codz").validate();$("#cloud").validate();</script>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>