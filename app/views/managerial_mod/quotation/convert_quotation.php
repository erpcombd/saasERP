<?php
session_start();
ob_start();

 

 

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
 $sql = 'select * from quotation_master where quotation_no="'.$quotation_no.'"';
 $qry=db_query($sql);
 $pdata = mysqli_fetch_object($qry);
 $insert = 'insert into purchase_master(`group_for`,`po_date`,`vendor_id`,`req_no`,`quotation_no`,`quotation_date`,`warehouse_id`,`entry_by`,`entry_at`) value("'.$_SESSION['user']['group'].'","'.date('Y-m-d').'","'.$pdata->vendor_id.'","'.$pdata->req_no.'","'.$pdata->quotation_no.'","'.$pdata->quotation_date.'","'.$pdata->warehouse_id.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
 $master_insert = db_query($insert);
 $po_no = db_insert_id();
 
 echo $sql2 = 'select * from quotation_detail where quotation_no="'.$quotation_no.'"';
 $qry=db_query($sql2);
 while($data=mysqli_fetch_object($qry)){
  echo $details_insert = 'insert into purchase_invoice(`po_no`,`po_date`,`req_no`,`quotation_no`,`quotation_id`,`vendor_id`,`item_id`,`warehouse_id`,`rate`,`qty`,`amount`,`entry_by`,`entry_at`) value("'.$po_no.'","'.date('Y-m-d').'","'.$data->req_no.'","'.$quotation_no.'","'.$data->id.'","'.$data->vendor_id.'","'.$data->item_id.'","'.$data->warehouse_id.'","'.$data->quotation_price.'","'.$data->qty.'","'.($data->quotation_price*$data->qty).'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
  db_query($details_insert);
  
 }
 
$update = db_query('update quotation_master set is_po=1 where quotation_no="'.$quotation_no.'"');
$_SESSION['po_no'] = $po_no;

if($pdata->req_no>0){
header('location:../po/po_create.php');
}
 
}
$target_url = '../quotation/mr_checking.php';

@session_destroy($_SESSION['quotation_no']);

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
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<?=$_POST['fdate']?>" autocomplete="off" />
                        </div>
                    </div>

                </div>
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>
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
							
							if($_POST['fdate']!=''&&$_POST['tdate']!='')
							$con .= 'and a.quotation_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
							
							if($_POST['warehouse_id']!='')
							$con .= 'and a.warehouse_id = "'.$_POST['warehouse_id'].'"';
							
							   $res='select  	a.quotation_no,a.quotation_no as quotation_no, DATE_FORMAT(a.quotation_date, "%d-%m-%Y") as quotation_date, a.req_no,  v.vendor_name as vendor_name,  c.fname as entry_by, a.entry_at,a.status, a.quotation  from quotation_master a,user_activity_management c, vendor v where a.vendor_id=v.vendor_id  and a.entry_by=c.user_id and a.is_po=0 '.$con.'  order by a.quotation_no desc';
								
								$query=db_query($res);
								
								While($row=mysqli_fetch_object($query)){
								?>
                        <tr>
							<td><?=$row->quotation_no?></td>
							<td><?=$row->req_no?></td>
                            <td><?=$row->quotation_no?></td>
                            <td><?=$row->quotation_date?></td>
                            <td style="text-align:left"><?=$row->vendor_name?></td>
							<!--<td><a href="../../../../media/quotation/<?=$row->quotation?>" target="_blank">View Attachment</a></td>-->
							<td><a href="../../../assets/support/upload_view.php?name=<?=$row->quotation?>&folder=quotation&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">View Attachment</a></td>


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
<!--<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Date:</strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="fdate" id="fdate" style="width:107px;" value="<?=$_POST['fdate']?>" />
    </strong></td>
    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
    <td width="1" bgcolor="#FF9966"><strong>
      <input type="text" name="tdate" id="tdate" style="width:107px;" value="<?=$_POST['tdate']?>" />
    </strong></td>
    <td rowspan="2" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Warehouse Name: </strong></td>
    <td colspan="3" bgcolor="#FF9966"><select name="warehouse_id" id="warehouse_id">
      <option selected="selected"></option>
      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],' 1 and use_type="WH"');?>
    </select></td>
    </tr>
</table>


</div>-->

<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabledesign">
<tr>
<td><div class="tabledesign2">
<? 

$con .= ' and a.status="CHECKED"';

if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.quotation_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

if($_POST['warehouse_id']!='')
$con .= 'and b.warehouse_id = "'.$_POST['warehouse_id'].'"';

$res='select  	a.quotation_no,a.quotation_no as quotation_no, DATE_FORMAT(a.quotation_date, "%d-%m-%Y") as quotation_date,  v.vendor_name as vendor_name,  c.fname as entry_by, a.entry_at,a.status from quotation_master a,user_activity_management c, vendor v where a.vendor_id=v.vendor_id  and a.entry_by=c.user_id and a.is_po=0 '.$con.'  order by a.quotation_no';
//echo link_report($res,'mr_print_view.php');
$qry = db_query($res);
?>
</div></td>
</tr>

<tr>
  <th>Sl</th>
  <th>Quotation No</th>
  <th>Quotation Date</th>
  <th>Vendor Name</th>
  <th>Action</th>
</tr>
<?
while($data=mysqli_fetch_object($qry)){
?>
<tr>
  <td><?=++$i?></td>
  <td><?=$data->quotation_no?></td>
  <td><?=$data->quotation_date?></td>
  <td><?=$data->vendor_name?></td>
  <td><input type="hidden" name="quotaiton_no" value="<?=$data->quotation_no?>" /><input type="submit" name="convert" id="convert" value="Convert" class="btn1 btn1-bg-update" /></td>
</tr>
<? } ?>
</table>
</form><?php */?>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>