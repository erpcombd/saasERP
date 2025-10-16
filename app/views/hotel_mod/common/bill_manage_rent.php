<?php 


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."core/init.php";
require_once SERVER_CORE."routing/layout.top.php";


//require "../common/my.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
$data = array();

	$data['unit_price'] = $_REQUEST['unit_price'];
	$data['qty'] = $_REQUEST['qty'];
	$data['dis_amt'] = $_REQUEST['dis_amt'];
	$data['bill_amt'] = $_REQUEST['bill_amt'];
	$data['service_id'] = $_REQUEST['service_id'];
	// $sql2="select b.service_name from hms_services b where b.id='".$data['service_id']."'";
	$sql="select b.service_name from hms_services b where b.id='".$data['service_id']."'";
	$data['service_name']=find_a_field_sql($sql);
	$data['bill_date'] = $_REQUEST['bill_date'];
	$count = $_REQUEST['count']+1;

?>
<table width="720px" border="1" align="left" cellpadding="2" cellspacing="2" bordercolor="#333333" bgcolor="#DFEFFF" id="rowid<?=$count;?>"  style="border-collapse:collapse; border:1px solid #C1DAD7;">

<td width="240px">
<input name="service_name<?=$count;?>" id="service_name<?=$count;?>" type="text" readonly="true" class="input3" value="<?=$data['service_name'] ?>" style="width:210px"/>
<input name="service_id<?=$count;?>" id="service_id<?=$count;?>" readonly="true" class="input3" value="<?=$data['service_id'] ?>" style="display:none;" type="hidden"/>
</td>
<td width="105px">
<input name="unit_price<?=$count;?>" id="unit_price<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['unit_price'] ?>" style="text-align:right"/></td>
</td>
<td width="105px"><input name="qty<?=$count;?>" id="qty<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['qty'] ?>" style="text-align:right"/>
</td>
<td width="105px"><input name="dis_amt<?=$count;?>" id="dis_amt<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['dis_amt'] ?>" style="text-align:right"/>

</td>
<td width="105px"><input name="bill_amt<?=$count;?>" id="bill_amt<?=$count;?>" type="text" readonly="true"  class="input3" value="<?=$data['bill_amt'] ?>" style="text-align:right"/>

</td>
<td width="60px"><a href="#" onclick="deletethis<?=$count;?>();"><button class="btn btn1-bg-cancel"><i class="fa-light fa-trash"></i></button></a></td>
	</tr>		
</table>
<input name="deleted<?=$count;?>" id="deleted<?=$count;?>" type="hidden" value="no" />
<script type="text/javascript">
function deletethis<?=$count;?>()
{
document.getElementById('rowid<?=$count;?>').className='deleted';
document.getElementById('deleted<?=$count;?>').value='yes';
document.getElementById('rowid<?=$count;?>').style.display='none';
document.getElementById("total_amt").value = ((document.getElementById("total_amt").value)*1)-((document.getElementById("bill_amt<?=$count;?>").value)*1);
}
</script>