<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require_once SERVER_CORE."routing/inc.notify.php";

// ::::: Edit This Section ::::: 



$title='Vendor Info';			// Page Name and Page Title

$page="vendor_info.php";		// PHP File Name



$table='vehicle_vendor';		// Database Table Name Mainly related to this page

$unique='vendor_id';			// Primary Key of this Database table

$shown='vendor_name';				// For a New or Edit Data a must have data field

do_calander('#expire_date');

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
$_POST['entry_at']=date('Y-m-d H:i:s');
if($_FILES['att_file']['tmp_name']!=''){
		
						$file_name= $_FILES['att_file']['name'];
			
						$file_tmp= $_FILES['att_file']['tmp_name'];
			
						$ext=end(explode('.',$file_name));
			
						$path='../../files/vendor/';
						
						$uploaded_file = $path.$$unique.'.'.$ext;
						
						$_POST['att_file'] = $uploaded_file;
			
						move_uploaded_file($file_tmp, $uploaded_file);
		
					}
$crud->insert();

$type=1;

$msg='New Vendor Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

        if($_FILES['att_file']['tmp_name']!=''){
		
						$file_name= $_FILES['att_file']['name'];
			
						$file_tmp= $_FILES['att_file']['tmp_name'];
			
						$ext=end(explode('.',$file_name));
			
						$path='../../files/vendor/';
						
						$uploaded_file = $path.$$unique.'.'.$ext;
						
						$_POST['att_file'] = $uploaded_file;
			
						move_uploaded_file($file_tmp, $uploaded_file);
		
					}
		$type=1;

		$msg='Successfully Updated.';

}

//for Delete..................................



/*if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}*/

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
						<th>Vendor Name</th>
						<th>Contact Person</th>
						<th>Mobile No.</th>
						<th>Email</th>
						<th>Address</th>
						
					</tr>
				</thead>
				<tbody>
				<?php 
				$res='select * from vehicle_vendor';
				$query=db_query($res);
				while($row=mysqli_fetch_object($query)){
								?>
					<tr onclick="DoNav(<?php 
						echo $row->vendor_id;
						?>)">
						
						<td><?php echo $row->vendor_name;?></td>
						<td><?php echo $row->contact_person;?></td>
						<td><?php echo $row->mobile;?></td>
						<td><?php echo $row->email;?></td>
						<td><?php echo $row->address;?></td>
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
                        <label> Vendor Name:</label>
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text"  readonly/>
						
                      </div>
					       
                      <div>
                        <label> Vendor Name:</label>
                        <input name="vendor_name" type="text" id="vendor_name" tabindex="2" value="<?=$vendor_name?>">
                      </div>
					  
					  <div>
                        <label> Contact Person:</label>
                        <input name="contact_person" type="text" id="contact_person" tabindex="2" value="<?=$contact_person?>">
                      </div>
					  
					  <div>
                        <label> Mobile No.:</label>
                        <input name="mobile" type="text" id="mobile" tabindex="2" value="<?=$mobile?>">
                      </div>
					  
					    <div>
                        <label> Email:</label>
                        <input name="email" type="text" id="email" tabindex="2" value="<?=$email?>">
                      </div>
					  
					  <div>
                        <label> Address:</label>
                        <input name="address" type="text" id="address" tabindex="2" value="<?=$address?>">
                      </div>
					  
					  <div>
                        <label> Document:</label>
                        <input name="att_file" type="file" id="att_file" tabindex="2" value="">
                      </div>
					  <?
					   if($att_file!=''){
					  ?>
					  <div>
                        <label> Document View:</label>
                        <a href="<?=$att_file;?>" target="_blank">View</a>
                      </div>
					  <? } ?>
                    
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
