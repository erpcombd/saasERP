<div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="responses-tab">
  
<div class="row m-0 p-0 pt-4">
  	

	
	
	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-users"></em> Responses</h1>
		<hr class="m-3" />
		
		<div class="pt-1">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
					
                    <tr class="bgc-info">
                        <th scope="col">Supplier</th>
                        <th scope="col">Response Name</th>
                        <th scope="col">Base Price</th>
						<th scope="col">Capacity</th>
						<th scope="col">Bid Price</th>
						<th scope="col">Savings</th>
						<th scope="col">Evaluation</th>
						<th scope="col">Awarded?</th>
						<th scope="col">Submitted</th>
                    </tr>
					
                    </thead>

                    <tbody class="tbody1" id="response_details">
					<?
		$sql = 'select r.*,i.item_name,v.vendor_name,v.vendor_id,m.status as m_status from rfq_vendor_item_response r, item_info i, vendor v, rfq_master m where r.rfq_no=m.rfq_no and r.vendor_id=v.vendor_id and i.item_id=r.item_id and r.rfq_no="'.$_SESSION[$unique].'"';
		 $qry = db_query($sql);
		 while($item=mysqli_fetch_object($qry)){
		 $vendor_response = find_a_field('rfq_vendor_response','response_name','rfq_no="'.$item->rfq_no.'" and vendor_id="'.$item->vendor_id.'"');
		?>
					    <tr>
							<td><?=$item->vendor_name?></td>
							<?php if($item->m_status=='UNSEALED'){?>
							<td><a href="vendor_response_view.php?vendor_id=<?=$item->vendor_id?>" target="_blank" rel="noopener"><?=$vendor_response?></a></td>
							<td><?=$item->base_price?></td>
							<td><?=$item->capacity?></td>
                            <td><?=$item->unit_price?></td>
							<td></td>
							<td>
							 <? 
						$sql2 = 'select a.id,u.fname,u.user_id,a.action,a.section from rfq_section_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and u.user_id="'.$_SESSION['user']['id'].'"';
		 $qry2 = db_query($sql2);
		 while($data2=mysqli_fetch_object($qry2)){
			 
		?>
        <a href="evaluation_marking.php?evaluation_id=<?=$data2->section?>&&vendor_id=<?=$item->vendor_id?>" target="_blank" rel="noopener"><button type="button" name="section" class="btn2 btn1-bg-cancel"><?=$data2->action?></button>
        <br>
        <? } ?>
		<?
		 if($_SESSION['user']['id']==$entry_by){
		?>
		  <a href="evaluation_table.php?vendor_id=<?=$item->vendor_id?>" target="_blank" rel="noopener"><button type="button" name="section" class="btn2 btn1-bg-cancel">Evaluation Information</button></a>
		  <? } ?>
							</td>
							
							
							<td></td>
							
							<?php }else{ ?>
							<td><?=$vendor_response?></td>
							<td>Sealed</td>
							<td>Sealed</td>
                            <td>Sealed</td>
							<td>Sealed</td>
							<td>Sealed</td>
							<td>Sealed</td>
							<?php } ?>
							<td><?=$item->entry_at?></td>
                        </tr>
					<? } ?>
					    <tr>
						<?php if($status!='UNSEALED'){?>
						 <form method="post"> <td colspan="9"><button type="submit" name="unseal" class="btn1 btn1-bg-update">Unsealed Now</button></td></form>
						  <?php } ?>
						</tr>						
					</tbody>
                </table>
  
  
  
  
  </div>
		
		
		
	</div>
	
	
	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-users"></em> Evaluation Information </h1>
		<hr class="m-3" />
		<div><a href="evaluation_comparison.php" target="_blank" rel="noopener"><button type="button" name="section" class="btn2 btn1-bg-cancel">Evaluation Comparison</button></a></div>
		<div><button type="button" name="section" class="btn2 btn1-bg-cancel">CS Table</button></div>
	</div>
	
  </div>
				
  </div>
  
  
  
  