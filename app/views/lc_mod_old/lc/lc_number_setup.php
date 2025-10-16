<?php

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 

//create_combobox('bank_ledger');

$title='PI Reference Number Setup';			// Page Name and Page Title

do_datatable('table_head');

$page="lc_number_setup.php";		// PHP File Name



$table='lc_pi_reference_setup';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='pi_number';				// For a New or Edit Data a must have data field



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

//if ($_POST['dealer_found']==0) {}
	

$proj_id  = $_SESSION['proj_id'];

$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');



$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%04d", $cy_id);

$_POST['ledger_id'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$_POST['ledger_name'] = $_POST['pi_number'];




$crud->insert();





//$ledger_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);

//if ($ledger_gl_found==0) {
//    $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id,  balance_type,  proj_id,  acc_class, acc_sub_class, acc_sub_sub_class, group_for, entry_by, entry_at)
//  
//  VALUES("'.$_POST['ledger_id'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "Both", "'.$proj_id.'",  "'.$gl_group->acc_class.'", 
//  "'.$gl_group->acc_sub_class.'", "'.$gl_group->acc_sub_sub_class.'", "'.$gl_group->group_for.'", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';
//
//db_query($acc_ins_led);
//}
		
		
	
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);




}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

		
		 $id =$_POST['id'];
		 $ledger_id = $_POST['ledger_id'];

	 // $sql1 = 'update accounts_ledger set ledger_name="'.$_POST['lc_number'].'" 
//	  where ledger_id = '.$ledger_id;
//		db_query($sql1);




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

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Company:                                       </td>

                                        <td width="60%" align="right">

										<select name="group_for" required id="group_for" style="width:250px; float:left;" >

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

<?

//if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">ID</span></th>

<th bgcolor="#45777B"><span class="style3"> Reference No. </span></th>

<th bgcolor="#45777B"><span class="style3">Ledger ID </span></th>
<th bgcolor="#45777B"><span class="style3">Status</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



//if($_POST['category_name']!="")
//
//$con .='and a.category_name like "%'.$_POST['category_name'].'%" ';





   $td='select a.'.$unique.',  a.'.$shown.', a.status from '.$table.' a where 1 order by a.id  ';

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

                                     <td width="50%"><span class="style1" style="padding-top:5px;">*</span> Manual Number:</td>

                                        <td width="50%">
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        				<input name="pi_number" required type="text" id="pi_number" tabindex="1"  style="width:200px;" value="<?=$pi_number?>"  >	
										 
										
										</td>
                                      </tr>
									  
									<?php /*?>  <tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>GL Configuration:</td>

                                        <td>
										
                        				
										
										
										<? if ($ledger_id==0) {?>
											<select name="ledger_group" required="required" id="ledger_group" style="width:250px; font-size:12px;" tabindex="2">
	
											  <option></option>
                                              <? foreign_relation('ledger_group','group_id','group_name',$ledger_group,'group_class=100'); //acc_sub_class=203?>
                                            </select>
											<? }?>
											
											<? if ($ledger_id>0) {?>
											<input name="ledger_id" type="text" id="ledger_id" tabindex="2" value="<?=$ledger_id?>"  readonly="" style="width:250px; font-size:12px;" />
											<? }?>
										 
										
										</td>
                                      </tr>
									  <?php */?>
									  
									  <?php /*?><tr>

                                        <td>Commercial Licence:</td>

                                        <td>
										
										<select name="commercial_licence"  id="commercial_licence" style="width:200px;"  tabindex="3">
										
										<option></option>

                     					 <? foreign_relation('commercial_licence_info','company_id','company_name',$commercial_licence,'1');?>
                  					  </select>
									  
									  <input name="lc_type" required type="hidden" id="lc_type" tabindex="1"  style="width:200px;" value="1"  >	
									  </td>
                                      </tr><?php */?>
									  
									  <?php /*?><tr>
                                        <td>GL Group:</td>

                                        <td>
										
										<select name="ledger_group_id" required id="ledger_group_id" style="width:200px;"  tabindex="3">
										
										<option></option>

										  <? foreign_relation('ledger_group','group_id','group_name',$ledger_group_id,'acc_sub_sub_class=124 order by group_id');?>
										</select></td>
                                      </tr><?php */?>
				
									  
									  <!--<tr>
                                        <td>L/C Bank Ledger:</td>

                                        <td>
										
										
										<select name="bank_ledger" id="bank_ledger" required="required" style="width:200px;">
										  <option></option>
										  <? foreign_relation('accounts_ledger','ledger_id','ledger_name',$_POST['bank_ledger'],'ledger_group_id in (126002)');?>
										</select>
										
										
										</td>
                                      </tr>-->
									  
									  
									  
									  <tr>

                                        <td>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for" style="width:200px;"  tabindex="6">
										
										<option></option>

										  <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
										</select></td>
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

</table>

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