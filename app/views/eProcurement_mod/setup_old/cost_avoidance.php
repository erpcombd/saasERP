<?php

require_once "../../../controllers/routing/layout.top.php";
$current_page = "setup";


$unique='id';  		
$title='Cost Avoidance Information' ; 	
$page="cost_avoidance.php";		
$table='cost_avoidance';		


$crud      =new crud($table);
$$unique = $_GET[$unique];


if(isset($_POST['submit']))
{		
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];
		$crud->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
}


if(isset($_POST['update']))
{
$_POST['edit_at']=date('Y-m-d H:i:s');
$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}
	
	
if(isset($$unique))
{
$condition=$unique."=".$$unique;	

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)


{ $$key=$value;}
}	
?>


<script type="text/javascript">

function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}

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
<h1 class="container" style=" font-size: 30px !important; ">Savings Type Information</h1>

<? if($msg !=''){ ?>
 <div class="alert alert-success"><?=$msg;?></div>
<? } ?>

<div class="container pt-0 mt-5 p-0 ">

	<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
	<div class="row m-0 p-0 pt-1 pb-3">
	<!-- <div class="col-sm-4 col-md-4 col-lg-4"></div> -->
		<div class="col-sm-4 col-md-4 col-lg-4">
		
			<table  class="w-100">
				<caption></caption>
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">New Savings Type</td>
						<td class="td2">
							<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$_SESSION[$unique]?>" type="hidden" />
							<input class="m-0" name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
							<input class="m-0" name="cost_avoidance" required type="text" id="cost_avoidance" tabindex="1"  value="<?=$cost_avoidance?>" />
						
						</td>
					</tr>
				
			</table>
		
		</div>
		
		<div class="col-sm-4 col-md-4 col-lg-4"></div>
		
		
		<div class="w-100 pt-3">
                     <? if(!isset($_GET[$unique])){?>
                      <input class="btn1 btn1-bg-cancel" name="submit" type="submit" id="submit" value="Save"   tabindex="3"/>
                     <? }?>
					  
					 <? if(isset($_GET[$unique])){?>
                      <input class="btn1 btn1-bg-update" name="update" type="submit" id="update" value="Update"  tabindex="4"/>
					  
					 <? }?>
					  <input class="btn1 btn1-bg-cancel" name="reset" type="button"  id="reset" value="Reset" onclick="parent.location='<?=$page?>'" tabindex="5"/> 
		 
		 </div>
		
	</div>
	</form>
	
	
	
	
	
	
<table id="example" class="table1  table-striped table-bordered table-hover table-sm">
    <caption></caption>
                    <thead class="thead1">
<tr class="bgc-info" >
  	<th scope="col" scope="col">ID</th>
	<th scope="col" scope="col">Savings Type Name</th>
	<th scope="col" scope="col">Create By</th>
	<th scope="col" scope="col">Action</th>
</tr>
</thead>

<tbody>
				<?  $data = "SELECT * FROM  cost_avoidance WHERE 1"; 
					$query = db_query($data);
					while($row =mysqli_fetch_object($query)){
				?>
					<tr>
						<td><?=$row->id;?></td>
						<td  style="text-align:left;"><?=$row->cost_avoidance;?></td>
						<td  style="text-align:left;"><?=find_a_field('user_activity_management','fname','user_id="'.$row->entry_by.'"'); ?> </td>
						<td><button type="button" onclick="nav('<?=$row->id;?>');" class="btn2 btn1-bg-update"><em class="fa-solid fa-pen-to-square"></em></button></td>
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