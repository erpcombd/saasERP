<?php


require_once "../../../controllers/routing/layout.top.php";
require_once(SERVER_CORE.'mailer/phpmail.php');


$current_page = "setup";
$title='User Information Setup';
do_datatable('user_info');


$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

do_datatable('table_head');

do_calander('#expire_date');

$page="user_info.php";

$table='user_activity_management';		

$unique='user_id';			

$shown='email';				


if($_GET['mhafuz']==2){

unset($_SESSION[$unique]);
echo '<script>window.location.href = "user_info.php"</script>';
}

$Crud      =new Crud($table);

if($_GET[$unique]>0){
$_SESSION[$unique] = $_GET[$unique];
}

if($_SESSION['user']['level']!=3){
$_SESSION[$unique] = $_SESSION['user']['id'];
header('Location:user_info_self.php');
}

if(isset($_POST[$shown]))

{

$_SESSION[$unique] = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$pass = $_POST['email'].'_nu';
$_POST['password']=auth_encode($pass);
$_POST['username']=$_POST['email'];

$found = find_a_field('user_activity_management','count(user_id)','email like "'.$_POST['email'].'"');
if($found<1){

$now = time();

$entry_by = $_SESSION['user'];
$email_id=auth_encode($_POST['email']);

	// $folder='user_pic';
	// $field = 'user_pic';  
	// $file_name = $folder.'-'.$user_id;
	// if($_FILES['user_pic']['tmp_name']!=''){
	// 	$_POST['user_pic']=upload_file($folder,$field,$file_name);
	// }


$user_id = $Crud->insert();

$tr_no = $user_id;
$tr_from = 'business_user';
$email = $_POST['email'];
$link = '/app/views/auth/eProc/update_pass _change_link.php?tyxzsd="'.$email_id.'"';
$status = 'no';
$expiration_time = date('Y-m-d H:i:s', strtotime('+7 days'));
$sql_expire_add = "INSERT INTO link_expiration_information (tr_no, tr_from, email, link, expiration_time, status) 
	VALUES ('$tr_no', '$tr_from', '$email', '$link', '$expiration_time', '$status')";

// $folder='user_pic';
// $field = 'user_pic';  
// $file_name = $folder.'-'.$user_id;
// if($_FILES['user_pic']['tmp_name']!=''){
// 	$_POST['user_pic']=upload_file($folder,$field,$file_name);
// }
		
$type=1;

$msg='New Entry Successfully Inserted.';

$body = 'Dear Concerned,';
$body .='<br>';
$body .='<br>';
$body .='Welcome to Robi eSourcing Platform. Your User Account has been created successfully. Below are your login credentials:';
$body .='<br>';
// $body .='User Account : '.$_POST['email'];
// $body .='<br>';
// $body .='Password : '.$pass;
// $body .='<br>';
// $body .= '<a href="https://esourcing.robi.com.bd/esourcing/app/views/auth/eProc/" target="_blank" rel="noopener">Click here for login</a>';
$body .= '<a href="https://esourcing.robi.com.bd/esourcing/app/views/auth/eProc/update_pass_change_link.php?tyxzsd='.$email_id.'" target="_blank" rel="noopener">Click here for login</a>';

$body .='<br>';
$body .='<br>';
$body .='Thank You';
$body .='<br>';
$body .='Robi eSourcing Platform';
$body .='<br>';

mailer($_POST['email'],'Welcome to Robi eSourcing Platform',$body);
echo '<span style="color:green; font-size:20px;">New User Created Successfully</span>';
}else{
	$msg='Email is already exist';
}
unset($_POST);

unset($_SESSION[$unique]);
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

		$_POST['edit_by'] = $_SESSION['user']['id'];
		 
		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');
		 $pass = $_POST['password'];

            // Validate password
    $passwordErrors = validate_password($pass);
    if (!empty($passwordErrors)) {
        $msg = implode('<br>', $passwordErrors);
    }else{

		 $_POST['password']=auth_encode($pass);
		 $found = find_a_field('user_activity_management','count(user_id)','email like "'.$_POST['email'].'" and user_id !="'.$_POST['user_id'].'"');
		 if($found<1){
   
	$folder='user_pic';
	$field = 'user_pic';  
	$file_name = $folder.'-'.$_POST['user_id'];
	if($_FILES['user_pic']['tmp_name']!=''){
		$_POST['user_pic']=upload_file($folder,$field,$file_name);
	}

		$Crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
	}else{
		$msg='Email is already exist';
	}
}

}

$folder='user_pic'; 
$field = 'user_pic';  
$file_name = $folder.'-'.$unique;

if($_FILES['user_pic']['tmp_name']!=''){
$_POST['user_pic']=upload_file($folder,$field,$file_name);
}



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
    background-color: #f9f9f9;
    min-width: 210px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
	left: 10px; 
	padding: 5px 0px;
	border-radius: 3px;
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
        /* text-decoration: line-through; */
    }
    .toggle-icon {
        cursor: pointer;
        margin-left: 10px;
    }

</style>
</style>
<h1 class="container" style=" font-size: 30px !important; ">User Information Setup</h1>

<? if($msg !=''){ ?>
 <div class="alert alert-success"><?=$msg;?></div>
<? } ?>

<div class="container pt-0 mt-5 p-0 ">

	<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data" autocomplete="off">
	<div class="row m-0 p-0 pt-1 pb-3">
		<div class="col-sm-6 col-md-6 col-lg-6">
		
			<table  class="w-100">
				<tbody>
				
					
												
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Full Name</td>
						<td class="td2"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$_SESSION[$unique]?>" type="hidden" />
							<input name="user_id" type="hidden" id="user_id" tabindex="1" value="<?=$_GET['user_id']?>" readonly>
							<input name="fname"  type="text" id="fname" tabindex=2 value="<?=$fname?>" required ></td>
					</tr>
					
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">E-mail</td>
						<td class="td2">
						<input name="email" type="email" id="email" tabindex=3 value="<?=$email?>" required class="required" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address.">
						<? $_POST['entry_by'] = $_SESSION['user']['id'];?>
						 <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_POST['entry_by'];?>"  />
						 <input name="entry_at" type="hidden" required id="entry_at" tabindex="10" value="<?=$now=date('Y-m-d H:i:s');?>"  />
						</td>
					</tr>

					
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Expire Date</td>
						<td class="td2"><input name="expire_date" type="date" id="expire_date" min="<?=date('Y-m-d')?>"  required value="<?=$expire_date?>" onchange="checkExpirationStatus()" tabindex=4/></td>
					</tr>
						
					<tr class="tr">
						<td class="td1 fs-14 bold">Company</td>
						<td class="td2">
							<select name="group_for" required id="group_for"  tabindex=5>
								  <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
						   </select>
						</td>
					</tr>

					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Status <?=$status;?></td>
						<td class="td2">
							<select name="status" required id="status"  tabindex=5 required>
								  <option <?php if($status=='Active') echo 'selected'; ?> value="Active">Active</option>
								  <option <?php if($status=='Inactive') echo 'selected'; ?> value="Inactive">Inactive</option>
						   </select>
						</td>
					</tr>
				


				
				</tbody>
			</table>
		
		</div>
		
		<div class="col-sm-6 col-md-6 col-lg-6">
		
		
					<table  class="w-100">
				<tbody>
								
					<tr class="tr">
						<td class="td1 fs-14 bold">Designation</td>
						<td class="td2"><input name="designation" required type="text" id="designation" tabindex=6 value="<?=$designation?>"></td>
					</tr>
					
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">User role</td>
						<td class="td2"><select name="level" id="level"  tabindex=7 required	>
									<option <?php if($level=='5') echo 'selected'; ?> value="5" >Sourcing Manager</option>
									<option <?php if($level=='4') echo 'selected'; ?> value="4" >Business User</option>
									<option <?php if($level=='3') echo 'selected'; ?> value="3" >Admin</option>
							</select></td>
					</tr>
					<tr class="tr">
						<td class="td1 fs-14 bold">Division</td>
						<td class="td2"><select name="division" id="division" >
						<? foreign_relation('user_division','id','division_name',$division,'1');?>
									
							</select></td>
					</tr>
					
							
					<tr class="tr">
						<td class="td1 fs-14 bold">Mobile</td>
						<td class="td2">
						<input name="mobile" type="text" id="mobile" tabindex=8 value="<?=$mobile?>" />
						<!-- <input name="status" type="hidden" id="status" tabindex=8 value="In Service" /> -->
						</td>
					</tr>
							
					
						
							
					<tr class="tr">
						<td class="td1 fs-14 bold">Department</td>
						<td class="td2"><select name="department" id="department" >
									<option <?php if($division=='department1') echo 'selected'; ?> value="department1" >department1</option>
									<option <?php if($division=='department2') echo 'selected'; ?> value="department2" >department2</option>
									
							</select></td>
					</tr>
					<? if(isset($_GET[$unique])){?>
					<tr class="tr">
						<td class="td1 fs-14 bold">Password</td>
						<td class="td2">
						    <div class="password-container"><input type="password" name="password" id="password"  value="<?=url_decode($password)?>">
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
					

				
				</tbody>
			</table>
			

		
		
		</div>
		
		
		<div class="w-100 pt-3"> 
		
		            <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-cancel" tabindex=10/>
                     <? }?>
                   
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" tabindex=11/>
                      <? }?>
                    
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page.'?new=2'?>'" tabindex=12/>
					  
		</div>
		
	</div>
	</form>
	

<table id="example" class="table1  table-striped table-bordered table-hover table-sm">
    <caption></caption>
                    <thead class="thead1">
							<tr class="bgc-info">
								<th scope="col" scope="col"><span>Action</span></th>
								<th scope="col" scope="col"><span>User ID</span></th>
								<th scope="col" scope="col"><span>Full Name</span></th>
								<th scope="col" scope="col"><span>Designation</span></th>
								<th scope="col" scope="col"><span>E-mail </span></th>
								<th scope="col" scope="col"><span>User Role </span></th>
								<th scope="col" scope="col"><span>Expire Date</span></th>
								<th scope="col" scope="col"><span>Division</span></th>
								<th scope="col" scope="col"><span>Company</span></th>
								<th scope="col" scope="col"><span>Mobile</span></th>
								<th scope="col" scope="col"><span>Status</span></th>
								<th scope="col" scope="col"><span>Department</span></th>
								<th scope="col" scope="col">Create By</th>
							</tr>
						</thead>
						
						<tbody>
						
						<?php
						
						
						if($_POST['group_for']!="")
						{
						$con .= 'and a.group_for="'.$_POST['group_for'].'"';
						}
						if($_POST['warehouse_id']!="")
						{
						$con .= 'and a.warehouse_id="'.$_POST['warehouse_id'].'"';
						
						}
						
				
						
						//select a.user_id, a.email , a.fname, a.designation, a.expire_date, a.level, a.entry_by, a.status 
						
						$td='select a.'.$unique.',  a.'.$shown.' ,  a.fname, a.designation, a.expire_date, a.level, a.entry_by, 
						a.status, a.division, a.group_for, a.mobile, a.department from '.$table.' a, user_group u where   a.group_for=u.id   '.$con.' order by a.user_id  ';
						
						$report=db_query($td);
						
						while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0){$cls=' class="alt"'; }else {$cls='';}?>
						<!-- show pointer -->
						<tr<?=$cls?>>
						<td><button type="button" onclick="DoNav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-update"><em class="fa-solid fa-pen-to-square"></em></button></td>
						<td><?=$rp[0];?></td>
						<td  style="text-align:left;"><?=$rp[2];?></td>
						<td  style="text-align:left;"><?=$rp[3];?></td>
						<td><?=$rp[1];?></td>
						<td><? if($rp[5]==5){ echo 'Sourcing Manager';} elseif($rp[5]==4){ echo 'Business User';} elseif($rp[5]==3){ echo 'Admin';}?></td>
						<td><?=$rp[4];?></td>
						<td><?=$rp[8];?></td>
						<td><?php echo find_a_field('user_group','group_name','id='.$rp[9]);?></td>
						<td><?=$rp[10];?></td>
						<td><?=$rp[7];?></td>
						<td><?=$rp[11];?></td>
						<td style="text-align:left;"><?=find_a_field('user_activity_management','fname','user_id="'.$rp[6].'"'); ?> </td>
						</tr>
						
						<?php }?>
	</tbody>
	</table>
	
	
	
	
	
	
</div>




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

 
  </script>

<script>
function checkExpirationStatus() {

    const expireDateInput = document.getElementById('expire_date');
    const statusSelect = document.getElementById('status');
    const currentDate = new Date().toISOString().split('T')[0]; // Get today's date in YYYY-MM-DD format

    if (expireDateInput.value && expireDateInput.value < currentDate) {
        statusSelect.value = 'Inactive';
    }
	checkPassword(passwordInput.value);
}

// Run the checkExpirationStatus function on page load
window.onload = function() {
    checkExpirationStatus();
	
};
</script>


<?
datatable("#example");
require_once SERVER_ROOT."public/assets/datatable/datatable.php";
require_once "../../../controllers/routing/layout.bottom.php";
?>