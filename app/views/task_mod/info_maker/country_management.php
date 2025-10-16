<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "All Country List";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');


 $today = date('Y-m-d');

 $lastdays = date("Y-m-d", strtotime("-7 days", strtotime($today)));

 $cur = '&#x9f3;';
 
 
 
 
 $table1 = 'crm_country_management';
 
 $crud1 = new crud($table1);
 
 
 if(isset($_POST['insert'])){
     
     $_POST['entry_by'] = $_SESSION['employee_selected'];
     
     $crud1->insert();
 }
 
 if(isset($_POST['update'])){
     
     $_POST['update_by'] = $_SESSION['employee_selected'];
     $_POST['update_at'] = date('Y-m-d h:s:i');
     
     $crud1->update('id');
 }
 

 
 require "../include/custom.php";

?>
 <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
  
<nav class="navbar navbar-light bg-light" style="box-shadow: 0 3px #888888;">
  <form class="form-inline">
        <div class="form-group">
        <select class="custom-select" style="height:33px!important; padding:0px 28px">
          <option selected>--Select One--</option>
          <option value="1">One</option>
          <option value="2">Two</option>
          <option value="3">Three</option>
        </select>
        </div>
        <div class="form-group ml-2">
            <button class="btn btn-outline-primary btn-sm" type="submit">Search <i class="fa fa-search-plus" aria-hidden="true"></i></button>
        </div>
  </form>

    <div style="right;!important;">
            
                <a href="country_management.php?update=<?=encrypTS('new')?>" class="btn btn-outline-info btn-sm">Add New <i class="fa fa-plus-square" aria-hidden="true"></i></a>
                <a href="country_management.php" class="btn btn-outline-warning btn-sm">Refresh <i class="fa fa-refresh" aria-hidden="true"></i></a>
        </div>
</nav>



<!-- Main Section Start -->
<div class="row">
        <div class="col-md-12">
            <table id="example" class="table">
                
                <thead>
                    <th>SN</th>
                    <th>Country Name</th>
                    <th>Leads Count</th>
                    <th>Entry by</th>
                    <th>Entry at</th>
                    <th>Action</th>
                </thead>
                <tbody>
                
                <?php 
                
                    $sn = 1;
 
                    $leadsQry = "SELECT * FROM $table1 WHERE 1";
                    $rslt = db_query($leadsQry);
                    while($row = mysqli_fetch_object($rslt)){
                
                ?>
                
                    <tr>
                        <td><?=$row->id?></td>
                        <td><?=$row->country_name ?></td>
                        <td><a class="btn btn-info btn-sm" href="#"><?=find_a_field('crm_project_lead', 'count(*)', 'country="'.$row->id.'"')?></a></td>
                        <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$row->entry_by.'"')?></td>
                        <td><?=$row->entry_at?></td>
                        <td><a class="btn btn-sm <?php if($row->is_active=='1'){echo 'btn-warning';}else{echo 'btn-danger';}?>" href="country_management.php?update=<?=encrypTS($row->id)?>"><i class="fa-solid fa-pencil"></i></a></td>
                    </tr>
                
                <?php 
                
                    $sn++;
                    
                    } 
                    
                ?>
                
                </tbody>
                <tfoot>
                    <td>SN</td>
                    <td>Country Name</td>
                    <td>Leads Count</td>
                    <td>Entry by</td>
                    <td>Entry at</td>
                    <td>Action</td>
                </tfoot>
                
            </table>   
            
        </div>
    </div>




    <!-- Modal Start Here -->
    <?php if(isset($_GET['update'])){$datas = find_all_field($table1,'','id="'.decrypTS($_GET['update']).'"');} ?>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Country Management</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="post">
          <div class="modal-body">
          <h5 class=text-center>Country Information</h5>
            <div class="row">
             
            <div class="col-md-12">
                  <table class="table">
                    <tbody>
                      
                      <tr>
                        <td>Country Name: </td>
                        <td><input type="text" name="country_name" class="form-control" value="<?=$datas->country_name?>" style="border-left:3.5px solid #df5b5b!important;" required></td>
                      </tr>

                      <tr>
                        <td>Status:</td>
                        <td>
                          <select name="is_active" id="is_active" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required>
                            <option value="1" <?php if($datas->is_active=='1'){echo 'selected';} ?>>Active</option>
                            <option value="0" <?php if($datas->is_active=='0'){echo 'selected';} ?>>Inactive</option>
                          </select>
                        </td>
                      </tr>

                    </tbody>
                </table>
            </div>
                
            </div>   
          </div>
          
          <?php if(!isset($datas)){ ?>
          <div class="modal-footer">
            <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-primary" name="insert">Save</button>
          </div>
          <?php }else{ ?>
            <div class="modal-footer">
                <input type="hidden" name="id" value="<?=$datas->id?>">
                <a type="button" class="btn btn-secondary text-light" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-warning" name="update">Update</button>
            </div>
          <?php } ?>
          
          </form>
          
        </div>
      </div>
    </div>

<!-- Main Section ENd -->








<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>


<?php if(isset($_GET['update'])){ ?>
    <script>
        $('.bd-example-modal-lg').modal('show');
    </script>
<?php } ?>

