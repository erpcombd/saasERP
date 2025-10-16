<?php

require_once "../../../controllers/routing/layout.top.php";
$current_page = "setup";


$unique='id';  		
$title='Currency Information' ; 	
$page="currency_info.php";		
$table='currency_info';		


$crud      =new crud($table);
$$unique = $_GET[$unique];


if(isset($_POST['submit']))
{		
$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['entry_by']=$_SESSION['user']['id'];
$found = find_a_field('currency_info','count(id)','currency like "'.$_POST['currency'].'"');
if($found<1){
	$group_name = trim($_POST['currency']);
	if (!empty($group_name)) {

		$found2 = find_a_field('currency_info','count(id)','currency_code like "'.$_POST['currency_code'].'"');
		if($found2<1){
			$group_name2 = trim($_POST['currency_code']);
			if (!empty($group_name2)) {
		$crud->insert();
		$type=1;
		$msg='New Entry Successfully Inserted.';
	}else{
		$msg='Empty value can not be inserted';
	}
	}else{
	$msg='Currency code is already exist';
	}
	}else{
		$msg='Empty value can not be inserted';
	}
	}else{
	$msg='Currency is already exist';
	}
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
<h1 class="container" style=" font-size: 30px !important; ">Mail Logs</h1>

<? if($msg !=''){ ?>
 <div class="alert alert-success"><?=$msg;?></div>
<? } ?>

<div class="container pt-0 mt-5 p-0 ">


	
	
	
	
</div>

<table id="example" class="table1 table-striped table-bordered table-hover table-sm">
    <caption></caption>
    <thead class="thead1">
        <tr class="bgc-info">
            <th scope="col">ID</th>
            <th scope="col">RFQ No</th>
            <th scope="col">Sender</th>
            <th scope="col">Recipients</th>
            <th scope="col">CC</th>
            <th scope="col">Subject</th>
            <th scope="col">Status</th>
            <th scope="col">Reason</th>
            <th scope="col">Sent At</th>
            <!-- <th scope="col">Action</th> -->
        </tr>
    </thead>

    <tbody>
        <?php
            $data = "SELECT * FROM mail_logs WHERE 1 ORDER BY id DESC"; 
            $query = db_query($data);
            while ($row = mysqli_fetch_object($query)) {
			if($row->status=='Success'){
        ?>
		 
            <tr>
                <td><?= $row->id; ?></td>
                <td><?= $row->rfq_no; ?></td>
                <td><?= $row->sender; ?></td>
                <td><?= $row->recipients; ?></td>
                <td><?= $row->cc; ?></td>
                <td><?= $row->subject; ?></td>
                <td><?= $row->status; ?></td>
                <td><?= $row->reason; ?></td>
                <td><?= $row->sent_at; ?></td>
                <!-- <td><button type="button" onclick="nav('<?//= $row->id; ?>');" class="btn2 btn1-bg-update"><em class="fa-solid fa-pen-to-square"></em></button></td> -->
            </tr>
			<?}else{?>
				<tr>
                <td style="color: red;"><?= $row->id; ?></td>
                <td style="color: red;"><?= $row->rfq_no; ?></td>
                <td style="color: red;"><?= $row->sender; ?></td>
                <td style="color: red;"><?= $row->recipients; ?></td>
                <td style="color: red;"><?= $row->cc; ?></td>
                <td style="color: red;"><?= $row->subject; ?></td>
                <td style="color: red;"><?= $row->status; ?></td>
                <td style="color: red;"><?= $row->reason; ?></td>
                <td style="color: red;"><?= $row->sent_at; ?></td>
                <!-- <td><button type="button" onclick="nav('<?//= $row->id; ?>');" class="btn2 btn1-bg-update"><em class="fa-solid fa-pen-to-square"></em></button></td> -->
            </tr>
			<?}?>
        <?php } ?>
    </tbody>
</table>

	
	
	
	
	
	
</div>


<?
datatable("#example");
require_once SERVER_ROOT."public/assets/datatable/datatable.php";
require_once "../../../controllers/routing/layout.bottom.php";
?>