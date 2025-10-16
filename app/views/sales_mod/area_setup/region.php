<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 



$title='Add Region Information';			// Page Name and Page Title

$page="region.php";		// PHP File Name



$table='branch';		// Database Table Name Mainly related to this page

$unique='BRANCH_ID';			// Primary Key of this Database table

$shown='BRANCH_NAME';				// For a New or Edit Data a must have data field

$tr_type="show";

$tr_from="Sales";

// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();
$tr_type="Add";
$id = $_POST['dealer_code'];
		
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

$id = $_POST['dealer_code'];
		




		$type=1;

		$msg='Successfully Updated.';
		
		$tr_type="Add";

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

if(!isset($$unique)){ $$unique=db_last_insert_id($table,$unique);}

?>
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>






<div class="container-fluid">
    <div class="row">
        <div class="col-sm-7">
            


            <div class="container n-form1">
                <table class="table table-sm"  style="border:0; border-collapse:collapse; padding:0;">

            <tr>
              <td>
                  <? 	$res='select '.$unique.','.$unique.' as REGION_CODE,'.$shown.' as REGION_NAME  from '.$table;

											echo $crud->link_report($res,$link);?>

                </td>
            </tr>
          </table>

            </div>

        </div>


        <div class="col-sm-5">
            <form id="form1" name="form1" class="n-form" method="post" action="" enctype="multipart/form-data">
                <h4  style="text-align:center;" class="n-form-titel1 text-uppercase"> <?=$title?></h4>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Region Code:</label>
                    <div class="col-sm-9 p-0">
                       <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text"  readonly/>


                    </div>
                </div>

                <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Region Name: </label>
                    <div class="col-sm-9 p-0">
                        <input name="BRANCH_NAME" type="text" id="BRANCH_NAME" tabindex="2" value="<?=$BRANCH_NAME?>">

                    </div>
                </div>

                   <div class="form-group row m-0 pl-3 pr-3 p-1">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Under Division: </label>
                    <div class="col-sm-9 p-0">

                        <select id="div_id" name="div_id">
						<option></option>
                         <?php foreign_relation('division', 'division_CODE', 'division_name', $div_id); ?>
					    </select>

                    </div>
                </div>
				
				
				<div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">CO-Ordinator Name:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

              <select name="U_ID" id="U_ID" >
								<option></option>
								<?

								foreign_relation('user_activity_management','user_id','username',$U_ID,'1');

								?>
					</select>


            </div>

          </div>
				
				
				

                <div class="n-form-btn-class">
                    <? if(!isset($_GET[$unique])){?>
                        <input name="insert" type="submit" id="insert" value="Save" class="btn1 btn1-bg-submit" />
                        <? }?>
                      
                    
                        <? if(isset($_GET[$unique])){?>
                        <input name="update" type="submit" id="update" value="Update" class="btn1 btn1-bg-update" />
                        <? }?>
                      
                      <input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                      

                </div>


            </form>

        </div>

    </div>

</div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
