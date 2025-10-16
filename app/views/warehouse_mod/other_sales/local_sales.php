<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='New Local Sales Entry';
$page_for = 'Local Sales';

$din = find_a_field('menu_warehouse','local_purchase','id="'.$_SESSION['user']['group'].'"');
if($din>0){$din=$din;}else{$din=60;}
do_calander('#oi_date','-"'.$din.'"','0');
do_calander('#quotation_date');
$tr_type="Show";

$table_master='warehouse_other_issue';
$table_details='warehouse_other_issue_detail';
$unique='oi_no';


if(isset($_POST['new']))
{
		$crud   = new crud($table_master);

		if(!isset($_SESSION['oi_no2'])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:s:i');
		$$unique=$_SESSION['oi_no2']=$crud->insert();
		unset($$unique);
		$type=1;
		$msg=$title.'  No Created. (No :-'.$_SESSION['oi_no2'].')';
		
		$tr_type="Initiate";
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:s:i');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		$tr_type="Add";
		}
}

$$unique=$_SESSION['oi_no2'];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION['oi_no2']);
		$type=1;
		$msg='Successfully Deleted.';
		$tr_type="Delete";
}

if($_GET['del']>0)
{
		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		
		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";
		db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
		$tr_type="Remove";
		
}
if(isset($_POST['confirmm']))
{
        
		$oi_no = $_POST['oi_no'];
		$receive_sub_ledger = $_POST['receive_sub_ledger'];
		$receive_ledger = find_a_field('general_sub_ledger','ledger_id','sub_ledger_id="'.$receive_sub_ledger.'"');
		
        $sql = 'select w.*,s.item_ledger,s.cogs_ledger,i.sub_ledger_id from warehouse_other_issue_detail w, item_info i, item_sub_group s where i.item_id=w.item_id and s.sub_group_id=i.sub_group_id and w.oi_no="'.$oi_no.'" and w.issue_type="Local Sales"';
		$qry = db_query($sql);
		$page_for = 'LocalSales';
		$jv_no=next_journal_sec_voucher_id();
        $jv_date = $_POST['oi_date'];
        $proj_id = 'clouderp'; 
        $group_for =  $_SESSION['user']['group'];
        $cc_code = '1';
        $tr_no = $oi_no;
        $tr_from = 'LocalSales';
        $narration = 'LocalSales#'.$oi_no;
        $localSalesLedger = find_a_field('config_group_class','localSales','group_for="'.$group_for.'"');
		while($data=mysqli_fetch_object($qry)){
		$avg_rate = find_a_field('journal_item','final_price','item_id="'.$data->item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" order by id desc');
		$cogs_amt = $data->qty*$avg_rate;
		$tr_id = $data->id;
		journal_item_control($data->item_id ,$_SESSION['user']['depot'],$data->oi_date,0,$data->qty,$page_for,$tr_id,$avg_rate,'',$_SESSION['oi_no2']);
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->item_ledger, $narration, '0',$cogs_amt,  $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group_for);
		$narration = 'LocalSales#Cogs#'.$oi_no;
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $data->cogs_ledger, $narration, $cogs_amt,'0',  $tr_from, $tr_no,$data->sub_ledger_id,$tr_id,$cc_code,$group_for);
		$total_amt +=$data->amount;
		}
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $receive_ledger, $narration, $total_amt, '0', $tr_from, $tr_no,$receive_sub_ledger,$tr_id=0,$cc_code,$group_for);
		add_to_sec_journal($proj_id, $jv_no, $jv_date, $localSalesLedger, $narration, '0', $total_amt, $tr_from, $tr_no,'',$tr_id=0,$cc_code,$group_for);
		$tr_type="Complete";
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='CHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION['oi_no2']);
		$type=1;
		$msg='Successfully Forwarded.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0) && $_SESSION['csrf_token']===$_POST['csrf_token'])
{
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
		$tr_type="Add";


// item info rate update
//$sql_update = "UPDATE  item_info SET cost_price ='".$_POST['rate']."' WHERE  item_id =".$_POST['item_id'];
//db_query($sql_update);

}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update LS Information'; else $btn_name='Initiate LS Information';
if($_SESSION['oi_no2']<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item_id');

$tr_from="Warehouse";
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
    <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
							  <? $field='oi_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Local Sales No:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
               
       							  <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
     
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 <? $field='oi_date'; if($oi_date=='') $oi_date =date(''); ?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Local Sales Date:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                 
        					<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly" required/>
							
							<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"  required/>

        					<input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
	  
                            </div>
                        </div>
						
						
						<div class="form-group row m-0 pb-1">

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                               



									<select id="group_for" name="group_for" required >
										<? user_company_access($group_for) ?>
									</select>



                            </div>

                        </div>
						
						
						
						
						
						<div class="form-group row m-0 pb-1">

						<? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name'; if($$field=='') $$field=$req_all->warehouse_id;?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                	 

							<select id="<?=$field?>" name="<?=$field?>" required style="width:220px;"    >

								<option></option>

							<? user_warehouse_access($warehouse_id);?>

									
							</select>


                            </div>

                        </div>
						

                    </div>

                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
						   <? $field='vendor_name'; ?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Payment Received</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                               
      
       							<select name="cash_bank_sub_ledger" id="cash_bank_sub_ledger" value=""  style="float:left" tabindex="2"  required>
            <option></option>
            <?php ?>
            <?
foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$cash_bank_sub_ledger,"type in ('Cash In Hand','Cash at Bank')");
?>
          </select>
      
                            </div>
                        </div>
						
						<div class="form-group row m-0 pb-1">
						   <? $field='vendor_name'; ?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sales From</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                               
      
       							 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
      
                            </div>
                        </div>
						

                        <div class="form-group row m-0 pb-1">
								 <? $field='oi_subject';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                
     
       							 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
     
                            </div>
                        </div>

                        

                    </div>



                </div>


            </div>

            <div class="n-form-btn-class">
                <input name="new" type="submit" value="<?=$btn_name?>" class="btn1 btn1-submit-input" tabindex="6">
				
            </div>
        </div>

        <!--return Table design start-->
        <!--<div class="container-fluid pt-5 p-0 ">
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>Returned By</th>
                    <th>Returned At</th>
                    <th>Remarks</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <tr>
                    <td>Row name 1</td>
                    <td>Row name 2</td>
                    <td>Row name 3</td>

                </tr>

                </tbody>
            </table>

        </div>-->
    </form>


    <? if($_SESSION['oi_no2']>0){?>
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


<input name="item_id" type="text" class="input3"  value="" id="item_id"  onblur="getData2('local_sales_ajax.php', 'so_data_found', this.value, document.getElementById('oi_no').value);"/>


<!--<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('pr_no').value);">

		<option></option>

      <? foreign_relation('item_info','item_id','item_name',$item_id,'1');?>
 </select>-->

<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />
<input type="hidden" id="oi_date" name="oi_date" value="<?=$oi_date?>"  />
<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
<input type="hidden" id="warehouse_id" name="warehouse_id" value="<?=$warehouse_id?>"  />
<input type="hidden" id="issue_type" name="issue_type" value="Local Sales"  />

<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>

</span>

 </span></td>
                    
						<td colspan="4">
							<div align="right">
								  <span id="so_data_found">
						<table style="width:100%;" border="1">
							<tr>

								<td width="20%"><input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name"  /></td>

								<td width="20%"><input name="pcs_stock" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="pcs_stock"  /></td>

								<td width="20%"><input name="ctn_price" type="text" class="input3" id="ctn_price" readonly="" required  value="<?=$do_data->ctn_price;?>"   /></td>

								<td width="20%"><input name="pcs_price" type="text" class="input3" id="pcs_price" readonly="" required="required"  value="<?=$do_data->pcs_price;?>"  /></td>
							</tr>
						</table>
						</span>
							</div>
						</td>

                    <td><input  name="dist_unit" type="text" class="input3" id="dist_unit"value=""   onkeyup="count()" required   /></td>

                    <td><input name="total_unit" type="hidden" class="form-control"   id="total_unit" readonly/>		


						<input name="total_amt" type="text" class="form-control" id="total_amt"   readonly/></td>
						
                    <td><input name="add" type="submit" id="add" value="ADD" class="btn1 btn1-bg-submit" /></td>
					

                </tr>

                </tbody>
            </table>





        </div>


        <!--Data multi Table design start-->
        <div class="container-fluid pt-5 p-0 ">

            
			<? 
				$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.oi_no='.$oi_no;

				?>
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
				
				$i=1;
				$qry = db_query($res);
				while($data=mysqli_fetch_object($qry)){
				?>
				<tr>
                    <td><?=$i++?></td>
					<td><?=$data->item_name?></td>
                    <td><?=$data->unit_price?></td>
                    <td><?=$data->qty?></td>
                    <td><?=$data->unit_name?></td>
                    <td><?=$data->amount?></td>
                    <td><a href="?del=<?=$data->id?>"> X </a></td>

                </tr>
				

                </tbody>
				<? }?>
            </table>

        </div>
    </form>

    <!--button design start-->
    <form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
				<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />
				<input type="text" id="receive_sub_ledger" name="receive_sub_ledger" value="<?=$cash_bank_sub_ledger?>"  />
<input type="hidden" id="oi_date" name="oi_date" value="<?=$oi_date?>"  />
				<input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM LOCAL SALES"  />
            </div>

        </div>
		<? }?>
    </form>
	

</div>


<?php /*?><div class="form-container_large">
<form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top"><fieldset>
    <? $field='oi_no';?>
      <div>
        <label for="<?=$field?>">Local Sales  No: </label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
      </div>
<? $field='oi_date'; if($oi_date=='') $oi_date =date(''); ?>
      <div>
        <label for="<?=$field?>">Local Sales Date:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly" required/>
	  </div>
    
    
        <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>

        <input  name="issue_type" type="hidden" id="issue_type" value="<?=$page_for?>"  required="required"/>
    </fieldset></td>
    <td>
			<fieldset>
			
    <? $field='oi_subject';?>
      <div>
        <label for="<?=$field?>">Note:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
      </div>
      <div></div>
      <? $field='vendor_name'; ?>
      <div>
        <label for="<?=$field?>">Sales From:</label>
        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
      </div>
      
      </div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td colspan="2"><div class="buttonrow" style="margin-left:240px;">
      <input name="new" type="submit" class="btn1" value="<?=$btn_name?>" style="width:250px; font-weight:bold; font-size:12px;" />
    </div></td>
    </tr>
</table>
</form>

<? if($_SESSION['oi_no2']>0){?>
<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">







<tr>
<td colspan="6" width="70%">&nbsp;       </td>
  <td width="20%"><div class="button">
		    
  <input name="add" type="submit" id="add" value="ADD" class="update" style="background: #339933; font-size:14px; font-weight:700;"/>
		    
          </div></td>
  </tr>

<tr>

<td width="10%" align="center" bgcolor="#0073AA"><span class="style2">Item Code </span></td>

<td width="60%"colspan="4" align="center" bgcolor="#0073AA">

<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
<tr>
	 <td width="55%"><span class="style2">Item Description</span></td>
	 <td width="15%"><span class="style2">Unit</span></td>
	 <td width="15%"><span class="style2">Stock</span></td>
	 <td width="15%"><span class="style2">Unit-Price</span></td>
</tr>
</table></td>

<td width="15%" align="center" bgcolor="#0073AA"><span class="style2">Quantity</span></td>
<td width="15%" align="center" bgcolor="#0073AA"><span class="style2">Value</span></td>
</tr>


<tr bgcolor="#CCCCCC">


<td align="center"><span class="style2">




<span id="sub">
<?

auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id','1','item_id');

//$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and pr_no=".$pr_no." order by id desc limit 1";
//$do_data = find_all_field_sql($do_details);

?>


<input name="item_id" type="text" class="input3"  value="" id="item_id" style="width:90%; height:30px;" onblur="getData2('local_sales_ajax.php', 'so_data_found', this.value, document.getElementById('oi_no').value);"/>


<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('pr_no').value);">

		<option></option>

      <? foreign_relation('item_info','item_id','item_name',$item_id,'1');?>
 </select>

		 

<input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />
<input type="hidden" id="oi_date" name="oi_date" value="<?=$oi_date?>"  />
<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
<input type="hidden" id="warehouse_id" name="warehouse_id" value="<?=$warehouse_id?>"  />
<input type="hidden" id="issue_type" name="issue_type" value="Local Sales"  />
</span>




 </span></td>
 <td colspan="4" align="center">
 
 
<span id="so_data_found">
<table  width="100%" border="1" align="left"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="0" cellspacing="2">
<tr bgcolor="#CCCCCC">
	 <td width="55%"><input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name" style="width:90%; height:30px;" /> </td>
	 <td width="15%"><input name="pcs_stock" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="pcs_stock" style="width:90%; height:30px;" /></td>
	 <td width="15%"><input name="ctn_price" type="text" class="input3" id="ctn_price" readonly=""   style="width:90%; height:30px;" required  value="<?=$do_data->ctn_price;?>"   /></td>
	 <td width="15%"><input name="pcs_price" type="text" class="input3" id="pcs_price" readonly=""   style="width:90%; height:30px;" required="required"  value="<?=$do_data->pcs_price;?>"  /></td>
</tr>
</table>
</span></td>
 
 <td width="10%" align="center">

<span class="style2">

<input  name="dist_unit" type="text" class="input3" id="dist_unit"value="" style="width:90%; height:30px;"   onkeyup="count()"   />
 </span></td>
<td width="10%" align="center">

<span class="style2">



<input name="total_unit" type="hidden" class="form-control"  style="width:64px" id="total_unit" readonly/>		


		<input name="total_amt" type="text" class="form-control" id="total_amt"  style="width:90%; height:30px;"   readonly/>

 </span></td>
</tr>
</table>
					  <br /><br /><br /><br />


<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td>
<div class="tabledesign2">
<? 
$res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_issue_detail a,item_info b where b.item_id=a.item_id and a.oi_no='.$oi_no;
echo link_report_add_del_auto($res,'2','5');
?>
</div>
</td>
    </tr>
	    	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>
</form>
<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
  <table width="100%" border="0">
    <tr>
      <td align="center"><input type="hidden" id="<?=$unique?>" name="<?=$unique?>" value="<?=$$unique?>"  />
<input type="hidden" id="oi_date" name="oi_date" value="<?=$oi_date?>"  />&nbsp;</td>
      <td align="center">

      <input name="confirmm" type="submit" class="btn btn-primary" value="CONFIRM LOCAL SALES" style="width:270px; font-weight:bold; font-size:12px; height:30px; color:#fff" />

      </td>
    </tr>
  </table>
</form>
<? }?>
</div><?php */?>



<script>$("#codz").validate();$("#cloud").validate();</script>
<script language="javascript">
function count()
{


if(document.getElementById('unit_price').value!=''){



var unit_price = ((document.getElementById('unit_price').value)*1);

var dist_unit = ((document.getElementById('dist_unit').value)*1);

var total_unit = (document.getElementById('total_unit').value)=dist_unit;

var total_amt = (document.getElementById('total_amt').value) = total_unit*unit_price;
var stock = document.getElementById('pcs_stock').value*1;

if(stock>=dist_unit){
if(unit_price!=''){
var total_unit = (document.getElementById('total_unit').value)=dist_unit;

var total_amt = (document.getElementById('total_amt').value) = total_unit*unit_price;

}else{
alert('Price Should Not Empty!!');
}
}else{
alert('Stock Not Found!!');
document.getElementById('dist_unit').value = '';
}

}




}

</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>