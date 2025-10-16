<?php

//

//

require "../../support/inc.all.php";



do_calander("#start_date");

do_calander("#end_date");


// ::::: Edit This Section ::::: 



$title='Commission Rate Setup';			// Page Name and Page Title

$page="commission_setup.php";		// PHP File Name



$table='commission_rate';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='commission_year';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::





$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];

$year = find_all_field('commission_year','','id='.$_POST['commission_year']);

$item_group = find_all_field('item_group','','group_id='.$_POST['group_id']);

$_POST['start_date'] = $year->start_date;
$_POST['end_date'] = $year->end_date;
$_POST['group_for'] = $item_group->group_for;

if ($_POST['sub_group_id']<1) {

$sub_sql = "select sub_group_id from item_sub_group where group_id='".$_POST['group_id']."' ORDER by group_id,sub_group_sl";

$sub_query = db_query($sub_sql);	

		while($sub_data=mysqli_fetch_object($sub_query))

		{
		
			$ins_sub_sql = "INSERT INTO `commission_rate` 
 (`commission_year`, `sale_type`, `group_for`, `group_id`, `sub_group_id`, `minimum_qty`, `maximum_qty`, `commission_rate`, `start_date`, `end_date`, `entry_by`, `entry_at`) VALUES
('".$_POST['commission_year']."', '".$_POST['sale_type']."', '".$_POST['group_for']."', '".$_POST['group_id']."', '".$sub_data->sub_group_id."', 
 '".$_POST['minimum_qty']."',  '".$_POST['maximum_qty']."', '".$_POST['commission_rate']."' , '".$_POST['start_date']."' , 
'".$_POST['end_date']."' ,  '".$_SESSION['user']['id']."' ,  '".$now=date('Y-m-d H:i:s')."'  )";

db_query($ins_sub_sql);
		
		}


}

if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];



$_POST['entry_by'] = $_SESSION['user']['id'];
		 
$_POST['entry_at'] = $now=date('Y-m-d H:i:s');





$crud->insert();

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
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td valign="top"><div class="left">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><div class="tabledesign" style="height:787px;">
                  <? 	$res='select a.'.$unique.', a.'.$unique.' as ID, b.commission_year as year, g.group_name as item_group,  a.sale_type as sales_type, a.minimum_qty as minimum, a.maximum_qty as maximum, a.commission_rate as Rate 
				   from '.$table.' a, commission_year b, item_group g
				   where b.id=a.commission_year and a.group_id=g.group_id ';

											echo $crud->link_report($res,$link);?>
                </div>
                <?=paging(50);?></td>
            </tr>
          </table>
        </div></td>
      <td valign="top"><form action="" method="post"  enctype="multipart/form-data" >
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2"><fieldset>
                      <legend>
                      <?=$title?>
                      </legend>
                      <div class="buttonrow"></div>
                      <div>
                        <label> ID:</label>
                        <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="text"  readonly/>
                      </div>
					   <div>
                        <label>Year:</label>
						<select id="commission_year" name="commission_year" required>
						<option></option>
                         <?php foreign_relation('commission_year', 'id', 'commission_year', $commission_year,'status="Active"'); ?>
						 </select>
                      </div>
					  
					  <div>
                        <label>Sales Type:</label>
						<select id="sale_type" name="sale_type" required>
						<option></option>
                         <?php foreign_relation('sale_type', 'sale_type', 'sale_type', $sale_type,'1'); ?>
						 </select>
                      </div>
                      
					  <div>
                        <label>Item Group:</label>
						<select id="group_id" name="group_id" required >
						<option></option>
                           <? foreign_relation('item_group','group_id','group_name',$group_id, 'product_type="Finish Goods"');?>
						 </select>
                      </div>
					  
					  
					  
					  <div>
                        <label> Minimum Qty:</label>
                        <input name="minimum_qty" type="text" id="minimum_qty" tabindex="2" value="<?=$minimum_qty?>" required>
                      </div>
					  
					  <div>
                        <label> Maximum Qty:</label>
                        <input name="maximum_qty" type="text" id="maximum_qty" tabindex="2" value="<?=$maximum_qty?>" required>
                      </div>
	
					  <div>
                        <label> Commission Rate:</label>
                        <input name="commission_rate" type="text" id="commission_rate" tabindex="2" value="<?=$commission_rate?>" required>
                      </div>
					  
					  
					  
                     
                      </fieldset></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div class="button">
                        <? if(!isset($_GET[$unique])){?>
                        <input name="insert" type="submit" id="insert" value="Save" class="btn" />
                        <? }?>
                      </div></td>
                    <td><div class="button">
                        <? if(isset($_GET[$unique])){?>
                        <input name="update" type="submit" id="update" value="Update" class="btn" />
                        <? }?>
                      </div></td>
                    <td><div class="button">
                        <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                      </div></td>
                    <td>
                    </td>
                  </tr>
                </table></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>
</div>
<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>
