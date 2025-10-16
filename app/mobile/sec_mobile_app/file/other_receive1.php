<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';

$title = "Other Receive";
$page = "other_rereive.php";


require_once '../assets/template/inc.header.php';


$user_id		=$_SESSION['user_id'];
$emp_code		=$_SESSION['user']['username'];
$group_for 	    =$_SESSION['user']['company_id']=1;
$pg	            =$_SESSION['user']['product_group'];
$region_id	    =$_SESSION['user']['region_id'];
$zone_id	    =$_SESSION['user']['zone_id'];
$area_id	    =$_SESSION['user']['area_id'];
$dinfo=findall("select * from dealer_info where dealer_code='".$dealer_code."' ");

$dealer_code = $dinfo->dealer_code;
$dealer_name = $dinfo->dealer_name_e;
        

$page_for           ='Other Receive';
$table_master       ='ss_receive_master';
$table_details      ='ss_receive_details';
$unique='or_no';
if($_GET['pal']==2){
		unset($$unique);
		unset($_SESSION['or_no2']);
}

if($_GET['or_no']>0) $_SESSION['or_no2']=$_GET['or_no'];




if(isset($_POST['new'])){

		$crud   = new crud($table_master);

		if(!isset($_SESSION['or_no2'])) {
		$_POST['entry_by']	=$_SESSION['username'];
		$_POST['entry_at']	=date('Y-m-d H:i:s');
		$_POST['edit_by']	=$_SESSION['username'];
		$_POST['edit_at']	=date('Y-m-d H:i:s');
		$_POST['warehouse_id']=$_SESSION['warehouse_id'];
		$_POST['vendor_name']	=find1('select shop_name from ss_shop where dealer_code="'.$_POST['vendor_id'].'"');
		

		$$unique=$_SESSION['or_no2']=$crud->insert();
		//unset($$unique);
		$type=1;
		$msg=$title.'  No Created. (No :-'.$_SESSION['or_no2'].')';	
		?><script>window.location.href = "other_receive.php?or_no=<?=$$unique;?>";</script><?
    	
		    
		} else {
		    
		$_POST['edit_by']	=$_SESSION['username'];
		$_POST['edit_at']	=date('Y-m-d H:i:s');
		$_POST['or_no']		=$_SESSION['or_no2'];
		$_POST['vendor_name']	=find1('select shop_name from ss_shop where dealer_code="'.$_POST['vendor_id'].'"');
		
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
} // end new

$$unique=$_SESSION['or_no2'];




if(isset($_POST['delete'])){

		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION['or_no2']);
		$type=1;
		$msg='Successfully Deleted.';
		?><script>window.location.href='other_receive.php?pal=2';</script><?php 
}

if(isset($_POST['hold'])){
		unset($$unique);
		unset($_SESSION['or_no2']);
		$type=1;
		$msg='Successfully Holded.';
		?><script>window.location.href='other_receive.php?pal=2';</script><?php 
}





if(isset($_POST['confirmm'])){
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['username'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		
// bin card entry		
 $sql = 'select a.id,a.item_id,a.qty,a.or_date,a.rate,a.or_no
		from ss_receive_details a
		where a.or_no='.$$unique.' order by a.id';
		
		$query = mysqli_query($conn, $sql);
		while($data=mysqli_fetch_object($query)){

$check_old_item=find1("select item_id from ss_journal_item where item_id='".$data->item_id."' and sr_no='".$data->or_no."' and tr_from='Other Receive' ");

if($check_old_item<1){
journal_item_ss($data->item_id ,$_SESSION['warehouse_id'],$data->or_date,$data->qty,0,$page_for,$data->id,$data->rate,'',$data->or_no);
}

} // end bin card hit			


		
		unset($$unique);
		unset($_SESSION['or_no2']);
		$type=1;
		$msg='Successfully Forwarded.';

?><script>window.location.href='other_receive.php?pal=2';</script><?php  
} // End confirm






if(isset($_POST['add'])&&($_POST[$unique]>0)){

$crud   = new crud($table_details);

$_POST['unit_name']=$_POST['unit'];
$_POST['rate']          =$_POST['price'];
$_POST['warehouse_id']  =$_SESSION['warehouse_id'];

$_POST['entry_by']=$_SESSION['username'];
$_POST['entry_at']=date('Y-m-d H:i:s');


$_SESSION['category_id']=$_POST['category_id'];
$_SESSION['subcategory_id']=$_POST['subcategory_id'];

if($_POST['item_id']>0) { 
if($_POST['rate']>0){            	
	
    $check_old=find1("select item_id from ss_journal_item where item_id='".$data->item_id."' and sr_no='".$data->or_no."' and tr_from='Other Receive' ");	
    if($check_old<1){	
    	unset($_POST['id']);
    	$xid = $crud->insert();
    }
} }           
} // end add




if($_GET['del']>0){

		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		$type=1;
		$msg='Successfully Deleted.';
		
}



if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value; }
		
}



if($$unique>0) $btn_name='Update'; else $btn_name='Start';

if($_SESSION['or_no2']<1)
$$unique=db_last_insert_id($table_master,$unique);



?>
<script language="javascript">
function focuson(id) {
  if(document.getElementById('id').value=='')
  document.getElementById('id').focus();
  else
  document.getElementById(id).focus();
}

window.onload = function() {
if(document.getElementById("warehouse_id").value>0)
  document.getElementById("id").focus();
  else
  document.getElementById("req_date").focus();
}
</script>

<script language="javascript">
function count(){
var num=((document.getElementById('qty').value)*1)*((document.getElementById('price').value)*1);
document.getElementById('amount').value = num.toFixed(2);	
}
</script>


    

<!-- start of Page Content-->  
   <div class="page-content header-clear-medium">
   
   
   

        
		
		
		
<form action="" method="post">

        <div class="card card-style">
							<div class="content">
				
					
					<div class="input-style input-style-always-active  has-borders no-icon validate-field mb-4"><? $field='or_no';?>		
					<input type="text" class="form-control validate-text"  name="<?=$field?>" id="<?=$field?>" value="<?=$$field?>" disabled="disabled">
						<label for="manager_name" class="color-highlight">No</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div>
	
	
					<div class="input-style input-style-always-active has-borders no-icon mb-4">
						
						<? $field='or_date'; if($or_date=='') $or_date =date('Y-m-d'); ?>
						<input  class="form-control validate-text" name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" required
						<? if($or_date!=''){?> readonly="readonly" <? } ?>
						/>
						<label for="odate" class="color-highlight">Date</label>
						<i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
						<i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
					</div>
					
						<div class="input-style input-style-always-active  has-borders no-icon validate-field mb-4">		
							<? $field='vendor_id';?>
						<select class="form-control validate-text" name="<?=$field?>" id="<?=$field?>" required/>
						<option value="<?=$$field?>"><?=find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='".$$field."' ");?></option>
						<?php optionlist('select s.dealer_code,concat(r.route_name,"-",s.shop_name) as shop_name 
							from ss_shop s, ss_route r 
							where s.route_id=r.route_id and s.status="1" and s.emp_code="'.$_SESSION['user']['username'].'" 
							order by r.route_id,s.shop_name');?>
						</select>
						<label for="manager_name" class="color-highlight">Party</label>
						<i class="fa fa-times disabled invalid color-red-dark"></i>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<em>(required)</em>
					</div>
					<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>  		
					
					
				
					<div class="d-flex justify-content-center row">
						<div class="col-6">
					

	<button name="new" type="submit" class="btn btn-3d btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s border-mint-dark bg-mint-dark w-100"><?=$btn_name?></button>

							
						</div>
					</div>
				</div>

            </div>
			
			
			
			<div class="content">
			
			<?
if(isset($_POST['submitit'])){

  if(isset($_POST['odate'])){
  $odate = $_SESSION['odate'] = $_POST['odate'];
  $sodate = date('ymd',strtotime($odate));
  }
  
if($_POST['category_id']!=''){ $cat_con=' and category_id="'.$_POST['category_id'].'"';}
if($_POST['subcategory_id']!=''){ $subcat_con=' and subcategory_id="'.$_POST['subcategory_id'].'"';}

?>
			
			
				  <table class="table table-borderless text-center rounded-sm shadow-l" style="overflow: hidden;">
						<thead>
							<tr class="bg-night-light">
								<th scope="col" class="color-white">Item Name</th>
								<th scope="col" class="color-white">Stock Qty</th>
								<th scope="col" class="color-white">Action</th>
							</tr>
						</thead>
						<tbody>

<?

$tr_from = 'Opening';
 $sql = "select item_price,j.item_in,j.item_ex,i.item_id 
from ss_journal_item j, item_info i 
where i.item_id=j.item_id 
and  j.warehouse_id='".$dealer_code."'  and j.tr_from='".$tr_from."' 
".$cat_con.$subcat_con."
and j.ji_date = '".$_POST['odate']."'
group by i.item_id ";

$query = mysqli_query($conn,$sql);
while($data = mysqli_fetch_object($query)){
$item_in[$data->item_id] = $data->item_in;
$item_ex[$data->item_id] = $data->item_ex;
$flag[$data->item_id] = 1;
}


$sql = "select * from item_info where 1
".$cat_con.$subcat_con."
order by item_name";
$query = mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){$i++;
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <!--<td><?=$data->finish_goods_code?></td>-->
    <td><?=$data->finish_goods_code?><br><?=$data->item_name?></td>
<!--    <td><? //=$data->unit_name?></td>
    <td width="11%">
<input name="orate_<?=$data->item_id?>" id="orate_<?=$data->item_id?>" value="<?=$data->f_price?>" style="width:40px;"/>
<input type="hidden" name="orate_<?=$data->item_id?>2" id="orate_<?=$data->item_id?>2" value="<?=($pre_stock[$data->item_id])?>" style="width:70px;"/>
</td>-->


<td width="10%"><input class="form-control" name="cqty_<?=$data->item_id?>" id="cqty_<?=$data->item_id?>" type="number" 
value="<? if($item_in[$data->item_id]>0){ echo (int)$item_in[$data->item_id];}?>" 
style="width:100px;" /></td>

<!--<td><input name="pqty_<?=$data->item_id?>" id="pqty_<?=$data->item_id?>" type="text" value="<?=(int)($item_ex[$data->item_id])?>" style="width:40px;" /><td width="0%"></td>
-->

<td align="center"><span id="divi_<?=$data->item_id?>">
            <? if($flag[$data->item_id]>0)
			  {?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" class="btn btn-primary"/><?
			  }
			  else
			  {
			  ?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" class="btn btn-success"/><? }?>
          </span>&nbsp;</td>
  </tr>
  <? }?>
  
						</tbody>
					</table>
					
					
					
					<? }?>
			</div>
			
			
			
			
						</form>
			
        </div>
    <!-- End of Page Content--> 
    
    











<?php 
 require_once '../assets/template/inc.footer.php';
 ?>
 

<script type="text/javascript">
  function FetchItemCategory(id){
    $('#category_id').html('');
    $('#subcategory_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { item_group : id},
      success : function(data){
         $('#category_id').html(data);
      }

    })
  }

  function FetchItemSubcategory(id){
    $('#subcategory_id').html('');
    $('#item_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { category_id : id},
      success : function(data){
         $('#subcategory_id').html(data);
      }

    })
  }


  function FetchItem(id){
    $('#item_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { subcategory_id : id},
      success : function(data){
         $('#browsers').html(data);
      }

    })
  }

</script>