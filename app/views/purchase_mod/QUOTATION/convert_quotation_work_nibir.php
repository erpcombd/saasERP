<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Convert Quotation To PO';
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
do_calander('#fdate');
do_calander('#tdate');

$table = 'quotation_master';
$unique = 'quotation_no';
$status = 'UNCHECKED';

if(isset($_POST['convert'])){
 $quotation_no = $_POST['quotaiton_no'];
 $sql = 'select * from purchase_quotation_master where invoice_no="'.$quotation_no.'"';
 $qry=db_query($sql);
 $pdata = mysqli_fetch_object($qry);
 $insert = 'insert into purchase_master(`group_for`,`po_date`,`purchase_type`,`vendor_id`,`req_no`,`quotation_no`,`quotation_date`,`vat`,`tax`,vat_include,tax_include,deductible,`ait`,`cash_discount`,`rebate`,`rebate_percentage`,`ref_no`,`warehouse_id`,`entry_by`,`entry_at`) value("'.$_SESSION['user']['group'].'","'.date('Y-m-d').'","'.$pdata->po_type.'","'.$pdata->vendor_id.'","'.$pdata->req_no.'","'.$pdata->invoice_no.'","'.$pdata->invoice_date.'","'.$pdata->vat.'","'.$pdata->tax.'","'.$pdata->vat_include.'","'.$pdata->tax_include.'","'.$pdata->deductible.'","'.$pdata->ait.'","'.$pdata->discount.'","'.$pdata->rebate.'","'.$pdata->rebate_percentage.'","'.$pdata->ref.'","'.$pdata->warehouse_id.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
 $master_insert = db_query($insert);
 $po_no = db_insert_id();
 
  $sql2 = 'select * from purchase_quotation_details where invoice_no="'.$quotation_no.'" and app_status=1';
 $qry=db_query($sql2);
 while($data=mysqli_fetch_object($qry)){
 
 
 	if($pdata->rebate == 'yes'){
		
		$rebate = $pdata->vat * ($pdata->rebate_percentage/100);
		$final_vat = ($pdata->vat-$rebate);
		}
		else{
		$final_vat = $pdata->vat;
		}
 
 	if($pdata->vat_include=='Including'){
		

			
			if($pdata->rebate == 'yes'){
			
				$vat_rate=(($data->unit_price/(100+ $rebate))* $rebate);
			
			}else{
				$vat_rate=0;
			
			}
			
			$vat_amt = $vat_rate*$data->req_qty;
			
			$with_vat_rate=$data->unit_price-$vat_rate;
			
			$with_vat_amt =number_format(($with_vat_rate * $data->req_qty),2,'.','');
		}else{
		
			$vat_rate=(($data->unit_price*$pdata->vat)/100);
			$vat_amt = $vat_rate*$data->req_qty;
			$with_vat_rate =$data->unit_price;
		
			$with_vat_amt =number_format(($with_vat_rate * $data->req_qty),2,'.','');
		
		
		}
		
		$tax_rate = (($with_vat_rate*$pdata->tax)/100);
		$tax_amt=number_format(($tax_rate*$data->req_qty),2,'.','');
		
		if($pdata->tax_include=='Including'){
		
			$grand_amount  = $with_vat_amt-$tax_amt;
		}else{
		
			$with_vat_rate=$with_vat_rate+$tax_rate;
			$with_vat_amt =$with_vat_rate* $data->req_qty;
		
			$grand_amount = ($with_vat_amt-$tax_amt);
		
		}
		
		if($pdata->deductible=='No'){
			
			$grand_amount=$grand_amount+$vat_amt;
		
		}
		
		$po_qty=$data->req_qty;
		$tolerance_qty=$po_qty+($po_qty*0.1);
 
   echo $details_insert = 'insert into purchase_invoice(`po_no`,`po_date`,`req_no`,`quotation_no`,`quotation_id`,`vendor_id`,`item_id`,`warehouse_id`,`rate`,`qty`,tolerance_qty,`amount`,vat,final_vat, tax, with_vat_rate,with_vat_amt, vat_amt, tax_amt,grand_amount,`entry_by`,`entry_at`) value("'.$po_no.'","'.date('Y-m-d').'","'.$data->req_no.'","'.$data->invoice_no.'","'.$data->id.'",              "'.$data->vendor_id.'","'.$data->item_id.'","'.$data->warehouse_id.'","'.$data->unit_price.'","'.$data->req_qty.'","'.$tolerance_qty.'","'.($data->unit_price*$data->req_qty).'","'.$pdata->vat.'","'.$final_vat.'","'.$pdata->tax.'","'.$with_vat_rate.'","'.$with_vat_amt.'","'.$vat_amt.'","'.$tax_amt.'","'.$grand_amount.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
  db_query($details_insert);
  
 }
 
$update = db_query('update purchase_quotation_master set is_po=1 where invoice_no="'.$quotation_no.'"');
$_SESSION['po_no'] = $po_no;

if($pdata->req_no>0){
header('location:../po/po_create.php');
}
 
}
$target_url = '../quotation/mr_checking.php';


unset($_SESSION['quotation_no']);

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?<?=$unique?>='+theUrl,false);
}
</script>



<div class="form-container_large">
    
    <form  action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date :</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<?=$_POST['fdate']?>" autocomplete="off" />
                        </div>
                  </div>

                </div>
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> To Date:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=$_POST['tdate']?>" autocomplete="off" />
                        </div>
                  </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <select name="warehouse_id" id="warehouse_id">
							  <option selected="selected"></option>
							  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],' 1 and use_type="WH"');?>
							</select>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
                    
                </div>

            </div>
        </div>






            
        <div class="container-fluid pt-5 p-0 ">

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
						<th>SI NO</th>
						<th>Req No</th>
                        <th>Quotation No</th>
                        <th>Quotation Date</th>
                        <th>Vendor Name</th>
						            <th>Attached</th>


                        <th>Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
						<? 

								$con .= ' and a.status="CHECKED"';
							
							if($_POST['fdate']!=''&&$_POST['tdate']!=''){
							$con .= 'and a.invoice_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
							}
							if($_POST['warehouse_id']!=''){
							$con .= 'and a.warehouse_id = "'.$_POST['warehouse_id'].'"';
							}
							 $res='select  	a.invoice_no,a.invoice_no as quotation_no, DATE_FORMAT(a.invoice_date, "%d-%m-%Y") as quotation_date, a.req_no,  v.vendor_name as vendor_name,  c.fname as entry_by, a.entry_at,a.status, a.invoice_no,a.file_upload as doc_file  from purchase_quotation_master a,user_activity_management c, vendor v where a.vendor_id=v.vendor_id  and a.entry_by=c.user_id and a.is_po=0 '.$con.'  order by a.invoice_no desc';
								
								$query=db_query($res);
								
								While($row=mysqli_fetch_object($query)){
								?>
                        <tr>
							<td><?=$row->quotation_no?></td>
							<td><?=$row->req_no?></td>
                            <td><?=$row->quotation_no?></td>
                            <td><?=$row->quotation_date?></td>
                            <td style="text-align:left"><?=$row->vendor_name?></td>

							<td><a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$row->doc_file?>&folder=maintain_quotation&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">View Attachment</a></td>


                            <td><input type="hidden" name="quotaiton_no" value="<?=$row->quotation_no?>" /><input type="submit" name="convert" id="convert" value="Convert to PO" class="btn1 btn1-bg-update" /></td>
                            

                        </tr>
							<? 
							}
							?>
                    </tbody>
                </table>





        </div>
    </form>
</div>




<br /><br />

<?php

require_once SERVER_CORE."routing/layout.bottom.php";
?>