<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title = "Organization Info";



$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');



$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');





 $cur = '&#x9f3;';

 



 $table1 = 'crm_project_org';

 $table2 = 'crm_task_lists';

 $table3 = 'crm_task_followup';

 $table4 = 'crm_org_contacts';

 

 

 require "../include/custom.php";

 

 $id = decrypTS($_GET['view']);

 $type = decrypTS($_GET['tp']);

 

 

 if(isset($_GET['del']) && $type == 'lead'){

     

     $del = decrypTS($_GET['del']);

     $delTaskQry = "DELETE FROM crm_task_lists WHERE id = '$del' AND project_id = '$id'";

     db_query($delTaskQry);

     

     $update_by = $_SESSION['employee_selected'];

     $update_at = date('Y-m-d h:s:i');

     

     $leadUpdateQry = "UPDATE crm_project_lead SET update_by = '$update_by', update_at = '$update_at' WHERE id = '$id'";

     

     echo '<script>location.href="crm_view.php?view='.encrypTS($id).'&tp='.encrypTS('lead').'";</script>';

 }

 



?>







    <div class="row">

        <div class="col-lg-12">

            

            <div class="card">

                

                

                <?php 

                //Lead View -Start-

                

                    if($type == 'lead'){

                    

                        $qry = "SELECT * FROM $table1 WHERE id = '$id'";

                        $rslt = db_query($qry);

                        if($rows = mysqli_fetch_object($rslt)){

                            

                ?>

                    

                        <div class="card-header" style="background:#f3f3f3;">

                            <h5>Organization Details <span class="float-right" style="font-size:11.5px;">[Status:<b> <?=find_a_field('crm_lead_status', 'status', 'id = "'.$rows->status.'"')?></b>]</span></h5>

                        </div>

                        

                        <div class="card-body">

                

                            <h5 class="card-title mb-2"><b>

                                <?=$rows->name?></b>

                                <span class="float-right">

                                    <!--<a href="../org/show_all_org.php" class="btn btn-primary text-light btn-sm"><i class="fa fa-arrow-left"></i> Go Back</a>-->

                                </span>

                            </h5>

                            <hr>

                            <div class="d-flex">

                                <div class="col-md-6">

                                    

                                    <?php if($rows->logo != NULL){ ?>

                                    <div class="col-md-3 mb-3 p-0">

                                        <img src="../lead_management/imgs/company_logo/<?=$rows->logo?>" width="82" height="76" style="border: 1px solid #b7b7b79e;">

                                    </div>

                                    <?php } ?>

                                    

                                    <p class="card-text"><b>Company</b>: <?=$rows->name?></p>

                                    

                                    <?php if($rows->description !=''){ ?>

                                        <p class="card-text"><b>Description</b>: <?=$rows->description?></p>

                                    <?php } ?>

    

                                    <p class="card-text"><b>Entry By</b>: <?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$rows->entry_by.'"')?></p>

                                    

                                    <?php if($rows->lead_type != 0){ ?>

                                        <p class="card-text"><b>Work Field</b>: <?=find_a_field('crm_lead_type', 'type', 'id = "'.$rows->lead_type.'"')?></p>

                                    <?php } ?>

                                    

                                    

                                    <h6 class="mt-2"><u>Office Address</u></h6>

                                    <span class="card-text"><b>Address</b>: <?php if($rows->address != ''){echo $rows->address.', ';} ?> 

                                        <?php if($rows->city != ''){echo $rows->city.', ';} ?>

                                        <?php if($rows->zip != 0){echo find_a_field('crm_postalcode_list', 'concat(po_name,"-",po_code)', 'id = "'.$rows->zip.'"').', ';} ?>

                                        <?php if($rows->country != 0){echo find_a_field('crm_country_management', 'country_name', 'id = "'.$rows->country.'"');} ?>

                                    </span>

                                    

                                    <?php if($rows->website !=''){ ?>

                                    <p class="card-text mt-1"><b>Website</b>: <a href="<?=$rows->website?>" target="_blank"><?=$rows->website?></a></p>

                                    <?php } ?>

                                    

                                    <?php if($rows->annual_revenue != 0.0){ ?>

                                    <p class="card-text mt-1"><b>Revenue</b>:

                                        <?=$rows->annual_revenue?>/year</p>

                                    <?php } ?>

                                    

                                    <?php if($rows->total_employees != 0){ ?>

                                    <p class="card-text mt-1"><b>Total Employee(s)</b>:

                                        <?=$rows->total_employees?></p>

                                    <?php } ?>

                                    

                                    <?php if($rows->lead_source !=''){ ?>

                                    <p class="card-text mt-1"><b>Source</b>:

                                        <?=find_a_field('crm_lead_source', 'source', 'id="'.$rows->lead_source.'"')?></p>

                                    <?php } ?>

    

                                </div>

                                

                                <div class="col-md-6 lead-contacts">

                                    

                                <?php 

                                

                                    $isContact = find_a_field($table4, 'count(*)', 'project_id = "'.$rows->id.'"'); 

                    

                                    if($isContact > 0){

                                

                                        $leadContactSql = "SELECT * FROM $table4 WHERE project_id = '$rows->id'";

                                        $leadContactRslt = db_query($leadContactSql);

                                        $i = 1;

                                        

                                        while($leadContacts = mysqli_fetch_object($leadContactRslt)){ 

                                

                                ?>

                                

                                                <h6 class="mt-2"><u>Contact</u> <small style="font-size: 11px;">(<?=$i?>)</small></h6>

                                                <span class="card-text"><b>Name</b>: <?=$leadContacts->contact_name?></span>

                                                <span class="card-text"><b>Designation</b>: <?=$leadContacts->contact_designation?></span>
												
												<span class="card-text"><b>Department</b>: <?=$leadContacts->department?></span>

                                                <span class="card-text"><b>Phone</b>: <a href="tel:<?=$leadContacts->contact_phone?>"><?=$leadContacts->contact_phone?></a></span>

                                                <span class="card-text"><b>Email</b>: <a href="mailto:<?=$leadContacts->contact_email?>"><?=$leadContacts->contact_email?></a></span>

                                    

                                <?php   

                                            

                                            $i++;

                                        }

                                        

                                        $flag = 1;

                                        

                                    }else{

                                        $flag = 0;

                                    }

                                

                                 

                                    if($flag == 0){ 

                                       echo '<h5 class="text-muted">No Contacts Found!</h5>';  

                                    }

                                 

                                ?>

                                    
                                    

                                </div>

                                

                            </div>

                            

                        </div>

                        

                        <hr>

                        

                        

                        

                        <div class="card-footer" style="background:#f3f3f3; margin:0!important;">

                            <!--<a href="../org/show.php?id=<?=$id?>" class="btn btn-warning mb-2" style="margin:0 auto;">Edit</a>-->

                        </div>

                    

                <?php 

                    

                        }

                        

                    }

                    

                //Lead View -End-    

                ?>

                

                

                <?php 

                //Task View -Start-

                

                    if($type == 'task'){

                    

                        $qry = "SELECT * FROM $table2 WHERE id = '$id'";

                        $rslt = db_query($qry);

                        if($rows = mysqli_fetch_object($rslt)){

                            

                ?>

                    

                        <div class="card-header" style="background:#f3f3f3;">

                            <h5>

                                <?=$CRMtaskName?> Details <span class="ml-2" style="font-size:11.5px;">[Status:<b> <?=find_a_field('crm_task_status', 'status', 'id = "'.$rows->status.'"')?></b>]</span>

                                

                                <span class="float-right">

                                    <a href="../task_management/show_all_tasks.php" class="btn btn-primary text-light btn-sm"><i class="fa fa-arrow-left"></i> Go Back</a>

                                    <a href="../task_management/show_all_tasks.php?update=" class="btn btn-success btn-sm mr-2 text-light">+ Add New</a>

                                </span>

                                

                                </h5>

                        </div>

                        

                        <div class="card-body">

                

                            <h5 class="card-title mb-2"><b><?=$rows->task_name?></b></h5>

                            <hr>

                            <div class="d-flex">

                                <div class="col-md-6">

                                    

                                    <p class="card-text"><b>Project</b>: <?=find_a_field('crm_project_lead', 'name', 'id="'.$rows->project_id.'"')?></p>

                                    

                                    <?php if($rows->description !=''){ ?>

                                        <p class="card-text"><b>Description</b>: <?=$rows->description?></p>

                                    <?php } ?>

    

                                    <span class="card-text"><b>Assigned To</b>: <?php echo find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$rows->assigned_person_id.'"').'<br>';?></span>

                                    <span class="card-text"><b>Assigned by</b>: <?php echo find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$rows->entry_by.'"').'<br>';?></span>

                                    

                                    <?php if($rows->contact_person != 0){ ?>

                                        <p class="card-text"><b>Contact Person</b>: <?=find_a_field('crm_lead_contacts', 'contact_name', 'id = "'.$rows->contact_person.'"')?></p>

                                    <?php } ?>

                                    

                                    <?php if($rows->purpose != ''){ ?>

                                        <p class="card-text"><b>Purpose</b>: <?=find_a_field('crm_task_purpose', 'purpose', 'id = "'.$rows->purpose.'"')?></p>

                                    <?php } ?>

                                    

                                    

                                    <h6 class="mt-2"><u>Task Schedule</u></h6>

                                    <span class="card-text"><b>Created at</b>: <?php if($rows->entry_at != ''){echo $rows->entry_at.'<br>';} ?> 

                                    </span>

                                    <span class="card-text"><b>Due Time</b>: <?php if($rows->to_time != ''){echo $rows->to_time.'<br>';} ?> 

                                    </span>

                                    <span class="card-text"><b>End Time</b>: <?php if($rows->update_at != ''){echo $rows->update_at;} ?> 

                                    </span>

                                    

                                    <?php if($rows->website !=''){ ?>

                                    <p class="card-text mt-1"><b>Website</b>: <a href="<?=$rows->website?>" target="_blank"><?=$rows->website?></a></p>

                                    <?php } ?>

                                    

                                    <?php if($rows->annual_revenue != 0.0){ ?>

                                    <p class="card-text mt-1"><b>Revenue</b>:

                                        <?=$rows->annual_revenue?>/year</p>

                                    <?php } ?>

                                    

                                    <?php if($rows->total_employees != 0){ ?>

                                    <p class="card-text mt-1"><b>Total Employee(s)</b>:

                                        <?=$rows->total_employees?></p>

                                    <?php } ?>

                                    

                                    <?php if($rows->lead_source !=''){ ?>

                                    <p class="card-text mt-1"><b>Source</b>:

                                        <?=find_a_field('crm_lead_source', 'source', 'id="'.$rows->lead_source.'"')?></p>

                                    <?php } ?>

                                    

    

                                </div>

                                

                                <div class="col-md-6 lead-contacts">

                                    

                                    <h6 class="mt-2"><u>Attachment</u></h6>

                                    <?php if($rows->attachment != NULL || $rows->attachment != ''){ ?>

                                            <a href="../task_management/imgs/task_attachment/<?=$rows->attachment?>" target="_blank"> <?=$rows->attachment?> </a>

                                    <?php }else{ ?>

                                        <span class="card-text text-muted">None!

                                    <?php } ?>

                                    </span>

                                    

                                </div>

                            </div>

                            

                        </div>

                        

                        <div class="card-footer" style="background:#f3f3f3; margin:0!important;">

                            <a href="111" class="btn btn-warning mb-2" style="margin:0 auto;">Edit</a>

                        </div>

                    

                <?php 

                    

                        }

                        

                    }

                    

                //Task View -End-    

                ?>

                

                

                <?php 

                //Employee View -Start-

                

                    if($type == 'employee'){

                    

                        $qry = "SELECT * FROM user_activity_management WHERE PBI_ID = '$id'";

                        $rslt = db_query($qry);

                        if($rows = mysqli_fetch_object($rslt)){

                            

                ?>

                    

                        <div class="card-header" style="background:#f3f3f3;">

                            <h5>

                                Working Progress of <?=$rows->fname?>

                                

                                <span class="float-right">

                                    <a href="../roll/roll.php" class="btn btn-primary text-light btn-sm"><i class="fa fa-arrow-left"></i> Go Back</a>

                                </span>

                                

                                </h5>

                        </div>

                        

                        <div class="card-body">

                

                            <h5 class="card-title mb-2"><b>Assigned Lead(s)</b>:</h5>

                            <hr>

                            

                            <div class="d-flex">

                                <div class="col-md-6">

                                    

                                </div>

                            </div>

                            

                        </div>

                        

                        <div class="card-footer" style="background:#f3f3f3; margin:0!important;">

                            <a href="#" class="btn btn-warning mb-2" style="margin:0 auto;">Edit</a>

                        </div>

                    

                <?php 

                    

                        }

                        

                    }

                    

                //Employee View -End-    

                ?>

                

            </div>

            

        </div>

    </div>







<?







require_once SERVER_CORE."routing/layout.bottom.php";







?>