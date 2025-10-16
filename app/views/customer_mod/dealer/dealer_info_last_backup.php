<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='ADD Customer Information';			// Page Name and Page Title

do_datatable('vendor_table');

$page="dealer_info.php";		// PHP File Name



$table='dealer_info';		// Database Table Name Mainly related to this page

$unique='dealer_code';			// Primary Key of this Database table

$shown='dealer_name_e';				// For a New or Edit Data a must have data field



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

if ($_POST['dealer_found']==0) {
	

$proj_id			= $_SESSION['proj_id'];

$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');

$wh_data = find_all_field('warehouse','','warehouse_id='.$_POST['depot']); 

$_POST['ledger_group_id']=$wh_data->ledger_group;

$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%05d", $cy_id);


$_POST['account_code'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$_POST['ledger_name'] = $_POST['dealer_name_e'];


$crud->insert();


$dealer_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);

if ($dealer_gl_found==0) {
   $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)
  
  VALUES("'.$_POST['account_code'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$_POST['group_for'].'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';

db_query($acc_ins_led);
}
		
		
	
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);


}

}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

		$id = $_POST['dealer_code'];




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

								    <td><div class="box"><form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box style2" style="width:100%;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>
								
						
                                  <td width="100%" colspan="2"><div class="box" style="width:100%;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      

									  

									  <!--<tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>Customer Code:</td>

                                        <td>
										
                       					<input name="dealer_code" type="hidden" id="dealer_code" tabindex="1" value="<?=$dealer_code?>" readonly>
                        				<input name="customer_id" required type="text" id="customer_id" tabindex="1" value="<?=$customer_id?>"  style="width:250px;"
										
										onblur="getData2('customer_code_ajax.php', 'customer_code_info',this.value,document.getElementById('customer_id').value);" >	
										
										<span id="customer_code_info">
                                       
										
										 </span></td>
                                      </tr>-->
									  
									  
									  
									  

                                      <tr>

                                        <td width="20%"><span class="style1" style="padding-top:5px;">*</span>Name:</td>

                                        <td width="80%" >
										
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                                        <input name="dealer_name_e" required type="text" id="dealer_name_e" tabindex="1" value="<?=$dealer_name_e?>" style="width: 95%;"
										onchange="getData2('customer_exist_ajax.php', 'customer_info_fount', this.value, document.getElementById('dealer_name_e').value);"></td>
									  </tr>
									  
									   <span id="customer_info_fount">
									   
									   </span>
									  
									  <tr>

                                        <td width="20%">VAT No:</td>

                                        <td width="80%"><input name="vat_no" type="text" id="vat_no" tabindex="2" value="<?=$vat_no?>"  style="width:95%;"/></td>
                                      </tr>
									  
									  <tr>

                                        <td width="20%">C.R No:</td>

                                        <td width="80%"><input name="cr_no" type="text" id="vacr_not_no" tabindex="3" value="<?=$cr_no?>"  style="width:95%;"/></td>
                                      </tr>
									  
								
									  
									  <tr>

                                        <td width="20%"> Address:</td>

                                        <td width="80%"><input name="address_e" type="text" id="address_e" tabindex="4" value="<?=$address_e?>" style="width:95%;"></td>
									  </tr>
									

                                      <tr>

                                        <td width="20%">Mobile No:</td>

                                        <td width="80%"><input name="mobile_no" type="text" id="mobile_no" tabindex="5" value="<?=$mobile_no?>"  style="width:95%;"/></td>
                                      </tr>

                                      <tr>

                                        <td width="20%">E-mail:</td>

                                        <td width="80%"><input name="email" type="text" id="email" tabindex="6" value="<?=$email?>" style="width:95%;">
						
						
					
						
						
						 <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_SESSION['user']['id']?>"  style="width:95%;"/></td>
                                      </tr>
									  
									  
									  
									  
									<?php /*?>  <tr>

                                        <td>Building No:</td>

                                        <td><input name="building_no" type="text" id="building_no"  value="<?=$building_no?>"  style="width:250px;"/></td>
                                      </tr>
									  
									  <tr>

                                        <td>Street Name:</td>

                                        <td><input name="street_name" type="text" id="street_name"  value="<?=$street_name?>"  style="width:250px;"/></td>
                                      </tr>
									  
									  <tr>

                                        <td>District:</td>

                                        <td><input name="district" type="text" id="district"  value="<?=$district?>"  style="width:250px;"/></td>
                                      </tr>
									  
									  <tr>

                                        <td>City:</td>

                                        <td><input name="city" type="text" id="city"  value="<?=$city?>"  style="width:250px;"/></td>
                                      </tr>
									  
									  <tr>

                                        <td>Postal Code:</td>

                                        <td><input name="postal_code" type="text" id="postal_code"  value="<?=$postal_code?>"  style="width:250px;"/></td>
                                      </tr>
									  
									  <tr>

                                        <td>Country:</td>

                                        <td><input name="country" type="text" id="country"  value="<?=$country?>"  style="width:250px;"/></td>
                                      </tr>
<?php */?>
                                     
									  
									  <tr>

                                        <td width="20%"><span class="style1" style="padding-top:5px;">*</span>Type:</td>

                                        <td width="80%">
									
										<select name="dealer_type" required id="dealer_type" style="width:95%;" tabindex="7">
										<option></option>
                    					  <? foreign_relation('sales_type','id','dealer_type',$dealer_type,'1');?>
                    					</select></td>
                                      </tr>
									   
             

                                      <tr>

                                        <td width="20%"><span class="style1" style="padding-top:5px;">*</span>Warehouse:</td>

                                        <td width="80%">
										<input name="group_for" type="hidden" id="group_for"  value="<?=$_SESSION['user']['group']?>"  style="width:95%;"/>
										<select name="depot" required id="depot" style="width:95%;" tabindex="7">
                    					  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'warehouse_id="'.$_SESSION['user']['depot'].'"');?>
                    					</select></td>
                                      </tr>
									  

                                    

                                      

                                      <tr>

                                        <td width="20%">&nbsp;</td>

                                        <td width="80%">&nbsp;</td>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                

                                <tr>

                                  <td colspan="2">&nbsp;</td>
                                </tr>

                                <tr>

                                  <td colspan="2">

								  <div class="box1">

								    <table width="60%" border="0" cellspacing="0" align="right" cellpadding="0">

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

    </form></div></td>
						      </tr>

								  <tr>

									<td>&nbsp;</td>
								  </tr> <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="vendor_table" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">ID</span></th>

<th bgcolor="#45777B"><span class="style3">Customer Name </span></th>

<th bgcolor="#45777B"><span class="style3">GL Code</span></th>
<th bgcolor="#45777B"><span class="style3">Address</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['depot']!="")

$con .= 'and a.depot="'.$_POST['depot'].'"';






  $td='select a.'.$unique.',  a.'.$shown.' as customer_name,  w.warehouse_name, a.address_e, a.account_code from '.$table.' a, user_group u, warehouse w
				where   a.group_for=u.id and a.depot=w.warehouse_id  and a.group_for="'.$_SESSION['user']['group'].'" and  a.depot="'.$_SESSION['user']['depot'].'"   '.$con.' order by a.dealer_code asc ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td><?=$rp[1];?></td>

<td><?=$rp[4];?></td>
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

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>