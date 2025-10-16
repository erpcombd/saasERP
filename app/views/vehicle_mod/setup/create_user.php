<?php

require_once "../../../assets/template/layout.top.php";



// ::::: Edit This Section ::::: 



$title='User Info';			// Page Name and Page Title

$page="create_user.php";		// PHP File Name



$table='user_activity_management';		// Database Table Name Mainly related to this page

$unique='user_id';			// Primary Key of this Database table

$shown='fname';				// For a New or Edit Data a must have data field

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
$_POST['status']='In Service';
$_POST['group_for']=2;
$_POST['level']=5;
if($_FILES['att_file']['tmp_name']!=''){
		
						$file_name= $_FILES['att_file']['name'];
			
						$file_tmp= $_FILES['att_file']['tmp_name'];
			
						$ext=end(explode('.',$file_name));
			
						$path='../../files/user/';
						
						$uploaded_file = $path.$$unique.'.'.$ext;
						
						$_POST['att_file'] = $uploaded_file;
			
						move_uploaded_file($file_tmp, $uploaded_file);
		
					}
$crud->insert();

$type=1;

$msg='New User Successfully Created.';

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
			
						$path='../../files/user/';
						
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
						<th>User Name</th>
						<th>Full Name</th>
						<th>Mobile No.</th>
						<th>Email</th>
						
						
						
					</tr>
				</thead>
				<tbody>
				<?php 
				$res='select * from user_activity_management';
				$query=mysql_query($res);
				while($row=mysql_fetch_object($query)){
								?>
					<tr onclick="DoNav(<?php 
						echo $row->user_id;
						?>)">
						
						<td><?php echo $row->username;?></td>
						
						<td><?php echo $row->fname;?></td>
						<td><?php echo $row->mobile;?></td>
						<td><?php echo $row->email;?></td>
						
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
                      
                        <div>
                        <label> User Type:</label>
						<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden"  readonly/>
                        <select name="user_type" id="user_type">
						<option></option>
						<option <?=($user_type=='User')?'selected':''?>>User</option>
						<option <?=($user_type=='Driver')?'selected':''?>>Driver</option>
						</select>
						
						
                      </div>
						 
                      <div>
                        <label> User Name:</label>
                        <input name="username" type="text" id="username" tabindex="2" value="<?=$username?>">
                      </div>
					  
					  <div>
                        <label> Password:</label>
                        <input name="password" type="text" id="password" tabindex="2" value="<?=$password?>">
                      </div>
					  
					  <div>
                        <label> Full Name:</label>
                        <input name="fname" type="text" id="fname" tabindex="2" value="<?=$fname?>">
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
                        <label> Designation:</label>
                        <input name="designation" type="text" id="designation" tabindex="2" value="<?=$designation?>">
                      </div>
					  
					  <div>
                        <label> Department:</label>
                        <input name="department" type="text" id="department" tabindex="2" value="<?=$department?>">
                      </div>
					  
					  <div>
                        <label> Picture:</label>
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

require_once "../../../assets/template/layout.bottom.php";

?>
