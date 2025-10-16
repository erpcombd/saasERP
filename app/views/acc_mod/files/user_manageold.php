<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$now=time();
$title='User Manage';
$unique='user_id';
$unique_field='username';
$table='user_activity_management';
$page="user_manage_add.php";
do_calander('#expire_date');
$active='usmanag';
$crud      =new crud($table);

$$unique = $_GET[$unique];

if(isset($_POST[$unique_field]))
{
$$unique = $_POST[$unique];

//for Record..................................

if(isset($_POST['record']))
{		
$crud->insert();
$type=1;
$msg='New Entry Successfully Inserted.';
unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['modify']))
{
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
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
?>
<script type="text/javascript">
function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}
</script>
<style>
.custombox{
margin-left:-58px;
	width:450px;
	}
</style>

      <table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
	  <thead>
            <tr>
              <th>User </th>
              <th>User Name</th>
              <th>Designation</th>
            </tr>
			</thead>
			<tbody>
            <?php
	$rrr = "select * from user_activity_management order by user_id";
	$report=db_query($rrr);

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
            <tr<?=$cls?> onclick="nav('<?php echo $rp[0];?>');">
              <td><nobr>
                <?=$rp[1];?>
              </nobr></td>
              <td><?=$rp[4];?></td>
              <td><?=$rp[8];?></td>
            </tr>
            <?php }?>
         
		 </tbody> </table>
              
      
    
   


<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout2.php");
?>