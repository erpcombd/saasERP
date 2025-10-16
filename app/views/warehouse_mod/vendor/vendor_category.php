<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Vendor Category';			// Page Name and Page Title

do_datatable('table_head');

$page="vendor_category.php";		// PHP File Name



$table='vendor_category';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='category_name';				// For a New or Edit Data a must have data field



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

		$_POST['entry_by'] = $_SESSION['user']['id'];
		 
		 $_POST['entry_at'] = $now=date('Y-m-d H:i:s');	

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();

		$id = $_POST['dealer_code'];
		
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{


		$_POST['edit_by'] = $_SESSION['user']['id'];
		 
		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');


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







<div class="container-fluid">
    <div class="row">
        <div class="col-sm-7">
            <div class="container p-0">
                <form id="form1" name="form1" class="n-form1" method="post" action="" >


                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company</label>
                        <div class="col-sm-9 p-0">
                             <select name="group_for" required id="group_for" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>

                        </div>
                    </div>
					
					<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Category Name</label>
                        <div class="col-sm-9 p-0">
                             	<input name="category_name" class="m-0" type="text" id="category_name" value="<?php echo $_POST['category_name']; ?>" />

                        </div>
                    </div>
					
					
					

                    <div class="n-form-btn-class">
                        <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                        <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear" />
                    </div>

                </form>
            </div>


            <div class="container n-form1">
                
				
<?

//if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr class="bgc-info" >
  	<th width="8%">ID</th>
	<th>Category Name</th>
	<th width="10%">Status</th>
	<th width="10%">Action</th>
</tr>
</thead>

<tbody>

<?php
if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['category_name']!="")

$con .='and a.category_name like "%'.$_POST['category_name'].'%" ';

 $td='select a.'.$unique.',  a.'.$shown.' ,   a.status from '.$table.' a, user_group u	where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'"   '.$con.' order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> >
  	<td><?=$rp[0];?></td>
	<td><?=$rp[1];?></td>
	<td><?=$rp[2];?></td>
	<td>
	<button type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
	</td>
</tr>

<?php }?>
</tbody>
</table>

<? //}?>
				
				
				

            </div>

        </div>


        <div class="col-sm-5">
            
			
            <form class="n-form"   action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label "> Category</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input class="m-0" name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        <input class="m-0" name="category_name" required type="text" id="category_name" tabindex="1"  value="<?=$category_name?>"  >	


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Company </label>
                    <div class="col-sm-9 p-0">
                        <select  name="group_for" required id="group_for"  tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Status  </label>
                    <div class="col-sm-9 p-0">

                       <select name="status" id="status" >

                              <option value="<?=$status?>"><?=$status?></option>

                              <option value="ACTIVE">ACTIVE</option>

                               <option value="INACTIVE">INACTIVE</option>


                        </select>

                    </div>
                </div>

                <div class="n-form-btn-class">
                    <? if(!isset($_GET[$unique])){?>
                      <input class="btn1 btn1-bg-submit" name="insert" type="submit" id="insert" value="Save" class="btn" />
                      <? }?>
					  
					  
					 <? if(isset($_GET[$unique])){?>
                      <input class="btn1 btn1-bg-update" name="update" type="submit" id="update" value="Update" class="btn" />
                      <? }?>
					  
					  
					   <input class="btn1 btn1-bg-cancel" name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" /> 

                </div>


            </form>

        </div>

    </div>




</div>


































<?php /*?><table border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td>
										<div class="box">
											<form id="form1" name="form1" method="post" action="">
												<table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
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

                                        <td align="right"> Category Name:                                         </td>

                                        <td align="right">
											<input name="category_name" type="text" id="category_name" style="width:250px; float:left;" value="<?php echo $_POST['category_name']; ?>" size="20" />
											</td>

                                      </tr>

                                      <tr>

                                        <td colspan="2">
											<div align="center">
                                          		<input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                                          		<input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Reset" />
                                        	</div>
										</td>

                                      </tr>

                                    </table>

								    </form>
										</div>
									</td>

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

<th bgcolor="#45777B"><span class="style3">Category Name </span></th>

<th bgcolor="#45777B"><span class="style3">Status</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['category_name']!="")

$con .='and a.category_name like "%'.$_POST['category_name'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.' ,   a.status from '.$table.' a, user_group u	where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'"   '.$con.' order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td><?=$rp[1];?></td>

<td><?=$rp[2];?></td>
</tr>

<?php }?>
</tbody>
</table>

<? //}?>

									<div id="pageNavPosition"></div>									</td>

								  </tr>

		</table>



	</div></td>

    <td valign="top" width="40%"><div class="right">
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

                                     <td><span class="style1" style="padding-top:5px;">*</span>Category :</td>

                                        <td>
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        				<input name="category_name" required type="text" id="category_name" tabindex="1"  style="width:250px;" value="<?=$category_name?>"  >	
										 
										
										</td>
                                      </tr>
									  
									  


                                      

                                      <tr>

                                        <td>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for" style="width:250px;"  tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select></td>
                                      </tr>
									  
									  <tr>

                                        <td>Status:</td>

                                        <td><select name="status" id="status" style="width:250px;" >

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="ACTIVE">ACTIVE</option>

                                          <option value="INACTIVE">INACTIVE</option>


                                        </select></td>

                                      </tr>
             

                                      

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>
                                      </tr>
									</table>

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
                  <td>
				  <div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input class="btn1 btn1-bg-submit" name="insert" type="submit" id="insert" value="Save" class="btn" />
                      <? }?>
                    </div>
					</td>
                  <td>
				  
				  
				  <div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input class="btn1 btn1-bg-update" name="update" type="submit" id="update" value="Update" class="btn" />
                      <? }?>
                    </div>
					</td>
                  <td>
				  <div class="button">
                      <input class="btn1 btn1-bg-cancel" name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                    </div>
					</td>
					
                  <td>
                  <!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->                    
					</td>
					
                </tr>
							        </table>
								  </div>								  </td>
                                </tr>
                              </table>

    </form>

							</div></td>

  </tr>

</table><?php */?>





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