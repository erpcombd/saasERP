<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Warehouse Information';			// Page Name and Page Title

do_datatable('table_head');

$page="role_create.php";		// PHP File Name



$table='warehouse';		// Database Table Name Mainly related to this page

$unique='warehouse_id';			// Primary Key of this Database table

$shown='warehouse_name';				// For a New or Edit Data a must have data field



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


		$_POST['entry_by']=$_SESSION['user']['id'];

		$_POST['entry_at']=date('Y-m-d h:i:s');
	
$_POST['acc_sub_class']=103;

$cy_id  = find_a_field('ledger_group','max(group_sl)','acc_sub_class='.$_POST['acc_sub_class'])+1;

$_POST['group_sl'] = sprintf("%02d", $cy_id);

$_POST['acc_class'] = find_a_field('acc_sub_class','acc_class','id='.$_POST['acc_sub_class']); 

$_POST['acc_sub_class'] = find_a_field('acc_sub_class','id','id='.$_POST['acc_sub_class']); 

$_POST['group_class'] = find_a_field('acc_class','priority','id='.$_POST['acc_class']); 

$_POST['ledger_group'] = $_POST['acc_sub_class'].''.$_POST['group_sl'];




$_POST['ledger_group_id']=10201;

$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group_id'])+1;

$_POST['ledger_sl'] = sprintf("%05d", $cy_id);


$_POST['cash_ledger'] = $_POST['ledger_group_id'].''.$_POST['ledger_sl'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group_id']); 

$_POST['ledger_name'] = 'Cash - '.$_POST['warehouse_name'];



$crud->insert();

$wh_found = find_a_field('ledger_group','group_id','group_name='.$_POST['warehouse_name']);

if ($wh_found==0) {
   $acc_ins = 'INSERT INTO ledger_group (group_id, group_sl, group_name, group_class, acc_class, acc_sub_class, proj_id, com_id, deletable, group_for, entry_by, entry_at)
  
  VALUES("'.$_POST['ledger_group'].'", "'.$_POST['group_sl'].'", "'.$_POST['warehouse_name'].'", "'.$_POST['group_class'].'", "'.$_POST['acc_class'].'", "'.$_POST['acc_sub_class'].'", "'.$proj_id.'", "0", "1", "'.$_POST['group_for'].'", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';

db_query($acc_ins);
}

$cssh_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);

if ($cssh_gl_found==0) {
   $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)
  
  VALUES("'.$_POST['cash_ledger'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group_id'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$_POST['group_for'].'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';

db_query($acc_ins_led);
}





		
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
			<h4 align="center" class="n-form-titel1">Search Role</h4>


                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company</label>
                        <div class="col-sm-9 p-0">
                             <select name="group_for" required id="group_for" tabindex="7">

                     			 <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                   			 </select>

                        </div>
                    </div>
					<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Roll</label>
                        <div class="col-sm-9 p-0">
                             <select name="roll_id2" required id="roll_id2"  tabindex="7" >
                            <option></option>
                      		<? foreign_relation('roll_master','role_id','role_name',$_POST['roll_id2'],'1');?>
                   		 </select>

                        </div>
                    </div>

                    <div class="n-form-btn-class">
                        <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                        <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />
                    </div>

                </form>
            </div>


            <div class="container n-form1" id="tableShow">
			<?
			 if(isset($_POST['search'])){
			?>
               <table id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
					<thead>
						 <tr class="bgc_info">
            <th>ID</th>
            <th>Roll Name</th>
            <th>Module</th>
            <th>Feature</th>
			<th>Menu</th>
             </tr>
					</thead>
					
					<tbody>
					
					<?php
					
					
					if($_POST['roll_id2']!="")
					
					$con .= 'and r.role_id="'.$_POST['roll_id2'].'"';
					
					
					
					$query = 'select r.role_name,m.module_name,f.feature_name,p.page_name from roll_details s,roll_master r,user_module_manage m, user_feature_manage f,user_page_manage p where r.role_id=s.role_id and s.module_id=m.id and s.feature_id=f.id and s.page_id=p.id '.$con.'';
					
					$report=db_query($query);
					
					while($rp=mysqli_fetch_object($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
					
					<tr <?=$cls?>>
					  <td><?=++$s;?></td>
					  <td><?=$rp->role_name;?></td>
					
					<td><?=$rp->module_name;?></td>
					
					<td><?=$rp->feature_name;?></td>
					<td><?=$rp->page_name;?></td>
					</tr>
					
					<?php }?>
					</tbody>
					</table>
					
					<? }?>

									<div id="pageNavPosition"></div>

            </div>

        </div>


        <div class="col-sm-5  p-0  pl-2">
            
            <form class="n-form  setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
            <h4 align="center" class="n-form-titel1"><?=$title?></h4>
                <span style="color:green;" id="msg"></span>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Roll Name: </label>
                    <div class="col-sm-9 p-0">
                        <select name="roll_id" required id="roll_id"  tabindex="7" >
                            <option></option>
                      		<? foreign_relation('roll_master','role_id','role_name',$roll_id,'1');?>
                   		 </select>
						 
						 <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Module:  </label>
                    <div class="col-sm-9 p-0">

                        <select name="module_id" required id="module_id"  tabindex="7" onchange="getFeature(this.value)">
                            <option></option>
                      		<? foreign_relation('user_module_manage','id','module_name',$module_id,'1');?>
                   		 </select>

                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Feature:  </label>
                    <div class="col-sm-9 p-0" id="showFeature">

                        <select name="feature_id" required id="feature_id"  tabindex="7" onchange="getMenu(this.value)">
						<option></option>

                      		<? foreign_relation('user_feature_manage','id','feature_name',$feature_id,'1');?>
                   		 </select>

                    </div>
                </div>
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Menu:  </label>
                    <div class="col-sm-9 p-0" id="showMenu">

                        <select name="menu_id" required id="menu_id"  tabindex="7" >
						<option></option>

                      		<? foreign_relation('user_page_manage','id','page_name',$menu_id,'1');?>
                   		 </select>

                    </div>
                </div>

               
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Status:  </label>
                    <div class="col-sm-9 p-0">

                       <select name="status" id="status">

                              
                              <option <?=($status=='Active')?'selected':''?> value="Active">Active</option>

                              <option <?=($status=='Inactive')?'selected':''?> value="Inactive">Inactive</option>


                        </select>

                    </div>
                </div>

                <div class="n-form-btn-class">
                     <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="button" id="insert" value="SAVE" class="btn1 btn1-bg-submit" onclick="save_role()" />
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


function getFeature(module_id){
getData2('getFeature_ajax.php','showFeature',module_id,module_id);
}

function getMenu(feature_id){
getData2('getMenu_ajax.php','showMenu',feature_id,feature_id);
}


function save_role() {

    var role_id = document.getElementById('roll_id').value*1;
	var module_id = document.getElementById('module_id').value*1;
	var feature_id = document.getElementById('feature_id').value*1;
	var menu_id = document.getElementById('menu_id').value*1;
	var status = document.getElementById('status').value;
    $.ajax({
      url: 'save_role_ajax.php',
      type: 'POST',
      data: {
        role_id : role_id,
		module_id: module_id,
		feature_id: feature_id,
		page_id: menu_id,
		status: status
		
      },
      success: function(response) {
      
        var res = JSON.parse(response);
		document.getElementById("tableShow").innerHTML = res['tableShow'];
      },
      error: function(xhr, status, error) {
        
        console.error(error);
      }
    });
  }
</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>