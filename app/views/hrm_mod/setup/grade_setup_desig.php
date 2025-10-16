<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 
$title='Employee Grade Information';			// Page Name and Page Title
$page="grade_type.php";		// PHP File Name
$input_page="grade_type_input.php";
$root='setup';

$table='hrm_grade';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='grade_name';				// For a New or Edit Data a must have data field
 if(isset($_POST['show'])){
     
   header("Location:grade_setup_desig.php?class_id=".$_POST['class_name']);  
 }
 
 
?>
 


<form  action=" " method="post">
    
    <div class="container">
        <div class="jumbotron">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    
                    <select name="class_name" id="class_name">
                        
                          <?php 
                  $sql='select * from hrm_class';
                  $query=db_query($sql);
                  while($row=mysqli_fetch_object($query)){
                  ?>
                        <option value="<?=$row->id?>"><?=$row->class_name?></option>
                      
           
                  <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">
                    
                     <input type="submit" name="show" id="show" value="show" class="btn btn-primary">
                </div>
            </div>
               <div class="col-md-4"></div>
        </div>
        
    </div>
        
</form> 

<?php 
if(isset($_POST['update'])){
    
     $dss_sql='select d.* from designation d ';
        $dss_query=db_query($dss_sql);
        while($dss_row=mysqli_fetch_object($dss_query)){
          
              
            if($_POST['grade_id_'.$dss_row->DESG_ID]>0){
                
                    $class_id=$_POST['class_id_'.$dss_row->DESG_ID];
          $grade_id=$_POST['grade_id_'.$dss_row->DESG_ID];
          $level_id=$_POST['level_id_'.$dss_row->DESG_ID];
           $designation_id=$_POST['designation_id_'.$dss_row->DESG_ID];
          echo $check_prev_submit=find_a_field('hrm_designation_grade','count(id)','designation_id="'.$designation_id.'" ');
           if($check_prev_submit>0){
                  $up_sql='update hrm_designation_grade set class_id="'.$class_id.'",level_id="'.$level_id.'",grade_id="'.$grade_id.'",designation_id="'.$designation_id.'" where  designation_id="'.$designation_id.'"  ';
          db_query($up_sql);  
     
            }
            else{
               //$up_sql='insert into hrm_designation_grade(class_id,level_id,grade_id,designation_id)values("'.$class_id.'","'.$level_id.'","'.$grade_id.'","'.$designation_id.'")';
                     $ins_sql='insert into hrm_designation_grade(class_id,level_id,grade_id,designation_id)values("'.$class_id.'","'.$level_id.'","'.$grade_id.'","'.$designation_id.'")';
          db_query($ins_sql);
            }
            }
     
            
        }
    
}
?>

<form action="" method="post">
<?php
if($_GET['class_id']>0){
?>
<table class="table table-bordered table-condensed table-sm">
    
    <thead>
        <tr>
            <th bgcolor="#99FF99">Class</th>
            <th bgcolor="#99FF99">Level</th>
            <th bgcolor="#99FF99">Designation</th>
            <th bgcolor="#99FF99">Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $ds_sql='select d.*,l.level_name,l.id as level_id,l.class_id,c.class_name from designation d,hrm_level l,hrm_class c where l.class_id=c.id and c.id="'.$_GET['class_id'].'" ';
        $ds_query=db_query($ds_sql);
		$count_row=mysqli_num_rows($ds_query);
		 
        while($ds_row=mysqli_fetch_object($ds_query)){
            $all_master_info=find_all_field('hrm_designation_grade','*','designation_id="'.$ds_row->DESG_ID.'"');
			$count_level_id=find_a_field('designation','count(DESG_ID)','level_id="'.$ds_row->level_id.'"');
        ?>
        <tr>
		
		<?php
		
		if($cus_class_id!=$ds_row->class_id){
		
		?>
            <td rowspan="<?=$count_row?>"><?=$ds_row->class_name?></td>
			<?php } ?>
				<?php
		
		if($cus_level_id!=$ds_row->level_id){
		?>
		<td rowspan="<?=$count_level_id?>"><?=$ds_row->level_name?></td>
           
			<?php } ?>
            
            <td><?=$ds_row->DESG_DESC; ?></td>
            <td>
                <input type="hidden" name="class_id_<?=$ds_row->DESG_ID?>" id="class_id_<?=$ds_row->DESG_ID?>" value="<?=$ds_row->class_id?>">
                <input type="hidden" name="level_id_<?=$ds_row->DESG_ID?>" id="level_id_<?=$ds_row->DESG_ID?>" value="<?=$ds_row->level_id?>">
                <input type="hidden" name="designation_id_<?=$ds_row->DESG_ID?>" id="designation_id_<?=$ds_row->DESG_ID?>" value="<?=$ds_row->DESG_ID?>">
                 <input type="hidden" name="grade_get_<?=$ds_row->DESG_ID?>" id="grade_get_<?=$ds_row->DESG_ID?>" value=" ">
                
                <select name="grade_id_<?=$ds_row->DESG_ID?>" id="grade_id_<?=$ds_row->DESG_ID?>">
                    <option value="<?=$all_master_info->grade_id?>"><?=find_a_field('hrm_grade','grade_name','id='.$all_master_info->grade_id)?></option>
                    <?php 
                    $g_sql='select * from hrm_grade';
                    $g_query=db_query($g_sql);
                    while($g_row=mysqli_fetch_object($g_query)){  ?>
                    <option value="<?php echo $g_row->id;?>"><?php echo $g_row->grade_name;?></option>
                    <? } ?>
                </select>
                
            </td>
        </tr>
        <?php 
		$cus_class_id=$ds_row->class_id;
		$cus_level_id=$ds_row->level_id;
		} ?>
        
    </tbody>
</table>
<div class="row">
    <div class="col-md-12 text-center">
        <input type="submit" name="update" id="update" value="Update" class="btn btn-success">
    </div>
    
</div>
</form>
<?php } ?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>