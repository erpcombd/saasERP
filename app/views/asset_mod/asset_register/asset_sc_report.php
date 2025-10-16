<?php
/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Asset Schedule Report';

// Functions Start

function depreciation_amt($item_id,$tag,$fdate,$tdate)
{
$date1 = new DateTime($fdate);
$date2 = new DateTime($tdate);
$interval = $date1->diff($date2);
$total_days = $interval->format('%a');

$sql = 'select i.depreciation_rate,a.depreciation_start_date,a.price from item_info i, asset_register a where i.item_id=a.item_id and i.item_id="'.$item_id.'" and a.asset_id="'.$tag.'" and a.depreciation_start_date<="'.$fdate.'"';
$query=db_query($sql);
$a = mysqli_fetch_object($query);


if($a->depreciation_start_date>$fdate){
$fdate = $a->depreciation_start_date;
}
$date1 = new DateTime($fdate);
$date2 = new DateTime($tdate);
$interval = $date1->diff($date2);
$total_days = $interval->format('%a');

$total_dpc_value = ($a->price*$a->depreciation_rate)/100;
$daily_rate = $total_dpc_value/365;
$actual_dpc_rate = $daily_rate*$total_days;

return $actual_dpc_rate;
}


function depreciation_opening($item_id,$tag,$fdate)
{
$date1 = new DateTime($fdate);
$date2 = new DateTime($tdate);
$interval = $date1->diff($date2);
$total_days = $interval->format('%a');

$sql = 'select i.depreciation_rate,a.depreciation_start_date,a.price from item_info i, asset_register a where i.item_id=a.item_id and i.item_id="'.$item_id.'" and a.asset_id="'.$tag.'" and a.depreciation_start_date<="'.$fdate.'"';
$query=db_query($sql);
$a = mysqli_fetch_object($query);

$tdate = $fdate;
$fdate = $a->depreciation_start_date;

$date1 = new DateTime($fdate);
$date2 = new DateTime($tdate);
$interval = $date1->diff($date2);
$total_days = $interval->format('%a');

$total_dpc_value = ($a->price*$a->depreciation_rate)/100;
$daily_rate = $total_dpc_value/365;
$actual_dpc_rate = $daily_rate*$total_days;

return $actual_dpc_rate;
}

$con = '';
if($_POST['ledger_id']!=''){
$ledger = end(explode("#",$_POST['ledger_id']));
$con = ' and s.asset_ledger="'.$ledger.'"';
}

if($_POST['sub_group_id']>0){
$con .= ' and i.sub_group_id="'.$_POST['sub_group_id'].'"';
}
$sql2 = 'select a.*,i.item_name,s.asset_ledger,s.sub_group_name,w.warehouse_name from asset_register a, item_info i, item_sub_group s, warehouse w where i.item_id=a.item_id and i.sub_group_id=s.sub_group_id and a.warehouse_id=w.warehouse_id '.$con.' group by a.serial_no';
$qry2 = db_query($sql2);
while($data=mysqli_fetch_object($qry2)){
 ++$n;
 $asset_name[$n] = $data->item_name;
 $asset_item_id[$n] = $data->item_id;
 $asset_category[$n] = $data->sub_group_name;
 $deprecetian_date[$n] = $data->depreciation_start_date;
 $price[$n] = $data->price;
 $serial_no[$n] = $data->serial_no;
 $asset_id[$n] = $data->asset_id;
 $warehouse[$n] = $data->warehouse_name;
}

$tdate=$_REQUEST['tdate'];
$fdate=$_REQUEST["fdate"];
$cc_code=$_REQUEST["cc_code"];
if($cc_code==24){
$cc_code2 = 1;
}else{
$cc_code2 = $cc_code;
}





if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')

$report_detail.='<br>Reporting Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'].'';

?>

<script type="text/javascript">

$(document).ready(function(){

	

	$(function() {

		$("#fdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'yy-mm-dd'

		});

	});

		$(function() {

		$("#tdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'yy-mm-dd'

		});

	});



});

function DoNav(a,b,c)



{



	document.location.href = 'transaction_list.php?fdate='+a+'&tdate='+b+'&ledger_id='+c+'&show=Show';



}

</script>





<style type="text/css">

<!--

.style1 {font-weight: bold}
.style2 {font-weight: bold}

-->
.box_report{
	border:3px solid cadetblue;
	background:aliceblue;
}
.custom-combobox-input{
width:217px!important;
}

</style>











<title>Financial Profit &amp; Loss</title><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report"><form autocomplete="off" id="form1" name="form1" method="post" action="">

									<table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="22%" align="right">Date : &nbsp;</td>

                                        <td width="23%" align="left"> <div align="right">
                                        <input name="fdate" type="text" id="fdate" size="12" class="form-control" value="<?php echo $_REQUEST['fdate'];?>"/>
										<input name="tdate" type="text" id="tdate" size="12" class="form-control" value="<?php echo $_REQUEST['tdate'];?>"/>
                                        </div></td>

                                        <td width="8%" align="left"> <div align="center"></div></td>
                                        <td width="50%" align="left">
										</td>
                                      </tr>
									  
									  <tr>

                                        <td width="22%" align="right"> Asset Ledger: &nbsp;</td>

                                        <td align="left">
										<input type="text" name="ledger_id" id="ledger_id" list="ledgerList" value="<?=$_POST['ledger_id']?>" class="form-control" size="12">
									<datalist id="ledgerList">               
	<? foreign_relation('accounts_ledger a, ledger_group g,acc_sub_class s','concat(ledger_name,"#",ledger_id)','""',$asset_ledger,'a.ledger_group_id=g.group_id and g.acc_sub_class=s.id and s.sub_class_name in ("Non-Current Assets","Non Current Assets")');?>
	                                </datalist>
                                       
                                         </td>
										 <td></td>
										 <td></td>
                                      </tr>
									  
									  <tr>

                                        <td width="22%" align="right"> Asset Category: &nbsp;</td>

                                        <td align="left">
										<select name="sub_group_id" id="sub_group_id" class="form-control">
										<option></option>
										<? foreign_relation('item_sub_group s,item_group g','s.sub_group_id','s.sub_group_name',$_POST['sub_group_id'],'g.group_id=s.group_id and g.group_name like "%Asset%"')?>
										</select>
									
                                       
                                         </td>
										 <td></td>
										 <td></td>
                                      </tr>
									  
									  
									  
									  
									<tr>
										
                                        <td align="right"> </td>

                                        <td colspan="3" align="left">
											<br />										</td>
                                      </tr>
                                      

                                      

                                      <tr>

                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center"><input class="btn btn-primary" name="show" type="submit" id="show" value="Show" /></td>
                                        <td align="center">&nbsp;</td>
                                      </tr>
                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td>

									<div id="reporting" style="overflow:hidden">
									  <div id="grp">


<?
if(isset($_POST['show'])){
?>
<table width="100%" class="" cellspacing="0" cellpadding="2" border="1">

<thead>

				 <tr>
				   <th>SL</th>
				   <th>Asset ID</th>
				   <th>Asset Name</th>
				   <th>Asset Category </th>
				   <th>Warehouse</th>
				   <th>Depreciation Start Date </th>
				   <th>Serial No.</th>
				   <th>Purchase Amount</th>
				   <th>Depreciation Opening</th>
					<?
				   for($i=$fdate;$i<=$tdate;$i = date('Y-m-d', strtotime( $i . " +1 month"))){
				   ?> 
					 <th><?=date('M-Y',strtotime($i));?></th>
					 <? } ?>
					 
					 <th>Total Depreciation</th>
					 <th>Depreciation Closing</th>
					 <th>WDV</th>
				 </tr>
				    </thead>

				<?php
				 for($j=1;$j<=$n;$j++){
				 $depreciation_opening = depreciation_opening($asset_item_id[$j],$asset_id[$j],$fdate);
				 
				?>
				 <tr>

				   <td><?=$j?></td>
				   <td><?=$asset_id[$j]?></td>
				   <td><?=$asset_name[$j]?></td>
				   <td><?=$asset_category[$j]?></td>
				   <td><?=$warehouse[$j]?></td>
				   <td><?=$deprecetian_date[$j]?></td>
				   <td><?=$serial_no[$j]?></td>
				   <td align="right"><?=number_format($price[$j],2)?></td>
				   <td align="right"><?=number_format($depreciation_opening,2)?></td>
				   
				   <?php
				   for($k=$fdate;$k<=$tdate;$k = date('Y-m-d', strtotime( $k . " +1 month"))){
				  
				   $sdate2 = date('Y-m-01',strtotime($k));
				   $edate2 = date('Y-m-t',strtotime($k));
				   $dpc_value = depreciation_amt($asset_item_id[$j],$asset_id[$j],$sdate2,$edate2);
				   $total_line_dpc_value[$k] += $dpc_value;
				   ++$s;
				   ?>
				   <td align="right"><?=number_format($dpc_value,2);?></td>
				   <? $total_dpc_value +=$dpc_value; } ?>
				   
				   <td align="right"><?=number_format($total_dpc_value,2);?></td>
				   <td align="right"><? $depreciation_closing = $total_dpc_value+$depreciation_opening; echo number_format($depreciation_closing,2);?></td>
				   <td><? $wdv = $price[$j]-$depreciation_closing; echo number_format($wdv,2);?></td>
				  
				   </tr>
				   <? 
				      $total_purchase_value += $price[$j];
					  $total_dpc_opening += $depreciation_opening;
				      $grand_total_dpc +=$total_dpc_value;
					  $grand_total_closing +=$depreciation_closing;
					  $grand_wdv +=$wdv;
				      $depreciation_closing=0;
				      $total_dpc_value=0;
				        } ?>
				   
				   
				 
			<tr bgcolor="#CCCCCC">
			   <td colspan="7" align="right"><strong>Total</strong></td>
			   <td align="right"><?=number_format($total_purchase_value,2)?></strong></td>
			   <td align="right"><?=number_format($total_dpc_opening,2)?></strong></td>
			   <?php
				 
				   for($c=$fdate;$c<=$tdate;$c = date('Y-m-d', strtotime( $c . " +1 month"))){
				?>
			   <td align="right"><strong><?=number_format($total_line_dpc_value[$c],2)?></strong></td>
			   <? }  ?>
			   <td align="right"><strong><?=number_format($grand_total_dpc,2)?></strong></td>
			   <td align="right"><strong><?=number_format($grand_total_closing,2)?></strong></td>
			   <td align="right"><strong><?=number_format($grand_wdv,2)?></strong></td>
			</tr>	 
				 
				 
</table>
<? } ?>


</div>

</div>



	</td>

		</tr>

		</table>

		</div></td>    

  </tr>

</table>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>