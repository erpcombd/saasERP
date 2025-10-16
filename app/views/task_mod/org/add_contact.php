<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Add New Contact";

$user_name = find_a_field('user_activity_management','username','user_id="'.$_SESSION['user']['id'].'"');

$_SESSION['employee_selected'] = find_a_field('user_activity_management','PBI_ID','user_id="'.$_SESSION['user']['id'].'"');


 $cur = '&#x9f3;';
 
 
 
 
 $table = 'crm_lead_contacts';
 
 $crud = new crud($table);
 
 
 if(isset($_POST['insert'])){
     
     $_POST['entry_by'] = $_SESSION['employee_selected'];
     
     $crud->insert();
     
     echo '<script>location.href="show_all_leads.php?update='.encrypTS($_POST['project_id']).'"</script>';
 }
 
 if(isset($_POST['update'])){
     
     $_POST['update_by'] = $_SESSION['employee_selected'];
     $_POST['update_at'] = date('Y-m-d h:s:i');
     
     $crud->update('id');
     
     echo '<script>location.href="show_all_leads.php?update='.encrypTS($_POST['project_id']).'"</script>';
 }
 
 if(isset($_GET['del'])){
     $del = decrypTS($_GET['del']);
     $proID = decrypTS($_GET['pro']);
     $delQry = "DELETE FROM crm_lead_contacts WHERE id = '$del' AND project_id = '$proID'";
     db_query($delQry);
     echo '<script>location.href="show_all_leads.php?update='.encrypTS($proID).'"</script>';
 }
 
 
  require "../include/custom.php";
  
  
  if(isset($_GET['cid'])){
      $pID = decrypTS($_GET['cid']);
  }else if(isset($_GET['update'])){
      $datas = find_all_field($table, '', 'id="'.decrypTS($_GET['update']).'"');
      $pID = $datas->project_id;
  }
 

?>

    <script type="text/javascript" src="../../../assets/js/bootstrap.min.js"></script>
    
    
    
    
    <div class="row">
        <div class="col-12">
            
            <div class="card">
            
                <div class="card-header text-right">
                    
                    <a href="show_all_leads.php?update=<?=encrypTS($datas->project_id)?>" class="btn btn-warning btn-sm mr-2"><i class="fa fa-arrow-left"></i> Back</a>
                    
                    <a href="add_contact.php?del=<?=encrypTS($datas->id)?>&pro=<?=encrypTS($datas->project_id)?>" class="text-danger"><i class="fa fa-trash"></i></a> Remove
                </div>
            
                <div class="card-body col-md-6 mx-auto mt-3 mb-4">
                    
                    <form method="post">
                        
                        <input type="hidden" name="project_id" value="<?=$pID?>">
        
                        <div class="form-group">
                            <label>Contact Name <span class="text-danger">*</span></label>
                            <input type="text" name="contact_name" class="form-control" value="<?=$datas->contact_name?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Contact Phone <span class="text-danger">*</span></label>
                            <input type="text" name="contact_phone" class="form-control" value="<?=$datas->contact_phone?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Contact Email <span class="text-danger">*</span></label>
                            <input type="email" name="contact_email" class="form-control" value="<?=$datas->contact_email?>"required>
                        </div>
                        
                        <div class="form-group">
                            <label>Contact Designation <span class="text-danger">*</span></label>
                            <input type="text" name="contact_designation" class="form-control" value="<?=$datas->contact_designation?>" required>
                        </div>
                        
                        <?php if($datas->id > 0){ ?>
                            <input type="hidden" name="id" value="<?=$datas->id?>">
                            <input type="submit" class="btn btn-warning d-flex mx-auto" name="update" value="Update Contact">
                        <?php }else{ ?>
                        <input type="submit" class="btn btn-success d-flex mx-auto" name="insert" value="Add Contact">
                        <?php } ?>
                        
                    </form>
                
                </div>
                
            </div>
            
        </div>
    </div>
    
    
    
    
<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>


