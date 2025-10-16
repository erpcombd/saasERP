<?php
require_once "../../../assets/template/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Product Search';			// Page Name and Page Title
$page="vendor_info.php";		// PHP File Name
$unique='service_no';
$table='vendor';		// Database Table Name Mainly related to this page
//$unique='vendor_id';			// Primary Key of this Database table
$shown='vendor_name';				// For a New or Edit Data a must have data field

if($_GET['mhafuz']>0) { $_SESSION[$unique] = '' ;  }

if(isset($_POST['new_service'])){
header('location:service_create.php?serial_no='.$_POST['serial_no']);
}

$crud      =new crud($table);

$$unique = $_GET[$unique];


if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
if($_POST['gf']==999) 
{unset($_SESSION['gf']);
unset($_POST['gf']);
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
							<table width="100%" class="table table-bordered" cellspacing="0" cellpadding="0">
                                <tr>
								  <td><?=$_SESSION['smsgs']; unset($_SESSION['smsgs']);?></td>
								</tr>
								  <tr>
									<td><form id="form2" name="form2" method="post" action="">
									  <table width="100%"  cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td>Search With : </td>
                                          <td><input type="text" name="serial_no" id="serial_no" class="form-control" placeholder=" Serial No" value="<?=$_POST['serial_no']?>" /></td>
										   <td><input type="text" name="invoice_no" id="invoice_no" class="form-control" placeholder=" Invoice No" value="<?=$_POST['invoice_no']?>" readonly/></td>
										   <td><input type="text" name="dealer_id" id="dealer_id" list="customer_list" class="form-control" placeholder=" Customer" readonly />
										    <datalist id="customer_list">
											
											  <? foreign_relation('dealer_info','concat(dealer_code,"#",dealer_name_e)','""',$_POST['dealer_id']);?>
											</datalist>
										   </td>
                                          <td><label>
                                            <input class="form-control" type="submit" name="show" value="GO" style="width:46px; height:41px; background:aqua;" />
                                            </label>
                                          </td>
                                        </tr>
                                      </table>
                                                                      
									</td>
								  </tr>
								  <tr>
                                    <td>
									<?
									  if(isset($_POST['show'])){
									   $sql = 'select sum(c.total_amt) as total_amt,c.serial_no,c.chalan_no,c.chalan_date,d.dealer_name_e,i.item_name,m.marketing_person from sale_do_chalan c,dealer_info d,item_info i,sale_do_master m where c.do_no=m.do_no and d.dealer_code=c.dealer_code and i.item_id=c.item_id and c.serial_no="'.$_POST['serial_no'].'"';
									   $qry = mysql_query($sql);
									   $data=mysql_fetch_object($qry);
									   
									   if($data->chalan_no>0){
									    $total_row = 0;
									?>
									
									<div class="tabledesign">
                                      <table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
									    
										   <tr>
										     <th>Invoice No</td>
											 <th><?=$data->chalan_no?></td>
										   </tr>
										   <tr>
										     <td>Customer Name</td>
											 <td><?=$data->dealer_name_e?></td>
										   </tr>
										   <tr>
										     <td>Product Name</td>
											 <td><?=$data->item_name?></td>
										   </tr>
										   <tr>
										     <td>Invoice Date</td>
											 <td><?=$data->chalan_date?></td>
										   </tr>
										   <tr>
										     <td>Sales Person</td>
											 <td><?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$data->marketing_person.'"');?></td>
										   </tr>
										   
										    <tr>
										     <td>Sales Amount</td>
											 <td><?=$data->total_amt?></td>
										   </tr>
										   
										   <tr>
										     <td colspan="2" align="center"><input type="submit" name="new_service" id="new_service" value="Going To Service" style="background:aqua;"/></th>
											 
										   </tr>
										
									  </table>
                                    </div><? }else{ ?>
									  <div align="center" style="color:red; font-size:14px; font-weight:bold;">Data Not Found In System!</div>
									  <div align="center"><input type="submit" name="new_service" id="new_service" value="Going To Service With Unknown Serial" style="background:aqua; width:30%;"/></div>
									<? } }?></td>
									</form>
						      </tr>
								</table>

							</div></td>
    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

      
    </form></td>
  </tr>
</table>
</div>
<?
require_once "../../../assets/template/layout.bottom.php";
?>