<?php

require_once "../../../assets/template/layout.top.php";




function next_ledger_ids($group_id)

{

$max=($group_id*1000000000000)+1000000000000;

$min=($group_id*1000000000000)-1;

$s='select max(ledger_id) from accounts_ledger where ledger_id>'.$min.' and ledger_id<'.$max;

$sql=mysql_query($s);

if(mysql_num_rows($sql)>0)

$data=mysql_fetch_row($sql);

else

$acc_no=$min;

if(!isset($acc_no)&&(is_null($data[0]))) 

$acc_no=$cls;

else

$acc_no=$data[0]+100000000;

return $acc_no;

}




// ::::: Edit This Section ::::: 



$title='ADD Dealer Information';			// Page Name and Page Title

$page="dealer_info.php";		// PHP File Name



$table='dealer_info';		// Database Table Name Mainly related to this page

$unique='dealer_code';			// Primary Key of this Database table

$shown='dealer_name_e';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$_POST['area_name'] = find_a_field('area','AREA_NAME','AREA_CODE='.$_POST['area_code']);

$_POST['zone_name'] = find_a_field('zon','ZONE_NAME','ZONE_CODE='.$_POST['zone_code']);

$_POST['region_name'] = find_a_field('branch','BRANCH_NAME','BRANCH_ID='.$_POST['region_code']);


$crud->insert();

  $acc_query='INSERT INTO accounts_ledger(ledger_id, ledger_name, ledger_group_id, opening_balance, balance_type, depreciation_rate, credit_limit, opening_balance_on, proj_id, budget_enable, group_for, parent, acc_code, ledger_type) 



VALUES ("'.$_POST['account_code'].'","'.trim($_POST['dealer_name_e']).'",1004,0.00,"Both", 0.00, 0.00,'.strtotime(date("Y-m-d H:i:s")).',"philips","NO", 2, 0, 0, 0)';

mysql_query($acc_query);




$id = $_POST['dealer_code'];
		
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

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);
header('Location:../dealer/dealer_info.php');

}





//for Modify..................................



if(isset($_POST['update']))

{
		$crud->update($unique);

$id = $_POST['dealer_code'];
		
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
    
	header('Location:../dealer/dealer_info.php');
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

while (list($key, $value)=each($data))

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>

<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>





<!-- Horizontal material form -->
<form>
  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputEmail3MD" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <input type="email" class="form-control" id="inputEmail3MD" placeholder="Email">
      </div>
    </div>
  </div>
  <!-- Grid row -->

  <!-- Grid row -->
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
        <input type="password" class="form-control" id="inputPassword3MD" placeholder="Password">
      </div>
    </div>
  </div>
  <!-- Grid row -->

  <!-- Grid row -->
  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary btn-md">Sign in</button>
    </div>
  </div>
  <!-- Grid row -->
</form>
<!-- Horizontal material form -->






<?

require_once "../../../assets/template/layout.bottom.php";

?>
