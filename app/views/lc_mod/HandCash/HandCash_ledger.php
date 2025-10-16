<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='HandCash Ledger';			// Page Name and Page Title

do_datatable('table_head');

$page="HandCash_ledger.php";		// PHP File Name



$table='handcash_ledger';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='handcash_ledger';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::




$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{	


	

$proj_id			= $_SESSION['proj_id'];

$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');

$group_for=$_SESSION['user']['group'];

$balance_type='Both';

$ledger_group_id=$_POST['ledger_group'];

$ledger_name = $_POST['handcash_ledger'].' - (IOU)';

if(!ledger_redundancy($ledger_name))
	{
	$type=0;
	$msg='Given Name('.$ledger_name.') is already exists.';
	}
	else
	{
	 $ledger_id=next_ledger_id($ledger_group_id);
		$ledger_layer=1;
		if(ledger_create($ledger_id,$ledger_name,$ledger_group_id,$group_for,$opening_balance,$balance_type,$depreciation_rate,$credit_limit, $now,$ledger_layer,$budget_enable))
		{
		$type=1;
		$msg='New Entry Successfully Inserted.';
		}
	}



$_POST['ledger_id']=$ledger_id;





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

		
		 $company_id =$_POST['company_id'];
		 $ledger_id = $_POST['ledger_id'];

	  $sql1 = 'update accounts_ledger set ledger_name="'.$_POST['company_name'].'" 
	  where ledger_id = '.$ledger_id;
		db_query($sql1);




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

<style type="text/css">



</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Company:                                       </td>

                                        <td width="60%" align="right">

										<select name="group_for" required id="group_for" style="width:250px; float:left;" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>
										
										</td>

                                      </tr>
				
                                      

                                      

                                      <tr>

                                        <td colspan="2"><div align="center">
                                          <input class="btn" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn" name="cancel" type="submit" id="cancel" value="Cancel" />
                                        </div></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td>&nbsp;</td>

								  </tr> <tr>

									<td>



<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">ID</span></th>

<th bgcolor="#45777B"><span class="style3">HandCash</span></th>

<th bgcolor="#45777B"><span class="style3">Ledger ID </span></th>
<th bgcolor="#45777B"><span class="style3">Contact No </span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';









 $td='select a.'.$unique.',  a.'.$shown.', a.ledger_id, a.mobile_no from '.$table.' a where 1 order by a.id  ';

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



									<div id="pageNavPosition"></div>									</td>

								  </tr>

		</table>



	</div></td>

    <td valign="top" width="40%"><div class="right">   <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

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

                                     <td width="27%"><span class="style1" style="padding-top:5px;">*</span>HandCash:</td>

                                        <td width="73%">
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        				<input name="handcash_ledger" required type="text" id="handcash_ledger" tabindex="1"  style="width:250px;" value="<?=$handcash_ledger?>"  >	
										 
										
										</td>
                                      </tr>
									  
									  <tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>Ledger:</td>

                                        <td>
										
                        				
										
										
										<? if ($ledger_id==0) {?>
											<select name="ledger_group" required="required" id="ledger_group" style="width:250px; font-size:12px;" tabindex="2">
	
                                              <? foreign_relation('ledger_group','group_id','group_name',$ledger_group,'group_id=1013'); 
                                            </select>
											<? }?>
											
											<? if ($ledger_id>0) {?>
											<input name="ledger_id" type="text" id="ledger_id" tabindex="2" value="<?=$ledger_id?>"  readonly="" style="width:250px; font-size:12px;" />
											<? }?>
										 
										
										</td>
                                      </tr>
									  
									  
									 
									  
									
									 <tr>

                                     <td>Designation:</td>

                                        <td>
										
                        				<input name="designation"  type="text" id="designation" tabindex="3"  style="width:250px;" value="<?=$designation?>"  >	
										 
										
										</td>
                                      </tr>
									  
									  <tr>

                                     <td>Contact No:</td>

                                        <td>
										
                        				<input name="mobile_no"  type="text" id="mobile_no" tabindex="4"  style="width:250px;" value="<?=$mobile_no?>"  >	
										 
										
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

								    <table width="100%" border="0" cellspacing="0" cellpadding="0">

								      <tr>
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
                    </div></td>
                  <td>
                                    </td>
                </tr>
							        </table>
								  </div>								  </td>
                                </tr>
                              </table>

    </form>

							</div></td>

  </tr>

</table>

<script type="text/javascript"><!--


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