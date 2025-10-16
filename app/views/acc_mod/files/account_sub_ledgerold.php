<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Account Sub Ledger';
$proj_id=$_SESSION['proj_id'];
$now=time();
$active='acsubl';
$page="account_sub_ledger_add.php";
$separator	= $_SESSION['separator'];
if(isset($_REQUEST['name'])||isset($_REQUEST['id']))
{
	//common part.............
	
	$id=$_REQUEST['id'];
	//echo $ledger_id;
	$name		= mysqli_real_escape_string($_REQUEST['name']);
	$name		= str_replace("'","",$name);
	$name		= str_replace("&","",$name);
	$name		= str_replace('"','',$name);
	$under		= mysqli_real_escape_string($_REQUEST['under']);
	$balance	= mysqli_real_escape_string($_REQUEST['balance']);
	//end
	if(isset($_POST['nledger']))
	{
		$check="select sub_ledger_id from sub_ledger where sub_ledger='$name'";
		if(mysqli_num_rows(db_query($check))>0)
		{
			$aaa=mysqli_num_rows(db_query($check));
			$ledger_id=$aaa[0];
				$type=0;
				$msg='Given Name('.$name.') is already exists.';
		}
		else
		{	$sql_check="select ledger_group_id, balance_type, budget_enable from accounts_ledger where ledger_id='".$under."' limit 1";
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
			$sub_ledger_id=number_format(next_sub_ledger_id($under), 0, '.', '');
			sub_ledger_create($sub_ledger_id,$name, $under, $balance, $now, $proj_id);
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
$search_sql="select 1 from sub_ledger where `sub_ledger`!='$id' and `sub_ledger` = '$name' limit 1";
if(mysqli_num_rows(db_query($search_sql))==0)
	{
		$sql_check="select ledger_id from accounts_ledger where ledger_id=".$under;
		$sql_query=db_query($sql_check);
		if(mysqli_num_rows($sql_query)==1){
		$id=$_REQUEST['id'];
		$sql2="UPDATE `accounts_ledger` SET 
		`ledger_name` 		= '$name'	
			WHERE `ledger_id` 		='$id' LIMIT 1";
		$sql="UPDATE `sub_ledger` SET
		`sub_ledger` = '$name'
		WHERE `sub_ledger_id` =$id LIMIT 1";
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
$sql="delete from `sub_ledger` where `sub_ledger_id`='$id' limit 1";
$query=db_query($sql);
$sql="delete from `accounts_ledger` where `ledger_id`='$id' limit 1";
$query=db_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
}

	$ddd="select * from sub_ledger where sub_ledger_id='$id'";
	$data=mysqli_fetch_row(db_query($ddd));
}
?>

<script type="text/javascript">



function Do_Nav()

{

	var URL = 'account_sub_ledger_add.php';

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


							<table class="table table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div ><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
                                      <tr class="form-group">
                                        <td width="40%" align="right">Sub Ledger Name:</td>
                                        <td width="60%" align="right" ><div align="left">
                                          <input name="sub_ladger" type="text" id="sub_ladger" value="<?php echo $_REQUEST['sub_ladger']; ?>"  style="max-width:250px"/>
                                        </div></td>
                                      </tr>
                                      <tr>
                                        <td align="left"><div align="right">Ledger Name :                                         </div></td>
                                        <td align="left" ><input name="ladger_name" type="text" id="ladger_name" value="<?php echo $_REQUEST['ladger_name']; ?>" style="max-width:250px" /></td>
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
								<th>Sub Ledger Id</th>
								<th>Sub Ledger</th>
								<th>A/C Ledger</th>
							  </tr>
							  </thead>
							  <tbody>
<?php 
		
		if($_SESSION['user']['group']>1)
$rrr="select a.sub_ledger, b.ledger_name, c.group_name, a.sub_ledger_id FROM sub_ledger a,accounts_ledger b,ledger_group c where a.ledger_id=b.ledger_id and b.ledger_group_id=c.group_id and c.group_for=".$_SESSION['user']['group'];
else
$rrr="select a.sub_ledger, b.ledger_name, c.group_name, a.sub_ledger_id FROM sub_ledger a,accounts_ledger b,ledger_group c where a.ledger_id=b.ledger_id and b.ledger_group_id=c.group_id";

	
	if(isset($_REQUEST['search']))
	{
		$ladger_group	= mysqli_real_escape_string($_REQUEST['ladger_group']);
		$ladger_name	= mysqli_real_escape_string($_REQUEST['ladger_name']) ;
	
		$rrr .= " AND b.ledger_name LIKE '%$ladger_name%'";
		$rrr .= " AND c.group_name LIKE '%$ladger_group%'";	
		
if($_REQUEST['sub_ladger']!='')
{
if(is_numeric($_REQUEST['sub_ladger']))
$rrr.=' and a.sub_ledger_id='.$_REQUEST['sub_ladger'];
else
$rrr.=' and a.sub_ledger like "%'.$_REQUEST['sub_ladger'].'%"';
}
	} 
	$rrr .= "  order by sub_ledger_id";

	$report=db_query($rrr);

	while($rp=mysqli_fetch_row($report))
	{$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[3];?>');">
				 				<td><nobr><?=add_separator($rp[3],$separator);?></nobr></td>
								<td><?=$rp[0];?></td>
								<td><?=$rp[1];?></td>
							  </tr>
	<?php }?>
	</tbody>
							</table>								</td>
								  </tr>
								</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout2.php");
?>