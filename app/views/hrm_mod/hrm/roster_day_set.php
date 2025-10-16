<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#roster_date');



if(isset($_POST['save']))
{		
		if($_POST['designation']>0)
		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0)
		$con .=' and a.PBI_DEPARTMENT='.$_POST['department'];
		if($_POST['job_location']>0)
		$con .=' and a.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0)
		$con .=' and a.PBI_ORG='.$_POST['group_for'];
		
		$sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT from 
		personnel_basic_info a
		where  1 ".$con."  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
		$query = db_query($sql);
		$query = db_query($sql);
		while($info=mysqli_fetch_object($query))
		{
		$roster_date = $_POST['roster_date'];
		$point_1 = $_POST['point_1_'.$info->PBI_ID];
		$shedule_1 = $_POST['shedule_1_'.$info->PBI_ID];
		$point_2 = $_POST['point_2_'.$info->PBI_ID];
		$shedule_2 = $_POST['shedule_2_'.$info->PBI_ID];
		$entry_by = $_SESSION['user']['id'];
		
			if($point_1>0){
			$sSql = 'select id, PBI_ID from hrm_roster_allocation where PBI_ID="'.$info->PBI_ID.'" and roster_date="'.$roster_date.'"';
			$sQuery = db_query($sSql);
			$sData = mysqli_fetch_object($sQuery);
			if($sData->id>0){
			$edit_by = $_SESSION['user']['id'];
			$edit_at = date('Y-m-d h:i:s');
			$job_location = $_POST['job_location'];
			$group_for = $_POST['group_for'];
			 $upSql = 'UPDATE hrm_roster_allocation SET point_1="'.$point_1.'", shedule_1="'.$shedule_1.'", point_2="'.$point_2.'", shedule_2="'.$shedule_2.'", edit_at="'.$edit_at.'", edit_by = '.$edit_by.', job_location="'.$job_location.'", group_for = "'.$group_for.'"  WHERE id='.$sData->id;
			db_query($upSql);
			
			}else{
			
			$insSql = 'INSERT INTO hrm_roster_allocation(PBI_ID, roster_date, point_1, shedule_1, point_2, shedule_2, job_location,group_for, entry_by) VALUES ("'.$info->PBI_ID.'", "'.$roster_date.'", "'.$point_1.'", "'.$shedule_1.'", "'.$point_2.'", "'.$shedule_2.'", "'.$_POST['job_location'].'", "'.$_POST['group_for'].'", "'.$entry_by.'")';
			db_query($insSql);
				}
			}
		}
}
?>
<script>

function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	

		try{

			xmlhttp=new XMLHttpRequest();

		}

		catch(e)	{		

			try{			

				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){

				try{

				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				}

				catch(e1){

					xmlhttp=false;

				}

			}

		}

		 	

		return xmlhttp;

    }

	function update_value(id)
	{
var PBI_ID=id; // Rent
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=document.getElementById('lt_'+id).value; 
var ab=document.getElementById('ab_'+id).value;
var lv=document.getElementById('lv_'+id).value;
var pre=(document.getElementById('pre_'+id).value)*1; // Due
var pay=document.getElementById('pay_'+id).value;
var ot=document.getElementById('ot_'+id).value;

var mon=document.getElementById('mon').value;
var year=document.getElementById('year').value;
var area=document.getElementById('area').value;


var strURL="monthly_attendence_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&mon="+mon+"&year="+year+"&area="+area;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {

			

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			

						

			req.open("GET", strURL, true);

			req.send(null);

		}	

}

	function cal_all(id)

	{
var PBI_ID=id; // Rent
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=(document.getElementById('lt_'+id).value)*1; 
var ab=(document.getElementById('ab_'+id).value)*1;
var lv=(document.getElementById('lv_'+id).value)*1;

var ltd=lt/3; 
var ltdd=Math.floor(ltd);
var pre=td - (od + hd + ab + lv);
var pay=td - ab - ltdd;
document.getElementById('pay_'+id).value=pay;
document.getElementById('pre_'+id).value=pre;
	}
</script>
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>
<form action="?"  method="post">
  <div class="oe_view_manager oe_view_manager_current">
    <div class="oe_view_manager_body">
      <div  class="oe_view_manager_view_list"></div>
      <div class="oe_view_manager_view_form">
        <div style="opacity: 1; text-align: right;" class="oe_formview oe_view oe_form_editable">
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
                              <th colspan="2"><span style="text-align: center; font-size:18px; color:#09F">Roster Day Set</span></th>
                            </tr>
                            <tr class="oe_list_header_columns">
                              <th colspan="2"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <tbody>
                            
                            <tr >
                              <td align="right"><div align="right"><strong>Date :</strong></div></td>
                              <td align="right"><div align="left"><span class="oe_form_group_cell"> </span><span class="oe_form_group_cell">
                                <input name="roster_date" type="text" id="roster_date" value="<?=$_POST['roster_date']?>" required/>
                              </span></div></td>
                            </tr>
                            <tr>
                              <td align="center" style="text-align: right"><div align="right"><strong>Company : </strong></div></td>
                              <td><select name="group_for" id="group_for"   onchange="getData2('ajax_location.php', 'loc', this.value,  this.value)" required>
                                  <? foreign_relation('user_group', 'id', 'group_name',$_POST['group_for'],'1')?>
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td align="right"><div align="right"><strong>Job Location : </strong></div></td>
                              <td><span id="loc">
                                <select name="job_location" id="job_location" >
                                  <? foreign_relation('office_location', 'ID', 'LOCATION_NAME',$_POST['job_location'],'1')?>
                                </select>
                                </span>
                                  <input type='hidden' name='area' id='area' value='1' /></td>
                            </tr>
                            
                             <tr>
                               <td align="center" style="text-align: right">&nbsp;</td>
                               <td>&nbsp;</td>
                             </tr>
                             <tr>
                            <td colspan="2" align="center" style="text-align: right"><div align="center">
                              <input name="create" id="create" value="SHOW EMPLOYEE" type="submit">
                            </div></td>
                            </tr>
                          </tbody>
                        </table>
                        <br />
                        <? if($_REQUEST['area']>0){?>
                        <div style="text-align:center">
                          
                          <div class="oe_form_sheetbg">
                            <div class="oe_form_sheet oe_form_sheet_width">
                              <div class="oe_view_manager_view_list">
                                <div class="oe_list oe_view">
                                  <table width="100%" class="oe_list_content">
                                    <thead>
                                      <tr class="oe_list_header_columns" style="font-size:10px;padding:3px;">
                                        <th>Code</th>
                                        <th>Full Name</th>
                                        <th>Desg</th>
                                        <th>Dept</th>
                                        <th>Duty Section </th>
                                        <th>Duty Schedule </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?
		if($_POST['designation']>0)
		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0)
		$con .=' and a.PBI_DEPARTMENT='.$_POST['department'];
		if($_POST['job_location']>0)
		$con .=' and a.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0)
		$con .=' and a.PBI_ORG='.$_POST['group_for'];
		
		$sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT from 
		personnel_basic_info a
		where  1 ".$con."  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
		$query = db_query($sql);
		while($info=mysqli_fetch_object($query))
		{
		$rosterAllocation = find_all_field('hrm_roster_allocation','','PBI_ID="'.$info->PBI_ID.'" and roster_date="'.$_POST['roster_date'].'"');
		$point_1 = $rosterAllocation->point_1;
		$shedule_1 = $rosterAllocation->shedule_1;
		?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td><?=$info->PBI_ID?>
                                          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
                                        <td><?=$info->PBI_NAME?></td>
                                        <td><?=$info->PBI_DESIGNATION?></td>
                                        <td><?=$info->PBI_DEPARTMENT?></td>
                                        <td><span class="oe_form_group_cell">
                                          <select name="point_1_<?=$info->PBI_ID?>" id="point_1_<?=$info->PBI_ID?>">
<? foreign_relation('hrm_roster_point','id','point_short_name',$point_1,'group_for = "'.$_POST['group_for'].'"');?>
                                          </select>
                                        </span></td>
                                        <td><span class="oe_form_group_cell">
                                          <select name="shedule_1_<?=$info->PBI_ID?>" id="shedule_1_<?=$info->PBI_ID?>">
<? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule_1,'group_for = "'.$_POST['group_for'].'"');?>
                                          </select>
                                          </span></td>
                                      </tr>
                                      <?
		}
		?>
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td colspan="2"></td>
                                      </tr>
                                    </tfoot>
                                  </table>
                                </div>
                              </div>
                            </div>
                          </div>
                          <table width="100%" class="oe_list_content">
                            <thead>
                              <tr class="oe_list_header_columns">
                                <th colspan="4"><table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#FF6633">
                                    <tr>
                                      <td align="center"><div align="center">
                                        <input name="save" type="submit" id="save" value="SET NEW SCHEDULE" />
                                      </div></td>
                                    </tr>
                                </table></th>
                              </tr>
                            </thead>
                            <tfoot>
                            </tfoot>
                            <tbody>
                            </tbody>
                          </table>
                        </div>
                        <? }?>
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