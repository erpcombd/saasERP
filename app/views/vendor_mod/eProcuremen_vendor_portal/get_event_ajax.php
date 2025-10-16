<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);
$unique = 'rfq_no';

 $search_with  = $data[0];

$search_text  = $data[1];

if($search_text!=''){
if($search_with =='rfq_no'){

	$con = ' and (m.'.$search_with.' like "%'.$search_text.'%" or m.rfq_version like "%'.$search_text.'%")';
}else if($search_with =='ALL'){
	$con='';
}
else{
	$con = ' and '.$search_with.' like "%'.$search_text.'%"';
}

}

?>
<table class="table1  table-striped table-bordered table-hover table-sm">
	            <caption></caption>
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col" scope="col">Event ID</th>
						<th scope="col" scope="col">Event Name</th>
                        <th scope="col" scope="col">Start Date</th>
						<th scope="col" scope="col">End Date</th>
						<th scope="col" scope="col">Status</th>
						<th scope="col" scope="col">Type</th>
						<th scope="col" scope="col">Response</th>
						<th scope="col" scope="col">Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					<?
					$now = date('Y-m-d H:i:s');
					$start = date('Y-m-d');
					$vendor = $_SESSION['vendor']['id'];
					$sql = 'select m.*,v.vendor_name ,d.reject_status
					from rfq_master m, rfq_vendor_details d, vendor v 
					where m.rfq_no=d.rfq_no and v.vendor_id=d.vendor_id and d.vendor_id="'.$vendor.'"   and d.status like "INVITED" '.$con.'  order by m.rfq_no desc
					';
					// and m.status="CHECKED" and m.eventStartDate<="'.$start.'" and m.eventEndAt>="'.$now.'"
					$qry=db_query($sql);
					while($data=mysqli_fetch_object($qry)){
						if($data->status=='CHECKED'){
							$status = 'Live';
							}elseif($data->status=='MANUAL'){
							$status = 'Draft';
							}elseif($data->status=='UNSEALED'){
							$status = 'Evaluation';
							}elseif($data->status=='COMPLETE'){
							$status = 'Completed';
							}else{
							$status = $data->status;
							}
					//&& $data->eventEndAt<=$now
					$eventStart = strtotime($data->eventStartDate);
					$startString = strtotime($start);
					
					$eventEnd = strtotime($data->eventEndDate." ".$data->eventEndTime);
					$nowString = strtotime($now);
					?>
					    <tr>
						    <td><?=$data->rfq_version?></td>
							<td style="text-align:left;"><?=$data->event_name?></td>
							<td><?=$data->eventStartDate?></td>
							<td><?=date('Y-m-d', $eventEnd);?></td> 
							<td><?=$status?></td> 
							<td><?=$data->rfx_stage?></td>
							<td><?=find_a_field('rfq_vendor_response','count(id)','vendor_id="'.$vendor.'" and rfq_no="'.$data->rfq_no.'" ')?></td>
							<td>
								<?php if($eventStart<=$startString && $eventEnd>=$nowString && $data->status=="CHECKED" && $data->reject_status=="No"){ ?>
									<a href="vendor_entry_entry.php?rfq_no=<?=$data->rfq_no?>"> <button type="button" class="btn2 btn1-bg-update">Event View</button></a>
								<?php } ?>
							
							<?if($data->reject_status=="Yes"){?>	
							  <span style="color:red;">Not Participated</span>
                            <?}?>
							</td>
                        </tr>	
						<? } //}?>	
						
											
					</tbody>
                </table>


