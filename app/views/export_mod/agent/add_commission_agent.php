<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Commission Agent Setup';			// Page Name and Page Title

$page="add_commission_agent.php";		// PHP File Name
$input_page="add_commission_input.php"; $add_button_bar = 'Mhafuz';



$table='sales_commission_agent';		// Database Table Name Mainly related to this page

$unique='ca_id';			// Primary Key of this Database table

$shown='ca_name';				// For a New or Edit Data a must have data field







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

if($_POST['gf']==999) 

{unset($_SESSION['gf']);

unset($_POST['gf']);

}

?>



<script type="text/javascript"> function DoNav(lk){
window.open('../../pages/agent<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk ,"_blank" );

}




</script>

<!--<div class="form-container_large">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">



								  <tr>

									<td>--><form id="form2" name="form2" method="post" action="">

									  <table width="100%" class="table table-bordered" style="background-color:aqua;"cellspacing="0" cellpadding="0">

                                        <tr>

                                          <td>Concern Group: </td>

                                          <td><select name="gf" id="gf" class="form-control" style="height:35px;">

                                              <option value="999">All</option>

                                              <?	$sql="select * from user_group where status!=1 order by group_name";

											$query=db_query($sql);

											while($datas=mysqli_fetch_object($query))

										{

										?>

					  <option <? if($datas->id==$_POST['gf']) echo 'Selected ';?> value="<?=$datas->id?>">

					  <?=$datas->group_name?>

					  </option>

                                              <? } ?>

                                          </select></td>

                                          <td><label>

                                            <input class="form-control" type="submit" name="show" value="GO" style="width:45px; height:41px;" />

                                            </label>

                                          </td>

                                        </tr>

                                      </table>

                                                                        </form>

									</td>

								  </tr>

								  <tr>

                                    <td>

									<div class="tabledesign">

                                        <? 	 



$res='select a.'.$unique.', a.'.$unique.' as agent_id, a.'.$shown.' as agent_name, w.warehouse_name as depot_name from '.$table.' a, warehouse w where a.warehouse_id = w.warehouse_id order by a.ca_id';

											echo $crud->link_report($res,$link);?>

                                    </div></td>

						      </tr>

								</table>



							</div></td>

    <?php /*?><td valign="top">
	
	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">



      <table width="100%" border="0" cellspacing="0" cellpadding="0">

                            <tr>

                              <td>                                   

							    <table width="100%"  cellspacing="0" cellpadding="0">

								  <tr>

									<td>

									<fieldset>

                                        <legend>Commission Agent   Details</legend>

                                        

                                        <div> </div>

                                        <div class="buttonrow"></div>

										

									

										

										<div>

                                          <label>Agent  ID:</label>

                                          

                                          <input class="form-control" name="ca_id" type="text" id="ca_id" value="<?=$ca_id?>">

                                        </div>

									<div>

                                          <label> Agent Name:</label>

                                          <input class="form-control" name="ca_name" type="text" id="ca_name" value="<?=$ca_name?>" />

									</div>

									

									<div>

                                         

                                  <label>Concern Company:</label>

                                  <select class="form-control" name="group_for" id="group_for">


                                    <?	$sql="select * from user_group where status!=1 order by group_name";

											$query=db_query($sql);

											while($datas=mysqli_fetch_object($query))

										{

										?>

                                    <option <? if($datas->id==$group_for) echo 'Selected ';?> value="<?=$datas->id?>">

                                      <?=$datas->group_name?>

                                    </option>

                                    <? } ?>

                                  </select>

									</div>

                                      

								

                                     <div>

                                          <label>Contact No:</label>

                                          <input class="form-control" name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>" />

									</div>
									
									
									
									 <div>

                                          <label>Area Name:</label>

                                          <select name="area_id" id="area_id" class="form-control" requi>
										  
										  	<option></option>

                      						  <? foreign_relation('area','AREA_CODE','AREA_NAME',$area_id,' 1');?>
                      					</select>

									</div>

                                     

                                     

                                    <div>

                                          <label>Sales Depot:</label>

                                          <select name="warehouse_id" id="warehouse_id" class="form-control" requi>
										  
										  	<option></option>

                      						  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,' center_depot= "Yes" and warehouse_id!=5');?>
                      					</select>

									</div>
									
									
									

                                        

                                       

                                     <div>

                                          <label>Address:</label>

                                          <input class="form-control" name="address" type="text" id="address" value="<?=$address?>" />

									</div>
									
									
										<div>

                                         

                                  <label>Status:</label>

                                          

                                          <select name="status" id="status" class="form-control">

                                          <option><?=$status?></option>

                                          <option>ACTIVE</option>

                                           <option>INACTIVE</option>

                                          </select>

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

										<input class="form-control" name="insert" type="submit" id="insert" value="Save" class="btn" />

										<? }?>	

										</div>										</td>

										<td>

										<div class="button">

										<? if(isset($_GET[$unique])){?>

										<input class="form-control" name="update" type="submit" id="update" value="Update" class="btn" />

										<? }?>	

										</div>									</td>

                                      <td>

									  <div class="button">

									  <input class="form-control" name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />

									  </div>									  </td>

                                      <td>

									  <div class="button">

									  <input class="form-control" class="btn" name="delete" type="submit" id="delete" value="Delete"/>

									  </div>									  </td>

                                    </tr>

                                </table></td>

                            </tr>

        </table>

    </form></td><?php */?>

  <!--</tr>

</table>

</div>-->

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>