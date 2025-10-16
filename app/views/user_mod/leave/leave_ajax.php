<?php
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');

$str = $_POST['data'];
$data=explode('##',$str);
$data1=explode('<#>',$data[1]);

$s_date=$data[0];
$e_date=$data[1];
if($s_date!='' && $e_date!=''){
$e_date = date('Y-m-d H:i:s', strtotime($e_date . ' +1 day'));

$begin = new DateTime($s_date);
$end = new DateTime($e_date);

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
$day_count = 0;
foreach ($period as $dt) {
     $dt->format("l Y-m-d H:i:s\n");
    $today = $dt->format("Y-m-d");
    if($dt->format("l")!='Friday')
    {
$found = 0;
$found = find_a_field('salary_holy_day','1',' holy_day="'.$today.'" ');
if($found==0)
$day_count++;
    }

}
echo 'Total '.$day_count.' Days';
}
?>
<input type="hidden" name="total_days" id="total_days" value="<?=$day_count;?>" onfocus="focuson('total_days')" />
