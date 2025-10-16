<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="evaluations-tab">



  <!-- Button trigger modal Start-->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#evaluationModal">
    Add Evaluations 
</button>
<!-- Button trigger modal end-->
  
  <!-- Modal start-->
  <div class="modal fade" id="evaluationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <!-- Modal header start-->
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- Modal header end-->
        <!-- Modal Body Start-->
        <div class="modal-body">
            <!-- content start -->

               <div class="row m-0 p-1 pt-4">
  	<div class="col-12">
	<div class="col-12 ">
			<h1 class="h1 m-0 p-0 pl-3">Section Name</h1>
			
			<div class="pl-3 d-flex">
				<div style=" width: 60% !important;"><select class="section_name" name="event_section_name" id="event_section_name">
				<option></option>
				<option>General</option>
				<option>Technical</option>
				<option>Commercial</option>
				<option>Form</option>
				</select></div>
                <div style=" width: 30% !important;"><input type="text" class="section_name" name="event_section_percent" id="event_section_percent" value="" placeholder="Example 60%.."></div>
				<div>
				<? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn1 btn1-bg-update" onclick="add_evaluation_section(document.getElementById('event_section_name').value,document.getElementById('event_section_percent').value)">Add Section</button><? } ?></div>
				<p class="p-0 m-0" ></p>
				
			</div>
			
			</div>
			
			<div id="section_details">
			<?
		 $sql = 'select * from rfq_evaluation_section where rfq_no="'.$rfq_no.'"';
		 $qry = db_query($sql);
		 while($doc=mysqli_fetch_object($qry)){
		?>

			<div class="col-12 row">
	<div class="col-12 ">
			<fieldset class="scheduler-border">
    <legend class="scheduler-border" style="font-size: 16px !important;">&nbsp;<?=$doc->section_name.'-'.$doc->section_percent?>%</legend>
			
			<div class="pl-3 d-flex">
				<div style=" width: 50% !important;"><input type="text" class="section_name" name="section_child<?=$doc->id?>" id="section_child<?=$doc->id?>" value="" placeholder="Section Child"></div>
                <div style=" width: 20% !important;"><input type="text" class="section_name" name="section_child_percent<?=$doc->id?>" id="section_child_percent<?=$doc->id?>" value="" placeholder="%"></div>
				<div>
				<? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn1 btn1-bg-update" onclick="add_evaluation_section_child(<?=$doc->id?>,document.getElementById('section_child'+<?=$doc->id?>).value,document.getElementById('section_child_percent'+<?=$doc->id?>).value)">+</button>
				<? } ?>
				</div>
				<p class="p-0 m-0" ></p>
                
			</div>
           
            
            <div id="section_child_details_<?=$doc->id?>">
             <table class="w-100"    border="1">
            <tbody>
			<?
		 $sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$rfq_no.'" and section_id="'.$doc->id.'"';
		 $qry2 = db_query($sql2);
		 while($doc2=mysqli_fetch_object($qry2)){
		?>
           
           <tr>
             <td><?=$doc2->child_name?></td>
             <td><?=$doc2->child_percent?>%</td>
             <td><?=$doc2->average_percent?>%</td>
             <td><? if($_SESSION['master_status']=='MANUAL'){?><button type="button" name="section" class="btn2 btn1-bg-cancel" onclick="remove_section_child(<?=$doc->id?>,<?=$doc2->id?>)">x</button><? } ?></td>
           </tr>
			
			
			<? } ?>
			</tbody>
            </table>
			</div>
            
           <? if($_SESSION['master_status']=='MANUAL'){?> <button type="button" onclick="remove_section(<?=$doc->id?>)" style="border:0px;">Remove Section</button><? } ?>
			</fieldset>
            
			</div>
            
			</div>
			
			<? } ?>
			
			</div>
			</div>
	
  </div>

            <!-- content start -->
        </div>
        <!-- Modal body End-->
        <!-- Modal Footer Start-->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        <!-- Modal Footer end-->
      </div>
    </div>
  </div>
  <!-- Modal end-->
  
  
  <!--Section Start-->
  <div class="accordion" id="accordionExample">
  <div class="card">
  
  <!--Section Header Start-->
    <div class="card-header" id="headingThree">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Show Evaluation
        </button>
      </h5>
    </div>
	<!--Section Header End-->
	
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
      <div class="card-body">
	  <!--Section Body start-->
        content hear.
		
		<!--Section Body End-->
      </div>
    </div>
  </div>
</div>
<!--Section End-->
  
  
  
  
  
  
 
  
  
  <div class="row m-0 p-0 pt-4">
  	<div class="col-12 pt-4 pb-4">
		<h1 class="h1 m-0 p-0 pl-3"><em class="fa-solid fa-users"></em> Evaluation Team </h1>
		<hr class="m-3" />
        
		<div class="col-6 ">
			<h1 class="h1 m-0 p-0 pl-3">Team Member</h1>
			
			<div class="pl-3 d-flex">
				<div style=" width: 60% !important;"><input type="text" class="section_name" name="evaluator_user" list="eventMemberList" id="evaluator_user" value="">
                <datalist id="eventMemberList">
                <?php 
				$sqlss = 'select a.id,u.fname,u.user_id from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'"';
		 $qryss = db_query($sqlss);
		 while($dataa=mysqli_fetch_object($qryss)){
				?>
                <option><?=$dataa->fname?>#<?=$dataa->user_id?></option>
                <? } ?>
                </datalist>
                </div>
                <div style=" width: 30% !important;"><select class="section_name" name="evaluation_section" id="evaluation_section"><option></option><? foreign_relation('rfq_evaluation_section','id','section_name',$evaluation_section,'rfq_no="'.$_SESSION[$unique].'"')?></select></div>
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
						$sql = 'select a.id,u.fname,u.user_id,a.action from rfq_evaluation_team a, user_activity_management u where a.user_id=u.user_id and a.rfq_no="'.$_SESSION['rfq_no'].'" group by u.user_id';
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
  
 