<?php
//ini_set('display_errors', '1');ini_set('display_startup_errors', '1');error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

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
dba_firstkey_query($sql);
$sql = "INSERT INTO `hms_bill_payment` (`reserve_id`, `service_group_id`, `optional_service_id`,  `paid_amt`,`bill_date`, `paid_date`, `service_charge`, `paid_status`, `entry_by`, `entry_at`) VALUES ( '$reserve_id', 8, 22, '$paying_amt', '$date', '$date', '0.00', 0, 0, '$datetime')";
db_query($sql);


}

if(isset($$unique))
{
$sql='select a.id,a.reserve_id as r_id,b.client_name as name, b.check_out_date as check_out,b.contact_no,(select sum(bill_amt) from hms_bill_payment where reserve_id=a.reserve_id) as total_bill,a.paid_amt as payable from hms_bill_payment a, hms_reservation b where a.reserve_id=b.id and a.optional_service_id=21 and a.id='.$$unique;
$data=mysqli_fetch_object(db_query($sql));
foreach($data as $key => $value)
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


<!--start here-->

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-7">
            <div class="container n-form1">
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

					
					
				<? 	$res='select a.id,a.reserve_id as r_id,b.client_name as name, b.check_out_date as check_out,b.contact_no,(select sum(bill_amt) from hms_bill_payment where reserve_id=a.reserve_id) as total_bill,a.paid_amt as payable from hms_bill_payment a, hms_reservation b where a.reserve_id=b.id and a.optional_service_id=21 order by id';
											echo $crud->link_report($res,$link);?>
                    

                </form>
            </div>           

        </div>


        <div class="col-sm-5">
            
			<? if(isset($$unique)){?>
            <form class="n-form" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" >
                <h4 align="center" class="n-form-titel1">Accounts Payable</h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Identification No :</label>
                    <div class="col-sm-9 p-0">
<input name="id" type="text" id="id" value="<?=$id?>">										                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Reserve ID :</label>
                    <div class="col-sm-9 p-0">
<input name="r_id" type="text" id="r_id" value="<?=$r_id?>" />                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Client Name :</label>
                    <div class="col-sm-9 p-0">
<input name="name" type="text" id="name" value="<?=$name?>" />                   
                  </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Contact No :</label>
                    <div class="col-sm-9 p-0">
<input name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" />                   
                  </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Check Out :</label>
                    <div class="col-sm-9 p-0">
<input name="check_out_date" type="text" id="check_out_date" value="<?=$check_out?>" />                   
                  </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Total Billed Amount :</label>
                    <div class="col-sm-9 p-0">
<input name="total_bill" type="text" id="total_bill" value="<?=$total_bill?>" />                   
                  </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Payable Amount :</label>
                    <div class="col-sm-9 p-0">
<input name="payable" type="text" id="payable" value="<?=$payable?>" />                   
                  </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Paying Amount :</label>
                    <div class="col-sm-9 p-0">
<input name="paying_amt" type="text" id="paying_amt" value="<?=$paying_amt?>" />                   
                  </div>
                </div>

                				
				        
				
				  

                <div class="n-form-btn-class">
                      
					
				<? if(isset($_GET[$unique])){?>
										<input name="update" type="submit" id="update" value="Confirm Paid" class="btn1 btn1-bg-update" />
										<? }?>

	

                </div>


            </form>
			<? }?>

        </div>

    </div>






<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>