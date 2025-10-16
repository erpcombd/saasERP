<?php 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Lead Status Management";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');
$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"' );

$table = 'crm_lead_status';
$crud  = new crud($table);

// Insert
if(isset($_POST['insert'])){
    $_POST['entry_by'] = $_SESSION['employee_selected'];
    $crud->insert();
}

// Update
if(isset($_POST['update'])){
    $_POST['update_by'] = $_SESSION['employee_selected'];
    $_POST['update_at'] = date('Y-m-d H:i:s');
    $crud->update('id');
    header("Location: status_of_lead.php");
    exit();
}

require "../include/custom.php";

// Get filter value
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
?>

<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>

<nav class="navbar navbar-light bg-light" style="box-shadow: 0 3px #888888;">
  <form class="form-inline" method="get">
        <div class="form-group">
        <select name="filter_status" class="custom-select" style="height:33px!important; padding:0px 28px">
          <option value="" <?=($filter_status=='')?'selected':''?>>--Select One--</option>
          <option value="Active" <?=($filter_status=='Active')?'selected':''?>>Active</option>
          <option value="Inactive" <?=($filter_status=='Inactive')?'selected':''?>>Inactive</option>
          <option value="No Bid" <?=($filter_status=='No Bid')?'selected':''?>>No Bid</option>
          <option value="Working / In Progress" <?=($filter_status=='Working / In Progress')?'selected':''?>>Working / In Progress</option>
          <option value="Proposal" <?=($filter_status=='Proposal')?'selected':''?>>Proposal</option>
          <option value="Negotiation" <?=($filter_status=='Negotiation')?'selected':''?>>Negotiation</option>
          <option value="Qualified" <?=($filter_status=='Qualified')?'selected':''?>>Qualified</option>
          <option value="Win" <?=($filter_status=='Win')?'selected':''?>>Win</option>
          <option value="Lost" <?=($filter_status=='Lost')?'selected':''?>>Lost</option>
          <option value="Closed" <?=($filter_status=='Closed')?'selected':''?>>Closed</option>
          <option value="Junk" <?=($filter_status=='Junk')?'selected':''?>>Junk</option>
        </select>
        </div>
        <div class="form-group ml-2">
            <button class="btn btn-outline-primary btn-sm" type="submit">Search <i class="fa fa-search-plus" aria-hidden="true"></i></button>
        </div>
  </form>

  <div style="right;!important;">
        <a href="status_of_lead.php?update=<?=encrypTS('new')?>" class="btn btn-outline-info btn-sm">Add New <i class="fa fa-plus-square" aria-hidden="true"></i></a>
        <a href="status_of_lead.php" class="btn btn-outline-warning btn-sm">Refresh <i class="fa fa-refresh" aria-hidden="true"></i></a>
  </div>
</nav>

<!-- Main Section Start -->
<div class="row">
    <div class="col-md-12">
        <table id="example" class="table">
            <thead>
                <th>SN</th>
                <th>Status</th>
                <th>Probability</th>
                <th>Total Lead</th>
                <th>Entry By</th>
                <th>Entry At</th>
                <th>Action</th>
            </thead>
            <tbody>
            <?php 
                $sn = 1;
                $leadsQry = "SELECT * FROM $table WHERE 1";
                if($filter_status != ''){
                    $leadsQry .= " AND status = '".mysqli_real_escape_string($conn, $filter_status)."'";
                }
                $rslt = db_query($leadsQry);
                while($row = mysqli_fetch_object($rslt)){
            ?>
                <tr>
                    <td><?=$row->id?></td>
                    <td><?=$row->status?></td>
                    <td><?=$row->probability?></td>
                    <td>
                        <a href="../report/master_report.php?report=202&&lead_status=<?=$row->id?>" target="_blank">
                            <button type="button" class="btn btn-info btn-sm">
                                <?=find_a_field('crm_project_lead','count(status)','status="'.$row->id.'"');?>
                            </button>
                        </a>
                    </td>
                    <td><?=find_a_field('user_activity_management', 'fname', 'PBI_ID = "'.$row->entry_by.'"')?></td>
                    <td><?=$row->entry_at?></td>
                    <td>
                        <a class="btn btn-sm btn-orange" style="background-color: orange; color: white;" href="status_of_lead.php?update=<?=encrypTS($row->id)?>">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                </tr>
            <?php $sn++; } ?>
            </tbody>
        </table>   
    </div>
</div>

<!-- Modal Start Here -->
<?php 
if(isset($_GET['update'])){
    if(decrypTS($_GET['update']) == 'new'){
        $datas = null; // Add New = empty fields
    }else{
        $datas = find_all_field($table,'','id="'.decrypTS($_GET['update']).'"'); 
    }
} 
?>
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Status of Lead</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="font-size:30px !important; color: red;">&times;</span>
        </button>
      </div>
      <form method="post">
      <div class="modal-body">
      <h5 class="text-center">Lead Status Information</h5>
        <div class="row">
          <div class="col-md-12">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Status of Lead:</td>
                    <td><input type="text" name="status" class="form-control" value="<?=($datas)?$datas->status:''?>" style="border-left:3.5px solid #df5b5b!important;" <?=($datas)?'readonly':''?> required></td>
                  </tr>
                  <tr>
                    <td>Probability(%):</td>
                
                    <td><input type="number" name="probability" class="form-control" value="<?=($datas)?$datas->probability:''?>" style="border-left:3.5px solid #df5b5b!important;" <?=($datas)?'readonly':''?> required></td>
                  </tr>
                  <tr>
                    <td>Status:</td>
                    <td>
                      <select name="is_active" class="form-control" style="border-left:3.5px solid #df5b5b!important;" required>
                        <option value="">--Select--</option>
                        <option value="Active" <?=($datas && $datas->lead_status=='Active')?'selected':''?>>Active</option>
                        <option value="Inactive" <?=($datas && $datas->lead_status=='Inactive')?'selected':''?>>Inactive</option>
                      </select>
                    </td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>   
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-secondary text-light" data-dismiss="modal" style="background-color: #FF0000;">Close</a>
        <?php if(!$datas){ ?>
            <button type="submit" class="btn btn-primary" name="insert">Save</button>
        <?php }else{ ?>
            <input type="hidden" name="id" value="<?=$datas->id?>">
            <button type="submit" class="btn btn-warning" name="update">Update</button>
        <?php } ?>
      </div>
      </form>
    </div>
  </div>
</div>

<?php
require_once SERVER_CORE."routing/layout.bottom.php";
?>

<?php if(isset($_GET['update'])){ ?>
<script>
    $('.bd-example-modal-lg').modal('show');
</script>
<?php } ?>
