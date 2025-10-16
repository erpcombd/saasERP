<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#cut_off_date');
if($_POST['mon']!=''){
$mon=$_POST['mon'];}
else{
$mon=date('n');
}

if($_POST['year']!=''){
$year=$_POST['year'];}
else{
$year=date('Y');
}

if(isset($_GET['pbi_id_in']) && $_GET['pbi_id_in']!=''){
$pbiIdIn = ' and p.PBI_ID in('.$_GET['pbi_id_in'].')';
}



		$sql = 'select distinct a.xenrollid from hrm_attdump a, personnel_basic_info p where a.xenrollid=p.PBI_ID and p.PBI_JOB_STATUS="In Service" '.$pbiIdIn; // and p.PBI_ID=1867
		$query = db_query($sql);
		$num_rows = mysqli_num_rows($query);
		while($datas = mysqli_fetch_object($query)){
		$startDate = '2017-08-26';
		$endDate = '2017-08-31';
		$startDateStr = strtotime($startDate);
		$endDatestr = strtotime($endDate);
		
		for($i=$startDateStr; $i<=$endDatestr; $i+=86400){
		 $emp_id = $datas->xenrollid;
		 '<br>'.$att_date = date('Y-m-d', $i);
		 $leave_id  = 1;
		 $leave_type  = 'LWP (Leave Without Pay)';
		 $leave_reason  = 'For Salary 25 Days';
		 $leave_duration = 1;
		 $leave_approved_by = $_SESSION['user']['id']; 
		 $leave_entry_at = date('Y-m-d');
		 $leave_entry_by = $_SESSION['user']['id'];
		 
		
	
$insSql='INSERT INTO hrm_att_summary( emp_id, att_date, leave_id, leave_type, leave_reason, leave_duration, leave_approved_by, leave_entry_at, leave_entry_by) 
		
		VALUES ("'.$emp_id.'", "'.$att_date.'",  "'.$leave_id.'", "'.$leave_type.'", "'.$leave_reason.'", "'.$leave_duration.'", "'.$leave_approved_by.'", "'.$leave_entry_at.'", "'.$leave_entry_by.'")';

db_query($insSql);

			}
					
		}


?>

<form action="" method="post">
  <div class="oe_view_manager oe_view_manager_current">
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
          <div class="oe_form_buttons"></div>
          <div class="oe_form_sidebar"></div>
          <div class="oe_form_pager"></div>
          <div class="oe_form_container">
            <div class="oe_form">
              <div class="">
                <div class="oe_form_sheetbg">
                  <div class="oe_form_sheet oe_form_sheet_width">
                    <div  class="oe_view_manager_view_list">
                      <div  class="oe_list oe_view">
                        <table width="100%" border="0" class="oe_list_content">
                          <thead>
                            <tr class="oe_list_header_columns">
                              <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Bonus Calculation</span></th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            <tr>
                              <td align="right" class="alt"><strong>Bonus Type  : </strong></td>
                              <td align="left" class="alt"><strong>
                                <select name="bonus_type" required = "required">
								<option value="2">Eid-Ul-Adha</option>
                                  <option value="1">Eid-Ul-Fitre</option>
                                  
                                </select>
                                </strong></td>
                              <td align="right" class="alt"><strong>Company :</strong></td>
                              <td><span class="alt"><span class="oe_form_group_cell">
                                <select name="PBI_ORG" style="width:160px;" id="PBI_ORG">
                                  <? foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']);?>
                                </select>
                                </span></span></td>
                            </tr>
                            <tr>
                              <td align="right" class="alt">Year  :</td>
                              <td align="left" class="alt"><select name="year" style="width:160px;" id="year" required="required">
                                  <option <?=($year=='2017')?'selected':''?>>2017</option>
                                  <option <?=($year=='2018')?'selected':''?>>2018</option>
                                  <option <?=($year=='2019')?'selected':''?>>2019</option>
                                  <option <?=($year=='2020')?'selected':''?>>2020</option>
                                </select></td>
                              <td width="40%" align="right" class="alt"><strong>Bonus % </strong>: </td>
                              <td width="10%"><input name="bonus_percentage" type="text" id="bonus_percentage" value="55" /></td>
                            </tr>
                            
                            <tr  class="alt">
                              <td align="right">Cut off Date : </td>
                              <td align="left"><input name="cut_off_date" type="date" id="cut_off_date" value="<?=$_POST['cut_off_date']?>"/></td>
                              <td align="right"><strong>PBI ID IN:</strong></td>
                              <td><input name="pbi_id_in" type="text" id="pbi_id_in" /></td>
                            </tr>
                          </tbody>
                        </table>
                        <br />
                        <div style="text-align:center">
                          <input name="submit" type="submit" id="submit" value="CALCULATE" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="oe_chatter">
                  <div class="oe_followers oe_form_invisible">
                    <div class="oe_follower_list"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>
