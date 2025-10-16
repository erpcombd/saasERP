<?php
session_start();
ob_start();
require "../../support/inc.all.php";

// ::::: Edit This Section ::::: 

$title='Room Reservation';			// Page Name and Page Title
$page="reservation.php";		// PHP File Name

$table='hms_reservation';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='client_name';				// For a New or Edit Data a must have data field


do_calander('#check_in_date');
do_calander('#check_out_date');
do_calander('#last_reserve_date');
$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']))
{		
$proj_id			= $_SESSION['proj_id'];
$now				= time();


$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['update']))
{

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
<div class="form-container_large">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
                                    <td>
									<div class="tabledesign">
                                        <? 	$res='select '.$unique.','.$unique.','.$shown.' from '.$table;
											echo $crud->link_report($res,$link);?>
                                    </div><?=paging(50);?></td>
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
                                        <legend><?=$title?></legend>
                                        
                                        <div> </div>
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label>Check In Date :</label>
                                          <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                                          <input name="check_in_date" type="text" id="check_in_date" value="<?=$check_in_date?>">
                                        </div>
									<div>
                                          <label>Check Out Date:</label>
                                          <input name="check_out_date" type="text" id="check_out_date" value="<?=$check_out_date?>" />
									</div>
										<div>
                                          <label>Client Name  :</label>
                                          <input name="client_name" type="text" id="client_name" value="<?=$client_name?>" />
                                        </div>
										<div>
                                          <label>Client Address :</label>
                                          <input name="client_address" type="text" id="client_address" value="<?=$client_address?>" />
                                        </div>
										<div>
                                          <label>Contact No :</label>
                                          <input name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" />
                                        </div>
										<div>
                                          <label>No of Room :</label>
                                          <input name="no_of_room" type="text" id="no_of_room" value="<?=$no_of_room?>" />
                                        </div>
										<div>
                                          <label>No of Adult :</label>
                                          <input name="no_of_adult" type="text" id="no_of_adult" value="<?=$no_of_adult?>" />
                                        </div>
										<div>
                                          <label>No of Child :</label>
                                          <input name="no_of_child" type="text" id="no_of_child" value="<?=$no_of_child?>" />
                                        </div>
										<div>
                                          <label>Last Reserve Date :</label>
                                          <input name="last_reserve_date" type="text" id="last_reserve_date" value="<?=$last_reserve_date?>" />
                                        </div>
										<div>
                                          <label>Member ID:</label>
                                          <input name="client_id" type="text" id="client_id" value="<?=$client_id?>" />
                                        </div>
										<div>
                                          <label>Reserve Type :</label>
                                          <select name="reserve_type">
										  <option value="0">Manual</option>
										  <option value="1">Fixed</option>
										  </select>
                                        </div>
									</fieldset>									</td>
								  </tr>
								  
								</table></td>
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
include ("../../template/main_layout.php");
?>