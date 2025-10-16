<?php

session_start();


require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);
$unique='id';
$table_master = 'rfq_item_details';

$rfq_no  = $_SESSION['rfq_no'];

$sql = 'select rfq_no, rfx_stage, eventStartAt, eventEndAt, lot_bidding, running_time from rfq_master where rfq_no="'.$rfq_no.'" ';
$rfq_qry = db_query($sql);
$rfq_res = mysqli_fetch_object($rfq_qry);

if($rfq_res->rfx_stage=='Auction'){
	$visibility_start = $rfq_res->eventStartAt;
	if($rfq_res->lot_bidding=='serial'){
	    
		$check_item = find_a_field('rfq_item_details','visibility_end','rfq_no="'.$rfq_no .'" order by id desc');
		if($check_item!=''){
			$visibility_start = $check_item;
		}else{
			$visibility_start = $rfq_res->eventStartAt;
		}
		$timeString = $visibility_start;
		$dateTime = new DateTime($timeString);
		$dateTime->modify('+'.$rfq_res->running_time.' minutes');
		$newTime = $dateTime->format('Y-m-d H:i:s');
		$visibility_end = $newTime;
	}else{
		$visibility_start = $rfq_res->eventStartAt;
		$visibility_end = $rfq_res->eventEndAt;
	}
}

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
#$_POST['need_by'] = $info[5];
$_POST['ceiling_value'] = $info[6];
$_POST['historic_value'] = $info[5];
$_POST['entry_at'] = date('Y-m-d H:i:s');
$_POST['entry_by'] = $_SESSION['user']['id'];
$_POST['visibility_start'] = $visibility_start;
$_POST['visibility_end'] = $visibility_end;
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