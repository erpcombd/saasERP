<?php

require_once "../../../assets/template/layout.top.php";



// ::::: Edit This Section ::::: 



$title='ADD Employee Information';			// Page Name and Page Title

$page="employee_information.php";		// PHP File Name



$table='employee_info';		// Database Table Name Mainly related to this page

$unique='employee_id';			// Primary Key of this Database table

$shown='employee_name';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		
$_POST['entry_by']=$_SESSION['user']['id'];
$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();

$id = $_POST['dealer_code'];
		
		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['np']['tmp_name']!=''){ 
		$file_temp = $_FILES['np']['tmp_name'];
		$folder = "../../np_pic/np/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['spp']['tmp_name']!=''){ 
		$file_temp = $_FILES['spp']['tmp_name'];
		$folder = "../../spp_pic/spp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['nsp']['tmp_name']!=''){ 
		$file_temp = $_FILES['nsp']['tmp_name'];
		$folder = "../../nsp_pic/nsp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

$id = $_POST['dealer_code'];
		
		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['np']['tmp_name']!=''){ 
		$file_temp = $_FILES['np']['tmp_name'];
		$folder = "../../np_pic/np/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['spp']['tmp_name']!=''){ 
		$file_temp = $_FILES['spp']['tmp_name'];
		$folder = "../../spp_pic/spp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['nsp']['tmp_name']!=''){ 
		$file_temp = $_FILES['nsp']['tmp_name'];
		$folder = "../../nsp_pic/nsp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}

		$type=1;

		$msg='Successfully Updated.';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

while (list($key, $value)=each($data))

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<style>
label{
color:black;
}
</style>


<div class="form-container_large">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td valign="top"><div class="left">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div style="height:787px;width:638px;">
			  
			  <table class="table table-bordered table-sm">
			  	<thead>
					<tr>
						<th>Employee ID</th>
						<th>Employee Name</th>
						<th>Designation</th>
						
					</tr>
				</thead>
				<tbody>
				<?php 
				$res='select * from employee_info';
				$query=mysql_query($res);
				while($row=mysql_fetch_object($query)){
								?>
					<tr onclick="DoNav(<?php 
						echo $row->employee_id;
						?>)">
						<td><?php 
						echo $row->employee_id;
						?></td>
						<td><?php 
						echo $row->employee_name;
						?></td>
						<td>
						<?php 
						echo find_a_field('designation','DESG_DESC','DESG_ID='.$row->designation);
						?></td>
					</tr>
					<?php  } ?>
				</tbody>
			  </table>
			  
			  
                  
                </div>
                </td>
            </tr>
          </table>
        </div></td>
      <td valign="top" style="width:364px;"><form action="" method="post"  enctype="multipart/form-data" >
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2"><fieldset>
                      <legend>
                      <?=$title?>
                      </legend>
                      <div class="buttonrow"></div>
                      <div style="display:none;">
                        <label> Employee CODE:</label>
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text"  readonly/>
                      </div>
					      <div>
                        <label> Employee ID No:</label>
                        <input name="employee_manual_id" type="text" id="employee_manual_id" tabindex="2" value="<?=$employee_manual_id?>">
                      </div>
                      <div>
                        <label> Employee NAME:</label>
                        <input name="employee_name" type="text" id="employee_name" tabindex="2" value="<?=$employee_name?>">
                      </div>
					  <div>
                        <label> Designation:</label>
                       
						<select name="designation" id="designation">
							<option value="<?php echo $designation;?>">	<?php 
						echo find_a_field('designation','DESG_DESC','DESG_ID='.$designation);
						?></option>
							<?php 
							$sql='select * from designation';
							$dquery=mysql_query($sql);
							while($drow=mysql_fetch_object($dquery)){
							?>
							<option value="<?php echo $drow->DESG_ID;?>"><?php echo $drow->DESG_DESC;?></option>
							<?php } ?>
						</select>
                      </div>
					
					    <div>
                        <label> Department:</label>
						<select name="department" id="department">
							<option value="<?php echo $department;?>"><?php 
						echo find_a_field('department','DEPT_DESC','DEPT_ID='.$department);
						?></option>
							<?php 
							$sql='select * from department';
							$dquery=mysql_query($sql);
							while($drow=mysql_fetch_object($dquery)){
							?>
							<option value="<?php echo $drow->DEPT_ID;?>"><?php echo $drow->DEPT_DESC;?></option>
							<?php } ?>
						</select>
                        
                      </div>
					    <div>
                        <label> Mobile No:</label>
                        <input name="mobile_no" type="text" id="mobile_no" tabindex="2" value="<?=$mobile_no?>">
                      </div>
					  
					     <div>
                        <label> NID:</label>
                        <input name="nid" type="text" id="nid" tabindex="2" value="<?=$nid?>">
                      </div>
					  <div>
                        <label> Email:</label>
                        <input name="email" type="text" id="email" tabindex="2" value="<?=$email?>">
                      </div>
					    <div>
                        <label> Remarks:</label>
                        <input name="remarks" type="text" id="remarks" tabindex="2" value="<?=$remarks?>">
                      </div>
                    
                      </fieldset></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="button">
                        <? if(!isset($_GET[$unique])){?>
                        <input name="insert" type="submit" id="insert" value="Save" class="btn" />
                        <? }?>
                      </div></td>
                    <td><div class="button">
                        <? if(isset($_GET[$unique])){?>
                        <input name="update" type="submit" id="update" value="Update" class="btn" />
                        <? }?>
                      </div></td>
                    <td><div class="button">
                        <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                      </div></td>
                    <td><!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->
                    </td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>
</div>
<?

require_once "../../../assets/template/layout.bottom.php";

?>
