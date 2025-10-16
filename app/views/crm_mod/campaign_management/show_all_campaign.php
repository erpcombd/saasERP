<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 


$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');


 $cur = '&#x9f3;';
 
 
 require "../include/custom.php";
 
 $title = "All ".$CRMcampaignName." List";
 
 
 $table1 = 'crm_campaign_management';
 
 $crud1 = new crud($table1);
 
 
 if(isset($_POST['insert'])){
 	$_POST['entry_at']=date('Y-m-d h:i:sa');
     
    $_POST['entry_by'] = $_SESSION['employee_selected'];
     
    $crud1->insert();
	
	header('Location: show_all_campaign.php');
    exit; 
	
	
 }
 
 
 if(isset($_POST['update'])){
     
    $_POST['update_by'] = $_SESSION['employee_selected'];
    $_POST['update_at'] = date('Y-m-d h:s:i');
     
    $crud1->update('id');
	
	header('Location: show_all_campaign.php');
    exit; 
    
 }
 

?>
 
    
    
        <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
    
    
        <div class="row well">
            <div class="col-md-12 text-right">
                <a href="../home/home.php" class="btn btn-warning" style="margin-top:12px; margin-bottom:14px;">Go Back</a>
                <a href="show_all_campaign.php?update=<?=encrypTS('new')?>" class="btn btn-success text-light" style="margin-top:12px; margin-bottom:14px;">+ Add New</a>
            </div>    
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <table id="example" class="table">
                    
                    <thead>
                        <th>SN</th>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Assigned to</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    
                    <?php 
                    
                        $sn = 1;
                        if(in_array($_SESSION['employee_selected'], $superID)){
                            $con = " 1 ";
                        }else{
                            $con = " camp_leader = '".$_SESSION['employee_selected']."' ";
                        }
                        
                        $campQry = "SELECT * FROM $table1 WHERE ".$con;
                        $rslt = db_query($campQry);
                        while($row = mysqli_fetch_object($rslt)){
                    
                    ?>
                    
                        <tr>
                            <td><?=$sn?></td>
                            <td><?=$row->camp_name?></td>
                            <td><?=$row->camp_platform?></td>
                            <td><?=$row->camp_result?></td>
                            <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$row->camp_leader.'"')?></td>
                            <td><?=$row->entry_at?></td>
                            <td class="d-flex">
                                <a class="btn btn-sm btn-info mr-2" href="../info_maker/crm_view.php?view=<?=encrypTS($row->id)?>&tp='<?=encrypTS('camp')?>'"><i class="fa-solid fa-eye"></i></a>
                                <a class="btn btn-sm btn-warning" href="show_all_campaign.php?update=<?=encrypTS($row->id)?>"><i class="fa-solid fa-pencil"></i></a>
                            </td>
                        </tr>
                    
                    <?php 
                    
                        $sn++;
                        
                        } 
                        
                    ?>
                    
                    </tbody>
                    <tfoot>
                        <td>SN</td>
                        <td>Name</td>
                        <td>Company</td>
                        <td>Status</td>
                        <td>Assigned to</td>
                        <td>Created at</td>
                        <td>Action</td>
                    </tfoot>
                    
                </table>   
                
            </div>
        </div>
    
 
        
        <!-- Campaign Module Modal Start Here -->
        
        <?php if(isset($_GET['update'])){ 
            $datas = find_all_field($table1, '', 'id="'.decrypTS($_GET['update']).' AND '.$con.'"'); 
            if(isset($datas)){$assigned_id = $datas->camp_leader;}else{$assigned_id = $_SESSION['employee_selected'];} 
        } ?>

        <div class="modal fade campaign-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    
          <div class="modal-dialog modal-lg">
        
            <div class="modal-content">
        
            <div class="modal-header">
        
                <h5 class="modal-title" id="exampleModalLongTitle"><?php if(isset($datas)){echo 'Update';}else{echo 'Create';}?> <?=$CRMcampaignName?></h5>
        
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        
                  <span aria-hidden="true" style="font-size:30px !important; color: red;">&times;</span>
        
                </button>
        
              </div>
        
              <form method="post">
        
              <div class="modal-body">
        
              <h5 class=text-center><?php if(isset($datas)){echo 'Update';}else{echo 'New';}?> <?=$CRMcampaignName?> Information</h5>
        
                <div class="row">
        
                    <div class="col-md-6">
        
                      <table class="table">
        
                        <tbody>
        
                          <tr>
        
                            <td>Name</td>
        
                            <td>
                              <input type="text" name="camp_name" id="camp_name" class="form-control" value="<?=$datas->camp_name?>">
                            </td>
        
                          </tr>
        
                          <tr>
        
                            <td>Leader </td>
        
                            <td>
                            <select name="camp_leader" id="camp_leader" class="form-control">
                                  <?php 
                                    
                                    if(in_array($_SESSION['employee_selected'], $superID)){ 
                                        foreign_relation('user_activity_management', 'distinct(PBI_ID)', 'fname', $datas->camp_leader, '1'); 
                                    }else{ 
                                        foreign_relation('user_activity_management', 'distinct(PBI_ID)', 'fname', $assigned_person_id, 'PBI_ID="'.$assigned_id.'"'); 
                                    }
                                    
                                ?>
                                </select>
                             
                            </td>
        
                          </tr>
                          <tr>
                            <td>Team</td>
                            <td>
                              <select name="camp_team" id="camp_team"  class="form-control" >
                               <?php foreign_relation('user_activity_management','distinct(PBI_ID)','fname',$camp_team,'1') ?>
                              </select>
                            </td>
                          </tr>
                          
                          <tr>
        
                              <td>From</td>
        
                              <td>
                                <input type="date" name="camp_from" id="camp_from" class="form-control" value="<?=$datas->camp_from?>">
                              </td>
        
                            </tr>
        
                        </tbody>
        
                      </table>
        
                    </div>
        
                    <div class="col-md-6">
        
                      <table class="table">
        
                        <tbody>
        
                          <tr>
        
                              <td>Platform</td>
        
                              <td>
                                  <input type="text" name="camp_platform" id="camp_platform" class="form-control" value="<?=$datas->camp_platform?>">
                              </td>
        
                          </tr>
                          <tr>
                            <td>Budget</td>
                            <td>
                              <input type="text" name="camp_budget" id="camp_budget" class="form-control" value="<?=$datas->camp_budget?>">
                            </td>
                          </tr>
                          
                            
                            <tr>
        
                              <td>Result</td>
        
                              <td>
                                  <select name="camp_result" class="form-control">
                                      <option <?php if($datas->camp_result == 'Successful'){echo 'selected';}?>>Successful</option>
                                      <option <?php if($datas->camp_result == 'Failed'){echo 'selected';}?>>Failed</option>
                                      <option <?php if($datas->camp_result == 'Pending'){echo 'selected';}?>>Pending</option>
                                  </select>
                              </td>
        
                            </tr>
                            
                            <tr>
        
                              <td>To</td>
        
                              <td>
                                <input type="date" name="camp_to" id="camp_to" class="form-control" value="<?=$datas->camp_to?>">
                              </td>
        
                            </tr>
							
							
                          
        
                        </tbody>
        
                      </table>
        
                    </div>
					
					<div class=""col-12>
					<table class="table">
        
                        <tbody>
					
					<tr>
							
							<td width="30%"> <label for="message text-center">Description Information</label></td>
							
							<td>
							
        
                    <textarea name="description" class="form-control" cols="70" rows="4"><?=$datas->camp_name?></textarea>
        
							
							</td>
							
							
							</tr>
							</tbody>
							</table>
					
					</div>
        
                </div>
        
              </div> 
        
              <div class="row mb-3">
        
                  <div class="form-group  m-0 m-auto">
        
                   
                  </div>
        
                </div>     
        
                  <?php if(!isset($datas)){ ?>
                  <div class="modal-footer">
                    <a type="button" class="btn btn-secondary text-light" data-dismiss="modal" style= " background-color: #FF0000;">Close</a>
                    <button type="submit" class="btn btn-primary" name="insert">Save</button>
                  </div>
                  <?php }else{ ?>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?=$datas->id?>">
                        <a type="button" class="btn btn-secondary text-light" data-dismiss="modal" style= " background-color: #FF0000;">Close</a>
                        <button type="submit" class="btn btn-warning" name="update">Update</button>
                    </div>
                  <?php } ?>
        
              </form>
        
            </div>
        
          </div>
        
        </div>
    
        <!-- Campaign Module Modal End Here --> 
        
        
<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>


<?php if(isset($_GET['update'])){ ?>
    <script>
        $('.campaign-modal-lg').modal('show');
    </script>
<?php } ?>