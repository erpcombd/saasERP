<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Other Receive';
$tr_type="Show";
do_calander('#or_date');
do_calander('#delivery_date');

do_calander('#customer_po_date');

create_combobox('vendor_id_combo');

$now = date('Y-m-d H:i:s');

if($_GET['cbm_no']>0)
$cbm_no =$_SESSION['cbm_no'] = $_GET['cbm_no'];

$cdm_data = find_all_field('raw_input_sheet','','cbm_no='.$cbm_no);

do_calander('#est_date');

$page = 'return_checking.php';

$table_master='warehouse_other_receive';

$unique_master='or_no';

$table_detail='warehouse_other_receive_detail';

$unique_detail='id';


//$table_chalan='sale_do_chalan';
//
//$unique_chalan='id';


if($_REQUEST['or_no']>0)

$$unique_master=$_REQUEST['or_no'];

elseif(isset($_GET['del']))

{$$unique_master=find_a_field('warehouse_other_receive_detail','or_no','id='.$_GET['del']); $del = $_GET['del'];}

else

$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){
if(isset($_POST['new']))
{

		
		if($_POST['vendor_id_combo']>0) {
		$_POST['vendor_id'] = $_POST['vendor_id_combo'];
		}
	
		$job_date = $_POST['or_date'];
		
		$YR = date('Y',strtotime($job_date));
  
  		$yer = date('y',strtotime($job_date));
  		$month = date('m',strtotime($job_date));

  		$job_cy_id = find_a_field('warehouse_other_receive','max(job_id)','year="'.$YR.'"')+1;
		
   		$cy_id = sprintf("%06d", $job_cy_id);
	
   		$job_no_generate='SO'.$yer.''.$month.''.$cy_id;

		$_POST['job_no'] = $job_no_generate;
		$_POST['job_id'] = $job_cy_id;
		$_POST['year'] = $YR;

		

		$crud   = new crud($table_master);



		$_POST['entry_at']=date('Y-m-d H:i:s');



		$_POST['entry_by']=$_SESSION['user']['id'];
		
		//$merchandizer_exp=explode('->',$_POST['merchandizer']);
		
		//$_POST['merchandizer_code']=$merchandizer_exp[0];


		if($_POST['flag']<1){



		$_POST['or_no'] = find_a_field($table_master,'max(or_no)','1')+1;



		$$unique_master=$crud->insert();



		



		$type=1;



		$msg='Sales Return Initialized. (Sales Return No-'.$$unique_master.')';
		$tr_type="Initiate";


		}



		else {
		
		
		unset($_POST['job_no']);
		unset($_POST['job_id']);
		unset($_POST['year']);



		$crud->update($unique_master);



		$type=1;



		$msg='Successfully Updated.';

		$tr_type="Add";

		}



}




if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{
    

$table		=$table_detail;
$crud      	=new crud($table);
$_POST['remarks']=$_POST['remarks11'];
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['rate']=$_POST['unit_price'];
$_POST['qty']=$_POST['dist_unit'];
$_POST['amount']=$_POST['total_amt'];
$xid = $crud->insert();
$tr_type="Add";
}

}

else

{

$type=0;

$msg='Data Re-Submit Error!';

}

if($del>0)

{	

$crud   = new crud($table_detail);

if($del>0)

{

$condition=$unique_detail."=".$del;		

$crud->delete_all($condition);

$condition="gift_on_order=".$del;		

$crud->delete_all($condition);

}

$type=1;

$msg='Successfully Deleted.';

}

if($$unique_master>0)

{

$condition=$unique_master."=".$$unique_master;

$data=db_fetch_object($table_master,$condition);

foreach($data as $key => $value)

{ $$key=$value;}

}

if(isset($_POST['confirm'])){
  
  
  unset($_POST);
  $crud   = new crud($table_master);
  $_POST[$unique_master] = $$unique_master;
  $_POST['entry_by'] = $_SESSION['user']['id'];
  $_POST['entry_at'] = date('Y-m-d H:i:s');
  $_POST['status'] = 'UNCHECKED';
  $crud->update($unique_master);
  unset($$unique_master);
  unset($_SESSION[$unique]);
  echo '<span style="color:green;">Success! Other Receive Added</span>';
 	$tr_type="Complete";
}

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		$crud   = new crud($table_chalan);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
		$tr_type="Delete";
}

// $dealer = find_all_field('dealer_info','','vendor_id='.$vendor_id);

// auto_complete_from_db('dealer_info','item_name','concat(item_name,"#>",finish_goods_code)','','vai_cutomer');

// auto_complete_from_db('area','area_name','area_code','','district');

// auto_complete_from_db('customer_info','customer_name_e ','customer_code',' vendor_id='.$vendor_id,'via_customer1');
// $tr_from="Warehouse";
?>

<script language="javascript">
function count()
{


if(document.getElementById('unit_price').value!=''){

var vat = ((document.getElementById('vat').value)*1);
var pkt_size = ((document.getElementById('pkt_size').value)*1);
var unit_price = ((document.getElementById('unit_price').value)*1);
var pkt_unit = ((document.getElementById('pkt_unit').value)*1);
var dist_unit = ((document.getElementById('dist_unit').value)*1);

var total_unit = (document.getElementById('total_unit').value)=(pkt_unit*pkt_size)+dist_unit;

var total_amt = (document.getElementById('total_amt').value) = unit_price*total_unit;

var discount = ((document.getElementById('discount').value)*1);

var amt_after_discount = (document.getElementById('amt_after_discount').value) = total_amt-discount;

var vat_amt = (document.getElementById('vat_amt').value) = (amt_after_discount*vat)/100;

//document.getElementById('total_unit').value=dist_unit;

var total_amt_with_vat = (document.getElementById('total_amt_with_vat').value) = amt_after_discount+vat_amt ;


document.getElementById('total_amt_with_vat').value  = total_amt_with_vat.toFixed(2);




}



}



</script>



<script language="javascript">




//function TRcalculation(){
//    
//var unit_name = document.getElementById('unit_name').value;
//var unit_price = document.getElementById('unit_price').value*1;
//var total_unit = document.getElementById('total_unit').value*1;
//var qty_kg = document.getElementById('qty_kg').value*1;
//
//
//if(unit_name=="Pcs"){
//var total_amt = document.getElementById('total_amt').value= (unit_price*total_unit);}
//
//else {
//    var total_amt = document.getElementById('total_amt').value= (unit_price*qty_kg);
//}
//
//
// if(unit_price<final_price)
//  {
//alert('You can`t reduce the price');
//document.getElementById('unit_price').value='';
//  } 
//  
//  
//}






</script>
<!--<style type="text/css">



/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 250px;
    height: 37px;
    border-radius: 0px !important;
}




.onhover:focus{
background-color:#66CBEA;

}


<!--
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}

</style>-->




<!--Mr create 2 form with table-->
<div class="form-container_large">
    <form action="<?=$page?>" method="post" name="codz2" id="codz2">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
        <? if($or_date!=date('Y-m-d')){ ?>
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Warning!</h4>
                        <p>Today is not the Receive date.This data will post on current Date after submit.</p>
                    </div>
                <? } ?>
            <div class="row">
                
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive No:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input style="width:250px;"  name="or_no" type="text" id="or_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

						<input name="group_for" type="hidden" id="group_for" required readonly="" style="width:250px;" value="<?=$_SESSION['user']['group']?>" tabindex="105" />
						 <input name="vat" type="hidden" class="form-control" readonly="" id="vat"  value="" tabindex="101" />
						 <input type="hidden" name="receive_type" id="receive_type" value="Otherreceive_typeIssue" />
                            </div>
                        </div>



						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive Date:</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input style="width:250px;"  name="or_date" type="text" id="or_date" value="<?=($or_date!='')?$or_date:date('Y-m-d')?>"  required />
                            </div>
                        </div>


                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select  id="warehouse_id" name="warehouse_id" class="form-control"  style="width:250px;" >
								   <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'warehouse_id="'.$warehouse_id.'"');?>
								</select>

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select  id="group_for" name="group_for" class="form-control"  style="width:250px;" >
									<? foreign_relation('user_group','id','group_name',$group_for,'id="'.$group_for.'"');?>

								</select>

                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive From:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input type="text" id="issued_to" name="issued_to" class="form-control" value="<?=$issued_to?>"  required style="width:250px;" />
									  
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Authorized By:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input name="approved_by" type="text" required id="approved_by" value="<?=$approved_by?>" style="width:250px;" class="form-control" />
								 
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Remarks:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input style="width:250px;"  name="or_details" type="text" id="or_details" value="<?=$or_details;?>" />

                            </div>
                        </div>

                    </div>



                </div>


            </div>

            
        </div>

        <!--return Table design start-->
        <div class="container-fluid pt-2 p-0 ">
		<?
	$sql = 'select a.*,u.fname from approver_notes a, user_activity_management u where a.entry_by=u.user_id and master_id="'.$$unique_master.'" and type in ("PurchaseReturn") and a.master_id>0';
	$row_check = mysqli_num_rows(db_query($sql));
	if($row_check>0){
	?>
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>Returned By</th>
                    <th>Returned At</th>
                    <th>Remarks</th>
                </tr>
                </thead>

                <tbody class="tbody1">
				<?

			  $qry = db_query($sql);
			  while($return_note=mysqli_fetch_object($qry)){
			 ?>

                <tr>
                    <td><?=$return_note->fname?></td>
                    <td><?=$return_note->entry_at?></td>
                   <td><?=$return_note->note?></td>

                </tr>
				<? } ?>

                </tbody>
            </table>
			<? } ?>

        </div>
    </form>



<? if($$unique_master>0) {?>
    <form action="" method="post" name="cloud" id="cloud">
        <!--Table input one design-->
        <div class="container-fluid p-0 ">





        </div>


        <!--Data multi Table design start-->
		<? if($$unique_master>0){?>
		<?

  $res='select s.*,i.item_name,i.unit_name,l.ledger_name,g.sub_ledger_name as Subsidiary_ledger from warehouse_other_receive_detail s left join item_info i on i.item_id=s.item_id
  
  LEFT JOIN 
	accounts_ledger l 
	ON 
	l.ledger_id = s.cr_ledger
	LEFT JOIN 
	general_sub_ledger g
	ON 
	g.sub_ledger_id = s.cr_sub_ledger
  
  
  
   where s.or_no="'.$$unique_master.'"';

?>
        <div class="container-fluid pt-2 p-0 ">

            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>SL</th>
                    <th>Item Description</th>
                    <th>Unit</th>
					<th>Cr Ledger</th>
					<th>Cr Subsidiary Ledger</th>
                    <th>Qty</th>
                    <th>Rate</th>
					<th>Amount</th>

                    <th>Action</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <?

$i=1;

$query = db_query($res);

while($data=mysqli_fetch_object($query)){ ?>
				<tr>
                    <td><?=$i++?></td>
                    <td><?=$data->item_name?></td>
                    <td><?=$data->unit_name?></td>
					<td><?=$data->ledger_name?></td>
					<td><?=$data->Subsidiary_ledger?></td>
                    <td><?=$data->qty?></td>
					<td><?=$data->rate?></td>
                    <td><?=$data->amount?></td>
                    <td>
						<a href="?del=<?=$data->id?>"> 
							<button type="button"class="btn2 btn1-bg-cancel">
								<i class="fa-solid fa-trash"></i>
							</button> 
						</a>
					</td>

                </tr>
				<?
 $total_pcs +=$data->qty;
 $total_amt +=$data->amount;
 } ?>

<tr>

<td colspan="4"><div align="right"><strong>  Total:</strong></div></td>

<td>&nbsp;</td>
<td align="right"><?=number_format($total_pcs,2);?></td>
<td>&nbsp;</td>
<td align="right"><?=number_format($total_amt,2);?></td>
<td>&nbsp;</td>

</tr>

                </tbody>
				<? }?>
            </table>


        </div>
    </form>

    <!--button design start-->
    <form action="unapproved_pr.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
        <div class="container-fluid p-0 ">






            <div class="n-form-btn-class">
               
					<input name="return"  type="submit" class="btn1 btn1-bg-cancel" value="RETURN"  />
					<input  name="or_no" type="hidden" id="or_no" value="<?=$$unique_master?>"/>
					<input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/></td>
					
					<input name="confirm" type="submit" class="btn1 btn1-submit-input" value="CONFIRM" />
            </div>

        </div>
		<? }?>
    </form>

</div>













<!--<script>$("#cz").validate();$("#cloud").validate();</script>-->
<script language="javascript">
function count()
{


if(document.getElementById('unit_price').value!=''){

var vat = ((document.getElementById('vat').value)*1);

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