<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

function auto_dropdown($sql){
$res=db_query($sql);
while($data=mysqli_fetch_row($res)){
if($value==$data[0])
echo '<option value="'.$data[0].'" selected>'.$data[1].'</option>';
else
echo '<option value="'.$data[0].'">'.$data[1].'</option>';
}}

if($_POST['mon']!=''){
$mon=$_POST['mon'];}
else{
$mon=date('n');
}

do_calander('#m_date');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$table='hrm_inout';
$unique='id';


if(isset($_POST["upload"]))
{
$year = $_POST['year'];
$mon = $_POST['mon'];
if($mon == 1)
{
$syear = $year - 1;
$smon = 12;
}
else
{
$syear = $year;
$smon =  $mon - 1;
}

$datetime = date('Y-m-d H:i:s');

$start_date = $syear.'-'.($smon).'-26';
//$start_date = '2018-02-26';

$startTime = $days1 = strtotime($start_date);
$days_mon = date('t',$startTime);

$end_date   = $year.'-'.($mon).'-25';
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

echo $sql = "SELECT `xenrollid` , `xdate` , min(`xtime`) in_time,max(xtime) out_time 
FROM `hrm_attdump` h, hrm_machice_type m, personnel_basic_info p
WHERE 
p.PBI_ID=h.xenrollid and xdate BETWEEN '".$start_date."' AND '".$end_date."' 
and h.xmechineid=m.mac_id 
and m.mac_type!='Out' ".$ORG_con.$emp_id_con."
GROUP BY `xenrollid` , `xdate`";

	$query = db_query($sql);
	while($data = mysqli_fetch_object($query))
	{
	$sl++;
	$value[$sl]['emp_id'] = $data->xenrollid;
	$value[$sl]['att_date'] = $data->xdate;
	$value[$sl]['in_time'] = $data->in_time;
	$value[$sl]['out_time'] = '';
	}

for($x=1;$x<=$sl;$x++)
{
			$found = find_a_field('hrm_att_summary2','1','emp_id="'.$value[$x]['emp_id'].'" and att_date="'.$value[$x]['att_date'].'"');
		
			if($found==0)
			{
				$sql="INSERT INTO hrm_att_summary2 
				(emp_id, att_date, in_time, out_time, iom_entry_at, iom_entry_by, dayname)
				VALUES 
('".$value[$x]['emp_id']."','".$value[$x]['att_date']."', '".$value[$x]['in_time']."', '".$value[$x]['out_time']."', '".$datetime."', '".$_SESSION['user']['id']."', dayname('".$value[$x]['att_date']."'))";
				$query=db_query($sql);
			}
			else
			{
				$sql='update hrm_att_summary2 set 
in_time="'.$value[$x]['in_time'].'", out_time="'.$value[$x]['out_time'].'", iom_entry_by="'.$value[$x]['emp_id'].'", iom_entry_at="'.$datetime.'"
				where  emp_id="'.$value[$x]['emp_id'].'" and att_date="'.$value[$x]['att_date'].'" ';
				$query=db_query($sql);
			}
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
<tr><td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Collect Roster Machine IN Data </div></td></tr>

<tr>
  <td>Employee Code </td>
  <td colspan="3"><input type="text" name="emp_id" id="emp_id" value="<?=$_POST['emp_id']?>" /></td>
</tr>
<tr>
  <td>Company:</td>
  <td colspan="3"><select name="PBI_ORG" id="PBI_ORG">
    <?php auto_dropdown("select id,group_name from user_group where id='".$_SESSION['user']['group']."' "); ?>
  </select></td>
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