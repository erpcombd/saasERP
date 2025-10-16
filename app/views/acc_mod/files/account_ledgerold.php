<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Account Ledger';

$page="account_ledger_add.php";

$proj_id=$_SESSION['proj_id'];

$active='acledg';

?>



<script type="text/javascript">







function Do_Nav()



{



	var URL = 'pop_ledger_selecting_list.php';



	popUp(URL);



}







function DoNav(theUrl)



{



	document.location.href = 'account_ledger_add.php?ledger_id='+theUrl;



}



function popUp(URL) 



{



	day = new Date();



	id = day.getTime();



	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");



}



</script>



<?

$now=time();

$separator	= $_SESSION['separator'];

if(isset($_REQUEST['ledger_name'])||isset($_REQUEST['ledger_id']))

{

	//common part.............

	

	$ledger_id			= mysqli_real_escape_string($_REQUEST['ledger_id']);

	$ledger_name 		= mysqli_real_escape_string($_REQUEST['ledger_name']);

	$ledger_name		= str_replace("'","",$ledger_name);

	$ledger_name		= str_replace("&","",$ledger_name);

	$ledger_name		= str_replace('"','',$ledger_name);

	$ledger_group_id	= mysqli_real_escape_string($_REQUEST['ledger_group_id']);

	$opening_balance	= mysqli_real_escape_string($_REQUEST['balance']);

	$balance_type		= mysqli_real_escape_string($_REQUEST['b_type']);

	$depreciation_rate	= mysqli_real_escape_string($_REQUEST['d_rate']);

	$credit_limit		= mysqli_real_escape_string($_REQUEST['cr_limit']);

	$date				= mysqli_real_escape_string($_REQUEST['open_date']);

	$now				= date_value($date);

	$budget_enable		= mysqli_real_escape_string($_REQUEST['budget_enable']);

	//end 

	if(isset($_POST['nledger']))

	{

		

	if(!ledger_redundancy($ledger_name))

	{

	$type=0;

	$msg='Given Name('.$ledger_name.') is already exists.';

	}

	else

	{

	$ledger_id=next_ledger_id($ledger_group_id);

		if(ledger_create($ledger_id,$ledger_name,$ledger_group_id,$opening_balance,$balance_type,$depreciation_rate,$credit_limit, $now,$proj_id,$budget_enable))

		{

		$type=1;

		$msg='New Entry Successfully Inserted.';

		}

	}

}





//for Modify..................................



if(isset($_POST['mledger']))

{

if(ledger_redundancy($ledger_name,$ledger_id))

{

$sql="UPDATE `accounts_ledger` SET 

		`ledger_name` 		= '$ledger_name',

		`opening_balance` 	= '$opening_balance',

		`ledger_group_id`	= '$ledger_group_id',

		`balance_type` 		= '$balance_type',

		`depreciation_rate` = '$depreciation_rate',

		`credit_limit` 		= '$credit_limit',

		`budget_enable`		= '$budget_enable',

		`opening_balance_on`= '$now'

	WHERE `ledger_id` 		= '$ledger_id' LIMIT 1";



		if(db_query($sql))

		{

		$type=1;

		$msg='Successfully Updated.';

		}

	}

	else

	{

	$type=0;

	$msg='Given Name('.$ledger_name.') is already exists.';

	}

}



//for Delete..................................



if(isset($_POST['dledger']))

{

$ledger_id = $_REQUEST['ledger_id'];

$sql="delete from `accounts_ledger` where `ledger_id`='$ledger_id' limit 1";

$query=db_query($sql);

		$type=1;

		$msg='Successfully Deleted.';

}





$ddd="select * from accounts_ledger where ledger_id='$ledger_id'";

$dddd=db_query($ddd);

if(mysqli_num_rows($dddd)>0)

$data = mysqli_fetch_row($dddd);

}

?>











							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box">

									<form id="form1" name="form1" method="post" action="">

									<table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="40%" align="right">Ledger Name : </td>

                                        <td width="60%" align="right" ><input name="ladger_name" style="max-width:250px;" class="form-control" type="text" id="ladger_name" value="<?=$_REQUEST['ladger_name']; ?>" /></td>

                                      </tr>

                                      <tr>

                                        <td align="right">Ledger Group :                                         </td>

                                        <td align="right">

										<select name="ladger_group" id="ladger_group" style="max-width:250px;" class="form-control">

<? 

if($_SESSION['user']['group']>1)

$sql="SELECT group_id ,group_name FROM ledger_group where group_for=".$_SESSION['user']['group']." order by group_id";

else

$sql="SELECT group_id ,group_name FROM ledger_group order by group_id";

$led=db_query($sql);

if(mysqli_num_rows($led) > 0)

{

while($ledg = mysqli_fetch_row($led)){?>

<option value="<?=$ledg[0]?>" <?php if($data[2]==$ledg[0]) echo " Selected "?>><?=$ledg[0].':'.$ledg[1]?></option>

<? }}?>									</select>

		</td>

                                      </tr>

                                      <tr>

                                        <td colspan="2" class="text-center"><input class="btn" name="search" type="submit" id="search" value="Show" /></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td>&nbsp;</td>

								  </tr>

								  <tr class="table table-bordered">

									<td>

									<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
									<thead>

							  <tr>

								<th>A/c Code</th>

								<th>Ledger Name</th>

								<th>Ledger Group</th>

							  </tr>
							  </thead>
							  <tbody>

<?php

if($_SESSION['user']['group']>1)

$rrr = "select l.ledger_id, l.ledger_name, g.group_name from accounts_ledger l, ledger_group g WHERE l.ledger_id like '%00000000' and  l.ledger_group_id=g.group_id and l.group_for= ".$_SESSION['user']['group'];

else

$rrr = "select l.ledger_id, l.ledger_name, g.group_name from accounts_ledger l, ledger_group g WHERE l.ledger_id like '%00000000' and  l.ledger_group_id=g.group_id ";

	

	if(isset($_REQUEST['search']))

	{

		$ladger_group	= mysqli_real_escape_string($_REQUEST['ladger_group']);

		$ladger_name	= mysqli_real_escape_string($_REQUEST['ladger_name']);

		

		$rrr .= " AND (l.ledger_name LIKE '$ladger_name' or g.group_name LIKE '%$ladger_group%')";

				

	} 

	$rrr .= " order by ledger_name";

	$report=db_query($rrr);

	//echo $rrr;

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

							    <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

								<td><nobr><?=add_separator($rp[0],$separator);?></nobr></td>

								<td><?=$rp[1];?></td>

								<td><?=$rp[2];?></td>

							  </tr>

	<?php }?>
</tbody>
							</table>									</td>

								  </tr>

								</table>






<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout2.php");

?>