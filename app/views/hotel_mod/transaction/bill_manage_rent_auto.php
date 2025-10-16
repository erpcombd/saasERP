<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Bill Information';
do_calander('#generate_date');
$table='hms_bill_payment';
$unique='id';
$time=time();
$now=($time-60*60*12);
$today=date("Y-m-d",$now);
$this_time=date("Y-m-d H:i:s",$time);

//echo time();
//echo $today;

$r_id=$_REQUEST['r_id'];

if($_REQUEST['check_out']==1)
{

		$sql="select * from hms_hotel_room_status where room_status='9' and date='$today'";
		$query=db_query($sql);
		while($data=mysqli_fetch_object($query)){

	
	$bill_date=$today;
	$service_room_id=$data->room_id;
	$reserve_id=$data->reserve_id;
	$s='select a.* from hms_room_type a,hms_hotel_room b where a.id=b.room_type_id and b.id='.$data->room_id;
	$totala=find_all_field_sql($s);
	$total_amt=$totala->rate-$totala->discount;
	
	$service_group=find_all_field('hms_service_group','service_group','id=2');

	$service_charge=$service_group->service_charge;
	$vat=$service_group->vat;
	
	$service_charge_amt=($service_group->service_charge*$total_amt)/100;
	$vat_amt=($service_group->vat*($total_amt+$service_charge_amt))/100;
	$bill_amt=$total_amt+$service_charge_amt+$vat_amt;

	
	$sql="INSERT INTO `hms_bill_payment` (
	`reserve_id` ,
	`room_id` ,
	`service_group_id` ,
	total_amt,
	service_charge,
	vat_amt,
	`bill_amt` ,
	`bill_date` ,
	`paid_amt` ,
	`paid_date`
	) VALUES ('$reserve_id', '$service_room_id', '2','$total_amt',
	'$service_charge_amt',
	'$vat_amt',  '$bill_amt', '$bill_date','', '')";
	db_query($sql);
	
			$service_id 	= $service_room_id;		
			$unit_price		= $totala->rate;	
			$qty			= 1;
			$dis_amt 		= $totala->discount;		
			$bill_amt		= $totala->rate-$totala->discount;
	$bill_no	=mysqli_insert_id();
		$sql="INSERT INTO `hms_bill_payment_details` (
		`bill_no`,
		`reserve_id` ,
		`room_id` ,
		`service_id` ,
		`bill_amt` ,
		`bill_date` ,
		unit_price,
		discount_amt,
		qty
		) VALUES ('$bill_no', '$reserve_id', '$room_id', '$service_id', '$bill_amt', '$bill_date', '$unit_price','$dis_amt', '$qty')";
		db_query($sql);
	

} $sql="INSERT INTO `hms_rent_bill_generate` (
`bill_date` ,
`generate_at` ,
`generate_at_s` ,
`user_id`
)
VALUES ('$today', '$this_time', '$time', '$user_id')";
db_query($sql);
}

?>

<form action="" method="post" name="form2" id="form2">
    <div class="container-fluid">
        <div class="d-flex justify-content-center">
            <div class="col-sm-8">
                <div class="n-form">
                    <h4 align="center" class="n-form-titel1">Bill Generate</h4>
                    <div class="form-group row m-0 pl-3 pr-3 p-1">
                        <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label">Generate Date:</label>
                        <div class="col-sm-9 p-0">
                            <input name="generate_date" type="text" id="generate_date" value="<?=date('Y-m-d',$now)?>" />
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</form>

<br />


<?
$sql="SELECT count(1) FROM `hms_rent_bill_generate` WHERE 
			bill_date='".$today."'";
$due = find_a_field_sql($sql);
if($due==0){
?>


<table class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
					<tr class="bgc-info">
                        <td><div align="center">
		<form id="form1" name="form1" method="post" action="?check_out=1">
          <input type="submit" name="checkout" value="GENERATE AUTO BILL"/>		  
		</form>
        </div></td>
		 </tr>
					  	
		<tbody class="tbody1">               
     
                      	
	  </tbody>			
			</table>
			
			
 <? }else{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <div align="center">
<? echo 'Today rent bill already generated';?>
        </div>
      </td>
    </tr>
</table>
<? 
	

	}
	?>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>