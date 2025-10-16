<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Company Define';			// Page Name and Page Title

do_datatable('table_head');

$page="company_define.php";		// PHP File Name



$table='company_define';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='user_id';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::





$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];

//for Insert..................................

if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];


		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:i:s');
	    $crud->insert();


		
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




}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

if(!isset($$unique)){ $$unique=db_last_insert_id($table,$unique);
}

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

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-7 p-0 pr-2">
            <div class="container p-0">
			<form id="form1" name="form1" class="n-form1 pt-0" method="post" action="">
			<h4 class="n-form-titel1 text-center">Search Company Define</h4>

                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company</label>
                        <div class="col-sm-9 p-0">
                             <select name="group_for" required id="group_for">

                     			 <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                   			 </select>

                        </div>
                    </div>
					<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">User Name</label>
                        <div class="col-sm-9 p-0">
                             <select name="suser_id" required id="suser_id">
                                  <option></option>
                     			 <? foreign_relation('user_activity_management','user_id','fname',$_POST['suser_id'],'status="Active"')?>
                   			 </select>

                        </div>
                    </div>

                    <div class="n-form-btn-class">
                        <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                        <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />
                    </div>

                </form>
            </div>


            <div class="container n-form1">
               <table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm">
					<thead>
						<tr>
							 <th><span>ID</span></th>
							
							<th><span>Company Name </span></th>
							
							<th><span>User Name</span></th>
							
							<th><span>Status</span></th>
						</tr>
					</thead>
					
					<tbody>
					
					<?php
					
					
					if($_POST['group_for']!=""){
					
					$con = 'and w.group_for="'.$_POST['group_for'].'"';
					}
					
					
					if($_POST['suser_id']>0){
					
					$con .='and d.user_id="'.$_POST['suser_id'].'"';
					}
					
					
					
					
					 $td='select d.id,w.group_name,u.fname,d.status from user_group w, user_activity_management u,company_define d where w.id=d.company_id and d.user_id=u.user_id '.$con.'';
					
					$report=db_query($td);
					
					while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
					
					<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
					 <td><?=++$i?></td>
					
					<td><?=$rp[1];?></td>
					
					<td><?=$rp[2];?></td>
					<td><?=$rp[3];?></td>
					
					</tr>
					
					<?php }?>
					</tbody>
					</table>
					
					<? //}?>

									<div id="pageNavPosition"></div>

            </div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
            
            <form class="n-form setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
                <h4 class="n-form-titel1 text-center"><?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label  req-input">Company</label>
                    <div class="col-sm-9 p-0">
                       <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	
                        <select name="company_id" required id="company_id">
						<option></option>
						<? foreign_relation('user_group','id','group_name',$company_id,'1')?>
						</select>	
						
                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">User Name: </label>
                    <div class="col-sm-9 p-0">
                       
                        <select name="user_id" required id="user_id">
						<option></option>
						<? foreign_relation('user_activity_management','user_id','fname',$user_id,'status!="Inactive"')?>
						</select>	

                    </div>
                </div>

               
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Status:  </label>
                    <div class="col-sm-9 p-0">

                       <select name="status" id="status">

                              <option></option>

                              <option <?=($status='Active')?'selected':''?> value="Active">Active</option>

                              <option <?=($status='Inactive')?'selected':''?> value="Inactive">Inactive</option>


                        </select>

                    </div>
                </div>

                <div class="n-form-btn-class">
                     <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }?>
                    
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>
                    
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
                  

                </div>


            </form>

        </div>

    </div>




</div>



<?php /*?><table class="w-100" border="0"><th></th>

  <tr>

    <td style="width:60%; verticle-align: top"><div class="left">

							<table class="w-100" border="0"><th></th>

								 								  <tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table class="w-100" border="0"><th></th>
									
									
									<tr>

                                        <td class="text-end" style="width:40%">

		    Company:                                       </td>

                                        <td class="text-end" style="width:60%">

										<select name="group_for" required id="group_for" style="width:250px; float:left;">

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select>
										
										</td>

                                      </tr>
									
									
									

                                      

                                      

                                      <tr>

                                        <td class="text-end"> Warehouse Name:                                         </td>

                                        <td class="text-end"><input name="warehouse_name" type="text" id="warehouse_name" style="width:250px; float:left;" value="<?php echo $_POST['warehouse_name']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td colspan="2"><div class="text-center">
                                          <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />
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

<table  id="table_head" class="table table-bordered">
<thead>
<tr>
  <th style="background-color:#45777B;"><span class="style3">ID</span></th>

<th style="background-color:#45777B;"><span class="style3">Warehouse Name </span></th>

<th style="background-color:#45777B;"><span class="style3">Address</span></th>
<th style="background-color:#45777B;"><span class="style3">Status</span></th>
</tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.' as warehouse_name,  a.address, a.status from '.$table.' a, user_group u where a.group_for=u.id and a.group_for="'.$_SESSION['user']['group'].'"  and a.use_type="WH" '.$con.' order by a.warehouse_id';

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

    <td style="verticle-align:top; width:40%"><div class="right">   <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table class="w-100" border="0"><th></th>
							  
							  
							  <tr>
								
								
								

                                  <td style="width:100%" colspan="2"><div class="box style2" style="width:400px;">

                                    <table style="width:100%" border="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" style="background-color:#45777B"> <div class="text-center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>
								
								
								

                                  <td style="width:100%" colspan="2"><div class="box" style="width:400px;">

                                    <table style="width:100%" border="0"><th></th>

                                      

									  

									  <tr>

                                     <td style="width:26%"><span class="style1" style="padding-top:5px;">*</span>Warehouse:</td>

                                        <td style="width:74%">
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>" readonly>
                        				<input name="warehouse_name" required type="text" id="warehouse_name" value="<?=$warehouse_name?>"  style="width:250px;" >	
										 <input name="use_type" type="hidden" id="use_type" value="WH" size="30" maxlength="100" class="required" />
										 
										 <input name="ledger_group" required type="hidden" id="ledger_group" value="<?=$ledger_group?>"  style="width:250px;" >
										 
										  <input name="cash_ledger" required type="hidden" id="cash_ledger" value="<?=$cash_ledger?>"  style="width:250px;" >
										
										</td>
                                      </tr>
									  
									  <tr>

                                        <td>Description:</td>

                                        <td>
										<input name="description" type="text" id="description" value="<?=$description?>" style="width:250px;"></td>
									  </tr>
									  
									  
									  <tr>

                                        <td>Address:</td>

                                        <td>
										<input name="address" type="text" id="address" value="<?=$address?>" style="width:250px;"></td>
									  </tr>
									  
									  <tr>

                                        <td>Contact Name: </td>

                                        <td>

                                       <input name="contact_persone" type="text" id="contact_persone" value="<?=$contact_persone?>" style="width:250px;"></td>
									  </tr>
									  
									  
									  
									  
									  <tr>

                                        <td>Phone:</td>

                                        <td><input name="contact_no" type="text" id="contact_no" value="<?=$contact_no?>"  style="width:250px;"/></td>
                                      </tr>
									  

                                      <tr>

                                        <td>Mobile:</td>

                                        <td><input name="mobile_no" type="text" id="mobile_no" value="<?=$mobile_no?>" style="width:250px;"/></td>
                                      </tr>

                                      <tr>

                                        <td>E-mail:</td>

                                        <td><input name="email" type="text" id="email" value="<?=$email?>" style="width:250px;" />
						
						
						 
						 </td>
                                      </tr>
									  
									  



                                      
									  
									  
									  
									  
									  
									 

                                      

                                      <tr>

                                        <td>Company:</td>

                                        <td>
										
										<select name="group_for" required id="group_for" style="width:250px;">

                      <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                    </select></td>
                                      </tr>
									  
									  <tr>

                                        <td>Status:</td>

                                        <td><select name="status" id="status"  style="width:250px;">

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="Active">Active</option>

                                          <option value="Inactive">Inactive</option>


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

								    <table class="w-100" border="0"><th></th>

								      <tr>
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>