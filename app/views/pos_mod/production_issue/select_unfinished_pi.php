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



			$pi_no = $_GET['pi_no'];



			$req_no = $_GET['req_no'];











		$_POST[$unique_master]=$$unique_master;







		$_POST['entry_at']=date('Y-m-d H:i:s');







		$_POST['status']='COMPLETE';







		$crud   = new crud($table_master);



		$crud->update($unique_master);











$master= find_all_field('production_issue_master','d_price','pi_no='.$pi_no);







$sql3='select * from master_requisition_details where req_no='.$_GET['req_no'];







		$rs = mysql_query($sql3);



		while($row=mysql_fetch_object($rs)){	



$issue_qty = $_POST['id'.$row->id];











mysql_query("UPDATE `production_issue_detail` SET `status` = 'COMPLETE',total_unit='".$issue_qty."' WHERE `req_id` = ".$row->id);



mysql_query("UPDATE `master_requisition_details` SET `status` = 'COMPLETE',qty='".$issue_qty."' WHERE `id` = ".$row->id);







		//journal_item_control($row->item_id ,$master->warehouse_from,$master->pi_date,0,$issue_qty,'Issue',$row->id,'',$master->warehouse_to,$req_no);



		//journal_item_control($row->item_id ,$master->warehouse_to  ,$master->pi_date,$issue_qty,'0','Issue',$row->id,'',$master->warehouse_from,$req_no);

		

		



		}



mysql_query("UPDATE `master_requisition_master` SET `status` = 'COMPLETE' WHERE `req_no` = ".$req_no);



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







    <td width="23%">&nbsp;</td>







    <td width="20%">&nbsp;</td>



<td width="13%">&nbsp;</td>







    <td width="10%">&nbsp;</td>



    <td width="34%">&nbsp;</td>







  </tr>







  <tr>







   <td bgcolor="#FF9966" align="right" width="23%"><strong>Date :</strong></td>







   <td  bgcolor="#FF9966" width="20%">



	<input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=$_POST['fdate']?>" autocomplete="off" />



	</td>





    <td align="center" bgcolor="#FF9966" width="13%"><strong> -to- </strong></td>







<td bgcolor="#FF9966" width="10%"><input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=$_POST['tdate']?>"  autocomplete="off" /></td>



<td  bgcolor="#FF9966" width="34%" ></td>

  </tr>







  <tr>







    <td align="right" bgcolor="#FF9966" width="23%"><strong>Select Production Line: </strong></td>







    <td bgcolor="#FF9966" colspan="3"><strong>







      	  <select name="req_for" id="req_for" style="width:200px;">



	  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['req_for'],'use_type="PL"  order by warehouse_name');?>

	  <option value="" <?=($_POST['req_for']=='')?'Selected':'';?>>All</option>





	  </select>







    </strong></td>







    <td bgcolor="#FF9966" colspan="20"><strong>







      <input type="submit" name="submitit" id="submitit" value="Create CMI" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>







    </strong></td>



 



  </tr>







</table>











<? 







if($_POST['fdate']!=''&&$_POST['tdate']!='')



$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';





if($_POST['req_for']>0)

$con .= ' and a.req_for = "'.$_POST['req_for'].'"  ';















 $res='select p.pi_no,a.req_no,a.req_no,w.warehouse_name as req_for,a.manual_req_no,(Select b.fname from user_activity_management b where b.user_id=p.entry_by) as entry_by ,a.entry_at,p.status



from master_requisition_master a,warehouse w,production_issue_master p, production_issue_detail pd where p.pi_no=pd.pi_no and p.req_no=a.req_no and p.status = "MANUAL" and w.warehouse_id=a.req_for  '.$con.' group by p.pi_no order by a.req_no';











 //echo $res='select p.pi_no,a.req_no,a.req_no,w.warehouse_name as req_for,b.fname as entry_by ,a.entry_at,p.status



//from master_requisition_master a,user_activity_management b,warehouse w,production_issue_master p where p.req_no=a.req_no and p.`status` = "PENDING" and w.warehouse_id=a.req_for and b.user_id = a.entry_by';



?>







<div class="tabledesign2">



<table width="100%" border="0" cellspacing="0" cellpadding="0">



    <thead>



    	<th>Req. No</th>



        <th>Req. For</th>

		

		 <th>Manual Req. For</th>



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



						<td><?=$rs->req_for?></td>

						

						<td><?=$rs->manual_req_no;?></td>



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







include ("../../template/main_layout.php");







?>