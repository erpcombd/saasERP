<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE.'core/init.php';
require_once SERVER_CORE."routing/layout.top.php";

if($_GET['clear']==1){
  unset($_POST);
  echo '<script type="text/javascript">
        window.location.href = "approval_layer_setup.php";
      </script>';
}
if($_GET['id']){
  $sql_update='SELECT * FROM approval_matrix_layer_setup WHERE id ="'.$_GET['id'].'"';
  $query_sql_update = db_query($sql_update);
  $sql_update_data=mysqli_fetch_object($query_sql_update);
  $level_name= $sql_update_data->layer_name;
  $layer_level= $sql_update_data->layer_level;
  $signatory_tittle= $sql_update_data->signatory_tittle;
  $group_for= $sql_update_data->group_for;

}
if($_GET['delete']){
  $sql_delete='DELETE FROM approval_matrix_setup where id="'.$_GET['delete'].'"';
  db_query($sql_delete);
  echo '<script type="text/javascript">
  window.location.href = "approval_layer_setup.php";
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



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud('approval_matrix_layer_setup');



$$unique = $_GET[$unique];



$$unique = $_POST[$unique];

//for Insert..................................

if(isset($_POST['insert']))

{
      
    //  $_POST['PBI_ID']=$_POST['PBI_ID'];
    //  $_POST['user_id']=$_POST['PBI_ID'];
    //  $_POST['level']=$_POST['user_level'];
    //  $_POST['tr_from']=$_POST['tr_from_id'];
    //  $_POST['status']='ACTIVE';

		 $_POST['entry_by'] = $_SESSION['user']['id'];

		 $_POST['entry_at'] = $now=date('Y-m-d H:i:s');

// $proj_id			= $_SESSION['proj_id'];

// $now				= time();

// $entry_by = $_SESSION['user'];



$crud->insert();






$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);
echo '<script type="text/javascript">
        window.location.href = "approval_layer_setup.php?clear=1";
      </script>';

}





//for Modify..................................



if(isset($_POST['update']))

{




  
  $id = $_GET['id'];
  $layer_name = $_POST['layer_name'];
  $layer_level = $_POST['layer_level'];
  $signatory_tittle = $_POST['signatory_tittle'];
  $group_for = $_POST['group_for'];

  $edit_by = $_SESSION['user']['id'];
  $edit_at = date('Y-m-d H:i:s'); // Current timestamp

  // Create the SQL update query
   $sql_update_the_data = "
      UPDATE approval_matrix_layer_setup 
      SET 
          layer_name = '$layer_name', 
          layer_level = '$layer_level', 
          signatory_tittle = '$signatory_tittle',
		  group_for = '$group_for', 
          entry_by = '$edit_by', 
          entry_at = '$edit_at'
      WHERE id = '$id'
  ";
  db_query($sql_update_the_data);





		$type=1;

		$msg='Successfully Updated.';
    echo '<script type="text/javascript">
        window.location.href = "approval_layer_setup.php?clear=1";
      </script>';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

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

<style type="text/css">



</style>



<div class="container-fluid p-0">
  <!-- <div id="alert_bar" class="alert bg-success"></div> -->
    <div class="row">
        <div class="col-sm-7 p-0 pr-2">

            <div class="container n-form1">
                <table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
					<thead>
						<tr class="bgc-info">
			
							
							  <th><span>Layer Name</span></th>
							  <th><span>Layer level</span></th>
							  <th><span>Signatory Name</span></th>
							  <th><span>Company</span></th>

							   <th><span>Edit</span></th>
							   <!-- <th><span>Delete</span></th> -->
						</tr>
					</thead>
					
					<tbody>
					
						<?php
						

						
						
						
						
						
						
        $sql_member_show = "
           SELECT * FROM approval_matrix_layer_setup;
        ";
        $query_member_show = db_query($sql_member_show);
        while($rp=mysqli_fetch_object($query_member_show)){
          
          ?>
						
						<tr>
             <td><?=$rp->layer_name;?></td>
             <td><?=$rp->layer_level;?></td>
             <td><?=$rp->signatory_tittle;?></td>
			 <td><?=$rp->group_for;?></td>

             <td><a href="approval_layer_setup.php?id=<?=$rp->id?>">Edit</a></td>
             <!-- <td><a href="approval_matrix_setup.php?delete=<?//=$rp->id?>">Delete</a></td> -->
						</tr>
						
						<?php }?>
					</tbody>
					</table>
					
					
					
					<div id="pageNavPosition"></div>	
					
				</div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
            
            <form id="form1" name="form1" class="n-form setup-fixed" method="post" action="" enctype="multipart/form-data">
                <h4 align="center" class="n-form-titel1"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Layer Name</label>
                    <div class="col-sm-9 p-0">

                    <input name="layer_name"  type="text" id="layer_name" tabindex="1" value="<?=$level_name?>" >


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">level</label>
                    <div class="col-sm-9 p-0">
                        <input name="layer_level"  type="text" id="layer_level" tabindex="1" value="<?=$layer_level?>" >

                    </div>
                </div>
                <div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Signatory Name</label>
                    <div class="col-sm-9 p-0">
                        <input name="signatory_tittle"  type="text" id="signatory_tittle" tabindex="1" value="<?=$signatory_tittle?>" >

                    </div>
                </div>
				
				
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Company:  </label>
                    <div class="col-sm-9 p-0">

                        <select name="group_for" required id="group_for"  tabindex="7" >

                      		<? foreign_relation('user_group','id','group_name',$group_for,'1');?>
                   		 </select>

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