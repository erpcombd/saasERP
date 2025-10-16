<?php
session_start();
ob_start();
//require "../../support/inc.all.php";

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Vendor Information';
do_datatable('vendor_table');
$proj_id=$_SESSION['proj_id'];
//echo $proj_id;


$title='Vendor Category';			// Page Name and Page Title
$page="vendor_category.php";		// PHP File Name

$table='vendor_category';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='category_name';	

$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
$$unique = $_POST[$unique];

if(isset($_POST['insert']))
{		
$proj_id			= $_SESSION['proj_id'];
$now				= time();

		$_POST['entry_at']=date('Y-m-d h:i:s');
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
		$_POST['edit_at']=date('Y-m-d h:i:s');
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
?>

<script type="text/javascript">
function DoNav(theUrl)
{
	document.location.href = 'vendor_info.php?vendor_id='+theUrl;
}

</script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>


      <form id="form2" name="form2" method="post" action="vendor_category_input.php?vendor_id=<?php echo $vendor_id;?>" onsubmit="return check()">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
							
                                  <td><fieldset>
                                        
                                        <div class="buttonrow"></div>
										
									
										
										<div>
                                          <label>Catagory ID:</label>
                                          <input name="id" type="text" id="id" value="<?=$id?>">
                                        </div>
									     <div>
                                          <label>Catagory Name:</label>
                                          <input name="category_name" type="text" id="category_name" value="<?=$category_name?>" />
									       </div>
                                           <div>
                                      <label>Catagory Status:</label> 
                                      <select name="status" id="status">
                                      <option><?=$status?></option>
                                      <option>ACTIVE</option>
                                      <option>INACTIVE</option>
                                      </select>
                                    </div>
									</fieldset>		 </td>
                                </tr>
								<tr>
                              <td>
							    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td>
									  <div class="button">
										<? if(!isset($_GET[$unique])){?>
										<input name="insert" type="submit" id="insert" value="Save" class="btn btn-primary" />
										<? }?>	
										</div>										</td>
										<td>
										<div class="button">
										<? if(isset($_GET[$unique])){?>
										<input name="update" type="submit" id="update" value="Update" class="btn btn-primary" />
										<? }?>	
										</div>									</td>
                                      <td>
									  <div class="button">
									  <input name="reset" type="button" class="btn btn-info" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
									  </div>									  </td>
                                      <td>
									  <div class="button">
									  <input class="btn btn-danger" name="delete" type="submit" id="delete" value="Delete"/>
									  </div>									  </td>
                                    </tr>
                                </table></td>
                            </tr>
                              </table>
    </form>

<script type="text/javascript">

function DoNav(theUrl)



{
	//document.location.href = 'vendor_info.php?vendor_id='+theUrl;

}

function popUp(URL) 

{



	day = new Date();



	id = day.getTime();



	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");



}



</script>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>