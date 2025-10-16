<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



// ::::: Edit This Section ::::: 

do_calander('#from_date');
do_calander('#to_date');

$title='Add Sales Target';			// Page Name and Page Title

$page="sales_target_setup.php";		// PHP File Name



$table='sales_target';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='id';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id	= $_SESSION['proj_id'];

$now			= time();

$entry_by = $_SESSION['user']['id'];



$crud->insert();

$id = $_POST['id'];

// insert task master

   $sql_insert = 'INSERT INTO `task_assign_master`(`task_date`, `schedule_date`, `task_title`, `description`,
  `assign_person`, `priority`, `entry_by`, `entry_at` ,  `st_id`, project)
  
   VALUES ("'.$_POST['from_date'].'","'.$_POST['to_date'].'","'.$_POST['details'].'"," Target Amount is : '.$_POST['target_amount'].'",
   "'.$_POST['sales_person'].'","1","'.$entry_by.'","'.$now.'","'.$id.'", "7")';

   db_query($sql_insert);

//end insert task master
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{
    $_POST['updated_by'] = $_SESSION['user']['id'];
    $_POST['updated_at'] = time();

		$crud->update($unique);

		$id = $_POST['id'];
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
<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<div class="form-container_large">
<div class="row">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td valign="top"><div class="left">
          <table width="95%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div class="tabledesign " style="height:787px;">
                  <? 	$res='select t.id,t.id, p.PBI_NAME, t.from_date, t.to_date, t.target_amount, t.details as remarks
                     from personnel_basic_info p, sales_target t
                     where p.PBI_ID=t.sales_person';
											echo $crud->link_report($res,$link);?>
                </div>
                 </td>
            </tr>
          </table>
        </div></td>
      <td valign="top"><form action="" method="post"  enctype="multipart/form-data" >
          <table width="95%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>
                <div class="card" style="padding:3%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2"><fieldset style="width:362px;">
                      <legend>
                      <?=$title?>
                      </legend>
                      <div class="buttonrow"></div>
                      <div>
                        <label> ID:</label>
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text" class="form-control"  readonly/>
                      </div>
                      <div>
                        <label> Sales Person Name:</label>
                        <select class="form-control" name="sales_person" id="sales_person" >
						<option></option>
						<? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$sales_person,' 1 ORDER BY PBI_NAME ASC');?>
						</select>
                      </div>
                      <div></div>
					  <div>
                        <label>From Date: </label>
						<input type="text" id="from_date" class="form-control" value="<?=$from_date?>" name="from_date" />
                      </div>
					  <div>
                        <label>To Date: </label>
						<input type="text" id="to_date" class="form-control" value="<?=$to_date?>" name="to_date" />
                      </div>
					    <div>
                  <label>Target Amount: </label>
						      <input type="text" id="target_amount" class="form-control" value="<?=$target_amount?>" name="target_amount" />
              </div>

              <div>
                <label>Remarks: </label>
                <textarea type="text" id="details" class="form-control" value="" name="details"><?=$details?></textarea>
              </div>

                      </fieldset></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td><table style="margin-top:10px" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="button">
                        <? if(!isset($_GET[$unique])){?>
                        <input name="insert"  type="submit" id="insert" value="Save" class="btn btn-success" />
                        <? }?>
                      </div></td>
                    <td><div class="button">
                        <? if(isset($_GET[$unique])){?>
                        <input name="update" type="submit" id="update" value="Update" class="btn btn-danger" />
                        <? }?>
                      </div></td>
                    <td><div class="button">
                        <input name="reset" type="button" class="btn btn-info" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                      </div></td>
                    <td><!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->
                    </td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </form></td>
    </tr>
    </div>
  </table>
  
</div>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>
