<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#m_date');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$table='hrm_inout';

$unique='id';



if(isset($_POST["upload"]))
{
$year = $_POST['year'];
$mon = $_POST['mon'];

$start_date = $year.'-'.($mon-1).'-26';
$end_date   = $year.'-'.$mon.'-25';

$startTime = $days1=mktime(1,1,1,(date('m',strtotime($start_date))),26,date('y',strtotime($start_date)));
$endTime = $days2=mktime(1,1,1,date('m',strtotime($end_date)),25,date('y',strtotime($end_date)));

$days_in_month = $days_mon = date('t',$startTime);



$filename=$_FILES["mobile_bill"]["tmp_name"];

	if($_FILES["mobile_bill"]["tmp_name"]!="")
	{
	echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");
	
			while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
			{
			if($emapData[0]==$year&&$emapData[1]==$mon){
			$s_sql="select * from hrm_attendence_final where year='".$emapData[0]."' and mon='".$emapData[1]."' and PBI_ID='".$emapData[2]."'";
			$s_query=@db_query($s_sql);
			$s_num_row=@mysqli_num_rows($s_query);
			
$PBI_DOJ = find_a_field('personnel_basic_info','PBI_DOJ','PBI_ID="'.$emapData[2].'"');

if(strtotime($PBI_DOJ)>$startTime)
$td_days_mon =ceil(($endTime - strtotime($PBI_DOJ))/(3600*24));
else $td_days_mon =$days_mon;
		
				if($s_num_row==0)
				{
				//db_query('delete from hrm_moblie_bill where year = "'.$emapData[0].'" and month = "'.$emapData[1].'" and emp_id ="'.$emapData[2].'" ');
$sql = "INSERT INTO `hrm_attendence_final` 
(`mon`, `year`, `PBI_ID`, 
`td`, `od`, `hd`, `lt`, `ab`, `lv`, `pre`, `pay`, `ot`, 
`status`,`remarks`, `entry_by`, `entry_at`) VALUES
('".$emapData[1]."','".$emapData[0]."','".$emapData[2]."',
'".$td_days_mon."','".$emapData[11]."', '0','0','".($td_days_mon-$emapData[10])."','".$emapData[9]."','".$emapData[7]."','".$emapData[10]."','0',
'".$emapData[13]."','".$emapData[12]."','".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."')";
db_query($sql);
				}
				else
				{
$sql = 'update hrm_attendence_final set  

td = "'.$td_days_mon.'",lv = "'.$emapData[9].'", od = "'.$emapData[11].'", ab = "'.($td_days_mon-$emapData[10]).'", pre = "'.$emapData[7].'", pay = "'.$emapData[10].'", edit_by = "'.$_SESSION['user']['id'].'", edit_at = "'.date('Y-m-d H:i:s').'"

where year = "'.$emapData[0].'" and mon = "'.$emapData[1].'" and PBI_ID ="'.$emapData[2].'"';
db_query($sql);
				}
			}
			}
			
	}
fclose($file);
 

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

                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Upload Sales Monthly Attendence</div></td>
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
                  <option <?=($year=='2021')?'selected':''?>>2021</option>
                </select></td>
                </tr>
              <tr>
                <td> Upload  File :</td>
                <td colspan="3"><input name="mobile_bill"  type="file" id="mobile_bill"/></td>
                </tr>
              <tr>

                <td colspan="4">
                  <div align="center">
                    <input name="upload" type="submit" id="upload" value="Upload File" />
                  </div></td>
                </tr>


              <tr>

                <td colspan="4"><label>

                    <div align="center">
                      <p>&nbsp;</p>
                      <p align="left" class="style2">Note: File must be at CSV format. Example: sales.csv </p>
                      <p align="left" class="style2"> And Filed example: </p>
                      <table cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="20" width="64">year</td>
                          <td width="64">month</td>
                          <td width="64">Code<br />
                            &nbsp;No.</td>
                          <td width="197">Name</td>
                          <td width="64">Design</td>
                          <td width="64">Area</td>
                          <td width="64">Dealer Name</td>
                          <td width="64">Present</td>
                          <td width="64">Absent</td>
                          <td width="64">Leave</td>
                          <td width="64">W/days</td>
                          <td width="64">OffDay</td>
                          <td width="64">Remarks</td>
                          <td width="64">Heldup</td>
                        </tr>
                      </table>
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

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>