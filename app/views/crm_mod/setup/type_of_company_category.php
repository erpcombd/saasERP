<?php 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Type Of Customer Category";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');
$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');

$table = 'crm_company_category';
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
    header("Location: type_of_company_category.php");
    exit();
}

require "../include/custom.php";
?>

<script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>

<!-- Navbar -->
<nav class="navbar navbar-light bg-light" style="box-shadow: 0 3px #888888;">
  <form class="form-inline" method="get">
        <div class="form-group">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search Category..." value="<?=isset($_GET['search'])?htmlspecialchars($_GET['search']):''?>">
        </div>
        <div class="form-group ml-2">
            <button class="btn btn-outline-primary btn-sm" type="submit">Search <i class="fa fa-search-plus"></i></button>
        </div>
  </form>

  <div>
        <a href="type_of_company_category.php?update=<?=encrypTS('new')?>" class="btn btn-outline-info btn-sm">Add New <i class="fa fa-plus-square"></i></a>
        <a href="type_of_company_category.php" class="btn btn-outline-warning btn-sm">Refresh <i class="fa fa-refresh"></i></a>
  </div>
</nav>

<!-- Main Section Start -->
<div class="row">
    <div class="col-md-12">
        <table id="example" class="table">
            <thead>
                <th>SN</th>
                <th>Category Name</th>
                <th>Entry By</th>
                <th>Entry At</th>
                <th>Action</th>
            </thead>
            <tbody>
            <?php 
                $sn = 1;
                $where = "1";
                if(isset($_GET['search']) && $_GET['search'] != ''){
                    $s = mysqli_real_escape_string($conn, $_GET['search']);
                    $where .= " AND category_name LIKE '%$s%'";
                }
                $qry = "SELECT * FROM $table WHERE $where ORDER BY id DESC";
                $rslt = db_query($qry);
                while($row = mysqli_fetch_object($rslt)){
            ?>
                <tr>
                    <td><?=$sn++?></td>
                    <td><?=$row->category_name?></td>
                    <td><?=find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID="'.$row->entry_by.'"')?></td>
                    <td><?=$row->entry_at?></td>
                    <td>
                        <a class="btn btn-sm" style="background-color: orange; color: white;" href="type_of_company_category.php?update=<?=encrypTS($row->id)?>">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
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
        <h5 class="modal-title">Customer Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="font-size:30px !important; color: red;">&times;</span>
        </button>
      </div>
      <form method="post">
      <div class="modal-body">
      <h5 class="text-center">Category Information</h5>
        <div class="row">
          <div class="col-md-12">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Category Name:</td>
                    <td><input type="text" name="category_name" class="form-control" value="<?=($datas)?$datas->category_name:''?>" style="border-left:3.5px solid #df5b5b!important;" required></td>
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
