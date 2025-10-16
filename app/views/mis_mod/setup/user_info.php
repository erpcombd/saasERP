<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 


$title='User Information';			// Page Name and Page Title

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

do_datatable('table_head');

do_calander('#expire_date');

$page="user_info.php";		// PHP File Name



$table='user_activity_management';		// Database Table Name Mainly related to this page

$unique='user_id';			// Primary Key of this Database table

$shown='username';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);


$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];

//for Insert..................................

if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];


$_POST['password']=md5($_POST['password']);

$now				= time();

$entry_by = $_SESSION['user'];

	$folder='user_pic';
	$field = 'user_pic';  //'PBI_PICTURE_ATT_PATH';
	$file_name = $folder.'-'.$user_id;
	if($_FILES['user_pic']['tmp_name']!=''){
		$_POST['user_pic']=upload_file($folder,$field,$file_name);
	}


$crud->insert();

		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{

      	$_POST['password']=md5($_POST['password']);

		$_POST['edit_by'] = $_SESSION['user']['id'];
		 
		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');

	$folder='user_pic';
	$field = 'user_pic';  //'PBI_PICTURE_ATT_PATH';
	$file_name = $folder.'-'.$user_id;
	if($_FILES['user_pic']['tmp_name']!=''){
		$_POST['user_pic']=upload_file($folder,$field,$file_name);
	}

		$crud->update($unique);


		// if($_FILES['pp']['tmp_name']!=''){ 
		// $file_temp = $_FILES['pp']['tmp_name'];
		// $folder = "../../pp_pic/pp/";
		// move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		// if($_FILES['np']['tmp_name']!=''){ 
		// $file_temp = $_FILES['np']['tmp_name'];
		// $folder = "../../np_pic/np/";
		// move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		// if($_FILES['spp']['tmp_name']!=''){ 
		// $file_temp = $_FILES['spp']['tmp_name'];
		// $folder = "../../spp_pic/spp/";
		// move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		// if($_FILES['nsp']['tmp_name']!=''){ 
		// $file_temp = $_FILES['nsp']['tmp_name'];
		// $folder = "../../nsp_pic/nsp/";
		// move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		

		// $type=1;
		// $msg='Successfully Updated.';

}

// $folder='user_pic'; 
// $field = 'user_pic';  //'PBI_PICTURE_ATT_PATH';
// $file_name = $folder.'-'.$unique;

// if($_FILES['user_pic']['tmp_name']!=''){
// $_POST['user_pic']=upload_file($folder,$field,$file_name);


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

<script type="text/javascript">

$(function() {

		$("#fdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'yy-mm-dd'

		});

});

function Do_Nav()

{

	var URL = 'pop_ledger_selecting_list.php';

	popUp(URL);

}




function DoNav(theUrl)

{

	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;

}

function popUp(URL) 

{

	day = new Date();

	id = day.getTime();

	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-7 p-0 pr-2">
            <div class="container p-0">
			<form id="form1" name="form1" class="n-form1 pt-0" method="post" action="">
			<h4 align="center" class="n-form-titel1">Search User Information</h4>

                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company</label>
                        <div class="col-sm-9 p-0">
                             <select name="group_for" required id="group_for" tabindex="7">
									<option></option>
                      			<? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                   			 </select>

                        </div>
                    </div>
					<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Warehouse</label>
                        <div class="col-sm-9 p-0">
                             <select name="warehouse_id"  id="warehouse_id"  tabindex="7">
										
									<option></option>

                      				<? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');?>
                    		</select>

                        </div>
                    </div>

                    <div class="n-form-btn-class">
                        <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                        <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />
                    </div>

                </form>
            </div>


            <div class="container n-form1">
					<table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
						<thead>
							<tr class="bgc-info">
								  <th><span>User ID</span></th>
								
								  <th><span>User</span></th>
								
								  <th><span>User Name </span></th>
								<th><span>Warehouse</span></th>
							</tr>
						</thead>
						
						<tbody>
						
						<?php
						
						
						if($_POST['group_for']!="")
						
						$con .= 'and a.group_for="'.$_POST['group_for'].'"';
						
						if($_POST['warehouse_id']!="")
						
						$con .= 'and a.warehouse_id="'.$_POST['warehouse_id'].'"';
						
						
						
						//if($_POST['username']!="")
						
						//$con .='and a.username like "%'.$_POST['username'].'%" ';
						
						
						
						
						
						 $td='select a.'.$unique.',  a.'.$shown.' ,  a.fname, w.warehouse_name from '.$table.' a, user_group u, warehouse w	where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'" and a.warehouse_id=w.warehouse_id   '.$con.' order by a.user_id  ';
						
						$report=db_query($td);
						
						while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
						
						<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
						  <td><?=$rp[0];?></td>
						
						<td><?=$rp[1];?></td>
						
						<td><?=$rp[2];?></td>
						<td><?=$rp[3];?></td>
						</tr>
						
						<?php }?>
	</tbody>
	</table>
	
	<? //}?>
	
						<div id="pageNavPosition"></div>
	
				</div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
           
            <form id="form1" name="form1" class="n-form setup-fixed" method="post" action="" enctype="multipart/form-data" >
            <? if(!isset($_GET[$unique])){?>
              <h4 align="center" class="n-form-titel1">Create User Information</h4>
            <? }?>
            <? if(isset($_GET[$unique])){?>
              <h4 align="center" class="n-form-titel1">Update User Information</h4>
            <? }?>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> User Id</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input name="user_id" type="text" id="user_id" tabindex="1" value="<?=$_GET['user_id']?>" readonly>
                        <input name="username" required type="hidden" id="username" tabindex="1" value="<?=$username?>"  >	


                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> User Name</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input name="user_id" type="hidden" id="user_id" tabindex="1" value="<?=$_GET['user_id']?>" readonly>
                        <input name="username" required type="text" id="username" tabindex="1" value="<?=$username?>"  >	


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Password </label>
                    <div class="col-sm-9 p-0">
                        <input name="password" required type="password" id="password" tabindex="1" value="<?=$password?>" >

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Company  </label>
                    <div class="col-sm-9 p-0">

                       <select name="group_for" required id="group_for"  tabindex="7">
					
							  <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
					   </select>

                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Warehouse  </label>
                    <div class="col-sm-9 p-0">

                        <select name="warehouse_id" required id="warehouse_id"  tabindex="7">
										
							<option></option>
					
							 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1');?>
						</select>

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Full Name  </label>
                    <div class="col-sm-9 p-0">

                        <input name="fname" required type="text" id="fname" tabindex="2" value="<?=$fname?>" >

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Designation  </label>
                    <div class="col-sm-9 p-0">

                        <input name="designation" required type="text" id="designation" tabindex="2" value="<?=$designation?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Address  </label>
                    <div class="col-sm-9 p-0">

                        <input name="address" type="text" id="address" tabindex="2" value="<?=$address?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Mobile  </label>
                    <div class="col-sm-9 p-0">

                        <input name="mobile" type="text" id="mobile" tabindex="8" value="<?=$mobile?>" />
						<input name="status" type="hidden" id="status" tabindex="8" value="In Service" />

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">E-mail  </label>
                    <div class="col-sm-9 p-0">

                        <input name="email" type="text" id="email" tabindex="8" value="<?=$email?>">
						
						
						<? $_POST['entry_by'] = $_SESSION['user']['id'];?>
						
						 <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_POST['entry_by'];?>"  />
						 <input name="entry_at" type="hidden" required id="entry_at" tabindex="10" value="<?=$now=date('Y-m-d H:i:s');?>"  />

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Expire Date  </label>
                    <div class="col-sm-9 p-0">

                        <input name="expire_date" type="text" id="expire_date"  required value="<?=$expire_date?>" />

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Distributor(If)</label>
                    <div class="col-sm-9 p-0">

                        <select name="dealer_code" id="dealer_code">
						<option></option>
						<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'1');?>
						</select>

                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Vendor(If)</label>
                    <div class="col-sm-9 p-0">

                        <select name="vendor_code" id="vendor_code">
						<option></option>
						<? foreign_relation('vendor','vendor_id','vendor_name',$vendor_code,'1');?>
						</select>

                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">User Pic </label>
                    <div class="col-sm-9 p-0">

                        <input  name="user_pic" type="file" id="user_pic" value=""  />
						
						<?php if ($user_pic!=''){?>
            <a href="<?=SERVER_CORE?>core/upload_view.php?name=<?=$user_pic?>&folder=user_pic&proj_id=<?=$_SESSION['proj_id']?>" target="_blank">View Attachment</a>
          <?php } ?>


                    </div>
                </div>
				
				
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Note</label>
                    <div class="col-sm-9 p-0">
                       <h4>Please Assign Warehouse to this User from "Warehouse Define" Menu.</h4>

                    </div>
                </div>
				
				
<?php /*?>
                <div class="n-form-btn-class">
                     <? 
					  $count_user = find_a_field('user_activity_management','count(user_id)','status = "Active"');
					 if(!isset($_GET[$unique])){
					  if($_SESSION['max_user_limit']>$count_user){
					 ?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }else{ ?>
					  <span style="color:#FF0000;">Max User Limit Exceed</span>
					  <? } } ?>
                   
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>
                    
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />

                </div><?php */?>
				
				
				                <div class="n-form-btn-class">
                     <? 
					  $count_user = find_a_field('user_activity_management','count(user_id)','1');
					 if(!isset($_GET[$unique])){
					  if($_SESSION['max_user_limit']>$count_user){
					 ?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }else{ ?>
					  <span style="color:#FF0000;">Max User Limit Exceed</span>
					  <? } } ?>
                   
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>
                    
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />

                </div>


            </form>

        </div>

    </div>




</div>







<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action="" enctype="multipart/form-data"><table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Company:                                       </td>

                                        <td width="60%" align="right">

										<select name="group_for" required id="group_for" style="width:250px; float:left;" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select>
										
										</td>

                                      </tr>
									  
									  
									  <tr>

                                        <td width="40%" align="right">

		    Warehouse:                                       </td>

                                        <td width="60%" align="right">

										<select name="warehouse_id"  id="warehouse_id" style="width:250px; float:left;" tabindex="7">
										
										<option></option>

                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');?>
                    </select>
										
										</td>

                                      </tr>
									
									
									

                                      

                                      

                                      <!--<tr>

                                        <td align="right"> User:                                         </td>

                                        <td align="right"><input name="username" type="text" id="username" style="width:250px; float:left;" value="<?php echo $_POST['username']; ?>" size="20" /></td>

                                      </tr>-->

                                      <tr>

                                        <td colspan="2"><div align="center">
                                          <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />
                                        </div></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td>&nbsp;</td>

								  </tr> <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">User ID</span></th>

  <th bgcolor="#45777B"><span class="style3">User</span></th>

  <th bgcolor="#45777B"><span class="style3">User Name </span></th>
<th bgcolor="#45777B"><span class="style3">Warehouse</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['warehouse_id']!="")

$con .= 'and a.warehouse_id="'.$_POST['warehouse_id'].'"';



//if($_POST['username']!="")

//$con .='and a.username like "%'.$_POST['username'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.' ,  a.fname, w.warehouse_name from '.$table.' a, user_group u, warehouse w	where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'" and a.warehouse_id=w.warehouse_id   '.$con.' order by a.user_id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td><?=$rp[1];?></td>

<td><?=$rp[2];?></td>
<td><?=$rp[3];?></td>
</tr>

<?php }?>
</tbody>
</table>

<? //}?>

									<div id="pageNavPosition"></div>									</td>

								  </tr>

		</table>



	</div></td>

    <td valign="top" width="40%"><div class="right">   <form action="" method="post"  name="form1" id="form1" onsubmit="return check()" enctype="multipart/form-data">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box style2" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      

									  

									  <tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>User Name:</td>

                                        <td>
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="user_id" type="text" id="user_id" tabindex="1" value="<?=$_GET['user_id']?>" readonly>
                        				<input name="username" required type="text" id="username" tabindex="1" value="<?=$username?>"  style=" width:250px" >	
										
										
										</td>
                                      </tr>
									  
									  
									  <tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>Password:</td>

                                        <td>
										
                        				<input name="password" required type="password" id="password" tabindex="1" value="<?=$password?>"  style="width:250px;; height:35px;" >	
										
										
										</td>
                                      </tr>
									  
									  
									  
									  
									  <td>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for" style=" width:250px" tabindex="7">
					
										  <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
										</select>
										<input name="level" type="hidden" id="level" tabindex="8" value="5" style=" width:250px"/>
										</td>
					
                                      <tr>
									  
									  
									  <td><span class="style1" style="padding-top:5px;">*</span>Warehouse:</td>

                                        <td>
										
										<select name="warehouse_id" required id="warehouse_id" style=" width:250px" tabindex="7">
										
										<option></option>
					
										 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1');?>
										</select></td>
					
									</tr>
									
									
									<tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Full Name:</td>

                                        <td>

                                        <input name="fname" required type="text" id="fname" tabindex="2" value="<?=$fname?>" style=" width:250px"></td>
									  </tr>
									  
					
					
									<tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Designation:</td>

                                        <td>

                                        <input name="designation" required type="text" id="designation" tabindex="2" value="<?=$designation?>" style=" width:250px"></td>
									  </tr>
									  
									  <tr>

                                        <td>Address:</td>

                                        <td>
										<input name="address" type="text" id="address" tabindex="2" value="<?=$address?>" style=" width:250px"></td>
									  </tr>
									  
									  
									  
									  
									  
									  
									  
									  

                                      <tr>

                                        <td>Mobile:</td>

                                        <td><input name="mobile" type="text" id="mobile" tabindex="8" value="<?=$mobile?>" style=" width:250px"/>
										<input name="status" type="hidden" id="status" tabindex="8" value="In Service" style=" width:250px"/>
										</td>
                                      </tr>

                                      <tr>

                                        <td>E-mail:</td>

                                        <td><input name="email" type="text" id="email" tabindex="8" value="<?=$email?>" style=" width:250px">
						
						
						<? $_POST['entry_by'] = $_SESSION['user']['id'];?>
						
						 <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_POST['entry_by'];?>" style=" width:250px" />
						 <input name="entry_at" type="hidden" required id="entry_at" tabindex="10" value="<?=$now=date('Y-m-d H:i:s');?>" style=" width:250px" />
						 </td>
                                      </tr>
									  
									  
									  
									  



                                      
									  
									  
									  
									  
									  
									 
									<tr>

                                        <td>Expire Date:</td>

                                        <td><input name="expire_date" type="text" id="expire_date"  required value="<?=$expire_date?>" style=" width:250px"/>
										
										</td>
                                      </tr>
									  
									  
									  <tr>

                                        <td> User Pic:</td>

                                        <td><input style="padding:5px 5px 7px 5px; width:250px" name="user_pic" type="file" id="user_pic" value=""  /></td>
                                      </tr>
									  
									  
             

                                      

									
									  

                                      

                                      
									  

                                    

                                      

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                

                                <tr>

                                  <td colspan="2">&nbsp;</td>
                                </tr>

                                <tr>

                                  <td colspan="2">

								  <div class="box1">

								    <table width="100%" border="0" cellspacing="0" cellpadding="0">

								      <tr>
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
                    </div></td>
                  <td>
                  <!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->                    </td>
                </tr>
							        </table>
								  </div>								  </td>
                                </tr>
                              </table>

    </form>

							</div></td>

  </tr>

</table><?php */?>

<script type="text/javascript"><!--

    var pager = new Pager('grp', 10000);

    pager.init();

    pager.showPageNav('pager', 'pageNavPosition');

    pager.showPage(1);

//-->

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>




<script>


function duplicate(){

var dealer_code_2 = ((document.getElementById('dealer_code_2').value)*1);

var customer_id = ((document.getElementById('customer_id').value)*1);



   if(dealer_code_2>0)
  {
  
alert('This customer code already exists.');
document.getElementById('customer_id').value='';


document.getElementById('customer_id').focus();

  } 



}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>