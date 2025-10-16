<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Roster Auto';

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#roster_date');
do_calander('#roster_date2');


if(isset($_POST['save']))
{		
		if($_POST['designation']>0)
		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0)
		$con .=' and a.DEPT_ID='.$_POST['department'];
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
		
$r_date = $rp1_date = $rp2_date = $rp3_date = $_POST['roster_date'];
$re_date = $_POST['roster_date2'];
		
		$roster_date = $_POST['roster_date'];
		$entry_by = $_SESSION['user']['id'];
		
		while(strtotime($rp3_date) <= strtotime($re_date)){ 

		$point = $_POST['p_'.$info->PBI_ID];
		$shedule = $_POST['s_'.$info->PBI_ID];
		$del_sql = "delete from hrm_roster_allocation where PBI_ID='".$info->PBI_ID."' and roster_date = '".$rp3_date."'";
		db_query($del_sql);
		$insSql = 'INSERT INTO hrm_roster_allocation( PBI_ID, roster_date, point_1, shedule_1, job_location,group_for, entry_by) VALUES ("'.$info->PBI_ID.'", "'.$rp3_date.'", "'.$point.'", "'.$shedule.'", "'.$_POST['job_location'].'", "'.$_POST['group_for'].'", "'.$entry_by.'")';
		db_query($insSql);
 		$rp3_date = date ("Y-m-d", strtotime("+1 day", strtotime($rp3_date)));} 
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

<style>

label{
font-weight:bold;
}
. col-md-3{
 float:left
 }
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
                              <th colspan="2" style="text-align:center"><span style="text-align: center; font-size:18px; color:#09F">Roster Day Set For 7 Days </span></th>
                            </tr>
                            <tr class="oe_list_header_columns">
                              <th colspan="2" style="text-align:center"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
                            </tr>
                          </thead>
                          <tfoot>
                          </tfoot>
                          <div class="row">
                            <div class="col-md-3 form-group">
                <label for="rcv_amt">7 Days Start From Date  : </label>
               <input name="rcv_amt" type="date" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
               </div>
			                <div class="col-md-3 form-group">
                <label for="rcv_amt">ompany : </label>
               <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
               </div>
			                <div class="col-md-3 form-group">
                <label for="rcv_amt">Job Location  : </label>
               <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
               </div>
			                <div class="col-md-3 form-group">
                <label for="rcv_amt">Departmant: </label>
               <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
               </div>
			                <div class="col-md-3 form-group">
                <label for="rcv_amt">Section: </label>
               <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />
               </div>
        
							 
                             <tr>
                            <td colspan="2" align="center" style="text-align: right"><div align="center">
                              <input name="create" id="create" value="SHOW EMPLOYEE" type="submit">
                            </div></td>
                            </tr>
							
                          </div>
                        </table>
                        <br />
                        <? if($_REQUEST['area']>0){
						
                   $r_date = $rp1_date = $rp2_date = $rp3_date = $_POST['roster_date'];
                   $re_date = $_POST['roster_date2'];

						?>
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
                                        <th>LOC</th>
                                        <th>SCH</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?
	
		if($_POST['designation']>0)
		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0)
		$con .=' and a.DEPT_ID='.$_POST['department'];
		if($_POST['job_location']>0)
		$con .=' and a.JOB_LOCATION='.$_POST['job_location'];
		if($_POST['group_for']>0)
		$con .=' and a.PBI_ORG='.$_POST['group_for'];
		if($_POST['PBI_DOMAIN']!='')
		$con .=' and a.PBI_DOMAIN="'.$_POST['PBI_DOMAIN'].'"';
		
		
		
		$sql = "select a.PBI_NAME,a.PBI_ID,a.PBI_DESIGNATION,a.PBI_DEPARTMENT from 
		personnel_basic_info a
		where  1 ".$con."  and a.PBI_JOB_STATUS='In Service' order by a.PBI_ID ";
		$query = db_query($sql);
		while($info=mysqli_fetch_object($query))
		{
		$rp2_date = $r_date;
		

		?>
                                      <tr style="font-size:10px; padding:3px; ">
                                        <td><?=$info->PBI_ID?><input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
                                        <td><?=$info->PBI_NAME?></td>
                                        <td><?=$info->PBI_DESIGNATION?></td>
                                        <td><?=$info->PBI_DEPARTMENT?></td>
                                        <td><select name="p_<?=$info->PBI_ID?>" id="p_<?=$info->PBI_ID?>" style="width:70px; font-size:12px;">
										<? foreign_relation('hrm_roster_point','id','point_short_name',$point[$info->PBI_ID],'group_for = "'.$_POST['group_for'].'"');?>
                                        </select>                                        </td>




<td><select name="s_<?=$info->PBI_ID?>" id="s_<?=$info->PBI_ID?>" style="width:70px; font-size:12px"><? foreign_relation('hrm_schedule_info','id','schedule_name',$shedule[$info->PBI_ID][$rp2_date],'group_for = "'.$_POST['group_for'].'"');?></select></td>
                         </tr><? }?>
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
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