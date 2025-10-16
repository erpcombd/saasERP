<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Project Information';			// Page Name and Page Title

do_datatable('table_head');

$page="project_information.php";		// PHP File Name



$table='project_info';		// Database Table Name Mainly related to this page

$unique='proj_id';			// Primary Key of this Database table

$shown='proj_name';				// For a New or Edit Data a must have data field



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

		$id = $_POST['id'];

		if($_FILES['company_logo']['tmp_name']!=''){
		$file_temp = $_FILES['company_logo']['tmp_name'];
		$folder = "../../../../public/uploads/logo/";
		move_uploaded_file($file_temp, $folder.$_SESSION['proj_id'].'.png');}

		if($_FILES['company_logo_bg']['tmp_name']!=''){
		$file_temp = $_FILES['company_logo_bg']['tmp_name'];
		$folder = "../../../../public/uploads/logo/bg_image/";
		move_uploaded_file($file_temp, $folder.$_SESSION['proj_id'].'.png');}




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

		$id = $_POST['id'];



		if($_FILES['company_logo']['tmp_name']!=''){
		$file_temp = $_FILES['company_logo']['tmp_name'];
		$folder = "../../../../public/uploads/logo/";
		move_uploaded_file($file_temp, $folder.$_SESSION['proj_id'].'.png');}


		if($_FILES['company_logo_bg']['tmp_name']!=''){
		$file_temp = $_FILES['company_logo_bg']['tmp_name'];
		$folder = "../../../../public/uploads/logo/bg_image/";
		move_uploaded_file($file_temp, $folder.$_SESSION['proj_id'].'.png');}




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

            <div class="container n-form1">
                <table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
					<thead>
						<tr class="bgc-info">
							  <th><span> ID</span></th>
							  <th><span>Logo</span></th>
							  <th><span>BG Image</span></th>
							  <th><span>Company Name </span></th>
							  <th><span>Company Address </span></th>
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
						
						
						
						
						
						$td='select a.'.$unique.',  a.'.$shown.' ,  a.proj_address  from '.$table.' a where 1   ';
						
						$report=db_query($td);
						
						while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
						
						<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
						  <td><?=$rp[0];?></td>

                            <td><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" style="width:75px;" height="50px"> </td>
							
                            <td><img src="<?=SERVER_ROOT?>public/uploads/logo/bg_image/<?=$_SESSION['proj_id']?>.png" style="width:75px;" height="50px"> </td>
							
<!--						  <td><img src="<?=SERVER_ROOT?>public/uploads/logo/--><?//=$rp[0]?><!--.png" style="width:80px;" /></td>-->
<!--                            <td> <img src="../../../assets/support/upload_view.php?name=--><?//=$rp[3];?><!--&folder=company_logo" style="width:80px;" class="userimg" /> </td>-->


						  <td><?=$rp[1];?></td><td><?=$rp[2];?></td>
						</tr>
						
						<?php }?>
					</tbody>
					</table>
					
					<? //}?>
					
					<div id="pageNavPosition"></div>	
					
				</div>

        </div>


        <div class="col-sm-5">
            
            <form id="form1" name="form1" class="n-form" method="post" action=""  enctype="multipart/form-data">
			    <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                <input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> Company Type</label>
                    <div class="col-sm-9 p-0">
						<select name="projects_types" id="projects_types" value="<?=$projects_types?>" style="text-transform: uppercase;">
						<option><?=$projects_types?></option>   
					    <option value="clouderp">CLOUDERP</option>
						<option value="aamra">AAMRA</option>
						<option value="robi">ROBI</option>  
						<option value="banglalink">BANGLALINK</option>                
					 </select>		
                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> Company ID</label>
                    <div class="col-sm-9 p-0">
                        <input name="proj_name" required type="text" id="proj_name" tabindex="1" value="<?=$proj_name?>" >	
                    </div>
                </div>
				
                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Company Name </label>
                    <div class="col-sm-9 p-0">
                        <input name="company_name"  type="text" id="company_name" tabindex="1" value="<?=$company_name?>" >

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Address  </label>
                    <div class="col-sm-9 p-0">

                        <input name="proj_address" type="text" id="proj_address" tabindex="2" value="<?=$proj_address?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Phone  </label>
                    <div class="col-sm-9 p-0">

                       <input name="proj_phone" type="text" id="proj_phone" tabindex="2" value="<?=$proj_phone?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Mobile  </label>
                    <div class="col-sm-9 p-0">

                       <input name="proj_fax" type="text" id="proj_fax" tabindex="8" value="<?=$proj_fax?>"/>

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Email  </label>
                    <div class="col-sm-9 p-0">

                        <input name="proj_email" type="text" id="proj_email" tabindex="8" value="<?=$proj_email?>">

                    </div>
                </div>
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Website  </label>
                    <div class="col-sm-9 p-0">

                        <input name="website" type="text" id="website" tabindex="8" value="<?=$website?>"/>

                    </div>
                </div>
				
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Company Logo  </label>
                    <div class="col-sm-9 p-0">

                        <input name="company_logo" type="file" id="company_logo" value="<?=$company_logo?>" />

                    </div>
                </div>
								
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Home width  </label>
                    <div class="col-sm-9 p-0">

                        <input name="home_width" type="text" id="home_width" tabindex="8" value="<?=$home_width?>"/>

                    </div>
                </div>
								
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Home Height  </label>
                    <div class="col-sm-9 p-0">

                        <input name="home_height" type="text" id="home_height" tabindex="8" value="<?=$home_height?>"/>

                    </div>
                </div>
								
												
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Menu width  </label>
                    <div class="col-sm-9 p-0">

                        <input name="menu_width" type="text" id="menu_width" tabindex="8" value="<?=$menu_width?>"/>

                    </div>
                </div>
								
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Menu Height  </label>
                    <div class="col-sm-9 p-0">

                        <input name="menu_height" type="text" id="menu_height" tabindex="8" value="<?=$menu_height?>"/>

                    </div>
                </div>
								
				
								
				
								
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">BG Image </label>
                    <div class="col-sm-9 p-0">

                        <input name="company_logo_bg" type="file" id="company_logo_bg" value="<?=$company_logo_bg?>" />

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