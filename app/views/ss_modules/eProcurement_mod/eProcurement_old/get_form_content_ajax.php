<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');


$str = $_POST['data'];
$data=explode('##',$str);

$section_id = $data[0];
$rfq_no  = $_SESSION['rfq_no'];


		$sql = 'select * from rfq_form_master where rfq_no="'.$rfq_no.'"';
		$qry = db_query($sql);
		while($form_data=mysqli_fetch_object($qry)){
		extract((array) $form_data);
		
		?>
		<div class="col-12 pt-4 pb-4">
			<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-file-lines"></em> Forms Name - <?=$form_name?></h1>
			<hr class="m-3" />
			
			<div class="pt-1">
					<div class="row m-0 p-0 pt-4">
					<div class="col-6 ">
					<table class="w-100">
					<tbody>
					
					
					<tr class="tr">
						<td class="td1">Status : </td>
						<td class="td2"><?=$form_status?></td>
					</tr>
					
								
					<tr class="tr">
						<td class="td1">Description : </td>
						<td class="td2"><?=$form_description?>
						</td>
					</tr>
					
				</tbody>
				</table>
					</div>	
					<div class="col-6">
						<p class="p-0 m-0 bold">Available to</p>
						<p class="p-0 m-0">
						
						
						
						</p>
						
						  <input type="radio" id="form_available" name="form_available" <?php if($form_available=='everyone') {echo 'checked';}?> value="everyone" readonly="readonly">
							<label for="sa2"><em class="fa-duotone fa-user-group fa-flip-horizontal" style="--fa-primary-color: #20304c; --fa-secondary-color: #0eee0e;"></em> Everyone</label><br>
							
							<input type="radio" id="form_available" name="form_available" <?php if($form_available=='event_member') {echo 'checked';}?> value="event_member" readonly="readonly">
							<label for="sa3">Only members of these content groups</label><br />
							
												
							<label for="sa3">Tags : </label><?=$form_tags?>
							<input type="checkbox" id="form_hide_from_search" name="form_hide_from_search" <?php if($form_hide_from_search=='1') {echo 'checked';}?> readonly="readonly"  value="1">
							<label for="sa3">Hide From Search</label>
							
						
						
					</div>
					
					
					<? 
		$sqlss = 'select f.*,f.id as form_details_id,e.fetch_file_name,e.element from rfq_form_details f,form_elements e where f.form_element=e.element and form_no="'.$form_no.'" and rfq_no="'.$rfq_no.'"';
		$qryr = db_query($sqlss);
		while($form_details_data=mysqli_fetch_object($qryr)){
		extract((array) $form_details_data);
		include_once($fetch_file_name);
		}
		?>
				
					
				</div>
			 <div ><button type="button" name="more_option" class="btn1 btn1-bg-cancel" onClick="remove_form(document.getElementById('new_rfq_no').value,<?=$form_no?>);">Remove Form</button></div>
			</div>
		</div>
	 <? } ?>