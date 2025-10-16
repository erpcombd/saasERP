<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Purchase Return Entry';

do_calander('#pr_date');
do_calander('#delivery_date');

do_calander('#customer_po_date');

create_combobox('vendor_id_combo');

//create_combobox('depot_id');



$now = date('Y-m-d H:s:i');

if($_GET['cbm_no']>0)
$cbm_no =$_SESSION['cbm_no'] = $_GET['cbm_no'];

$cdm_data = find_all_field('raw_input_sheet','','cbm_no='.$cbm_no);

do_calander('#est_date');

$page = 'new_return.php';

$table_master='purchase_return_master';

$unique_master='pr_no';

$table_detail='purchase_return_details';

$unique_detail='id';


//$table_chalan='sale_do_chalan';
//
//$unique_chalan='id';


if($_REQUEST['old_pr_no']>0)

$$unique_master=$_REQUEST['old_pr_no'];

elseif(isset($_GET['del']))

{$$unique_master=find_a_field('purchase_return_details','pr_no','id='.$_GET['del']);
            $del = $_GET['del'];
		header("Location: new_return.php?old_pr_no=".$$unique_master);	
			
			}

else

$$unique_master=$_REQUEST[$unique_master];

if(prevent_multi_submit()){

if(isset($_POST['new']))



{

		
		if($_POST['vendor_id_combo']>0) {
		$_POST['vendor_id'] = $_POST['vendor_id_combo'];
		}
	
		$job_date = $_POST['pr_date'];
		
		$YR = date('Y',strtotime($job_date));
  
  		$yer = date('y',strtotime($job_date));
  		$month = date('m',strtotime($job_date));

  		$job_cy_id = find_a_field('purchase_return_master','max(job_id)','year="'.$YR.'"')+1;
		
   		$cy_id = sprintf("%06d", $job_cy_id);
	
   		$job_no_generate='SO'.$yer.''.$month.''.$cy_id;

		$_POST['job_no'] = $job_no_generate;
		$_POST['job_id'] = $job_cy_id;
		$_POST['year'] = $YR;

		

		$crud   = new crud($table_master);



		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_at']=$_REQUEST['group_for'];



		$_POST['entry_by']=$_SESSION['user']['id'];
		
		//$merchandizer_exp=explode('->',$_POST['merchandizer']);
		
		//$_POST['merchandizer_code']=$merchandizer_exp[0];


		if($_POST['flag']<1){



		$_POST['pr_no'] = find_a_field($table_master,'max(pr_no)','1')+1;

	$po_master=find_a_field('purchase_receive','po_no','pr_no="'.$_POST['invoice_no'].'"');
	
	$po_all=find_all_field('purchase_master','*','po_no="'.$po_master.'"');


    $_POST['rebate_percentage'] = $po_all->rebate_percentage;
	
	$_POST['po_no']=$po_all->po_no;
	$_POST['vat']=$po_all->vat;
	$_POST['ait']=$po_all->ait;

		$$unique_master=$crud->insert();



		



		$type=1;



		$msg='Sales Return Initialized. (Sales Return No-'.$$unique_master.')';



		}



		else {
		
		
		unset($_POST['job_no']);
		unset($_POST['job_id']);
		unset($_POST['year']);
		
		$po_master=find_a_field('purchase_receive','po_no','pr_no="'.$_POST['invoice_no'].'"');
	
	$po_all=find_all_field('purchase_master','*','po_no="'.$po_master.'"');

 $_POST['po_no']=$po_all->po_no;
	$_POST['vat']=$po_all->vat;
	 $_POST['ait']=$po_all->ait;

		$crud->update($unique_master);



		$type=1;



		$msg='Successfully Updated.';



		}



}




if(isset($_POST['add'])&&($_POST[$unique_master]>0))

{
    

$table		=$table_detail;
if($_POST['sub_group_id']!=0){
$_SESSION['sub_group'] = $_POST['sub_group_id'];
$_SESSION['vendor_id'] = $_POST['vendor_id'];
$_SESSION['group_for'] = $_POST['group_for'];
}

$crud      	=new crud($table);

 $_POST['remarks']=$_POST['remarks11'];
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];


//if($_REQUEST['init_bag_unit']<1){
//
//$_POST['init_bag_unit'] = $_REQUEST['bag_unit'];
//$_POST['init_dist_unit'] = $_REQUEST['total_unit'];
//$_POST['init_total_unit'] = $_REQUEST['total_unit'];
//$_POST['init_total_amt'] = $_REQUEST['total_amt'];
//
//}




//$xid = $crud->insert();
if($_REQUEST['item_id']>0){
$invo_id = $_POST['item_id'];

$invo_all= find_all_field('purchase_receive','*','id='.$_POST['item_id'].'');
  $item_id=$invo_all->item_id; 
   $with_vat_rate=$invo_all->with_vat_rate;
  $with_vat_amount=($invo_all->with_vat_rate*$_REQUEST['dist_unit']);
  
  $vat_amt= ($with_vat_amount-$_REQUEST['total_amt']);
  
  $stock=find_a_field('journal_item','sum(item_in-item_ex)','item_id="'.$item_id.'" and warehouse_id="'.$_POST['depot_id'].'"');
  
  if($stock>=$_REQUEST['dist_unit']){

$addd_sql = "INSERT INTO `purchase_return_details` 
(`pr_no`,  `pr_date`, vendor_id, `item_id`, `unit_name`, depot_id,`unit_price`, dist_unit, total_unit, `total_amt`,with_vat_rate,vat_amt,total_amt_with_vat,entry_by, entry_at, remarks) VALUES
('".$pr_no."',  '".$_POST['pr_date']."', '".$_POST['vendor_id']."','".$item_id."', '".$_REQUEST['unit_name']."',
 '".$_POST['depot_id']."', '".$_REQUEST['unit_price']."', '".$_REQUEST['dist_unit']."', '".$_REQUEST['dist_unit']."',
  '".$_REQUEST['total_amt']."', '".$with_vat_rate."','".$vat_amt."','".$with_vat_amount."','".$_SESSION['user']['id']."', '".$now."', '".$_POST['remarks']."')";

    db_query($addd_sql);

}else{
 
echo '<span style=" color:red;"><strong>Stock not available!!</strong></span>';

}	

}



//$table_ch		=$table_chalan;


//$crud      	=new crud($table_ch);


//$cid = $crud->insert();

  //$challan_sql = "INSERT INTO `sale_do_chalan` 
// (`chalan_no`, `order_no`, pr_no, `item_id`, `vendor_id`, `unit_price`,`pkt_unit`, bag_unit, dist_unit, total_unit, total_amt, chalan_date, depot_id, group_for, entry_by, entry_at) VALUES
//('".$_POST['chalan_no']."', '".$xid."', '".$_POST['pr_no']."', '".$_POST['item_id']."',  '".$_POST['vendor_id']."', '".$_POST['unit_price']."',  '".$_POST['pkt_unit']."', '".$_POST['bag_unit']."', '".$_POST['dist_unit']."' , '".$_POST['total_unit']."' , '".$_POST['total_amt']."' , '".$_POST['pr_date']."' ,'4', '".$_POST['group_for']."', '".$_SESSION['user']['id']."', '".$now."' )";
//
//mysql_query($challan_sql);


   










//$_POST['init_total_unit'] = $_POST['init_dist_unit'];

//$_POST['in_stock_kg']=$_POST['in_stock'];

//$_POST['init_total_amt'] = ($_POST['init_total_unit'] * $_POST['unit_price']);

//$_POST['t_price'] = 0;

//$_POST['gift_on_order'] = $crud->insert();

}

}

else

{

$type=0;

$msg='Data Re-Submit Error!';

}



if($del>0)

{	

$main_del = find_a_field($table_detail,'gift_on_order','id = '.$del);

$crud   = new crud($table_detail);

if($del>0)

{

$condition=$unique_detail."=".$del;		

$crud->delete_all($condition);

$condition="gift_on_order=".$del;		

$crud->delete_all($condition);

if($main_del>0){

$condition=$unique_detail."=".$main_del;		

$crud->delete_all($condition);

$condition="gift_on_order=".$main_del;		

$crud->delete_all($condition);}

}


 



$type=1;

$msg='Successfully Deleted.';

}

if($$unique_master>0)

{

$condition=$unique_master."=".$$unique_master;

$data=db_fetch_object($table_master,$condition);

//while (list($key, $value)=@each($data))

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
  echo '<span style="color:green;">Success! New Purchase Return Added</span>';
 
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
}

$dealer = find_all_field('dealer_info','','vendor_id='.$vendor_id);

//auto_complete_from_db('dealer_info','item_name','concat(item_name,"#>",finish_goods_code)','','vai_cutomer');

//auto_complete_from_db('area','area_name','area_code','','district');

//auto_complete_from_db('customer_info','customer_name_e ','customer_code',' vendor_id='.$vendor_id,'via_customer1');

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
<style type="text/css">



/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 100%;
    height: 37px;
    border-radius: 0px !important;
}
/*div.form-container_large input {
    width: 250px;
    height: 37px;
    border-radius: 0px !important;
}
*/



.onhover:focus{
background-color:#66CBEA;

}


<!--
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>




<!--Mr create 2 form with table-->
<div class="form-container_large">
    <form action="<?=$page?>" method="post" name="codz2" id="codz2" autocomplete="off">
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PR No:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input style="width:250px;"  name="pr_no" type="text" id="pr_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

					<?php /*?>	<input name="group_for" type="hidden" id="group_for" required readonly="" style="width:250px;" value="<?=$_SESSION['user']['group']?>" tabindex="105" /><?php */?>
						 <input name="vat" type="hidden" class="form-control" readonly="" id="vat"  value="0" tabindex="101" />
                            </div>
                        </div>



						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return Date:</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <input style="width:250px;"  name="pr_date" type="text" id="pr_date" value="<?=($pr_date!='')?$pr_date:date('Y-m-d')?>"  required />
                            </div>
							
							
                        </div>
						
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return Type:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select name="return_type" required id="return_type"   style="width:250px;" class="form-control"  >
								  <? foreign_relation('purchase_return_type','id','return_type',$return_type,'id=1');?>
								</select>
                            </div>
                        </div>
					
			
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                <select  id="depot_id" name="depot_id" class="form-control"  style="width:250px;" >
								  <? user_warehouse_access($depot_id);?>
								</select>

                            </div>
                        </div>

                    </div>
                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                    <div class="form-group row m-0 pb-1">
     <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company Name:</label>
     <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
	                    <select  id="group_for" name="group_for" class="form-control"  style="width:250px;" onchange="get_vendor();" required >
                        <option></option>
	                       <? user_company_access($group_for); ?>
						</select>
							
					</div>
                        </div>	
                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Vendor:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                
                                <select  id="vendor_id" name="vendor_id" class="form-control"  required style="width:250px;" onchange="get_grn()" >
									  
                                <? foreign_relation('vendor','vendor_id','concat(vendor_name," (",vendor_id," )")',$vendor_id,'1 and group_for='.$group_for.'');?>


								</select>
                            </div>
                        </div>

                        

                        <div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Remarks:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              <input style="width:250px;"  name="remarks" type="text" id="remarks" value="<?=$remarks;?>" />
                            </div>
                        </div>

<div class="form-group row m-0 pb-1">
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">GRN No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              <input style="width:250px;"  name="invoice_no" type="text" id="invoice_no" value="<?=$invoice_no;?>"  list="grn"/>
							  <datalist id="grn">
							  
							  
							  </datalist>
                            </div>
                        </div>










                    </div>



                </div>
				
				


            </div>

            <div class="n-form-btn-class">
				<? if($$unique_master>0) {?>



		<input name="new" type="submit" class="btn1 btn1-bg-submit" value="Update Entry"  tabindex="5" />



		<input name="flag" id="flag" type="hidden" value="1" />



		<? }else{?>



		<input name="new" type="submit" class="btn1 btn1-bg-submit" value="Initiate Entry"  tabindex="5" />



		<input name="flag" id="flag" type="hidden" value="0" />



		<? }?>
            </div>
        </div>

        <!--return Table design start-->
        <div class="container-fluid  p-0 ">
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
                    <td>Row name 1</td>
                    <td>Row name 2</td>
                    <td>Row name 3</td>

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
        <div class="container-fluid pt-0 p-0 ">


            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th width="200px" >Item Code</th>
                    <th width="200px">Item Description</th>
                    <th width="">Stock</th>
					<th width="">GRN Qty</th>
                    <th>Unit-Price</th>
                    <th width="" !importent>Quantity</th>

                    <th>Value</th>
                    <th>ADD</th>
                </tr>
                </thead>

                <tbody class="tbody1">


				<tr>

                    <td><span class="style2">




<span id="sub">
<?

//auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id',' product_nature="Salable"','item_id');

//$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and pr_no=".$pr_no." order by id desc limit 1";
//$do_data = find_all_field_sql($do_details);

?>

<?php /*?>
<input name="item_id" type="text" class="input3"  value="" id="item_id"  onblur="getData2('return_ajax.php', 'so_data_found', this.value, document.getElementById('pr_no').value);"/><?php */?>
<?
$master_data=find_all_field('purchase_return_master','*','pr_no='.$$unique_master.'');

$invos =$master_data->invoice_no;
$vendor=$master_data->vendor_id;
?>

<select  name="item_id" id="item_id"  style="width:300px;" required onblur="item_data(this.value);">

    <option></option>

      <? foreign_relation('purchase_invoice p,purchase_receive m, item_info i ','m.id','concat(i.item_id,"->",i.item_name,"(",m.id,")")',$item_id,'1 and m.item_id = i.item_id and m.vendor_id='.$vendor.' and m.order_no=p.id and    m.po_no=p.po_no and m.pr_no in ('.$invos.')');?>
 </select>



<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />
<input type="hidden" id="pr_date" name="pr_date" value="<?=$pr_date?>"  />
<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
<input type="hidden" id="depot_id" name="depot_id" value="<?=$depot_id?>"  />
<input type="hidden" id="vendor_id" name="vendor_id" value="<?=$vendor_id?>"  />
<input name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date;?>"/>
<input name="job_no" type="hidden" id="job_no" value="<?=$job_no;?>"/>
</span>




 </span></td>

                    

<td width="180px"><input name="item_name" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="item_name"  /> </td>

<td width=""><input name="pcs_stock" type="text" class="input3"  readonly=""  autocomplete="off"  value="" id="pcs_stock"  /></td>

<td width=""><input name="grn_qty" type="text" class="input3" id="grn_qty" readonly="" required  value="" /></td>


<td width=""><input name="unit_price" type="text" class="input3" id="unit_price" readonly=""    required="required"  value=""  /></td>
                  <td><span >
                    <input width="" name="dist_unit" type="text" class="input3" id="dist_unit" value=""    onkeyup="count()"   />
                  </span></td>

                    <td><span>



<input name="total_unit" type="hidden"    id="total_unit" readonly/>


		<input name="total_amt" type="text"  id="total_amt"     readonly/>

 </span></td>
                    <td><input name="add" type="submit" class="btn1 btn1-bg-submit" value="ADD" /></td>
                </tr>
                </tbody>
            </table>





        </div>


        <!--Data multi Table design start-->
		<? if($$unique_master>0){?>
		<?

    $res='select s.*,i.item_name from purchase_return_details s left join item_info i on i.item_id=s.item_id where s.pr_no="'.$$unique_master.'"';

?>
        <div class="container-fluid pt-5 p-0 ">

            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-info">
                    <th>SL</th>
                    <th>Item Description</th>
                    <th>Unit</th>

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

                    <td><?=$data->total_unit?></td>
					<td><?=$data->unit_price?></td>
                    <td><?=$data->total_amt?></td>
                    <td><a href="?del=<?=$data->id?>">X</a></td>
                </tr>
				<?
 $total_pcs +=$data->total_unit;
 $total_amt +=$data->total_amt;
 } ?>

<tr>

<td colspan="2"><div align="right"><strong>  Total:</strong></div></td>

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
    <form action="new_return.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
       <table>


<tr>



            
               <?php /*?> <td><input name="delete" type="submit" class="btn1 btn1-bg-cancel" value="DELETE AND CANCEL REQUSITION" /></td>
               <td> <input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD REQUSITION" /></td>

<?php */?>

				<td><input name="delete"  type="submit" class="btn1 btn1-bg-cancel" value="DELETE PR"  /></td>
				<td><input  name="pr_no" type="hidden" id="pr_no" class="btn1 btn1-bg-cancel" value="<?=$$unique_master?>"/></td>
				<td><input  name="pr_date" type="hidden" id="pr_date" class="btn1 btn1-bg-cancel" value="<?=$pr_date?>"/></td>
				<td width="80%">&nbsp;</td>
				<td><input name="confirm" type="submit" class="btn1 btn1-bg-submit"  value="CONFIRM PR" /></td>
          
</tr>
       </table>
		<? }?>
    </form>

</div>












<?php /*?><div class="form-container_large">

<form action="<?=$page?>" method="post" name="codz2" id="codz2">

<table width="99%" border="0" cellspacing="0" cellpadding="0" align="center">

<tr>

<td>

<div>

<label style="width:220px;">PR No: </label>

<input style="width:250px;"  name="pr_no" type="text" id="pr_no" value="<? if($$unique_master>0) echo $$unique_master; else echo (find_a_field($table_master,'max('.$unique_master.')','1')+1);?>" readonly/>

<input name="group_for" type="hidden" id="group_for" required readonly="" style="width:250px;" value="<?=$_SESSION['user']['group']?>" tabindex="105" />
 <input name="vat" type="hidden" class="form-control" readonly="" id="vat"  value="15" tabindex="101" />
</div>

</td>



</tr>



<tr>

<td>
<? if($pr_date=="") {?>
<div>

<label style="width:220px;">Return Date: </label>

<input style="width:250px;"  name="pr_date" type="text" id="pr_date" value="<?=($pr_date!='')?$pr_date:date('Y-m-d')?>"  required />
</div>
<? }?>


<? if($pr_date!="") {?>
<div>
<label style="width:220px;">Return Date: </label>
<input style="width:250px;"  name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date;?>"/>

<input style="width:250px;"  name="pr_date2" type="text" id="pr_date2" value="<?=$pr_date;?>" required/>
</div>
<? }?>

</td>



</tr>

<tr>

<td>

<div>

<label style="width:220px;">warehouse: </label>

			<select  id="depot_id" name="depot_id" class="form-control"  style="width:250px;" >
			   <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
            </select>
</div>

</td>



</tr>

<tr>

<td>
<div>

<label style="width:220px;">Vendor: </label>

<select  id="vendor_id" name="vendor_id" class="form-control"  required style="width:250px;" >
	  <option></option>
	 <? foreign_relation('vendor','vendor_id','vendor_name',$vendor_id,'1');?>

</select>

</div>
</td>



</tr>

<tr>

<td>

<div>

<label style="width:220px;">Return Type: </label>

<select name="return_type" required id="return_type"   style="width:250px;" class="form-control"  >

                      <? foreign_relation('purchase_return_type','id','return_type',$return_type,'1');?>
                    </select>
</div>


</td>



</tr>

<tr>

<td>

<div>

<label style="width:220px;">Remarks: </label>

<input style="width:250px;"  name="remarks" type="text" id="remarks" value="<?=$remarks;?>" />
</div>


</td>



</tr>


<td>







		<div class="buttonrow">



		<? if($$unique_master>0) {?>



		<input name="new" type="submit" class="btn1" value="Update Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="1" />



		<? }else{?>



		<input name="new" type="submit" class="btn1" value="Initiate Entry" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />



		<input name="flag" id="flag" type="hidden" value="0" />



		<? }?>



		</div>



</td>


	<?
	$sql = 'select a.*,u.fname from approver_notes a, user_activity_management u where a.entry_by=u.user_id and master_id="'.$$unique_master.'" and type in ("PurchaseReturn") and a.master_id>0';
	$row_check = mysql_num_rows(mysql_query($sql));
	if($row_check>0){
	?>
	<tr>
	   <td colspan="2">
	      <table border="1" cellpadding="3" cellspacing="0" style=" width:100%; margin:auto; border-collapse:collapse;">
		     <tr style="background:#CCCCCC;">
			    <th>Returned By</th>
				<th>Returned At</th>
				<th>Remarks</th>
			 </tr>
			 <?
			  
			  $qry = mysql_query($sql);
			  while($return_note=mysql_fetch_object($qry)){
			 ?>
			 <tr>
			    <td><?=$return_note->fname?></td>
				<td><?=$return_note->entry_at?></td>
				<td><?=$return_note->note?></td>
			 </tr>
			 <? } ?>
		  </table>
	   </td>
	</tr>
	<? } ?>


</table>


</form>

<? if($$unique_master>0) {?>

<form action="<?=$page?>" method="post" name="codz2" id="codz2">





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

auto_complete_from_db('item_info','concat(item_id,"-> ",item_name)','item_id',' product_nature="Salable"','item_id');

//$do_details="SELECT a.*, i.item_name FROM sale_do_details a, item_info i WHERE  a.item_id=i.item_id and pr_no=".$pr_no." order by id desc limit 1";
//$do_data = find_all_field_sql($do_details);

?>


<input name="item_id" type="text" class="input3"  value="" id="item_id" style="width:90%; height:30px;" onblur="getData2('return_ajax.php', 'so_data_found', this.value, document.getElementById('pr_no').value);"/>


<!--<select  name="item_id" id="item_id"  style="width:90%;" required onchange="getData2('sales_invoice_ajax.php', 'so_data_found', this.value, document.getElementById('pr_no').value);">

		<option></option>

      <? foreign_relation('item_info','item_id','item_name',$item_id,'1');?>
 </select>-->

		 

<input type="hidden" id="<?=$unique_master?>" name="<?=$unique_master?>" value="<?=$$unique_master?>"  />
<input type="hidden" id="pr_date" name="pr_date" value="<?=$pr_date?>"  />
<input type="hidden" id="group_for" name="group_for" value="<?=$group_for?>"  />
<input type="hidden" id="depot_id" name="depot_id" value="<?=$depot_id?>"  />
<input type="hidden" id="vendor_id" name="vendor_id" value="<?=$vendor_id?>"  />
<input name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date;?>"/>
<input name="job_no" type="hidden" id="job_no" value="<?=$job_no;?>"/>
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








<? if($$unique_master>0){?>

<br /><br /><br /><br />

<? 

  $res='select s.*,i.item_name,i.unit_name from purchase_return_details s left join item_info i on i.item_id=s.item_id where s.pr_no="'.$$unique_master.'"';

?>

<div  class="tabledesign2">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px;">

<tr>

<th width="2%">SL</th>
<th width="28%">Item Description</th>
<th width="7%">Unit</th>
<th width="7%">Qty</th>
<th width="7%">Rate</th>
<th width="7%">Amount</th>
<th width="7%">X</th>
</tr>


<?

$i=1;

$query = mysql_query($res);

while($data=mysql_fetch_object($query)){ ?>

<tr>

<td><?=$i++?></td>

<td><?=$data->item_name?></td>
<td><?=$data->unit_name?></td>
<td><?=$data->total_unit?></td>
<td><?=$data->unit_price?></td>
<td><?=$data->total_amt?></td>
<td><a href="?del=<?=$data->id?>">X</a></td>

</tr>

<?
 $total_pcs +=$data->total_unit;
 $total_amt +=$data->total_amt;
 } ?>

<tr>

<td colspan="2"><div align="right"><strong>  Total:</strong></div></td>

<td>&nbsp;</td>
<td align="right"><?=number_format($total_pcs,2);?></td>
<td>&nbsp;</td>
<td align="right"><?=number_format($total_amt,2);?></td>
<td>&nbsp;</td>

</tr>







<? }?>
</table>

</div>

</form>

<br />


<form action="new_return.php" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">

<table width="100%" border="0">
<tr>
<td align="center" width="50%">
<input name="delete"  type="submit" class="btn1" value="DELETE PR" style="width:60%; font-weight:bold; background:#0073AA; font-size:12px;color:#F00; height:30px" />
<input  name="pr_no" type="hidden" id="pr_no" value="<?=$$unique_master?>"/>
<input  name="pr_date" type="hidden" id="pr_date" value="<?=$pr_date?>"/></td>
<td align="right" style="text-align:right" width="50%">
<input name="confirm" type="submit" class="btn1" value="CONFIRM PR" style="width:60%; background:#0073AA; font-weight:bold; font-size:12px; height:30px; color: #FFFFFF; float:right" />
</td>
</tr>




</table>

<? }?>

</form>

</div><?php */?>







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



function get_vendor() { 
    var group_for = document.getElementById('group_for').value;

    $.ajax({
        type: "POST",
        url: "vendor_grn_ajax.php",
        data: { group_for: group_for },
        success: function(data) {
            console.log(data); // Debugging
            $('#vendor_id').html(data);
        },
        error: function(xhr, status, error) {
            console.error("Error: " + status + " " + error);
        }
    });
}

function get_grn() { 
    var group_for = document.getElementById('group_for').value;
    var vendor = document.getElementById('vendor_id').value;


    $.ajax({
        type: "POST",
        url: "vendor_grn_list_ajax.php",
        data: { group_for: group_for,vendor: vendor },
        success: function(data) {
            console.log(data); // Debugging
            $('#grn').html(data);
        },
        error: function(xhr, status, error) {
            console.error("Error: " + status + " " + error);
        }
    });
}



function item_data(id){

    var pr_no = document.getElementById('pr_no').value;
    var depot_id = document.getElementById('depot_id').value;
    var pr_id = id;


    $.ajax({
        type: "POST",
        dataType: "json",
        url: "return_ajax.php",
        data: { pr_id: pr_id, pr_no: pr_no,depot_id },
        success: function(data) {
            console.log(data);
            /* $('#so_data_found').html(data); */

            document.getElementById('item_name').value = data.item_name;
            document.getElementById('pcs_stock').value = data.pcs_stock;
            document.getElementById('grn_qty').value = data.pqty;
            document.getElementById('unit_price').value = data.unit_price;
            
        },
        error: function(xhr, status, error) {
            console.error("Error: " + status + " " + error);
        }
    });
}


</script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";




?>