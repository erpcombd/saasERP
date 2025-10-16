<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Demand Order Create COrporate';

do_calander('#est_date');
$page = 'do_check.php';
if($_POST['dealer']>0) 
$dealer_code = $_POST['dealer'];


$table_master='sale_do_master';
$unique_master='do_no';

$table_detail='sale_do_details';
$unique_detail='id';



if($_REQUEST['old_do_no']>0)
$$unique_master=$_REQUEST['old_do_no'];
elseif(isset($_GET['del']))
{$$unique_master=find_a_field('sale_do_details','do_no','id='.$_GET['del']); $del = $_GET['del'];}
else
$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){
if(isset($_POST['new']))
{
		$crud   = new crud($table_master);
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];
		if($_POST['flag']<1){
		$$unique_master=$crud->insert();
		unset($$unique);
		$type=1;
		$msg='Work Order Initialized. (Demand Order No-'.$$unique_master.')';
		}
		else {
		$crud->update($unique_master);
		$type=1;
		$msg='Successfully Updated.';
		}
}

if(isset($_POST['add'])&&($_POST[$unique_master]>0))
{
		$table		=$table_detail;
		$crud      	=new crud($table);
		$_POST['gift_on_order'] = $crud->insert();
		$do_date = date('Y-m-d');
		$_POST['gift_on_item'] = $_POST['item_id'];


		$sss = "select * from sale_gift_offer where item_id='".$_POST['item_id']."' and start_date<='".$do_date."' and end_date>='".$do_date."' and group_for=''";
		$qqq = db_query($sss);
		while($gift=mysqli_fetch_object($qqq)){
		
		if($gift->dealer_code!='') 
		{
		$dealers = explode(',',$gift->dealer_code);
		if(!in_array($_POST['dealer_code'],$dealers))
		$not_found = 1;
		else
		$not_found = 0;
		}
		if($not_found==0){
		if($gift->item_qty>0)
		{
			$_POST['gift_id'] = $gift->id;
			$gift_item = find_all_field('item_info','','item_id="'.$gift->gift_id.'"');
			$_POST['item_id'] = $gift->gift_id;
			
			if($gift->gift_id== 1096000100010239)
			{
				$_POST['unit_price'] = (-1)*($gift->gift_qty);
				$_POST['total_amt']  = (((int)($_POST['total_unit']/$gift->item_qty))*($_POST['unit_price']));
				$_POST['total_unit'] = (((int)($_POST['total_unit']/$gift->item_qty)));
				
				$_POST['dist_unit'] = $_POST['total_unit'];
				$_POST['pkt_unit']  = '0.00';
				$_POST['pkt_size']  = '1.00';
				$_POST['t_price']   = '-1.00';
				$crud->insert();
			}
			elseif($gift->gift_id== 1096000100010312)
			{
				$_POST['unit_price'] = (-1)*($gift->gift_qty);
				$_POST['total_amt']  = (((int)($_POST['total_unit']/$gift->item_qty))*($_POST['unit_price']));
				$_POST['total_unit'] = (((int)($_POST['total_unit']/$gift->item_qty)));
				
				$_POST['dist_unit'] = $_POST['total_unit'];
				$_POST['pkt_unit']  = '0.00';
				$_POST['pkt_size']  = '1.00';
				$_POST['t_price']   = '-1.00';
				$crud->insert();
			}
			else
			{
			$_POST['unit_price'] = '0.00';
			$_POST['total_amt'] = '0.00';
			$_POST['total_unit'] = (((int)($_POST['total_unit']/$gift->item_qty))*($gift->gift_qty));
			
			$_POST['dist_unit'] = ($_POST['total_unit']%$gift_item->pack_size);
			$_POST['pkt_unit'] = (int)($_POST['total_unit']/$gift_item->pack_size);
			$_POST['pkt_size'] = $gift_item->pack_size;
			$_POST['t_price'] = '0.00';
			$crud->insert();
			}
		//unset($_POST['gift_id']);
		//unset($_POST['gift_on_order']);
		//unset($_POST['gift_on_item']);
}

}
}

}
}
else
{
	$type=0;
	$msg='Data Re-Submit Error!';
}

if($del>0)
{	
		$next_del = find_a_field($table_detail,$unique_detail,'gift_on_order = '.$del);
		$crud   = new crud($table_detail);
		$condition=$unique_detail."=".$del;		
		$crud->delete_all($condition);
		if($next_del>0)
		{
			$condition=$unique_detail."=".$next_del;		
			$crud->delete_all($condition);
		}
		$type=1;
		$msg='Successfully Deleted.';
}

if($$unique_master>0)
{
		$condition=$unique_master."=".$$unique_master;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}



$dealer = find_all_field('dealer_info','','dealer_code='.$dealer_code);
		if($dealer->product_group!='M') $dgp = $dealer->product_group;

auto_complete_start_from_db('item_info','concat(finish_goods_code,"#>",item_name)','finish_goods_code','product_nature="Salable" order by finish_goods_code ASC','item');
$party_balance = find_a_field('journal','sum(cr_amt-dr_amt)','ledger_id="'.$dealer->account_code.'"');
?>
<script language="javascript">
function count()
{
if(document.getElementById('pkt_unit').value!=''){
var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
var dist_unit = ((document.getElementById('dist_unit').value)*1);
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var total_unit = (pkt_unit*pkt_size)+dist_unit;
var unit_price = ((document.getElementById('unit_price').value)*1);
var total_amt  = (total_unit*unit_price);
document.getElementById('total_unit').value=total_unit;
document.getElementById('total_amt').value	= total_amt .toFixed(2);
}
else
document.getElementById('dist_unit').focus();
}
</script>

<script language="javascript">
function focuson(id) {
  if(document.getElementById('item').value=='')
  document.getElementById('item').focus();
  else
  document.getElementById(id).focus();
}

window.onload = function() {
if(document.getElementById("flag").value=='0')
  document.getElementById("remarks").focus();
  else
  document.getElementById("item").focus();
}
</script>
<script language="javascript">
function grp_check(id)
{
if(document.getElementById("item").value!=''){
var myCars=new Array();
myCars[0]="01815224424";
<?
$item_i = 1;
$sql_i='select finish_goods_code from item_info where sales_item_type like "%'.$dealer->product_group.'%" and product_nature="Salable"';
$query_i=db_query($sql_i);
while($is=mysqli_fetch_object($query_i))
{
	echo 'myCars['.$item_i.']="'.$is->finish_goods_code.'";';
	$item_i++;
}
?>
var item_check=id;
var f=myCars.indexOf(item_check);
if(f>0)
getData2('do_ajax.php', 'do',document.getElementById("item").value,'<?=$dealer->depot.'<#>'.$dealer->dealer_code;?>');
else
{
alert('Item is not Accessable');
document.getElementById("item").value='';
document.getElementById("item").focus();
}}
}
</script>






<!--Mr create 2 form with table-->
<div class="form-container_large">
    <form action="<?=$page?>?<?=$unique_master?>=<?=$$unique_master?>" method="post" name="codz2" id="codz2">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order No</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="do_no" type="text" id="do_no" 
	  value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly="readonly"/>
    
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Delaer name</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                               <select id="dealer_code" name="dealer_code" readonly="readonly">
								<option value="<?=$dealer->dealer_code;?>"><?=$dealer->dealer_name_e.'-'.$dealer->dealer_code;?></option>
								</select>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depot</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select id="depot_id2" name="depot_id2"  class="from-control" readonly="readonly">
									<option value="<?=$dealer->depot;?>">
									  <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
									  </option>
								  </select>

                            </div>
                        </div>
						
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Address</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <textarea name="delivery_address" id="delivery_address" ><? if($delivery_address!='') echo $delivery_address; else echo $dealer->address_e?></textarea>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">View Deposit Slip</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									 
									   
									 
									  <a href="../../../assets/support/upload_view.php?name=<?=$do_file?>&folder=do_distributor" target="_blank">Click Here</a>

								</div>
							</div>
						
						
						

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Order Date</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="do_date" type="text"  id="do_date" value="<?=date('Y-m-d')?>" readonly="readonly"/>
                            </div>
                        </div>
                        <!--<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Ref PO NO</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="ref_no" type="text"  id="ref_no"  value="<?=$ref_no?>"/>
                            </div>
                        </div>-->

                        <!--<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">CO Discount</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input  name="sp_discount"  type="text" id="sp_discount" value="<?=$sp_discount?>"\/>
                            </div>
                        </div>-->

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="remarks" type="text" id="remarks" value="<?=$remarks?>" tabindex="10" />

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">DO amount</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                
								<input name="received_amt" type="text" id="received_amt" value="<?=$received_amt?>" tabindex="10" />

                            </div>
                        </div>
						
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Current Balance</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                
								<input name="party_balance" type="text" id="party_balance" value="<?=$party_balance?>" tabindex="10" />

                            </div>
                        </div>
						
						
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Payment Type</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
							    <input type="text" name="payment_by" id="payment_by" value="<?=$payment_by?>" class="form-control" readonly="readonly" />
                                <!--<select name="payment_by" type="text" id="payment_by" value="<?=$payment_by;?>" required onChange="check_type()" class="form-control">
											<option></option>
											<option <?=($payment_by=='CASH')?'selected':''?>>CASH</option>
											<option <?=($payment_by=='CHEQUE')?'selected':''?>>CHEQUE</option>
											<option <?=($payment_by=='BANK')?'selected':''?>>BANK</option>
											</select>-->

                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Bank</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="receive_acc_head" id="receive_acc_head" required>
									<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$receive_acc_head,' ledger_id="'.$receive_acc_head.'"');?>
									</select>

                            </div>
                        </div>
						
						

                    </div>



                </div>


            </div>

          <div class="n-form-btn-class">
                <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Update Requsition Information" tabindex="6">
            </div>
        </div>

        <!--return Table design start-->
	



</table>
</form>
<form action="<?=$page?>" method="post" name="codz" id="codz">
<? if($$unique_master>0){?>
		<form action="<?=$page?>" method="post" name="codz2" id="codz2">
			<!--Table input one design-->
			<div class="container-fluid pt-5 p-0">
			<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>Item Code</th>
						<th>Item Description</th>
						<th>Unit</th>

						<!--<th>Stock</th>-->
						<th>Unit-Price</th>
						<th>Quantity</th>

						<th>Value</th>
						<th>Action</th>
					</tr>
					</thead>

					<tbody class="tbody1">

					<tr>
						<td id="sub">


							<input name="item_id" type="text" list="item" value="" id="item_id" onblur="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('do_no').value);"/>
							 <datalist id="item">
							 <option></option>
							 <? foreign_relation('item_info','finish_goods_code','concat(item_name,"#",finish_goods_code)',$item_id,'sub_group_id like "2%"');?>
							</datalist>

							<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />
							<input type="hidden" id="do_date" name="do_date" value="<?=$do_date?>"  />
							<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
							<input type="hidden" id="depot_id" name="depot_id" value="<?=$depot_id?>"  />
							<input type="hidden" id="dealer_code" name="dealer_code" value="<?=$dealer_code?>"  />
							<input name="do_date" type="hidden" id="do_date" value="<?=$do_date;?>"/>
							<input name="job_no" type="hidden" id="job_no" value="<?=$job_no;?>"/>

						</td>

						 <td id="so_data_found" colspan="3">

							<table  width="100%" border="1" align="left" cellpadding="0" cellspacing="2">
							<tr>
								 <td width="20%"><input name="item_name" type="text" readonly=""  autocomplete="off"  value="" id="item_name" /> </td>
								 <td width="20%"><input name="pcs_stock" type="text" readonly=""  autocomplete="off"  value="" id="pcs_stock" /></td>
								 <!--<td width="20%"><input name="ctn_price" type="text" id="ctn_price" readonly="" required  value="<?=$do_data->ctn_price;?>" /></td>-->
								 <td width="20%"><input name="pcs_price" type="text" id="pcs_price" readonly="" required="required"  value="<?=$do_data->pcs_price;?>"  /></td>
							</tr>
							</table>

						 </td>

						<td>
							<input  name="dist_unit" type="text" class="input3" id="dist_unit" value=""  onkeyup="count()" />
 						</td>

						<td>
							<input name="total_unit" type="hidden" id="total_unit" readonly/>
							<input name="total_amt" type="text" id="total_amt" readonly/>
						</td>

						<td><input name="add" type="submit" id="add" value="ADD" class="btn1 btn1-bg-submit" /></td>

					</tr>

					</tbody>
				</table>





			</div>

		
			
			<div class="container-fluid pt-5 p-0 ">
			<?
			  $res='select a.id,b.item_name,a.item_id,a.unit_name, b.finish_goods_code, a.unit_price, a.total_unit,a.pkt_unit, a.total_amt as Net_sale, a.discount, a.vat_amt, a.total_amt_with_vat,a.gift_id from
			   sale_do_details a,item_info b where b.item_id=a.item_id and a.do_no='.$$unique_master.' order by a.id';
			?>

				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">
					<tr class="bgc-info">
						<th>SL</th>
						<th>Item Code</th>
						<th>Item Description</th>

						<th>Unit</th>
						<th>Unit Price</th>
						<th>Quantity</th>
						<th>Value</th>
						<th>Action</th>
					</tr>
					</thead>

					<tbody class="tbody1">

					<?

					$i=1;

					$query = db_query($res);

					while($data=mysqli_fetch_object($query)){ ?>

					<tr>

						<td><?=$i++?><input type="hidden" name="do_id_<?=$data->id?>" id="do_id_<?=$data->id?>" value="<?=$data->id?>" /></td>

						<td><?=$data->finish_goods_code?></td>
						<td><?=$data->item_name?></td>

						<td><?=$data->unit_name?></td>
						<? if($data->gift_id>0){?>
						<td><?=$data->unit_price;?></td>
						<td><?=$data->total_unit;?><? $tot_pcs +=$data->total_unit;?>&nbsp;Pcs</td>
						<? }else{?>
						<td><input type="text" name="rate_<?=$data->id?>" id="rate_<?=$data->id?>" readonly="readonly" value="<?=$data->unit_price;?>"/></td>
						<td><input type="text" name="qty_<?=$data->id?>" id="qty_<?=$data->id?>" value="<?=$data->pkt_unit;?>" onkeyup="getData2('c_do_update_ajax.php', 'edit_check_<?=$data->id?>', this.value,document.getElementById('do_id_<?=$data->id?>').value+'#'+document.getElementById('rate_<?=$data->id?>').value)" /><? $tot_ctn +=$data->pkt_unit;?></td> 
						<? }?>
						<td><span id="edit_check_<?=$data->id?>"><?=$data->Net_sale; $tot_Net_sale +=$data->Net_sale;?></span>

						<? $data->vat_amt; $tot_vat_amt +=$data->vat_amt;?>
						<? $data->total_amt_with_vat; $tot_total_amt_with_vat +=$data->total_amt_with_vat;?></td>
						<td><a href="?del=<?=$data->id?>">X</a></td>
					</tr>

					<? } ?>



					<tr>
						<td colspan="4"><strong>Total:</strong></td>
						<td>&nbsp;</td>
						<td><strong><?=$tot_ctn.'CTN<br>'.$tot_pcs;?>PCS</strong></td>
						<td><strong><?=number_format($tot_Net_sale,2);?></strong></td>
						<td>&nbsp;</td>
					</tr>

					</tbody>
				</table>

			</div>
		
		</form>


		<!--button design start-->
		<form action="select_uncheck_do.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
							
				   <input name="return"  type="submit" class="btn btn-warning" value="RETURN TO USER" onclick="return_function()" />
				   <input  name="do_no" type="hidden" id="do_no" value="<?=$do_no?>"/><input type="hidden" name="return_remarks" id="return_remarks">
				 
				   <input name="cancel"  type="submit" class="btn btn-danger" value="CANCEL" />
				 
				 <input type="button" class="btn btn-primary" value="CLOSE" onclick="window.location.href='select_uncheck_do.php'" /></td>
			
				  <input name="confirmm" type="submit" class="btn btn-info" value="CONFIRM AND FORWARD SO" />
	 
                
            </div>

        </div>
    </form>

		<? } ?>
</form>
</div>
<script>
function return_function() {
  var notes = prompt("Why Return This DO?","");
  if (notes!=null) {
    document.getElementById("return_remarks").value =notes;
	document.getElementById("cz").submit();
  }
  return false;
}

function count()
{


if(document.getElementById('unit_price').value!=''){


var unit_price = ((document.getElementById('unit_price').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);

var total_unit = (document.getElementById('total_unit').value)=dist_unit;

var total_amt = (document.getElementById('total_amt').value) = total_unit*unit_price;


}



}
</script>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>