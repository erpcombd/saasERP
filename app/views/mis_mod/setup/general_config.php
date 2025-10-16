<?php
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 



$title='General Configuration';			// Page Name and Page Title

do_datatable('table_head');

$page="general_config.php";		// PHP File Name

$table='general_configuration';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='group_for';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);
$$unique = find_a_field('general_configuration','id','group_for="'.$_SESSION['user']['group'].'"');

//for Insert..................................

if(isset($_POST['insert']))

{		

$_POST['proj_id']= $_SESSION['proj_id'];

$now = time();

$_POST['group_for']=$_SESSION['user']['group'];

$_POST['edit_by'] = $_SESSION['user']['id'];
$_POST['edit_by'] = date('Y-m-d H:i:s');

$crud->insert();
	
$type=1;

$msg='New Entry Successfully Inserted.';

echo "<script>window.top.location='".$page."'</script>";

}





//for Modify..................................



if(isset($_POST['update']))

{
        
$_POST['group_for']=$_SESSION['user']['group'];
$_POST['edit_at'] = date('Y-m-d H:i:s');
$_POST['edit_by'] = $_SESSION['user']['id'];

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

}

//for Delete..................................






if(isset($$unique))

{

$condition="group_for='".$$unique."'";

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

//if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>

<style type="text/css">

<!--

.style1 {color: #FF0000}
.style2 {
	font-weight: bold;
	color: #000000;
	font-size: 14px;
}
.style3 {color: #FFFFFF}

-->

</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
<!--<?=$$unique?>-->
  <tr>

    

    <td valign="top" width="100%">
	<div class="left">   
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2" style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B">
								  										<div align="center">
                                          <?=$title?>
                                        </div>
								  </td>
								  
                                </tr>

                                <tr>
								
								
								

                                  <td width="100%" colspan="2" style="padding-top:10px;">
								  
								  
								  
								  <div class="box" style="width:400px; padding-top:10px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
									
									<input name="id" type="hidden" value="<?=$$unique?>"/>

									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Role Type:</td>
									   <td>
										<select name="menu_format"id="menu_format" tabindex="1" class="form-control" >
										<option></option>
										<option <?=($menu_format=='Menu_wise')?'selected':''?>>Menu_wise</option>
										<option <?=($menu_format=='Role_wise')?'selected':''?>>Role_wise</option>
										</select>
									
										</td>
                                      </tr>
									  
									  <tr>
									   <td><span class="style1" style="padding-top:5px;"></span>Cash/Bank Reconsilation:</td>
									   <td>
										<select name="cash_bank_reconsilation"id="cash_bank_reconsilation" tabindex="1" class="form-control" >
										<option></option>
										<option <?=($cash_bank_reconsilation=='Yes')?'selected':''?>>Yes</option>
										<option <?=($cash_bank_reconsilation=='No')?'selected':''?>>No</option>
										</select>
									
										</td>
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

								    <table width="30%" border="0" cellspacing="0" cellpadding="0" align="center">

					<tr>
					<? if($$unique==''){?>
                 	 <td><div class="button">
                      <!--<input name="insert" type="submit" id="insert" value="SAVE" class="btn btn-primary" />-->
					  </div>
					  </td>
					<? }else{?>
                 	 <td>
				  	<div class="button">
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn btn-success" />
                      <? }?>
                    </div></td>
                 <!-- <td><div class="button">
                      <input name="reset" type="button" class="btn btn-warning" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
                    </div></td>-->
                  
                </tr>
							        </table>
								  </div>								  </td>
                                </tr>
                              </table>

    </form>

							</div></td>

  </tr>

</table>


<?

	 require_once SERVER_CORE."routing/layout.bottom.php";

?>