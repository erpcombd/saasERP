<?php



session_start();

include 'config/db.php';

include 'config/function.php';

include 'config/access.php';

$user_id	=$_SESSION['user_id'];



$page="home";



include "inc/header.php";



?>



<div class="main-container container">




<? 


$u_id= $_SESSION['user_id']; //$_SESSION['user']['id'];
$PBI_ID = find_a_field('user_activity_management','PBI_ID','user_id='.$u_id);

$currentMonth = date("m");
$currentYear = date("Y");

$attedance = find_all_field('hrm_attendence_final','','PBI_ID="'.$PBI_ID.'" and mon="'.$currentMonth.'" and year="'.$currentYear.'"');

$basic = find_all_field('personnel_basic_info','','PBI_ID="'.$PBI_ID.'"');

?>


<?  

// *********  DISTANCE CALCULATION FUNCTION STRAT ***********

$damp = find_all_field('hrm_attdump','','EMP_CODE="'.$PBI_ID.'" and xdate="'.date('Y-m-d').'"');


function Distance($lat1, $lon1, $lat2, $lon2, $unit) {
  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}



$lat1 = $damp->latitude; //"23.791166";
$lon1 = $damp->longitude;  //"90.4082562";

$lat2 = $damp->sch_latitude_point;  //"23.8289778";
$lon2 = $damp->sch_longitude_point;  //"90.3637915";
$unit = "K";

$distance = Distance($lat1, $lon1, $lat2, $lon2, $unit);

// *********  DISTANCE CALCULATION FUNCTION END ***********


?>

<?

/*
 $leave_sql="SELECT l.*,a.PBI_NAME as Employee_Name,a.PBI_CODE,(select DEPT_DESC from department where DEPT_ID=a.DEPT_ID) as department

 FROM hrm_att_summary l, personnel_basic_info a where   a.PBI_ID=l.emp_id ".$pbi_con." order by l.emp_id,l.att_date asc";



 $leave_query=db_query($leave_sql);

 while($data = mysqli_fetch_object($leave_query)){


$val[$data->att_date]['in_time'] = $data->in_time;

$val[$data->att_date]['out_time'] = $data->out_time;

$val[$data->att_date]['sch_in_time'] = $data->sch_in_time;

$val[$data->att_date]['sch_out_time'] = $data->sch_out_time;

$val[$data->att_date]['iom'] = $data->iom_sl_no	;

$val[$data->att_date]['leave'] = $data->leave_id;

$val[$data->att_date]['dayname'] = $data->dayname;
$val[$data->att_date]['iom_start_time'] = $data->iom_start_time;
$val[$data->att_date]['iom_total_hrs'] = $data->iom_total_hrs;
$total_overtime += $data->over_time_hour;

//office time

$sac_formated = date("H:i",strtotime($data->sch_in_time));

$punch_outtimes= date("H:i",strtotime($data->out_time));

//od start time

$od_start_timee = date("h:i",strtotime($data->od_start_time));

//iom start time

$sort_leave_start_timee = date("h:i",strtotime($data->iom_start_time));

$val[$data->att_date]['final_late_min'] = $data->final_late_min;

$val[$data->att_date]['late_min'] = $data->late_min;

$val[$data->att_date]['final_late_status'] = $data->final_late_status;

$val[$data->att_date]['grace_no'] = $data->grace_no;

$val[$data->att_date]['holyday'] = $data->holyday;



if($data->leave_id>0)

$val[$data->att_date]['final_status'] = 'LEAVE';

elseif( $data->in_time=='' && $data->leave_id==0 && $data->od_id==0 && $data->iom_sl_no==0 )

$val[$data->att_date]['final_status'] = 'Absent';

elseif($data->final_early_status>0)

$val[$data->att_date]['final_status'] = 'Early Out';



elseif( $data->final_late_status>0)

$val[$data->att_date]['final_status'] = 'LATE';



elseif( $data->final_late_status>0 && $data->final_early_status>0)

$val[$data->att_date]['final_status'] = 'LateEarlyOut';

elseif($data->final_late_status>0 && $data->iom_sl_no>0 && $sort_leave_start_timee < $sac_formated )

$val[$data->att_date]['final_status'] = 'SHL';

elseif($data->holyday>0)

$val[$data->att_date]['final_status'] = 'HOLIDAY';

elseif($data->dayname=='Friday')

$val[$data->att_date]['final_status'] = 'HOLIDAY';

elseif($data->final_late_status>0||$data->final_late_min>0)

$val[$data->att_date]['final_status'] = 'LATE';

elseif($data->id>0)

$val[$data->att_date]['final_status'] = 'PRESENT';



$dteStart = new DateTime($data->in_time);

$dteEnd   = new DateTime($data->out_time);

$dteDiff  = $dteStart->diff($dteEnd);



  }
  
  
$start_date = $_POST['fdate'];
$end_date = $_POST['tdate'];


$begin = new DateTime($start_date);

 //$end = new DateTime($end_date);
$start = new DateTimeImmutable($end_date);
$end = $start->modify('+1 day');

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ( $period as $dt ){
++$days;

$this_date = $dt->format( "Ymd" );
$day_date = $dt->format( "Y-m-d" );

$holysql = "select * from salary_holy_day where holy_day = '".$day_date."'";

	$holy_query = db_query($holysql);

	$holy = mysqli_fetch_object($holy_query);

	$holy_reson=$holy->reason;

	$val[$day_date]['grace_no'];



	if($holy>0){

	$bgcolor = '#E2E3E5';

	$val[$day_date]['final_status']= $holy_reson;

	$public_holy++;

	}



	elseif($dt->format("l")=='Friday')

	{$bgcolor = '#E2E3E5';$off_days++;}



	elseif($val[$day_date]['final_status']=='LEAVE')

	{$bgcolor = '#D1ECF1'; $leave++;}



	elseif($dt->format("l")=='Friday')

	{$bgcolor = '#CCCCCC';$off_days++;}



	elseif($val[$day_date]['final_status']=='SHL')

	{$bgcolor = '#D5D6EA'; $shl++;}



	elseif($val[$day_date]['final_status']=='OD')

	$bgcolor = '#9FE2BF';



	elseif($val[$day_date]['final_status']=='Early Out')

	{$bgcolor = '#FCF2CD'; $early++;}



  elseif($val[$day_date]['final_status']=='LateEarlyOut')

	{$bgcolor = '#FAF884'; $late_early++;}



	elseif($val[$day_date]['final_status']=='ABSENT')

	{$bgcolor = '#EA6F5A'; $absent_leave_ck++;}



	elseif($val[$day_date]['final_status']=='LATE')

	{$bgcolor = '#FAF884';$late++;$late_min_total = $late_min_total + $val[$day_date]['final_late_min'];}





	elseif($val[$day_date]['final_status']=='PRESENT')

	{$bgcolor = '#9ED7D1';$regular++;}



	else

	{$bgcolor = '#EA6F5A';  $regular++; $absent++;

	$val[$day_date]['final_status']='ABSENT';

	} */




?>
<style>


hr {
    border-top: 1px solid #007bff;
    width:70%;
}

a {color: #000;}


.card{
    background-color: #FFFFFF;
    padding:0;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius:4px;
    box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.3);
}


.card:hover{
    box-shadow: 0 16px 24px 2px rgba(0,0,0,0.14), 0 6px 30px 5px rgba(0,0,0,0.12), 0 8px 10px -5px rgba(0,0,0,0.3);
    color:black;
}

address{
  margin-bottom: 0px;
}




#author a{
  color: #fff;
  text-decoration: none;
    
}



.my-card
{
    position:absolute;
    left:40%;
    top:-20px;
    border-radius:50%;
}

</style>

     
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

 


<!-- 1st Baner info -->

<div class="row  text-white">

                <div class="col bg-theme align-self-center">

                    <div class="text-center py-4">

                        <h4 class="mb-0"><span class="countertext"><?=$attedance->pre;?></span></h4>
						
					

                        <p class="small">Total Present</p>

                    </div>

                </div>



                <div class="col bg-theme3 align-self-center">

                    <div class="text-center py-4">

                        <h4 class="mb-0"><span class="countertext"><?=$attedance->ab?></span></h4>

                        <p class="small">Total Absent</p>

                    </div>

                </div>

            </div>

            











<!-- 2nd Baner info -->




 







<div class="row text-white">

                <div class="col bg-theme1 align-self-center">

                    <div class="text-center py-4">

                        <h4 class="mb-0"><span class="countertext"><?=$attedance->lt?></span></h4>

                        <p class="small">Total Late</p>

                    </div>

                </div>



                <div class="col bg-theme2 align-self-center">

                    <div class="text-center py-4">

                        <h4 class="mb-0"><span class="countertext"><?=$attedance->lv?></span></h4>

                        <p class="small">Total leave</p>

                    </div>

                </div>

            </div>


<div class="container-fluid">
  <div class="row">
  
  
  
  <div class="col-lg-12 mt-5">
      <div class="card text-center">
        
        <div class="card-body">
          <h5 class="card-title">CURRENT LOCATION</h5>
          <hr>

  <body onLoad="getLocation()">
    <iframe id="map" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
  </body>
        </div>
        
      </div>
    </div>
  
  
	
	
	
  </div>
</div>




<?php /*?><div class="container-fluid">
  <div class="row">
  
  
  
  <div class="col-lg-6 mt-5">
      <div class="card text-center">
        
        <div class="card-body">
          <h5 class="card-title">SCHEDULE MAP</h5>
          <hr>
		  
		  <?  
		  
		        $sac_latitute =  find_a_field('hrm_attdump','sch_latitude_point','EMP_CODE="'.$PBI_ID.'" and xdate="'.date('Y-m-d').'"'); 
				$sac_longitude = find_a_field('hrm_attdump','sch_longitude_point','EMP_CODE="'.$PBI_ID.'" and xdate="'.date('Y-m-d').'"'); 
		  
		  ?>
       
		   
		   <iframe src="https://maps.google.com/maps?q=<?php echo $sac_latitute; ?>,<?php echo $sac_longitude; ?>&z=15&output=embed" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>


<!--          <a href="https://goo.gl/maps/drPW7JdCdy62"><address class="font-italic">Piazza del Colosseo, 1, 00184 Roma RM</address></a>-->
        </div>
        
      </div>
    </div>
  
  <div class="col-lg-6 mt-5">
      <div class="card text-center">
        
        <div class="card-body">
          <h5 class="card-title">ATTENDANCE MAP</h5>
          <hr>
		  
		  <?  
		  
		        $latitute =  find_a_field('hrm_attdump','latitude','EMP_CODE="'.$PBI_ID.'" and xdate="'.date('Y-m-d').'"'); 
				$longitude = find_a_field('hrm_attdump','longitude','EMP_CODE="'.$PBI_ID.'" and xdate="'.date('Y-m-d').'"'); 
		  
		  ?>
       
		   
		   <iframe src="https://maps.google.com/maps?q=<?php echo $latitute; ?>,<?php echo $longitude; ?>&z=15&output=embed" width="100%" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>


<!--          <a href="https://goo.gl/maps/drPW7JdCdy62"><address class="font-italic">Piazza del Colosseo, 1, 00184 Roma RM</address></a>-->
        </div>
        
      </div>
    </div>
	
	
	
  </div>
</div><?php */?>
<br>


<!--<div class="container-fluid">
  <div class="row">

<div class="jumbotron">
<div class="row w-100">
        <div class="col-md-3">
            <div class="card border-info mx-sm-1 p-3">
                <div class="card border-info shadow text-info p-3 my-card" ><span class="fa fa-car" aria-hidden="true"></span></div>
                <div class="text-info text-center mt-3"><h4>Deffine She</h4></div>
                <div class="text-info text-center mt-2"><h1>234</h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success mx-sm-1 p-3">
                <div class="card border-success shadow text-success p-3 my-card"><span class="fa fa-eye" aria-hidden="true"></span></div>
                <div class="text-success text-center mt-3"><h4>Eyes</h4></div>
                <div class="text-success text-center mt-2"><h1>9332</h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger mx-sm-1 p-3">
                <div class="card border-danger shadow text-danger p-3 my-card" ><span class="fa fa-heart" aria-hidden="true"></span></div>
                <div class="text-danger text-center mt-3"><h4>Hearts</h4></div>
                <div class="text-danger text-center mt-2"><h1>346</h1></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning mx-sm-1 p-3">
                <div class="card border-warning shadow text-warning p-3 my-card" ><span class="fa fa-inbox" aria-hidden="true"></span></div>
                <div class="text-warning text-center mt-3"><h4>Inbox</h4></div>
                <div class="text-warning text-center mt-2"><h1>346</h1></div>
            </div>
        </div>
     </div>
</div>


</div></div>-->

<br>


<div class="row mt-3">




<div class="col-12">





    <div class="card1 shadow-sm mb-3">

           <div class="text-center pb-1 pt-1 bg-color"><h4>Basic Information</h4></div>

            <ul class="list-group list-group-flush bg-none">

            <li class="list-group-item border-0">

                <div class="row">





                    <div class="col px-0">

                        <table  style="margin: 0 auto;">

                            <thead>

                                <tr>

                                    <th></th>

                                    <th></th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>ID</td>

                                    <td>: <?=$basic->PBI_CODE;?></td>

                                </tr>



                                <tr>

                                    <td>Name</td>

                                    <td>: <?=$basic->PBI_NAME;?></td>

                                </tr>



                                <tr>

                                    <td>Designation</td>

                                    <td>: <?=$basic->PBI_DESIGNATION;?> </td> 

                                </tr>



                                <tr>

                                    <td>Department</td>

                                    <td>: <?=$basic->PBI_DEPARTMENT;?></td>

                                </tr>



                                <tr>

                                    <td>Joining Date</td>

                                    <td>: <?=$basic->PBI_DOJ;?> </td>

                                </tr>



                                <tr>

                                    <td>Service Length</td>

                                    <td>: <?
								$ddd = date("Y-m-d");	
							    $date1 = new DateTime($basic->PBI_DOJ);
								$date2 = new DateTime($ddd); 
								$diff = $date1->diff($date2);
								
								echo $diff->y . " years, " . $diff->m . " months, " . $diff->d . " days";
									
									
									?> </td>

                                </tr>



                                <tr>

                                    <td>Incharge</td>

                                    <td>: <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$basic->incharge_id.'"');?> </td>

                                </tr>



                            </tbody>

                        </table>

<!--                        <p class="mb-0"><stong>ID :</stong> 0000</p>-->

<!--						<p class="mb-0"><stong>Name :</stong>  Md. Sarwar Jahan</p>-->

<!--                        <p class="mb-0"><small class="text-secondary">hii <br>--><?//=$data->mobile?><!--</small></p>-->

<!--                        <p><small class="text-secondary">--><?//=$data->designation;?><!-- </small></p>-->



                    </div>

                </div>

            </li>

    

        </ul>

         

    </div>





    <div class="card1 shadow-sm mb-3" style="min-height: 200px;">

           <div class="text-center pb-1 pt-1 bg-color-notice"><h4>Notice Board</h4></div>

            <ul class="list-group list-group-flush bg-none">

            <li class="list-group-item border-0">

                <div class="row">



                    <div class="col px-0">

                        <p class="p-2"> Notice Titel <?  echo $distance;?></br>

                        <small class="text-secondary">Notice Text</small>

                        </p>





                    </div>

                </div>

            </li>



        </ul>



    </div>






<? 

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

$leave_rule = find_all_field('hrm_leave_rull_manage','','1');

$lv_days_casual =find_a_field('hrm_leave_info','sum(total_days)','type=1 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type=2 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type=3 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
$leave_days_marrige=find_a_field('hrm_leave_info','sum(total_days)','type=4 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
$leave_days_maternity=find_a_field('hrm_leave_info','sum(total_days)','type=5 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
$leave_days_paternity=find_a_field('hrm_leave_info','sum(total_days)','type=6 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
$leave_days_Hajj=find_a_field('hrm_leave_info','sum(total_days)','type=7 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
$leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Short Leave (SHL)" and leave_status="Granted" and half_leave_date>="'.$g_s_date.'" and 
half_leave_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);
$leave_days_EOL=find_a_field('hrm_leave_info','sum(total_days)','type=8 and leave_status="GRANTED" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$basic->PBI_ID);


?>


    <div class="card1 shadow-sm mb-3">

           <div class="text-center pb-1 pt-1 bg-color"><h4>Individual Leave Status 2023</h4></div>

            <ul class="list-group list-group-flush bg-none">

            <li class="list-group-item border-0">

                <div class="row">

                    <div class="col px-0">

                        <table class="table1  table-striped table-bordered table-hover table-sm" style="margin: 0 auto;">

                            <thead class="thead1 bold">

                                <tr class="bgc-info">

                                    <th> Type </th>

                                    <th> Casual Leave (CL) </th>

                                    <th> Sick Leave (SL) </th>

                                    <th> Annual Leave (AL) </th>

                                    <th> Extra Ordinary Leave (EOL) </th>

                                </tr>

                            </thead>

                            <tbody class="tbody1">



                                <tr>

                                    <td>Entitlement</td>

                                    <td><?=$leave_rule->CL?></td>

                                    <td><?=$leave_rule->MED?></td>

                                    <td><?=$leave_rule->ANU?></td>

                                    <td> As per Management Approval</td>

                                </tr>



                                <tr>

                                    <td>Availed</td>

                                    <td><?=$lv_days_casual;?></td>

                                    <td><?=$leave_days_sick;?></td>

                                    <td><?=$leave_days_annual;?></td>

                                    <td> </td>

                                </tr>



                                <tr>

                                    <td>Balance</td>

                                    <td><?=$leave_rule->CL-$lv_days_casual;?></td>

                                    <td><?=$leave_rule->MED-$leave_days_sick;?></td>

                                    <td><?=$leave_rule->ANU-$leave_days_annual;?></td>

                                    <td> </td>

                                </tr>







                            </tbody>

                        </table>

<!--                        <p class="mb-0"><stong>ID :</stong> 0000</p>-->

<!--						<p class="mb-0"><stong>Name :</stong>  Md. Sarwar Jahan</p>-->

<!--                        <p class="mb-0"><small class="text-secondary">hii <br>--><?//=$data->mobile?><!--</small></p>-->

<!--                        <p><small class="text-secondary">--><?//=$data->designation;?><!-- </small></p>-->



                    </div>

                </div>

            </li>



        </ul>



    </div>




   <script>
      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition);
        } else { 
          alert("Geolocation is not supported by this browser.");
        }
      }
      function showPosition(position) {
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;
        var mapSrc = "https://maps.google.com/maps?q=" + lat + "," + lon + "&z=17&output=embed";
        document.getElementById("map").src = mapSrc;
      }
    </script>




</div>



</div> 



<!--sk-->





</div> 












<?php /*?>
<?php 

$sql_t = "select s.* from ss_shop s where 1 order by market_id";

$query2=db_query($conn, $sql_t);

while($data2=mysqli_fetch_object($query2)){

?> 
                               
<?=$data2->dealer_code?>">
<?=$data2->shop_name?>(<?=$data2->dealer_code?>
<?=$data2->shop_owner_name?> - <?=$data2->mobile?></p>
<?php } ?>                                
<?php */?>
                   





<?php include "inc/footer.php"; ?>