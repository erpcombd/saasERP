<?php
require_once "../../../assets/template/layout.top.php";
$title='New POS Purchase';
$page_for = 'Local Purchase';

$din = find_a_field('menu_warehouse','local_purchase','id="'.$_SESSION['user']['group'].'"');
if($din>0){$din=$din;}else{$din=60;}
do_calander('#or_date'/*,'-"'.$din.'"','0'*/);
do_calander('#quotation_date');


$table_master='warehouse_other_receive';
$table_details='warehouse_other_receive_detail';
$unique='or_no';
$warehouse_id = $_SESSION['user']['depot'];


if(isset($_POST['new']))
{
		$crud   = new crud($table_master);

		if(!isset($_SESSION['or_no2'])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:s:i');
		$_POST['warehouse_id'] = $warehouse_id;
		$$unique=$_SESSION['or_no2']=$crud->insert();
		unset($$unique);
		$type=1;
		$msg=$title.'  No Created. (No :-'.$_SESSION['or_no2'].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:s:i');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
}

$$unique=$_SESSION['or_no2'];

if(isset($_POST['delete']))
{
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
        
		$or_no = $_POST['or_no'];
        $sql = 'select w.*,s.item_ledger as ledger_id from warehouse_other_receive_detail w, item_info i, item_sub_group s where i.item_id=w.item_id and s.sub_group_id=i.sub_group_id and w.or_no="'.$or_no.'"';
		$qry = mysql_query($sql);
		$page_for = 'LocalPurchase';
		$jv_no=next_journal_sec_voucher_id();
        $jv_date = $_POST['or_date'];
        $proj_id = 'clouderp'; 
        $group_for =  $_SESSION['user']['group'];
        $cc_code = '1';
        $tr_no = $or_no;
        $tr_from = 'LocalPurchase';
        $narration = 'LocalPurchase#'.$or_no;
        $localPurchaseLedger = find_a_field('config_group_class','localPurchase','group_for="'.$group_for.'"');
		while($data=mysql_fetch_object($qry)){
		$tr_id = $data->id;
		journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->or_date,$data->qty,0,$page_for,$tr_id,$data->rate,'',$_SESSION['or_no2']);
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->ledger_id, $narration, $data->amount,'0',  $tr_from, $tr_no,'',$tr_id,$cc_code,$group_for);
		$total_amt +=$data->amount;
		}
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $localPurchaseLedger, $narration, '0',$total_amt, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		
	 
		//sec_journal_journal($jv_no,$jv_no,'LocalPurchase');
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION['or_no2']);
		$type=1;
		$msg='Successfully Forwarded.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$_POST['item_id'];
		$_POST['rate']=$_POST['unit_price'];
		$_POST['qty']=$_POST['dist_unit'];
		$_POST['amount']=$_POST['total_amt'];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$xid = $crud->insert();
		


// item info rate update
//$sql_update = "UPDATE  item_info SET cost_price ='".$_POST['rate']."' WHERE  item_id =".$_POST['item_id'];
//mysql_query($sql_update);

}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update LP Information'; else $btn_name='Initiate LP Information';
if($_SESSION['or_no2']<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item_id');
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

















<!--Mr create 2 form with table-->
<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
						<? $field='or_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">LP NO</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
								<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 <? $field='or_date'; if($or_date=='') $or_date =date(''); ?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">LP Date</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
             
       						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly" required/>
	  
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						    <? $field='chalan_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan No</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
      
          						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
        
                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
						 <? $field='requisition_from';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Requisitioin From</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                  <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
						     <? $field='vendor_name'; ?>
                            <label  for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Purchase From</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
        
        					<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
    
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 <? $field='qc_by';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">QC By</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
          						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
		                 </div>
                        </div>
						<div class="form-group row m-0 pb-1">
							<? $field='approved_by';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Approved By</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                
        
         						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
       
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						<? $field='or_subject';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
      
       						 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      
                            </div>
                        </div>

                    </div>



                </div>


            </div>

            <div class="n-form-btn-class">
                <input name="new" type="submit" value="<?=$btn_name?>" class="btn1 btn1-bg-submit"  tabindex="6">
				
				
				
            </div>
        </div>

		
        
    </form>




    <? if($_SESSION['or_no2']>0){?>
	<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
        <!--Table input one design-->
        <div class="container-fluid pt-5 p-0 ">


            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>Item Code</th>
                    <th>Item Description</th>
                    <th>Unit</th>

                    <th>Stock</th>
                    <th>Unit-Price</th>
					<th>Quantity</th>
                    <th>Value</th>
					<th>Action</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <tr>
                    <td><span class="style2">




<span id="sub">
<?

auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id','1','item_id');

//$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and pr_no=".$pr_no." order by id desc limit 1";
//$do_data = find_all_field_sql($do_details);

?>


<input name="item_id" type="text"   value="" id="item_id"  onblur="getData2('local_purchase_ajax.php', 'so_data_found', this.value, document.getElementById('or_no').value);"/>


<!--<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('pr_no').value);">

		<option></option>

      <? foreign_relation('item_info','item_id','item_name',$item_id,'1');?>
 </select>-->

		 

<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />
<input type="hidden" id="or_date" name="or_date" value="<?=$or_date?>"  />
<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
<input type="hidden" id="warehouse_id" name="warehouse_id" value="<?=$warehouse_id?>"  />
<input type="hidden" id="vendor_id" name="vendor_id" value="<?=$vendor_id?>"  />
<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
</span>




 </span></td>
                    <td colspan="4">
							<div align="right">
								  <span id="so_data_found">
						<table style="width:100%;" border="1">
							<tr>

								<td width="20%"><input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name"  /></td>

								<td width="20%"><input name="pcs_stock" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="pcs_stock"  /></td>

								<td width="20%"><input name="ctn_price" type="text" class="input3" id="ctn_price" readonly=""    required  value="<?=$do_data->ctn_price;?>"   /></td>

								<td width="20%"><input name="pcs_price" type="text" class="input3" id="pcs_price" readonly=""    required="required"  value="<?=$do_data->pcs_price;?>"  /></td>
							</tr>
						</table>
						</span>
							</div>
						</td>
                    <td><input  name="dist_unit" type="text"  id="dist_unit"value="" required    onkeyup="count()"   /></td>

                    <td><input name="total_unit" type="hidden"   id="total_unit" readonly/>		


		<input name="total_amt" type="text"  id="total_amt"     readonly/></td>
                    <td><input name="add" type="submit" id="add" value="ADD" class="btn1 btn1-bg-submit" onclick="qtyChecker()" /></td>

                </tr>

                </tbody>
            </table>





        </div>


        <!--Data multi Table design start-->
        <div class="container-fluid pt-5 p-0 ">

			<table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                   <th>S/L</th>
                    <th>Item Name</th>
                    <th>Unit Price</th>

                    <th>Qty</th>
                    <th>Unit Name</th>
					<th>Amount</th>
                    <th>X</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <? 
				$s=0;
$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_receive_detail a,item_info b where b.item_id=a.item_id and a.or_no='.$or_no;
//echo link_report_add_del_auto($res,'2','5');
$qry = mysql_query($res);
						while($data=mysql_fetch_object($qry)){
						?>
				<tr>
                    <td><?=++$s?></td>
                    <td style="text-align:left"><?=$data->item_name?></td>
                    <td><?=$data->unit_price?></td>

                    <td><?=$data->qty?></td>
					<td><?=$data->unit_name?></td>
                    <td><?=$data->amount?></td>
                    <td><a href="?del=<?=$data->id?>"> <button type="button" class="btn2 btn1-bg-cancel"><i class="fa-solid fa-trash"></i></button> </a></td>

                </tr>
				<?
				$t_amount+=$data->amount;
				 } ?>
				
				<tr bgcolor="yellow">
            <td colspan="5" align="center" valign="top" ><div align="right"><strong>Total Amount: </strong></div></td>
            <td align="center" valign="top">
                <span class="style1"> <?=$t_amount?> </span>
            </td>
        </tr>

                </tbody>
            </table>

        </div>
    </form>

    <!--button design start-->
    <form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
				<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />
				<input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
<input type="hidden" id="or_date" name="or_date" value="<?=$or_date?>"  />
                <input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD LP" />
            </div>

        </div>
    </form>
<? }?>
</div>


















<script>$("#codz").validate();$("#cloud").validate();</script>
<script language="javascript">
function count()
{


if(document.getElementById('unit_price').value!=''){



var unit_price = ((document.getElementById('unit_price').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);

var total_unit = (document.getElementById('total_unit').value)=dist_unit;

var total_amt = (document.getElementById('total_amt').value) = total_unit*unit_price;

}

}


function qtyChecker(){
 var qty = document.getElementById('dist_unit').value*1;
 var rate = document.getElementById('unit_price').value*1;
 if(qty==0 || qty=='' || qty<0){
  alert('Qty Must Be Gretter Then Zero');
  document.getElementById('dist_unit').value = '';
 }
 
 if(rate==0 || rate=='' || rate<0){
  alert('Rate Should Not Zero');
  document.getElementById('unit_price').value = '';
 }
}
</script>
<?
require_once "../../../assets/template/layout.bottom.php";
?>