<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//create_combobox('sub_group_id');


// ::::: Edit This Section ::::: 



$title='Factory Overhead Ledger';			// Page Name and Page Title

do_datatable('table_head');

$page="factory_overhead_ledger.php";		// PHP File Name

$table='accounts_ledger';		// Database Table Name Mainly related to this page

$unique='ledger_id';			// Primary Key of this Database table

$shown='ledger_name';				// For a New or Edit Data a must have data field

$config_ledger=find_all_field('config_group_class','*','group_for="'.$_SESSION['user']['group'].'"');

//$batch_all=find_all_field('batch_master','*','batch_no="'.$batch_no.'"');

echo $config_ledger->factory_overhead;

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


		$_POST['entry_by'] = $_SESSION['user']['id'];
		 
		 $_POST['entry_at'] = $now=date('Y-m-d H:i:s');


$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%04d", $cy_id);

$grp_data = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$_POST['acc_class'] =$grp_data->acc_class;

$_POST['acc_sub_class'] =$grp_data->acc_sub_class;

$_POST['acc_sub_sub_class'] =$grp_data->acc_sub_sub_class;

// $_POST['ledger_id'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];



$crud->insert();

		
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

            <div class="container n-form1">
			<table id="table_head" class="table1  table-striped table-bordered table-hover table-sm">
				<thead class="thead1">
				<tr class="bgc-info">
					<th>GL Code</th>
					<th>GL  Group</th>
					<th>General Ledger</th>
				</tr>
				</thead>

				<tbody class="tbody1">

<?php


if($_POST['group_for']!="")

$con .= 'and a.group_for="'.$_POST['group_for'].'"';



if($_POST['warehouse_name']!="")

$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';



 $td='select a.'.$unique.',  a.'.$shown.', a.acc_class, a.acc_sub_class,  a.ledger_group_id, a.acc_sub_sub_class from '.$table.' a where ledger_group_id="'.$config_ledger->factory_overhead.'"  '.$con.' order by a.ledger_id  ';

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
  <td><?=$rp[0];?></td>

<td align="left"><?=find_a_field('ledger_group','group_name','group_id='.$rp[4]);?></td>
<td align="left"><?=$rp[1];?></td>
</tr>

<?php }?>
				</tbody>
			</table>
                <div id="pageNavPosition"></div>
				
				

            </div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
		<form class="n-form setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
			
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-4 pl-0 pr-0 col-form-label "> General Ledger: </label>
                    <div class="col-sm-8 p-0">
						
																
										<input name="ledger_id" required type="hidden" id="ledger_id" tabindex="1" value="<?=$ledger_id?>"  style="width:220px;" >	
										<input name="balance_type" required type="hidden" id="balance_type" tabindex="1" value="Both"  style="width:220px;" >
									
                        				<input name="ledger_name" required type="text" id="ledger_name" tabindex="1" value="<?=$ledger_name?>"  style="width:220px;" >	
										
										
						
                    </div>
                </div>
				


      
                
				

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-4 pl-0 pr-0 col-form-label "> GL Group: </label>
                    <div class="col-sm-8 p-0">
																<span id="acc_group">
										<select name="ledger_group_id" required id="ledger_group_id"  tabindex="2">
										
                      						<? foreign_relation('ledger_group','group_id','CONCAT(group_id, ": ", group_name)',$ledger_group_id,'group_id="'.$config_ledger->factory_overhead.'"');?>
                    					</select></span>
                    </div>
                </div>
				

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-4 pl-0 pr-0 col-form-label "> Company: </label>
                    <div class="col-sm-8 p-0">
					<select name="group_for" required id="group_for"  tabindex="7">

                     <? user_company_access($group_for); ?>
                    </select>
                    </div>
                </div>
				





				
				<!--<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="req-input col-sm-4 pl-0 pr-0 col-form-label "> Status: </label>
                    <div class="col-sm-8 p-0">
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