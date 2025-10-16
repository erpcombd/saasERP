<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title = "View Request Status";


$datas = find_all_field('it_support_request', '', 'id="'.$_GET['view'].'"');

if(($datas->status >= 3 && $datas->status <=5) && $datas->has_seen==0){
    
    $upSeenStat = "UPDATE it_support_request SET has_seen = '1' WHERE id='".$datas->id."'";
    db_query($upSeenStat);
    
}

?>


    <style>
        td {
            padding: 7px!important;
        }
    </style>

    
    <div class="row well">
        <div class="col-xs-12 text-right">
            <a href="request_status.php" class="btn btn-md btn-warning" style="margin-top:8px;"><i class="glyphicon glyphicon-arrow-left"></i> Back</a>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            
            <div class="container">
                <div class="card">
                    
                    <div class="card-header">
                        <h3>Support Ticket View #<?=$datas->request_id?></h3>
                    </div>
                    
                    <div class="card-body">
                        
                        <table width="45%" style="margin-top:35px; margin-right: 20px; float:left; border-right: 2px solid #dfdfdf;">
                            <tbody>
                                
                                <tr>
                                    <th width="50%">Issue:</th>
                                    <td width="50%"><?=$datas->subject?></td>
                                </tr>
                                
                                <?php if($datas->subcategory > 0 && $datas->subcategory != NULL){ ?>
                                <tr>
                                    <th width="50%">Subcategory:</th>
                                    <td width="50%" class="text-right"><?=find_a_field('it_support_subcategory', 'name', 'id="'.$datas->subcategory.'"')?> <?=find_a_field('it_support_subcategory a, it_support_category b', 'b.name', 'a.id="'.$datas->subcategory.'" AND b.id=a.category')?></td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($datas->otherNeed > 0 && $datas->otherNeed != NULL){ ?>
                                <tr>
                                    <th width="50%">Unlisted Item:</th>
                                    <td width="50%" class="text-right"><?=$datas->otherNeed?></td>
                                </tr>
                                <?php } ?>
                                
                                <tr>
                                    <th width="50%">Description:</th>
                                    <td width="50%" class="text-right" style="word-break: break-all;"><?=$datas->note?></td>
                                </tr>
                                
                                <?php if($datas->PBI_ID != find_a_field('user_activity_management', 'PBI_ID', 'user_id="'.$datas->entry_by.'"')){ ?>
                                <tr>
                                    <th width="50%">Request For:</th>
                                    <td width="50%" class="text-right"><?=find_a_field('user_activity_management', 'concat(fname," (",username,")")', 'PBI_ID="'.$datas->PBI_ID.'"')?></td>
                                </tr>
                                
                                <tr>
                                    <th width="50%">Entry By:</th>
                                    <td width="50%" class="text-right"><?=find_a_field('user_activity_management', 'concat(fname," (",username,")")', 'user_id="'.$datas->entry_by.'"')?></td>
                                </tr>
                                <?php }else if($datas->PBI_ID == $_SESSION['employee_selected']){ ?> 
                                
                                <tr>
                                    <th width="50%">Requested by:</th>
                                    <td width="50%" class="text-right"> <b>Self</b> </td>
                                </tr>
                                
                                <?php }else{ ?>
                                
                                <tr>
                                    <th width="50%">Requested by:</th>
                                    <td width="50%" class="text-right"><?=find_a_field('user_activity_management', 'concat(fname," (",username,")")', 'PBI_ID="'.$datas->PBI_ID.'"')?></td>
                                </tr>
                                
                                <?php } ?>
                                
                                <tr>
                                    <th width="50%">Entry at:</th>
                                    <td width="50%" class="text-right"><?=$datas->entry_at?></td>
                                </tr>
                                
                                <?php if($datas->attachment!=''){ ?>
                                 <tr>
                                    <th width="50%">View Attachement: </th>
                                    <td width="50%" class="text-right">
                                        <?php 
                                        $attachments = explode(',', $datas->attachment);
                                        foreach ($attachments as $attachment) { ?>
                                            <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$attachment?>&folder=support_ticketing&proj_id=<?=$_SESSION['proj_id']?>" class="btn btn-primary btn-xs" style="margin-right: 5px;" target="_blank"><?=htmlspecialchars($attachment)?></a>
                                        <?php } ?>
                                    </td>
                                    
                                </td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($datas->update_by > 0 && $datas->update_by != NULL){ ?>
                                <tr>
                                    <th width="50%">Updated by:</th>
                                    <td width="50%" class="text-right"><?php if($datas->update_by!=NULL){echo find_a_field('user_activity_management', 'username', 'user_id="'.$datas->update_by.'"');}else{echo 'None';}?></td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($datas->update_at!='0000-00-00 00:00:00' && $datas->update_at != NULL){ ?>
                                <tr>
                                    <th width="50%"><?php if($datas->assigned_to!=NULL && ($datas->status==3||$datas->status==4||$datas->status==5)){echo 'Responded at:';}else{echo 'Updated at:';} ?></th>
                                    <td width="50%" class="text-right"><?php if($datas->update_at!='0000-00-00 00:00:00'){echo $datas->update_at;}else{echo '--:--';}?></td>
                                </tr>
                                <?php } ?>
                                
                               
                                
                            </tbody>
                        </table>
                        
                        
                        <table width="50%" style="margin-top:35px; float:left;">
                            <tbody>
                                
                                <tr>
                                    <th width="50%">Request Type:</th>
                                    <td width="50%"><?=find_a_field('it_support_type', 'name', 'id="'.$datas->type.'"')?></td>
                                </tr>
                                
                                <tr>
                                    <th width="50%">Request Priority:</th>
                                    <td width="50%"><b><?=find_a_field('it_support_priority', 'name', 'id="'.$datas->priority.'"')?></b></td>
                                </tr>
                                
                                <?php if($datas->device != NULL){ ?>
                                <tr>
                                    <th width="50%">Device:</th>
                                    <td width="50%" class="text-right"><?php if($datas->device == 0){echo 'Personal';}else{echo find_a_field('it_support_devices', 'concat(name," (",serial,")")', 'id = "'.$datas->device.'"');} ?></td>
                                </tr>
                                <?php } ?>
                                
                                <?php if($datas->otherNeed > 0 && $datas->otherNeed != NULL){ ?>
                                <tr>
                                    <th width="50%">Unlisted Item:</th>
                                    <td width="50%" class="text-right"><?=$datas->otherNeed?></td>
                                </tr>
                                <?php } ?>
                                
                                <tr>
                                    <th>Assigned By:</th>
                                    <td><?php if($datas->assigned_to!=NULL){echo find_a_field('user_activity_management', 'username', 'PBI_ID="'.$datas->assigned_to.'"');}else{echo 'None';}?></td>
                                </tr>
                                
                                <tr>
                                    <th>Assigned At:</th>
                                    <td><?php if($datas->assigned_at!='0000-00-00 00:00:00'){echo $datas->assigned_at;}else{echo '--:--';}?></td>
                                </tr>
                                
                                <tr>
                                    <th>Status:</th>
                                    <td><?php if($datas->status > 0){echo find_a_field('it_support_status', 'name', 'id="'.$datas->status.'"');}else{echo 'Pending';}?></td>
                                </tr>
                                
                                <tr>
                                    <th>Remarks:</th>
                                    <td><?php if($datas->remarks != NULL){echo $datas->remarks;}else{echo 'None!';}?></td>
                                </tr>
                                
                                
                            </tbody>
                        </table>
                        
                    </div>
                    
                    <div class="card-footer">
                        <p></p>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>



<?php
require_once SERVER_CORE."routing/layout.bottom.php";

?>