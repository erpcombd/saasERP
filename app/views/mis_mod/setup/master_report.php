<?

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


date_default_timezone_set('Asia/Dhaka');
//echo $_REQUEST['report'];
if(isset($_REQUEST['submit'])&&isset($_REQUEST['report'])&&$_REQUEST['report']>0)
{
	if((strlen($_REQUEST['t_date'])==10))
	{
		$t_date=$_REQUEST['t_date'];
		$f_date=$_REQUEST['f_date'];
	}
	
	if($_REQUEST['report']==1) $reportName="User Action Log";
	if($_REQUEST['report']==2) $reportName="User Transaction Report";
	if($_REQUEST['report']==3) $reportName="Query Log Report";
}	

$tr_type="Show";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>

<?
	require_once "../../../controllers/core/inc.exporttable.php";

?>
<style>
table tr td, table tr th{
	border: 1px solid #000;
}
</style>

<center><h1><?=$_SESSION['company_name']?></h1></center>
<h2><center><u><?=$reportName?></u></center></h2>
<? if($_POST['user_id']!=''){?><center><h3>User Name: <b><?=find_a_field('user_activity_management','fname','user_id='.$_POST['user_id']);?></b></h3></center><? }?>
<? if($_POST['mod_id']!=''){?><center><h3>Module Name: <b><?=find_a_field('user_module_manage','module_name','id='.$_POST['mod_id']);?></b></h3></center><? }?>
<center><h3>Date:<b><?=$f_date?></b> To <b><?=$t_date?></b> </h3></center><br /><br />




<?
if($_REQUEST['report']==1) 
{
?>
<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="10"><div class="header">





	<thead>
		<tr>
			<th>S/L</th>
			<th>User Name</th>
			<th>Module</th>
			<th>Page Name</th>
			<th>Link</th>
			<th>IP Address</th>
			<th>Access Date</th>
			<th>Execution Time</th>
		</tr>
		
	</thead>
	<tbody>
	<?
$connt='';
if($_POST['user_id']!=''){
$connt=' and l.user_id="'.$_POST['user_id'].'"';
}	
if($_POST['mod_id']!=''){
$connt .=' and l.mod_id="'.$_POST['mod_id'].'"';
}

 $qry='select l.*,m.module_name from user_action_log l, user_module_manage m where l.mod_id=m.id and l.access_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'" '.$connt.' ORDER BY l.id DESC';

	$query = db_query($qry);
		$sl = 1;
		while($info=mysqli_fetch_object($query)){
	?>

		<tr>
			<td><?=$sl++;?></td>
			<td><?=$info->user_fname;?></td>
			<td><?=$info->module_name;?></td>
			<td><?=$info->page_name?></td>
			<td><?=$info->page_link?></td>
			<td><?=$info->ip_address?></td>
			<td><?=$info->access_date?></td>
			<td><?=$info->execution_time?></td>
		
		</tr>
	<? } ?>	
	</tbody>
</table>
<?

}

if($_POST['report']=='182403') {

    if($_POST['opening_date']!=''){
        $opening_date_con=' and a.ji_date<="'.$_POST['t_date'].'"  '  ;    
    }
    if($_POST['group_for']!=''){
        $group_for_con=' and i.group_for="'.$_POST['group_for'].'"';    
    }

    // Date range setup - between f_date and t_date
    $from_date = $_POST['f_date'];
    $to_date = $_POST['t_date'];
    
    // Generate date range between f_date and t_date
    $dates = array();
    
    if(!empty($from_date) && !empty($to_date)) {
        $current = strtotime($from_date);
        $end = strtotime($to_date);
        
        if($current !== false && $end !== false) {
            while($current <= $end) {
                $dates[] = date('Y-m-d', $current);
                $current = strtotime('+1 day', $current);
                
                // Safety check to prevent infinite loop (max 100 days for performance)
                if(count($dates) > 100) break;
            }
        }
    } else if(!empty($to_date)) {
        // If only t_date provided, use just that date
        $dates[] = $to_date;
    }
    
    if(empty($dates)) {
        echo "Error: No valid dates to process.";
        exit;
    }

    // Get dynamic ledger groups
    $ledger_groups = array();
    $ledger_sql = "SELECT DISTINCT l.ledger_id,l.ledger_name 
                   FROM accounts_ledger l 
                   WHERE l.acc_sub_sub_class in (121,113) 
                   ORDER BY l.ledger_name" ;
    $ledger_query = db_query($ledger_sql);
    while($ledger_data = mysqli_fetch_object($ledger_query)) {
        $ledger_groups[$ledger_data->ledger_id] = $ledger_data->ledger_name;
    }

    // Function to get data for each date
    function getDateData($target_date, $ledger_groups) {
        $date_data = array();
        
        if($_POST['group_for']!=''){
            $gf_con=' and i.group_for in ('.$_POST['group_for'].')';    
        } else {
            $gf_con=' and i.group_for in (1,2,3,4,5,6,7)';
        }
        
        if($_POST['group_id']!=''){
            $group_con=' and g.group_id="'.$_POST['group_id'].'"';    
        } else {
            $group_con = '';
        }

        // Get stock values cumulative up to this date (as on date)
		// sum((j.item_in*j.item_price)-(j.item_ex*j.item_price)) 
          $wh_sql = "SELECT s.item_ledger, sum((j.item_in-j.item_ex)*j.item_price) as stock_value
                   FROM journal_item j, warehouse w, item_info i, item_group g, item_sub_group s
                   WHERE  
                    w.warehouse_id=j.warehouse_id  
                   AND j.ji_date<='".$target_date."' 
                   AND i.item_id=j.item_id 
                   AND i.sub_group_id=s.sub_group_id 
                   AND s.group_id=g.group_id 
                   AND s.item_ledger IN ('".implode("','", array_keys($ledger_groups))."')
                   AND w.use_type !='PL'
				   AND j.ji_date !='0000-00-00'
                   ".$gf_con.$group_con."
                   GROUP BY s.item_ledger";
        
        $stock_query = db_query($wh_sql);
        while($stock_data = mysqli_fetch_object($stock_query)) {
            $ledger_id = $stock_data->item_ledger;
            $date_data[$ledger_id]['stock'] = $stock_data->stock_value;
        }

        // Get spare parts stock cumulative up to this date (as on date)
        // $sp_sql = "SELECT g.ledger_group_id, sum((j.item_in-j.item_ex)*j.item_price) as stock_value
        //            FROM journal_item j, warehouse w, item_info i, item_group g
        //            WHERE w.warehouse_id=j.warehouse_id  
        //            AND j.ji_date<='".$target_date."' 
        //            AND i.item_id=j.item_id  
        //            AND i.item_group=g.group_id 
        //            AND i.item_group=400000000
        //            AND g.ledger_group_id IN ('".implode("','", array_keys($ledger_groups))."')
		// 		   AND j.group_for = ".$_POST['group_for']."
        //            GROUP BY g.ledger_group_id";
        
        // $sp_query = db_query($sp_sql);
        // while($sp_data = mysqli_fetch_object($sp_query)) {
        //     $ledger_id = $sp_data->ledger_group_id;
        //     $date_data[$ledger_id]['stock'] = $sp_data->stock_value;
        // }

        // Get TB values cumulative up to this date (as on date)
        $tb_sql = "SELECT j.ledger_id, sum(j.dr_amt-j.cr_amt) as tb_value
                   FROM journal j
                   WHERE j.jv_date<='".$target_date."' 
                   AND j.ledger_id IN ('".implode("','", array_keys($ledger_groups))."')
				   AND j.group_for =".$_POST['group_for']."
                   GROUP BY j.ledger_id";
        
        $tb_query = db_query($tb_sql);
        while($tb_data = mysqli_fetch_object($tb_query)) {
            $ledger_id = $tb_data->ledger_id;
            $date_data[$ledger_id]['tb'] = $tb_data->tb_value;
        }

        return $date_data;
    }

?>

<div class="report-header">
    <h1><?php echo find_a_field('user_group','group_name','id='.$_POST['group_for'].''); ?></h1>
    <h2><?php echo $report; ?></h2>
    <h2>Stock Position Report (As On Date) from <?php echo date('d-m-Y', strtotime($from_date)); ?> to <?php echo date('d-m-Y', strtotime($to_date)); ?></h2>
    <div class="date">Reporting Time: <?php echo date("h:i A d-m-Y"); ?></div>
</div>

<div class="table-container">
    <table id="ExportTable">
        <thead class="sticky-header">
            <!-- Main Header Row -->
            <tr class="main-header">
                <th class="frozen-cell date-header" rowspan="2"><strong>Date</strong></th>
                <?php foreach($ledger_groups as $ledger_id => $ledger_name): ?>
                    <th class="group-header" colspan="3"><strong><?php echo $ledger_name; ?></strong><br><small>(<?php echo $ledger_id; ?>)</small></th>
                <?php endforeach; ?>
                <th class="total-header" rowspan="2"><strong>Total Diff</strong></th>
            </tr>
            
            <!-- Sub Header Row -->
            <tr class="sub-header">
                <?php foreach($ledger_groups as $ledger_id => $ledger_name): ?>
                    <th class="sub-header-cell"><strong>Stock Value</strong></th>
                    <th class="sub-header-cell"><strong>TB Value</strong></th>
                    <th class="sub-header-cell diff-header"><strong>Difference</strong></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        
        <tbody>
            <?php 
            $totals = array(); // To store column totals
            
            // Initialize totals array
            foreach($ledger_groups as $ledger_id => $ledger_name) {
                $totals[$ledger_id]['stock'] = 0;
                $totals[$ledger_id]['tb'] = 0;
                $totals[$ledger_id]['diff'] = 0;
            }
            
            foreach($dates as $date): 
                $row_total_diff = 0;
                $date_data = getDateData($date, $ledger_groups);
            ?>
                <tr class="data-row">
                    <td class="frozen-cell date-cell"><strong><?php echo date('d-m-Y', strtotime($date)); ?></strong></td>
                    
                    <?php foreach($ledger_groups as $ledger_id => $ledger_name): 
                        // Get values for this date and ledger
                        $stock_value = isset($date_data[$ledger_id]['stock']) ? $date_data[$ledger_id]['stock'] : 0;
                        $tb_value = isset($date_data[$ledger_id]['tb']) ? $date_data[$ledger_id]['tb'] : 0;
                        
                        $diff = $stock_value - $tb_value;
                        $row_total_diff += $diff;
                        
                        // Add to totals
                        $totals[$ledger_id]['stock'] += $stock_value;
                        $totals[$ledger_id]['tb'] += $tb_value;
                        $totals[$ledger_id]['diff'] += $diff;

                    ?>
                        <!-- <td align="right"><a href="master_report.php?report=18240301&t_date=<?=$date?>&ledger_group_id=<?=$ledger_id?>&group_for=<?=$_POST['group_for']?>" target="_blank"><?php echo number_format($stock_value, 2);?></a></td> -->
                        <td><?=number_format($stock_value, 2)?></td>
                        <td align="right"><?php echo number_format($tb_value, 2); ?></td>
                        <td align="right" class="diff-cell"><?php echo number_format($diff, 2); ?></td>
                    <?php endforeach; ?>
                    
                    <td align="right" class="total-diff"><strong><?php echo number_format($row_total_diff, 2); ?></strong></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.report-header {
    text-align: center;
    margin-bottom: 20px;
    padding: 10px;
}

.report-header h1, .report-header h2 {
    margin: 5px 0;
}

.date {
    text-align: right;
    font-size: 12px;
    color: #666;
    margin-top: 10px;
}

.table-container {
    position: relative;
    width: 100%;
    height: 100%; /* Set a fixed height for scrolling */
    overflow: auto;
    border: 1px solid #ddd;
}

#ExportTable {
    border-collapse: collapse;
    width: 100%;
    font-size: 12px;
    position: relative;
}

#ExportTable th, #ExportTable td {
    border: 1px solid #ddd;
    padding: 6px;
    text-align: left;
    background-color: white;
    margin: 0;
    white-space: nowrap;
}

/* Sticky thead */
.sticky-header {
    position: sticky;
    top: 0;
    z-index: 10;
    background-color: #f2f2f2;
}

#ExportTable th {
    background-color: #f2f2f2;
    font-weight: bold;
    text-align: center;
    vertical-align: middle;
}

/* Freeze the first column */
.frozen-cell {
    position: sticky;
    left: 0;
    z-index: 15;
    background-color: #f2f2f2;
    border-right: 2px solid #999;
}

/* Header styling */
.date-header {
    background-color: #f2f2f2;
}

.group-header {
    background-color: #f2f2f2;
    padding: 8px 6px;
    line-height: 1.2;
}

.total-header {
    background-color: #f2f2f2;
}

.sub-header-cell {
    background-color: #f2f2f2;
    padding: 4px 6px;
}

/* Difference header and cell styling */
.diff-header {
    background-color: #99FFFF !important;
}

/* Data cells styling */
.date-cell {
    background-color: #f9f9f9;
    font-weight: bold;
    position: sticky;
    left: 0;
    z-index: 5;
    border-right: 2px solid #999;
}

.diff-cell {
    background-color: #99FFFF !important;
}

.total-diff {
    background-color: #e6f3ff;
    font-weight: bold;
}

/* Make sure borders are consistent */
#ExportTable td:first-child,
#ExportTable th:first-child {
    border-left: 1px solid #ddd;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-container {
        height: 100%;
    }
    
    #ExportTable {
        font-size: 10px;
    }
    
    #ExportTable th, #ExportTable td {
        padding: 4px;
    }
}

/* Print styles */
@media print {
    .table-container {
        height: auto;
        overflow: visible;
    }
    
    #ExportTable th {
        position: static;
    }
    
    .frozen-cell {
        position: static;
    }
}
</style>

<?php
}


	
if($_REQUEST['report']==2) 
{
?>
<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="10"><div class="header">


	<thead>
		<tr>
			<th>.S/L</th>
			<th>User Name</th>
			<th>Date</th>
			<th>Tr From</th>
			<th>Entry Count</th>
			<th>Initiate</th>
			<th>Add</th>
			<th>Remove</th>
			<th>Delete</th>
			<th>Show</th>
		</tr>
		 
	</thead>
	<tbody>
	<?
$con='';
if($_POST['user_id']!=''){
$con=' and user_id="'.$_POST['user_id'].'"';
}	
if($_POST['mod_id']!=''){
$con .=' and mod_id="'.$_POST['mod_id'].'"';
}

    echo $sql='select user_id,tr_from,access_date,count(tr_type) as trcount from user_action_log where access_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'" '.$con.' and tr_from!="" and tr_type!="" group by user_id,access_date,tr_from,tr_type order by user_id';
echo 'found';
$qrry=db_query($sql);
while($test=mysqli_fetch_object($qrry)){

$trEntry[$trData->user_id][$trData->tr_from][$trData->access_date][$trData->tr_type]=$trData->trcount;
}


	
   $sql3333='select user_id,user_fname,access_date,tr_from,count(tr_from) as trdata from user_action_log where access_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'" '.$con.' group by tr_from,access_date ';
	$query2=db_query($sql3333);
		$sl = 1;
		while($info = mysqli_fetch_object($query2)){
		
	?>
		<tr>
			<td><?=$sl++;?></td>
			<td><?=$info->user_fname;?></td>
			<td><?=$info->access_date?></td>
			<td><?=$info->tr_from;?></td>
			<td><?=$info->trdata;?></td>
			<td><?=$trEntry[$info->user_id][$info->tr_from][$info->access_date]['Initiate']?></td>
			<td><?=$trEntry[$info->user_id][$info->tr_from][$info->access_date]['Add']?></td>
			<td><?=$trEntry[$info->user_id][$info->tr_from][$info->access_date]['Remove']?></td>
			<td><?=$trEntry[$info->user_id][$info->tr_from][$info->access_date]['Delete']?></td>
			<td><?=$trEntry[$info->user_id][$info->tr_from][$info->access_date]['Show']?></td>
		</tr>
	<? } ?>	
	</tbody>
</table>



<? } if($_REQUEST['report']==3){?>

<table id="ExportTable" width="100%" cellspacing="0" cellpadding="2" border="0"><thead><tr><td style="border:0px;" colspan="10"><div class="header">
	<thead>
		<tr>
			<th>S/L</th>
			<th>Query Info</th>
			<th>Query execution time</th>
			<th>Run At</th>
			<th>User Name</th>
<!--			<th>Module</th>
			<th>Page Name</th>-->
			<th>Link</th>
			<th>IP Address</th>
			<th>Access Date</th>
		<!--<th>Execution Time</th>-->
		</tr>
		
	</thead>
	<tbody>
	<?
 	
	$qry='select * from user_query_log where 1 and access_date between "'.$_REQUEST['f_date'].'" and "'.$_REQUEST['t_date'].'" ORDER BY id DESC';
	$query = db_query($qry);
	$sl = 1;
	while($info=mysqli_fetch_object($query)){
	?>
		<tr>
			<td><?=$sl++;?></td>
			<th align="left"><?=$info->query_info;?></th>
			<td><?=$info->query_execution_time;?></td>
			<td><?=$info->run_at;?></td>
			<td><?=$info->user_fname;?></td>
<!--			<td><?=$info->module_name;?></td>
			<td><?=$info->page_name?></td>-->
			<td><?=$info->page_link?></td>
			<td><?=$info->ip_address?></td>
			<td><?=$info->access_date?></td>
<!--			<td><?=$info->execution_time?></td>-->
		
		</tr>
	<? } ?>	
	</tbody>
</table>

<?
} elseif(isset($sqla)&&$sqla!='') {echo report_create($sqla,1,$str);}
?>
</div>
</body>
</html>

<?
$page_name= $_POST['report'].$report."(Master Report Page)";
require_once SERVER_CORE."routing/layout.report.bottom.php";
?>