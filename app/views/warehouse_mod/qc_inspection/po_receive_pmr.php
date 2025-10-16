<?php


// ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$c_id = $_SESSION['proj_id'];


$title='Purchased Material QC Inspection';



do_calander('#rec_date');



$table_master='purchase_master';

$table_details='purchase_invoice';


$get_po_no=$_GET['po_no'];
$get_pmr_no=$_GET['pmr_no'];
$unique='po_no';

if($_SESSION[$unique]>0)

$$unique=$_SESSION[$unique];

if($_GET[$unique]>0){

$$unique=$_GET[$unique];
$pc_no=$_GET['pc_no'];

$_SESSION[$unique]=$$unique;}

else

$$unique = $_SESSION[$unique];

$all=find_all_field('purchase_master','','po_no="'.$_GET['po_no'].'"');

if(isset($_POST['confirmm']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$_POST['status']='COMPLETED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Successfully Completed All Purchase Order.';

}



if(isset($_POST['delete']))

{

		unset($_POST);

		$_POST[$unique]=$$unique;

		$_POST['edit_by']=$_SESSION['user']['id'];

		$_POST['edit_at']=date('Y-m-d h:s:i');

		$_POST['status']='CANCELED';

		$crud   = new crud($table_master);

		$crud->update($unique);

		unset($$unique);

		unset($_SESSION[$unique]);

		$type=1;

		$msg='Canceled Remainning All Purchase Order.';

}



if(prevent_multi_submit()){



if(isset($_POST['confirm']) && $_SESSION['csrf_token']===$_POST['csrf_token']){
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

		$vendor_id = $_POST['vendor_id'];

		$warehouse_id = $_POST['warehouse_id'];

		$qc_by=$_POST['qc_by'];

		$ch_no=$_POST['ch_no'];

		$rec_date=$_POST['rec_date'];

		$rec_no=$_POST['rec_no'];

		$now = date('Y-m-d H:i:s');
		
		$status='QC_RECEIVE';
		
	
		
		$pmr_no=$_POST['pmr_no'];
		
		
		
	//	$sql = 'select * from purchase_invoice where po_no = '.$pc_no;
$sql = 'select * from primary_receive_purchase where pmr_no = '.$pmr_no;
		$query = db_query($sql);

		$qc_no = find_a_field('qc_receive_purchase','max(qc_no)','1')+1;

		$vendor = find_all_field('vendor','ledger_id',"vendor_id=".$vendor_id);

		$vendor_ledger = $vendor->ledger_id;

		//$jv=next_journal_sec_voucher_id();
	////////file upload Start/////
		
		$folder='qc_file';
$field = 'upload_file';
$file_name = $field.'-'.$qc_no;
if($_FILES['upload_file']['tmp_name']!=''){
//$random = random_int(10000,99999);
//$newFileName = 'vendor_tin_'.$random;
$ext = end(explode(".",$_FILES['upload_file']['name']));
//$_POST['tin']=upload_file($folder,$field,$file_name);
file_upload_aws('upload_file','qc_file',$file_name);
$_POST['upload_file']= $file_name.'.'.$ext;
$tr_type="Add";
}
	////////file upload End/////	




		while($data=mysqli_fetch_object($query))

		{
			//////update purchase_invoice//////
			$unrec_qty=$_POST['unrec_qty_'.$data->id];
			$fresh_qty=$_POST['chalan_'.$data->id];
			$damage_qty=$_POST['damage_qty_'.$data->id];
			$deduction_qty=$_POST['deduction_qty_'.$data->id];
			$detection_amount=$_POST['detection_amount_'.$data->id];
			$tot_rec_input=$fresh_qty+$damage_qty;
			
			
		 
			$is_complete=$_POST['is_complete_'.$data->id];
				if($is_complete==1){
					$up_sql='update purchase_invoice set is_complete=1 where po_no="'.$po_no.'" and id="'.$data->id.'"';
					db_query($up_sql);
				}
		 

			if(($_POST['chalan_'.$data->id]>0)){
			
				$pc_no=$data->pc_no;
				$qty=$_POST['chalan_'.$data->id];
                
				$damage_qty=$_POST['damage_qty_'.$data->id];
				$deduction_qty=$_POST['deduction_qty_'.$data->id];
				$detection_amount=$_POST['detection_amount_'.$data->id];
				$short_qty=$_POST['short_qty_'.$data->id];
				$quarentine=$_POST['quarentine_'.$data->id];
				
				$all_qty=$_POST['all_qty_'.$data->id];
				$rate=$_POST['rate_'.$data->id];
				$item_id =$_POST['item_id_'.$data->id];
				$unit_name =$data->unit_name;
				$amount = ($qty*$rate);
				$total = $total + $amount;
			
  $q = "INSERT INTO `qc_receive_purchase` (`qc_no`, `po_no`, `order_no`, `rec_no`,`rec_date`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, `qty`, `unit_name`, `amount`, `qc_by`, `entry_by`, `entry_at`,ch_no,status,damage_qty,short_qty,quarentine,all_qty,pc_no,pmr_no,deduction_qty,detection_amount) VALUES('".$qc_no."', '".$po_no."', '".$data->id."', '".$rec_no."','".$rec_date."',".$vendor_id.", '".$item_id."',".$warehouse_id.", ".$rate.", '".$qty."', '".$unit_name."',  '".$amount."', '".$qc_by."',  '".$_SESSION['user']['id']."', '".$now."', '".$ch_no."','".$status."','".$damage_qty."','".$short_qty."','".$quarentine."','".$all_qty."','".$pc_no."','".$pmr_no."','".$deduction_qty."','".$detection_amount."')";

db_query($q);
$last_id=db_insert_id();

///Qc Parameter Start//
if($all->qc_with_parameter == 'Yes'){
	$sqlTasks = "SELECT * FROM item_parameter_details WHERE po_no ='".$po_no."' AND item_id = '".$item_id."'";
	$resultTasks = db_query($sqlTasks);
	while ($row = mysqli_fetch_object($resultTasks)){
		$qc_receive_no = $last_id;
		$qc_master = $qc_no;
		$po_master_id =$_POST['po_master_id_'.$row->id];
		$po_details_id =$_POST['po_details_id_'.$row->id];
		$item_id =$_POST['item_id_'.$row->id];
		$parameter_id =$_POST['parameter_id_'.$row->id];
		$maximum =$_POST['maximum_'.$row->id];
		$minimum =$_POST['minimum_'.$row->id];
		$entry_by = $_SESSION['user']['id'];
		$entry_at =date('Y-m-d h:s:i');
		
		$qp ="INSERT INTO `qc_item_parameter_details`(`qc_receive_no`, `qc_no`, `po_no`, `po_master_id`, `po_details_id`, `item_id`, `parameter_id`, `maximum`, `minimum`, `entry_by`, `entry_at`) VALUES ('".$qc_receive_no."', '".$qc_master."', '".$po_no."', '".$po_master_id."', '".$po_details_id."', '".$item_id."', '".$parameter_id."', '".$maximum."', '".$minimum."', '".$entry_by."', '".$entry_at."')";
		db_query($qp);
	}

}
///Qc Parameter end//

//
//$xid = db_insert_id();
//journal_item_control($data->item_id ,$warehouse_id,$rec_date,$qty,0,'Purchase',$xid,$rate,'',$qc_no);


			}

		}
		
		
//if($xid>0)
//auto_insert_purchase_secoundary_journal($qc_no); 



}

}

else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($delivery_within>0)

{

	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);

}

?>
<script>
function addup(id) {
var fresh=(document.getElementById("chalan_"+id).value)*1;
var damage=(document.getElementById("damage_qty_"+id).value)*1;
var deduction=(document.getElementById("deduction_qty_"+id).value)*1;
 
var add=fresh+damage;
document.getElementById("all_qty_"+id).value = add;
}

</script>

<style>
label{
color:black;
}

</style>





<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}" enctype="multipart/form-data" >
<!--        top form start hear-->
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
						 <? $field='po_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO NO </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
        

       							 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
<input  name="pmr_no" type="hidden" id="pmr_no" value="<?=$_GET['pmr_no']?>"/>
      
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 <? $field='po_date';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO Date</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                           

        						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>

                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						<? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='vendor_name';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Supplier :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
              

       							 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"  readonly="readonly"/>

    

                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
								 <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='address';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Address :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                            

        						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$vendor_id)?>"  readonly="readonly"/>


                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
						 <? $field='vendor_id2'; $table='vendor';$get_field='vendor_id';$show_field='contact_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Contacts :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                      

       							 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" style="width:200px;" readonly="readonly" />


                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
								<? $field='req_no';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PR. No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                        
							<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  readonly="readonly" />
    
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 <? $field='quotation_date';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PR. Date:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              
								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"  readonly="readonly" />

                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
						      <? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                           


     								<input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly="readonly"/>

		<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required="required"/>


                            </div>
                        </div>
						<div class="form-group row m-0 pb-1">
						<? $field='entry_by'; $table='user_activity_management';$get_field='user_id';$show_field='fname';?>
                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Entry By:</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                

								<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly=""/>


                            </div>
                        </div>
						
					

                    </div>



                </div>
				
				
				<div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
				
							<div class="d-flex justify-content-center pt-5 pb-2">
								<div class="n-form1 fo-white pt-0 p-0">
									<div class="container p-0">
									
									
									
								<table class="table1  table-striped table-bordered table-hover table-sm">
								
									<thead>
																			
												<tr class="bgc-yellow">
										
												  <td><strong>Date</strong></td>
										
												  <td><strong>QC NO</strong></td>
												</tr>
									</thead>
										
													  

										
										<?

 $sql='select distinct qc_no,rec_date from qc_receive_purchase where po_no='.$get_po_no.' order by qc_no desc';

$qqq=db_query($sql);

while($aaa=mysqli_fetch_object($qqq)){

?>
										
												<tr>
										
												  <td><?=$aaa->rec_date?></td>
										
												  <td ><a target="_blank" href="chalan_view2.php?qc_no=<?=rawurlencode(url_encode($aaa->qc_no));?>">
												    <?=$aaa->qc_no?>
												  </a></td>
												</tr>
										
										<?
										
										}
										
										?>
								</table>
										
						
						
						
									</div>
								</div>
							</div>
                   



                </div>
				


            </div>
			
			
			

            
        </div>


			<div class="d-flex justify-content-center pt-5 pb-2">
        <div class="n-form1 fo-white pt-0 p-0">
            <div class="container p-0">
			
			
			
			
			<table class="table1  table-striped table-bordered table-hover table-sm">

					  <tr>
					
						<td colspan="3" align="center"><strong>Entry Information</strong></td>
					
						</tr>
					
					  <tr>
					
						<td align="right" >Created By:</td>
					
						<td align="left" >&nbsp;&nbsp;<?=find_a_field('user_activity_management','fname','user_id='.$entry_by);?></td>
					
						<?php /*?><td rowspan="2" align="center" ><a href="../../../views/purchase_mod/po/po_print_view_store.php?po_no=<?=rawurlencode(url_encode($po_no));?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td><?php */?>
						
						
						<td rowspan="2" align="center" ><a href="../../../views/purchase_mod/po/po_print_view_store.php?c=<?=rawurlencode(url_encode($c_id));?>&v=<?=rawurlencode(url_encode($po_no));?>" target="_blank"><img src="../../../images/print.png" width="26" height="26" /></a></td>
					
					  </tr>
					
					  <tr>
					
						<td align="right" >Created On:</td>
					
						<td align="left">&nbsp;&nbsp;<?=$entry_at?>></td>
					
						</tr>
					
					</table>
                



            </div>
        </div>
    </div>



<div class="container-fluid bg-form-titel">
            <div class="row">
                <!--left form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
						
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Manual QC NO</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
        

       							 <input   name="rec_no" type="text" id="rec_no" value="" required="required"/>

      
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 
                            <label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">QC Date :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                           
								<input  name="rec_date" type="text" id="rec_date" value="" required="required" autocomplete="off"/>
                            </div>
                        </div>

                       <div class="form-group row m-0 pb-1">
								 
                            <label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Upload File :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                           
								<input  name="upload_file" type="file" id="upload_file" value=""   autocomplete="off"/>
                            </div>
                        </div>

                    </div>



                </div>

                <!--Right form-->
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">
								
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">QC By :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                        		<?php
									  $sql33="SELECT user_id,fname,mobile from user_activity_management";
									 
												$query23=db_query($sql33);
									
									 ?>		 
									
									 <input type="text" list="browsers112" name="qc_by" id="qc_by"  autocomplete="off" > 
									  <datalist id="browsers112">
									
									  <?php 
									  
									  while($datarow=mysqli_fetch_object($query23)){
									  
									  
									  ?>
												  
											 <option value="<?=$datarow->user_id?>"> <?=$datarow->fname?></option> 
												   
									 <?php }?>
											  </datalist>
    
                            </div>
                        </div>

                        <div class="form-group row m-0 pb-1">
								 
                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan No :</label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                              
								<input   name="ch_no" type="text" id="ch_no" required="required"/>

                            </div>
                        </div>

                        
						
						
						
					

                    </div>



                </div>
				
				
				


            </div>
			
			
			

            
        </div>



        <!--return Table design start-->
        <div class="container-fluid pt-5 p-0 ">
				<? if($$unique>0){

					$sql='select a.id,a.item_id,b.item_name,b.unit_name,a.qty,a.rate from primary_receive_purchase a,item_info b where b.item_id=a.item_id and a.pmr_no='.$get_pmr_no;
					
					$res=db_query($sql);
					$s=1;
					?>
            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
				<? if($all->qc_with_parameter == 'Yes'){?>
                <tr class="bgc-info">
                    <th rowspan="2">SL</th>
					<th rowspan="2">Item Code</th>
                    <th rowspan="2">Item Name</th>
                    <th rowspan="2">UOM</th>
					<th rowspan="2">PO Qty</th>
                    <th colspan="2">Received Qty</th>
                    <th rowspan="2">Pending Qty</th>
					<th rowspan="2">Fresh Quantity</th>
					<th rowspan="2">Deduction Quantity</th>
					<th rowspan="2">Deduction Amount</th>
					<th rowspan="2">Is Complete? </th>
                </tr>
				<? } ?>
				
				
				<? if($all->qc_with_parameter == 'NO'){?>
						  <th rowspan="2">SL</th>
					<th rowspan="2">Item Code</th>
                    <th rowspan="2">Item Name</th>
                    <th rowspan="2">UOM</th>
					<th rowspan="2">PO Qty</th>
                    <th colspan="2">Received Qty</th>
                    <th rowspan="2">Pending Qty</th>
					<th rowspan="2">Fresh Quantity</th>
					<th rowspan="2">Damage Quantity</th>
					<th rowspan="2">Is Complete? </th>
				
				<? } ?>
				<tr>
            <th bgcolor="#009900">Fresh</th>
            <th bgcolor="#009900">Damage</th>
          </tr>
                </thead>
				
				
				
				
          

                <tbody class="tbody1">
				
				 <? while($row=mysqli_fetch_object($res)){$bg++?>
<? if($all->qc_with_parameter == 'Yes'){?>
				<tr <?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>>
	
				<td <? if($all->qc_with_parameter == 'Yes'){echo'rowspan="2"';}?>><?=++$ss;?></td>
	
				<td><?=find_a_field('item_info','finish_goods_code','item_id="'.$row->item_id.'"');?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>
	
				  <td><?=$row->item_name?>
	
					<input  type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" style="width:90px; float:none" /></td>
	
				  <td align="center"><?=$row->unit_name?>
	
					<input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>
	
				  <td align="center"><?=round($row->qty,0);?></td>
	
				  <td align="center"><?php   $rec_qty = (find_a_field('qc_receive_purchase','sum(all_qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));
			  echo $fresh=find_a_field('qc_receive_purchase','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1);
			  ?></td>
	
				  <td align="center"><?php    echo $damage_get=find_a_field('qc_receive_purchase','sum(deduction_qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1);?></td>
					
					<td align="center"><? echo $unrec_qty=($row->qty-$fresh);?>

                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>
					
					<td align="center"> <? if($unrec_qty>0){$cow++;}?>
  <? if($row->is_complete<1){ ?>
                <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:70px; float:none"  onchange="addup(<?=$row->id?>)"  required/>

                <? } else echo 'Done';?></td>
	
				  <td><input name="deduction_qty_<?=$row->id?>" type="text" id="deduction_qty_<?=$row->id?>" style="width:70px; float:none" value="0" onchange="addup(<?=$row->id?>)"  /></td>
				  <td><input name="detection_amount_<?=$row->id?>" type="text" id="detection_amount_<?=$row->id?>" style="width:70px; float:none" value="0" onchange="addup(<?=$row->id?>)"  /></td>
				 
<input name="all_qty_<?=$row->id?>" type="hidden" id="all_qty_<?=$row->id?>"  />
<td><input type="checkbox" id="is_complete_<?=$row->id?>" name="is_complete_<?=$row->id?>" value="1" <?php if ($row->is_complete>0){?>readonly checked="checked"<?php } ?>></td>
	
				</tr>
				  <? } ?>
				
				<tr>
				<? if($all->qc_with_parameter == 'Yes'){?>
                <td colspan="11">
                    <div class="row m-0 p-0">
                        <?php
                        
						$sqlTasks = "SELECT * FROM item_parameter_details WHERE po_no ='".$po_no."' AND item_id = '".$row->item_id."'";
                        $resultTasks = db_query($sqlTasks);
                        while ($row = mysqli_fetch_object($resultTasks)) { 
						?>
								<div class="col-sm-2 p-1" style="zoom: 80%">
									<div class="content1 rounded p-2" style="background-color: #f9f9f9 !important; 
										 box-shadow: rgba(17, 17, 26, 0.05) 0px 1px 0px, rgba(17, 17, 26, 0.1) 0px 0px 8px;
										 border: 1px solid #9f9898;">
										<div class="d-flex justify-content-between align-items-center">
											<h6>Parameter: <strong><?=find_a_field('parameter_info','parameter_name','id="'.$row->parameter_id.'"');?></strong></h6>
											<input type="hidden" name="po_master_id_<?=$row->id?>" id="po_master_id_<?=$row->id?>" value="<?=$row->po_master_id?>" readonly required/>
											<input type="hidden" name="po_details_id_<?=$row->id?>" id="po_details_id_<?=$row->id?>" value="<?=$row->po_details_id?>" readonly required/>
											<input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" readonly required/>
											<input type="hidden" name="parameter_id_<?=$row->id?>" id="parameter_id_<?=$row->id?>" value="<?=$row->parameter_id?>" readonly required/>											
										</div>
										<div> 
											<p class="m-0 text-left">Max: <strong><?=number_format($row->maximum,2);?> </strong> <input type="text" name="maximum_<?=$row->id?>" id="maximum_<?=$row->id?>" value="" required/></p>
											<p class="m-0 text-left">Min: <strong><?=number_format($row->minimum,2);?> </strong> <input type="text" name="minimum_<?=$row->id?>" id="minimum_<?=$row->id?>" value="" required/></p>
										</div>
									</div>
								</div>
                     <?php } ?>
                    </div>
                </td>
			<? } ?>
			</tr>
			
			
			<? if($all->qc_with_parameter == 'NO'){?>
			<tr <?=(($bg%2)==1)?'#FFEAFF':'#DDFFF9'?>>
	
				<td><?=++$ss;?></td>
	
				<td><?=find_a_field('item_info','finish_goods_code','item_id="'.$row->item_id.'"');?>

              <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>
	
				  <td><?=$row->item_name?>
	
					<input  type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" style="width:90px; float:none" /></td>
	
				  <td align="center"><?=$row->unit_name?>
	
					<input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>
	
				  <td align="center"><?=round($row->qty,0);?></td>
	
				  <td align="center"><?php   $rec_qty = (find_a_field('qc_receive_purchase','sum(all_qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));
			  echo $fresh=find_a_field('qc_receive_purchase','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1);
			  ?></td>
	
				  <td align="center"><?php    echo $damage_get=find_a_field('qc_receive_purchase','sum(damage_qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1);?></td>
					
					<td align="center"><? echo $unrec_qty=($row->qty-$fresh);?>

                <input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>
					
					<td align="center"> <? if($unrec_qty>0){$cow++;}?>
  <? if($row->is_complete<1){ ?>
                <input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>" style="width:70px; float:none"  onchange="addup(<?=$row->id?>)"  />

                <? } else echo 'Done';?></td>
	
				  <td><input name="damage_qty_<?=$row->id?>" type="text" id="damage_qty_<?=$row->id?>" style="width:70px; float:none" value="0" onchange="addup(<?=$row->id?>)"  /></td>
				 
<input name="all_qty_<?=$row->id?>" type="hidden" id="all_qty_<?=$row->id?>"  />
<td><input type="checkbox" id="is_complete_<?=$row->id?>" name="is_complete_<?=$row->id?>" value="1" <?php if ($row->is_complete>0){?>readonly checked="checked"<?php } ?>></td>
	
				  </tr>
				
				<? } ?>
					
					
				<? } ?>
				
				

                </tbody>
            </table>

        </div>
    



    <!--button design start-->
    
        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">
<? 
$check_is_po=find_a_field('primary_receive_purchase','count(id)','is_complete!=1 and pmr_no="'.$get_pmr_no.'"');
if($check_is_po<1){

$vars['status']='COMPLETED';

db_update('primary_receive_purchase', $get_pmr_no, $vars, 'prm_no');

?>

<tr>

<td colspan="2" align="center" bgcolor="#009900"><strong>THIS QC Inspection IS COMPLETE</strong></td>

</tr>

<? }else{?>

<tr>

<td align="center"><input type="button" class="btn1 btn1-bg-help" value="CLOSE"  onclick="window.location.href='upcomming_po_list.php'" />

<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/></td>

<td align="center">
<input  name="csrf_token" type="hidden" id="csrf_token" value="<?=$_SESSION['csrf_token']?>"/>
<input name="confirm" type="submit" class="btn1 btn-success" value="RECEIVE"  />
</td>

</tr>

<? }?>
				
					
					
            </div>

        </div>
		
		
	<? } ?>
    </form>

</div>


<script>$("#codz").validate();$("#cloud").validate();</script>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>