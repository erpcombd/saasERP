<?
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$flag=$_REQUEST['flag'];
$PBI_ID=$_REQUEST['PBI_ID'];


		$U_ID=$_SESSION['user']['id'];
		$USED_DT=date('Y-m-d h:i:s');
		$last_update_date=date('Y-m-d h:i:s');
if($flag==0)
{
$sql = "UPDATE `salary_info` SET 
`bonus_applicable` = 'YES'  WHERE `PBI_ID` = ".$PBI_ID;
db_query($sql);
echo 'SET-TO-YES!';
}
if($flag==1)
{
$sql = "UPDATE `salary_info` SET 
`bonus_applicable` = 'NO'  WHERE `PBI_ID` = ".$PBI_ID;
db_query($sql);
echo 'SET-TO-NO!';

}?>