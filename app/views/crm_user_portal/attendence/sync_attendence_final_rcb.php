<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#m_date');

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


$table='hrm_inout';

$unique='id';





if(isset($_POST["upload"]))
{
$year = $_POST['year'];
$mon = $_POST['mon'];
$datetime = date('Y-m-d H:i:s');
$start_date = $year.'-'.($mon).'-01';
$startTime = $days1 = strtotime($start_date);
$days_mon = date('t',$startTime);
$end_date   = $year.'-'.($mon).'-'.$days_mon;
$endTime = $days2=mktime(0,0,0,$mon,$days_mon,$year);

for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;} 
$r_count=${'day5'};


//
//
//	$sql = "SELECT `xenrollid` , `xdate` , min(`xtime`) in_time,max(xtime) out_time FROM `hrm_attdump`
//	WHERE xdate BETWEEN '".$start_date."' AND '".$end_date."' 
//	GROUP BY `xenrollid` , `xdate`";
//	$query = db_query($sql);
//	while($data = mysqli_fetch_object($query))
//	{
//	$sl++;
//	$value[$sl]['emp_id'] = $data->xenrollid;
//	$value[$sl]['att_date'] = $data->xdate;
//	$value[$sl]['in_time'] = $data->in_time;
//	$value[$sl]['out_time'] = $data->out_time;
//	}
//
//for($x=1;$x<=$sl;$x++)
//{
//			$found = find_a_field('hrm_att_summary','1','emp_id="'.$value[$x]['emp_id'].'" and att_date="'.$value[$x]['att_date'].'"');
//		
//			if($found==0)
//			{
//				$sql="INSERT INTO hrm_att_summary 
//				(emp_id, att_date, in_time, out_time, iom_entry_at, iom_entry_by, dayname)
//				VALUES 
//('".$value[$x]['emp_id']."','".$value[$x]['att_date']."', '".$value[$x]['in_time']."', '".$value[$x]['out_time']."', '".$datetime."', '".$_SESSION['user']['id']."', dayname(".$value[$x]['att_date']."))";
//				$query=db_query($sql);
//			}
//			else
//			{
//				$sql='update hrm_att_summary set 
//in_time="'.$value[$x]['in_time'].'", out_time="'.$value[$x]['out_time'].'", iom_entry_by="'.$value[$x]['emp_id'].'", iom_entry_at="'.$datetime.'"
//				where  emp_id="'.$value[$x]['emp_id'].'" and att_date="'.$value[$x]['att_date'].'" ';
//				$query=db_query($sql);
//			}
//}


//1------------------>>>>>--------------------------2



	echo $sql = "SELECT id,emp_id,in_time,att_date,sch_in_time FROM hrm_att_summary s,  personnel_basic_info p
	WHERE p.PBI_ID=s.emp_id AND p.PBI_ORG =11  and att_date BETWEEN '".$start_date."' AND '".$end_date."' and dayname!='Friday'	 and in_time>concat(att_date,' ',sch_in_time) and leave_id=0 and iom_sl_no=0 order by emp_id,att_date";
	//and emp_id = 7684
	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
$emp_id = $data->emp_id;

if($emp_id==$old_emp_id) $grace_no++; else $grace_no=1;


$in_time = strtotime($data->in_time);
$from_time = strtotime($data->att_date.' '.$data->sch_in_time);
$late_min = round(abs($in_time - $from_time) / 60,2);

if($grace_no<6) 
{$grace = $grace_no;
if($late_min<11)  {$final_late_min = 0;$final_late_status = 0;}
else {

if($late_min>70) $final_late_min = 60;
else $final_late_min = $late_min - 10;

$final_late_status = 1;}
} else {$grace = 0;

if($late_min>60) $final_late_min = 60;
else $final_late_min = $late_min;

}


echo $update_sql = "update hrm_att_summary set late_min='".$late_min."',grace_no='".$grace."',final_late_min='".$final_late_min."',final_late_status='".$final_late_status."',process_time='".$datetime."' where id=".$data->id;
db_query($update_sql);
$old_emp_id = $data->emp_id;
	}




echo 'Complete';
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





<div class="oe_view_manager oe_view_manager_current">

        <form action=""  method="post" enctype="multipart/form-data">



        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">

		     

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

            <table width="80%" border="1" align="center">

              <tr>

                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Upload Machine Daily Attendence</div></td>
                </tr>

              <tr>
                <td width="20%">Month :</td>
                <td colspan="3"><span class="oe_form_group_cell">
                  <select name="mon" style="width:160px;" id="mon" required="required">
                  <option value="5" <?=($mon=='5')?'selected':''?>>May</option>
<!--                <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
                    <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
                    <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
                    <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
                    <option value="5" <?=($mon=='5')?'selected':''?>>May</option>
                    <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>
                    <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
                    <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
                    <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
                    <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
                    <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
                    <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>-->
                  </select>
                </span></td>
                </tr>
              <tr>
                <td>Year :</td>
                <td colspan="3"><select name="year" style="width:160px;" id="year" required="required">
                  <option <?=($year=='2020')?'selected':''?>>2020</option>
                </select></td>
                </tr>
              
              <tr>

                <td colspan="4">
                  <div align="center">
                    <input name="upload" type="submit" id="upload" value="Sync All Data" />
                  </div></td>
                </tr>


              <tr>

                <td colspan="4"><label>

                    <div align="center">
                      <p>&nbsp;</p>
                      </div>

                    </label></td>
              </tr>
            </table>

            <br />
          </div>
          </div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

 </form>   </div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>