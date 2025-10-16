<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "All Activity List";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');


 $cur = '&#x9f3;';
 
 
 require "../include/custom.php";
 
 
 $table = 'crm_lead_activity_type';
 
 $crud = new crud($table);
 
 
 if(isset($_POST['insert'])){
     
     $_POST['entry_by'] = $_SESSION['employee_selected'];
     
     $crud->insert();

     
 }
 
 if(isset($_POST['update'])){
     
     $_POST['update_by'] = $_SESSION['employee_selected'];
     $_POST['update_at'] = date('Y-m-d h:s:i');
     
     $crud->update('id');
 }
 
 
 $datas = find_all_field($table, '', 'id="'.$_GET['update'].'"');
 

?>



    <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
    
    
    <div class="row">
        <div class="col-md-8">
            
            <table id="example">
                <thead>
                    <tr>
                        <th>Sn</th>
                        <th>Activity Name</th>
                        <th>Entry by</th>
                        <th>Entry at</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    <?php
                    
                        $productsQry = "SELECT * FROM $table ORDER BY id";
                        $productRslt = db_query($productsQry);
                        $sn = 1;
                        while($products = mysqli_fetch_object($productRslt)){
                            
                    ?>
                    
                    <tr onclick="window.location='crm_company_activies.php?update=<?=$products->id?>';">
                        <td><?=$sn?></td>
                        <td><?=$products->activity_name?></td>
                        <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID="'.$products->entry_by.'"')?></td>
                        <td><?=$products->entry_at?></td>
                    </tr>
                    
                    <?php $sn++; } ?>
                    
                </tbody>

            </table>
            
        </div>
        <div class="col-md-4">
            <div class="text-right mt-3">
                <a onclick="window.location='crm_company_activies.php'" class="btn btn-success text-light">+ Add New</a>
            </div>
            <form method="post">
            <div class="card">
                <div class="card-header"><h5>Add/Update Activity</h5></div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Activity Name</label>
                        <input type="text" name="activity_name" value="<?=$datas->activity_name?>" required>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <?php if($datas->id > 0){ ?>
                    <input type="hidden" value="<?=$datas->id?>" name="id">
                    <input type="submit" value="Update" name="update" class="btn btn-warning mx-auto mb-3">
                    <?php }else{ ?>
                    <input type="submit" value="Insert" name="insert" class="btn btn-info mx-auto mb-3">
                    <?php } ?>
                </div>
            </div>
            </form>
        </div>
    </div>
    
    

<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>