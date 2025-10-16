<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section :::::

$title='Decimal Numbers';	// Page Name and Page Title

do_datatable('vendor_table');			

$page="decimal_numbers.php";			// PHP File Name

$table='decimal_numbers';				// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='number_format';				// For a New or Edit Data a must have data field


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

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();

		 $under=find_a_field('config_group_class','receivable',"group_for=".$_SESSION['user']['group']);

		$id = $_POST['dealer_code'];
		
		if($_FILES['cr_upload']['tmp_name']!=''){ 
		$file_temp = $_FILES['cr_upload']['tmp_name'];
		$folder = "../../images/cr_pic/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}


		
		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['np']['tmp_name']!=''){ 
		$file_temp = $_FILES['np']['tmp_name'];
		$folder = "../../np_pic/np/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['spp']['tmp_name']!=''){ 
		$file_temp = $_FILES['spp']['tmp_name'];
		$folder = "../../spp_pic/spp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['nsp']['tmp_name']!=''){ 
		$file_temp = $_FILES['nsp']['tmp_name'];
		$folder = "../../nsp_pic/nsp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		
		
		
		
		$name=$_POST['dealer_name_e'];
		
		
			 $sql_check="select ledger_group_id, balance_type, budget_enable from accounts_ledger where ledger_id='".$under."' limit 1";
			$sql_query=db_query($sql_check);
			if(mysqli_num_rows($sql_query)>0){
			$ledger_data=mysqli_fetch_row($sql_query);
				if(!ledger_redundancy($name))
				{
					$type=0;
					$msg='Given Name('.$name.') is already exists as Ledger.';
				}
			else
			{				
			$sub_ledger_id=number_format(next_sub_ledger_id($under), 0, '.', '');
			$group_for=$_SESSION['user']['group'];
			$ledger_layer=2;
			//sub_ledger_create($sub_ledger_id,$name, $under, $balance, $now, $proj_id);
			ledger_create_dealer($sub_ledger_id,$name,$ledger_data[0],$group_for,$under,$ledger_data[1],'','', time(),$ledger_layer,$ledger_data[2],$dealer_code);
			
			
					$type=1;
					$msg='New Entry Successfully Inserted.';
					
			
						
			}

		}
		else
		{
		$type=0;
		$msg='Invalid Accounts Ledger!!!';
		}
		
		

		$update_sql = 'update dealer_info d, accounts_ledger a set d.account_code=a.ledger_id where d.dealer_code=a.dealer_code and d.dealer_code="'.$dealer_code.'"';
		$update = db_query($update_sql);
		
		
		
	
		
		
		
		
		
		
		
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

		$id = $_POST['dealer_code'];



		if($_FILES['cr_upload']['tmp_name']!=''){ 
		$file_temp = $_FILES['cr_upload']['tmp_name'];
		$folder = "../../images/cr_pic/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}


		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['np']['tmp_name']!=''){ 
		$file_temp = $_FILES['np']['tmp_name'];
		$folder = "../../np_pic/np/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['spp']['tmp_name']!=''){ 
		$file_temp = $_FILES['spp']['tmp_name'];
		$folder = "../../spp_pic/spp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		if($_FILES['nsp']['tmp_name']!=''){ 
		$file_temp = $_FILES['nsp']['tmp_name'];
		$folder = "../../nsp_pic/nsp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}

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
									
									
									

                                      <tr>

                                        <td width="40%" align="right">Customer:                                       </td>

                                        <td width="60%" align="left">
										
									


										<select name="dealer_src"  id="dealer_src" style="width:250px;" >
										<option></option>

                      						<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_src'],'group_for="'.$_SESSION['user']['group'].'"');?>
                    					</select></td>

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

<table  id="vendor_table" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th width="18" bgcolor="#45777B"><span class="style3">ID</span></th>

  <th width="105" bgcolor="#45777B"><span class="style3">Decimal Numbers </span></th>
  <th width="64" bgcolor="#45777B"><span class="style3">Buyer </span></th>

<th width="69" bgcolor="#45777B"><span class="style3">Customer </span></th>
<th width="69" bgcolor="#45777B"><span class="style3">Approval</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['dealer_src']!="")

$con .= 'and a.dealer_code="'.$_POST['dealer_src'].'"';


if($_POST['customer_code']!="")

$con .='and a.merchandizer_code like "%'.$_POST['customer_code'].'%" ';





  $td='select a.'.$unique.', a.'.$shown.', b.buyer_name, c.dealer_name_e, a.number_format, a.approval from '.$table.' a, user_group u, dealer_info c, buyer_info b
				where   a.group_for=u.id  and c.dealer_code=a.dealer_code and a.buyer_code=b.buyer_code and a.group_for="'.$_SESSION['user']['group'].'"   '.$con.' order by a.id asc ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

  <td><?=$rp[4];?></td>
  <td><?=$rp[2];?></td>

<td><?=$rp[3];?></td>
<td><?=$rp[5];?></td>
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
										
										<select name="dealer_code" required id="dealer_code" style="width:250px;" onchange="getData2('buyer_ajax.php', 'buyer_filter', this.value, 

document.getElementById('dealer_code').value);" >
										<option></option>

                      						<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'group_for="'.$_SESSION['user']['group'].'"');?>
                    					</select></td>
                                      </tr>
									  
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Buyer:</td>

                                        <td>
										<span id="buyer_filter">
										<select name="buyer_code" required id="buyer_code" style="width:250px;" tabindex="7" >
										<option></option>

                      						<? foreign_relation('buyer_info','buyer_code','buyer_name',$buyer_code,'group_for="'.$_SESSION['user']['group'].'"');?>
                    					</select>
										</span>
										</td>
                                      </tr>
									  
									  
									  
									  <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Decimal Numbers:</td>

                                        <td>
										
										<span id="buyer_code_filter">
										
										</span>

                                        <input name="number_format" required type="number" id="number_format" tabindex="2" value="<?=$number_format?>" style="width:250px;">
										 <input name="approval" type="hidden" id="approval" tabindex="2" value="No" style="width:250px;">
										</td>
									  </tr>
									  
									  
									  
									  


                                      <tr>

                                        <td><span class="style1" style="padding-top:5px;">*</span>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for" style="width:250px;" tabindex="7" >

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>
					<input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_SESSION['user']['id']?>"  style="width:250px;"/>
					</td>
                                      </tr>
             

                                      

									  

									  

								

									  

                                     

                                      <!--<tr>

                                        <td> CR No:</td>

                                        <td><input name="cr_no" type="text" id="cr_no" tabindex="9" value="<?=$cr_no?>"></td>
                                      </tr>

                                      <tr>

                                        <td> CR Upload:</td>

                                        <td><input style="padding:5px 5px 7px 5px;" name="cr_upload" type="file" id="cr_upload" value="<?=$cr_upload?>" /></td>
                                      </tr>-->
									  
									  
									  
									  
									  

                                    

                                      

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