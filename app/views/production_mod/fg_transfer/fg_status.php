<?php



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Stock Transfer List';





do_calander('#fdate');


do_calander('#tdate');





$table = 'stock_transfer_master';


$unique = 'st_no';


$status = 'CHECKED';


$target_url = '../stock_transfer/st_issue_report.php';





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
		<th width="10%">ST No</th>
		<th width="10%">St Date</th>
		
		<th width="10%">Item</th>
		<th width="10%">Details</th>
		<th width="10%">Warehouse From</th>
		<th width="10%">Warehouse To</th>
		<th width="10%">Total</th>
		<th width="10%">Entry By</th>
		</tr>


<?

$con .= 'and a.st_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';





 $res='select  a.st_no,a.st_no,a.st_date,a.st_details as Details,(select item_name from item_info where item_id=b.item_id) as item,(select warehouse_name from warehouse where warehouse_id=a.warehouse_from) as warehouse_from, (select warehouse_name from warehouse where warehouse_id=a.warehouse_to) as warehouse_to,b.qty,c.username 


from stock_transfer_master a, stock_transfer_details b, user_activity_management c,item_info i


where a.issue_type = "Stock_transfer" and  a.st_no=b.st_no and a.entry_by=c.user_id  '.$con.' and a.status="CHECKED" group by a.st_no order by a.st_no desc';









$query = db_query($res);

while($data = mysqli_fetch_object($query)){


?>				<tr>

			<td width="10%"><a href="../stock_transfer/st_issue_report.php?v_no=<?=$data->st_no?>" target="_blank"><?=$data->st_no;?></a></td>
			<td width="10%"><?=$data->st_date;?></td>
			
			<td width="10%"><?=$data->item;?></td>
			<td width="10%"><?=$data->Details;?></td>
			<td width="10%"><?=$data->warehouse_from;?></td>
			<td width="10%"><?=$data->warehouse_to;?></td>
			<td width="10%"><?=$data->qty;?></td>
			<td width="10%"><?=$data->username;?></td>
			
				
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