<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);
$unique='id';
$table_master = 'rfq_item_details';

$rfq_no  = $_SESSION['rfq_no'];

$info = explode("|",$data[1]);

$_POST['rfq_no'] = $rfq_no;

if($_SESSION['rfq_no']>0){

$_POST['item_name'] = trim($info[0]);
$check_item = find_a_field('item_info','item_id','item_name="'.$_POST['item_name'].'"');
if($check_item>0){
$item_id = $check_item;
}else{
$_POST['status'] = 'Active';
$Crud   = new Crud('item_info');
$item_id = $Crud->insert();
}


$Crud   = new Crud($table_master);
$_POST['item_id'] = $item_id;
$_POST['unit'] = $info[1];
$_POST['expected_qty'] = $info[2];
$_POST['price'] = $info[3];
$_POST['currency'] = $info[4];
$_POST['need_by'] = $info[5];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud->insert();
$_POST['field_name'] = 'event_item_insert';
$_POST['field_value'] = $info[0];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}
?>

 <tr class="bgc-info">
                        <th scope="col">SL</th>
						<th scope="col">Item Description</th>
                        <th scope="col">Quantity</th>
						<th scope="col">UOM</th>
						<th scope="col">Unit Price</th>
						<th scope="col">Currency</th>
						<th scope="col">Amount</th>
						
						
                    </tr>
					
<?
		 $sql = 'select r.*,i.item_name from rfq_item_details r, item_info i where i.item_id=r.item_id and r.rfq_no="'.$rfq_no.'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
						<tr>
						    <td style="text-align:right;"><?=++$j?></td>
							<td style="text-align:left;"><?=$doc->item_name?></td>
							<td style="text-align:right;"><?=$doc->expected_qty?></td>
							<td><?=$doc->unit?></td>
							<td style="text-align:right;"><?=$doc->price?></td>
							<td><?=$doc->currency?></td>
							<td style="text-align:right;"><?=number_format($doc->expected_qty*$doc->price,0)?>
							&nbsp;
							<button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_item_cancel(document.getElementById('new_rfq_no').value,<?=$doc->id?>)">x</button>
		</td>
                            
                        </tr>	
						<? } ?>