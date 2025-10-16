<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


create_combobox('dealer_code');

// ::::: Edit This Section :::::

$title='Price List';	// Page Name and Page Title

do_datatable('vendor_table');			

$page="count_measurement.php";			// PHP File Name

$table='count_measurement';				// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='count';				// For a New or Edit Data a must have data field


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

										<select name="group_for" required id="group_for" style="width:250px; float:left;" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>
										
										</td>

                                      </tr>
									
									
									

                                      <!--<tr>

                                        <td width="40%" align="right">Warehouse:                                       </td>

                                        <td width="60%" align="right">
										
									


										<select name="depot"  id="depot" style="width:250px; float:left" tabindex="7">
										
										<option></option>

                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot'],'1');?>
                    </select></td>

                                      </tr>-->

                                      

                                      <?php /*?><tr>

                                        <td align="right"> Merchandiser Code:                                         </td>

                                        <td align="right"><input name="customer_code" type="text" id="customer_code" style="width:250px; float:left;" value="<?php echo $_POST['customer_code']; ?>" size="20" /></td>

                                      </tr><?php */?>

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

<table  id="vendor_table" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">Code</span></th>

  <th bgcolor="#45777B"><span class="style3">Count</span></th>
  <th bgcolor="#45777B"><span class="style3">UOM</span></th>
  <th bgcolor="#45777B"><span class="style3">Measurement</span></th>
  <th bgcolor="#45777B"><span class="style3">Price WHT($)</span></th>
  <th bgcolor="#45777B"><span class="style3">Price DTM($)</span></th>
  <th bgcolor="#45777B"><span class="style3">Customer</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['depot']!="")

$con .= 'and a.depot="'.$_POST['depot'].'"';


if($_POST['customer_code']!="")

$con .='and a.merchandizer_code like "%'.$_POST['customer_code'].'%" ';





   $td='select a.'.$unique.', a.'.$shown.', a.uom, a.measurement, a.price_white, a.price_dtm, a.dealer_code from '.$table.' a
				where 1 '.$con.' order by a.dealer_group, a.id';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

  <td><?=$rp[1];?></td>
  <td><?=$rp[2];?></td>
  <td><?=$rp[3];?></td>
  <td><?=$rp[4];?></td>
  <td><?=$rp[5];?></td>
  <td><?=find_a_field('dealer_info','dealer_name_e',"dealer_code=".$rp[6]);?></td>
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

                                        <td><span class="style1" style="padding-top:5px;">*</span>Customer:</td>

                                        <td>
										
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
										
										<select name="dealer_code" required id="dealer_code" style="width:250px;" tabindex="1">
										<option></option>

                      						<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'1');?>
                    					</select>
										</td>
									  </tr>
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Count:</td>

                                        <td>
										 <input name="count" type="text" id="count" tabindex="2" value="<?=$count?>" style="width:250px;"></td>
                                      </tr>
									  
									  
							
									  
									  <tr>

                                        <td>UOM: </td>

                                        <td>

                                       <input name="uom" type="text" id="uom" tabindex="3" value="<?=$uom?>" style="width:250px;"></td>
									  </tr>
									  
									  
									  
									   <tr>

                                        <td>Measurement:</td>

                                        <td><input name="measurement" type="text" id="measurement" tabindex="4" value="<?=$measurement?>"  style="width:250px;"/></td>
                                      </tr>

                                      <tr>

                                        <td>Price White($):</td>

                                        <td><input name="price_white" type="text" id="price_white" tabindex="5" value="<?=$price_white?>" required style="width:250px;">
						
						
						
						 <input name="entry_by" type="hidden" required id="entry_by" value="<?=$_SESSION['user']['id']?>"  style="width:250px;"/></td>
                                      </tr>
									  
									  
									  <tr>

                                        <td>Price DTM($):</td>

                                        <td><input name="price_dtm" type="text" id="price_dtm" tabindex="6" value="<?=$price_dtm?>" required style="width:250px;">
										
										
										
										<input name="group_for" type="hidden" id="group_for" tabindex="7" value="<?=$_SESSION['user']['group'];?>" required style="width:250px;">
						
						
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

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>