<?php

 

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 
$tr_type="Show";


$title='Quotation Configure';			// Page Name and Page Title

do_datatable('table_head');

$page="quotation_setup_cus.php";		// PHP File Name



$table='quotation_setup';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='return_status';				// For a New or Edit Data a must have data field



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
		$tr_type="Add";
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
$tr_type="Add";
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
		$tr_type="Add";

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);
		$tr_type="Delete";
		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

 

foreach($data as $key=>$value)

{ $$key=$value;}

}

if(!isset($$unique)){ $$unique=db_last_insert_id($table,$unique);}

$tr_from="Purchase";
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
			<h4 align="center" class="n-form-titel1">Quotation Configure</h4>


                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company :</label>
                        <div class="col-sm-9 p-0">
                             <select name="group_for" required id="group_for" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>

                        </div>
                    </div>
					
					<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Category Name :</label>
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



?>

<table  id="table_head" class="table table-bordered" cellspacing="0">
<thead>
<tr class="bgc-info" >
  	<th  style="width:8%">ID</th>
	<th style="text-align:left">Return For Revise</th>
	<th style="width:10%">Rate Revise</th>
	<th style="width:10%">Action</th>
</tr>
</thead>

<tbody>

<?php
if($_POST['group_for']!=""){

$con .= 'and a.group_for="'.$_POST['group_for'].'"';}

if($_POST['category_name']!=""){

$con .='and a.category_name like "%'.$_POST['category_name'].'%" ';}

   $td='select a.'.$unique.', a.return_status,a.rate_revise_status   from '.$table.' a	where  1 order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0){$cls=' class="alt"';} else{ $cls='';}
?>

<tr<?=$cls?> >
  	<td style="text-align:center"><?=$rp[0];?></td>
	<td><?=$rp[1];?></td>
	<td><?=$rp[2];?></td>
	<td style="text-align:center">
	<button type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
	</td>
</tr>

<?php }?>
</tbody>
</table>

<? //}?>
				
				
				

            </div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
            
			
            <form class="n-form setup-fixed"   action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
					<? if(!isset($_GET[$unique])){?>
						<h4 align="center" class="n-form-titel1">Quotation Configure</h4>
					<? }?>
					<? if(isset($_GET[$unique])){?>
						<h4 align="center" class="n-form-titel1">Update</h4>
					<? }?>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-3 pl-0 pr-0 col-form-label ">Return For Revise:</label>
                    <div class="col-sm-9 p-0">
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       	<input class="m-0" name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                    
<select name="return_status" id="return_status">
	<option value="<?=$return_status?>"><?=$return_status?></option>
	<option value="Enable">Enable</option>
	<option value="Disable">Disable</option>
</select>

                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Rate Revise  :</label>
                    <div class="col-sm-9 p-0">
     <select name="rate_revise_status" id="rate_revise_status">
	<option value="<?=$rate_revise_status?>"><?=$rate_revise_status?></option>
	<option value="Enable">Enable</option>
	<option value="Disable">Disable</option>
</select>

                    </div>
                </div>

                 

                <div class="n-form-btn-class">
                    <? if(!isset($_GET[$unique])){?>
                      <input class="btn1 btn1-bg-submit" name="insert" type="submit" id="insert" value="Save"  />
                      <? }?>
					  
					  
					 <? if(isset($_GET[$unique])){?>
                      <input class="btn1 btn1-bg-update" name="update" type="submit" id="update" value="Update"  />
                      <? }?>
					  
					  
					   <input class="btn1 btn1-bg-cancel" name="reset" type="button"  id="reset" value="Reset" onclick="parent.location='<?=$page?>'" /> 

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