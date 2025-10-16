<?php
session_start();
ob_start();
require "../../support/inc.all.php";

// ::::: Edit This Section ::::: 

$title='Accounts Payable';			// Page Name and Page Title
$page="payable.php";		// PHP File Name

$table='hms_bill_payment';		// Database Table Name Mainly related to this page
$unique='id';			

$crud      =new crud($table);

$$unique = $_GET[$unique];

if(isset($_POST[$unique]))
{
	$identification = $$unique;
	$date = date('Y-m-d');
	$datetime = date('Y-m-d h:m:s');
	$reserve_id = $_POST['r_id'];
	$paying_amt = $_POST['paying_amt'];

$sql = 'UPDATE `hms_bill_payment` SET `paid_amt` = (paid_amt-'.$paying_amt.') WHERE `id` ='.$identification;
mysql_query($sql);
$sql = "INSERT INTO `hms_bill_payment` (`reserve_id`, `service_group_id`, `optional_service_id`,  `paid_amt`,`bill_date`, `paid_date`, `service_charge`, `paid_status`, `entry_by`, `entry_at`) VALUES ( '$reserve_id', 8, 22, '$paying_amt', '$date', '$date', '0.00', 0, 0, '$datetime')";
mysql_query($sql);


}

if(isset($$unique))
{
$sql='select a.id,a.reserve_id as r_id,b.client_name as name, b.check_out_date as check_out,b.contact_no,(select sum(bill_amt) from hms_bill_payment where reserve_id=a.reserve_id) as total_bill,a.paid_amt as payable from hms_bill_payment a, hms_reservation b where a.reserve_id=b.id and a.optional_service_id=21 and a.id='.$$unique;
$data=mysql_fetch_object(mysql_query($sql));
while (list($key, $value)=each($data))
{ $$key=$value;}
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
							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
                                    <td>
									<div class="tabledesign">
                                        <? 	$res='select a.id,a.reserve_id as r_id,b.client_name as name, b.check_out_date as check_out,b.contact_no,(select sum(bill_amt) from hms_bill_payment where reserve_id=a.reserve_id) as total_bill,a.paid_amt as payable from hms_bill_payment a, hms_reservation b where a.reserve_id=b.id and a.optional_service_id=21 order by id';
											echo $crud->link_report($res,$link);?>
                                    </div><?=paging(50);?></td>
						      </tr>
								</table>

							</div></td>
    <td valign="top"><? if(isset($$unique)){?>
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>                                   
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>
									<fieldset>
                                        <legend><?=$title?></legend>
                                        
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label>Identification No :</label>
                                          <input name="id" type="text" id="id" value="<?=$id?>">
                                        </div>
									<div>
                                          <label>Reserve ID :</label>
                                          <input name="r_id" type="text" id="r_id" value="<?=$r_id?>" />
									</div>
									<div>
                                          <label>Client Name :</label>
                                          <input name="name" type="text" id="name" value="<?=$name?>" />
									</div>
                                    
									<div>
                                          <label>Contact No :</label>
                                      <input name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" />
									</div>
									<div>
                                  <label>Check Out :</label>
                                          <input name="check_out_date" type="text" id="check_out_date" value="<?=$check_out?>" />
									</div>
									<div>
                                          <label>Total Billed Amount :</label>
                                          <input name="total_bill" type="text" id="total_bill" value="<?=$total_bill?>" />
									</div>
                                    
									<div>
                                          <label>Payable Amount :</label>
                                      <input name="payable" type="text" id="payable" value="<?=$payable?>" />
									</div>
                                    
									<div>
                                          <label>Paying Amount : </label>
                                      <input name="paying_amt" type="text" id="paying_amt" value="<?=$paying_amt?>" />
									</div>
									</fieldset>									</td>
								  </tr>
								  
								</table></td>
							    </tr>
                                
                             
                            <tr>
                              <td>
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
									  <div class="button"></div>										</td>
										<td>
										<div class="button">
										<? if(isset($_GET[$unique])){?>
										<input name="update" type="submit" id="update" value="Confirm Paid" class="btn" />
										<? }?>	
										</div>									</td>
                                      <td>
									  <div class="button"></div>									  </td>
                                      <td>
									  <div class="button"></div>									  </td>
                                    </tr>
                                </table></td>
                            </tr>
        </table>
    </form>
	<? }?></td>
  </tr>
</table>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>