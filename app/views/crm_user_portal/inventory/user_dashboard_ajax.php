<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

@ini_set('error_reporting', E_ALL);

@ini_set('display_errors', 'Off');

$today = date('Y-m-d');
$lastdays = 	date("Y-m-d", strtotime("-7 days", strtotime($today)));
$this_month_start = date('Y-m-01');
$sunday=date('Y-m-d',strtotime('last sunday'));
$monday=date('Y-m-d',strtotime('last monday'));
$tuesday=date('Y-m-d',strtotime('last tuesday'));
$wednesday=date('Y-m-d',strtotime('last wednesday'));
$thursday=date('Y-m-d',strtotime('last thursday'));
$friday=date('Y-m-d',strtotime('last friday'));
$saturday=date('Y-m-d',strtotime('last saturday'));

$basic = 'select p.PBI_NAME,p.PBI_ID,p.PBI_CODE,desg.DESG_DESC,d.DEPT_DESC,p.PBI_DOJ,p.PBI_SERVICE_LENGTH,p.incharge_id from personnel_basic_info p left join department d on d.DEPT_ID=p.DEPT_ID left join designation desg on desg.DESG_ID=p.DESG_ID where p.PBI_ID="'.$_SESSION['employee_selected'].'"';
$basic_data = mysqli_fetch_object(db_query($basic));
$incharge = find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$basic_data->incharge_id.'"');
$interval = date_diff(date_create(date('Y-m-d')), date_create($basic_data->PBI_DOJ));
$service_length =  $interval->format("%Y Year, %M Months, %d Days");
$basic_info = '<table>
					      <tr>
									<td class="bold">ID:</td>
									<td>'.$basic_data->PBI_CODE.'</td>
								</tr>

								<tr>
									<td class="bold">NAME: </td>
									<td>'.$basic_data->PBI_NAME.'</td>
								</tr>

								<tr>
									<td class="bold">Designation: </td>
									<td>'.$basic_data->DESG_DESC.'</td>
								</tr>

								<tr>
									<td class="bold">Department: </td>
									<td>'.$basic_data->DEPT_DESC.'</td>
								</tr>

								<tr>
									<td class="bold">Joining Date: </td>
									<td>'.date('d-M-Y',strtotime($basic_data->PBI_DOJ)).'</td>
								</tr>


								<tr>
									<td class="bold">Service Length: </td>
									<td>'.$service_length.'</td>
								</tr>
								
								<tr>
									<td class="bold">Incharge: </td>
									<td>'.$incharge.'</td>
								</tr>

							</table>';

$late = 0;
$absent = 0;
$present = 0;	
$leave = 0;	
$holiday= 0;	
$friday = 0;			
for($i=$this_month_start;$i<=$today; $i = date('Y-m-d', strtotime( $i . " +1 days"))){
$inTime = find_a_field('hrm_attdump','min(xtime)','xdate="'.$i.'" and xenrollid="'.$_SESSION['employee_selected'].'"');
if($inTime!=''){
 $present++;
 $intime = strtotime($inTime);
 $office_in_time = strtotime($i.' 10:00:00');
 if($intime>$office_in_time){
  $late++;
 }
}else{
$leave_check = find_a_field('hrm_att_summary','id','att_date="'.$i.'" and leave_id>0 and emp_id="'.$_SESSION['employee_selected'].'"');
$holiday = find_all_field('salary_holy_day','','holy_day="'.$i.'"');
$fridays = date('D',strtotime($i));
if($leave_check>0){
$leave++;
}elseif($holiday->reason!=''){
$holiday++;
}elseif($fridays=='Fri'){
$friday++;
}else{
$absent++;
}
}
}							
//$att_sql = 'select * from hrm_attdump where xdate between "'.$this_month_start.'" and "'.$today.'" and xenrollid="'.$_SESSION['employee_selected'].'"';
$activities_sql = 'select page_name,page_link,ip_address,access_date as access_timing from user_action_log where user_id="'.$_SESSION['employee_selected'].'" order by id desc limit 2';
$qry = db_query($activities_sql);

$activities_table = '<table class="table1  table-striped table-bordered table-hover table-sm">
							<thead class="thead1">
							<tr class="bgc-success">
								<th>#</th>
								<th>Page Name</th>
								<th>Page Link</th>
								<th>Ip Address</th>
								<th>Timing</th>
							</tr>
							</thead>
							<tbody class="tbody1">';
							while($activity=mysqli_fetch_object($qry)){
							
		$activities_table .='<tr>';
		$activities_table .='<td>'.++$i.'</td>';
		$activities_table .='<td>'.$activity->page_name.'</td>';
		$activities_table .='<td>'.$activity->page_link.'</td>';
		$activities_table .='<td>'.$activity->ip_address.'</td>';
		$activities_table .='<td>'.$activity->access_timing.'</td>';
		$activities_table .='</tr>';
                             }
		$activities_table .='</tbody></table>';



$all_dealer[]=$basic_info;
$all_dealer[]=$present+($leave+$friday+$holiday);
$all_dealer[]=$absent;
$all_dealer[]=$late;
$all_dealer[]=$leave;
$all_dealer[]=$activities_table;
$all_dealer[]=link_report($res);

echo json_encode($all_dealer);

?>



