<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Asset Sales';

do_calander('#do_date');

do_calander('#date');

do_calander('#customer_po_date');

$now = date('Y-m-d H:s:i');
do_calander('#est_date');

$s = 0;
if(isset($_POST['submit'])){
foreach ($_POST['check'] as $row){
if($s>0){
 $ids .=', ';
}
 $ids .=$row;
 $s++;
}
$_SESSION['ids'] = $ids;
}

if(isset($_POST['confirm'])){
$crud= new crud('asset_sales_info');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['entry_at'] = date('Y-m-d H:i:s');
 $sql='select r.*,i.item_name,s.sub_group_name 

from asset_disposal_info r,item_info i, item_sub_group s 

where r.item_id=i.item_id and s.sub_group_id=i.sub_group_id and r.status="Checked" and r.id in ('.$_SESSION['ids'].') group by r.asset_id';

     $query=db_query($sql);

     $i=1;

     while($data=mysqli_fetch_object($query)){

    $_POST['asset_id'] = $data->asset_id;
	$_POST['item_id'] = $data->item_id;
	$_POST['serial_no'] = $data->serial_no;
	$_POST['wdv'] = $data->current_value;
	$_POST['sales_amount'] = $_POST['sale_value'.$data->id];
	$_POST['sub_ledger'] = $_POST['sub_ledger'];
    $id = $crud->insert();
	
}



$info = find_all_field('asset_disposal_info','','id="'.$_SESSION['ids'].'"');
$group_for=find_a_field('asset_register','group_for','asset_id="'.$info->asset_id.'"');


$tr_from = 'Asset Sales';
$jv_date = date('Y-m-d');
$jv_no=next_journal_sec_voucher_id('',$tr_from,$group_for);
//journal_asset_item_control($info->item_id ,$_SESSION['user']['depot'],$jv_date,0,1,$tr_from,$_POST['id'],$info->po_value,0,$_POST['id'],$info->po_value,0,0,$info->serial_no,$info->asset_id,'');
$narration = 'Asset Sales';

$ledger_all=find_all_field('item_info s','s.item_id','s.item_id='.$info->item_id.'');

$receivable=$ledger_all->asset_sales;
 $disposal_ac =$ledger_all->disposal_acc;
 $gain_loss_disposal =$ledger_all->gain_disposal;
 $asset_ledger =$ledger_all->asset_ledger;
 $item_sub_ledger =$ledger_all->item_sub_ledger;
 
 $asset_sales=find_all_field('asset_sales_info s','s.asset_id','s.asset_id='.$info->asset_id.' and s.item_id='.$info->item_id.'');

$disposal_amt=$asset_sales->wdv;
$sales_value=$asset_sales->sales_amount;
$sub_ledger=$asset_sales->sub_ledger;
if($sales_value>$disposal_amt){
$cr=$sales_value-$disposal_amt;
$dr=0;
}else{
$dr=$disposal_amt-$sales_value;
$cr=0;
}
 

asset_journal($jv_no,$jv_date,$info->asset_id,$asset_ledger,$narration,($sales_value),'0',$tr_from,$_SESSION['ids'],$group_for,'');
//Secondary Journal
//add_to_sec_journal('AMI', $jv_no, $jv_date, $disposal_ac,$narration,$info->current_value,'0', $tr_from, $_POST['id'],'','','',$info->group_for,$entry_by,$entry_at);

//add_to_sec_journal('AMI', $jv_no, $jv_date, $adep_ledger,$narration,$info->total_dpc,'0', $tr_from, $_POST['id'],'','','',$info->group_for,$entry_by,$entry_at);

//add_to_sec_journal('AMI', $jv_no, $jv_date, $asset_ledger,$narration,'0',$info->po_value, $tr_from, $_POST['id'],'','','',$info->group_for,$entry_by,$entry_at);

//sec_journal_journal($jv_no,$jv_no,$tr_from);

$insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger,  `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$receivable.",'".$narration."',".$sales_value.",'0', '".$tr_from."', ".$_SESSION['ids'].",".$sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$gain_loss_disposal.",'".$narration."',".$dr.",".$cr.", '".$tr_from."', ".$_SESSION['ids'].",".$item_sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$disposal_ac.",'".$narration."','0',".$disposal_amt.", '".$tr_from."', ".$_SESSION['ids'].",".$item_sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);

//sec_journal_journal2($jv_no,$jv_no,$tr_from);

$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');



$time_now = date('Y-m-d H:i:s');



if($sa_config=="Yes"){



$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($sa_up);



$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');





if($jv_config=="Yes"){


$insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$receivable.",'".$narration."',".$sales_value.",'0', '".$tr_from."', ".$_SESSION['ids'].",".$sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$gain_loss_disposal.",'".$narration."',".$dr.",".$cr.", '".$tr_from."', ".$_SESSION['ids'].",".$item_sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$disposal_ac.",'".$narration."','0',".$disposal_amt.", '".$tr_from."', ".$_SESSION['ids'].",".$item_sub_ledger.",".$group_for.",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);

$time_now = date('Y-m-d H:i:s');



$up2='update secondary_journal set checked="YES", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($up2);



$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up2);





}



} else {



$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($sa_up);



}

$up = 'update asset_disposal_info set status="Sold" where asset_id="'.$info->asset_id.'"';
	db_query($up);


unset($_SESSION['ids']);
$_SESSION['msg'] = '<span style="color:green;">Great! Sales Completed</span>';
header('location:direct_sales.php');
}

if(isset($_POST['cancel'])){
 unset($_SESSION['ids']);
$_SESSION['msg'] = '<span style="color:green;">Canceled!!!</span>';
header('location:direct_sales.php');
}
?>



<script language="javascript">
	function count()

	{





		if (document.getElementById('unit_price').value != '') {



			var vat = ((document.getElementById('vat').value) * 1);



			var unit_price = ((document.getElementById('unit_price').value) * 1);



			var dist_unit = ((document.getElementById('dist_unit').value) * 1);



			var total_unit = (document.getElementById('total_unit').value) = dist_unit;







			var total_amt = (document.getElementById('total_amt').value) = total_unit * unit_price;





		}







	}
</script>


<style type="text/css">
	.onhover:focus {

		background-color: #66CBEA;



	}





	< !-- .style2 {

		color: #FFFFFF;

		font-weight: bold;

	}

	-->
</style>



<!--DO create 2 form with table-->

<div class="form-container_large">

<?=$type ?>

	<form action="<?= $page ?>" method="post" name="codz2" id="codz2">

		<!--        top form start hear-->

		<div class="container-fluid bg-form-titel">

			<div class="row">

				<!--left form-->

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="container n-form2">

						





<div class="form-group row m-0 pb-1">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Dealer</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
						<? //create_combobox('sub_ledger');?>
								<input type="text" name="sub_ledger" id="sub_ledger" value="<?=$sub_ledger;?>"  list="sladger"/>
	  <datalist id="sladger">
	  <? foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$sub_ledger,'tr_from="dealer"');?>
	  
	  </datalist>
								

							</div>

						</div>
						
						<div class="form-group row m-0 pb-1">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Referance</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

								<input type="text" name="referance" id="referance" />
								

							</div>

						</div>

						



					</div>





				</div>



				<!--Right form-->

				<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

					<div class="container n-form2">


						<div class="form-group row m-0 pb-1">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive From</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                    
									<input type="date" name="sales_date" id="sales_date" />
									
								</span>

							</div>

						</div>
						
						<div class="form-group row m-0 pb-1">

							<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>

							<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                    
									<input type="text" name="note" id="note" />
									
								</span>

							</div>

						</div>

					</div>
				</div>





			</div>



		</div>

		
			<!--Table input one design-->

			<div class="container-fluid pt-5 p-0 ">





				<table class="table1  table-striped table-bordered table-hover table-sm">

					<thead class="thead1">

						  <tr>

      <th scope="col">S/L</th>
      <th scope="col">Asset ID</th>

      <th scope="col">Asset Category</th>

      <th scope="col">Asset Name</th>
	  
	  <th scope="col">Serial No.</th>

      <th scope="col">Current Value</th>
	  
	  <th scope="col">Sales Value</th>
	  
	  

    </tr>
					</thead>



					<tbody class="tbody1">


                        <?php
						
$sql='select r.*,i.item_name,s.sub_group_name from asset_disposal_info r,item_info i, item_sub_group s where r.item_id=i.item_id and s.sub_group_id=i.sub_group_id and r.status="Checked" and r.id in ('.$_SESSION['ids'].') group by r.asset_id';

     $query=db_query($sql);

     $i=1;

     while($data=mysqli_fetch_object($query)){
						?>
						<tr>

      <td><input type="checkbox" checked="checked" name="check[]" id="check<?=$data->id?>" value="<?=$data->id?>" class="form-control" /></td>


      <td><?=$data->asset_id?></td>

      <td><?=$data->sub_group_name?></td>
	  
	  <td><?=$data->item_name?></td>

      <td><?=$data->serial_no?></td>

	  <td><?=number_format($data->current_value,2)?></td>
	  <td><input type="text" name="sale_value<?=$data->id?>" id="sale_value<?=$data->id?>" value="" /></td>
	  
    </tr>
						<? } ?>
					</tbody>
				</table>


			</div>

			<div class="container-fluid p-0 ">



				<div class="n-form-btn-class">


					<div class="n-form-btn-class">

                    <input name="cancel" type="submit" class="btn btn-warning" value="CANCEL" style="float:left;" />
					<input name="confirm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM SALES" style="float:right;" />

				</div>

				</div>

			</div>

		</form>
		
</div>

<script>

$('#type').change(function(){

if($('#type').val()=="Department"){
$("#depp").css({display: "block"});

}else{

$("#depp").css({display: "none"});
}
});

</script>


<!--<script>$("#cz").validate();$("#cloud").validate();</script>-->



<?



require_once SERVER_CORE."routing/layout.bottom.php";







?>