<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Select Production Line for Issue';



$table_master='production_issue_master';
$unique_master='pi_no';



$table_detail='production_issue_detail';
$unique_detail='id';



$$unique_master=$_POST[$unique_master];



if(isset($_POST['delete']))

{

		$crud   = new crud($table_master);

		$condition=$unique_master."=".$$unique_master;		

		$crud->delete($condition);

		$crud   = new crud($table_detail);

		$crud->delete_all($condition);

		unset($$unique_master);

		unset($_POST[$unique_master]);

		$type=1;

		$msg='Successfully Deleted.';

}

if(isset($_POST['confirm']))

{

		unset($_POST);

		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='PENDING';

		$crud   = new crud($table_master);
		$crud->update($unique_master);

			$pi_no = $_GET['pi_no'];
			$req_no = $_GET['req_no'];
$master= find_all_field('production_issue_master','d_price','pi_no='.$pi_no);

		$sql3='select * from warehouse_requisition_details where req_no='.$_GET['req_no'];
		echo $sql3;
		$rs = db_query($sql3);
		while($row=mysqli_fetch_object($rs)){	
		    
$r = "INSERT INTO `production_issue_detail` (`pi_no`, `req_no`, `req_id`, `pi_date`, `item_id`, `warehouse_from`, `warehouse_to`, `req_qty`,`total_unit`, `unit_price`, `total_amt`, `old_production_date`, `status`) VALUES 
('".$pi_no."', '".$req_no."', '".$row->id."', '".$master->pi_date."', '".$row->item_id."', '".$master->warehouse_from."', '".$master->warehouse_to."', '".$row->order_qty."', '0', '0', '', 'PENDING')";
db_query($r);
		}
db_query("UPDATE `warehouse_requisition_master` SET `status` = 'PENDING' WHERE `req_no` = ".$req_no);
		unset($$unique_master);
		unset($_POST[$unique_master]);
        unset($_SESSION[$unique_master]);
		$type=1;

		$msg='Successfully Send.';

}



auto_complete_start_from_db('warehouse','concat(warehouse_name,"-",use_type)','warehouse_id','use_type="PL"','line_id');

?>

<script language="javascript">

window.onload = function() {document.getElementById("dealer").focus();}

</script>

<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Select Production Line: </strong></td>

    <td bgcolor="#FF9966"><strong>

      	  <select name="line_id" id="line_id" style="width:200px;">
          <option value="">All</option>

	  <? foreign_relation('warehouse','warehouse_name','warehouse_name',$_POST['line_id'],'use_type="PL"  order by warehouse_name');?>

	  </select>

    </strong></td>

    <td bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Create CMI" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>

    </strong></td>

  </tr>

</table>


<? 
$res='select p.pi_no,a.req_no,a.req_no,w.warehouse_name as req_for,b.fname as entry_by ,a.entry_at,a.status
from warehouse_requisition_master a,user_activity_management b,warehouse w,production_issue_master p where p.req_no=a.req_no and p.`status` = "PENDING" and w.warehouse_id=a.req_for and b.user_id = a.entry_by and a.req_for like "%'.$_POST['line_id'].'%"';
?>

<div class="tabledesign2">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <thead>
    	<th>Req. No</th>
        <th>Req. For</th>
        <th>Entry By</th>
        <th>Entry At</th>
        <th>Status</th>
        <th>Show</th>
    </thead>
      
        <? 
			$r=db_query($res);
			while($rs=mysqli_fetch_object($r)){
				?>
					<tr>
                    	<td><?=$rs->req_no?></td>
						<td><?=$rs->req_for?></td>
                        <td><?=$rs->entry_by?></td>
                        <td><?=$rs->entry_at?></td>
                        <td><?=$rs->status?></td>
                        <td><a href="../production_issue/production_issue_check.php?old_pi_no=<?=$rs->pi_no?>"><span><strong>Show</strong></span></a></td>                    
                    </tr>
				<?
			}
		?>
     
      </td>
    </tr>
  </table>
  </div>

</form>

</div>



<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>