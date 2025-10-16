<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


$title = "Driver Info";



$page = 'driver_info.php';



$table = 'vehicle_driver_info';

$crud = new crud($table);
$update_id = $_GET['update'];




if(isset($_POST['insert'])){
    
    
    	$nid_file = $_FILES['nid_file']['name'];

        if ($nid_file != '') {
            
          $nid_no = $_POST['licence_number'];

          $ext = end(explode('.', $_FILES['nid_file']['name']));
          $path = '../../../../media_attachment/vehicle/driver_nid/';
          move_uploaded_file($_FILES['nid_file']['tmp_name'], $path . $nid_no . '.' . $ext);
          
          $_POST['nid_file'] = $nid_no.'.'.$ext;
        }
        
        
        
        
       	$licence_file = $_FILES['licence_file']['name'];

        if ($licence_file != '') {
            
          $licence_no = $_POST['licence_number'];

          $ext = end(explode('.', $_FILES['licence_file']['name']));
          $path = '../../../../media_attachment/vehicle/driver_licence/';
          move_uploaded_file($_FILES['licence_file']['tmp_name'], $path . $licence_no . '.' . $ext);
          
          $_POST['licence_file'] = $licence_no.'.'.$ext;
        }
        
        
        
        
        
       
        
        
    $_POST['entry_by'] = $_SESSION['user']['id'];

    

        

        $crud->insert();

        

        echo "<script>location.href='driver_list.php';</script>";

        exit;

        


}









if(isset($_POST['update'])){
    
   
    $id = $_POST['id'];
    
    	$nid_file = $_FILES['nid_file']['name'];

        if ($nid_file != '') {
        
            
          $nid_no = $_POST['licence_number'];

          $ext = end(explode('.', $_FILES['nid_file']['name']));
          $path = '../../../../media_attachment/vehicle/driver_nid/';
          
          $prev_nid_file= $_POST['existing_nid_file'];
            if (file_exists($path . $prev_nid_file)) {
            unlink($path . $prev_nid_file);
        }

          
          move_uploaded_file($_FILES['nid_file']['tmp_name'], $path . $nid_no . '.' . $ext);
          
          $_POST['nid_file'] = $nid_no.'.'.$ext;
        }
        
        
        
        
       	$licence_file = $_FILES['licence_file']['name'];

        if ($licence_file != '') {
            
         
            
          $licence_no = $_POST['licence_number'];

          $ext = end(explode('.', $_FILES['licence_file']['name']));
          $path = '../../../../media_attachment/vehicle/driver_licence/';
          
          
           $prev_licence_file= $_POST['existing_licence_file'];
            if (file_exists($path . $prev_licence_file)) {
            unlink($path . $prev_licence_file);
        }
          
          
          move_uploaded_file($_FILES['licence_file']['tmp_name'], $path . $licence_no . '.' . $ext);
          
          $_POST['licence_file'] = $licence_no.'.'.$ext;
        }
        



    $_POST['update_by'] = $_SESSION['user']['id'];

    $_POST['update_at'] = date('Y-m-d H:i:s');



    $crud->update('id');

}





if(isset($_POST['remove'])){

    

    $qry = "DELETE FROM $table WHERE id = '".$_POST['id']."'";

    db_query($qry);

    

    echo "<script>location.href='".$page."';</script>";

    exit;

}







$data = find_all_field($table, '', 'id="'.$_GET['update'].'"');


?>


    <style>

        td {

            text-align: center!important;

        }
         body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 700px;
            margin-top: 30px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

    </style>

<div class="container">
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h4>Add Vehicle</h4>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="">
                <input name="id" id="id" type="hidden" class="form-control" value='<?=$update_id ?>' >
                    <div class="mb-3">
                        <label class="form-label">Driver Name <span class="text-danger">*</span></label>
                        <input type="text" name="d_name" id="d_name" value="<?=$data->d_name;?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Driver Contact Number <span class="text-danger">*</span></label>
                        <input type="text" name="d_number" id="d_number" value="<?=$data->d_number;?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Driver NID Number</label>
                        <input type="text" name="nid_number" id="nid_number" value="<?=$data->nid_number;?>" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NID Attachment</label>
                        <input type="file" name="nid_file" id="nid_file" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Driving Licence No. <span class="text-danger">*</span></label>
                        <input type="text" name="licence_number" value="<?=$data->licence_number;?>"  class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Driving Licence Attachment</label>
                        <input type="file" name="licence_file" id="licence_file" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Active Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select" required>
                            <? foreign_relation('activation','id','activation',$status,'1');?>
                        </select>
                    </div>
                    <div class="text-center">
                    <?if($data->id > 0){?>
                        <input name="update" id="update" type="submit" class="btn btn-secondary" value='Update' >
                        <?}else{?>
                        <button type="submit" name="insert" class="btn btn-primary">Insert</button>
                        <?}?>
                    </div>
                </form>
            </div>
        </div>
    </div>


  
            



    

    



<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>

