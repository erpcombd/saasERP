<?php 
session_start();
require_once "../engine/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once '../assets/support/ss_function.php';
//var_dump($_SESSION);
$title = "Sales Return";
$page = "return_sales.php";


require_once '../assets/template/inc.header.php';


$group_for 	    =$_SESSION['user']['company_id']=1;
$user_id	    =$_SESSION['user']['id'];
$username	    =$_SESSION['user']['username'];
$pg	            =$_SESSION['user']['product_group'];
$region_id	    =$_SESSION['user']['region_id'];
$zone_id	    =$_SESSION['user']['zone_id'];
$area_id	    =$_SESSION['user']['area_id'];        

$page_for           ='Sales Return';
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
		$_POST['entry_by']	=$_SESSION['user']['username'];
		$_POST['entry_at']	=date('Y-m-d H:i:s');
		$_POST['edit_by']	=$_SESSION['user']['username'];
		$_POST['edit_at']	=date('Y-m-d H:i:s');
		$_POST['warehouse_id']=$_SESSION['user']['warehouse_id'];
		$_POST['vendor_name']	=find1('select shop_name from ss_shop where dealer_code="'.$_POST['vendor_id'].'"');
		$_POST['return_type'] = 'MANUAL';
		
		$$unique=$_SESSION['or_no2']=$crud->insert();
		//unset($$unique);
		$type=1;
		$msg=$title.'  No Created. (No :-'.$_SESSION['or_no2'].')';	
		?><script>window.location.href = "return_sales_manual.php?or_no=<?=$$unique;?>";</script><?
		} else {
		    
		$_POST['edit_by']	=$_SESSION['user']['username'];
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
		?><script>window.location.href='return_sales.php?pal=2';</script><?php 
}

if(isset($_POST['hold'])){
		unset($$unique);
		unset($_SESSION['or_no2']);
		$type=1;
		$msg='Successfully Holded.';
		?><script>window.location.href='return_sales.php?pal=2';</script><?php 
}


if(isset($_POST['confirmm'])){
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['username'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		
// bin card entry		
 $sql = 'select a.id,a.item_id,a.qty,a.or_date,a.rate,a.or_no
		from ss_receive_details a
		where a.or_no='.$$unique.' order by a.id';
				
		$query = mysqli_query($conn,$sql);
		while($data=mysqli_fetch_object($query)){

journal_item_ss($data->item_id ,$_SESSION['user']['warehouse_id'],$data->or_date,$data->qty,0,$page_for,$data->id,$data->rate,'',$data->or_no);


} 
// end bin card hit			
		unset($$unique);
		unset($_SESSION['or_no2']);
		$type=1;
		$msg='Successfully Forwarded.';
?>
<script>window.location.href='return_sales.php?pal=2';</script>

<?php  
} // End confirm


if(isset($_POST['add'])&&($_POST[$unique]>0)){

$crud   = new crud($table_details);

$_POST['unit_name']=$_POST['unit'];
$_POST['rate']          =$_POST['price'];
$_POST['warehouse_id']  =$_SESSION['user']['warehouse_id'];

$_SESSION['category_id']=$_POST['category_id'];
$_SESSION['subcategory_id']=$_POST['subcategory_id'];

if($_POST['item_id']>0) { 
if($_POST['rate']>0){            	
	unset($_POST['id']);
	$xid = $crud->insert();
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
		foreach( $data as $key=>$value )
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
   
			<div class="card card-style m-0">
			<form action="" method="post" name="codz" id="codz">
				<div class="content mt-0">	
	
	
							<? $field='route_id';?>
						<label for="<?=$field?>">Route Name</label>

							<select name="<?=$field?>" id="<?=$field?>" class="form-select form-control" required  onchange="FetchShopList(this.value)" >
									<? if($_POST['route_id']>0){ ?>
										<option value="<?=$_POST['route_id']?>"><?=find1("select route_name from ss_route where route_id='".$_POST['route_id']."'");?></option>
									<? }else{ ?>
									<option></option>
									<? } ?>
									<? optionlist("select s.route_id,r.route_name 
									from ss_route r, ss_shop s where s.route_id=r.route_id and s.emp_code='".$_SESSION['user']['username']."' group by s.route_id order by route_name");?>
							</select>
	
	
	
	
							<? $field='vendor_id';?>
						<label for="<?=$field?>">Party Name</label>

							<select name="<?=$field?>" id="<?=$field?>" class="form-select form-control" required="required" onChange="getshopData()">
<?php /*?>								<option value="<?=$$field?>"><?=find1("select concat(dealer_code,'-',shop_name) from ss_shop where dealer_code='".$$field."' ");?></option>
						<?php optionlist('select s.dealer_code,concat(r.route_name,"-",s.shop_name) as shop_name 
								from ss_shop s, ss_route r 
								where s.route_id=r.route_id and s.status="1" and s.emp_code="'.$_SESSION['user']['username'].'" 
								order by r.route_id,s.shop_name');?><?php */?>
									<? if($_POST['route_id']>0){
										optionlist('select dealer_code,shop_name from ss_shop where status="1" 
										and region_id="'.$region_id.'" and zone_id="'.$zone_id.'" and area_id="'.$area_id.'" and route_id="'.$_POST['route_id'].'" order by shop_name');
									}?>
							</select>
	
							<div class="row">
							<div class="col-6">
							
													<? $field='or_date'; if($or_date=='') $or_date =date('Y-m-d'); ?>
													<label for="<?=$field?>" >Date</label>
							
													<input class="form-control validate-text" name="<?=$field?>" type="date" id="<?=$field?>" value="<?=$$field?>" required
													<? if($or_date!=''){?> readonly="readonly" <? } ?> placeholder="Date"/>
							</div>	
							<div class="col-6">
													<? $field='or_no';?>
													<label for="<?=$field?>" >Sales Return NO</label>
							
													<input class="form-control validate-text" name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required disabled="disabled" placeholder="NO" />
							
							</div>
							</div>



<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/> 
	
					
					<div class="row d-flex justify-content-center mt-3">
						<div class="col-6">
							<input name="new" type="submit" value="<?=$btn_name?>" class=" b-n btn btn-success btn-3d btn-block  text-light w-100 py-3">
						</div>
					</div>
				</div>
				</form>


<?php 
//echo 'or_no2='.$_SESSION['or_no2'];
if($_SESSION['or_no2']>0){ ?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">

				<div class="content">
					<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
						<label for="form5" >Category</label>
						<select name="category_id" id="category_id" onchange="FetchItemSubcategory(this.value)">
							<option value="<?=$_SESSION['category_id'];?>"><?=find1("select category_name from item_category where id='".$_SESSION['category_id']."'");?></option>
			<?php optionlist("select id,category_name from item_category where 1 order by category_name"); ?>
			<?php //optionlist("select c.id,concat(g.group_name,'>>',c.category_name) as name from item_category c, product_group g where g.id=c.group_id order by c.group_id,c.category_name"); ?>
						</select>
						<!-- <span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em></em>
					</div> -->
					
					
					
					
					

					<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
						<label for="form5" >SubCategory</label>
						<select name="subcategory_id" id="subcategory_id" onchange="FetchItem(this.value)">
									 <option value="<?=$_SESSION['subcategory_id'];?>"><?=find1("select subcategory_name from item_subcategory where id='".$_SESSION['subcategory_id']."'");?></option>
				    <?php 
				    if($_SESSION['category_id']>0){$cat_group=" and category_id='".$_SESSION['category_id']."' ";}
				    optionlist("select id,subcategory_name from item_subcategory where 1 ".$cat_group." order by subcategory_name"); ?>
						</select>
						<!-- <span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em></em>
					</div> -->

					<!-- <div class="input-style-new input-style-always-active has-borders no-icon mb-4"> -->
						<label for="form5" >Item</label>
						<select name="item_id" id="item_id"  onChange="getData()">
									<option></option>
							<?php 
        if($_SESSION['subcategory_id']>0){	
        	optionlist('select item_id,concat(finish_goods_code,"#",item_name) from item_info where 1 and status_sec=1 and subcategory_id="'.$_SESSION['subcategory_id'].'" and status="Active" order by item_name');
        }
        	?>
						</select>
						<!-- <span><i class="fa fa-chevron-down"></i></span>
						<i class="fa fa-check disabled valid color-green-dark"></i>
						<i class="fa fa-check disabled invalid color-red-dark"></i>
						<em></em>
					</div> -->
					
					
				</div>
				<div class="content">
				  <table class="table table-borderless text-center table-scroll mt-2" style="overflow: hidden; width:100%">
						<thead>
							<tr class="bg-night-light1">
								<th scope="col" class="color-white">Rate</th>
								<th scope="col" class="color-white">Qty</th>
								<th scope="col" class="color-white">Amount</th>
								<th scope="col" class="color-white">Action</th>
							</tr>
						</thead>
						<tbody>
							<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
							<input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
							<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
							<input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>
							<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id?>"/>
							<input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>
							<tr>
				<td><input name="price" type="text" id="price" onChange="count()" autocomplete="off" style="width: 100%;"/> </td>
				<td><input name="qty" type="number" id="qty"  maxlength="100" onChange="count()" required autocomplete="off" style="width: 100%;"/> </td>
				<td><input name="amount" type="text" id="amount" readonly="readonly" required style="width: 100%;"/></td>
				<td> <button name="add" type="submit" id="add" style="width: 100%;" class="btn btn-3d btn-m btn-full mb-0 rounded-xs btn-success font-900 shadow-s ">Add</button> </td>
							</tr>
						</tbody>
					</table>
			</div>
			<div class="content">
			<? 
			$res='select a.id,i.item_name,a.rate,a.qty ,a.amount,"x" 
			from ss_receive_details a,item_info i 
			where i.item_id=a.item_id and a.or_no='.$or_no.' order by a.id desc';
			echo link_report_add_del_auto1($res,'',4,5);
			?>
			</div>
				
</form>



			<form action="" method="post" name="cz" id="cz">
			<div class="content">		
					<div class="row">	  
						<div class="col-4">
							<button name="delete" type="submit" value="Delete" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-danger w-100">Delete</button>
						</div>
						<div class="col-4 p-1">
							<button name="hold" type="submit" value="Hold" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-primary  w-100">Hold</button>
						</div>
						<div class="col-4 p-1">
							<button name="confirmm" type="submit" value="Confirm" class="btn btn-3d btn-m btn-full mb-0 rounded-xs  font-900 shadow-s btn-success  w-100">Confirm</button>
						</div>
					</div>
				</div>
			</form>
			<? } ?>
			</div>
			

        </div>
    <!-- End of Page Content--> 
    
<?php 
 require_once '../assets/template/inc.footer.php';
 selected_two("#vendor_id", "Select");
// selected_two("#category_id");
// selected_two("#subcategory_id");
//// selected_two("#item_id");
 ?>
 <script>
function getshopData(){
var id = document.getElementById("vendor_id").value;
		jQuery.ajax({
			url:'ajax_location.php',
			type:'post',
			data:'id='+id,
			success:function(result){
				var json_data=jQuery.parseJSON(result);

				jQuery('#latitude2').val(json_data.lat2);
				jQuery('#longitude2').val(json_data.long2);
			}
		})
}
</script> 

<script>
function FetchShopList(id){
    $('#vendor_id').html('');
    $.ajax({
      type:'post',
      url: 'get_data.php',
      data : { route_id : id},
      success : function(data){
         $('#vendor_id').html(data);
      }

    })
  }

</script> 



<script>

function getData(){
var id        = document.getElementById("item_id").value;
var vendor_id = document.getElementById("vendor_id").value;

		jQuery.ajax({
			url:'ajax_return_price.php',
			type:'post',
			data: {id: id, vendor_id: vendor_id},
			success:function(result){
				var json_data=jQuery.parseJSON(result);

				jQuery('#unit').val(json_data.unit);
				jQuery('#price').val(json_data.price);

			}

		})
$( "#qty" ).focus();	
}
</script>  
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script>
jQuery('.party_list').chosen();
jQuery('.item_list').chosen();
</script>

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
         $('#item_id').html(data);
      }

  })
}
</script>