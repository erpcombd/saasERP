<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Upcoming Purchase Order List';

do_calander("#fdate");
do_calander("#tdate");
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';



?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
</script>

<div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Item Name : </strong></td>
        <td colspan="3" bgcolor="#FF9966"><label>
          <input type="text" name="item" id="item" style="width:220px" value="<?=$_POST['item']?>" required />
          </label></td>
        <td rowspan="3" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
          </strong></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966">Line Name : </td>
        <td colspan="3" bgcolor="#FF9966"><select name="warehouse_id" id="warehouse_id">
		<option></option>
            <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'use_type="PL" and group_for='.$_SESSION['user']['group'].' order by warehouse_name asc');?>
          </select></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
          </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
          </strong></td>
      </tr>
    </table>
  </form>
  <div class="tabledesign2">
    <table width="100%" cellspacing="0" cellpadding="0" id="grp">
      <tbody>
        <tr>
          <th>SL</th>
          <th>Code</th>
          <th>Item_name</th>
          <th>Unit</th>
          <th>GR</th>
          <th>Issue</th>
          <th>Consumption</th>
          <th>GR vs Issue %</th>
          <th>GR vs Comp. %</th>
          <th>Issue vs Comp. %</th>
        </tr>
        <? 
if(isset($_POST['submitit'])){

$con ='';
if($_POST['fdate']!=''&&$_POST['tdate']!=''){
$con .= ' and p.rec_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$issue_con.=' and pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
$consm_con.=' and pi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';}

if($_REQUEST['item']!=''){$item = explode('#>',$_REQUEST['item']);
if($item[1]>0){			
$item_id=$item[1];
$con .= ' and p.item_id="'.$item_id.'"';
$issue_con.=' and item_id ="'.$item_id.'"';
$consm_con.=' and item_id ="'.$item_id.'"';
}}
$con.=' and p.warehouse_id ="'.$_SESSION['user']['depot'].'"';


if($_REQUEST['warehouse_id']!=''){
$issue_con.=' and warehouse_to ="'.$_POST['warehouse_id'].'"';
$consm_con.=' and warehouse_from ="'.$_POST['warehouse_id'].'"';}

$res='select  distinct p.item_id as item_id_p, i.item_name, i.unit_name, sum(p.qty) as qty_gr,
(select sum(total_unit) from production_issue_detail where item_id=p.item_id and warehouse_from="'.$_SESSION['user']['depot'].'"'.$issue_con.') as total_issue,
(select sum(total_unit) from production_floor_issue_detail where item_id=p.item_id'.$consm_con.') as total_consm

from purchase_receive p, item_info i 

where p.item_id=i.item_id'.$con;

//echo $res;
$query = db_query($res);
while($data=mysqli_fetch_object($query))
{

?>
        <tr>
          <td valign="top"><?= ++$z;?></td>
          <td valign="top"><?=$data->item_id_p;?></td>
          <td valign="top"><?=$data->item_name;?></td>
          <td valign="top"><?=$data->unit_name;?></td>
          <td><?=number_format($data->qty_gr,2);?></td>
          <td><?=number_format($data->total_issue,2);?></td>
          <td><?=number_format($data->total_consm,2);?></td>
          <td><?=number_format(($data->total_issue/$data->qty_gr)*100,2);?></td>
          <td><?=number_format(($data->total_consm/$data->qty_gr)*100,2);?></td>
          <td><?=number_format(($data->total_consm/$data->total_issue)*100,2);?></td>
        </tr>
        <? }}?>
        <tr>
          <td colspan="4" valign="top"><div align="right"><strong>Total:</strong></div></td>
          <td><strong>
            <?=number_format($tqty,0);?>
            </strong></td>
          <td><strong>
            <?=number_format($trq,0);?>
            </strong></td>
          <td><strong>
            <?=number_format($tdq,0);?>
            </strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </div>
  </td>
  </tr>
  </table>
</div>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>