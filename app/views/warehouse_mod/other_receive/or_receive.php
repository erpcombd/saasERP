<?php
 
//ini_set('display_startup_errors', 1);
//ini_set('display_errors', 1);
//error_reporting(-1);
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='New Other Receive';
$page_for = 'Other Receive';

/*if($_SESSION['user']['group']=='4'){
do_calander('#or_date','-360','0');
}
do_calander('#or_date','-5','0');
do_calander('#quotation_date');*/

$din = find_a_field('menu_warehouse','other_receive','id="'.$_SESSION['user']['group'].'"');
if($din>0){$din=$din;}else{$din=60;}
do_calander('#or_date');
 
$table_master='warehouse_other_receive';
$table_details='warehouse_other_receive_detail';
$unique='or_no';
$tr_type="Show";


if($_GET['new']>0) {unset($_SESSION['or_no']);}


if($_GET['or_no']>0) {$_SESSION['or_no']=$_GET['or_no'];}

if(isset($_SESSION['or_no'])) $$unique=$_SESSION['or_no']; else $$unique=0;

if(isset($_POST['new']))
{
    $crud   = new crud($table_master);

    if(!isset($_SESSION['or_no'])) {
        // INSERT
        $_POST['entry_by']=$_SESSION['user']['id'];
        $_POST['entry_at']=date('Y-m-d h:i:s');
        $_POST['edit_by']=$_SESSION['user']['id'];
        $_POST['edit_at']=date('Y-m-d h:i:s');
        $$unique=$_SESSION['or_no']=$crud->insert();
        //unset($$unique);
        $type=1;
        $msg=$title.'  No Created. (No :-'.$_SESSION['or_no'].')';
        $tr_type="Initiate";
    }
    else {
        // UPDATE
        $update = "update warehouse_other_receive_detail set or_date='".$_POST['or_date']."',warehouse_id=".$_POST['warehouse_id']." where or_no='".$_POST['or_no']."'";
        db_query($update);

        $_POST['edit_by']=$_SESSION['user']['id'];
        $_POST['edit_at']=date('Y-m-d h:s:i');
        $crud->update($unique);
        $type=1;
        $msg='Successfully Updated.';
        $tr_type="Add";
    }
}


$$unique=$_SESSION['or_no'];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION['or_no']);
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
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION['or_no']);
		$type=1;
		$msg='Successfully Forwarded.';
		$tr_type="Complete";
		
}

if(isset($_POST['add'])&&($_POST[$unique]>0) && $_SESSION['csrf_token']===$_POST['csrf_token'])
{
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[1];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$xid = $crud->insert();
		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['or_date'],$_POST['qty'],0,$page_for,$xid,$_POST['rate']);
		$tr_type="Add";
}

if(isset($_POST['upload_excel_btn']) && ($_POST[$unique]>0) && $_SESSION['csrf_token']=== $_POST['csrf_token'] )
{   
    
    

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
		$filename=$_FILES["excel_file"]["tmp_name"];
		$ext=end(explode('.',$_FILES["excel_file"]["name"]));
		if($ext=='csv'){
     	if($_FILES["excel_file"]["size"] > 0){

		      $file = fopen($filename, "r");
			  $count = 0;
			  while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
			  { 
			  $count++; 
              if($count>1)
			  {

                        $crud = new crud($table_details);
                        $_POST['item_id'] = $getData[0];
                        $_POST['qty'] = $getData[2];
                        $_POST['rate'] = $getData[1];
                        $_POST['amount'] = $getData[1] * $getData[2];
                        $_POST['unit_name'] = find_a_field('item_info', 'unit_name', 'item_id="' . $getData[0] . '"');
                        $_POST['receive_type'] = $page_for;
                        $_POST['cr_ledger'] = $getData[3];
                        $_POST['cr_sub_ledger'] = $getData[4];
                        $_POST['or_no'] = $_POST['or_no'];
                        $_POST['warehouse_id'] = $_POST['warehouse_id'];
                        $_POST['or_date'] = $_POST['or_date'];
                        $_POST['entry_by'] = $_SESSION['user']['id'];
                        $_POST['entry_at'] = date('Y-m-d H:i:s');
                        $_POST['edit_by'] = $_SESSION['user']['id'];
                        $_POST['edit_at'] = date('Y-m-d H:i:s');
                        $crud->insert();
                    }
                    
                } 
 }
fclose($file);  
 }
 else{
 echo $message = '<span style="color:red; font-weight:bold">Opps! Invalid Data. Please upload as per system format!</span>';
 }

}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';


//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
$depot_type = find_a_field('warehouse','use_type','warehouse_id="'.$_SESSION['user']['depot'].'"');


auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','1','item_id');
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
function count(){
var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
document.getElementById('amount').value = num.toFixed(2);	
}
</script>





    <div class="form-container_large">
        <form action="?" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
            <div class="container-fluid bg-form-titel">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="container n-form2">

                            <fieldset>

                                <? $field='or_no';?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">OR  No:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                      <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly/>
                                    </div>
                                </div>

                                <? $field='or_date'; if($or_date=='') $or_date =date('Y-m-d'); ?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>"class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">OR Date :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly" required />

                                                           
                                    </div>
                                </div>

                                <? $field='requisition_from';?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Requisition From :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
                                    </div>
                                </div>
								
								<? $field='group_for';?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company:</label>
                                  <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
									<?php if($group_for>0){  ?>
										<input  name="<?=$field?>" type="hidden" id="<?=$field?>" value="<?=$$field?>" />
									
									<? } ?>
                                    <select  id="group_for" name="group_for" class="form-control" <?=($group_for>0) ? 'disabled' : '' ?>  required >
                                      <? user_company_access($group_for); ?>
                                    </select>
                                  </div>
                                </div>
								
								
								

                                
                                <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
                            </fieldset>

                        </div>



                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                        <div class="container n-form2">

                            <fieldset>

                                <? $field='or_subject';?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Slip No :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
                                    </div>
                                </div>


                                <? $field='vendor_name'; ?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive From :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
                                    </div>
                                </div>


                                <? $field='approved_by';?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Approved By :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" />
                                    </div>
                                </div>


                                <div class="form-group row m-0 pb-1">
								<label for="req_note" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
								
									<?php if($warehouse_id>0){  ?>
										<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" />
									
									<? } ?>
									<select name="warehouse_id" id="warehouse_id" <?=($warehouse_id>0) ? 'disabled' : '' ?> required>
									   
									   <option></option>
									   <? user_warehouse_access($warehouse_id);?> 
								  </select>
								</div>
							</div>



                            </fieldset>



                        </div>






                    </div>

                </div>

                <div class="n-form-btn-class">
                  <input name="new" type="submit" class="btn1 btn1-bg-submit" value="<?=$btn_name?>" />
				  
                </div>
            </div>

            <!--return Table design start-->
            <div class="container-fluid pt-2 p-0 ">

            </div>

        </form>



        <? if($_SESSION['or_no']>0){?>
        <!-- Beautified Excel Upload Form -->
        <form action="?<?=$unique?>=<?=$$unique?>" method="post" enctype="multipart/form-data" class="mb-4">
            <div class="form-group row align-items-center">
                <label for="excel_file" class="col-sm-3 col-form-label font-weight-bold text-right">
                    Upload Excel File:
                </label>
                <div class="col-sm-3">
                    <input type="file" name="excel_file" id="excel_file" class="form-control-file" accept=".csv" required />
                    <input type="hidden" name="or_no" value="<?=$or_no?>">
                    <input type="hidden" name="warehouse_id" value="<?=$warehouse_id?>">
                    <input type="hidden" name="or_date" value="<?=$or_date?>">
                    <input type="hidden" name="csrf_token" value="<?=$_SESSION['csrf_token']?>">
                </div>
                <div class="col-sm-3">
                    <button type="submit" name="upload_excel_btn" class="btn btn-success w-100">
                        <i class="fa fa-upload"></i> Upload
                    </button>
                </div>
                <div class="col-sm-3">
                    
                    <a href="test.csv" class="btn btn-outline-secondary btn-sm" download>
                        <i class="fa fa-download"></i> Download Sample CSV
                    </a>
                </div>
                <div class="col-sm-12">
                    <p class="text-muted">
                        **Please ensure that your Excel file is formatted correctly before uploading. First row as header and data in subsequent rows. Required columns: Item ID, Quantity, Rate, Cr Ledger, Subsidiary Ledger.**
                    </p>
                </div>
                
            </div>
        </form>
    
        <form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
            <!--Table input one design-->
            <div class="container-fluid pt-2 p-0">
                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Item Name</th>
                        <th>Stock</th>
                        <th>Unit</th>
						
                        <th>Price</th>
						
						<th>Cr Ledger</th>
						<th>Subsidiary Ledger</th>
						
						<th>Qty</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <tr>
                        <td align="center">
                            <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
                            <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
                            <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
                            <input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>
                            <input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>
							
							<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
							
                            <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>"  required onblur="getData2('or_receive_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"  autofocus /></td>
							
                        <td colspan="3" align="center">
						<span id="po" style=" display: flex; width: 100% !important; ">
						<input name="stk" type="text" class="form-control" id="stk"  readonly="readonly" style=" width: 36% !important; "/>
						<input name="unit_name" type="text" class="form-control" id="unit_name"  readonly="readonly" style=" width: 30% !important; margin: 0px 7px !important; "/>
						<input name="rate" type="text" class="form-control" id="rate"   readonly="readonly" style=" width: 34% !important;" required="required"/>
						</span></td>
						
						<td>
							<input list="cr_ledgers" type="text" name="cr_ledger" id="cr_ledger" class="form-control" required  autocomplete="off" />
							<datalist id="cr_ledgers">
								<? foreign_relation('accounts_ledger','ledger_id','ledger_name','','1'); ?>
							</datalist>
						</td>
						<td>
							<input list="sub_ledger_list" name="cr_sub_ledger" type="text" class="input3" id="cr_sub_ledger" class="form-control"   autocomplete="off" />

							<datalist id="sub_ledger_list">
								<? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name','','1'); ?>
							</datalist>
						</td>
						
						
						
						
                        <td align="center"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" onchange="count()" required/></td>
                        <td align="center"><input name="amount" type="text" class="input3" id="amount"  readonly="readonly" required/></td>
                        <td><input name="add" type="submit" id="add" class="btn1 btn1-bg-submit" value="ADD"></td>
                    </tr>

                    </tbody>
                </table>



            </div>




            <!--Data multi Table design start-->
            <div class="container-fluid pt-5 p-0 ">

                <div class="tabledesign2 border-0">
                    <?
                    $res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,l.ledger_name,s.sub_ledger_name as Subsidiary_ledger,"x" from warehouse_other_receive_detail a
					
					
					LEFT JOIN item_info b
					 		on  b.item_id=a.item_id 
					 
					LEFT JOIN 
							accounts_ledger l 
						ON 
							l.ledger_id = a.cr_ledger
					LEFT JOIN 
							general_sub_ledger s 
						ON 
							s.sub_ledger_id = a.cr_sub_ledger
						WHERE
					 
					  a.or_no='.$$unique;
					
					


                    echo link_report_add_del_auto($res,'',4,6);


                    ?>

                </div>

            </div>
        

            
        </form>



        <!--button design start-->
        <form action="?" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
            <div class="container-fluid p-0 ">

                <div class="n-form-btn-class">

                    <input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD OR"/>
                </div>

            </div>
        </form>

        <? } ?>
    </div>





<script>$("#codz").validate();$("#cloud").validate();</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>