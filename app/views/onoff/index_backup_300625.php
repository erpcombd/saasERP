<?
$config = require_once "../../../app/controllers/config/db_master_config.php";
$con = mysqli_connect($config['hostname'], $config['username'], $config['password'], $config['database'], $config['port']);

$pid = $_REQUEST['pid'];
$p=100;
if($_REQUEST['pid']>0 && $_REQUEST['pid']==10112)
{
$transfer_status = $_REQUEST['tstatus'];
if($transfer_status==''){
$status =  $_REQUEST['pstatus'];
$transfer_status = 'NO';
}else{
$status = 'ON';
}

$sql2 ='update company_info set is_transfer="'.$transfer_status.'",status="'.$status.'" where id = '.$pid;
mysqli_query($con,$sql2);


$sqlq="SELECT b.db_user,b.db_pass,b.db_name,a.cid,a.id,a.company_name,a.address FROM 
company_info a,database_info b WHERE a.id='$pid' and a.id=b.company_id limit 1";


	$sql=@mysqli_query($con,$sqlq);
	if($proj=@mysqli_fetch_object($sql))
	{




					$host   = 'localhost';
					$db	    = $proj->db_name;
					$user	= $proj->db_user;
					$pass	= $proj->db_pass;

                    $mainDb = mysqli_connect($host,$user,$pass,$db);
                    
                    $sql ='update project_info set status="'.$action.'" where 1';
                    //mysqli_query($mainDb,$sql);

}
//header("Location: index.php");
//die();
}

?>
<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>

<h1 style="text-align: center; color: red;">Control Panel</h1>
<form action="" method="post">
<table id="customers">
  <tr>
    <th>Projects</th>
    <th>Status</th>
    <th>ON/OFF</th>
	<th>BLACKWHITE</th>
	<th>TRANSFER</th>
  </tr>
  <?
$sql="SELECT cid,id,company_name,status,is_transfer FROM 
company_info  WHERE id in (10112)";
$query = mysqli_query($con,$sql);
while($data=mysqli_fetch_object($query)){

if($data->status=='ON'){
$btnName1 = 'OFF NOW';
$btnName2 = 'BLACKLIST';

}elseif($data->status=='OFF'){
$btnName1 = 'ON NOW';
$btnName2 = 'BLACKLIST';

}elseif($data->status=='BLACK'){
$btnName1 = 'ON NOW';
$btnName2 = 'WHITELIST';

}else{
$btnName = '';
}

if($data->is_transfer=='YES'){
$btnName3 = 'STOP';
}else{
$btnName3 = 'TRANSFER';
}

  ?>
  <tr>
    <td><?=$data->company_name?></td>
    <td><?=$data->status?></td>
    <td><input type="button" value="<?=$btnName1?>" onClick="window.location.href='?pstatus=<?=($data->status=='ON')?'OFF':'ON'?>&pid=<?=$data->id?>'"></td>
	<td><input type="button" value="<?=$btnName2?>" onClick="window.location.href='?pstatus=<?=($data->status=='ON')?'BLACK':'ON'?>&pid=<?=$data->id?>'"></td>
	<td><input type="button" value="<?=$btnName3?>" onClick="window.location.href='?tstatus=<?=($data->is_transfer=='YES')?'NO':'YES'?>&pid=<?=$data->id?>'"></td>
  </tr>
  <? }?>

</table>
</form>
</body>
</html>