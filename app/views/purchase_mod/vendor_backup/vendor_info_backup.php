<?php
session_start();
ob_start();
require "../../support/inc.all.php";

// ::::: Edit This Section ::::: 

$title='Vendor information';			// Page Name and Page Title
$page="vendor_info.php";		// PHP File Name

$table='vendor';		// Database Table Name Mainly related to this page
$unique='vendor_id';			// Primary Key of this Database table
$shown='vendor_name';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::

//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']))
{		
$proj_id			= $_SESSION['proj_id'];
$now				= time();

		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['entry_by']=$_SESSION['user']['id'];
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['update']))
{
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
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
if($_POST['gf']==999) 
{unset($_SESSION['gf']);
unset($_POST['gf']);
}
?>

<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}

function popUp(URL) 
{
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<div class="form-container_large">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
									<td><form id="form2" name="form2" method="post" action="">
									  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td style="color:#000000;">Company : </td>
                                          <td><select id="group_for" name="group_for" required>

					 						 <option selected="selected"></option>
											 
											 <option></option>



					  							<? foreign_relation('user_group','id','group_name',$_POST['group_for'],'1 ');?>

					 						 </select>
					  						</td>
                                          <td><label>
                                            <input type="submit" name="show" value="GO" style="width:40px; height:27px;" />
                                            </label>
                                          </td>
                                        </tr>
                                      </table>
                                                                        </form>
									</td>
								  </tr>
								  <tr>
                                    <td style="padding-left:10px;">
									<div class="table table-bordered table-condensed">
                                        <? 	
										
										if($_POST['group_for']!="")

										$con .= 'and a.group_for="'.$_POST['group_for'].'"';
										
							   $res='select a.'.$unique.',a.'.$shown.' as party_name,b.category_name,  c.group_name from '.$table.' a,vendor_category b, user_group c where a.group_for = c.id and   a.vendor_category=b.id  '.$con.' order by a.vendor_name';
											echo $crud->link_report($res,$link);?>
                                    </div><?=paging(100);?></td>
						      </tr>
								</table>

							</div></td>
    <td valign="top"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>                                   
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td>
									<fieldset>
                                        <legend>Vendor  Details</legend>
                                        
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label style="width:180px;">Vendor  ID:</label>
                                          
                                          <input name="vendor_id" type="text" id="vendor_id" value="<?=$vendor_id?>">
                                        </div>
									<div>
                                          <label style="width:180px;"><span class="style1">*</span>Vendor  Name:</label>
                                          <input name="vendor_name" type="text" id="vendor_name" value="<?=$vendor_name?>" />
									</div>
									
									<div>
                                          <label style="width:180px;"><span class="style1">*</span>Beneficiary Name:</label>
                                          <input name="vendor_company" type="text" id="vendor_company" value="<?=$vendor_company?>" />
									</div>
									
									<div>
                                          <label style="width:180px;"><span class="style1">*</span>Beneficiary Bank:</label>
                                          <input name="vendor_bank" type="text" id="vendor_bank" value="<?=$vendor_bank?>" />
									</div>
									
									<div>
                                          <label style="width:180px;"><span class="style1">*</span>Account Number:</label>
                                          <input name="vendor_bank_ac" type="text" id="vendor_bank_ac" value="<?=$vendor_bank_ac?>" />
									</div>
									
									<div>
                                          <label style="width:180px;"><span class="style1">*</span>Branch Name:</label>
                                          <input name="branch_name" type="text" id="branch_name" value="<?=$branch_name?>" />
									</div>
									
									<div>
                                          <label style="width:180px;"><span class="style1">*</span>IBAN:</label>
                                          <input name="iban_no" type="text" id="iban_no" value="<?=$iban_no?>" />
									</div>
									
									<div>
                                          <label style="width:180px;"><span class="style1">*</span>Swift Code:</label>
                                          <input name="swift_code" type="text" id="swift_code" value="<?=$swift_code?>" />
									</div>
									
				
									
									
									<div>
                                         
                                  <label style="width:180px;">Concern Company:</label>
                                  <select name="group_for" id="group_for">
                                    <option></option>
                                    <?	$sql="select * from user_group where 1 order by group_name";
											$query=db_query($sql);
											while($datas=mysqli_fetch_object($query))
										{
										?>
                                    <option <? if($datas->id==$group_for) echo 'Selected ';?> value="<?=$datas->id?>">
                                      <?=$datas->group_name?>
                                    </option>
                                    <? } ?>
                                  </select>
								  
								  <input name="ledger_id" type="hidden" id="ledger_id" value="2001000100000000" size="20" maxlength="16" />
				
								  
									</div>
									
									
									

									
                                      
									<div>
                                         
                                  	<label style="width:180px;">Status:</label>
                                          
                                          <select name="status" id="status">
                                          <option><?=$status?></option>
                                          <option>ACTIVE</option>
                                           <option>INACTIVE</option>
                                          </select>
                                    </div>
                                        
                                   <div>
                                          <label style="width:180px;"><span class="style1">*</span>Address:</label>
                                          <input name="address" type="text" id="address" value="<?=$address?>" />
									</div>
                                     <div>
                                          <label style="width:180px;">Contact No:</label>
                                          <input name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" />
									</div>
                                     <div>
                                       <label style="width:180px;">Vendor Type:</label>
                                       <select name="vendor_type" id="vendor_type">
                                       <? foreign_relation('vendor_type','id','vendor_type',$vendor_type);?>
                                       </select>
                                     </div>
                                     <div>
                                          <label style="width:180px;">Fax No:</label>
                                          <input name="fax_no" type="text" id="fax_no" value="<?=$fax_no?>" />
									</div>
                                    <div>
                                          <label style="width:180px;">Email Address:</label>
                                          <input name="email" type="text" id="email" value="<?=$email?>" />
									</div>
                                     <div>
                                          <label style="width:180px;">Contact Person Name:</label>
                                          <input name="contact_person_name" type="text" id="contact_person_name" value="<?=$contact_person_name?>" />
									</div>
                                     <div>
                                          <label style="width:180px;">Contact P Designation:</label>
                                          <input name="contact_person_designation" type="text" id="contact_person_designation" value="<?=$contact_person_designation?>" />
									</div>
                                     <div>
                                          <label style="width:180px;">Contact Person Mobile:</label>
                                          <input name="contact_person_mobile" type="text" id="contact_person_mobile" value="<?=$contact_person_mobile?>" />
									</div>
									</fieldset>									</td>
								  </tr>
                             
 


                           </table>
                             
                             
                             <tr>
                               <td>&nbsp;</td>
                             </tr>
            
                            <tr>
                              <td>
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
									  <div class="button">
										<? if(!isset($_GET[$unique])){?>
										<input name="insert" type="submit" id="insert" value="Save" class="btn" />
										<? }?>	
										</div>										</td>
										<td>
										<div class="button">
										<? if(isset($_GET[$unique])){?>
										<input name="update" type="submit" id="update" value="Update" class="btn" />
										<? }?>	
										</div>									</td>
                                      <td>
									  <div class="button">
									  <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
									  </div>									  </td>
                                      <td>
									  <div class="button">
									  <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
									  </div>									  </td>
                                    </tr>
                                </table></td>
                            </tr>
        </table>
    </form></td>
  </tr>
</table>
</div>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>