<div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="responses-tab">
  <h1 class="h1 m-0 p-0 pl-3 text-center"><em class="fa-solid fa-message-arrow-up-right"></em> Supplier Response </h1>
<div class="row m-0 p-0 pt-4">

<?   
	  $eventEndAt = $eventEndDate.' '.$eventEndTime;
	  $eventEndAtInt = strtotime($eventEndAt); 
	  $currentDateTime = strtotime(date('Y-m-d H:i:s'));
	 
	 
?>

	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-users"></em> Responses 
		<?php if($rfq_data->unseal_status=='UNSEALED' || ($rfq_data->when_unseal=='after_event_ends' && $eventEndAtInt<=$currentDateTime )){?>
			<a href="download_all_vendor_response_files.php"class="btn btn-success" target="_blank">Download all vendor data</a>
		<? } ?>
		</h1>
		
		<hr class="m-3" />
		
		<div class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					
                    <tr class="bgc-info">
                        <th scope="col">Supplier</th>
                        <th scope="col">Response Name</th>
						<th scope="col">Submitted Time</th>
                        <th scope="col">Total Cost</th>
						<th scope="col">Currency</th>
						<th scope="col">Evaluation Score</th>
						<th scope="col">Awarded</th>
						
                    </tr>
					
                    </thead>

                    <tbody class="tbody1" id="response_details">
					<?
			
		 /*$sql = 'select r.*,v.vendor_name,v.vendor_id,m.status as m_status, r.response_name 
		 from rfq_vendor_response r, vendor v, rfq_master m 
		 where r.rfq_no = m.rfq_no and r.vendor_id=v.vendor_id and r.status like "SUBMITED" and r.rfq_no="'.$_SESSION[$unique].'"';*/
		 
		 $sql = 'SELECT r.vendor_id, MAX(r.id) AS id, MAX(r.rfq_no) AS rfq_no, MAX(v.vendor_name) AS vendor_name,
		  MAX(m.status) AS m_status, MAX(r.entry_at) AS entry_at
		  FROM rfq_vendor_response r JOIN vendor v ON r.vendor_id = v.vendor_id JOIN rfq_master m ON r.rfq_no = m.rfq_no WHERE r.status LIKE "SUBMITED" AND r.rfq_no = "'.$_SESSION[$unique].'" GROUP BY r.vendor_id';
		 
		 
		 $qry = db_query($sql);
		 $total_cost = 0;
		 $response_name = '';
		 while($item=mysqli_fetch_object($qry)){
		 $total_cost = find_a_field('rfq_vendor_item_response','sum(total_amount)','rfq_no='.$_SESSION[$unique].'  and vendor_id='.$item->vendor_id.' and section_id='.$item->id);
		 $currency = find_a_field('rfq_vendor_item_response','currency','rfq_no='.$_SESSION[$unique].'  and vendor_id='.$item->vendor_id.' and section_id='.$item->id);
		 $response_all = find_all_field('rfq_vendor_response','response_name','id='.$item->id);
		 
		 $vendor_details_all = find_all_field('rfq_vendor_details','vendor_name','rfq_no='.$_SESSION[$unique].' and vendor_id="'.$item->vendor_id.'" ');
		 
		
		?>
					    <tr>
							<td><?=$item->vendor_name?></td>
							<?php if($rfq_data->unseal_status=='UNSEALED' || ($rfq_data->when_unseal=='after_event_ends' && $eventEndAtInt<=$currentDateTime ) ){?>
							<td><a href="vendor_response_view.php?vendor_id=<?=$item->vendor_id?>&response_id=<?=$item->id?>" target="_blank" rel="noopener"><?=$response_all->id?>#<?=$response_all->response_name?></a></td>
							<td><?=$item->entry_at?></td>
							<td><?=number_format($total_cost,2)?></td>
							<td><?=$currency?></td>
							<td>
							 <? 
							 if($_SESSION['user_role']=='Owner'){ 
							  
						  //$sql2 = 'select distinct a.action, a.id,u.fname,u.user_id,a.section from rfq_section_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'"';
						  
						  $sql2 = 'select  a.section_name as action, a.id as section from rfq_evaluation_section a where  a.rfq_no="'.$_SESSION['rfq_no'].'"';
							 
							 }else{
						$sql2 = 'select a.id,u.fname,u.user_id,a.action,a.section from rfq_section_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and u.user_id="'.$_SESSION['user']['id'].'"';
						}
		 $qry2 = db_query($sql2);
		 while($data2=mysqli_fetch_object($qry2)){
			 
		?>
        <a href="evaluation_marking.php?evaluation_id=<?=$data2->section?>&&vendor_id=<?=$item->vendor_id?>" target="_blank" rel="noopener"><button type="button" name="section" class="btn2 btn1-bg-cancel"><?=$data2->action?></button>
        <br>
        <? } ?>
		
							</td>
							
							
							<td>
							 <?
							 if($_SESSION['user_role']=='Owner'){
							  if($vendor_details_all->status=='SELECTED'){ echo 'Awarded : '.$vendor_details_all->award_per.' %'; }else{ ?>
								<form action="" method="post">
									<input name="award_per" id="award_per" type="text" value="<? if($award_per>0) echo $award_per; else echo 100;?>" placeholder="100%"  /> 
									<input type="hidden" name="vendor_id" id="vendor_id" value="<?=$item->vendor_id;?>"  />
									<input type="submit" name="award" value="Award" class="btn2 btn1-bg-cancel" />
								</form>
								<? } } ?>
							</td>
							
							<?php }else{ ?>
							<td><?=$item->response_name?></td>
							<td><?=$item->entry_at?></td>
							
                            <td>Sealed</td>
							<td>Sealed</td>
							<td>Sealed</td>
							<td>Sealed</td>
							<?php } ?>
							
							
                        </tr>
					<? } ?>
					    <tr>
						<?   $eventEndAt = $eventEndDate.' '.$eventEndTime;
							 $eventEndAtInt = strtotime($eventEndAt);
							 $currentDateTime = strtotime(date('Y-m-d H:i:s'));
						?>
						<?php if($_SESSION['user_role']=='Owner' && $rfq_data->unseal_status!='UNSEALED' && $eventEndAtInt<=$currentDateTime){?>
						 <form method="post"> <td colspan="9"><button type="submit" name="unseal" class="btn1 btn1-bg-update">Unseal Now</button></td></form>
						  <?php } ?>
						</tr>						
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
	
	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-users"></em> Evaluation Information </h1>
		<hr class="m-3" />
		<div><a href="cs_table_ev.php" target="_blank" rel="noopener"><button type="button" name="section" class="btn2 btn1-bg-cancel">Evaluation Comparison</button></a></div>
		<?php if($rfq_data->unseal_status=='UNSEALED' && $_SESSION['user_role']=='Owner'){?>
		<div><a href="cs_table.php" target="_blank" rel="noopener"><button type="button" name="section" class="btn2 btn1-bg-cancel">CS Table</button></a></div>
		<? } ?>
	</div>
	
  </div>
				
  </div>
  
  
  
  