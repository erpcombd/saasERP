<?php

session_start();

require_once "../../../assets/support/inc.all.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

//--========Table information==========-----------//
$table_master='sale_do_master';

$unique_master='do_no';

$table_detail='sale_do_details';

$unique_detail='id';

//--========Table information==========-----------//

$unique = $_POST[$unique_master];

$details_insert = new crud($table_detail)	;
$_POST['unit_price']=$_POST['unit_price2'] ;
$details_insert->insert();
unset($$unique);
$type=1;
$msg='Item Entry Succesfull';

$res='select a.id,b.finish_goods_code as code,b.item_name,a.in_stock, b.unit_name as unit,a.dist_unit as qty ,a.unit_price as price,a.dope_qty as sec_unit,a.sec_unit as sec_unit,a.total_amt,"X"

 from sale_do_details a,item_info b 

where b.item_id=a.item_id and a.do_no='.$unique.' order by a.id';

//$query44=mysql_query($res);

$all_dealer[]=link_report_add_del_auto($res,'',10);
 echo json_encode($all_dealer);

?>


  <?php /*?>  echo    "<table width='100%'>";
		echo "<thead>";
			echo "<tr>";
				echo "<th>S/L</th>";
				echo "<th>Code</th>";
				echo "<th>Item Name</th>";
				echo "<th>Price</th>";
				echo "<th>Quantity</th>";
				echo "<th>Total</th>";
				echo "<th>X</th>";
			echo "<tr>";
		echo "</thead>";
		
		echo "<tbody>";
		
	$i=1;
	
	while($data=mysql_fetch_object($query44)){
		
	
			echo "<tr>";
				echo "<td>".$i++."</td>";
				echo "<td>".$data->code."</td>";
				echo "<td>". $data->item_name."</td>";
				echo "<td><input style='width:95px !important' type='text' value='".$data->price."' /></td>";
				echo "<td><input style='width:95px !important' type='text' value='".$data->qty."'  /></td>";
				echo "<td>".$data->total_amt."</td>";
				
				echo "<td><a>X</a></td>";
				
				
			//	echo "<td><a href='?del=".$data->id."&or_no=".$or_no."'>x</a></td>";
				
			echo "<tr>";
		 } 
		echo "</tbody>";
	echo "</table>";


<?php */?>

