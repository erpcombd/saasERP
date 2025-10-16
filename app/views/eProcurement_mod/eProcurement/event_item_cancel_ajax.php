<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$unique='id';
$table_master = 'rfq_item_details';
$Crud   = new Crud($table_master);

$rfq_no  = $data[0];
$id = $data[1];

$item_id = find_a_field('rfq_item_details','item_id','id="'.$id.'"');
$item_name = find_a_field('item_info','item_name','item_id="'.$item_id.'"');

if($rfq_no>0 && $id>0){
$del = 'delete from rfq_item_details where id="'.$id.'"';
db_query($del);

$_POST['rfq_no'] = $rfq_no;
$_POST['field_name'] = 'Event item Removed';
$_POST['field_value'] = $item_name;
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$Crud   = new Crud('rfq_logs');
$Crud->insert();
}

?>
<tr class="bgc-info">
                       <th scope="col" width="2%">SL</th>
						<th scope="col" width="35%">Item Description</th>
                        <th scope="col" width="10%">Quantity</th>
						<th scope="col" width="10%">UOM</th>
						<th scope="col" width="10%">Ceiling Value</th>
						<th scope="col" width="10%">Historic Value</th>
						<th scope="col" width="8%">Unit Price</th>
						<th scope="col" width="10%">Currency</th>
						<th scope="col" width="10%">Amount</th>
						<th scope="col" width="15%">Delivery lead time in days</th>
						
						
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
							<td style="text-align:right;"><?=$doc->ceiling_value?></td>
							<td style="text-align:right;"><?=$doc->historic_value?></td>
							<td style="text-align:right;"><?=$doc->price?></td>
							<td><?=$doc->currency?></td>
							<td style="text-align:right;"><?=number_format($doc->expected_qty*$doc->price,0)?></td>
							<td><?=$doc->need_by?>
							&nbsp;
							<button type="button" name="add_event_team" 
		class="btn2 btn1-bg-cancel" onclick="event_item_cancel(document.getElementById('new_rfq_no').value,<?=$doc->id?>)">x</button>
		</td>
                            
                        </tr>	
						<? } ?>