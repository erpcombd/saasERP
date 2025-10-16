<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='System Stock Config';			// Page Name and Page Title

do_datatable('table_head');

$page="system_stock_config.php";		// PHP File Name



$table='system_stock_config';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='tr_from';				// For a New or Edit Data a must have data field



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


			$entry_by = $_SESSION['user'];



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
	<div class="col-md-12">
            
            <form id="form1" name="form1" class="n-form" method="post" action="">
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> Tr From</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        <input name="tr_from" required type="text" id="tr_from" tabindex="1" value="<?=$tr_from?>" >	


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Table Name </label>
                    <div class="col-sm-9 p-0">
                        <input name="table_name"  type="text" id="table_name" tabindex="1" value="<?=$table_name?>" >

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Detail Field</label>
                    <div class="col-sm-9 p-0">

                        <input name="sum_field" type="text" id="sum_field" tabindex="2" value="<?=$sum_field?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Ji Field  </label>
                    <div class="col-sm-9 p-0">

                       <input name="sum_field_ji" type="text" id="sum_field_ji" tabindex="2" value="<?=$sum_field_ji?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Date Field  </label>
                    <div class="col-sm-9 p-0">

                       <input name="date_field" type="text" id="date_field" tabindex="8" value="<?=$date_field?>"/>

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Table Condition  </label>
                    <div class="col-sm-9 p-0">

                        <textarea name="table_condition"  id="table_condition" ><?=$table_condition?></textarea>

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
        <div class="col-md-12">
           


            <div class="container n-form1">
                <table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
					<thead>
						<tr class="bgc-info">
							  <th>ID</th>
							  <th>Tr From</th>
							  <th>Table Name</th>
							  <th>Detail Field</th>
							  
							  <th>Ji Field</th>
							  <th>Date Field</th>
							  <th>Condition</th>
							  
						</tr>
					</thead>
					
					<tbody>
					
						<?php
						
						
						
						
						
						
						
						
						 $td='select *  from '.$table.'';
						
						$report=db_query($td);
						
						while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
						
						<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
						  <td><?=$rp[0];?></td>
						  <td><?=$rp[1];?></td>
						  <td><?=$rp[2];?></td>
						  <td><?=$rp[3];?></td>
						  <td><?=$rp[4];?></td>
						  <td><?=$rp[5];?></td>
						  <td><?=$rp[6];?></td>
						
						  
						</tr>
						
						<?php }?>
					</tbody>
					</table>
					
					<? //}?>
					
					<div id="pageNavPosition"></div>	
					
				</div>

        </div>


        

    </div>




</div>





<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  

								   <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr>
  <th bgcolor="#45777B"><span class="style3"> ID</span></th>

  <th bgcolor="#45777B"><span class="style3">Logo</span></th>
  <th bgcolor="#45777B"><span class="style3">Company Name </span></th>
  </tr>
</thead>

<tbody>

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';

if($_POST['warehouse_id']!="")

$con .= 'and a.warehouse_id="'.$_POST['warehouse_id'].'"';



if($_POST['username']!="")

$con .='and a.username like "%'.$_POST['username'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.' ,  a.address  from '.$table.' a where 1 order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

  <td><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$rp[0]?>.png" style="width:80px;" /></td>
  <td><?=$rp[1];?></td>
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

                                     <td><span class="style1" style="padding-top:5px;">*</span>Company Name:</td>

                                        <td>
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                        				<input name="group_name" required type="text" id="group_name" tabindex="1" value="<?=$group_name?>" style="width:250px;"  >	
										
										
										</td>
                                      </tr>
									  
									  
									  
									  
									  
									  
									  
									  <td>Description:</td>

                                        <td>
										
										<input name="description"  type="text" id="description" tabindex="1" value="<?=$description?>" style="width:250px;" >	</td>
									  
									  
									  
									  

                                      
					
					
				
									  <tr>

                                        <td>Address:</td>

                                        <td>
										<input name="address" type="text" id="address" tabindex="2" value="<?=$address?>" style="width:250px;"></td>
									  </tr>
									  
									  
									  <tr>

                                        <td>Phone:</td>

                                        <td>
										<input name="phone" type="text" id="phone" tabindex="2" value="<?=$phone?>" style="width:250px;"></td>
									  </tr>
									  
									  
					  

                                      <tr>

                                        <td>Mobile:</td>

                                        <td><input name="mobile" type="text" id="mobile" tabindex="8" value="<?=$mobile?>" style="width:250px;"/></td>
                                      </tr>

                                      <tr>

                                        <td>E-mail:</td>

                                        <td><input name="email" type="text" id="email" tabindex="8" value="<?=$email?>" style="width:250px;">
						
						
						
						 </td>
                                      </tr>
									  
									  
									  
									  <tr>

                                        <td>Website:</td>

                                        <td><input name="website" type="text" id="website" tabindex="8" value="<?=$website?>" style="width:250px;"/></td>
                                      </tr>
									  
				
                                      <tr>

                                        
                                      </tr>
									  
									  
									  <tr>

                                        <td> Company Logo:</td>

                                        <td><input style="padding:5px 5px 7px 5px; width:250px;" name="company_logo" type="file" id="company_logo" value="<?=$company_logo?>" /></td>
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






<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>