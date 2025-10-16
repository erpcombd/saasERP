<?php

require_once "../../../controllers/routing/layout.top.php";
$current_page = "setup";
$title='Create Product Group';

$proj_id=$_SESSION['proj_id'];


do_datatable('table_head');

$now=time();
$unique='group_id';
$unique_field='group_name';
$table='item_group';
$page="item_group.php";
$Crud      =new Crud($table);
$_SESSION[$unique] = $_GET[$unique];
$tr_type="Show";

if($_GET['mhafuz']==2){

unset($_SESSION[$unique]);
echo '<script>window.location.href = "item_group.php"</script>';
}

if(isset($_POST[$unique_field]))
{
$_SESSION[$unique] = $_POST[$unique];


if(isset($_POST['record']))
{		

$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['ledger_group_id']=$inventory;





$Crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($_SESSION[$unique]);
$tr_type="Add";
}









if(isset($_POST['modify']))

{       
		$_POST['edit_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$Crud->update($unique);
		
		$type=1;
		$msg='Successfully Updated.';
		$tr_type="Add";
}





if(isset($_POST['delete']))

{		
		$condition=$unique."=".$_SESSION[$unique];		
		$Crud->delete($condition);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Deleted.';
}



}

if(isset($_SESSION[$unique]))

{

$condition=$unique."=".$_SESSION[$unique];	
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ ${$key}=$value;}
}
$tr_from="Warehouse";
?>

<script type="text/javascript">
function Do_Nav()
{
	var URL = 'pop_ledger_selecting_list.php';
	popUp(URL);
}
$(document).ready(function(){
	
	$("#form1").validate();	
});	
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
.nav-tabs{
	border-bottom: 1px solid #d9d9d9;
	background-color: ghostwhite;
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
<h1 class="container" style=" font-size: 30px !important; ">Create Product Group</h1>
<? if($msg !=''){ ?>
 <div class="alert alert-success"><?=$msg;?></div>
<? } ?>

<div class="container pt-0 mt-5 p-0 ">
			
	<form id="form1" name="form1" method="post" action="" onsubmit="return check()">
	<div class="row m-0 p-0 pt-1 pb-3">
		<div class="col-sm-6 col-md-6 col-lg-6">
		
			<table  class="w-100">
				<caption></caption>
				
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Group Name</td>
						<td class="td2">
						<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$_SESSION[$unique]?>"  />
						<input name="group_name" required type="text" id="group_name" value="<?php echo $group_name;?>" class="required" tabindex=1 />
						<input name="group_for" type="hidden" id="group_for" value="<?php echo $_SESSION['user']['group'];?>" class="required" />
						</td>
					</tr>			
				
			</table>
		
		</div>
		
		<div class="col-sm-6 col-md-6 col-lg-6">
					<table  class="w-100">
				
					<tr class="tr">
						<td class="td1 fs-14 bold">Description</td>
						<td class="td2"><input name="description" type="text" id="description" value="<?php echo $description;?>" class="required" tabindex=2/></td>
					</tr>
			
			</table>

		
		
		</div>
		
		
	  <div class="w-100 pt-3">

					<? if($_SESSION[$unique]<1){?>
						<input name="record" type="submit" class="btn1 btn1-bg-cancel" id="record" value="Save" tabindex=3/>
					<? }?>

					<? if($_SESSION[$unique]>0){?>
						<input name="modify" type="submit" class="btn1 btn1-bg-update" id="modify" value="update" tabindex=4/>
				  <? }?>
				  <input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>?new=2'" value="Clear" tabindex=5/>
				  <?php ?>
	    </div>
		
	</div>
	</form>
	
<table id="example" class="table1  table-striped table-bordered table-hover table-sm">
    <caption> </caption>
                    <thead class="thead1">
					<tr class="bgc-info">
						<th scope="col" scope="col"> Group ID </th>
						<th scope="col" scope="col"> Product Group </th>
						<th scope="col" scope="col"> Description </th>
						<th scope="col" scope="col">Create By</th>
					</tr>
					</thead>

					<tbody>

					<?php


					if($_POST['group_for']!="")
					  {

						$con .= 'and b.group_for="'.$_POST['group_for'].'"';
					  }


					$rrr = "select b.group_id,  b.group_name, b.description, b.entry_by from item_group b, user_group a where a.id=b.group_for and group_for='".$_SESSION['user']['group']."' ";

					$report = db_query($rrr);
					$i=0;
					while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0){$cls=' class="alt"';} else {$cls='';}?>
						<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
							<td><?=$rp[0];?></td>
							<td><?=$rp[1];?></td>
							<td><?=$rp[2];?></td>
							<td><?=find_a_field('user_activity_management','fname','user_id='.$rp[3]);?></td>
						</tr>
					<?php }?>


					</tbody>
				</table>

	
	
	
	
	
	
</div>

<?
datatable("#example");
require_once SERVER_ROOT."public/assets/datatable/datatable.php";
require_once "../../../controllers/routing/layout.bottom.php";
?>