<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Worker Salary Configuration';// Page Name and Page Title
$page="pf_status.php";	// PHP File Name
$input_page="pf_status_input.php";
$root='hrm';
$table='pf_status';		// Database Table Name Mainly related to this page
$unique='PF_STATUS_ID';	// Primary Key of this Database table
$shown='PF_STATUS_CV';	// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::

$crud = new crud($table);
$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
$required_id = find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);

if($required_id>0)

$$unique = $_GET[$unique] = $required_id;



// Post Starts from here

//if(isset($_POST[$shown])){	
	if(isset($_POST['insert'])){	
	
		

	$_POST['PBI_ID']=$_SESSION['employee_selected'];
	$folder='hrm_pf_status'; 
	$field = 'PBI_CV_ATT_PATH'; 

//$file_name = $folder.'-'.$_SESSION['employee_selected'];


if($_FILES['PBI_CV_ATT_PATH']['tmp_name']!=''){



    $_POST['file_type'] = find_a_field('hrm_pf_type_info','file_type','id='.$_POST['type']); //$_POST['type']; 
	$_POST['file_path'] = find_a_field('hrm_pf_type_info','file_path','id='.$_POST['type']); //$_POST['type'];   
	$_POST['status'] = $_POST['PF_STATUS_CV'];
    $file_name = ''.$_POST['file_path'].'-'.$_SESSION['employee_selected'];	
	$_POST['file_path']=upload_file($folder,$field,$file_name);



}

	$crud->insert();
	$type=1;
	$msg='New Entry Successfully Inserted.';
	unset($_POST);
	unset($$unique);

	$required_id=find_a_field($table,$unique,'PBI_ID='.$_SESSION['employee_selected']);
	if($required_id>0)
	$$unique = $_GET[$unique] = $required_id;

}
	
	
if(isset($$unique)){

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach($data as $key => $value)

{ $$key=$value;}

}

?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}
</script>
<style>
	
.style1{
padding-left:20px;
}

.container {
  padding: 2rem 0rem;
}

h4 {
  margin: 2rem 0rem 1rem;
}

.table-image {
  td, th {
    vertical-align: middle;
  }
}

</style>




<form action="insert_salary_config.php" method="post" enctype="multipart/form-data">

  <? //=include('../../common/input_bar.php');?>

  
  
  
  
  
  <div class="page-content page-container" id="page-content">
   <div class="padding">
    <div class="row">
      <div class="col-lg-12">
    
		
		
		
          <div class="card">
            <div class="card-header" style="color:#E16127;"><strong> Worker Salary Configuration </strong></div>
            <div class="card-body">
        
       <div class="form-row">
                <div class="form-group col-sm-4">
                  <label>Schedule Type</label>
            <select name="salary_schedule" id="salary_schedule" class="form-control" >
           <option selected="selected">
           <? foreign_relation('salary_schedule','id','schedule_name',$salary_schedule,' 1');?>
           </select>
                </div>
                <div class="form-group col-sm-4">
                  <label>Grade</label>
           <select name="grade" id="grade">
            <? foreign_relation('hrm_grade','id','grade_name',$grade,'1');?>
          </select>
                </div>
                
                
                 <div class="form-group col-sm-4">
                  <label>Designation</label>
                <select  name="designation[]" id="designation" class="form-control chosen-select" multiple />
             <option></option>
             <? foreign_relation('designation','DESG_ID','DESG_DESC',$designation,'1 order by DESG_DESC');?>
              </select>
                </div>
                
                
              </div>
              
              
            <p  style="color:#E16127"> Salary Base Started :  </p>
			
              <div class="form-row">
                <div class="form-group col-sm-2">
                  <label>Gross Salary</label>
                  	<input name="gross" type="text" id="gross"  value="<?=$gross?>" />
                </div>
                <div class="form-group col-sm-2">
                  <label>Basic Salary</label>
                  <input name="basic" type="text" id="basic"  value="<?=$basic?>" />
                </div>
				
				
				  <div class="form-group col-sm-2">
                  <label>House Rent</label>
                <input name="house" type="text" id="house"  value="<?=$house?>" />
                </div>
                <div class="form-group col-sm-2">
                  <label>Medical Allowance </label>
                 <input name="medical" type="text" id="medical"  value="<?=$medical?>" />
                </div>
				
				
				<div class="form-group col-sm-2">
                  <label>Convayence Allowance </label>
                 <input name="conveyance" type="text" id="conveyance"  value="<?=$conveyance?>" />
                </div>
				
				
				<div class="form-group col-sm-2">
                  <label>Food Allowance </label>
                 <input name="food" type="text" id="food"  value="<?=$food?>" />
                </div>
				

  
  
  
              </div>
              
              
     <div class="text-right">
      <button name="insert" accesskey="S" class="btn btn-danger" type="submit"> <i class="fa-duotone fa-share-all"></i> Upload</button>
     </div>
              
              
                

            </div>
          </div>
     
      </div>
  
  
    </div>
</div></div>

  

  
  <table class="table table-bordered table-sm">
    <thead class="bg-light">
      <tr class="table-info" align="center">
        <th>SL</th>
        <th>Schedule Type</th>
        <th>Grade</th>
         <th>Designation</th> 
        <th>Gross Salary</th>
		 <th>Basic Salary</th>
        <th>House Rent</th>
        <th>Medical Allowance</th>
         <th>Convayence Allowance</th> 
        <th>Food Allowance</th>
		<th>Action</th>
		
      </tr>
    </thead>
    <tbody>
      <? 

 $pf = find_all_field('pf_status','','PBI_ID="'.$_SESSION['employee_selected'].'"');
 
 
$sqld = 'select *
from grade_settings
where 1';


$queryd=db_query($sqld);
while($data = mysqli_fetch_object($queryd)){


  ?>
      <tr align="center">
        <td><?=++$s?></td>
        <td align="center"><p class="fw-normal mb-1"> <?=find_a_field('salary_schedule','schedule_name','id="'.$data->salary_schedule.'"');?></p></td>
        <td align="center"><span class="badge badge-info"><?=$data->grade?></span></td>
		<td align="center"><span class="badge badge-success"><?=find_a_field('designation','DESG_DESC','DESG_ID="'.$data->designation.'"');?></span></td>
		<td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->gross?></span></td>
		<td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->basic?></span></td>
		<td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->house?></span></td>
		<td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->medical?></span></td>
		<td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->conveyance?></span></td>
		<td align="center"><span class="badge badge-primary rounded-pill d-inline"><?=$data->food?></span></td>
         
        <td align="center">
	      <a href="../../../assets/support/upload_view.php?name=<?=$data->file_path?>&folder=hrm_pf_status&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" target="_blank">
        <button type="button" class="btn btn-primary"><i class="far fa-eye"></i></button>
        </a> <a href="pf_delete.php?asign_id=<?=$data->PF_STATUS_ID;?>" onclick="return confirm('Are you sure you want to delete this item?');"   
			class="btn btn-danger btn-flat"> <i class="fa fa-trash"></i> </a> </td>
    </tr>
    <? } ?>
    </tbody>
    
  </table>
  
  
  
  
  
  <div class="oe_chatter">
    <div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div>
  </div>
</form>


<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<script>
$(".chosen-select").chosen({
  no_results_text: "Oops, nothing found!"
})

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
