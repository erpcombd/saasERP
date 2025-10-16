<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Add New Contact";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');


 $cur = '&#x9f3;';
 
 
 $table = 'crm_roll_assign';
 
 $crud = new crud($table);
 
 
 
 require "../include/custom.php";
 
 
?>
 
 

    <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
    
    
    <div class="row">
        <div class="col-md-12 text-right mt-2 mb-3">
            <a href="assign_role.php?update=" class="btn btn-md btn-success text-light">+ Add New</a>
        </div>
        <div class="col-md-12">
            <table class="table" id="example">
                
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Name</th>
                        <th>PBI_ID</th>
                        <th>Access</th>
                        <th>Entry by</th>
                        <th>Entry at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    <?php
                    
                    $sn = 1;
                    $allEmployeeQry = "SELECT * FROM $table";
                    $allEmployeeRslt = db_query($allEmployeeQry);
                    while($allEmployee = mysqli_fetch_object($allEmployeeRslt)){
                        
                    ?>
                    
                        <tr>
                            <td><?=$sn?></td>
                            <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$allEmployee->PBI_ID.'"')?></td>
                            <td><?=$allEmployee->PBI_ID?></td>
                            <td><?php if($allEmployee->access==1){echo 'Yes';}else{echo 'No';}?></td>
                            <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$allEmployee->entry_by.'"')?></td>
                            <td><?=$allEmployee->entry_at?></td>
                            <td>
                                <a class="btn btn-warning btn-sm" href="assign_role.php?update=<?=encrypTS($allEmployee->id)?>"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    
                    <?php $sn++; } ?>
                    
                </tbody>
                
                <tfoot>
                    <tr>
                        <td>SN</td>
                        <td>Name</td>
                        <td>PBI_ID</td>
                        <td>Access</td>
                        <td>Entry by</td>
                        <td>Entry at</td>
                        <td>Action</td>
                    </tr>
                </tfoot>
                
            </table>
        </div>
    </div>
    
    
    
<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>