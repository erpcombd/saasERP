<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




$title = "Vehicle List";



$page = 'vehicle_info.php';



$table = 'vehicle_information';

$crud = new crud($table);

$update_id = $_GET['update'];



if(isset($_POST['insert'])){
    
    
    	$reg_file = $_FILES['reg_file']['name'];

        if ($reg_file != '') {
            
          $reg_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['reg_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_registration/';
          move_uploaded_file($_FILES['reg_file']['tmp_name'], $path . $reg_no . '.' . $ext);
          
          $_POST['reg_file'] = $reg_no.'.'.$ext;
        }
        
        
        
        
       	$insurance_file = $_FILES['insurance_file']['name'];

        if ($insurance_file != '') {
            
          $insurance_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['insurance_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_insurance/';
          move_uploaded_file($_FILES['insurance_file']['tmp_name'], $path . $insurance_no . '.' . $ext);
          
          $_POST['insurance_file'] = $insurance_no.'.'.$ext;
        }
        
        
        
        
        
       	$tax_file = $_FILES['tax_file']['name'];

        if ($tax_file != '') {
            
          $tax_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['tax_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_tax/';
          move_uploaded_file($_FILES['tax_file']['tmp_name'], $path . $tax_no . '.' . $ext);
          
          $_POST['tax_file'] = $tax_no.'.'.$ext;
        }
        
        
        
        
       	$fitness_file = $_FILES['fitness_file']['name'];

        if ($fitness_file != '') {
            
          $fitness_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['fitness_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_fitness/';
          move_uploaded_file($_FILES['fitness_file']['tmp_name'], $path . $fitness_no . '.' . $ext);
          
          $_POST['fitness_file'] = $fitness_no.'.'.$ext;
        }
        
        
      	$permission_file = $_FILES['permission_file']['name'];

        if ($permission_file != '') {
            
          $permission_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['permission_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_permission/';
          move_uploaded_file($_FILES['permission_file']['tmp_name'], $path . $permission_no . '.' . $ext);
          
          $_POST['permission_file'] = $permission_no.'.'.$ext;
        }
        
        
        
    $_POST['entry_by'] = $_SESSION['user']['id'];

    



        

        $crud->insert();

        

        echo "<script>location.href='vehicle_list.php';</script>";

        exit;

        

    // }

}









if(isset($_POST['update'])){
    
         $id = $_POST['id'];
    
    	$reg_file = $_FILES['reg_file']['name'];

        if ($reg_file != '') {

          $reg_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['reg_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_registration/';
          
           
               $prev_reg_file= $_POST['prev_reg_file'];
                if (file_exists($path . $prev_reg_file)) {
                    unlink($path . $prev_reg_file);
                }
              
          move_uploaded_file($_FILES['reg_file']['tmp_name'], $path . $reg_no . '.' . $ext);
          
          $_POST['reg_file'] = $reg_no.'.'.$ext;
        }
        
        
        
        
       	$insurance_file = $_FILES['insurance_file']['name'];

        if ($insurance_file != '') {
            
          $insurance_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['insurance_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_insurance/';
                    
            $prev_insurance_file= $_POST['prev_insurance_file'];
                if (file_exists($path . $prev_insurance_file)) {
                    unlink($path . $prev_insurance_file);
                }
                    
          move_uploaded_file($_FILES['insurance_file']['tmp_name'], $path . $insurance_no . '.' . $ext);
          
          $_POST['insurance_file'] = $insurance_no.'.'.$ext;
        }
        
        
        
        
        
       	$tax_file = $_FILES['tax_file']['name'];

        if ($tax_file != '') {
            
          $tax_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['tax_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_tax/';
          
            $prev_tax_file= $_POST['prev_tax_file'];
                if (file_exists($path . $prev_tax_file)) {
                    unlink($path . $prev_tax_file);
                }
                
          move_uploaded_file($_FILES['tax_file']['tmp_name'], $path . $tax_no . '.' . $ext);
          
          $_POST['tax_file'] = $tax_no.'.'.$ext;
        }
        
        
        
        
       	$fitness_file = $_FILES['fitness_file']['name'];

        if ($fitness_file != '') {
            
          $fitness_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['fitness_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_fitness/';
          
                $prev_fitness_file = $_POST['prev_fitness_file'];
                    if (file_exists($path . $prev_fitness_file)) {
                        unlink($path . $prev_fitness_file);
                    }
                    
          move_uploaded_file($_FILES['fitness_file']['tmp_name'], $path . $fitness_no . '.' . $ext);
          
          $_POST['fitness_file'] = $fitness_no.'.'.$ext;
        }
        
        
      	$permission_file = $_FILES['permission_file']['name'];

        if ($permission_file != '') {
            
          $permission_no = $_POST['reg_number'];

          $ext = end(explode('.', $_FILES['permission_file']['name']));
          $path = '../../../../media_attachment/vehicle/vehicle_permission/';
           
                 $prev_permission_file = $_POST['prev_permission_file'];
                    if (file_exists($path . $prev_permission_file)) {
                        unlink($path . $prev_permission_file);
                    }
                    
          move_uploaded_file($_FILES['permission_file']['tmp_name'], $path . $permission_no . '.' . $ext);
          
          $_POST['permission_file'] = $permission_no.'.'.$ext;
        }

    $_POST['update_by'] = $_SESSION['user']['id'];
    $_POST['update_at'] = date('Y-m-d H:i:s');
    $concern_id = $_POST['concern_id'];


    $crud->update('id');
}





if(isset($_POST['remove'])){

    

    $qry = "DELETE FROM $table WHERE id = '".$_POST['id']."'";

    db_query($qry);

    

    echo "<script>location.href='".$page."';</script>";

    exit;

}







$datas = find_all_field($table, '', 'id="'.$_GET['update'].'"');


?>





    <style>

        td {

            text-align: center!important;

        }
        
         body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
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
                        <label class="form-label">Concern name : <span class="text-danger">*</span></label>
                        <select name="concern_id" id="concern_id" class="form-select"  >
                           	 <? foreign_relation('customer_list','id','customer_name',$concern_id,'1');?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vehicle Model <span class="text-danger">*</span></label>
                        <input name="vehicle_model" id="vehicle_model" class="form-control" value='<?=$datas->vehicle_model?>'  >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Registration Number <span class="text-danger">*</span></label>
                        <input name="reg_number" id="reg_number" class="form-control" value='<?=$datas->reg_number?>'  >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Registration Attachment</label>
                        <input type="file" name="reg_file" id="reg_file" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Insurance Deadline <span class="text-danger">*</span></label>
                        <input name="insurance_deadline" id="insurance_deadline" type="date" class="form-control"  value='<?=$datas->insurance_deadline?>'  >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Insurance Attachment</label>
                        <input type="file" name="insurance_file" id="insurance_file" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tax Deadline <span class="text-danger">*</span></label>
                        <input name="tax_deadline" id="tax_deadline" type="date" class="form-control" value='<?=$datas->tax_deadline?>'  >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tax Attachment</label>
                        <input type="file" name="tax_file" id="tax_file" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fitness Deadline <span class="text-danger">*</span></label>
                        <input name="fitness_deadline" id="fitness_deadline" type="date" class="form-control"  value='<?=$datas->fitness_deadline?>'  >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fitness Attachment</label>
                        <input type="file" name="fitness_file" id="fitness_file" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Root Permission Deadline <span class="text-danger">*</span></label>
                        <input name="root_permission_deadline" id="root_permission_deadline" type="date" class="form-control"  value='<?=$datas->root_permission_deadline?>'>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Route Permission Attachment</label>
                        <input type="file" name="permission_file" id="permission_file" class="form-control">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Vehicle Category <span class="text-danger">*</span></label>
                        <select name="category"  id="category" class="form-select"  >
                            <option value="">--SELECT---</option>
                           	 <? foreign_relation('vehicle_category','id','category_name',$datas->category,'1');?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Vehicle Type <span class="text-danger">*</span></label>
                        <select name="vehicle_type" id="vehicle_type" class="form-select"  >
                            <option value="">--SELECT---</option>
                           	 <? foreign_relation('vehicle_type_list','id','concat(type_name)',$datas->vehicle_type,'1');?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Seats (Without Driver) <span class="text-danger">*</span></label>
                        <input name="sit_number" id="sit_number" type="number" class="form-control" value='<?=$datas->sit_number?>'  >
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Empty Space in CFT</label>
                        <input name="cft" id="cft" type="number" value='<?=$datas->cft?>' class="form-control" >
                    </div>
                    
                      <div class="mb-3">
                        <label class="form-label">Empty Space in KG</label>
                        <input name="kg" id="kg" type="number" value='<?=$datas->kg?>' class="form-control" >
                    </div>
                    
                    
                    <div class="mb-3">
                        <label class="form-label">Fuel Capacity <span class="text-danger">*</span></label>
                        <input name="fuel_capacity" id="fuel_capacity" type="number" step="any" class="form-control" value='<?=$datas->fuel_capacity?>' >
                    </div>
             
                    <div class="mb-3">
                        <label class="form-label">Driver Incharge<span class="text-danger">*</span></label>
                        <select name="driver_incharge" id="driver_incharge" class="form-select"  >
                           
                            	 <? foreign_relation('vehicle_driver_info','id','d_name',$driver_incharge,'1');?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Active Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select"  >
                           	 <? foreign_relation('activation','id','activation',$status,'1');?>
                        </select>
                    </div>
                    <div class="text-center">
                        <?if($datas->id > 0){?>
                            <input name="update" id="update" type="submit" class="btn btn-secondary" value='Update' >
                        <!-- <button type="submit" name = "update" class="btn btn-secondary">Update</button> -->
                        <?}else{?>
                        <button type="submit" name = "insert" class="btn btn-primary">Insert</button>
                        <?}?>
                 
                    </div>
                </form>
            </div>
        </div>
    </div>

  
            



    

    

<?
	require_once SERVER_CORE."routing/layout.bottom.php";
?>

