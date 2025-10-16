<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Account Ledger';

$proj_id=$_SESSION['proj_id'];

$active='acledg';

$button="yes";

$unique='ledger_id';

$$unique=$_GET[$unique];

?>



<script type="text/javascript">







function Do_Nav()



{



	var URL = 'pop_ledger_selecting_list.php';



	popUp(URL);



}







function DoNav(theUrl)



{



	document.location.href = '<?=$page?>?ledger_id='+theUrl;



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

	if(isset($_POST['record']))

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
		
		header('Location:../pages/account_ledger.php');

		}

	}

}





//for Modify..................................



if(isset($_POST['modify']))

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

                                    <table class="table table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">

                                      <tr>

                                        <td>Ledger  Name:</td>

                                        <td><input name="ledger_name" style="max-width:250px;" type="text" id="ledger_name" value="<?php echo $data[1];?>" class="required form-control" /></td>

									  </tr>



                                      <tr>

                                        <td>Ledger Group  :</td>

                                        <td>

			<select name="ledger_group_id" id="ledger_group_id" style="max-width:250px;" class="form-control">

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

			<? }}?>

			</select>

			</td>

									  </tr>

                                      <!--<tr>

                                        <td>Opening Balance   :</td>

                                        <td><input name="balance" type="text"  id="balance" value="<?php echo $data[3];?>"/></td>

									  </tr>-->

                                      <tr>

                                        <td>Transaction Type : </td>

                                        <td><select name="b_type" id="b_type" style="max-width:250px;" class="form-control">

                                          <option value="Debit"<?php if($data[4]=='Debit') echo " Selected "?>>Debit</option>

                                          <option value="Credit"<?php if($data[4]=='Credit') echo " Selected "?>>Credit</option>

                                          <option value="Both"<?php if($data[4]=='Both') echo " Selected "?>>Both</option>

                                        </select></td>

                                      </tr>

                                      <!--<tr>

                                        <td>Depreciation Rate : </td>

                                        <td><input name="d_rate" type="text" id="d_rate" value="<?php echo $data[5];?>"/></td>

                                      </tr>-->

                                      <!--<tr>

                                        <td>Credit Limit :</td>

                                        <td><input name="cr_limit" type="text" id="cr_limit" value="<?php echo $data[6];?>"/></td>

                                      </tr>-->

                                      <tr>

                                        <td>Budget Enable: </td>

                                        <td>

										<select name="budget_enable" id="budget_enable" style="max-width:250px;" class="form-control">

										<option value="NO"<?php if($data[9]=='NO') echo " Selected "?>>NO</option>

                                          <option value="YES"<?php if($data[9]=='YES') echo " Selected "?>>YES</option>

                                          

                                        </select>

										</td>

                                      </tr>

                                      <tr>

                                        <td>Opening Balance on:</td>

                                        <td>          <?php 

		if(isset($data[7]))

		{

		?>

          <input name="open_date" style="max-width:250px;" class="form-control" type="text" id="open_date" value="<?php echo date("d-m-Y",$data[7]);?>"/>

          <?php	}else	{

		?>

          <input name="open_date" style="max-width:250px;" type="text" id="open_date" value="<?php echo date("d-m-Y",time());?>"/>

          <?php

		}

		?></td>

                                      </tr>

                                    </table>

                                  </div></td>

                                </tr>

                                

                                

                              

                              </table>

    

							</div></td>

  </tr>

</table>75



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>