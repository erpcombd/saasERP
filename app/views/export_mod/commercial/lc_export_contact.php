<?php

//

//

 
 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 

$title='Export Sales Contract Information';			// Page Name and Page Title

do_datatable('vendor_table');

do_calander('#date');

$page="lc_export_contact.php";		// PHP File Name

$table='lc_export_contact';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='contact';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::

$lcAll=find_all_field('lc_master','','lc_no="'.$_REQUEST['lc_no'].'"');

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

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();

		
			
						
			}



if(isset($_POST['update']))

{



		$crud->update($unique);
		
	

	echo "<script>window.top.location='lc_export_contact.php?lc_no=".$_REQUEST['lc_no']."'</script>";

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

	echo "<script>window.top.location='lc_export_contact.php?lc_no=".$_REQUEST['lc_no']."'</script>";

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

	document.location.href = '<?=$page?>?lc_no=<?=$_REQUEST['lc_no']?>&<?=$unique?>='+theUrl;

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

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="vendor_table" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3">ID</span></th>

  <th bgcolor="#45777B"><span class="style3">LC NO</span></th>

  <th bgcolor="#45777B"><span class="style3">Export Sales Contract No </span></th>
  <th bgcolor="#45777B"><span class="style3">Date</span></th>
</tr>
</thead>

<tbody>

<?php






    $td='select * from '.$table.' 
				where lc_no='.$_REQUEST['lc_no'];

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td><?=find_a_field('lc_master','export_lc_no','lc_no="'.$rp[1].'"');?></td>

<td><?=$rp[2]?></td>
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

    <td valign="top" width="50%"><div class="right">
	
	
	   <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

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

                                        <td><span class="style1" style="padding-top:5px;">*</span>LC No:</td>

                                        <td>
										
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                            <input name="lc_nos" required type="text" id="lc_nos" tabindex="2" value="<?=$lcAll->export_lc_no?>" readonly="readonly" style="width:220px;">
							<input type="hidden" name="lc_no" id="lc_no" value="<?=$_REQUEST['lc_no']?>"/>
										
										</td>
									  </tr>
									  
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Sales Contract No:</td>

                                        <td>
										
										<input name="contact" required type="text" id="contact" tabindex="2" value="<?=$contact?>" style="width:220px;"></td></td>
                                      </tr>
									  
									  
									  
									  
									  
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Date: </td>

                                        <td>

                                       <input name="date" type="text" required id="date" tabindex="2" value="<?=$date?>" style="width:220px;">
									    <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_SESSION['user']['id']?>"  style="width:220px;"/>
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
					<? if(isset($_GET[$unique])){?>
                  <td><div class="button">
                      
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn" />
                    
                    </div>
					</td>
					<td><div class="button">
                      <input name="delete" type="submit" class="btn btn-danger btn-sm" id="delete" value="Delete" />
                    </div></td></td>
					  <? }?>
					<td><div class="button">
                      <input name="reset" type="button" class="btn" id="reset" value="Back" onclick="parent.location='lc_entry.php'" />
                    </div></td>
                  <td></td>
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