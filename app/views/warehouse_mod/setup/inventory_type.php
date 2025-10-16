<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$now=time();
$title='Inventory Type';

$unique='id';
$unique_field='type';
$table='inventory_type';
$page="inventory_type.php";

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

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"><div class="left">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

          <td><table id="grp" class="table table-bordered" cellspacing="0">

            <tr>

              <th>Inventory ID </th>

              <th>Inventory Name Name</th>

            </tr>

            <?php

	 $rrr = "select * from inventory_type order by id desc";
	$report=db_query($rrr);

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
            <tr<?=$cls?> onclick="nav('<?php echo $rp[0];?>');">
              <td><?=$rp[0];?></td>

              <td><?=$rp[1];?></td>

            </tr>

            <?php }?>

          </table>

                </td>

        </tr>

      </table>

    </div></td>    <td valign="top" width="34%" >
	<div class="rights">

      <form id="form1" name="form1" method="post" action="<?=$page?>?<?=$unique?>=<?=$$unique?>">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td><div class="box">

              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr>

                  <td>Inventory Name</td>

                  <td>

				  

<? if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique)?>

<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

				  

				  

				  

				  

				  <input name="type" type="text" id="type" value="<?php echo $type;?>" required class="form-control"/></td>

                </tr>

                

                

              </table>

            </div></td>

          </tr>

          <tr>

            <td>&nbsp;</td>

          </tr>

          <tr>

            <td><div class="box1">

              <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr>

                  <td>

<? if(!isset($_POST[$unique])&&!isset($_GET[$unique])) {?>

<input name="record" type="submit" id="record" value="Record" onclick="return checkUserName()" class="btn btn-primary" />

<? }?>

				  </td>

                  <td>

<? if(isset($_POST[$unique])||isset($_GET[$unique])) {?>

<input name="modify" type="submit" id="modify" value="Modify" class="btn btn-warning" />

<? }?>

</td>

                  <td><input name="clear" type="button" class="btn btn-success" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>

                  <td>

<? if($_SESSION['user']['level']==5){?>

<input class="btn btn-danger" name="delete" type="submit" id="delete" value="Delete"/>

<? }?>

					</td>

                </tr>

              </table>

            </div></td>

          </tr>

        </table>

      </form>

    </div></td>

  </tr>

</table>50

<script type="text/javascript">

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>