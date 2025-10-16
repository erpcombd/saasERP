<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Update Schedule Call';

$condition="id=".$_GET['id'];
$data=db_fetch_object('crm_lead_activity',$condition);
while (list($key, $value)=@each($data)){ $$key=$value;}



if(isset($_POST['scCall'])){
db_query('update crm_lead_activity set main=0 where id="'.$_GET['id'].'"');

$crud   = new crud('crm_lead_activity');
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date("Y-m-d H:i:s");
$crud->insert();

echo "<script>window.top.location='lead_task.php'</script>";
}




?>


						  <div class="modal-dialog" role="document">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Update Schedule to Log call</h5>
								<button type="button"  onclick="window.location='lead_task.php'" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
								  Back
								</button>
								
							  </div>
							  <form method="post">
							  <div class="modal-body">
							  
							  		<input type="hidden" name="call_main" value="Log" />
									<input type="hidden" name="main" value="0" />
									<input type="hidden" name="activity_type" value="Call" />
														
								<div class="form-group row m-0 pt-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Select Lead:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
									  <select class="form-control req" name="lead_id" id="lead_id" >
                                        <? foreign_relation('crm_project_org o,crm_project_lead l,crm_lead_products p','l.id','concat(o.id,"-",o.name,"##(",p.products,")")',$lead_id,'l.organization=o.id and l.product=p.id and l.id='.$lead_id); ?>
                                      </select>
									</div>
								</div>
								
								
							
								<div class="form-group row m-0 pt-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call to:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">

											<input class="form-control req" name="call_to" id="call_to" value="<?=$call_to?>">
									</div>
								</div>
								
								
								
								<div class="form-group row m-0 pt-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call type:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
											<select class="form-control req" name="call_type" required>
												<option></option>
												<option value="Inbounde Call" <?=($call_type=='Inbounde Call')? 'selected' :''?>>Inbounde Call</option>
												<option value="Outbound Call"  <?=($call_type=='Outbound Call')? 'selected' :''?>>Outbound Call</option>
											</select>
									</div>
								</div>
								
								<div class="form-group row m-0 pt-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Date:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input type="date" name="date" id="date" value="<?=$date?>" class="form-control req" />
									</div>
								</div>
								
								<div class="form-group row m-0 pt-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Time:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input type="time" name="time" id="time" value="<?=$time?>" class="form-control req" />
									</div>
								</div>
									
																	
								<div class="form-group row m-0 pt-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Duration:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input type="text" name="call_duration" id="call_duration" value="" class="form-control req" />
									</div>
								</div>
									

								<div class="form-group row m-0 pt-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Call Purpose:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<input type="text" name="subject" id="subject" value="<?=$subject?>" class="form-control req" />
									</div>
								</div>
								
							<div class="form-group row m-0 pt-1">
									<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-start align-items-center pr-1 bg-form-titel-text">Note:</label>
									<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
										<textarea class="form-control req1" name="details"><?=$details?></textarea>
									</div>
								</div>
								
																


							  </div>
							  <div class="modal-footer">
								<button type="submit" name="scCall" class="btn1 btn1-bg-submit">Update </button>
							  </div>
							  </form>
							  
							</div>
						  </div>
					



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>




