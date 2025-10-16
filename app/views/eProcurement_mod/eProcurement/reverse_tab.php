<?php
	// show error
	
?>
<div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="reverse-tab">
 
<div class="row m-0 p-0 pt-4">

	<div class="col-12 pt-4 pb-4">		
			<style>
		.auction table tr td{
		border:0px !important;
		}
		.auction table tbody tr{
		    border-left: 5px solid #28a745;
    		border-bottom: 8px solid #f0f0f0;
		}
		
		</style>
		<div class="pt-1 auction" id="reverse_auction_ranking">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					

                    <tr class="bgc-info">
                        <th scope="col">Item Name</th>
                        <th scope="col">Vendor Name</th>
						<th scope="col">Bid Amount( Unit )</th>
						<th scope="col">Bid Amount( Total )</th>
						<th scope="col">Ceiling Bid</th>
						<th scope="col">Date & Time</th>
						<th scope="col">Action</th>
                    </tr>
					
                    </thead>
                    <tbody class="tbody1">
						<?php
						    $sql = 'SELECT d.*, i.item_name FROM rfq_item_details d, item_info i WHERE i.item_id = d.item_id AND rfq_no = "'.$_SESSION['rfq_no'].'"';
							$qry = db_query($sql);
							$i = 1;
							while ($res = mysqli_fetch_object($qry)) {

							$response_sql = 'SELECT 
									r.item_id, 
									MIN(r.unit_price) AS unit_price, 
									v.vendor_name, v.vendor_id,
										r.entry_at
								FROM 
									rfq_vendor_item_response r
								JOIN 
									vendor v ON r.vendor_id = v.vendor_id
								WHERE 
									r.item_id = "'.$res->item_id.'" 
									AND r.rfq_no = "'.$_SESSION['rfq_no'].'"
								GROUP BY 
									r.vendor_id, r.item_id
								ORDER BY 
									unit_price ASC;
								';
							
								
								$response_qry = db_query($response_sql);
								$colspan = $response_qry->num_rows;
								//if($colspan>0){
									
								
								$i = 1;
								while ($response_res = mysqli_fetch_object($response_qry)) {
									 //echo '<pre>'; print_r($response_res);
								
						?>
								<tr>
									<?php if($colspan>0){ ?>
										<td rowspan="<?php echo $colspan; $colspan=0; ?>" style=" border-left: 4px solid #298518; "><?php echo $res->item_name; ?></td>
									<?php } ?>
									
									<td><?php echo $response_res->vendor_name; ?></td>
									<td>BDT <?php echo number_format($response_res->unit_price,2); ?> 
									<span class="badge" style="background-color: 
											<?php 
												if ($i == 1) {
													echo 'green';
												} elseif ($i == 2) {
													echo 'lightgreen';
												} elseif ($i == 3) {
													echo 'yellow';
												} else {
													echo 'gray';
												}
											?>; color: white;"><?php echo $i++; ?>
										</span>
								
								</td>
									<td>BDT <?php echo number_format($response_res->unit_price*$res->expected_qty,2); ?> </td>

									<td><?=$res->ceiling_value?></td>
									<td><?=$response_res->entry_at?></td>
									<!-- <td>BDT <?php //echo number_format($response_res->unit_price,2); ?> <span class="badge badge-success"></span></td> -->
									<td><a href="reverse_tab_action.php?supplier_id=<?php echo $response_res->vendor_id; ?>"><button type="button" class="btn2 btn1-bg-update"><i class="fa-solid fa-ellipsis-vertical"></i></button></a></td>
								</tr>
						<?php } }// } ?>
						
		
					</tbody>
                </table>
				<style>
					#item_header {
					display: grid;
					place-items: center;     
					text-align: center;
					width: 100%;      
				}
				</style>
				<div id="item_header">All Item Combined Ranking</div>
				<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					

                    <tr class="bgc-info">
                        <th scope="col">Rank</th>
                        <th scope="col">Vendor Name</th>
						<th scope="col">Bid Amount( Total )</th>
						<th scope="col">Bidded Item</th>

						<!-- <th scope="col">Bid Amount( Total )</th>
						<th scope="col">Ceiling Bid</th>
						<th scope="col">Action</th> -->
                    </tr>
					
                    </thead>
                    <tbody class="tbody1">
						<?php


							$response_sql = 'SELECT r.vendor_id, SUM(r.min_unit_price * d.expected_qty) AS total_price, vd.vendor_name, GROUP_CONCAT(r.item_name ORDER BY r.item_id ASC) AS bidded_items, RANK() OVER (ORDER BY SUM(r.min_unit_price * d.expected_qty) ASC) AS vendor_rank  FROM ( SELECT v.vendor_id, v.item_id, MIN(v.unit_price) AS min_unit_price, q.item_name FROM rfq_vendor_item_response v JOIN item_info q ON v.item_id = q.item_id WHERE v.rfq_no = "'.$_SESSION['rfq_no'].'" GROUP BY v.vendor_id, v.item_id ) AS r JOIN rfq_item_details d ON r.item_id = d.item_id AND d.rfq_no = "'.$_SESSION['rfq_no'].'" JOIN vendor vd ON r.vendor_id = vd.vendor_id GROUP BY r.vendor_id ORDER BY total_price ASC;';
							
								
								$response_qry = db_query($response_sql);
								$colspan = $response_qry->num_rows;
								//if($colspan>0){
									
								
								$i = 1;
								while ($response_res = mysqli_fetch_object($response_qry)) {
									 //echo '<pre>'; print_r($response_res);
								
						?>
<tr>
    <td>
        <div style="width: 20px; height: 20px; text-align: center; line-height: 20px; 
            background-color: 
            <?php 
                if ($response_res->vendor_rank == 1) {
                    echo 'green';
                } elseif ($response_res->vendor_rank == 2) {
                    echo 'lightgreen';
                } elseif ($response_res->vendor_rank == 3) {
                    echo 'yellow';
                } else {
                    echo 'gray';
                }
            ?>; color: white;">
            <?=$response_res->vendor_rank?>
        </div>
    </td>
    <td><?=$response_res->vendor_name?></td>
    <td><?=$response_res->total_price?></td>
    <td><?=str_replace(',', '<br>', $response_res->bidded_items)?></td>
</tr>

						<?php } // } ?>
						
		
					</tbody>
                </table>
			</div>	
		</div>
	
	
	
  </div>
				
  </div>
  
  <script>
	// after every 15 seconds send get request to reverse_auction_ranking_ajax.php 

	
		setInterval(function() {
			// if url is : ?tab7 then send request
			if(window.location.href.indexOf("tab7") > -1) {
				$.ajax({
					url: 'reverse_auction_ranking_ajax.php',
					success: function(data) {
						document.getElementById('reverse_auction_ranking').innerHTML = data;
					}
				})
			}
			
		}, 15000);
	



    </script>  
  