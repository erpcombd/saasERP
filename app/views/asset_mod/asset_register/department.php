<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Department Information Add';			// Page Name and Page Title



do_datatable('vendor_table');



$page="department.php";		// PHP File Name



$table='asset_department';		// Database Table Name Mainly related to this page



$unique='id';			// Primary Key of this Database table



$shown='department_name';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];



$crud =new crud($table);



$$unique = $_GET[$unique];



if(isset($_POST[$shown]))



{



$$unique = $_POST[$unique];



//for Insert..................................



if(isset($_POST['insert']))



{	







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

$_POST['id']=$_GET['id'];

$crud->update($unique);



echo "<script>window.top.location='department.php'</script>";



}



//for Delete..................................



if(isset($_POST['delete']))



{		



$condition=$unique."=".$$unique;



$crud->delete($condition);



unset($$unique);



$type=1;



$msg='Successfully Deleted.';



}



}



if(isset($$unique)){



$condition=$unique."=".$$unique;



$data=db_fetch_object($table,$condition);



foreach($data as $key => $value)



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







</style>



<!--dealer info-->



<div class="form-container_large">



<h4 class="text-center bg-titel bold pt-2 pb-2 text-uppercase"> <?=$title?> </h4>



<form action="" method="post"  name="form1" id="form1" onsubmit="return check()">



<div class="container-fluid bg-form-titel">



<div class="row">

	

<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 pt-1 pb-1">



<div class="form-group row m-0">



<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 vendor_label_text d-flex justify-content-start align-items-center pr-1 bg-form-titel-text req-input">Department Name:</label>



<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">



<input name="department_name" type="text" id="department_name" tabindex="14" value="<?=$department_name?>" />



</div>



</div>



</div>



</div>



<hr>



<div class="n-form-btn-class">



<? if(!isset($_GET[$unique])){?>



<input name="insert" type="submit" id="insert" value="SAVE &amp; NEW" class="btn1 btn1-bg-submit" />



<? }?>



<? if(isset($_GET[$unique])){?>



<input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />



<? }?>



<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />



</div>



</div>



</form>



<?



//if(isset($_POST['search'])){



?>



<div class="container-fluid pt-5 p-0 ">



<table id="vendor_table" class="table1  table-striped table-bordered table-hover table-sm">



<thead class="thead1">



<tr class="bgc-info">



<th>ID</th>



<th>Department Name</th>



<th>Action</th>



</tr>



</thead>



<tbody class="tbody1">







</tbody>



</table>



</div>



<? //}?>



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