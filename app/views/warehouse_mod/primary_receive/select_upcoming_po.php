<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Upcomming PO For Primary Receive';

do_calander('#fdate');
do_calander('#tdate');
do_datatable('grp_id');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'MANUAL';
$target_url = '../po/po_create.php';

if($_POST[$unique]>0)
{
$_SESSION[$unique] = $_POST[$unique];
header('location:'.$target_url);
}

?>






<div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date Interval :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>"/>
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">-to-</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate"  value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />

                        </div>
                    </div>
                </div>
				

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
					<input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
					
                </div>

            </div>
        </div>
</form>





          
        <div class="container-fluid pt-5 p-0 ">

                <table id="grp_id" class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SL No</th>
                        <th>PO No</th>
                        <th>PO Date</th>

                        <th>PR NO</th>
                        <th>PR Date</th>
                        <th>Warehouse Name</th>

                        <th>Supplier Name</th>
                        <th>PO Qty</th>
						<th>PO Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
					
                    <tbody class="tbody1">
					<? 

if(isset($_POST['submitit'])){

if($_POST['item_name']!=''){
$get_item_name=explode('#',$_POST['item_name']);
$item_id=$get_item_name[2];
$item_idcon='and o.item_id="'.$item_id.'"';
}

if($_POST['fdate']!=''&&$_POST['tdate']!=''){

$con_date= 'and p.po_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
}
else{
$con_date = 'and p.po_date between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"';
}

if($_POST['po_no']!=''&&$_POST['po_no']!='')
$con .= 'and p.po_no="'.$_POST['po_no'].'"';

}



if($_POST['item_name']!=''){

 $res='select p.po_no,p.po_date,p.req_no,p.vendor_id,o.po_no,o.item_id,p.status,p.warehouse_id from purchase_master p,purchase_invoice o where p.po_no=o.po_no and  p.status in ("CHECKED","QC_CHECKED","QA_RECEIVE")  '.$con.$con_date.$item_idcon.' order by p.po_no desc ';
}
else{
$res='select p.po_no,p.po_date,p.req_no,p.vendor_id,p.status,p.warehouse_id from purchase_master p  where p.status in ("CHECKED","QC_CHECKED","QA_RECEIVE") '.$con.$con_date.' order by p.po_no desc ';
}

$query = db_query($res);
while($data = mysqli_fetch_object($query)){
?>

                        <tr>
                            <td><?=++$i?></td>
                            <td><?=$data->po_no?></td>
                            <td><?=$data->po_date;?></td>

                            <td><?=$data->req_no?></td>
                            <td><?=find_a_field('requisition_master','req_date','req_no='.$data->req_no);?></td>
                            <td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$data->warehouse_id);?></td>

                            <td><?=find_a_field('vendor','vendor_name','vendor_id='.$data->vendor_id);?></td>
                            <td><?=find_a_field('purchase_invoice','sum(qty)','po_no="'.$data->po_no.'"')?></td>
							<td><?=find_a_field('purchase_invoice','sum(amount)','po_no="'.$data->po_no.'"')?></td>
                            <td><a href="po_receive.php?pc_no=<?=$data->po_no?>&po_no=<?=$data->po_no?>" target="_blank"><button class="btn btn-success btn-sm">View</button></a></td>
							

                        </tr>
						<?php } ?>

                    </tbody>
                </table>





        </div>
    
</div>









  


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>