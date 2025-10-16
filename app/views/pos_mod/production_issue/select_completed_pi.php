<?php



session_start();



ob_start();



require_once "../../../assets/support/inc.all.php";



$title='Select Production Line for Issue';

do_calander('#fdate');


do_calander('#tdate');





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



		$_POST[$unique_master]=$$unique_master;

		$_POST['entry_at']=date('Y-m-d H:i:s');

		$_POST['status']='PENDING';



		$crud   = new crud($table_master);

		$crud->update($unique_master);



		$pi_no = $_GET['pi_no'];

		$req_no = $_GET['req_no'];

$master= find_all_field('production_issue_master','d_price','pi_no='.$pi_no);



		$sql3='select * from master_requisition_details where req_no='.$_GET['req_no'];



		$rs = mysql_query($sql3);

		while($row=mysql_fetch_object($rs)){

		    $issue_qty = $_POST['id'.$row->id];

$r = "INSERT INTO `production_issue_detail` (`pi_no`, `req_no`, `req_id`, `pi_date`, `item_id`, `warehouse_from`, `warehouse_to`, `req_qty`,`total_unit`, `unit_price`, `total_amt`, `old_production_date`, `status`) VALUES 

('".$pi_no."', '".$req_no."', '".$row->id."', '".$master->pi_date."', '".$row->item_id."', '".$master->warehouse_from."', '".$master->warehouse_to."', '".$row->order_qty."','".$issue_qty."', '0', '0', '', 'PENDING')";

mysql_query($r);

$xid= mysql_insert_id();


//journal_item_control($row->item_id ,$master->warehouse_from,$master->pi_date,0,$issue_qty,'Issue',$xid,'',$master->warehouse_to,$_POST['remarks']);

//journal_item_control($row->item_id ,$master->warehouse_to,$master->pi_date,$issue_qty,'0','Issue',$xid,'',$master->warehouse_from,$_POST['remarks']);

mysql_query("UPDATE `master_requisition_details` SET `status` = 'PENDING',qty='".$issue_qty."' WHERE `id` = ".$row->id);

		}

mysql_query("UPDATE `master_requisition_master` SET `status` = 'PENDING' WHERE `req_no` = ".$req_no);

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

<td>&nbsp;</td>
<td>&nbsp;</td>

  </tr>



  <tr>



    <td bgcolor="#FF9966" align="right"><strong>Date :</strong></td>



    <td  bgcolor="#FF9966">
	<input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=$_POST['fdate']?>"  autocomplete="off"/>
	</td>



    <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>

<td bgcolor="#FF9966"><input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=$_POST['tdate']?>"  autocomplete="off"/></td>
<td  bgcolor="#FF9966"></td>

  </tr>



  <tr>



    <td align="right" bgcolor="#FF9966"><strong>Select Production Line: </strong></td>



    <td colspan="3" bgcolor="#FF9966"><strong>



      	  <select name="req_for" id="req_for" style="width:200px;">

          <option value="">All</option>



	  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],'use_type="PL"  order by warehouse_name');?>



	  </select>



    </strong></td>



    <td bgcolor="#FF9966" rowspan="3"><strong>



      <input type="submit" name="submitit" id="submitit" value="SHOW" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>



    </strong></td>



  </tr>



</table>





<? 
if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';


if($_POST['req_for']>0)
$con .= 'and a.req_for = "'.$_POST['req_for'].'"  ';

 $res='select a.req_no,a.req_no,w.warehouse_name as req_for,a.manual_req_no , b.fname as entry_by ,a.entry_at,a.status from master_requisition_master a,user_activity_management b,warehouse w where a.status  in ("COMPLETE","RECEIVE") '.$con.'  and w.warehouse_id=a.req_for and b.user_id = a.entry_by ';

?>



<div class="tabledesign2">

<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <thead>

    	<th>Req. No</th>
		
    	<th>Auto Req No</th>

        <th>Req. For</th>

        <th>Entry By</th>

        <th>Entry At</th>

        <th>Status</th>

        <th>Show</th>

    </thead>

      

        <? 

			$r=mysql_query($res);

			while($rs=mysql_fetch_object($r)){

				?>

					<tr>

                    	<td><?=$rs->req_no?></td>

						<td><?=$rs->manual_req_no?></td>
						
						<td><?=$rs->req_for?></td>

                        <td><?=$rs->entry_by?></td>

                        <td><?=$rs->entry_at?></td>

                        <td><?=$rs->status?></td>

                        <td>

						<?

						if($rs->status=="COMPLETE" || $rs->status=="RECEIVE" ){

						?>

						<a target="_blank" href="../production_issue/production_issue_report.php?v_no=<?=$rs->req_no?>&req_status=<?=$rs->status?>"><span><strong>Complete</strong></span></a>

						<?

						}else{

						?>

						<a href="../production_issue/production_issue.php?req=<?=$rs->req_no?>"><span><strong>Show</strong></span></a>

						<?

						}

						?>

						</td>                    

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



include ("../../template/main_layout.php");



?>