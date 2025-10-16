<?php

require_once "../../../controllers/routing/layout.top.php";
require_once(SERVER_CORE.'mailer/phpmail.php');

$current_page = "setup";
$title='Company Information Setup';
do_datatable('user_info');


$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

do_datatable('table_head');

$page="company_info.php";

$table='user_group';		

$unique='id';			

$shown='group_name';				


if($_GET['mhafuz']==2){

unset($_SESSION[$unique]);
echo '<script>window.location.href = "company_info.php"</script>';
}

$Crud  = new Crud($table);

if($_GET[$unique]>0){
	$_SESSION[$unique] = $_GET[$unique];
}

if(isset($_POST[$shown]))

{

$_SESSION[$unique] = $_POST[$unique];


if (isset($_POST['insert'])) {		
    $now = time();
    $entry_by = $_SESSION['user'];
    $_POST['entry_at'] = date('Y-m-d H:i:s');
    $_POST['entry_by'] = $_SESSION['user']['id'];

    // Insert data into the database

	$found = find_a_field('user_group','count(id)','group_name like "'.$_POST['group_name'].'"');
	if($found<1){
    $folder = SERVER_ROOT . "public/uploads/company_logo/";
    $field = 'company_logo';  
    $file_name = $folder . '-' .$_POST['group_name'];
	var_dump($_FILES['company_logo']['tmp_name']);
    if (!empty($_FILES['company_logo']['tmp_name'])) {
        $file_tmp = $_FILES['company_logo']['tmp_name'];
        $file_info = pathinfo($_FILES['company_logo']['name']);
        $file_ext = strtolower($file_info['extension']);

        // Allow only JPG and PNG files
        if (in_array($file_ext, ['jpg', 'jpeg', 'png'])) {
            $new_file_name = $file_name . '.' . $file_ext;
            $file_contents = file_get_contents($file_tmp);
			
            // Save the file using file_put_contents
			
            if (file_put_contents($new_file_name, $file_contents)) {
				$user_id = $Crud->insert();
                $_POST['company_logo'] = $new_file_name;
				$msg = 'New Company Inserted';
				
            } else {
                $msg = 'Failed to upload the file.';
                // Handle upload failure (optional)
            }
        } else {
            $msg = 'Invalid file type. Only JPG and PNG are allowed.';
            // Handle invalid file type (optional)
        }
    }

    $type = 1;
    // $msg = 'New Entry Successfully Inserted.';

    unset($_SESSION[$unique]);
}else{
	$msg='Already Exists';
	unset($_SESSION[$unique]);
}
}



// if(isset($_POST['insert']))

// {		


// $now = time();

// $entry_by = $_SESSION['user'];

// 	/*$folder='logo';
// 	$field = 'company_logo';  
// 	$file_name = $folder.'-'.$user_id;
// 	if($_FILES['company_logo']['tmp_name']!=''){
// 		$_POST['company_logo']=upload_file($folder,$field,$file_name);
// 	}*/
// $_POST['entry_at'] = $now=date('Y-m-d H:i:s');
// $_POST['entry_by'] = $_SESSION['user']['id'];

// $user_id = $Crud->insert();

// $folder=SERVER_ROOT . "public/uploads/company-logo/";;
// $field = 'company_logo';  
// $file_name = $folder.'-'.$user_id;
// if($_FILES['company_logo']['tmp_name']!=''){
// 	$_POST['company_logo']=upload_file($folder,$field,$file_name);
// }
		
// $type=1;

// $msg='New Entry Successfully Inserted.';

// unset($_SESSION[$unique]);
// }



if(isset($_POST['update']))

{
	$found = find_a_field('user_group','count(id)','group_name like "'.$_POST['group_name'].'" and id != "'.$_POST['id'].'"');
	if($found<1){
		$group_name = trim($_POST['group_name']);
		if (!empty($group_name)) {
		$_POST['edit_by'] = $_SESSION['user']['id'];
		 
		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');
   
	$folder='logo';
	$field = 'company_logo';  
	$file_name = $folder.'-'.$_POST['id'];
	if($_FILES['company_logo']['tmp_name']!=''){
		$_POST['company_logo']=upload_file($folder,$field,$file_name);
	}

		$Crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
	}	else{
			$msg='Empty value can not be inserted';
		}
}else{
			$msg='Already Exists';
			unset($_SESSION[$unique]);
		}

}

$folder='logo'; 
$field = 'company_logo';  
$file_name = $folder.'-'.$unique;

if($_FILES['company_logo']['tmp_name']!=''){
	$_POST['company_logo']=upload_file($folder,$field,$file_name);
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
</style>
<h1 class="container" style=" font-size: 30px !important; ">Company Information Setup</h1>
<? if($msg !=''){ ?>
 <div class="alert alert-success"><?=$msg;?></div>
<? } ?>
<div class="container pt-0 mt-5 p-0 ">

	<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data" autocomplete="off">
	<div class="row m-0 p-0 pt-1 pb-3">
		<div class="col-sm-6 col-md-6 col-lg-6">
		
			<table id="example" class="table1  table-striped table-bordered table-hover table-sm">
				<tbody>						
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Company Name</td>
						<td class="td2"><input name="<?=$unique?>" id="<?=$unique?>" value="<?=$_SESSION[$unique]?>" type="hidden" />
							<input name="id" type="hidden" id="id" tabindex="1" value="<?=$_GET['id']?>" readonly>
							<input name="group_name" required type="text" id="group_name" tabindex=2 value="<?=$group_name?>" ></td>
					</tr>
					
					
					<tr class="tr">
						<td class="td1 fs-14 bold">Address</td>
						<td class="td2"><textarea name="address"  id="address"><?=$address;?></textarea></td>
					</tr>
					<tr class="tr">
					<td class="td1 fs-14 bold req-input">Status</td>
					<td class="td2">
					<select name="status" required id="status"  tabindex=5 required>
								  <option <?php if($status=='1') echo 'selected'; ?> value="1">Active</option>
								  <option <?php if($status=='0') echo 'selected'; ?> value="0">Inactive</option>
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
						<td class="td1 fs-14 bold req-input">Logo</td>
						<td class="td2">
			
                        <input  name="company_logo" type="file" id="company_logo" value=""  <?if($_GET['id']>0){echo '';}else{echo 'required';}?>  tabindex=9/>
						
						<?php if ($company_logo!=''){?>
				<img src="../../../../public/assets/images/logo/<?=$company_logo?>" alt="<?=$group_name;?>"  style="width:20%; height:20%" />
<?php } ?>
						</td>
					</tr>
					

				
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
	
	
	
	
	
<div class="d-flex justify-content-start d-flex-bg-color">
	<div class="dropdown" id="dropdown">
		<button type="button" class="btn1 btn1-bg-submit" onclick="toggleDropdown()" style=" margin-bottom: 4px !important; ">Export to </button>
		  <div class="dropdown-content" id="myDropdown">
			<a href="#">CSV plain (current columns)</a>
			<a href="#">CSV for Excel (current columns)</a>
			<a href="#">Excel (current columns)</a>
		  </div>
	</div>


	<div style=" padding-top: 10px; ">
		<div class="form-group row m-0 p-0" style=" width: 300px; ">
		<label for="inputPassword" class="col-sm-2 col-form-label fs-14" style=" padding: 3px; color: white; font-weight: 600 !important; text-align: end; ">View</label>
		<div class="col-sm-10">
		        <select id="" name="" class="form-control" style="height: 28px !important;padding-top: 4px; ">
					<option> ALL</option>
					<option value="">opction </option>
					<option value="">opction </option>
      			</select>
		</div>
	  </div>
  </div>
	<div style=" padding-top: 10px; ">
	  	  <form class="form-inline m-0 p-0" action="">
		<div class="input-group" style=" background-color: white; border-radius: 5px; ">
				  <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon1" style="height: 28px !important;padding-top: 2px; border-right: none; ">
		  <button type="submit" class="input-group-prepend" style=" width: 25%; height: 27px !important; border: none; border-radius: 0px 5px 5px 0px; background-color: white; "> Search
		  </button>
		</div>
	  </form>
	</div>
	  
</div>

<table id="user_info" class="table1  table-striped table-bordered table-hover table-sm">
    <caption></caption>
                    <thead class="thead1">
							<tr class="bgc-info">
								  <th scope="col" scope="col"><span>ID</span></th>
								
								  <th scope="col" scope="col"><span>Company Name</span></th>
								  <th scope="col" scope="col"><span>Status</span></th>
								  <th scope="col" scope="col">Create By</th>
								
								  
							</tr>
						</thead>
						
						<tbody>
						
						<?php
						
						 $td='select a.'.$unique.',  a.'.$shown.', a.entry_by,a.status from '.$table.' a ';
						
						$report=db_query($td);
                        

						while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0){$cls=' class="alt"'; }else {$cls='';}?>
						
						<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
						  <td><?=$rp[0];?></td>
						
						<td><?=$rp[1];?></td>
						<td><?=$rp[3]=='0'?'Inactive':'Active'?></td>
						<td><?=find_a_field('user_activity_management','fname','user_id="'.$rp[2].'"'); ?> </td>
						

						
						</tr>
						
						<?php }?>
	</tbody>
	</table>
	
	
	
	
	
	
</div>


<?

require_once "../../../controllers/routing/layout.bottom.php";
?>