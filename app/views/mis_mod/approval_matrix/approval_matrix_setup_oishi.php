<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

if($_GET['clear']==1){
  unset($_POST);
  echo '<script type="text/javascript">
        window.location.href = "approval_matrix_setup_oishi.php";
      </script>';
}
if($_GET['delete']){
  $sql_delete='DELETE FROM approval_matrix_setup where id="'.$_GET['delete'].'"';
  db_query($sql_delete);
  echo '<script type="text/javascript">
  window.location.href = "approval_matrix_setup_oishi.php";
</script>';
;
}

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

// ::::: Edit This Section ::::: 

$title='Company Concerns ';			// Page Name and Page Title
do_datatable('table_head');
//$page="user_group.php";		// PHP File Name
$page="approval_matrix_setup_oishi.php";		// PHP File Name

$table='approval_matrix_setup';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='user_id';				// For a New or Edit Data a must have data field
// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];
$crud      =new crud('approval_matrix_setup');
// $$unique = $_GET[$unique];
// $$unique = $_POST[$unique];

//for Insert..................................
if(isset($_POST['insert'])){
      
    


		 $_POST['entry_by'] = $_SESSION['user']['id'];

		 $_POST['entry_at'] = $now=date('Y-m-d H:i:s');




$crud->insert();

$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
echo '<script type="text/javascript">
        window.location.href = "approval_matrix_setup_oishi.php?clear=1";
      </script>';
}





//for Modify..................................
if(isset($_POST['update'])){

  $approval_name =$_POST['approval_name'];
  $edit_at = date('Y-m-d H:i:s'); // Current timestamp
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



if(isset($_GET[$unique])){

}

if(isset($$unique))

{



$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

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

<style type="text/css">



</style>



<div class="container-fluid">
    
    <div class="row">
        <div class="col-sm-7">

            <div class="container n-form1">
                <table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm">
					<thead>
						<tr class="bgc-info">
							  <th><span> ID</span></th>
							
							  <th><span>Member Name</span></th>
							  <th><span>Level</span></th>
							   <th><span>Tr From</span></th>
                 <th><span>Status</span></th>
							   <th><span>Edit</span></th>
							   
						</tr>
					</thead>
					
					<tbody>
					
						<?php
						

						
						
						
						
						
						
        $sql_member_show = "
           SELECT a.approval_name, a.id, u.user_id, u.fname, a.level,a.status,a.tr_from FROM approval_matrix_setup a JOIN user_activity_management u ON a.user_id = u.user_id;
        ";
        $query_member_show = db_query($sql_member_show);
        while($rp=mysqli_fetch_object($query_member_show)){
          
          ?>
						
						<tr>
             <td><?=$rp->user_id;?></td>
             <td><?=$rp->fname;?></td>
             <td><?=$rp->level;?></td>
             <td><?=$rp->tr_from;?></td>
             <td><?=$rp->status;?></td>
             <td><a href="approval_matrix_setup_oishi.php?id=<?=$rp->id?>" class="btn1 btn1-bg-update">Edit</a></td>

						</tr>
						
						<?php }?>
					</tbody>
					</table>
					
					
					
					<div id="pageNavPosition"></div>	
					
				</div>

        </div>


        <div class="col-sm-5">
            
            <form id="form1" name="form1" class="n-form" method="post" action="" enctype="multipart/form-data">
                <h4 class="n-form-titel1 text-center"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3 pb-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Approver</label>
                    <div class="col-sm-9 p-0">
                      <?php
                  $sql_member = 'SELECT user_id,fname from user_activity_management;';
                  $query_member = db_query($sql_member);
                  ?>
				  <input type="hidden" name="id" id="id" value="<?=$$unique?>"  />
                      <select name="PBI_ID" id="PBI_ID" class="form-control p-0" required data-live-search="true" tabindex="-98">
				  <option></option>
                      <?php while ($row1 = mysqli_fetch_object($query_member)) { ?>
                        
                        <option 
                          value="<?= $row1->user_id ?>" 
                          <?= ($row1->user_id == $PBI_ID) ? 'selected' : '' ?>>
                          <?= $row1->user_id ?> - <?= $row1->fname ?>
                      </option>                      <?php } ?>
                  </select>	


                  </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3 pb-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Status</label>
                    <div class="col-sm-9 p-0">
                    <select name="status" id="status">
                        <option   <?= ($status == 'ACTIVE') ? 'selected' : '' ?> value="ACTIVE">ACTIVE</option>
                        <option   <?= ($status == 'INACTIVE') ? 'selected' : '' ?> value="INACTIVE">INACTIVE</option>
                   </select>
                      </div>
                      </div>

                  <div class="form-group row m-0 pl-3 pr-3 pb-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Threshold</label>
                    <div class="col-sm-9 p-0">
                   
                  <input type="number" name="max_limit_amount" id="max_limit_amount" class="form-control p-0" value="<?=$max_limit_amount?>"/>
				  


                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3 pb-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Level</label>
                    <div class="col-sm-9 p-0">
                    <?php
                  $sql_member = 'SELECT layer_level,layer_name from approval_matrix_layer_setup;';
                  $query_member = db_query($sql_member);
                  ?>
                  <select name="user_level" id="user_level" class="form-control p-0" data-live-search="true" tabindex="-98">
				  <option></option>
                      <?php while ($row1 = mysqli_fetch_object($query_member)) { ?>
                        
                        <option 
                          value="<?= $row1->layer_level ?>" 
                          <?= ($row1->layer_level == $level) ? 'selected' : '' ?>>
                          <?= $row1->layer_level ?> - <?= $row1->layer_name ?>
                      </option>                      <?php } ?>
                  </select>	


                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3 pb-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Tr From</label>
                    <div class="col-sm-9 p-0">
                    <?php
                  $sql_tr_from = 'SELECT tr_id,name from approval_matrix_trfrom;';
                  $query_tr_from = db_query($sql_tr_from);
                  ?>
                  <select name="tr_from_id" id="tr_from_id" class="form-control  p-0" required data-live-search="true" tabindex="-98">
				  <option></option>
                      <?php while ($row1 = mysqli_fetch_object($query_tr_from)) { ?>
                          
                          <option 
                          value="<?= $row1->name ?>" 
                          <?= ($row1->name == $tr_from) ? 'selected' : '' ?>>
                          <?= $row1->name ?>
                      </option>
                      <?php } ?>
                  </select>	


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3 pb-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Approval Name</label>
                    <div class="col-sm-9 p-0">
                        <input name="approval_name"  type="text" id="approval_name" value="<?=$approval_name?>" >

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





<?php /*?><table style="weight:100%" border="0">
<thead></thead>

  <tr>

    <td style="vertical-align: top;" style="weight:60%"><div class="left">

							<table style="weight:100%;" border="0">
							<thead></thead>

								 								  

								   <tr>

									<td>

<?

//if(isset($_POST['search'])){

?>

<table  id="table_head" class="table table-bordered">
<thead>
<tr>
  <th style="bakground-color:#45777B;"><span class="style3"> ID</span></th>

  <th style="bakground-color:#45777B;"><span class="style3">Logo</span></th>
  <th style="bakground-color:#45777B;"><span class="style3">Company Name </span></th>
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

    <td style="vertical-align: top;" class="w-50"><div class="right">   <form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table class="w-100" border="0">
							  <thead></thead>
							  
							  
							  <tr>
								
								
								

                                  <td class="w-100" colspan="2"><div class="box style2" style="width:400px;">

                                    <table class="w-100" border="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF; background-color:#45777B;"> <div class="text-center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>
								
								
								

                                  <td class="w-100" colspan="2"><div class="box" style="width:400px;">

                                    <table class="w-100" border="0">

                                      

									  

									  <thead><tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>Company Name:</td>

                                        <td>
										<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       					<input name="id" type="hidden" id="id"
                       					value="<?=$id?>" readonly>
                        				<input name="group_name" required type="text" id="group_name" value="<?=$group_name?>" style="width:250px;"  >	
										
										
										</td>
                                      </tr>
                                      </thead>
									  
									  
									  
									  
									  
									  
									  
									  <td>Description:</td>

                                        <td>
										
										<input name="description"  type="text" id="description" value="<?=$description?>" style="width:250px;" >	</td>
									  
									  
									  
									  

                                      
					
					
				
									  <tr>

                                        <td>Address:</td>

                                        <td>
										<input name="address" type="text" id="address" value="<?=$address?>" style="width:250px;"></td>
									  </tr>
									  
									  
									  <tr>

                                        <td>Phone:</td>

                                        <td>
										<input name="phone" type="text" id="phone" value="<?=$phone?>" style="width:250px;"></td>
									  </tr>
									  
									  
					  

                                      <tr>

                                        <td>Mobile:</td>

                                        <td><input name="mobile" type="text" id="mobile" value="<?=$mobile?>" style="width:250px;"/></td>
                                      </tr>

                                      <tr>

                                        <td>E-mail:</td>

                                        <td><input name="email" type="text" id="email" value="<?=$email?>" style="width:250px;">
						
						
						
						 </td>
                                      </tr>
									  
									  
									  
									  <tr>

                                        <td>Website:</td>

                                        <td><input name="website" type="text" id="website" value="<?=$website?>" style="width:250px;"/></td>
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

								    <table class="w-100" border="0">

								      <thead><tr>
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
                </tr></thead>
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