<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$title='Purchased Product Receive';


do_calander('#rec_date','0');


$table_master='purchase_master';


$table_details='purchase_receive';


$unique='po_no';


if($_SESSION[$unique]>0)


$$unique=$_SESSION[$unique];


if($_REQUEST[$unique]>0){



$$unique=$_REQUEST[$unique];



$_SESSION[$unique]=$$unique;}



else



$$unique = $_SESSION[$unique];


if($_SESSION['pr_no']>0){
$pr_no = $_SESSION['pr_no'];
}



if(isset($_POST['confirmm'])){
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



if(isset($_POST['return'])){

        $remarks = $_POST['return_remarks'];
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$_POST['status']='MANUAL';



		$crud   = new crud($table_master);



		$crud->update($unique);

		

		echo $note_sql = 'insert into approver_notes(`master_id`,`type`,`note`,`entry_at`,`entry_by`) value("'.$$unique.'","PR","'.$remarks.'","'.date('Y-m-d H:i:s').'","'.$_SESSION['user']['id'].'")';

		db_query($note_sql);



		unset($$unique);



		unset($_SESSION[$unique]);



		$type=1;



		header('location:select_upcoming_po.php');



}







//if(isset($_POST['delete']))

//

//{

//

//		unset($_POST);

//

//		$_POST[$unique]=$$unique;

//

//		$_POST['edit_by']=$_SESSION['user']['id'];

//

//		$_POST['edit_at']=date('Y-m-d h:s:i');

//

//		$_POST['status']='CANCELED';

//

//		$crud   = new crud($table_master);

//

//		$crud->update($unique);

//

//		

//

//

//

//		unset($$unique);

//

//		unset($_SESSION[$unique]);

//

//		$type=1;

//

//		$msg='Canceled Remainning All Purchase Order.';

//

//}


if(prevent_multi_submit()){

if(isset($_POST['confirm'])){
		$group_for = $_POST['group_for'];
		$vendor_id = $_POST['vendor_id'];
		$warehouse_id = $_POST['warehouse_id'];
		$qc_by=$_POST['qc_by'];
		$ch_no=$_POST['ch_no'];
		$transport_charge=$_POST['transport_charge'];
		$other_charge=$_POST['other_charge'];
		$remarks=$_POST['remarks'];
		$rec_date=$_POST['rec_date'];
		$rec_no= find_a_field('purchase_receive','max(rec_no)','po_no="'.$po_no.'"')+1;

		$now = date('Y-m-d H:s:i');

		if($_SESSION['pr_no']>0){
		$pr_no = $_SESSION['pr_no'];
		}else{
		$pr_no = $_SESSION['pr_no'] = next_transection_no('0',$rec_date,'purchase_receive','pr_no');
		}

		$po_master= find_all_field('purchase_master','','po_no="'.$po_no.'"');


		$sql = 'select p.*,i.item_type from purchase_invoice p, item_info i where i.item_id=p.item_id and p.po_no = '.$po_no;

		$query = db_query($sql);
		
		
		//$folder='mrr_chalan_1';
		//$field = 'upload_chalan_1';
		//$file_name = $folder.'-'.$pr_no;
		//if($_FILES['upload_chalan_1']['tmp_name']!=''){
		//$_POST['upload_chalan_1']=upload_file($folder,$field,$file_name);
		//}
		
		
	$folder ='mrr_chalan_1';
	$field = 'upload_chalan_1';
	$file_name = $field.'-'.$_POST['pr_no'];
	if($_FILES['upload_chalan_1']['tmp_name']!=''){
	$random = random_int(10000,99999);
	$newFileName = 'mrr_chalan_1_'.$random;
	$ext = end(explode(".",$_FILES['upload_chalan_1']['name']));
	//$_POST['file_upload']=upload_file($folder,$field,$file_name);
	file_upload_aws('upload_chalan_1','mrr_chalan_1',$newFileName);
	$_POST['upload_chalan_1']= $newFileName.'.'.$ext;
	}
		
		
		
		$folder2='mrr_chalan_2';
		$field2 = 'upload_chalan_2';
		$file_name2 = $folder2.'-'.$pr_no;
		if($_FILES['upload_chalan_2']['tmp_name']!=''){
			$_POST['upload_chalan_2']=upload_file($folder2,$field2,$file_name2);
		}
		
		$folder3='mrr_chalan_3';
		$field3 = 'upload_chalan_3';
		$file_name3 = $folder3.'-'.$pr_no;

		if($_FILES['upload_chalan_3']['tmp_name']!=''){
			$_POST['upload_chalan_3']=upload_file($folder3,$field3,$file_name3);
		}
		
		
		while($data=mysqli_fetch_object($query)){
		
			$is_complete=$_POST['is_complete_'.$data->id];
				if($is_complete==1){
					  $up_sql='update purchase_master set status="COMPLETED" where po_no="'.$po_no.'" ';
					db_query($up_sql);
				}



			if(($_POST['chalan_'.$data->id]>0)){
				$qty=$_POST['chalan_'.$data->id];
				$rate=$_POST['rate_'.$data->id];
				$item_id =$_POST['item_id_'.$data->id];
				$unit_name =$data->unit_name;
				$amount = ($qty*$rate);
				$total = $total + $amount;
				
				
				
						
			if($po_master->vat_include=='Including'){
				
				
			
				//if($po_master->rebate=='Yes'){
				//	$rebate = $po_master->vat * ($po_master->rebate_percentage/100);
					$vat_rate=(($rate/(100+$data->vat))*$data->vat);
				//}
			//else{
				//	$vat_rate=0;
			//	}
				
				$vat_amt = $vat_rate*$qty;
				
				//$with_vat_rate=$rate-$vat_rate;
				
			if($po_master->rebateable == 'Yes'){
			$with_vat_rate=$rate-$vat_rate;
			}
			else{
			$with_vat_rate=$rate;
			}
				
				$with_vat_amt =number_format(($with_vat_rate * $qty),2,'.','');
			}else{
		
			$vat_rate=(($rate*$data->vat)/100);
			$vat_amt = $vat_rate*$qty;
			//$with_vat_rate = $rate+$vat_rate;
			
			if($po_master->rebateable == 'Yes'){
			$with_vat_rate=$rate;
			}
			else{
			$with_vat_rate=$rate+$vat_rate;
			}
			
		
			$with_vat_amt =($qty*$rate);
		

		}
		
		
		$tax_rate=(($with_vat_rate*$data->tax)/100);
		$tax_amt = number_format(($tax_rate*$qty),2,'.','');
		
		if($po_master->tax_include =='Including'){
				if($po_master->rebateable == 'Yes'){	
					if($po_master->vat_include=='Excluding'){$grand_amount  = $amount+$vat_amt-$tax_amt;}
					else{ $grand_amount = $amount-$tax_amt; }
				}
				else{
					$tax_rate=((($with_vat_rate-$vat_rate)*$data->tax)/100);
					$tax_amt = number_format(($tax_rate*$qty),2,'.','');
					
					if($po_master->vat_include=='Excluding'){$grand_amount  = $amount+$vat_amt-$tax_amt;}
					else{ $grand_amount = $amount-$tax_amt; }
				}
		
			//$grand_amount = $with_vat_amt-$tax_amt; 
		}else{
			if($po_master->vat_include=='Including'){ $tax_rate=(($with_vat_rate*$data->tax)/100); }
			else{$tax_rate=(($rate*$data->tax)/100);}

				if($po_master->rebateable == 'Yes'){
					
					$tax_amt = number_format(($tax_rate*$qty),2,'.','');
					$with_vat_rate=$with_vat_rate+$tax_rate;
					$with_vat_amt =$with_vat_rate*$qty;
					$grand_amount=($with_vat_amt)-$tax_amt+$vat_amt;
				}
				else{
					
					$tax_amt = number_format(($tax_rate*$qty),2,'.','');
					$with_vat_rate=$with_vat_rate+$tax_rate;
					$with_vat_amt =$with_vat_rate*$qty;
					$grand_amount=($with_vat_amt)-$tax_amt;
				}
		
		}
		
		if($po_master->deductible=='No'){
			if($po_master->rebateable == 'Yes'){
				$grand_amount=$grand_amount;
			}
			else{
				$grand_amount=$grand_amount;
			}
			//$grand_amount=$grand_amount+$vat_amt;
		
		}
				
		
				
				
				
				if (isset($_POST['is_complete_'.$data->id])) {
					$balCheck = 1;
						$inv='update purchase_invoice set is_complete=1 where id='.$data->id;	
						db_query($inv);	
				} else {
					$balCheck = 0;
				}

	
				
				
				//$final_avg_price = moving_average_price_calculation($item_id,$qty,$amount,$group_for);


if($data->item_type=='Non-Serialized'){
 $q = "INSERT INTO `purchase_receive` (`pr_no`, group_for,  `po_no`, `order_no`, `rec_no`,`rec_date`, `vendor_id`, `item_id`, `warehouse_id`, `rate`, `qty`, `unit_name`, `amount`, `qc_by`, `entry_by`, 

`entry_at`,ch_no, transport_charge, other_charge, remarks, avg_price,status,upload_chalan_1,upload_chalan_2,upload_chalan_3,is_complete,with_vat_rate,with_vat_amt,vat,vat_rate,tax,tax_rate,vat_amt,tax_amt,payable_amt)

 VALUES('".$pr_no."', '".$group_for."', '".$po_no."', '".$data->id."', '".$rec_no."','".$rec_date."',".$vendor_id.", ".$item_id.",".$warehouse_id.", ".$rate.", '".$qty."', '".$unit_name."',  '".$amount."', '".$qc_by."',  '".$_SESSION['user']['id']."', '".$now."', '".$ch_no."', '".$transport_charge."', '".$other_charge."', '".$remarks."', '".$final_avg_price."', 'Received','".$_POST['upload_chalan_1']."','".$_POST['upload_chalan_2']."','".$_POST['upload_chalan_3']."','".$balCheck."','".$with_vat_rate."','".$with_vat_amt."','".$data->vat."','".$vat_rate."','".$data->tax."','".$tax_rate."','".$vat_amt."','".$tax_amt."','".$grand_amount."')";
db_query($q);
$xid = db_insert_id();
journal_item_control($item_id, $warehouse_id, $rec_date, $qty, 0, 'Purchase', $xid, $with_vat_rate, '', $pr_no, '', '',$group_for, $final_avg_price, '' );
}

$tr_from="Purchase";

$tr_no=$pr_no;

$tr_id=$data->id;                                                                                        

$tr_type="Add";
			}
		}

		auto_insert_purchase_secoundary_journal($pr_no);
		unset($_SESSION[$unique]);
		unset($_SESSION['pr_no']);
	header("Location:select_upcoming_po.php?po_no=".$po_no);
}

}else{

	$type=0;
	$msg='Data Re-Submit Warning!';
}


if($_GET['del']>0){
db_query('delete from purchase_receive where id="'.$_GET['del'].'"');
db_query('delete from journal_item where tr_no="'.$_GET['del'].'" and tr_from="Purchase" and sr_no="'.$_SESSION['pr_no'].'"');
}


if($$unique>0){

		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		foreach ($data as $key => $value)
		{ $$key=$value;}
}

if($delivery_within>0){
	$ex = strtotime($po_date) + (($delivery_within)*24*60*60)+(12*60*60);
}
?>


<script>
function cal2(id) {
  var grn_qty = ((document.getElementById('chalan_'+id).value)*1);
  var unrec_qty = ((document.getElementById('unrec_qty_'+id).value)*1);
 
  if(grn_qty>unrec_qty)
  {

		alert('Can not Receive More than Unreceive Qty.');
		document.getElementById('chalan_'+id).value='';
		document.getElementById('chalan_'+id).focus();

  }
}
</script>










<!--Mr create 2 form with table-->

<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}" enctype="multipart/form-data">

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

        



       							 <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>



      

                            </div>

                        </div>

<div class="form-group row m-0 pb-1">

								

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Chalan No </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                        

							<input  name="ch_no" type="text" id="ch_no" />

    

                            </div>

                        </div>

                        <div class="form-group row m-0 pb-1">

						

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Rec Date </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

        



       							 <input name="rec_date" type="text" id="rec_date" value="<?=$po_date?>"  required="required"/>



      

                            </div>

                        </div>
						<div class="form-group row m-0 pb-1">

                            <label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Trans Charge</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

        						<input  name="transport_charge" type="text" id="transport_charge" value=""/>

                            </div>

                        </div>
						
						<div class="form-group row m-0 pb-1">

								 

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Other Charge</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                             
								<input  name="other_charge" type="text" id="other_charge" />



                            </div>

                        </div>
						
						



                    </div>







                </div>
				



                <!--Right form-->

                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">

                    <div class="container n-form2">

                        <div class="form-group row m-0 pb-1">

								 <? $field='po_date';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">PO Date</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                           



        						<input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly"/>



                            </div>

                        </div>
						
						<div class="form-group row m-0 pb-1">

								

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                             

								<input  name="remarks" type="text" id="remarks"/>

                            </div>

                        </div>


						<div class="form-group row m-0 pb-1">

						<? $field='warehouse_id'; $table='warehouse';$get_field='warehouse_id';$show_field='warehouse_name';?>

                            <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

              



       							 <input  name="warehouse_id2" type="text" id="warehouse_id2" value="<?=find_a_field($table,$show_field,$get_field.'='.$$field)?>" required="required" readonly="readonly"/>



								<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" required="required"/>



    



                            </div>

                        </div>
						<div class="form-group row m-0 pb-1">

								

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">QC By </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                        		<input  name="qc_by" type="text" id="qc_by" />

    

                            </div>

                        </div>
						
						<div class="form-group row m-0 pb-1">

                            <label  class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Upload Chalan</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

        						<input type="file" name="upload_chalan_1" id="upload_chalan_1" class="pt-1 pb-1 pl-1" />
								

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

										

												  <td><strong>PR</strong></td>

										

												</tr>

									</thead>

										

													  



										

										<?

										

										$sql='select distinct pr_no,rec_date from purchase_receive where po_no='.$po_no.' order by pr_no desc';

										

										$qqq=db_query($sql);

										

										while($aaa=mysqli_fetch_object($qqq)){

										

										?>

										

												<tr>

										

												  <td><?=$aaa->rec_date?></td>

										

												  <td ><a target="_blank" href="../po_receiving/chalan_view_store.php?v_no=<?=rawurlencode(url_encode($aaa->pr_no));?>"><img src="print.png" width="100%" height="100%" /></a></td>

										

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

        <!--return Table design start-->

        <div class="container-fluid pt-5 p-0 ">

				<? if($$unique>0){



					$sql='select a.id,a.item_id,b.item_name,b.unit_name,a.qty,a.rate,a.is_complete,b.item_type from purchase_invoice a,item_info b where b.item_id=a.item_id and a.po_no='.$$unique;

					

					$res=db_query($sql);

					$s=1;

					?>

            <table class="table1  table-striped table-bordered table-hover table-sm">

                <thead class="thead1">

                <tr class="bgc-info">

                    <th>SL</th>

                    <th>Item Code</th>

                    <th>Item Name</th>

					<th>Unit</th>

                    <th>Ordered</th>

                    <th>Recd</th>

					<th>UnRecd</th>

					<th>RecQty</th>
					
					<th>Is Complete?</th>

                </tr>

                </thead>



                <tbody class="tbody1">

				

				<? while($row=mysqli_fetch_object($res)){?>



				<tr>

	

				<td><?=++$ss;?></td>

	

				<td><?=$row->item_id?>

	

				  <input type="hidden" name="item_id_<?=$row->id?>" id="item_id_<?=$row->id?>" value="<?=$row->item_id?>" /></td>

	

				  <td align="left"><?=$row->item_name?>

	

					<input  type="hidden" name="rate_<?=$row->id?>" id="rate_<?=$row->id?>" value="<?=$row->rate?>" style="width:90px; float:none" /></td>

	

				  <td align="center"><?=$row->unit_name?>

	

					<input type="hidden" name="unit_name_<?=$row->id?>" id="unit_name_<?=$row->id?>" value="<?=$row->unit_name?>" /></td>

	

				  <td align="center"><?=$row->qty?></td>

	

				  <td align="center"><? echo $rec_qty = (find_a_field('purchase_receive','sum(qty)','order_no="'.$row->id.'" and item_id="'.$row->item_id.'"')*(1));?></td>

	

				  <td align="center"><? echo $unrec_qty=($row->qty-$rec_qty); if($unrec_qty>0){ $cow++;}?>

	

					<input type="hidden" name="unrec_qty_<?=$row->id?>" id="unrec_qty_<?=$row->id?>" value="<?=$unrec_qty?>" /></td>

	
                <?php if($row->item_type=='Non-Serialized'){ ?>
				
				  <td align="center" class="text-center"><? if($unrec_qty>0){ ?><? if($row->is_complete==0){ ?>
<input name="chalan_<?=$row->id?>" type="text" id="chalan_<?=$row->id?>"  class="text-center" value="" onkeyup="cal2(<?=$row->id?>)" style="width:50%"  />
<? } } else echo 'Done';?></td>

					<? }else{ ?>
					<td><span id="error_msg<?=$row->id?>"></span><input type="text" name="item_serial<?=$row->id?>" id="item_serial<?=$row->id?>" value="" /><input type="button" value="ADD+" onclick="add_serial(<?=$row->id?>)" />
					<input name="chalan_<?=$row->id?>" type="hidden" id="chalan_<?=$row->id?>"  class="text-center" value="1" onkeyup="cal2(<?=$row->id?>)" style="width:50%"  />
					<input type="hidden" name="pid" id="pid" value="<?=$row->id?>" />
					</td>
					<?php } ?>
					
					<td><input type="checkbox" id="is_complete_<?=$row->id?>" name="is_complete_<?=$row->id?>" value="<?=$row->is_complete?>"  <?php if ($row->is_complete>0){?>readonly checked="checked"<?php } ?>></td>

	

				  </tr>

					

					

				<? } ?>



                </tbody>

            </table>

       <br />
	   
	   <table class="table1  table-striped table-bordered table-hover table-sm" id="response">

                <thead class="thead1">

                <tr class="bgc-info">

                    <th>SL</th>

                    <th>Item Code</th>

                    <th>Item Name</th>

					<th>Unit</th>

                    <th>Qty</th>

                    <th>Serial No</th>

					<th>Action</th>

                </tr>

                </thead>



                <tbody class="tbody1">

				 

				<?
				 $sql = 'select p.id,i.finish_goods_code as item_code,i.item_name,i.unit_name,p.qty,p.serial_no from purchase_receive p, item_info i where p.item_id=i.item_id and p.pr_no="'.$_SESSION['pr_no'].'"';
				 $qry = db_query($sql);
				while($row=mysqli_fetch_object($qry)){?>



				<tr>

	

				<td><?=++$ss;?></td>

	

				<td><?=$row->item_code?></td>

	

				  <td align="left"><?=$row->item_name?></td>

	

				  <td align="center"><?=$row->unit_name?></td>

	

				  <td align="center"><?=$row->qty?></td>

	

				  <td align="center"><?=$row->serial_no?></td>

	

				  <td><a href="?del=<?=$row->id?>"><em class="fa fa-trash" style="color:red"></em></a></td>

	

				  </tr>

					

					

				<? } ?>



                </tbody>

            </table>

        </div>

    







    <!--button design start-->

    

        <div class="container-fluid p-0 ">



            <div class="n-form-btn-class">

                <? 
				
					$check_is_po=find_a_field('purchase_receive','count(id)','is_complete!=1 and pr_no="'.$pr_no.'"');
				$cow = 1;
				if($cow<0){

					

					$vars['status']='COMPLETED';

					

					db_update($table_master, $po_no, $vars, 'po_no');

					

					?>

					<div class="alert alert-success p-2" role="alert">

					  THIS PURCHASE ORDER IS COMPLETE

					</div>

					

					

					

					

					

					<? }else{?>

					

					

					<?php /*?>onclick="window.location = 'select_dealer_chalan.php?del=1&po_no=<?=$po_no?>';" <?php */?>

					<input name="return" type="submit" id="return" onclick="return_function()" class="btn btn-danger" value="Return To Purchase Department" />

					<input  name="po_no" type="hidden" id="po_no" value="<?=$po_no?>"/><input type="hidden" name="return_remarks" id="return_remarks">

					

					<input  name="vendor_id" type="hidden" id="vendor_id" value="<?=$vendor_id;?>"/>

					

					<input name="confirm" type="submit" class="btn btn-primary" value="RECEIVE"  />

					

				

					

					<? }?>

				

					

					

            </div>



        </div>

		

		

	<? } ?>

    </form>



</div>




<br /><br />





<script>$("#codz").validate();$("#cloud").validate();</script>

<script>

function return_function() {

  var notes = prompt("Why Return This PO?","");

  if (notes!=null) {

    document.getElementById("return_remarks").value =notes;

	document.getElementById("codz").submit();

  }

  return false;

}


function add_serial(id){

           var serial = $('#item_serial'+id).val();
            if(serial!=''){
            $.ajax({
                url: 'add_serial_ajax.php',
                type: 'POST',
				dataType: 'json',
                /*data: { name: name },*/
				data: $('#codz').serialize(),
                success: function (data) {
				    $('#item_serial'+id).val("");
					$('#error_msg'+id).html(data['error_msg']);
                    $('#response').html(data['msg']);
					
                },
                error: function () {
				    
                    $('#response').text("An error occurred.");
					
                }
            });
			}else{
			alert('Serial Not Found!');
			}
       
		
}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";


?>