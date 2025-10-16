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

$Crud->insert();

$body = 'Dear Concerned,';
$body .='<br>';
$body .='<br>';
$body .='Welcome to Robi eSourcing Platform. Your User Account has been created successfully. Below are your login credentials';
$body .='<br>';
$body .='Username : '.$_POST['email'];
$body .='<br>';
$body .='Password : '.$randomNumber;
$body .='<br>';

$body .= '<a href="https://esourcing.robi.com.bd/esourcing/app/views/auth/vendor/" target="_blank" rel="noopener">Click here for login</a>';
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









if(isset($_POST['update']))

{

$found = find_a_field('vendor','count(vendor_id)','email like "'.$_POST['email'].'" and vendor_id!='.$_GET['vendor_id']);
if($found<1){
			
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
</style>
<h1 class="container" style=" font-size: 30px !important; ">Suppliers Information</h1>

<? if($msg_email_exist !=''){ ?>
<h1 class="container" style=" color:red; font-size: 30px !important; "><?=$msg_email_exist;?></h1>
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
						<td class="td2"><input onkeyup="userCopy(this.value)"  name="email" type="email" id="email" tabindex=4 value="<?=$email?>" required/></td>
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
                              <option value="ACTIVE">ACTIVE</option>

                               <option value="INACTIVE">INACTIVE</option>


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
	
	
	
	
	
	
	
	
	
	
	
	
	
	
<div class="d-flex justify-content-start d-flex-bg-color">
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
</div>
<div class="container new" style=" overflow-x: scroll; height: 550px; ">
<span id="vendor_detailss">
<table class="table1  table-striped table-bordered table-hover table-sm overflow-x scroll">
    <caption></caption>
                    <thead class="thead1">
				<tr class="bgc-info" style=" text-wrap: nowrap; ">
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
	</span>
	</div>
	
	
	
	
</div>
<script>
function get_vendor(search_with,search_text){
	 getData2('get_master_vendor_ajax.php','vendor_detailss',search_with,search_text);
}
</script>

<?
require_once "../../../controllers/routing/layout.bottom.php";
?>