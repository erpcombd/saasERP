<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="evaluations-tab">
  
 
  <div class="row m-0 p-1 pt-4">
  	<div class="col-12">
	<div class="col-6 ">
	
	 <table class="w-100" border="1" cellspacing="5" cellpadding="5">
	   <tbody>
	  <tr>
	    <td>Evaluation Method</td>
		<td><input type="radio" name="evaluation_method1" id="evaluation_method1" value="pass_fail" <? if($evaluation_method=='pass_fail'){ echo 'checked';}?> />&nbsp;Pass/Fail</td>
		<td><input type="radio" name="evaluation_method1" id="evaluation_method2" value="combined" <? if($evaluation_method=='combined'){ echo 'checked';}?>  />&nbsp;Combined</td>
		</tr>
		<tr>
	    <td><select class="section_name" name="event_section_name" id="event_section_name">
				<option></option>
				<option>General</option>
				<option>Technical</option>
				<option>Commercial</option>
				<option>Form</option>
				</select></td>
		<td><input type="text" class="section_name" name="event_section_percent" id="event_section_percent" value="" placeholder="Weightage %.."></td>
		<td><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn1 btn1-bg-update" onclick="add_evaluation_section(document.getElementById('event_section_name').value,document.getElementById('event_section_percent').value,document.getElementById('evaluation_method1').value,document.getElementById('evaluation_method2').value)">Add Section</button><? } ?></td>
		</tr>

			</tbody>
			</table><br /><br />

			
			<div id="section_details">
			<?
		 $sql = 'select * from rfq_evaluation_section where rfq_no="'.$rfq_no.'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>
       <table class="w-100" border="0" cellspacing="5" cellpadding="5">
	   <tbody>
	  <tr>
	    <td style="font-weight:bold;">Section</td>
		<td style="font-weight:bold;">Weightage</td>
		<td style="font-weight:bold;">Total Weightage</td>
		</tr>
		
		 <tr>
	    <td><?=$doc->section_name?></td>
		<td><?=$doc->section_percent?>%</td>
		<td><span id="total_weight<?=$doc->id?>"><?=find_a_field('rfq_evaluation_section_child','sum(average_percent)','section_id="'.$doc->id.'" and rfq_no="'.$_SESSION['rfq_no'].'"');?></span>%</td>
		</tr>
		
		<tr>
	    <td><input type="text" class="section_name" name="section_child<?=$doc->id?>" id="section_child<?=$doc->id?>" value="" placeholder="Criteria"></td>
		<td><input type="text" class="section_name" name="section_child_percent<?=$doc->id?>" id="section_child_percent<?=$doc->id?>" value="" placeholder="Weightage..%"></td>
		<td><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn1 btn1-bg-update" onclick="add_evaluation_section_child(<?=$doc->id?>,document.getElementById('section_child'+<?=$doc->id?>).value,document.getElementById('section_child_percent'+<?=$doc->id?>).value);">+</button>
				<? } ?></td>
		</tr>
		
		<tr>
	    <td colspan="3">
		 
             <table class="w-100" border="1" id="section_child_details_<?=$doc->id?>">
            <tbody>
			<?
		 $sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$rfq_no.'" and section_id="'.$doc->id.'"';
		 $qry2 = db_query($sql2);
		 while($doc2=mysqli_fetch_object($qry2)){
		?>
           
           <tr>
             <td><?=$doc2->child_name?></td>
             <td style="text-align:right;"><?=$doc2->child_percent?>%</td>
             <td style="text-align:center;"><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn2 btn1-bg-cancel" onclick="remove_section_child(<?=$doc->id?>,<?=$doc2->id?>)">x</button><? } ?></td>
           </tr>
			
			
			<? } ?>
			</tbody>
            </table>

		</td>
		</tr>
		<tr>
		 <td colspan="3">			<? if($_SESSION['master_status']=='MANUAL'){?><button type="button" onclick="remove_section(<?=$doc->id?>)" style="border:0px;">Remove Section</button>	<? } ?></td>
		</tr>
		</tbody>
		</table><br />

			<? } ?>
			
			</div>
			</div>
			</div>
	
  </div>
  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-users"></em> Evaluation Team </h1>
		<hr class="m-3" />
        
		<div class="col-6 ">
			<h1 class="h1 m-0 p-0 pl-3">Team Member</h1>
			
			<div class="pl-3 d-flex">
				<div style=" width: 60% !important;" id="eventTeamAssign">
				<input type="text" class="section_name" name="evaluator_user" list="eventMemberList" autocomplete="off" id="evaluator_user" value="">
                <datalist id="eventMemberList">
                <?php 
				$sqlss = 'select a.id,u.fname,u.user_id from rfq_evaluation_team a, user_activity_management u where a.action in ("Owner","Evaluator") and a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'"';
				 $qryss = db_query($sqlss);
				 while($dataa=mysqli_fetch_object($qryss)){
				?>
                <option><?=$dataa->fname?>#<?=$dataa->user_id?></option>
                <? } ?>
                </datalist>
                </div>
                <div style=" width: 30% !important;" id="section_assign"><select class="section_name" name="evaluation_section" id="evaluation_section"><option></option><? foreign_relation('rfq_evaluation_section','id','section_name',$evaluation_section,'rfq_no="'.$_SESSION[$unique].'"')?></select></div>
				<div>
				<? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn1 btn1-bg-update" onclick="add_evaluator(document.getElementById('evaluator_user').value,document.getElementById('evaluation_section').value)">Add Evaluator</button><? } ?></div>
				<p class="p-0 m-0" ></p>
				
			</div>
			
			</div>
		<div class="pt-4">
  	<table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th scope="col">Name</th>
                        <th scope="col">Role</th>
						<th scope="col">Evaluation Status</th>
                        <th scope="col">Sections</th>
						<th scope="col">Action</th>
                        
                    </tr>
                    </thead>

                    <tbody class="tbody1" id="evaluator_details">
					
					    
						
						<? 
						$sql = 'select a.id,u.fname,u.user_id,a.action from rfq_evaluation_team a, user_activity_management u 
						where a.action in ("Owner","Evaluator") and a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qry = db_query($sql);
		 while($data=mysqli_fetch_object($qry)){
			 
		?>
		<tr>
							<td><?=$data->fname?></td>
                            <td><?=$data->action?></td>
							<td>Pending</td>
							<td><? 
						$sql2 = 'select a.id,u.fname,u.user_id,a.action from rfq_section_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" and u.user_id="'.$data->user_id.'"';
		 $qry2 = db_query($sql2);
		 while($data2=mysqli_fetch_object($qry2)){
			 echo $data2->action;
			 echo ', ';
			 
		?>
        <span><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn2 btn1-bg-cancel" onclick="remove_evaluator(<?=$data2->id?>)">x</button><? } ?></span>
        <br>
        <? } ?>
        </td>
							<td></td>
                        </tr>
		<? } ?>
														
					</tbody>
                </table>
  
  
  
  
  </div>
		<br><br><br><br>
		
		
	</div>
	
  </div>			
  </div>
  
 