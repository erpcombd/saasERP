<?php
 

require_once "../../../controllers/routing/layout.top.php";
$current_page = "setup";
$title='Product Information Setup';


do_datatable('item_table');

$proj_id=$_SESSION['proj_id'];



$now=time();

$unique='item_id';

$unique_field='item_name';

$table='item_info';

$page="item_info.php";

if($_GET['mhafuz']==2){

unset($_SESSION[$unique]);
echo '<script>window.location.href = "item_info.php"</script>';
}

$Crud      =new Crud($table);

$_SESSION[$unique] = $_GET[$unique];

$tr_type="Show";



if(isset($_POST[$unique_field]))

{

$_SESSION[$unique] = $_POST[$unique];



$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);





$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);



$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);

$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);





$_POST['group_for'] = find_a_field('item_sub_group','group_for','sub_group_id='.$_POST['sub_group_id']);

if(isset($_POST['record']))

{

$_POST['entry_at']=date('Y-m-d H:i:s');

$_POST['entry_by']=$_SESSION['user']['id'];



$min=number_format($_POST['sub_group_id'] + 1, 0, '.', '');

$max=number_format($_POST['sub_group_id'] + 10000, 0, '.', '');

$_POST[$unique]=number_format(next_value('item_id','item_info','1',$min,$min,$max), 0, '.', '');

$Crud->insert();



$type=1;

$msg='New Entry Successfully Inserted.';
$tr_type="Add";


unset($_POST);

unset($_SESSION[$unique]);

}







if(isset($_POST['modify']))

{

		

$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);

$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);



$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);



$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);

$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);



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
		$tr_type="Delete";

}







}



if(isset($_SESSION[$unique]))

{

	$condition=$unique."=".$_SESSION[$unique];	

	$data=db_fetch_object($table,$condition);

	foreach ($data as $key => $value){ ${$key}=$value;}

}









if($_REQUEST['src_sub_group_id']>0){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}

if($_REQUEST['src_item_id']!=''){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}

if($_REQUEST['item_group']!=''){$_SESSION['item_group'] = $_REQUEST['item_group'];$_SESSION['item_group'] = $_REQUEST['item_group'];}

if($_REQUEST['fg_code']!=''){$_SESSION['fg_code'] = $_REQUEST['fg_code'];$_SESSION['fg_code'] = $_REQUEST['fg_code'];}



if(isset($_REQUEST['cancel'])){unset($_SESSION['item_group']);unset($_SESSION['src_sub_group_id']);unset($_SESSION['src_item_id']);unset($_SESSION['fg_code']);}



if($_SESSION['item_group']>0){

$item_group = $_SESSION['item_group'];

$con .='and b.group_id="'.$item_group.'" ';}


if($_SESSION['src_sub_group_id']>0){

$src_sub_group_id = $_SESSION['src_sub_group_id'];

$con .='and a.sub_group_id="'.$src_sub_group_id.'" ';}



if($_SESSION['src_item_id']!=''){

$src_item_id = $_SESSION['src_item_id'];

$con .='and a.item_name like "%'.$src_item_id.'%" ';}



if($_SESSION['fg_code']>0){

$fg_code = $_SESSION['fg_code'];

$con .='and a.finish_goods_code="'.$fg_code.'" ';}
$tr_from="Warehouse";
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
<h1 class="container" style=" font-size: 30px !important; ">Product Information Setup</h1>

<? if($msg !=''){ ?>
 <div class="alert alert-success"><?=$msg;?></div>
<? } ?>

<div class="container pt-0 mt-5 p-0 ">

	<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data" onsubmit="return check()">
	<div class="row m-0 p-0 pt-1 pb-3">
		<div class="col-sm-6 col-md-6 col-lg-6">
		
			<table  class="w-100">
				<tbody>
				
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Product Code</td>
						<td class="td2"><input type="text" name="finish_goods_code" class="m-0" id="finish_goods_code" value="<?=$finish_goods_code?>" required tabindex=1/></td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold">Sub Group :</td>
						<td class="td2">
													<span id="product_sub_group">
										<?php



										$a2="select sub_group_id, sub_group_name from item_sub_group where 1 and group_for='".$_SESSION['user']['group']."'";

										

										$a1=db_query($a2);

										echo "<select name=\"sub_group_id\" id=\"sub_group_id\"\"  tabindex=2>";
										echo "<option></option>";
										while($a=mysqli_fetch_row($a1))

										{



											if($a[0]==$sub_group_id)
                                               {
												echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";
											   }
											else
											   {
												echo "<option value=\"".$a[0]."\">".$a[1]."</option>";
											   }
										}

										echo "</select>";

										?>




										</span>
						</td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Status</td>
						<td class="td2">
							<select name="status" id="status" required="required" tabindex=3>

								<option value="<?=$status?>"><?=$status?></option>

								<option value="Active">Active</option>

								<option value="Inactive">Inactive</option>


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
						<td class="td1 fs-14 bold req-input">Product Name</td>
						<td class="td2">
							<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$_SESSION[$unique]?>"  />
							<input name="item_name" class="m-0" type="text" id="item_name" value="<?php echo $item_name;?>"  required tabindex=4/>
							<input name="product_nature" required type="hidden" id="product_nature" value="Salable"  class="required m-0" />
						</td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold req-input">Unit Name </td>
						<td class="td2">
						
								<?php

								$a2="select unit_name, unit_name from unit_management where 1 order by id";

								

								$a1=db_query($a2);

								echo "<select name=\"unit_name\" id=\"unit_name\"\" required tabindex=5>";

								echo "<option value=\"\" selected></option>";

								while($a=mysqli_fetch_row($a1))

								{

									if($a[0]==$unit_name)
									{
										echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";
									}
									echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

								}

								echo "</select>";

								?>
						</td>
					</tr>
							
					<tr class="tr">
						<td class="td1 fs-14 bold"> Pack Size</td>
						<td class="td2"><input type="text" class="m-0" name="pack_size" id="pack_size" value="<?=$pack_size?>" tabindex=6/></td>
					</tr>
						
				
				</tbody>
			</table>

		
		
		</div>
		
		
		<div class="w-100 pt-3">
								<? if($_SESSION[$unique]<1){?>

							<input name="record" type="submit" id="record" value="Save" onclick="return checkUserName()" class="btn1 btn1-bg-cancel" tabindex=7/>

						<? }?>


						<? if($_SESSION[$unique]>0){?>

							<input name="modify" type="submit" id="modify" value="Update" class="btn1 btn1-bg-update" tabindex=8/>

						<? }?>

						<input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>?new=2'" value="Clear" tabindex=9/>


		</div>
		
	</div>
	</form>
	
	
	
	
	

<table id="example" class="table1  table-striped table-bordered table-hover table-sm">
                                <caption></caption>
								<thead class="thead1">
								<tr class="bgc-info">
									<th scope="col" scope="col"><span class="style2">Product Code </span></th>
									<th scope="col" scope="col"><span class="style2">Product Name</span></th>
									<th scope="col" scope="col"><span class="style2">Category </span></th>
									<th scope="col" scope="col"><span class="style2">Status</span></th>
									<th scope="col" scope="col">Create By</th>
								</tr>
								</thead>

								<tbody>
								<?php

								 $td="select a.item_id,a.item_name,a.sub_group_id, a.item_description,a.finish_goods_code, a.status, a.entry_by 
								 FROM item_info a where 1 ".$con." order by item_id";

								$report=db_query($td);

								while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0){$cls=' class="alt"';} else {$cls='';}?>

									<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

										<td><?=$rp[4];?></td>

										<td class="text-left"><?=$rp[1];?></td>

										<td class="text-left"><?=$rp[2];?></td>
										<td><?=$rp[5];?></td>
										<td><?=find_a_field('user_activity_management','fname','user_id='.$rp[6]);?></td>
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