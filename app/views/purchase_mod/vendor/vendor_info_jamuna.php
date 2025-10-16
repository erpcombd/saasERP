<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);


// ::::: Edit This Section ::::: 
$tr_type="Show";
 //var_dump($_SESSION);

$title='Vendor Information';			// Page Name and Page Title

do_datatable('vendor_table');

$page="vendor_info_jamuna.php";		// PHP File Name
$page_entry="vendor_jamuna_entry.php";		// PHP File Name



$table='vendor';		// Database Table Name Mainly related to this page

$unique='vendor_id';			// Primary Key of this Database table

$shown='vendor_name';				// For a New or Edit Data a must have data field

function createSubLedger($code,$name,$tr_from,$tr_id,$ledger_id,$type){

 $insert = 'insert into general_sub_ledger set sub_ledger_id="'.$code.'",sub_ledger_name="'.$name.'",tr_from="'.$tr_from.'",tr_id="'.$tr_id.'",ledger_id="'.$ledger_id.'",type="'.$type.'",entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$_SESSION['user']['id'].'",group_for="'.$_SESSION['user']['group'].'"';
db_query($insert);
return db_insert_id();

}

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



//if ($_POST['dealer_found']==0) {}
	

$proj_id = $_SESSION['proj_id'];

$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');

/*tin*/	


$folder='vendor';
$field = 'tin';
$file_name = $field.'-'.$_POST['vendor_id'];
if($_FILES['tin']['tmp_name']!=''){
$random = random_int(10000,99999);
$newFileName = 'vendor_tin_'.$random;
$ext = end(explode(".",$_FILES['tin']['name']));
//$_POST['tin']=upload_file($folder,$field,$file_name);
file_upload_aws('tin','vendor_tin',$newFileName);
$_POST['tin']= $newFileName.'.'.$ext;
$tr_type="Add";
}

//////////trade////////////////


//$_POST['pic']=image_upload($path,$_FILES['pic']);

$field = 'trade';
$file_name = $field.'-'.$_POST['vendor_id'];
if($_FILES['trade']['tmp_name']!=''){
$random = random_int(10000,99999);
$newFileName = 'vendor_trade_'.$random;
$ext = end(explode(".",$_FILES['trade']['name']));
//$_POST['trade']=upload_file($folder,$field,$file_name);
file_upload_aws('trade','vendor_trade',$newFileName);
$_POST['trade']= $newFileName.'.'.$ext;
}


//////////BIN////////////////

$field = 'bin';
$file_name = $field.'-'.$_POST['vendor_id'];
if($_FILES['bin']['tmp_name']!=''){
$random = random_int(10000,99999);
$newFileName = 'vendor_bin_'.$random;
$ext = end(explode(".",$_FILES['bin']['name']));
//$_POST['bin']=upload_file($folder,$field,$file_name);
file_upload_aws('bin','vendor_bin',$newFileName);
$_POST['bin']= $newFileName.'.'.$ext;
}

//////////cheque////////////////

$field = 'cheque';
$file_name = $field.'-'.$_POST['vendor_id'];
if($_FILES['cheque']['tmp_name']!=''){
$random = random_int(10000,99999);
$newFileName = 'vendor_cheque_'.$random;
$ext = end(explode(".",$_FILES['cheque']['name']));
//$_POST['cheque']=upload_file($folder,$field,$file_name);
file_upload_aws('cheque','vendor_cheque',$newFileName);
$_POST['cheque']= $newFileName.'.'.$ext;
}

$custome_codes = find_a_field('vendor','max(sub_ledger_id)','1');
if($custome_codes>0){
	$custome_code = $custome_codes+1;
	}
	else{
	$custome_code = 50000001;
	}

//$wh_data = find_all_field('warehouse','','warehouse_id='.$_POST['depot']); 

$_POST['ledger_id'] = $_POST['ledger_id'];
$_POST['sub_ledger_id'] = $custome_code;

$_POST['ledger_name'] = $_POST['vendor_name'];

 


$crud->insert();
$ledger_gl_found = find_a_field('general_sub_ledger','sub_ledger_id','sub_ledger_name='.$_POST['ledger_name']);


if ($ledger_gl_found==0) {
createSubLedger($custome_code,$_POST['ledger_name'],'vendor',$_POST[$unique],$_POST['ledger_id'] ,$_POST['vendor_category']);
}
		
		
	
$tr_type="Initiate";

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);


header("Location: vendor_info.php");

}





//for Modify..................................



if(isset($_POST['update']))

{
$tr_type="update";
			
$folder='vendor';

$field = 'tin';
$file_name = $field.'-'.$_POST['vendor_id'];

if($_FILES['tin']['tmp_name']!=''){

$_POST['tin']=upload_file($folder,$field,$file_name);

}

$field = 'trade';
$file_name = $field.'-'.$_POST['vendor_id'];

if($_FILES['trade']['tmp_name']!=''){

$_POST['trade']=upload_file($folder,$field,$file_name);


}

$field = 'bin';
$file_name = $field.'-'.$_POST['vendor_id'];


if($_FILES['bin']['tmp_name']!=''){

$_POST['bin']=upload_file($folder,$field,$file_name);


}
$field = 'cheque';
$file_name = $field.'-'.$_POST['vendor_id'];

if($_FILES['cheque']['tmp_name']!=''){

$_POST['cheque']=upload_file($folder,$field,$file_name);


}

		
		
		

		$crud->update($unique);

		
		 $vendor_id =$_POST['vendor_id'];
		 $ledger_id = $_POST['ledger_id'];

	$sub_ledger_id = $_POST['sub_ledger_id'];



	  $sql1 = 'update  general_sub_ledger set sub_ledger_name="'.$_POST['vendor_name'].'" 

	  where sub_ledger_id  = '.$sub_ledger_id;
		db_query($sql1);




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

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);
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

	document.location.href = '<?=$page_entry?>?<?=$unique?>='+theUrl;

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





<div class="container-fluid pt-0 p-0 ">

			<div class="n-form-btn-class">
				   <a href="<?=$page_entry;?>"><button type="button" class="btn1 btn1-bg-submit"><i class="fa-regular fa-plus-large"></i> New Supplier / Vendor Add</button></a>
			</div>


			<table id="vendor_table" class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th>ID</th>
					<th style="text-align:left">Vendor Name</th>
					<th>GL Code</th>
					<th style="text-align:left">Address</th>

					<th>Action</th>
				</tr>
				</thead>

				<tbody class="tbody1">

				<?php


				if($_POST['group_for']!="")

					$con .= 'and a.group_for="'.$_POST['group_for'].'"';

				if($_POST['depot']!="")

					$con .= 'and a.depot="'.$_POST['depot'].'"';



				$td='select a.'.$unique.',  a.'.$shown.' as vendor_name,   a.address, a.ledger_id from '.$table.' a, user_group u
				where   a.group_for=u.id  and a.group_for="'.$_SESSION['user']['group'].'"    '.$con.' order by a.vendor_id ';

				$report=db_query($td);

				while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

					<tr<?=$cls?>  bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
						<td><?=$rp[0];?></td>

						<td style="text-align:left"><?=$rp[1];?></td>

						<td><?=$rp[3];?></td>
						<td style="text-align:left"><?=$rp[2];?></td>
						<td>
						<button type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-update"><i class="fa-solid fa-pen-to-square"></i></button>
						
						<!--<input type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn1 btn1-bg-update" value="Edit"/>-->
						</td>
					</tr>
				<?php }?>
				</tbody>
			</table>

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