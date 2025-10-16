<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Account Sub Sub Ledger';
$proj_id=$_SESSION['proj_id'];
$now=time();
$active='subsubl';
$page="account_sub_sub_ledger_add.php";
$separator	= $_SESSION['separator'];
if(isset($_REQUEST['name'])||isset($_REQUEST['id']))
{
	//common part.............
	
	$id=$_REQUEST['id'];
	//echo $ledger_id;
	$name		= mysqli_real_escape_string($_REQUEST['id']);
	$name			= str_replace("'","",$name);
	$name			= str_replace("&","",$name);
	$name			= str_replace('"','',$name);
	$under		= mysqli_real_escape_string($_REQUEST['under']);
	$balance	= mysqli_real_escape_string($_REQUEST['balance']);
	//end
	if(isset($_POST['nledger']))
	{
		$check="select sub_sub_ledger_id from sub_sub_ledger where sub_sub_ledger='$name'";
		//echo $check;
		if(mysqli_num_rows(db_query($check))>0)
		{
			$aaa=mysqli_num_rows(db_query($check));
			$ledger_id=$aaa[0];
				$type=0;
				$msg='Given Name('.$name.') is already exists.';
		}
		else
		{	$sql_check="select ledger_id,balance_type,budget_enable from accounts_ledger where ledger_id='".$under."' limit 1";
			$sql_query=db_query($sql_check);
			if(mysqli_num_rows($sql_query)>0){
			$ledger_data=mysqli_fetch_row($sql_query);
				if(!ledger_redundancy($name))
				{
					$type=0;
					$msg='Given Name('.$name.') is already exists as Ledger.';
				}
			else
			{				
			 		$sub_ledger_id=next_sub_sub_ledger_id($under);
					sub_sub_ledger_create($sub_ledger_id,$name, $under, $balance, $now, $proj_id);

					ledger_create($sub_ledger_id,$name,$ledger_data[0],'',$ledger_data[1],'','', time(),$proj_id,$ledger_data[2]);
					$type=1;
					$msg='New Entry Successfully Inserted.';
						
			}

		}
		else
		{
		$type=0;
		$msg='Invalid Accounts Ledger!!!';
		}
		}
	}

//for Modify..................................

	if(isset($_POST['mledger']))
	{
$search_sql="select 1 from sub_sub_ledger where `sub_sub_ledger_id`!='$id' and `sub_sub_ledger` = '$name' limit 1";
if(mysqli_num_rows(db_query($search_sql))==0)
	{
		$sql_check="select ledger_id from accounts_ledger where ledger_id=".$under;
		$sql_query=db_query($sql_check);
		if(mysqli_num_rows($sql_query)==1){
		$id=$_REQUEST['id'];
		$sql2="UPDATE `accounts_ledger` SET 
		`ledger_name` 		= '$name'	
			WHERE `ledger_id` 		='$id' LIMIT 1";
		$sql="UPDATE `sub_sub_ledger` SET
		`sub_sub_ledger` = '$name'
		WHERE `sub_sub_ledger_id` =$id LIMIT 1";
		$query=db_query($sql);
		$query=db_query($sql2);
		$type=1;
		$msg='Successfully Updated.';
		}
		else
		{
		$type=0;
		$msg='Invalid Accounts Ledger!!!';
		}
		//echo $sql;
	}
	else
	{
	$type=0;
	$msg='Given Name('.$name.') is already exists.';
	}
	}

	if(isset($_POST['dledger']))
{
$id=$_REQUEST['id'];
$sql="delete from `sub_sub_ledger` where `sub_sub_ledger_id`='$id' limit 1";
$query=db_query($sql);
$sql="delete from `accounts_ledger` where `ledger_id`='$id' limit 1";
$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}

	$ddd="select * from sub_sub_ledger where sub_sub_ledger_id=".$$unique;
	$data=mysqli_fetch_row(db_query($ddd));
}
?>
<script type="text/javascript">



function Do_Nav()

{

	var URL = 'account_sub_ledger.php';

	popUp(URL);

}



function DoNav(theUrl)

{

	document.location.href = 'account_sub_sub_ledger_add.php?id='+theUrl;

}

function popUp(URL) 

{

	day = new Date();

	id = day.getTime();

	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

							<table class="table table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr>
                                        <td align="right">Sub Sub Ledger   : </td>
                                        <td width="60%" align="right" >
                <input name="search_u_s_s_l" style="max-width:250px;" type="text" id="search_u_s_s_l" value="<?php echo $_REQUEST['search_u_s_s_l']; ?>" /></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Under Sub Ledger  : </td>
                                        <td align="right" >
                <input name="search_u_s_l" type="text" style="max-width:250px;" id="search_u_s_l" value="<?php echo $_REQUEST['search_u_s_l']; ?>" /></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="center"><input class="btn" name="search" type="submit" id="search" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
									<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
									<thead>
							  <tr>
								<th>Sub Sub Ledger</th>
								<th>Sub Sub Ledger Id</th>
								<th>Sub Ledger</th>
							  </tr>
							  </thead>
							  <tbody>
<?php 

if($_SESSION['user']['group']>1)
$rrr="select z.* FROM sub_sub_ledger z,sub_ledger a,accounts_ledger b,ledger_group c where a.ledger_id=b.ledger_id and b.ledger_group_id=c.group_id and z.sub_ledger_id=a.sub_ledger_id and c.group_for=".$_SESSION['user']['group'];
else
$rrr="select z.* FROM sub_sub_ledger z,sub_ledger a,accounts_ledger b,ledger_group c where a.ledger_id=b.ledger_id and b.ledger_group_id=c.group_id and z.sub_ledger_id=a.sub_ledger_id";

if($_REQUEST['search_u_s_s_l']!='')
{
if(is_numeric($_REQUEST['search_u_s_s_l']))
$rrr.=' and z.sub_sub_ledger_id='.$_REQUEST['search_u_s_s_l'];
else
$rrr.=' and z.sub_sub_ledger like "%'.$_REQUEST['search_u_s_s_l'].'%"';
}

if($_REQUEST['search_u_s_l']>0)
$rrr.=' and z.sub_ledger_id='.$_REQUEST['search_u_s_l'];
	
	$report=db_query($rrr);
//echo $rrr;
	while($rp=@mysqli_fetch_row($report))
	{$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
								<td><nobr><?=add_separator($rp[1],$separator);?></nobr></td>
								<td><?=$rp[0];?></td>
								<td><?=$rp[2];?></td>
							  </tr>
	<?php }?>
							</tbody></table>									</td>
								  </tr>
								</table>

							
<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout2.php");
?>