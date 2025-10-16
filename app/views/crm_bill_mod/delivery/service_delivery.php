<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
function next_ledger_ids($group_id)

{

$max=($group_id*100000)+100000;

$min=($group_id*100000)-1;

 $s='select max(ledger_id) from accounts_ledger where ledger_id>'.$min.' and ledger_id<'.$max;

$sql=db_query($s);

if(mysqli_num_rows($sql)>0)

$data=mysqli_fetch_row($sql);

else

$acc_no=$min;

if(!isset($acc_no)&&(is_null($data[0]))) 

$acc_no=$cls;

else

$acc_no=$data[0]+1000000000;

return $acc_no;

}
$title='Product Search';			// Page Name and Page Title
$page="vendor_info.php";		// PHP File Name

$table='vendor';		// Database Table Name Mainly related to this page
$unique='vendor_id';			// Primary Key of this Database table
$shown='vendor_name';				// For a New or Edit Data a must have data field



if(isset($_POST['new_service'])){
header('location:service_create.php?serial_no='.$_POST['serial_no']);
}

$crud      =new crud($table);

$$unique = $_GET[$unique];


if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
if($_POST['gf']==999) 
{unset($_SESSION['gf']);
unset($_POST['gf']);
}


if(isset($_POST['confirm_delivery'])){
 
 if($_REQUEST['service_no']>0){
   
   $master_update = 'update service_master set status="DELIVERED" where service_no="'.$_REQUEST['service_no'].'"';
   db_query($master_update);
   
   $detail_update = 'update service_details set status="DELIVERED" where service_no="'.$_REQUEST['service_no'].'"';
   db_query($detail_update);
   
   $chalan_dist = 1;
   
   $service_data = find_all_field('service_details','','service_no="'.$_REQUEST['service_no'].'"');
   $client_id = find_a_field('service_master','client_id','service_no="'.$_REQUEST['service_no'].'"');
   
   $journal_item_sql = 'insert into rma_journal_item (`ji_date`,`item_id`,`warehouse_id`,`serial_no`,`item_ex`,`tr_from`,`tr_no`,`sr_no`,`entry_by`,`entry_at`,`vendor_id`) value("'.date('Y-m-d').'","'.$service_data->item_id.'","'.$_SESSION['user']['depot'].'","'.$service_data->serial_no.'","'.$chalan_dist.'","Service","'.$data->id.'","'.$_REQUEST['service_no'].'","'.$_SESSION['user']['id'].'","'.date('Y-m-d h:i:s').'","'.$client_id.'")';
db_query($journal_item_sql);
   
   $_SESSION['msgs'] = '<a href="service_delivery_print_view.php?service_no='.$_REQUEST['service_no'].'" style="color:green;font-size:15px;font-weight:bold" target="_blank">Success! New Service Delivery Generated.</a>';
   header('location:done_service_list.php');
   
 }

}



?>

<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}

function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>
<div class="form-container_large">
<form action="" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
					
									<?
									  
									   $sql = 'select m.*,d.*,c.dealer_name_e,i.item_description from service_master m, service_details d, item_info i, dealer_info c where m.service_no=d.service_no and m.client_id=c.dealer_code and d.item_id=i.item_id and m.service_no="'.$_REQUEST['service_no'].'"';
									   $qry = db_query($sql);
									   $data=mysqli_fetch_object($qry);
									   
									   if($data->service_no>0){
									    
									?>
									
									<div class="tabledesign">
                                      <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
									    
										   <tr>
										     <th>Invoice No</th>
											 <th><?=$data->invoice_no?></th>
										   </tr>
										   <tr>
										     <td>Customer Name</td>
											 <td><?=$data->dealer_name_e?></td>
										   </tr>
										   <tr>
										     <td>Product Name</td>
											 <td><?=$data->item_description?></td>
										   </tr>
										   <tr>
										     <td>Invoice Date</td>
											 <td><?=$data->sales_date?></td>
										   </tr>
										   <tr>
										     <td>Serial No</td>
											 <td><?=$data->serial_no?></td>
										   </tr>
										   
										    <tr>
										     <td>Product Status</td>
											 <td><?=$data->status?></td>
										   </tr>
										   
										   <tr>
										     <td colspan="2" align="center"><input type="submit" name="confirm_delivery" id="confirm_delivery" value="CONFIRM DELIVERY" style="background:aqua;"/></td>
											 
										   </tr>
										
									  </table>
                                    </div></div><? }else{ ?>
									  <div align="center" style="color:red; font-size:14px; font-weight:bold;">Data Not Found!</div>
									<? } ?></td>
						      </tr>
								</table></form>

							</div></td>
    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

      
    </form></td>
  </tr>
</table>
</div>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>