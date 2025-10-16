<?php



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Other Issue List';





do_calander('#fdate');


do_calander('#tdate');





$table = 'purchase_master';


$unique = 'po_no';


$status = 'CHECKED';


$target_url = '../other_issue/other_issue_report.php';





if($_REQUEST[$unique]>0)


{


$_SESSION[$unique] = $_REQUEST[$unique];


header('location:'.$target_url);


}





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


        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>


        <td width="1" bgcolor="#FF9966"><strong>


          <input type="text" name="fdate" id="fdate" style="width:80px;" value="<?=date('Y-m-01')?>" />


        </strong></td>


        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>


        <td width="1" bgcolor="#FF9966"><strong>


          <input type="text" name="tdate" id="tdate" style="width:80px;" value="<?=(isset($_POST['tdate']))?$_POST['tdate']:date('Y-m-d')?>" />


        </strong></td>


        <td bgcolor="#FF9966"><strong>


          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>


        </strong></td>


      </tr>


    </table>


  </form>


  <table width="100%" border="0" cellspacing="0" cellpadding="0">


<tr>


<td><div class="tabledesign2">


<? 


if(isset($_POST['submitit'])){


?>
		<table id="grp" cellspacing="0" cellpadding="0" width="100%">
		
		<tr>
		<th width="10%">Oi No</th>
		<th width="10%">Oi Date</th>
		<th width="10%">Serial</th>
		<th width="10%">Req From</th>
		<th width="10%">Issue To</th>

		<th width="10%">Total</th>

		<th width="10%">Entry By</th>
		</tr>


<?

$con .= 'and a.oi_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';





 $res='select  a.oi_no,a.oi_no,a.oi_date,a.oi_subject as serial,d.DEPT_DESC as requisition_from, p.PBI_NAME as issue_to,a.issue_type,sum(amount) as Total,a.entry_at,c.fname as entry_by 


from warehouse_other_issue a, warehouse_other_issue_detail b, user_activity_management c, department d, personnel_basic_info p


where (a.issue_type = "Sample Issue" or a.issue_type = "Other Issue" or a.issue_type = "Gift Issue" or a.issue_type = "Entertainment Issue" or a.issue_type = "Office Issue") and a.requisition_from= d.DEPT_ID and a.issued_to=p.PBI_ID and a.oi_no=b.oi_no and a.entry_by=c.user_id and a.warehouse_id = "'.$_SESSION['user']['depot'].'" '.$con.' group by a.oi_no order by a.oi_no desc';









$query = db_query($res);

while($data = mysqli_fetch_object($query)){


?>				<tr>

			<td width="10%"><a href="../other_issue/other_issue_report.php?v_no=<?=$data->oi_no?>" target="_blank"><?=$data->oi_no;?></a></td>
			<td width="10%"><?=$data->oi_date;?></td>
			<td width="10%"><?=$data->serial;?></td>
			<td width="10%"><?=$data->requisition_from;?></td>
			<td width="10%"><?=$data->issue_to;?></td>
			<td width="10%"><?=$data->Total;?></td>
			<td width="10%"><?=$data->entry_by;?></td>
			
				
		</tr>
	
<?
}
}


?>
</table>

</div></td>


</tr>


</table>


</div>





<?


$main_content=ob_get_contents();


ob_end_clean();


require_once SERVER_CORE."routing/layout.bottom.php";


?>