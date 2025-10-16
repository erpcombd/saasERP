 <?php
require_once "../../../assets/template/layout.top.php";
$title='Upcomming Performance Appraisal List(Authorized)';

do_calander('#fdate');
do_calander('#tdate');
do_datatable('sales_list');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../salesReturn/item_return_report.php';

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
<style>
table thead tr th{
font-size:14px!important;
padding:0px 6px!important;
}
table tbody tr td{
font-size:14px!important;
padding:0px 6px!important;
}
</style>

<div class="form-container_large">
<?php 
 $cus_emp_id=find_a_field('user_activity_management','EMP_ID','user_id="'.$_SESSION['user']['id'].'"');
  $autho_pbi=find_a_field('personnel_basic_info','PBI_ID','EMP_ID="'.$cus_emp_id.'"');
$_SESSION['notify'][774]=find_a_field('performance_appraisal','count(id)','status="VERIFIED" and   employee_id in(select EMP_ID from personnel_basic_info where authorized_by="'.$autho_pbi.'")');
?>
<?php 
											  $current_month= date("m");
												$current_year=date('Y');
											  if($current_month<=1){
											  $prev_month=12;
											   $prev_year=$current_year-1;
											  }
											  else{
												$prev_month=$current_month-1;
												 $prev_year=$current_year;
											  }
											  //////prev from date////
											  $prev_date=$prev_year."-".$prev_month."-26";
											?>
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
          <input type="text" name="fdate" id="fdate" style="width:110px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:$prev_date;?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:110px;" value="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
        </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>
    </table>
  </form>
  
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
$con_date= 'and do_date between "'.date('Y-m-01').'" and "'.date('Y-m-d').'"';
if($_POST['fdate']!=''&&$_POST['tdate']!=''){

$con_date= 'and present_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

}
 
?>

<table class="table table-bordered table-sm" id="sales_list">
	<thead class="jumbotron">
		<tr>
		<th>Employee ID</th>
			<th>Employee Name</th>
			<th>Designation</th>
			<th>Department</th>
			 
			<th>Action</th>
		 
		</tr>
	</thead>
	<tbody>
	<?php 
		if($_SESSION['user']['id']==1 || $_SESSION['user']['id']==10130){
		     $sql="select * from performance_appraisal where status in('VERIFIED')  order by id desc ";
	}
	else{
	   $sql="select * from performance_appraisal where status in('VERIFIED') and  employee_id in(select EMP_ID from personnel_basic_info where authorized_by='".$autho_pbi."')  order by id desc ";
	   }
	 
	$query=mysql_query($sql);
	while($data=mysql_fetch_object($query)){
	$pbi_all=find_all_field('personnel_basic_info','*','EMP_ID="'.$data->employee_id.'"');
	?>
		<tr>
		 
			<td><?=$data->employee_id?></td>
			<td><?=$pbi_all->PBI_NAME?></td>
			<td><?=find_a_field('designation','DESG_DESC','DESG_ID='.$pbi_all->DESG_ID);?></td>
			<td><?=find_a_field('department','DEPT_DESC','DEPT_ID='.$pbi_all->DEPT_ID);?></td>
		 
			<td><a href="performance_apprisial_view_autho.php?emp_id=<?php echo $pbi_all->PBI_ID;?>&id=<?php echo $data->id;?>"  ><input type="button" value="View" /></a></td>
			 
		</tr>
		<?php } ?>
	</tbody>
</table>



</div></td>
</tr>
</table>


<?
require_once "../../../assets/template/layout.bottom.php";
?>