<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//date_default_timezone_set('Asia/Dhaka');
$title="Machine Data Sync (General)";
do_calander('#m_date');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$table='hrm_inout';
$unique='id';



/*echo "<script>
        $(document).ready(function() {
            // Trigger form submission after 50 seconds
            setTimeout(function() {
                document.getElementById('button-addon1').click();
            }, 3600000); // 50 seconds in milliseconds
        });
      </script>";*/



if(isset($_POST["upload"]))
{

if($_POST['s_date']!='' && $_POST['e_date']!=''){
$start_date = date('Y-m-d',strtotime($_POST['s_date']));
$end_date = date('Y-m-d',strtotime($_POST['e_date']));

$date_con = " and h.xdate BETWEEN '".$start_date."' AND '".$end_date."'";
}


$sql = 'select * from hrm_schedule_info';

$query  =db_query($sql);

while($data=mysqli_fetch_object($query)){



    $sch_start[$data->id] = $data->office_start_time;



    $sch_end[$data->id] = $data->office_end_time;



    $sch_mid[$data->id] = $data->office_mid_time;



}



// Roster Schedule Fetch All
$sql = "select * from hrm_roster_allocation where roster_date  BETWEEN '".$start_date."' AND '".$end_date."' ";
$query  =db_query($sql);
while($data=mysqli_fetch_object($query)){
    $roster_assign[$data->PBI_ID][$data->roster_date] = $data->shedule_1;
}
$datetime = date('Y-m-d H:i:s');


$emp_id = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['emp_id'].'"');


//if($_POST['emp_id']>0) 	$emp_id=$_POST['emp_id'];


$PBI_ORG = $_POST['PBI_ORG'];


if($_POST['JOB_LOCATION']>0) $job_location_con = " and p.JOB_LOC_ID='".$_POST['JOB_LOCATION']."'";


if($_POST['department']>0) $department_con = " and p.DEPT_ID='".$_POST['department']."'";

$PBI_ORG = $_POST['PBI_ORG'];


if($PBI_ORG>0) $ORG_con = " and p.PBI_ORG='".$PBI_ORG."'";



//if($emp_id > 0) $emp_id_con=" and p.PBI_ID IN (".$emp_id.")";

if($_POST['emp_id']>0) $emp_id_con = " and p.PBI_ID='".$_POST['emp_id']."'";


if($_POST['roster_type']=='Regular'){

echo  $sql="SELECT h.EMP_CODE , h.xdate as roster_date , min(h.xtime) in_time, max(h.xtime) out_time,p.define_schedule,p.PBI_ID



FROM hrm_attdump h, personnel_basic_info p



WHERE  h.EMP_CODE = p.PBI_ID and p.schedule_type='Regular'  ".$date_con.$emp_id_con.$job_location_con.$ORG_con.$department_con."



GROUP BY h.EMP_CODE , h.xdate";



}

else{
    
 $sql="SELECT EMP_CODE,a.roster_date,min(d.xtime) in_time,max(d.xtime) out_time,a.shedule_1,p.schedule_type,p.PBI_ID

FROM hrm_attdump d, hrm_roster_allocation a , hrm_schedule_info s,personnel_basic_info p

WHERE  a.PBI_ID=p.PBI_ID and  d.EMP_CODE=a.PBI_ID and  d.xdate in (d.xdate,DATE_ADD(d.xdate, INTERVAL 1 DAY)) and  a.roster_date between '".$start_date."' and '".$end_date."' and shedule_1=s.id and  

d.xtime between   DATE_ADD(concat(a.roster_date,' ',s.office_start_time), INTERVAL ".min_in." HOUR) and DATE_ADD(concat(a.roster_date,' ',s.office_end_time), INTERVAL ".max_out." HOUR) and p.schedule_type='Roster' ".$job_location_con.$emp_id_con.$department_con." group by a.PBI_ID,a.roster_date";



}

$query = db_query($sql);

while($data = mysqli_fetch_object($query))

	{



	if($roster_assign[$data->PBI_ID][$data->roster_date]<1){



	$value[$data->PBI_ID][$data->roster_date]['sch_in_time']  = $office_in_times  = $sch_start[$data->define_schedule];
	$value[$data->PBI_ID][$data->roster_date]['sch_mid_time']  = $office_mid_times  = $sch_mid[$data->define_schedule];
    $value[$data->PBI_ID][$data->roster_date]['sch_id']  = $data->define_schedule;  

	}

	else { 
	
	$value[$data->PBI_ID][$data->roster_date]['sch_in_time']  = $office_in_times  = $sch_start[$roster_assign[$data->PBI_ID][$data->roster_date]];
	$value[$data->PBI_ID][$data->roster_date]['sch_mid_time']  = $office_mid_times  = $sch_mid[$data->define_schedule];
	$value[$data->PBI_ID][$data->roster_date]['sch_id'] = $data->shedule_1;  
	
	
	}



	if($roster_assign[$data->PBI_ID][$data->roster_date]<1){



	$value[$data->PBI_ID][$data->roster_date]['sch_out_time'] = $office_out_times = $sch_end[$data->define_schedule];
	$value[$data->PBI_ID][$data->roster_date]['sch_mid_time'] = $office_mid_times = $sch_mid[$data->define_schedule];

	}

	else { 
	
	$value[$data->PBI_ID][$data->roster_date]['sch_out_time']  = $office_in_times  = $sch_end[$roster_assign[$data->PBI_ID][$data->roster_date]];
	$value[$data->PBI_ID][$data->roster_date]['sch_mid_time']  = $office_mid_times  = $sch_mid[$roster_assign[$data->PBI_ID][$data->roster_date]];


}
	$value[$data->PBI_ID][$data->roster_date]['emp_id'] = $data->EMP_CODE;

    $value[$data->PBI_ID][$data->roster_date]['att_date'] = $data->roster_date;
    
    $value[$data->PBI_ID][$data->roster_date]['in_time'] = $data->in_time;

	if($data->in_time!=$data->out_time)

    $value[$data->PBI_ID][$data->roster_date]['out_time'] = $data->out_time;
   
     

	$value[$data->PBI_ID][$data->roster_date]['in_time'];



	}

$start = strtotime( $_POST['s_date'] );



$end = strtotime( $_POST['e_date'] );







$sqll = "SELECT  p.PBI_ID 

FROM personnel_basic_info p

WHERE 1 and p.schedule_type='".$_POST['roster_type']."' ".$emp_id_con.$job_location_con.$ORG_con;



$queryy = db_query($sqll);







while($datas=mysqli_fetch_object($queryy)){







for ( $i = $start; $i <= $end; $i = $i + 86400 ) {



  		 $thisDate = date( 'Y-m-d', $i );



		



		 $found = find_a_field('hrm_att_summary','1','emp_id="'.$datas->PBI_ID.'" and att_date="'.$thisDate.'" ');



		



		if($found==0)







			{





$sql="INSERT INTO hrm_att_summary 

(emp_id, att_date, in_time, out_time, dayname,sch_in_time,sch_mid_time,sch_out_time,sch_id)
VALUES 

('".$datas->PBI_ID."','".$thisDate."', '".$value[$datas->PBI_ID][$thisDate]['in_time']."','".$value[$datas->PBI_ID][$thisDate]['out_time']."',dayname('".$thisDate."'), 
'".$value[$datas->PBI_ID][$thisDate]['sch_in_time']."','".$value[$datas->PBI_ID][$thisDate]['sch_mid_time']."',
'".$value[$datas->PBI_ID][$thisDate]['sch_out_time']."',

'".$value[$datas->PBI_ID][$thisDate]['sch_id']."')";







				$query=db_query($sql);







			}



			



		else{



		



			 $sql='update hrm_att_summary set 







in_time="'.$value[$datas->PBI_ID][$thisDate]['in_time'].'", out_time="'.$value[$datas->PBI_ID][$thisDate]['out_time'].'", sch_in_time="'.$value[$datas->PBI_ID][$thisDate]['sch_in_time'].'",sch_mid_time="'.$value[$datas->PBI_ID][$thisDate]['sch_mid_time'].'",

sch_out_time="'.$value[$datas->PBI_ID][$thisDate]['sch_out_time'].'", sch_id="'.$value[$datas->PBI_ID][$thisDate]['sch_id'].'" 



where  emp_id="'.$datas->PBI_ID.'" and att_date="'.$thisDate.'" ';







				$query=db_query($sql);



		



		}



		



		



		



		



		}







}















































$msz = 'Machine Data Sync Complete';



}



















?>

<style type="text/css">















<!--















.style1 {font-size: 24px}















.style2 {















	color: #FF66CC;















	font-weight: bold;















}















-->















</style>




<form action=""  method="post" enctype="multipart/form-data">

<? if($msz!=""){ ?>

<div class="alert alert-success" role="alert">

  <?=$msz;?>

</div>

<? }?>

  <div class="d-flex justify-content-center">

    <div class="n-form1 fo-width pt-0">

      <h4 class="text-center bg-titel bold pt-2 pb-2"> Collect Machine Data Factory </h4>

      <div class="container-fluid p-0">

        <div class="row">

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

            <div class="form-group row  m-0 mb-1 pl-3 pr-3">

              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code : </label>

              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

           
				
										  
           <input type="text"  list='eip_ids' name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" autocomplete="off" />
                <datalist id='eip_ids'>
                  <option></option>
                  <?
			foreign_relation('personnel_basic_info','PBI_CODE','concat(PBI_CODE," - ",PBI_NAME)',$emp_id,'1');
			?>
                </datalist>


              </div>

            </div>

          </div>

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

            <div class="form-group row m-0 mb-1 pl-3 pr-3">

              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company : </label>

              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                <select name="PBI_ORG"  id="PBI_ORG">

                  <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>

                </select>

              </div>

            </div>

          </div>

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

            <div class="form-group row m-0 mb-1 pl-3 pr-3">

              <label for="group_for" 
              class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Start Date : </label>

              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                <input type="date" name="s_date" id="s_date" value="<?=date("Y-m-01");?>" />

              </div>

            </div>

          </div>

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

            <div class="form-group row m-0 mb-1 pl-3 pr-3">

              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">End Date : </label>

              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                <input type="date" name="e_date" id="e_date" value="<?=date("Y-m-t");?>" />

              </div>

            </div>

          </div>

          <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

            <div class="form-group row m-0 mb-1 pl-3 pr-3">

              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Type : </label>

              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                <select name="roster_type"  id="roster_type" required>

                  <option value="Regular">Non-Roster</option>

                  <option value="roster">Roster</option>

                </select>

              </div>

            </div>

          </div>
		  
		  
		  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

            <div class="form-group row m-0 mb-1 pl-3 pr-3">

              <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department : </label>

              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">

                <select name="department"  class="form-control" id="department">
                  <option></option>
                  <? foreign_relation('department','DEPT_ID','DEPT_DESC',$department,' 1 order by DEPT_DESC');?>
                </select>

              </div>

            </div>

          </div>

        </div>

        <div class="n-form-btn-class">

          <input name="upload" class="btn1 btn1-bg-submit" type="submit" id="button-addon1" value="Sync All Data" />
          
          

        </div>

      </div>

    </div>

  </div>

</form>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>

