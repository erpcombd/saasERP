<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require_once "../sms_function.php";

$title='Single Attendance Report (HO)';
//$page_id = 35;
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#start_date');
do_calander('#end_date');


 $PBI_ID = find_a_field('personnel_basic_info','PBI_ID','PBI_ID='.$_POST['PBI_ID']); 

?>

<div class="right_col" role="main">
  <form action=""  method="post">
    <div class="d-flex justify-content-center">
      <div class="n-form1 fo-width pt-0">
        <h4 class="text-center bg-titel bold pt-2 pb-2"> Select Employee </h4>
        <div class="container-fluid p-0 pt-3">
          <div class="row">
            <div class="container">
              <div class="form-group row  m-0 mb-1 pl-3 pr-3">
                <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Code: </label>
                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
				
           <input name="PBI_ID" list='eip_ids' type="text" id="PBI_ID" size="30" onblur="" tabindex="1"  class="form-control"  required="required" value="<?=$_POST['PBI_ID']?>" />
                  <datalist id='eip_ids'>
                    <option></option>
                    <?
                     foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE," - ",PBI_NAME)',$PBI_ID,'1');



                                    ?>
                  </datalist>
                </div>
              </div>
            </div>
            <div class="container pt-2">
              <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                  <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date : </label>
                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                      <input type="text"  name="start_date" id="start_date"  class="form-control" required="required"

                                            value="<? if(isset($_POST['start_date'])){ echo $_POST['start_date']; }else{echo date('Y-m-01'); } ?>" />
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                  <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> TO: </label>
                    <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                      <input type="text"  name="end_date" id="end_date"  class="form-control" required="required"

                                             value="<? if(isset($_POST['end_date'])){ echo $_POST['end_date']; }else{echo date('Y-m-25'); } ?>" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="n-form-btn-class">
            <input name="create" type="submit" id="create" value="Show Report"  class="btn1 btn1-bg-submit" />
          </div>
        </div>
      </div>
    </div>
  </form>

  <? if($_POST['PBI_ID']>0){

                   

                    $start_date = $_POST['start_date'];

                    $end_date = $_POST['end_date'];

                    $begin = new DateTime($start_date);

                    $end = new DateTime($end_date);

                    $end->modify('+1 day');

                    $startTime = $days1=mktime(1,1,1,date('m',strtotime($start_date)),26,date('y',strtotime($start_date)));

                    $endTime = $days2=mktime(1,1,1,date('m',strtotime($end_date)),25,date('y',strtotime($end_date)));

                    $days_mon=($endTime - $startTime)/(3600*24);

                    for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {

                    $day   = date('l',$i);

                    ${'day'.date('N',$i)}++;



                    //if(isset($$day))

                    //$$day .= ',"'.date('Y-m-d', $i).'"';

                    //else

                    //$$day .= '"'.date('Y-m-d', $i).'"';

                    }





                    $ab="SELECT

                    a.PBI_NAME as name,

                   desi.DESG_DESC as designation,a.PBI_PICTURE_ATT_PATH,





                    d.DEPT_DESC as department



                    FROM

                    personnel_basic_info a,

                    department d,



                    designation desi

                    WHERE



                    a.DEPT_ID=d.DEPT_ID and

                    a.DESG_ID=desi.DESG_ID and

                    a.PBI_ID='".$PBI_ID."'";





                    $abb = db_query($ab);





                    $pbi=mysqli_fetch_object($abb);

$module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);

                    ?>
 
    <h4 class="text-center bg-titel bold pt-3 pb-2 m-0"> ATTENDANCE REPORT</h4>
    <h4 class="text-center bg-titel bold pt-2 pb-3 m-0"> DATE INTERVAL :
      <?=date('d-M-Y',strtotime($_POST['start_date']))?>
      To
      <?=date('d-M-Y',strtotime($_POST['end_date']))?>
    </h4>
    <span id="id_view">
    <?

     if($pbi->PBI_PICTURE_ATT_PATH!="") {?>
    <div align="center"> <img src="../../../assets/support/upload_view.php?name=<?=$pbi->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" class="img-circle profile_img modal-content" style="width:130px; height:auto; margin:10px; margin-top: 7px; margin-left:7px;"  vspace="0" hspace="5" height="auto"> </div>
    <? }else{?>
    <div align="center"> <img src="../../pic/staff/default.png" class="img-circle profile_img modal-content" style="width: 100px; margin:10px; margin-top: 7px; margin-left:7px;" width="120" vspace="0" hspace="5" height="100"> </div>
    <? } ?>
    <br>
    <h5 class="text-center bold ">Employee Code  : <?php echo $_POST['PBI_ID'];?></h5>
    <h5 class="text-center bold ">Employee Name  :
      <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$PBI_ID);?>
    </h5>
    <h5 class="text-center bold ">Designation  :
      <?=$pbi->designation;?>
    </h5>
    <h5 class="text-center bold ">Department  :
      <?=$pbi->department;?>
    </h5>
    </span> 
	
 
    <table width="100%" class="table1 table-bordered table-sm" cellspacing="0" cellpadding="0" id="grp">
      <thead class="thead1" >
        <tr class="bgc-info">
          <th>Date</th>
          <th>Day Name</th>
          <th>Office In Time</th>
          <th>Office Out Time</th>
          <th>Punch In</th>
          <th>Punch Out</th>
          <th>Over Time (Hour)</th>
     
          <th>Status</th>
        </tr>
      </thead>

      <?
        $sql  = 'select * from hrm_att_summary where emp_id="'.$PBI_ID.'" and  att_date between "'.$start_date.'" and "'.$end_date.'" order by att_date asc';
        $query = db_query($sql);
        while($data=mysqli_fetch_object($query)){
                  
        $val[$data->att_date]['in_time'] = $data->in_time;
        $val[$data->att_date]['out_time'] = $data->out_time;

        $val[$data->att_date]['sch_in_time'] = $data->sch_in_time;
        $val[$data->att_date]['sch_out_time'] = $data->sch_out_time;

        $val[$data->att_date]['iom'] = $data->iom_sl_no	;
        $val[$data->att_date]['leave'] = $data->leave_id;
        $val[$data->att_date]['dayname'] = $data->dayname;

        $val[$data->att_date]['od_id'] = $data->od_id;
        $val[$data->att_date]['od_start_time'] = $data->od_start_time;

        $val[$data->att_date]['iom_start_time'] = $data->iom_start_time;
        
        $val[$data->att_date]['over_time_hour'] = $data->ot_final_hour;

        $val[$data->att_date]['iom_total_hrs'] = $data->iom_total_hrs;
		
		$val[$data->att_date]['sch_off_day'] = $data->sch_off_day;
		
		
        $total_overtime += $data->ot_final_hour; //$data->over_time_hour;




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

      elseif( $data->present==0)

      $val[$data->att_date]['final_status'] = 'Absent';
	  
	  elseif( $data->final_late_status>0 && $data->final_early_status>0 )
       $val[$data->att_date]['final_status'] = 'Late/Early';

      elseif( $data->final_early_status>0 )
      $val[$data->att_date]['final_status'] = 'Early Out';

      elseif($data->final_late_status>0 && $data->od_id>0 && $od_start_timee < $sac_formated )
      $val[$data->att_date]['final_status'] = 'OD';

      //elseif( $data->final_late_status>0)
      //$val[$data->att_date]['final_status'] = 'LATE';

      elseif($data->final_late_status>0 && $data->iom_sl_no>0 && $sort_leave_start_timee < $sac_formated )

      $val[$data->att_date]['final_status'] = 'SHL';

      elseif($data->holyday>0)
      $val[$data->att_date]['final_status'] = 'HOLIDAY';
	  
      elseif($data->sch_off_day>0)
      $val[$data->att_date]['final_status'] = 'OFFDAY';

      elseif($data->final_late_status>0||$data->final_late_min>0)

      $val[$data->att_date]['final_status'] = 'LATE';
	  


      elseif($data->id>0)
      $val[$data->att_date]['final_status'] = 'PRESENT';
      $dteStart = new DateTime($data->in_time);
      $dteEnd   = new DateTime($data->out_time);
      $dteDiff  = $dteStart->diff($dteEnd);

}

                    $interval = DateInterval::createFromDateString('1 day');

                    $period = new DatePeriod($begin, $interval, $end);

                    //echo $off_day;

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

                    $bgcolor = '#FFF';

                    $val[$day_date]['final_status']= $holy_reson;

                    $public_holy++;
                    }

                    elseif($val[$day_date]['final_status']=='OFFDAY')

                    {$bgcolor = '#FFF';$off_days++;}

                    elseif($val[$day_date]['final_status']=='LEAVE')

                    {$bgcolor = '#FFF'; $leave++;}

                 

                    elseif($val[$day_date]['final_status']=='SHL')

                    {$bgcolor = '#FFF'; $shl++;}

                    elseif($val[$day_date]['final_status']=='OD')

                    $bgcolor = '#FFF';

                    elseif($val[$day_date]['final_status']=='Early Out')

                    {$bgcolor = '#FFF'; $early++;}
					
					 elseif($val[$day_date]['final_status']=='Late/Early')

                    {$bgcolor = '#FFF'; $late++; $early++;}

                    elseif($val[$day_date]['final_status']=='ABSENT')

                    {$bgcolor = '#e7e7e7'; $absent_leave_ck++;}

                    elseif($val[$day_date]['final_status']=='LATE')

                    {$bgcolor = '#FFF';$late++;$late_min_total = $late_min_total + $val[$day_date]['final_late_min'];}

                    elseif($val[$day_date]['final_status']=='PRESENT')
                    {$bgcolor = '#FFF';$PRESENT++;}
                    else
                    {$bgcolor = '#e7e7e7';  $PRESENT++; $absent++;
                    $val[$day_date]['final_status']='ABSENT';
}?>

        <tr bgcolor="<?=$bgcolor?>">
        <td bgcolor="<?=$bgcolor?>"><?=$dt->format( "d-M-Y" );?></td>
        <td bgcolor="<?=$bgcolor?>"><?=$dt->format("l");?></td>
        <td bgcolor="<?=$bgcolor?>"><?=date("h:i:s a",strtotime($val[$day_date]['sch_in_time']));?></td>
        <td bgcolor="<?=$bgcolor?>"><?=date("h:i:s a",strtotime($val[$day_date]['sch_out_time']));?></td>

        <?php  if ($val[$day_date]['in_time'] >0){  ?>
        <td bgcolor="<?=$bgcolor?>"><?=date("h:i:s a",strtotime($val[$day_date]['in_time']));?></td>
        <td bgcolor="<?=$bgcolor?>"><?=date("h:i:s a",strtotime($val[$day_date]['out_time']));?></td>
        <?php }else{  ?>
        <td bgcolor="<?=$bgcolor?>"></td>
        <td bgcolor="<?=$bgcolor?>"></td>
        <?php } ?>	

        <td bgcolor="<?=$bgcolor?>"><?=round($val[$day_date]['over_time_hour']);?></td>
      
        <td bgcolor="<?=$bgcolor?>"><?=$val[$day_date]['final_status'];?></td>
      </tr>
      <? }?>


      <tr bgcolor="#FFFFFF">
        <td colspan="11"><br />
          <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table table-striped">
          
            <tr>
              <th bgcolor="#666666"><div align="center" class="style2">Total Days</div></th>
              <th bgcolor="#FFCBA4"><div align="center">Holidays</div></th>
              <th bgcolor="#F7E7CE"><div align="center">Public Holidays</div></th>
              <th bgcolor="#66CDAA"><div align="center">Present</div></th>
              <th bgcolor="#F70D1A"><div align="center" class="style2">Absent</div></th>
              <th bgcolor="#D1ECF1">Leave</th>
              <th bgcolor="#F2BA14">Early Out</th>
              <th bgcolor="#D5D6EA"><div align="center"> SHL </div></th>
              <th bgcolor="#FAF884"><div align="center">Late In Days</div></th>
              <th bgcolor="#78B4BF"><div align="center">Total Overtime Hour</div></th>
            </tr>

            <tr >
              <td bgcolor="#CCCCCC"><div align="center">
                  <?=$days;?>
                </div></td>
              <td bgcolor="#FFCBA4"><div align="center">
                  <?=$off_days;?>
                </div></td>
              <td bgcolor="#F7E7CE"><div align="center">
                  <?=$public_holy;?>
                </div></td>
              <td bgcolor="#66CDAA"><div align="center">
                  <?=$PRESENT-$absent;?>
                </div></td>
              <td bgcolor="#F70D1A"><div align="center">
                  <?=$absent+$absent_leave_ck;?>
                </div></td>
              <td bgcolor="#D1ECF1"><div align="center">
                  <?=$leave?>
                </div>
                <? //=$late_min_total ?></td>
              <td bgcolor="#F2BA14"><div align="center">
                  <?=$early;?>
                </div></td>
              <td bgcolor="#D5D6EA"><div align="center">
                  <?=$shl?>
                  <? //if($late_min_p>$late_day_p) echo $late_min_p*.5; else echo $late_day_p*.5;?>
                </div></td>
              <td bgcolor="#FAF884"><div align="center">
                  <?=$late;?>
                </div></td>
              <td bgcolor="#33CCFF"><?=$total_overtime; //$late_day_p = (int)($late/3); $late_min_p = (int)($late_min_total/30); if($late_min_p>$late_day_p) echo $late_min_p; else echo $late_day_p;?></td>
            </tr>

          </table>
          </td>
      </tr>
    </table>
 
<?  } ?>
</div>

<?
  require_once SERVER_CORE."routing/layout.bottom.php";
?>