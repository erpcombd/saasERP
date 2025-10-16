<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$now=time();
$title='Unit Manage';
$active='unit';
$unique='id';
$unique_field='unit_name';
$table='unit_management';
$page="unit_management_add.php";

$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$unique_field]))
{
$$unique = $_POST[$unique];
//for Record..................................

if(isset($_POST['record']))

{		
$_POST['entry_at']=time();
$_POST['entry_by']=$_SESSION['user']['id'];
$crud->insert();

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['modify']))

{
$_POST['edit_at']=time();
$_POST['edit_by']=$_SESSION['user']['id'];
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

<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
<thead>
            <tr>

              <th>Unit ID </th>

              <th>Unit Name</th>

              <th>Detail</th>

            </tr>
</thead><tbody>
            <?php

	$rrr = "select * from unit_management order by id desc";
	$report=db_query($rrr);

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
            <tr<?=$cls?> onclick="nav('<?php echo $rp[0];?>');">
              <td><?=$rp[0];?></td>

              <td><?=$rp[1];?></td>

              <td><?=$rp[2];?></td>

            </tr>

            <?php }?>
</tbody>
          </table>

      



<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout2.php");

?>