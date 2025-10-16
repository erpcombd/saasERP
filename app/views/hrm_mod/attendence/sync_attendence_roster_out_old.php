<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#m_date');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$table='hrm_inout';
$unique='id';


if(isset($_POST["upload"])){
$year = $_POST['year'];
$mon = $_POST['mon'];

if($mon == 1){
$syear = $year - 1;
$smon = 12;
}else{
$syear = $year;
$smon =  $mon - 1;
}

$datetime = date('Y-m-d H:i:s');

$start_date = $syear.'-'.($smon).'-25';
//$start_date = '2018-02-26';

$startTime = $days1 = strtotime($start_date);
$days_mon = date('t',$startTime);

$end_date   = $year.'-'.($mon).'-26';
//$end_date   = '2018-03-25';


$endTime = $days2=mktime(0,0,0,$mon,26,$year);

for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;} 
$r_count=${'day5'};
$PBI_ORG = $_POST['PBI_ORG'];
if($_POST['emp_id']>0) 	$emp_id=$_POST['emp_id'];

if(isset($emp_id)){$emp_id_con=" and xenrollid IN (".$_POST['emp_id'].")";}
if($PBI_ORG>0) $ORG_con = " and p.PBI_ORG='".$PBI_ORG."'";


$sql = "SELECT xenrollid , xdate , min(`xtime`) in_time,max(xtime) out_time, office_start_time sch_in_time,office_end_time sch_out_time 
FROM `hrm_attdump` h, hrm_machice_type m,personnel_basic_info p, hrm_roster_allocation r, hrm_schedule_info s
WHERE p.PBI_ID = r.PBI_ID AND r.roster_date = h.xdate AND r.shedule_1=s.id AND p.PBI_ID=h.xenrollid 
and xdate BETWEEN '".$start_date."' AND '".$end_date."' and h.xmechineid=m.mac_id and m.mac_type!='In' 
".$ORG_con.$emp_id_con."
GROUP BY `xenrollid` , `xdate`";

	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$sl++;
	$value[$sl]['emp_id'] = $data->xenrollid;
	$value[$sl]['att_date'] = $data->xdate;
	$value[$sl]['roster_att_date'] = date('Y-m-d',(strtotime($data->xdate) - 86400));
	$value[$sl]['in_time'] = $data->in_time;
	$value[$sl]['out_time'] = $data->out_time;
	$value[$sl]['sch_in_time'] = $data->sch_in_time;
	$value[$sl]['sch_out_time'] = $data->sch_out_time;
	}

for($x=1;$x<=$sl;$x++)
{

			
				
				if($value[$x]['sch_out_time']>$value[$x]['sch_in_time']){
					$sql='update hrm_att_summary set 
					out_time="'.$value[$x]['out_time'].'"
					where  emp_id="'.$value[$x]['emp_id'].'" and att_date="'.$value[$x]['att_date'].'" ';
					$query=db_query($sql);
					}

}

		$sql2 = "SELECT xenrollid , xdate , max(xtime) out_time 
					FROM `hrm_attdump` h, hrm_machice_type m,personnel_basic_info p
					
					WHERE p.PBI_ID=h.xenrollid 
					and xtime BETWEEN concat(h.xdate,' 00:00:00') AND  concat(h.xdate,' 10:00:00') 
					and h.xmechineid=m.mac_id and m.mac_type!='In' 
					".$ORG_con.$emp_id_con." 
					and xdate BETWEEN '".$start_date."' AND '".$end_date."' 
					GROUP BY `xenrollid` , `xdate`";
					
					$query2 = db_query($sql2);
					while($data2 = mysqli_fetch_object($query2)){
					$att_date = date('Y-m-d',(strtotime($data2->xdate) - 86400));
					$sql='update hrm_att_summary set out_time="'.$data2->out_time.'"
					where  emp_id="'.$data2->xenrollid.'" and att_date="'.$att_date.'" ';
					$query=db_query($sql);
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
<tr><td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Collect Roster Machine OUT Data </div></td></tr>

<tr>
  <td>Employee Code </td>
  <td colspan="3"><input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" /></td>
</tr>
<tr>
  <td>Company:</td>
  <td colspan="3"><span class="oe_form_group_cell">
    <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
      <? foreign_relation('user_group','id','group_name',$PBI_ORG);?>
    </select>
  </span></td>
</tr>
<tr>
<td width="20%">Month :</td>
<td colspan="3"><span class="oe_form_group_cell">
<select name="mon" style="width:160px;" id="mon" required="required">


<option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
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
<option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>

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
</form></div>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>