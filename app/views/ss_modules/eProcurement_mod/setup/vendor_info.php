<?

require_once "../../../controllers/routing/layout.top.php";
require_once(SERVER_CORE.'mailer/phpmail.php');
$current_page = "setup";
$title='Suppliers Information';


$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);



$tr_type="Show";
do_datatable('vendor_table');
$page="vendor_info.php";		
$table='vendor';		
$unique='vendor_id';			
$shown='vendor_name';				


if($_GET['mhafuz']==2){
	unset($_SESSION[$unique]);
	echo '<script>window.location.href = "vendor_info.php"</script>';
}


$Crud      =new Crud($table);
$_SESSION[$unique] = $_GET[$unique];
if(isset($_POST[$shown]))

{

$_SESSION[$unique] = $_POST[$unique];

}

if(isset($_POST['insert']))

{	
	

$proj_id = $_SESSION['proj_id'];
$found = find_a_field('vendor','count(vendor_id)','email like "'.$_POST['email'].'"');
if($found<1){

$randomNumber = $_POST['email'].'_1';
$_POST['password'] = auth_encode($randomNumber);
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');
$email_id=auth_encode($_POST['email']);
$inserted_id=$Crud->insert();

$tr_no = $inserted_id;
$tr_from = 'vendor';
$email = $_POST['email'];
$link = '/app/views/auth/vendor/update_pass _change_link.php?tyxzsd="'.$email_id.'"';
$status = 'no';
$expiration_time = date('Y-m-d H:i:s', strtotime('+7 days'));
$sql_expire_add = "INSERT INTO link_expiration_information (tr_no, tr_from, email, link, expiration_time, status) 
	VALUES ('$tr_no', '$tr_from', '$email', '$link', '$expiration_time', '$status')";

db_query($sql_expire_add);
$body = 'Dear Concerned,';
$body .='<br>';
$body .='<br>';
$body .='Welcome to Robi eSourcing Platform. Your User Account has been created successfully. Below are your login credentials';
// $body .='<br>';
// $body .='Username : '.$_POST['email'];
// $body .='<br>';
// $body .='Password : '.$randomNumber;
// $body .='<br>';

$body .= '<a href="https://esourcing.robi.com.bd/esourcing/app/views/auth/vendor/update_pass_change_link.php?tyxzsd='.$email_id.'" target="_blank" rel="noopener">Click here for login</a>';
//$body .= '<a href="https://10.101.74.49/esourcing_dev/app/views/auth/vendor/update_pass_change_link.php?tyxzsd='.$email_id.'" target="_blank" rel="noopener">Click here for login</a>';
$body .='<br>';
$body .='<br>';
$body .='Thank You';
$body .='<br>';
$body .='Robi eSourcing Platform';
$body .='<br>';

mailer($_POST['email'],'Welcome to Robi eSourcing Platform',$body);
echo '<span style="color:green; font-size:20px;">New Supplier Created Successfully</span>';
	
		
	
$tr_type="Initiate";

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($_SESSION[$unique]);

}else{
	$msg_email_exist='Email is already exist';
}


}






function validate_password($password)
{
    $errors = [];

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if (!preg_match('/\d/', $password)) {
        $errors[] = "Password must contain at least one number.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must contain at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must contain at least one lowercase letter.";
    }
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors[] = "Password must contain at least one special character.";
    }


    return $errors;
}


if(isset($_POST['update']))

{
	$pass = $_POST['password'];

	// Validate password
$passwordErrors = validate_password($pass);
if (!empty($passwordErrors)) {
$msg = implode('<br>', $passwordErrors);
}else{
$found = find_a_field('vendor','count(vendor_id)','email like "'.$_POST['email'].'" and vendor_id!='.$_GET['vendor_id']);
if($found<1){
	$pass = $_POST['password'];
	$_POST['password']=auth_encode($pass);
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

		
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:i:s');
		

		$Crud->update($unique);

		
		 $vendor_id =$_POST['vendor_id'];





		$type=1;

		$msg='Successfully Updated.';
		$tr_type="Add";
		
}else{
	$msg_email_exist='Email is already exist';
}
}
}





if(isset($_POST['delete']))

{		$condition=$unique."=".$_SESSION[$unique];		$Crud->delete($condition);

		unset($_SESSION[$unique]);
		$tr_type="Delete";
		$type=1;

		$msg='Successfully Deleted.';

}





if(isset($_SESSION[$unique]))

{

$condition=$unique."=".$_SESSION[$unique];

$data=db_fetch_object($table,$condition);

//while (list($key, $value)=each($data))
foreach ($data as $key => $value)

{ ${$key}=$value;}

}

if(!isset($_SESSION[$unique])) {$_SESSION[$unique]=db_last_insert_id($table,$unique);}
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

<? include '../eProcurement/ep_menu.php'; ?>
    <script type="text/javascript" src="../../../../public/assets/js/bootstrap.min.js"></script>	
	<script type="text/javascript" src="../../../../public/assets/js/jquery-3.4.1.min.js"></script>

<style>
tr:nth-child(odd) {
    background-color: #fffffffb !important;
    color: #333 !important;
}
tr:nth-child(even) {
    background-color: #fffffffb!important;
    color: #333 !important;
}
.nav-tabs .nav-item .nav-link, .nav-tabs .nav-item .nav-link:hover, .nav-tabs .nav-item .nav-link:focus {
    border: 0 !important;
    color: #007bff !important;
    font-weight: 500;
}
.sidebar, .sidemenu{
	display:none;
    width: 0% !important;
}

.main_content{
	width: 100% !important;
}

.tab-content>.active {
    display: block;
    border: 1px solid #f5f5f5;
	background-color: #fbfbfb9e;
}

.nav-tabs .nav-item .nav-link.active{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.nav-tabs .nav-item .nav-link:hover{
    border: 1px solid #e1e1e1 !important;
    border-radius: 5px 5px 0px 0px;
    border-bottom: 1px solid #f8f8ff !important;
}
.d-flex-bg-color{
background-color:#333 !important;
}
.ep-bg-color{
	background-color:#f5f5f5 !important;
}
.btn1-bg-submit{
	margin:10px !important;
	background-color:#FFFFFF !important;
	color:#333 !important;
	font-weight:bold !important;	
}
.alerts-bg{
	background-color:#f0f0f0;
	padding:10px;
}
.bg-alerts-bg{
background-color:#FFFFFF !important;
}
.alerts-table{
	height:300px !important;
}
.sourcing-table{
	width:100%;
}

.sourcing-table tr:nth-child(odd), .sourcing-table tr:nth-child(even)  {
    background-color: #fff !important;
    color: #333!important;
	text-align:left;
}
.tab-pane{
height:292px;
background-color:#fff !important;
}
.nav-tabs {
    border-bottom: 1px solid #d9d9d9;
    background-color: #fffefe;
}

 .dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    
    min-width: 210px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
	left: 10px; 
	padding: 5px 0px;
	border-radius: 3px;
	background-color: white;
  }
  .dropdown-content a{
  	background-color:#fff !important;
	text-align:left;
	padding: 5px 0px 5px 10px;
  }
  .dropdown-content a:hover{
  color:#f37025;
  }
 
  

  .fs-8{font-size:8px !important;}.fs-9{font-size:9px !important;}.fs-10{font-size:10px !important;}.fs-11{font-size:11px !important;}.fs-12{font-size:12px !important;}.fs-13{font-size:13px !important;} .fs-14{font-size:14px !important;}  .fs-15{font-size:15px !important;}  .fs-16{font-size:16px !important;}  .fs-17{font-size:17px !important;}  .fs-18{font-size:18px !important;}  .fs-19{font-size:19px !important;}  .fs-20{font-size:20px !important;} .fs-21{font-size:21px !important;}.fs-22{font-size:22px !important;}
  
  
 
  .modal-dialog {
    max-width: 1000px;
	top: 10%;
   }
   .modal-header{
	   background-color:#333;
	   padding: 13px;
   }
    
   .modal-header .modal-title, .modal-header button i {
   		color:#fff;
   }

	.new-even{
		width: 100%;
		height: 250px;
		border: 1px solid #d5d4d4;
		border-radius: 10px;
		padding: 10px;
	}
	
	.even-ul,.even-ul .even-li{
		margin:0px;
		padding:0px;
		list-style:none;
		line-height:2;
	}
	.overflow-even{
		overflow-x: hidden !important;
		overflow: scroll;
		height: 160px;
		width: 100%;
	}
	.btn1-bg-cancel,.btn1-bg-cancel:hover {
    	background-color: #efefef;
    	color: #181818;
    	font-weight: bold !important;
	}
	.dataTables_length label {
    font-size: 12px !important;
    width: 100% !important;
    display: flex;
    padding-left: 15px;
}
.password-container {
      position: relative;
      
    }

    

    .password-container .toggle-icon {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 20px;
      color: #666;
    }

    .password-container .toggle-icon:hover {
      color: #333;
    }
    .password-requirements ul {
        list-style-type: none;
        padding: 0;
        font-size: 12px;
    }
    .password-requirements li {
        color: red;
    }
    .password-requirements li.valid {
        color: green;

    }
    .toggle-icon {
        cursor: pointer;
        margin-left: 10px;
    }
</style>
<h1 class="container" style=" font-size: 30px !important; ">Suppliers Information</h1>

<? if($msg_email_exist !=''){ ?>
<h1 class="container" style=" color:red; font-size: 30px !important; "><?=$msg_email_exist;?></h1>
<? } ?>
<? if($msg !=''){ ?>
 <div class="alert alert-success"><?=$msg;?></div>
<? } ?>
<div class="container pt-0 mt-5 p-0 ">

	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
	<div class="row m-0 p-0 pt-1 pb-3">
		<div class="col-sm-6 col-md-6 col-lg-6">
		
			<table  class="w-100">
				<caption></caption>
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Suppliers Name</td>
						<td class="td2">
						<input  name="<?=$unique?>" id="<?=$unique?>" value="<?=$_SESSION[$unique]?>" type="hidden" />
						<input name="group_for" required type="hidden" id="group_for" tabindex="1" value="<?=$_SESSION['user']['group'];?>" >
						<input  name="vendor_name" required type="text" id="vendor_name" tabindex=1 value="<?=$vendor_name?>">
						
						</td>
					</tr>
												
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Suppliers Category	</td>
						<td class="td2">
							<select name="vendor_category" required id="vendor_category"  tabindex=2>
									<option></option>
									<? foreign_relation('vendor_category v','v.id','v.category_name',$vendor_category,'v.status="ACTIVE" and v.group_for="'.$_SESSION['user']['group'].'"');?>
							</select>
						</td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Primary Contact Name	</td>
						<td class="td2"><input name="contact_person_name" type="text" id="contact_person_name" tabindex=3 value="<?=$contact_person_name?>" /></td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Primary Contact Email</td>
						<td class="td2"><input onkeyup="userCopy(this.value)"  name="email" type="email" id="email" tabindex=4 value="<?=$email?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address."/></td>
					</tr>
					
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Current Address</td>
						<td class="td2"><input  name="address" type="text" id="address" tabindex=5 value="<?=$address?>" required/></td>
					</tr>
				
			</table>
		
		</div>
<script>
	function userCopy(val){
		document.getElementById('tin').value=val;
	}
</script>		
		
		<div class="col-sm-6 col-md-6 col-lg-6">
		
		
					<table  class="w-100">
					    <caption></caption>
				
				
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Supplier User ID</td>
						<td class="td2"><input readonly type="text" name="tin" id="tin" value="<?=$tin;?>" tabindex=6  /></td>
					</tr>
					
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Status</td>
						<td class="td2">
						<select name="status" id="status" required="required" tabindex=7 >
                              <option value="ACTIVE" <?=$status=='ACTIVE'?'selected':'';?>>ACTIVE</option>

                               <option value="INACTIVE" <?=$status=='INACTIVE'?'selected':'';?>>INACTIVE</option>


                        </select>
						</td>
					</tr>
					
					<tr class="tr">
						<td class="td1 fs-14 bold">Secondary Contact Name</td>
						<td class="td2"><input type="text" name="beneficiary_name" id="beneficiary_name" value="<?=$beneficiary_name?>"  tabindex=8 /></td>
					</tr>
					
					<tr class="tr">
						<td class="td1 fs-14 bold">Secondary Contact Email</td>
						<td class="td2"><input type="email" name="cc_email" id="cc_email" value="<?=$cc_email?>"  tabindex=9/></td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Country</td>
						<td class="td2"><input required name="country" type="text" id="country" tabindex=10 value="<?=$country?>" /></td>
					</tr>
					<? if(isset($_GET[$unique])){?>
					<tr class="tr">
						<td class="td1 fs-14 bold">Password</td>
						<td class="td2">
						    <div class="password-container"><input type="password" name="password" id="password" value="<?=url_decode($password)?>">
						<span class="toggle-icon" id="togglePassword">&#128065;</span>
						</div>
						<div id="passwordRequirements" class="password-requirements">
						<ul>
							<li id="length">8 or more characters long</li>
							<li id="number">Password must contain 1 number</li>
							<li id="upperCase">Password must contain 1 uppercase character</li>
							<li id="lowerCase">Password must contain 1 lowercase character</li>
							<li id="specialChar">Password must contain 1 special character</li>

						</ul>
					</div>	
									</td>
					</tr>
					<? }?>
			</table>

		</div>
		
		
		<div class="w-100 pt-3">
									<? if(!isset($_GET[$unique])){?>
								<input name="insert" type="submit" id="insert" value="Save &amp; New" class="btn1 btn1-bg-cancel" tabindex=7/>
							<? }?>

							<? if(isset($_GET[$unique])){?>
								<input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-cancel" tabindex=8/>
							<? }?>

							<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" tabindex=9/>
		
		 </div>
		
	</div>
	</form>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<!--<div class="d-flex justify-content-start d-flex-bg-color">
	<div class="dropdown" id="dropdown">
		<button type="button" class="btn1 btn1-bg-submit" onclick="toggleDropdown()" style=" margin-bottom: 4px !important; ">Export to</button>
		  <div class="dropdown-content" id="myDropdown">
			<a href="#">CSV plain (current columns)</a>
			<a href="#">CSV for Excel (current columns)</a>
			<a href="#">Excel (current columns)</a>
		  </div>
	</div>

	<form class="form-inline m-0 p-0" action="">
	<div style=" padding-top: 10px; ">
		<div class="form-group row m-0 p-0" style=" width: 300px; ">
		<label for="inputPassword" class="col-sm-2 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">View</label>
		<div class="col-sm-10">
		        <select id="search_with" name="search_with" class="form-control" style="height: 28px !important;padding-top: 4px; ">
					<option value="vendor_name">Name</option>
					<option value="email">Email</option>
					<option value="contact_no">Contact Number</option>
					<option value="address">Address</option>
      			</select>
		</div>
	  </div>
  </div>
	<div style=" padding-top: 10px; ">
	  	  
		<div class="input-group" style=" background-color: white; border-radius: 5px; ">
				  <input type="text" class="form-control" id="search_box" name="search_box" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" style="height: 28px !important;padding-top: 2px; border-right: none; ">
		  <button type="button" class="input-group-prepend" style=" width: 25%; height: 27px !important; border: none; border-radius: 0px 5px 5px 0px; background-color: white; "
		  onclick="get_vendor(document.getElementById('search_with').value,document.getElementById('search_box').value)">
			Search
		  </button>
		</div>
	  
	</div>
	</form>  
</div>-->
<div class="container new pt-5">
<!--<span id="vendor_detailss">-->
<table id="example" class="table1  table-striped table-bordered table-hover table-sm" style="width: 100% !important; zoom: 90% !important;">
                    <thead class="thead1">
				<tr class="bgc-info">
					<th  scope="col">Action</th>
					<th scope="col" >ID</th>
					<th  scope="col" >Suppliers Name </th>
					<th scope="col">Suppliers Category</th>
					<th scope="col">Primary Contact Name</th>
					<th  scope="col" >Primary Contact Email</th>
					<th  scope="col" >Current Address</th>
					
					<th scope="col" >Supplier User ID</th>
					<th scope="col" >Status</th>
					<th  scope="col" >Secondary Contact Name</th>
					<th  scope="col" >Secondary Contact Email</th>
					<th  scope="col" >Country</th>
					<th  scope="col" >Entry By</th>
				</tr>
				</thead>

				<tbody class="tbody1">

				<?php


				if($_POST['group_for']!="")

					{$con .= 'and a.group_for="'.$_POST['group_for'].'"';}

				if($_POST['depot']!="")

					{$con .= 'and a.depot="'.$_POST['depot'].'"';}



				$td='select a.'.$unique.',  a.'.$shown.' as vendor_name,   a.email, a.entry_by, a.contact_person_name, a.language, a.vendor_category,
				a.email, a.address, a.tin, a.status, a.beneficiary_name, a.cc_email, a.country
				from '.$table.' a
				where   1     '.$con.' order by a.vendor_id '; //and a.group_for="'.$_SESSION['user']['group'].'" 

				$report=db_query($td);

				while($rp=mysqli_fetch_object($report)){$i++; if($i%2==0){$cls=' class="alt"';} else {$cls='';}?>

					<tr<?=$cls?>  bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>" style="text-align:left">
						<td>
							<button type="button" onclick="DoNav('<?php echo $rp->vendor_id;?>');" class="btn2 btn1-bg-update"><em class="fa-solid fa-pen-to-square"></em></button>
						</td>
						<td><?=$rp->vendor_id;?></td>
						<td><?=$rp->vendor_name;?></td>
						<td style="text-align:left"><?=find_a_field('vendor_category','category_name','id="'.$rp->vendor_category.'"'); ?></td>
						<td><?=$rp->contact_person_name;?></td>
						<td style="text-align:left"><?=$rp->email;?></td>
						<td><?=$rp->address?></td>
						<td><?=$rp->tin;?></td>
						<td><?=$rp->status;?></td>
						<td><?=$rp->beneficiary_name;?></td>
						<td><?=$rp->cc_email;?></td>
						<td><?=$rp->country;?></td>
						<td style="text-align:left"><?=find_a_field('user_activity_management','fname','user_id="'.$rp->entry_by.'"'); ?> </td>
					</tr>
				<?php }?>
				</tbody>
			</table>
<!--	</span>-->
	</div>
	
	
	
	
</div>
<script>
//function get_vendor(search_with,search_text){
//	 getData2('get_master_vendor_ajax.php','vendor_detailss',search_with,search_text);
//}
</script>
<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
	const requirements = {
        length: document.getElementById('length'),
        number: document.getElementById('number'),
        upperCase: document.getElementById('upperCase'),
        lowerCase: document.getElementById('lowerCase'),
        specialChar: document.getElementById('specialChar'),
        // previousPass: document.getElementById('previousPass') // Server-side validation
    };

    const checkPassword = (password) => {
        // Update requirements dynamically
        requirements.length.classList.toggle('valid', password.length >= 8);
        requirements.number.classList.toggle('valid', /\d/.test(password));
        requirements.upperCase.classList.toggle('valid', /[A-Z]/.test(password));
        requirements.lowerCase.classList.toggle('valid', /[a-z]/.test(password));
        requirements.specialChar.classList.toggle('valid', /[!@#$%^&*(),.?":{}|<>]/.test(password));
        // Note: The 'previousPass' requirement must be checked on the server side
    };

    passwordInput.addEventListener('input', (e) => {
        checkPassword(e.target.value);
    });

    //  togglePassword.addEventListener('click', function () {
    //   const type = passwordInput.type === 'password' ? 'text' : 'password';
    //   passwordInput.type = type;
    //   this.textContent = type === 'password' ? '\u{1F441}' : '\u{1F440}';
    // });

	window.onload = function() {
		checkPassword(passwordInput.value);
	
};
  </script>

<?
datatable("#example");
require_once SERVER_ROOT."public/assets/datatable/datatable.php";
require_once "../../../controllers/routing/layout.bottom.php";
?>