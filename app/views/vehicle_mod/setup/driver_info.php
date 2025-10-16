<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";



// ::::: Edit This Section ::::: 



$title='ADD Driver Information';			// Page Name and Page Title

$page="driver_info.php";		// PHP File Name



$table='driver_info';		// Database Table Name Mainly related to this page

$unique='driver_id';			// Primary Key of this Database table

$shown='driver_name';				// For a New or Edit Data a must have data field



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

foreach ($data as $key => $value)

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
						<th>Driver ID</th>
						<th>Driver Name</th>
						<th>Mobile No</th>
						
					</tr>
				</thead>
				<tbody>
				<?php 
				$res='select * from driver_info';
				$query=db_query($res);
				while($row=mysqli_fetch_object($query)){
								?>
					<tr onclick="DoNav(<?php 
						echo $row->driver_id;
						?>)">
						<td><?php 
						echo $row->driver_id;
						?></td>
						<td><?php 
						echo $row->driver_name;
						?></td>
						<td>
						<?php 
						echo $row->mobile_no;
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
                        <label> Driver CODE:</label>
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text"  readonly/>
                      </div>
					       
                      <div>
                        <label> Driver NAME:</label>
                        <input name="driver_name" type="text" id="driver_name" tabindex="2" value="<?=$driver_name?>">
                      </div>
					  <div>
                        <label> Mobile No:</label>
                       
				<input name="mobile_no" type="text" id="mobile_no" tabindex="2" value="<?=$mobile_no?>">
                      </div>
					
					    <div>
                        <label> NID No:</label>
				<input name="nid_no" type="text" id="nid_no" tabindex="2" value="<?=$nid_no?>">
                        
                      </div>
					    <div>
                        <label>Present Address:</label>
                        <input name="present_address" type="text" id="present_address" tabindex="2" value="<?=$present_address?>">
                      </div>
					  
					     <div>
                        <label> Permanent Address:</label>
                        <input name="permanent_address" type="text" id="permanent_address" tabindex="2" value="<?=$permanent_address?>">
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>
