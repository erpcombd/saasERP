 <?php
require_once "../../../assets/template/layout.top.php";
$title='Sales Order List';

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
  <form action="" method="post" name="codz" id="codz">
  
  <?php /*?><table width="50%" border="0" align="center">
      <tr>
	  
	  <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="so_no" id="so_no" style="width:200px;" placeholder="SO Number" />
        </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
		<?php
  $sql="select * from dealer_info";
 $query=mysql_query($sql);
 ?>		 
 <input list="bro" name="customer" id="customer" autocomplete="off" placeholder="Customer Name"> 
               <datalist id="bro">
		 <?php 
               while($datarow=mysql_fetch_object($query)){ ?>
              <option value="<?=$datarow->dealer_code?>"><?=$datarow->dealer_name_e?></option> 
		<?php }?>
		  </datalist>

		
        </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
		
			<?php
  $sql="select * from user_activity_management";
 $query=mysql_query($sql);
 ?>		 
 <input list="bros" name="entry_by" id="entry_by" autocomplete="off" placeholder="Entry By"> 
               <datalist id="bros">
		 <?php 
               while($datarow=mysql_fetch_object($query)){ ?>
              <option value="<?=$datarow->user_id?>"><?=$datarow->fname?></option> 
		<?php }?>
		  </datalist>
        </strong></td>
		
		<td width="1" bgcolor="#FF9966"><strong>
          <select name="status" placeholder="Status">
		  <option> </option>
		  <option value="MANUAL">UNFINISHED</option>
		  <option value="COMPLETED">COMPLETED</option>
		  <option value="ACC_APPROVE">AC VERIFY</option>
		  <option value="VERIFIED_SO">APPROVAL</option>
		  <option value="CHECKED">APPROVED</option>
		  
		  </select>
        </strong></td>
       
      </tr>
    </table><?php */?>
  
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:110px;" value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
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

$con_date= 'and do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

}

//$customer=$_POST['customer'];
//$entry_by=$_POST['entry_by'];

if($_POST['customer']!=""){
		$con.= " and dealer_code='".$_POST['customer']."' ";
	    }
if($_POST['entry_by']!=""){
		$con.= "and entry_by='".$_POST['entry_by']."' ";
	    }		
if($_POST['so_no']!=""){
		$con.= "and do_no='".$_POST['so_no']."' ";
	    }		
if($_POST['status']!=""){
		$con.= "and status='".$_POST['status']."' ";
	    }
?>

<table class="table table-bordered table-sm" id="sales_list">
	<thead>
		<tr>
		<th>SL No</th>
			<th>SO No</th>
			<th>SO Date</th>
			<th>PO No</th>
			<th>PO Date</th>
			<th>Customer Name</th>
			
			<th>Entry By</th>
			<th>View</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	  $sql="select * from sale_do_master where status in('ACC_APPROVE','MANUAL','VERIFIED_SO','CHECKED','COMPLETED') ".$con.$con_date." order by do_no desc ";
	$query=mysql_query($sql);
	while($data=mysql_fetch_object($query)){
	?>
		<tr>
		<td><?=++$i?></td>
			<td><?=$data->do_no?></td>
			<td><?=$data->do_date?></td>
					<td><?=$data->po_no?></td>
							<td><?=$data->po_date?></td>
			<td><?=find_a_field('dealer_info','dealer_name_e','dealer_code='.$data->dealer_code);?></td>
			<td><?=find_a_field('user_activity_management','fname','user_id="'.$data->entry_by.'"')?></td>
			<td><a href="do_print_view.php?do_no=<?=$data->do_no?>" target="_blank"><button type="submit" class="btn btn-success btn-sm" >View</button></a></td>
			<td  
			<?php if($data->status=='MANUAL'){echo 'style="background-color: red; color:white"';}
			 if($data->status=='COMPLETED'){echo 'style="background-color: green; color:white"';}
			  if($data->status=='ACC_APPROVE'){echo 'style="background-color: yellow;"';}
			   if($data->status=='CHECKED'){echo 'style="background-color: blue; color:white"';}
			?>
			
			
			><?php if($data->status=='COMPLETED'){echo "COMPLETED";} if($data->status=='MANUAL'){echo "UNFINISHED";}  if($data->status=='ACC_APPROVE'){ echo "AC VERIFY"; } if($data->status=='VERIFIED_SO'){ echo "APPROVAL"; }if($data->status=='CHECKED'){ echo "APPROVED";}  ?></td>
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