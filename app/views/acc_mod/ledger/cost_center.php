<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Cost Center';			// Page Name and Page Title

do_datatable('table_head');

$page="cost_center.php";		// PHP File Name



$table='cost_center';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='center_name';				// For a New or Edit Data a must have data field



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

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();

		$id = $_POST['dealer_code'];
		
		if($_FILES['cr_upload']['tmp_name']!=''){ 
		$file_temp = $_FILES['cr_upload']['tmp_name'];
		$folder = "../../images/cr_pic/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}


		
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

}





//for Modify..................................



if(isset($_POST['update']))

{


		$_POST['edit_by'] = $_SESSION['user']['id'];
		 
		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');


		$crud->update($unique);

		$id = $_POST['dealer_code'];



		if($_FILES['cr_upload']['tmp_name']!=''){ 
		$file_temp = $_FILES['cr_upload']['tmp_name'];
		$folder = "../../images/cr_pic/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}


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

foreach ($data as $key => $value)

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

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

<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-7 p-0 pr-2">
            <div class="container p-0">
			<form id="form1" name="form1" class="n-form1 pt-0" method="post" action="">
			<h4 align="center" class="n-form-titel1">Search Cost Center</h4>
	


                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company:</label>
                        <div class="col-sm-9 p-0">

						<select name="group_for" required id="group_for" style="float:left;" tabindex="7">
                      <? foreign_relation('user_group','id','group_name',$group_for,'id="'.$_SESSION['user']['group'].'"');?>
                    </select>

                        </div>
                    </div>
					
					<!--<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Warehouse Name:</label>
                        <div class="col-sm-9 p-0">
                             	<input name="warehouse_name" type="text" id="warehouse_name" style="width:250px; float:left;" value="<?php echo $_POST['warehouse_name']; ?>" />
                        </div>
                    </div>-->
					
					
					

                    <div class="n-form-btn-class">										  
                        <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show">
                        <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear">
                    </div>

                </form>
            </div>


            <div class="container n-form1">
			
			
				<table id="table_head" class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th> ID</th>
					<th> Cost Center</th>
					<th> Cost Category</th>
					<th> Warehouse</th>
					<th> Company</th>
					
				</tr>
				</thead>

				<tbody class="tbody1">
				

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';





 $td='select a.'.$unique.',  a.'.$shown.', u.group_name, c.category_name,w.warehouse_name from '.$table.' a left join warehouse w on a.warehouse_id=w.warehouse_id, cost_category c, user_group u  	where   a.category_id=c.id  and a.group_for="'.$_SESSION['user']['group'].'" and a.group_for=u.id    '.$con.' order by a.id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td align="left"><?=$rp[1];?></td>

<td align="left"><?=$rp[3];?></td>
<td align="left"><?=$rp[4];?></td>
<td align="left"><?=$rp[2];?></td>
</tr>

<?php }?>
				
				
				</tbody>
				</table>
                
				
				<div id="pageNavPosition"></div>

            </div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
            <form class="n-form setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
					<? if(!isset($_GET[$unique])){?>
						<h4 align="center" class="n-form-titel1">Create Cost Center</h4>
					<? }?>
					<? if(isset($_GET[$unique])){?>
						<h4 align="center" class="n-form-titel1">Update Cost Center</h4>
					<? }?>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="req-input col-sm-4 pl-0 pr-0 col-form-label "> Cost Center:</label>
                    <div class="col-sm-8 p-0">
						<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                       <input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>
                       <input name="center_name" required type="text" id="center_name" tabindex="1" value="<?=$center_name?>"  style="width:220px;" >	
													
                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-4 pl-0 pr-0 col-form-label">Cost Category: </label>
                    <div class="col-sm-8 p-0">
										
					<select name="category_id" required id="category_id"  tabindex="7" >
                          <option></option>
                      <? foreign_relation('cost_category','id','category_name',$category_id,'group_for="'.$_SESSION['user']['group'].'"');?>
                    </select>

                    </div>
                </div>
				
				
				<div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-4 pl-0 pr-0 col-form-label">Warehouse:</label>
                    <div class="col-sm-8 p-0">
										
					<select name="warehouse_id" required id="warehouse_id"  tabindex="7" >
                        <option></option>
                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'group_for="'.$_SESSION['user']['group'].'"');?>
                    </select>

                    </div>
                </div>
				
				
				
                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-4 pl-0 pr-0 col-form-label">Company: </label>
                    <div class="col-sm-8 p-0">
					<select name="group_for" required id="group_for"  tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'id="'.$_SESSION['user']['group'].'"');?>
                    </select>
                    </div>
                </div>






                <!--<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Status  </label>
                    <div class="col-sm-9 p-0">
					<select name="status" id="status"  style="width:250px;">

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="Active">Active</option>

                                          <option value="Inactive">Inactive</option>


                                        </select>

                    </div>
                </div>-->

                <div class="n-form-btn-class">

                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }?>

                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
                      <? }?>

                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />
          
					
					
					
			

                </div>


            </form>

        </div>

    </div>




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