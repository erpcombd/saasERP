<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";

header('Content-Type: text/html');

// Read the JSON input
$input = json_decode(file_get_contents('php://input'), true);

$rfq_name = $input['rfq_no'] ?? '';
 $bid_amount = $input['bid_amount'] ?? '';
$bid_currency = $input['bid_currency'] ?? '';

// Get the current time
$current_time = new DateTime();
$lead_bid='';
// $rfq_sql='SELECT * FROM rfq_master WHERE rfq_no="'..'"'
$rfq_master = find_all_field('rfq_master','','rfq_no="'.$rfq_name.'"');

// Query to get the relevant rows
$sql = 'SELECT d.*, i.item_name FROM rfq_item_details d, item_info i WHERE i.item_id = d.item_id AND rfq_no = "'.$rfq_name.'"';
$qry = db_query($sql);

// Build the table
?>

<table class="table1 table-striped table-bordered table-hover table-sm">
    <thead class="thead1">
        <tr class="bgc-info">
            <th scope="col">SL</th>
            <th scope="col">Item Description</th>
            <th scope="col">Item Quantity</th>
            <th scope="col">Lead BID</th>
            <th scope="col">Units</th>
            <th scope="col">Ceiling Value</th>
            <th scope="col">Historic Value</th>
            <th scope="col">MY BID</th>
            <th scope="col">Currency</th>
            <th scope="col">BID(XFOR) [RANK]</th>
            <th scope="col">New BID</th>
            <th scope="col">Action</th>
        </tr>
    </thead>

    <tbody class="tbody1">
        <?php
        $i = 1;
        while ($res = mysqli_fetch_object($qry)) {
            // Get the showtime and endtime
            $showtime = new DateTime($res->visibility_start);
            $endtime = new DateTime($res->visibility_end);
            
            // Check if current time is within visibility period
            if ($current_time >= $showtime && $current_time <= $endtime) {
                ?>
                <tr>
                    <input type="hidden" id="live_bid_item_id" value="<?=$res->item_id?>">
                    <td><?= $i++ ?></td>
                    <td><?= $res->item_name ?></td>
                    <td><?= $res->expected_qty ?></td>
                    <td><?if($lead_bid !=''){echo $lead_bid;}else{echo '0.00';}?></td>
                    <td><?=$res->unit ?></td>
                    <td><?=$rfq_master->initial_bid?></td>
                    <td><?=$rfq_master->historical_amt?></td>
                    <td><input type="text" id="live_bid_item_amount"live_bid_item_amount name="" value="<?=$bid_amount?>"></td>
                    <td>
							<select name="live_bid_currency" id="live_bid_currency<?=$res->id?>" >
							<?php if($rfq->other_currency=='yes'){?>
								<?php
									$sql_currency = 'select c.currency from rfq_multiple_currency m, currency_info c where m.currency_id=c.id and m.rfq_no='.$rfq_name.' ';
									$qry_currency = db_query($sql_currency);
									while($res_currency = mysqli_fetch_object($qry_currency)){
										echo '<option value="'.$res_currency->currency.'"';
											// if($res_currency->currency==$itemResponse->currency){ echo 'selected';}
										echo ' >'.$res_currency->currency.'</option>';
									}
								?>
								</p>
								
							<?php }else{ ?>	
								<option value="<?=$res->currency;?>" ><?=$res->currency;?></option>
								<?}?>
							</select>
					</td>
                    <td>Bid for rank</td>
                    <td>New Bid</td>
                    <td>
                        <button class="btn1 btn1-bg-update active" type="button" name="vendor_auction_item_response" id="vendor_auction_item_response" onclick="auction_item_bid_update(<?=$res->item_id?>,<?=$_SESSION['user']['id']?>,<?=$rfq_name?>)">Place Bid</button>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>

<?php

