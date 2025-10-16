<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

if($_GET['clear']==1){
  unset($_POST);
  echo '<script type="text/javascript">
        window.location.href = "approval_matrix_setup.php";
      </script>';
}
if($_GET['id']){
  $sql_update='SELECT * FROM approval_matrix_setup WHERE id ="'.$_GET['id'].'"';
  $query_sql_update = db_query($sql_update);
  $sql_update_data=mysqli_fetch_object($query_sql_update);
  $member_id= $sql_update_data->user_id;
  $member_level= $sql_update_data->level;
  $member_tr_from= $sql_update_data->tr_from;
  $member_status= $sql_update_data->status;
  $member_approval_name= $sql_update_data->approval_name;
}
if($_GET['delete']){
  $sql_delete='DELETE FROM approval_matrix_setup where id="'.$_GET['delete'].'"';
  db_query($sql_delete);
  echo '<script type="text/javascript">
  window.location.href = "approval_matrix_setup.php";
</script>';
;
}

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

// ::::: Edit This Section ::::: 

$title='Company Concerns ';			// Page Name and Page Title
do_datatable('table_head');
$page="user_group.php";		// PHP File Name

$table='user_group';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='group_name';				// For a New or Edit Data a must have data field
// ::::: End Edit Section :::::




$crud      =new crud('approval_matrix_setup');


//for Insert..................................
if(isset($_POST['insert'])){
      
      

		 $_POST['entry_by'] = $_SESSION['user']['id'];

		 $_POST['entry_at'] = $now=date('Y-m-d H:i:s');


$crud->insert();

$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
// unset($$unique);
echo '<script type="text/javascript">
        window.location.href = "approval_matrix_setup.php?clear=1";
      </script>';
}





//for Modify..................................
if(isset($_POST['update'])){
  $id = $_GET['id'];
  $PBI_ID = $_POST['PBI_ID'];
  $user_id = $_POST['PBI_ID'];
  $level = $_POST['user_level'];
  $tr_from = $_POST['tr_from_id'];
  $status = $_POST['status'];
  $edit_by = $_SESSION['user']['id'];
  $approval_name =$_POST['approval_name'];
  $edit_at = date('Y-m-d H:i:s'); // Current timestamp

  // Create the SQL update query
  $sql_update_the_data = "
      UPDATE approval_matrix_setup 
      SET 
          PBI_ID = '$PBI_ID', 
          user_id = '$user_id', 
          level = '$level', 
          tr_from = '$tr_from', 
          status = '$status', 
          edit_by = '$edit_by', 
          edit_at = '$edit_at',
          approval_name = '$approval_name'
      WHERE id = '$id'
  ";
  db_query($sql_update_the_data);





		$type=1;

		$msg='Successfully Updated.';
    echo '<script type="text/javascript">
        window.location.href = "approval_matrix_setup.php?clear=1";
      </script>';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}







{



$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}



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

<style type="text/css">



</style>



<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-7 p-0 pr-2">

            <div class="container n-form1">
                <table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm">
					<thead>
						<tr class="bgc-info">
							  <th><span> ID</span></th>
							
							  <th><span>Member Name</span></th>
							  <th><span>level</span></th>
							   <th><span>Tr From</span></th>
                 <th><span>Status</span></th>
							   <th><span>Edit</span></th>
						</tr>
					</thead>
					
					<tbody>
					
						<?php
						

						
						
						
						
						
						
        $sql_member_show = "
           SELECT a.approval_name, a.id, u.user_id, u.fname, a.level,a.status,a.tr_from FROM approval_matrix_setup a JOIN user_activity_management u ON a.user_id = u.user_id;
        ";
        $query_member_show = db_query($sql_member_show);
        while($rp=mysqli_fetch_object($query_member_show)){
          
          ?>
						
						<tr>
             <td><?=$rp->user_id;?></td>
             <td><?=$rp->fname;?></td>
             <td><?=$rp->level;?></td>
             <td><?=$rp->tr_from;?></td>
             <td><?=$rp->status;?></td>
             <td><a href="approval_matrix_setup.php?id=<?=$rp->id?>">Edit</a></td>
						</tr>
						
						<?php }?>
					</tbody>
					</table>
					
					
					
					<div id="pageNavPosition"></div>	
					
				</div>

        </div>


        <div class="col-sm-5 p-0 pl-2">
            
            <form id="form1" name="form1" class="n-form setup-fixed" method="post" action="" enctype="multipart/form-data">
                <h4 class="n-form-titel1 text-center"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Member</label>
                    <div class="col-sm-9 p-0">
                    <?php
                  $sql_member = 'SELECT user_id,fname from user_activity_management;';
                  $query_member = db_query($sql_member);
                  ?>
                  <select name="PBI_ID" id="PBI_ID" class="form-control selectpicker p-0" required data-live-search="true" tabindex="-98">
                      <?php while ($row1 = mysqli_fetch_object($query_member)) { ?>
                        
                        <option 
                          value="<?= $row1->user_id ?>" 
                          <?= ($row1->user_id == $member_id) ? 'selected' : '' ?>>
                          <?= $row1->user_id ?> - <?= $row1->fname ?>
                      </option>                      <?php } ?>
                  </select>	


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Status</label>
                    <div class="col-sm-9 p-0">
                    <select name="status" id="status">
                        <option   <?= ($member_status == 'ACTIVE') ? 'selected' : '' ?> value="ACTIVE">ACTIVE</option>
                        <option   <?= ($member_status == 'INACTIVE') ? 'selected' : '' ?> value="INACTIVE">INACTIVE</option>
                   </select>
                      </div>
                      </div>

                  <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Level</label>
                    <div class="col-sm-9 p-0">
                    <?php
                  $sql_member = 'SELECT layer_level,layer_name from approval_matrix_layer_setup;';
                  $query_member = db_query($sql_member);
                  ?>
                  <select name="user_level" id="user_level" class="form-control selectpicker p-0" required data-live-search="true" tabindex="-98">
                      <?php while ($row1 = mysqli_fetch_object($query_member)) { ?>
                        
                        <option 
                          value="<?= $row1->layer_level ?>" 
                          <?= ($row1->layer_level == $member_level) ? 'selected' : '' ?>>
                          <?= $row1->layer_level ?> - <?= $row1->layer_name ?>
                      </option>                      <?php } ?>
                  </select>	


                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Tr From</label>
                    <div class="col-sm-9 p-0">
                    <?php
                  $sql_tr_from = 'SELECT tr_id,name from approval_matrix_trfrom;';
                  $query_tr_from = db_query($sql_tr_from);
                  ?>
                  <select name="tr_from_id" id="tr_from_id" class="form-control selectpicker p-0" required data-live-search="true" tabindex="-98">
                      <?php while ($row1 = mysqli_fetch_object($query_tr_from)) { ?>
                          <option 
                          value="<?= $row1->name ?>" 
                          <?= ($row1->name == $member_tr_from) ? 'selected' : '' ?>>
                          <?= $row1->name ?>
                      </option>
                      <?php } ?>
                  </select>	


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Approval Name</label>
                    <div class="col-sm-9 p-0">
                        <input name="approval_name"  type="text" id="approval_name" value="<?=$member_approval_name?>" >

                    </div>
                </div>




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




<script type="text/javascript">

    var pager = new Pager('grp', 10000);

    pager.init();

    pager.showPageNav('pager', 'pageNavPosition');

    pager.showPage(1);

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