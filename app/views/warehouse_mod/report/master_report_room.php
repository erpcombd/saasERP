<?
session_start();
require "../../common/check.php";
require "../../config/db_connect.php";

require "../../common/my.php";
date_default_timezone_set('Asia/Dhaka');

if(isset($_POST['submit'])&&isset($_POST['report'])&&$_POST['report']>0)
{
	if($_POST['room_id']>0)
	{
		$room_id=$_POST['room_id'];

	}
	if((strlen($_POST['t_date'])==10)&&(strlen($_POST['f_date'])==10))
	{
	$t_date=$_POST['t_date'];
	$f_date=$_POST['f_date'];
	}
	if($_POST['service_id']>0)
	$service_id=$_POST['service_id'];

switch ($_POST['report']) {
    case 1:
		$report="Service Wise Billing Report ";
		if(isset($room_id)) {$room_con=' and a.room_id='.$room_id;} 
		if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;} 
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.bill_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		$sql='select a.id,s.service_group, a.bill_date,a.bill_amt,a.paid_date,a.paid_amt from hms_bill_payment a,`hms_service_group` s where s.id=a.service_group_id '.$date_con.$service_con.' group by service_group_id' ;
	break;
    case 2:
		$report="Room Wise Billing Report ";
		if(isset($room_id)) {$room_con=' and a.room_id='.$room_id;} 
		if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;} 
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.bill_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		$sql='select a.id,s.service_group,b.room_name, a.bill_date,a.bill_amt,a.paid_date,a.paid_amt from hms_bill_payment a,`hms_service_group` s,hms_hotel_room b where a.room_id=b.id and s.id=a.service_group_id '.$date_con.$service_con.$room_con ;
		break;
		
    case 3:
	$report="Pending Billing Report ";
		if(isset($room_id)) {$room_con=' and a.room_id='.$room_id;} 
		if(isset($service_id)) {$service_con=' and a.service_group_id='.$service_id;} 
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.bill_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		
		$sql='select a.id,s.service_group,b.room_name, a.bill_date,a.bill_amt,a.paid_date,a.paid_amt from hms_bill_payment a,`hms_service_group` s,hms_hotel_room b where a.bill_amt>a.paid_amt and  a.room_id=b.id and s.id=a.service_group_id '.$date_con.$service_con.$room_con ;
		break;
    case 4:
	$report="Product Information";
		
	$sql="SELECT * FROM `proc_product_info` ";
		break;
	    case 5:
		if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' party_code='.$party_code;}

	$report="Client Detail Information";

	$sql="SELECT `party_code`,`party_name`,`fname` as full_name,`per_add` as permanent_address,`per_tel` as Permanent_address,`pre_add` as present_address,`pre_tel_of` as Present_tel_no,`tin_no`,`birth_date`,`nominee`,`naddr` as nominee_address,`nrelation` as nominee_relation FROM `tbl_party_info` where".$party_con;
		break;
	
    case 6:
		$report="Collection Statement(Total)";
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select a.rec_date as tr_date,a.cheq_no,b.proj_name".$flat_show.",a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b where a.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." order by a.rec_date";
		break;
		case 7:
		$report="Payment Statement";
		if(isset($_POST['mr'])&&$_POST['mr']>0)
		{$mr_no=$_POST['mr']; $mr_con=' and a.rec_no='.$mr_no;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="SELECT a.`rec_date`,a.`rec_no` as m_r_no,b.proj_name,a.flat_no,c.party_name,a.`rec_amount`,
concat_ws(' ','C/NO:',a.`cheq_no`,'DT:',a.`cheq_date`,'Bank:',a.`bank_name`,'BH:',a.`branch` ) as detail
FROM `tbl_receipt` a, tbl_party_info c,tbl_project_info b  
WHERE a.proj_code=b.proj_code and a.party_code=c.party_code ".$proj_con.$date_con.$flat_con.$mr_con;
		break;
		
	case 11:
        $report="OutStanding Dues";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select c.proj_name as project_name,a.flat_no as allot_no,b.party_name as client_name,a.inst_date,a.inst_amount as payable_amt,a.rcv_amount as received_amt from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d where a.proj_code=c.proj_code and d.party_code=b.party_code and a.proj_code=d.proj_code and a.build_code=d.build_code and a.flat_no=d.flat_no and rcv_status=0 ".$proj_con.$date_con.$flat_con.$party_con." order by a.inst_date";
		break;
	case 12:
        $report="Expected Collection";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select c.proj_name as project_name,a.flat_no as allot_no,b.party_name as client_name,a.inst_date,a.inst_amount as payable_amt,a.rcv_amount as received_amt from tbl_flat_cost_installment a, tbl_party_info b, tbl_project_info c,tbl_flat_info d where a.proj_code=c.proj_code and d.party_code=b.party_code and a.proj_code=d.proj_code and a.build_code=d.build_code and a.flat_no=d.flat_no ".$proj_con.$date_con.$flat_con.$party_con." order by a.inst_date";
		break;
	case 13:
        $report="Payment Schedule";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and d.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.inst_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="SELECT e.pay_desc,a.inst_no, c.proj_name AS project_name,a.flat_no AS allot_no,  a.inst_date, a.inst_amount AS payable_amt, a.rcv_date AS receive_date, a.rcv_amount AS receive_amt
FROM 
tbl_flat_cost_installment a, 
tbl_party_info b, 
tbl_project_info c, 
tbl_flat_info d,
tbl_payment_head e
WHERE a.proj_code = c.proj_code
AND d.party_code = b.party_code
AND a.proj_code = d.proj_code
AND a.build_code = d.build_code
AND a.flat_no = d.flat_no
AND a.pay_code = e.pay_code".$proj_con.$date_con.$flat_con.$party_con." order by a.inst_date";
		break;
		case 14:
        $report="Party Rent Agreement Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		$sql="SELECT b.`proj_name`,a.`flat_no`,c.`party_name`,a.`monthly_rent`,a.`effective_date`,a.`expire_date`,a.`notice_period`,a.discontinue_term,a.`witness1`,a.`witness1_address` FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;
		break;
		case 15:
        $report="Party Rent Payment Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		$sql="SELECT b.`proj_name`,a.`flat_no`,c.`party_name`,a.`security_money`,a.`monthly_rent`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,(a.`monthly_rent`++a.`electricity_bill`+a.`other_bill`+a.`wasa_bill`+a.`gas_bill`) as total_payable FROM `tbl_rent_info` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;
		break;
		case 16:
        $report="Party Rent Payment Terms";
if(isset($party_code))
{$client_name=find_a_field('tbl_party_info','party_name','party_code='.$party_code); $party_con=' and a.party_code='.$party_code;}
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}

		$sql="SELECT a.jv_no as Invoice_no,a.mon as period,b.`proj_name`,a.`flat_no`,c.`party_name`,a.`rent_amt`,a.`electricity_bill`,a.`other_bill`,a.`wasa_bill`,a.`gas_bill`,total_amt as total_amt FROM `tbl_rent_receive` a,tbl_party_info c,tbl_project_info b WHERE a.party_code=c.party_code and a.proj_code=b.proj_code ".$proj_con.$flat_con.$party_con;
		break;

	case 24:
	$report="Collection Statement(Cash)";
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select a.rec_date as tr_date,b.proj_name".$flat_show.",a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b where a.pay_mode=0 and a.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." order by a.rec_date";
		break;
	case 25:
	$report="Collection Statement(Chaque)";
		if(isset($proj_code)) 
		if(!isset($flat_no))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		else
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); 
$allotment_no=$flat_no; $flat_show=',a.flat_no as allot_no'; $flat_con=' and a.proj_code='.$proj_code.' and a.flat_no=\''.$flat_no.'\' ';}
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.rec_date between \''.$fr_date.'\' and \''.$to_date.'\'';}
		$sql="select a.rec_date as tr_date,a.cheq_no,b.proj_name".$flat_show.",a.rec_amount as total_amt from tbl_receipt a,tbl_project_info b where a.pay_mode=1 and a.proj_code=b.proj_code ".$proj_con.$date_con.$flat_con." order by a.rec_date";
		break;
		
		
// COMMISION REPORTS
		case 31:
	$report="Share Holder Investment Amount";
		if(isset($proj_code))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`status`,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code`".$date_con.$proj_con ." order by a.proj_code,a.agent_code";
		break;
		
		case 33:
	$report="Running Share Holder Information";
		if(isset($proj_code))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Running' ".$date_con.$proj_con ." order by a.proj_code,a.agent_code";
		break;
		
		case 34:
	$report="Withdrawn Share Holder Information";
		if(isset($proj_code))
{$project_name=find_a_field('tbl_project_info','proj_name','proj_code='.$proj_code); $proj_con=' and a.proj_code='.$proj_code;}
		
		if(isset($t_date)) 
{$to_date=$t_date; $fr_date=$f_date; $date_con=' and a.opening_date between \''.$fr_date.'\' and \''.$to_date.'\'';}

		$sql="SELECT a.`member_no`,a.`party_name` as share_holder,b.proj_name,a.`agent_code`,c.`emp_name` as agent_name,a.`opening_date` as invest_date,a.`invested`,a.`status_date` as withdrawn_date,a.`withdraw` FROM `tbl_director_info` AS a,tbl_project_info as b,tbl_employee_info as c WHERE a.proj_code=b.proj_code and c.emp_id=a.`agent_code` and a.status='Withdrawn' ".$date_con.$proj_con ." order by a.proj_code,a.agent_code";
		break;
		
		case 35:
	$report="Agent Information";
		
		$sql="SELECT `emp_id`,`emp_name`,`emp_designation`,`emp_joining_date`,`emp_contact_no`, (select count(1) from tbl_director_info where agent_code=a.emp_id) as total_member, (select sum(invested) from tbl_director_info where agent_code=a.emp_id) as total_invested, (select sum(withdraw) from tbl_director_info where agent_code=a.emp_id)  as total_withdrawn FROM `tbl_employee_info` as a WHERE 1";
		break;
		
		//ROW_NUMBER() OVER(ORDER BY Id) AS Row
}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?=$report?></title>
<link href="../../css/report.css" type="text/css" rel="stylesheet" />
<script language="javascript">
function hide()
{
document.getElementById('pr').style.display='none';
}
</script>
</head>
<body>
<div align="center" id="pr">
<input type="button" value="Print" onclick="hide();window.print();"/>
</div>
<div class="main">
<?
		$str 	.= '<div class="header">';
		if(isset($_SESSION['company_name'])) 
		$str 	.= '<h1>'.$_SESSION['company_name'].'</h1>';
		if(isset($report)) 
		$str 	.= '<h2>'.$report.'</h2>';
		if(isset($to_date)) 
		$str 	.= '<h2>'.$fr_date.' To '.$to_date.'</h2>';
		$str 	.= '</div>';
		if(isset($_SESSION['company_logo'])) 
		//$str 	.= '<div class="logo"><img height="60" src="'.$_SESSION['company_logo'].'"</div>';
		$str 	.= '<div class="left">';
		if(isset($project_name)) 
		$str 	.= '<p>Project Name: '.$project_name.'</p>';
		if(isset($allotment_no)) 
		$str 	.= '<p>Allotment No.: '.$allotment_no.'</p>';
		$str 	.= '</div><div class="right">';
		if(isset($client_name)) 
		$str 	.= '<p>Client Name: '.$client_name.'</p>';
		$str 	.= '</div><div class="date">Reporting Time: '.date("h:i A d-m-Y").'</div>';

if(isset($sql)&&$sql!='') echo report_create($sql,1,$str);
?></div>
</body>
</html>