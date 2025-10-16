<?php
//session_start ();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";

//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
include '../config/function.php';
$menu         = 'Home';
$title='Dashboard';	

//include 'inc/header.php';
//include 'inc/sidebar.php';

$total_shop = find1("select count(*) from ss_shop");

class Calendar
{

  private $active_year, $active_month, $active_day;
  private $events = [];

  public function __construct($date = null)
  {
    $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
    $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
    $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
  }

  public function add_event($txt, $date, $days = 1, $color = '')
  {
    $color = $color ? ' ' . $color : $color;
    $this->events[] = [$txt, $date, $days, $color];
  }

  public function __toString()
  {
    $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
    $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
    $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
    $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
    $html = '<div class="calendar" id="calEvent">';
    $html .= '<div class="header" style="height: 42px color:black">';
    $html .= '<div class="month-year">';
    $html .= date('F Y', strtotime($this->active_year . '-' . $this->active_month . '-' . $this->active_day));
    $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="days">';
    foreach ($days as $day) {
      $html .= '
              <div class="day_name">
                  ' . $day . '
              </div>
          ';
    }
    for ($i = $first_day_of_week; $i > 0; $i--) {
      $html .= '
              <div class="day_num ignore">
                  ' . ($num_days_last_month - $i + 1) . '
              </div>
          ';
    }
    for ($i = 1; $i <= $num_days; $i++) {
      $selected = '';
      if ($i == $this->active_day) {
        $selected = ' selected';
      }
      $html .= '<div class="day_num';

      if (date('D', strtotime(date($this->active_year.'-'.$this->active_month.'-' . $i))) == 'Fri') {
        $html .= ' dangers  ';

      } else {
        $html .= ' successs ';
      }
      $html .= $selected . '">';
      $html .= '<span>' . $i . '</span>';

      // if(date('D',strtotime(date('Y-m-'.$i)))=='Fri'){
      //   $html .= '<div class="event red">';
      //             $html .= 'Default Holiday';
      //             $html .= '</div>';
      // };

      foreach ($this->events as $event) {
        for ($d = 0; $d <= ($event[2] - 1); $d++) {
          if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($event[1]))) {
            $html .= '<div class="event' . $event[3] . '">';
            $html .= $event[0];
            $html .= '</div>';
          }
        }
      }
      $html .= '</div>';
    }
    for ($i = 1; $i <= (42 - $num_days - max($first_day_of_week, 0)); $i++) {
      $html .= '
              <div class="day_num ignore">
                  ' . $i . '
              </div>
          ';
    }
    $html .= '</div>';
    $html .= '</div>';
    return $html;
  }
  
    public function getActiveYear()
  {
    return $this->active_year;
  }

  public function getActiveMonth()
  {
    return $this->active_month;
  }

}


function number_of_late_dayes($PBI_ID, $from, $to, $limittime)
{

  $select = 'SELECT bizid, xdate, MIN(xtime) as intime FROM `hrm_attdump` WHERE `bizid` = "' . $PBI_ID . '" and xdate BETWEEN "' . $from . '" and "' . $to . '" group BY xdate';
  $query = mysql_query($select);
  $lateTotal = 0;
  while ($rows = mysql_fetch_object($query)) {
    // echo $rows->bizid." - ".$rows->xdate." - ".$rows->intime.'<br>';

    // echo $rows->xdate.' '.$limittime." - ".strtotime($rows->xdate.' '.$limittime)." === ".$rows->intime. "-". strtotime($rows->intime)."<br>";
    $attLastTime = strtotime($rows->xdate . ' ' . $limittime);
    $punchTime = strtotime($rows->intime);
    if ($attLastTime <= $punchTime) {

      $lateTotal += 1;
    }
  }
  return $lateTotal;
}


function getWeekDays($start, $end, $weekday)
{
  $start = strtotime($start);
  $end = strtotime($end);

  $weekdays = array();

  while (date("w", $start) != $weekday) {
    $start += 86400;
  }

  while ($start <= $end) {
    $weekdays[] = date('Y-m-d', $start);
    $start += 604800;
  }

  return ($weekdays);
}




function total_work_on_holidays($PBI_ID, $from, $to)
{
  // Start Count Friday Holidays From s Years
  $toHoli = getWeekDays($from, $to, 5);
  // End Count Friday Holidays From s Years

  // End Calculate Holidays From Defined Holidays
  $selectHolidays = 'select * from hrm_defined_holiday where date between "' . $from . '" and "' . $to . '"';
  $holiquery = mysql_query($selectHolidays);
  $holls = "";
  while ($holi = mysql_fetch_object($holiquery)) {
    $holls[] = $holi->date;
  }
  // End Calculate Holidays From Defined Holidays
// Start Merge Array
  $mergedHolidays = array_merge($holls, $toHoli);
  // End Merge Array

  // Start select individual attandence from dump within a date range

  $foundholidaysWork = 0;
  $select = 'select xdate from hrm_attdump where bizid="' . $PBI_ID . '" and xdate between "' . $from . '" and "' . $to . '" group by xdate';
  $query = mysql_query($select);
  while ($rr = mysql_fetch_object($query)) {
    // echo $rr->xdate.'<br>';
    if (in_array($rr->xdate, $mergedHolidays)) {
      // echo "Match found";
      $foundholidaysWork += 1;
    }
    // else
//   {
//   echo "Match not found";
//   }
  }
  // End select individual attandence from dump within a date range

  return $foundholidaysWork;

}



function number_of_working_days($from, $to)
{
  $selectHolidays = 'select * from hrm_defined_holiday where date between "' . $from . '" and "' . $to . '"';
  $holiquery = mysql_query($selectHolidays);
  $holls = "";
  while ($holi = mysql_fetch_object($holiquery)) {
    $holls .= "'" . $holi->date . "',";
  }

  $workingDays = [1, 2, 3, 4, 6, 7]; # date format = N (1 = Monday, ...)
  //$holidayDays = ['2023-01-14','2023-01-28','2023-02-11','2023-02-25','2023-02-21','2023-03-08','2023-03-11','2023-03-25','2023-03-17','2023-04-08','2023-04-22','2023-04-23','2023-05-13','2023-05-27','2023-05-01','2023-06-10','2023-06-24','2023-06-28','2023-06-29','2023-06-30','2023-07-08','2023-07-22','2023-07-29','2023-08-12','2023-08-26','2023-08-15','2023-09-09','2023-09-23','2023-09-06','2023-09-28','2023-10-14','2023-10-28','2023-10-24','2023-11-11','2023-11-25','2023-12-09','2023-12-23','2023-12-16','2023-12-25',]; # variable and fixed holidays

  $holidayDays = array();
  $Dselect1 = 'select * from hrm_defined_holiday where YEAR(date) = "' . date('Y') . '"';
  $Dquery1 = mysql_query($Dselect1);
  while ($dRow1 = mysql_fetch_object($Dquery1)) {
    array_push($holidayDays, $dRow1->date);
  }


  $from = new DateTime($from);
  $to = new DateTime($to);
  $to->modify('+1 day');
  $interval = new DateInterval('P1D');
  $periods = new DatePeriod($from, $interval, $to);

  $days = 0;
  foreach ($periods as $period) {
    if (!in_array($period->format('N'), $workingDays))
      continue;
    if (in_array($period->format('Y-m-d'), $holidayDays))
      continue;
    if (in_array($period->format('*-m-d'), $holidayDays))
      continue;
    $days++;
  }
  return $days;
}
?>  

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="../../../dashboard_assets/morris/morris.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="../../../dashboard_assets/morris/morris.css"/>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>  </title>
   <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../../../../../public/dashboard_assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/main.min.css' rel='stylesheet' />


  
<style>

.wrapper {
    margin: 15px auto;
    max-width: 1100px;
}

.container-calendar {
    background: #ffffff;
    padding: 15px;
    max-width: 475px;
    margin: 0 auto;
    overflow: auto;
}

.button-container-calendar button {
    cursor: pointer;
    display: inline-block;
    zoom: 1;
    background: #00a2b7;
    color: #fff;
    border: 1px solid #0aa2b5;
    border-radius: 4px;
    padding: 5px 10px;
}

.table-calendar {
    border-collapse: collapse;
    width: 100%;
}

.table-calendar td, .table-calendar th {
    padding: 5px;
    border: 1px solid #e2e2e2;
    text-align: center;
    vertical-align: top;
}

.date-picker.selected {
    font-weight: bold;
    outline: 1px dashed #00BCD4;
}

.date-picker.selected span {
    border-bottom: 2px solid currentColor;
}

/* sunday */
.date-picker:nth-child(1) {
  color: red;
}

/* friday */
.date-picker:nth-child(6) {
  color: green;
}

#monthAndYear {
    text-align: center;
    margin-top: 0;
}

.button-container-calendar {
    position: relative;
    margin-bottom: 1em;
    overflow: hidden;
    clear: both;
}

#previous {
    float: left;
}

#next {
    float: right;
}

.footer-container-calendar {
    margin-top: 1em;
    border-top: 1px solid #dadada;
    padding: 10px 0;
}

.footer-container-calendar select {
    cursor: pointer;
    display: inline-block;
    zoom: 1;
    background: #ffffff;
    color: #585858;
    border: 1px solid #bfc5c5;
    border-radius: 3px;
    padding: 5px 1em;
}



     /* Custom styles */
        .calendar-card {
            margin-top: 20px;
        }

        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

.calendar-card, .card-body {
    overflow: visible;
}


  #onemounth{
  	height: 268px;
  
  }
  @media(max-width: 1200px) {
	  #onemounth{
		    height: 212px;
	  }
   }
   
     @media(max-width: 1400px) {
	  #onemounth{
		    height: 212px;
	  }
   }
   
   @media(max-width: 1500px) {
	  #onemounth{
		    height: 357px;
	  }
   }
  
  
  </style>
  
 <style>
  .calendar {
    display: flex;
    flex-flow: column;
    

  }

  .calendar .header .month-year {
    font-size: 22px;
    font-weight: bold;
    color: black;
    /* padding: 20px 0; */
    height: 50px;
  }

  .calendar .days {
    display: flex;
    flex-flow: wrap;

  }

  .calendar .days .day_name {
    width: calc(100% / 7);
    border-right: 1px solid #fff;
    padding: 5px;
    text-transform: uppercase;
    font-size: 12px;
    font-weight: bold;
    color: #818589;
    color: #fff;
    background-color: #5c0632;
  }

  .calendar .days .day_name:nth-child(7) {
    border: none;
  }

  .calendar .days .day_num {
    display: flex;
    flex-flow: column;
    width: calc(100% / 7);
    border-right: 1px solid #e6e9ea;
    border-bottom: 1px solid #e6e9ea;
    padding: 5px;
    font-weight: bold;
    color: #070707;
    cursor: pointer;
    min-height: 50px;
  }

  .calendar .days .day_num span {
    display: inline-flex;
    width: 30px;
    font-size: 14px;
  }

  .calendar .days .day_num .event {
    /* margin-top: 5px; */
    font-weight: 500;
    font-size: 10px;
    /* padding: 3px; */
    /* border-radius: 4px; */
    background-color: #f7c30d;
    /* color: #fff; */
    word-wrap: break-word;
  }

  .calendar .days .day_num .event.green {
    background-color: #51ce57;
  }

  .calendar .days .day_num .event.blue {
    background-color: #518fce;
  }

  .calendar .days .day_num .event.red {
    background-color: #FF0000;
    color: white;
  }

  .calendar .days .day_num:nth-child(7n+1) {
    border-left: 1px solid #e6e9ea;
  }

  .calendar .days .day_num:hover {
    background-color: #fdfdfd;
  }

  .calendar .days .day_num.ignore {
    background-color: #fdfdfd;
    color: #ced2d4;
    cursor: inherit;
  }

  .calendar .days .day_num.selected {
    background-color: #00D725;
    /* background-color: green; */
    /* color: white; */
    cursor: inherit;
  }

  .calendar .days .day_num.selected span {
    color: black !important;
  }

  /* .successs{
  background : #006400;
}

.successs span{
  color: white;
} */

  .dangers {
    background: #F5C9C9;
    color: red !important;
  }
</style>

</head>

<div class="content">
        <div class="container-fluid">
        <div class="row">
				
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats" style="border: 1px solid red;">
                <div class="card-header card-header-danger card-header-icon">
                 <div class="card-icon p-0"> <i class="fa-solid fa-calendar-days" style="color: #ffffff;"></i> </div>
                   <p class="card-category">365 DAy</p>
                   <h3 class="card-title font-siz"> <span id="localsales7day" class="loader">171</span> </h3>
                 </div>
                <div class="card-footer" style="border-top:1px solid red">
                <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">Total Working Days</h5>
                </div>
               </div>
              </div>
            </div>
			
			
			<div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats" style="border: 1px solid green;">
                <div class="card-header card-header-success card-header-icon">
                 <div class="card-icon p-0"> <i class="fa-solid fa-clipboard-user" style="color: #ffffff;"></i> </div>
                   <p class="card-category">30 DAy</p>
                   <h3 class="card-title font-siz"> <span id="localsales7day" class="loader">10</span> </h3>
                 </div>
                <div class="card-footer" style="border-top:1px solid green">
                <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">Total Attendence Days</h5>
                </div>
               </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats" style="border: 1px solid orange;">
                <div class="card-header card-header-info card-header-icon">
                 <div class="card-icon p-0"> <i class="fa-solid fa-clipboard-user" style="color: #ffffff;"></i> </div>
                   <p class="card-category">30 DAy</p>
                   <h3 class="card-title font-siz"> <span id="localsales7day" class="loader">9</span> </h3>
                 </div>
                <div class="card-footer" style="border-top:1px solid #06b0c5;">
                <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">Total Late Days</h5>
                </div>
               </div>
              </div>
            </div>
			
			  

            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats" style="border: 1px solid #1ec1d5;">
                <div class="card-header card-header-primary card-header-icon">
                 <div class="card-icon p-0"> <i class="fa-solid fa-eye" style="color: #ffffff;"></i> </div>
                   <p class="card-category">30 DAy</p>
                   <h3 class="card-title font-siz"> <span id="localsales7day" class="loader">0</span> </h3>
                 </div>
                <div class="card-footer" style="border-top:1px solid #1ec1d5">
                <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">Total Work on Holidays</h5>
                </div>
               </div>
              </div>
            </div>
			
			  <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats" style="border: 1px solid black;">
                <div class="card-header card-header-warning card-header-icon">
                 <div class="card-icon p-0"> <i class="fa-solid fa-eye" style="color: #ffffff;"></i> </div>
                   <p class="card-category">30 DAy</p>
                   <h3 class="card-title font-siz"> <span id="localsales7day" class="loader">1</span> </h3>
                 </div>
                <div class="card-footer" style="border-top:1px solid black">
                <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">Today Visited Page</h5>
                </div>
               </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats" style="border: 1px solid dark;">
                <div class="card-header card-header-dark card-header-icon">
                 <div class="card-icon p-0"> <i class="fa-solid fa-eye" style="color: #ffffff;"></i> </div>
                   <p class="card-category">30 DAy</p>
                   <h3 class="card-title font-siz"> <span id="localsales7day" class="loader">16</span> </h3>
                 </div>
                <div class="card-footer" style="border-top:1px solid dark;">
                <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">This Month Days of Logged In</h5>
                </div>
               </div>
              </div>
            </div>
			
			  <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats" style="border: 1px solid red;">
                <div class="card-header card-header-danger card-header-icon">
                 <div class="card-icon p-0"> <i class="fa-solid fa-eye" style="color: #ffffff;"></i> </div>
                   <p class="card-category">30 DAy</p>
                   <h3 class="card-title font-siz"> <span id="localsales7day" class="loader"> 48</span> </h3>
                 </div>
                <div class="card-footer" style="border-top:1px solid red">
                <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">Days Logged in Last 60 Days</h5>
                </div>
               </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats" style="border: 1px solid red;">
                <div class="card-header card-header-danger card-header-icon">
                 <div class="card-icon p-0"> <i class="fa-solid fa-eye" style="color: #ffffff;"></i> </div>
                   <p class="card-category">30 DAy</p>
                   <h3 class="card-title font-siz"> <span id="localsales7day" class="loader"> 334</span> </h3>
                 </div>
                <div class="card-footer" style="border-top:1px solid #ff6384;">
                <div class="stats m-0">
                    <h5 class="m-0 font-weight-bold">Total Days of Logged In</h5>
                </div>
               </div>
              </div>
            </div>
			
		</div>
		  
		  
   
<div class="row well">



  <div class="col-md-6 col-xs-12 text-center">

    <?php
    
    if(isset($_GET['prev_month'])){
        $curMonth = $_GET['prev_month'];
        $curYear = date('Y');
        $prevYear = $_GET['prev_year'];
        if(isset($_GET['next_month'])){
            $prevMonth = $_GET['next_month']-1;
             $prevYear = $_GET['next_year'];
        }else{
            $prevMonth = $curMonth-1;
        }
        if($prevMonth <= 0){
            $prevMonth = 12;
            $prevYear = date('Y')-1;
        }
    }
    
    if(isset($_GET['next_month'])){
        $curMonth = $_GET['next_month'];
        $curYear = date('Y');
        $nextYear = $_GET['next_year'];
        if(isset($_GET['prev_month'])){
            $nextMonth = $_GET['prev_month']+1;
            $nextYear = $_GET['prev_year'];
            
        }else{
            $nextMonth = $curMonth+1;
        }
        
        if($nextMonth > 12){
            $nextMonth = 1;
            $nextYear = date('Y') + 1;
        }
    }
    

    if(isset($_GET['prev_month']) || isset($_GET['next_month'])){
        $curDate = '01';
    }else{
        $curDate= date('d');
        
        $curYear = date('Y');
        $curMonth = date('m');

    }
    
    
    if(!isset($_GET['prev_month'])){
        $prevYear = date('Y');
        if(isset($_GET['next_month'])){
            $prevMonth = $_GET['next_month']-1;
            $prevYear = $_GET['next_year'];
        }else{
            $prevMonth = $curMonth-1;
        }
        if($prevMonth <= 0){
            $prevMonth = 12;
            $prevYear = date('Y')-1;
        }
    
    }
    
    
    if(!isset($_GET['next_month'])){
    
        $nextYear = date('Y');
        if(isset($_GET['prev_month'])){
            $nextMonth = $_GET['prev_month']+1;
            $nextYear = $_GET['prev_year'];
        }else{
            $nextMonth = $curMonth+1;
        }
        if($nexMonth > 12){
            $nextMonth = 1;
            $nextYear = date('Y') + 1;
        }
        
    }

    $calendar1 = new Calendar(date($curYear.'-'.$curMonth.'-'.$curDate));
    $Dselect1 = 'select * from hrm_defined_holiday where date between "' . date($curYear.'-'.$curMonth) . '-01" and "' . date($curYear.'-'.$curMonth) . '-31"';
    $Dquery1 = mysql_query($Dselect1);
    while ($dRow1 = mysql_fetch_object($Dquery1)) {

      $calendar1->add_event($dRow1->note, $dRow1->date, 1, 'red');
    }

    ?>
    <?= $calendar1 ?>

  <br>

  <?php if($prevYear==date('Y')){ ?>    
  <a href="home.php?prev_month=<?=$prevMonth?>&prev_year=<?=$prevYear?>&cal=#calEvent" class="btn btn-sm btn-info"><i class="fa fa-arrow-left"></i> Prev</a>
  <?php } ?>
  
  <?php if($nextYear==date('Y')){ ?>   
  <a href="home.php?next_month=<?=$nextMonth?>&next_year=<?=$nextYear?>&cal=#calEvent" class="btn btn-sm btn-info">Next <i class="fa fa-arrow-right"></i></a>
  <?php } ?>

  
  
  
  </div>
  <div class="col-md-6 col-xs-12">
    <h2 class="text-center" style="font-size:22px; font-weight:bold; color:black">Transaction History</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Ledger</th>
          <th>Debit</th>
          <th>Credit</th>
        </tr>
      </thead>

      <?php $tD = 0;
      $tC = 0; $tB = 0; ?>

      <tbody>

        <?php
        $a1Data = find_a_field('accounts_ledger a, personnel_basic_info p', 'a.ledger_name', 'p.pf_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
        if ($a1Data != '' && $a1Data != NULL) {
          ?>
          <tr>
            <td><a
                href="my_ledger_report.php?lg=<?= find_a_field('personnel_basic_info', 'pf_ledger', 'PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"') ?>">
                <?= $a1Data ?>
              </a></td>
            <th>
              <?php $a = find_a_field('journal a, personnel_basic_info p', 'sum(a.dr_amt)', 'p.pf_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($a > 0) {
                echo $a;
                $tD += $a;
              } else {
                echo '0.00';
              } ?>
              </td>
            <th>
              <?php $b = find_a_field('journal a, personnel_basic_info p', 'sum(a.cr_amt)', 'p.pf_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($b > 0) {
                echo $b;
                $tC += $b; 
              } else {
                echo '0.00';
              } ?>
              </td>
          </tr>
        <?php } ?>

        <?php
        $paC = 0.00;
        $paD = 0.00;
        $a2Data = find_a_field('accounts_ledger a, personnel_basic_info p', 'a.ledger_name', 'p.project_advance_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
        if ($a2Data != '' && $a2Data != NULL) {
          ?>
          <tr>
            <td><a
                href="my_ledger_report.php?lg=<?= find_a_field('personnel_basic_info', 'project_advance_ledger', 'PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"') ?>">
                <?= $a2Data ?>
              </a></td>
            <th>
              <?php $a = find_a_field('journal a, personnel_basic_info p', 'sum(a.dr_amt)', 'p.project_advance_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($a > 0) {
                echo number_format($a, 2);
                $tD += $a;
                $paD += $a;
              } else {
                echo '0.00';
              } ?>
              </td>
            <th>
              <?php $b = find_a_field('journal a, personnel_basic_info p', 'sum(a.cr_amt)', 'p.project_advance_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($b > 0) {
                echo number_format($b, 2);
                $tC += $b; $tB = $b;
                $paC += $b;
              } else {
                echo '0.00';
              } ?>
              </td>
          </tr>
        <?php } ?>

        <?php
        $aData = find_a_field('accounts_ledger a, personnel_basic_info p', 'a.ledger_name', 'p.salary_advance_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
        if ($aData != '' && $aData != NULL) {
          ?>
          <tr>
            <td><a
                href="my_ledger_report.php?lg=<?= find_a_field('personnel_basic_info', 'salary_advance_ledger', 'PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"') ?>">
                <?= $aData ?>
              </a></td>
            <th>
              <?php $a = find_a_field('journal a, personnel_basic_info p', 'sum(a.dr_amt)', 'p.salary_advance_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($a > 0) {
                echo number_format($a, 2);
                $tD += $a;
              } else {
                echo '0.00';
              } ?>
              </td>
            <th>
              <?php $b = find_a_field('journal a, personnel_basic_info p', 'sum(a.cr_amt)', 'p.salary_advance_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($b > 0) {
                echo number_format($b, 2);
                $tC += $b;
              } else {
                echo '0.00';
              } ?>
              </td>
          </tr>
        <?php } else {
          ?>
          <tr>
            <td>Salary Advance::</td>
            <td>0.00</td>
            <td>0.00</td>
          </tr>

        <?php } ?>


        <?php
        $eData = find_a_field('accounts_ledger a, personnel_basic_info p', 'a.ledger_name', 'p.salary_exp_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
        if ($eData != '' && $eData != NULL) {
          ?>
          <tr>
            <td><a
                href="my_ledger_report.php?lg=<?= find_a_field('personnel_basic_info', 'salary_exp_ledger', 'PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"') ?>">
                <?= $eData ?>
              </a></td>
            <td>
              <?php $a = find_a_field('journal a, personnel_basic_info p', 'sum(a.dr_amt)', 'p.salary_exp_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($a > 0) {
                echo $a;
                $tD += $a;
              } else {
                echo '0.00';
              } ?>
            </td>
            <td>
              <?php $b = find_a_field('journal a, personnel_basic_info p', 'sum(a.cr_amt)', 'p.salary_exp_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($b > 0) {
                echo $b;
                $tC += $b;
              } else {
                echo '0.00';
              } ?>
            </td>
          </tr>
        <?php } else { ?>

          <tr>
            <td>Salary Exp::</td>
            <td>0.00</td>
            <td>0.00</td>
          </tr>

        <?php } ?>







        <?php
        $bData = find_a_field('accounts_ledger a, personnel_basic_info p', 'a.ledger_name', 'p.tax_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
        if ($bData != '' && $bData != NULL) {
          ?>
          <tr>
            <td><a
                href="my_ledger_report.php?lg=<?= find_a_field('personnel_basic_info', 'tax_ledger', 'PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"') ?>">
                <?= $bData ?>
              </a></td>
            <td>
              <?php $a = find_a_field('journal a, personnel_basic_info p', 'sum(a.dr_amt)', 'p.tax_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($a > 0) {
                echo $a;
                $tD += $a;
              } else {
                echo '0.00';
              } ?>
            </td>
            <td>
              <?php $b = find_a_field('journal a, personnel_basic_info p', 'sum(a.cr_amt)', 'p.tax_ledger=a.ledger_id and p.PBI_ID="' . $_SESSION['user']['PBI_ID'] . '"');
              if ($b > 0) {
                echo $b; 
                $tC += $b; 
              } else {
                echo '0.00';
              } ?>
            </td>
          </tr>
        <?php } else { ?>

          <tr>
            <td>Tax::</td>
            <td>0.00</td>
            <td>0.00</td>
          </tr>

        <?php } ?>


      </tbody>

      <tfoot>
        <tr>
          <th>Total </th>
          <th>
            <?= number_format($tD, 2) ?>
          </th>
          <th>
            <?= number_format($tC, 2) ?>
          </th>
        </tr>

        <!--tr>
          <th></th>
          <?php if ($tD > $tB) { ?>
            <th>
              <?php echo '(Dr) ' . number_format(($tD - $tB), 2) ?>
            </th>
            <th></th>
          <?php } else if ($tD < $tB) { ?>
              <th></th>
              <th>
              <?php echo '(Cr) ' . number_format(($tB - $tD), 2) ?>
              </th>
          <?php } else { ?>
              <th></th>
              <th></th>
          <?php } ?>
        </tr-->
        
        <tr>
            <th>Project Advance Summary</th>
            <th colspan="2" class="text-center"><?=number_format($paD-$paC, 2)?><?=$paD>=$paC?'(Dr)':'(Cr)'?></th>
        </tr>
      </tfoot>

    </table>
  </div>

</div>

<div class="row well">


  <div class="col-md-6 col-xs-12">

    <h2 class="text-center calendar" style="font-size:22px; font-weight:bold; color:black;">Pay Slip</h2>
    <form action="./downloadpdf.php" method="post" target="_blank" class="well">
      <div class="form-group">
        <label>Month : </label>
        <select name="mon" id="mon" class="form-control" required>
          <option value="">Select Month</option>
          <option value="1">January</option>
          <option value="2">Fabruary</option>
          <option value="3">March</option>
          <option value="4">April</option>
          <option value="5">May</option>
          <option value="6">June</option>
          <option value="7">July</option>
          <option value="8">August</option>
          <option value="9">September</option>
          <option value="10">October</option>
          <option value="11">November</option>
          <option value="12">December</option>
        </select>
      </div>

      <div class="form-group">
        <label>Year : </label>
        <select name="year" id="year" class="form-control" required>

          <option value="">Select Year</option>
          <option value="2019">2019</option>
          <option value="2020">2020</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
          <option value="2023">2023</option>
          <option value="2024">2024</option>
          <option value="2025">2025</option>
        </select>
      </div>
      <br>

      <div class="form-group text-center">
        <input type="submit" class="btn" value="GET PAYSLIP"
          style="background-color:#5c0632; color:white; padding:4px 12px 2px 12px!important;">
      </div>

    </form>

  </div>
  <div class="col-md-6 col-xs-12">
    <h2 class="text-center" style="font-size:22px; font-weight:bold; color:black;">Login Activity Feed</h2>
    <div class="activity-feed">
      <!-- <div class="feed-item">
    <div class="date">Sep 25</div>
    <div class="text">Responded to need <a href="single-need.php">“Volunteer opportunity”</a></div>
  </div> -->

      <?
      $fedsel = 'select * from login_activity_log where PBI_ID="' . $_SESSION['user']['PBI_ID'] . '" order by date desc limit 3';
      $fedquer = mysql_query($fedsel);
      while ($fedRow = mysql_fetch_object($fedquer)) {

        ?>
        <div class="feed-item">

          <div class="date">
            <?= date("d M Y H:i:s a", strtotime($fedRow->entry_at)) ?>
          </div>
          <div class="text">Last Logged in. </div>
        </div>
      <?
      }

      ?>


    </div>
  </div>


</div>


<div class="row">
  <div class="col-md-12 col-xs-12 text-center">
    <br>
    <br>
    <!-- <h1 class="style1">Welcome To  <br> User Module</h1> -->
    <a href="../attendence/daily_attendance.php" class="btn" style="background-color:#5c0632; color:white;">Click here
      For Putting Attendance</a>
  </div>
</div>

    



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>

<script>
  (function ($) {
    $.fn.countTo = function (options) {
      options = options || {};

      return $(this).each(function () {
        // set options for current element
        var settings = $.extend({}, $.fn.countTo.defaults, {
          from: $(this).data('from'),
          to: $(this).data('to'),
          speed: $(this).data('speed'),
          refreshInterval: $(this).data('refresh-interval'),
          decimals: $(this).data('decimals')
        }, options);

        // how many times to update the value, and how much to increment the value on each update
        var loops = Math.ceil(settings.speed / settings.refreshInterval),
          increment = (settings.to - settings.from) / loops;

        // references & variables that will change with each update
        var self = this,
          $self = $(this),
          loopCount = 0,
          value = settings.from,
          data = $self.data('countTo') || {};

        $self.data('countTo', data);

        // if an existing interval can be found, clear it first
        if (data.interval) {
          clearInterval(data.interval);
        }
        data.interval = setInterval(updateTimer, settings.refreshInterval);

        // initialize the element with the starting value
        render(value);

        function updateTimer() {
          value += increment;
          loopCount++;

          render(value);

          if (typeof (settings.onUpdate) == 'function') {
            settings.onUpdate.call(self, value);
          }

          if (loopCount >= loops) {
            // remove the interval
            $self.removeData('countTo');
            clearInterval(data.interval);
            value = settings.to;

            if (typeof (settings.onComplete) == 'function') {
              settings.onComplete.call(self, value);
            }
          }
        }

        function render(value) {
          var formattedValue = settings.formatter.call(self, value, settings);
          $self.html(formattedValue);
        }
      });
    };

    $.fn.countTo.defaults = {
      from: 0,               // the number the element should start at
      to: 0,                 // the number the element should end at
      speed: 1000,           // how long it should take to count between the target numbers
      refreshInterval: 100,  // how often the element should be updated
      decimals: 0,           // the number of decimal places to show
      formatter: formatter,  // handler for formatting the value before rendering
      onUpdate: null,        // callback method for every time the element is updated
      onComplete: null       // callback method for when the element finishes updating
    };

    function formatter(value, settings) {
      return value.toFixed(settings.decimals);
    }
  }(jQuery));

  jQuery(function ($) {
    // custom formatting example
    $('.count-number').data('countToOptions', {
      formatter: function (value, options) {
        return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
      }
    });

    // start all the timers
    $('.timer').each(count);

    function count(options) {
      var $this = $(this);
      options = $.extend({}, options || {}, $this.data('countToOptions') || {});
      $this.countTo(options);
    }
  });
</script>