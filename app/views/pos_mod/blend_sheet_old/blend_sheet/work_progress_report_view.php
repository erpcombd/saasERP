<?php

session_start();

//====================== EOF ===================

//var_dump($_SESSION);

require_once "../../../assets/support/inc.all.php";



$oi_no 		= $_REQUEST['v_no'];








$sql1="select m.*, p.project_name, c.name, l.location, u.fname from cons_daily_progress_master m, user_activity_management u, cons_supervisor c, cons_location l, cons_project p  where m.project_id=p.id and m.location=l.id and m.supervisor_id=c.id and m.entry_by=u.user_id and m.id = '".$oi_no."'";
//echo $sql1;
$data1=mysql_query($sql1);



$pi=0;

$total=0;

while($info=mysql_fetch_object($data1)){ 

$entry_date=$info->entry_date;

$project_id=$info->project_name;

$location=$info->location;

$supervisor_id=$info->name;

$time_of_arrival=$info->time_of_arrival;

$type_of_vehicle=$info->type_of_vehicle;

$distance_travelled=$info->distance_travelled;

$client_contact_person=$info->client_contact_person;

$weather=$info->weather;

$target_work_time=$info->target_work_time;

$target_finish_date=$info->target_finish_date;

$worked_hour=$info->worked_hour;

$reason=$info->reason;

$prepare_by=$info->fname;
}









?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Other Issue Report :.</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">

function hide()

{

    document.getElementById("pr").style.display="none";

}

</script>
<style type="text/css">
<!--
.style1 {color: #000000}
.style4 {font-size: 12px; font-style: italic; }
-->
</style>
</head>
<body style="font-family:Tahoma, Geneva, sans-serif">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><table width="60%" border="0" align="center" cellpadding="5" cellspacing="0">
                            <tr>
                              <td bgcolor="#FFFFFF" style="text-align:center; color:#FFF; font-size:18px;"><span class="style1"><strong>AKSID Corporation Limited</strong>
                                </br>
                              Flat-5/A, Plot-4, Road-12, Block-j, Baridhara, Dhaka-1212</span></td>
                            </tr>
                            <tr>
                              <td bgcolor="#FFFFFF" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;"><span class="style1">Daily Progress Report</span></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="54%" valign="top"><table width="100%" border="0" align="left" cellpadding="3" cellspacing="0"  style="font-size:13px">
                      <tr>
                        <td width="40%" align="right" valign="middle">Project Name : </td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><strong><?php echo $project_id;?></strong>&nbsp;</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Supervisor Name:</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><?php echo $supervisor_id;?></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle"> Time of Arrival :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><?php echo $time_of_arrival ;?></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Type of Vehicle :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><?php echo $type_of_vehicle;?></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Target Finish Date :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><?php echo $target_finish_date;?></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Client Contact Person  :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><?php echo $client_contact_person;?></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                  <td width="46%" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0"  style="font-size:13px">
                      <tr>
                        <td width="33%" align="right" valign="middle">Date :</td>
                        <td width="67%"><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;<strong><?php echo $entry_date;?></strong></td>
                            </tr>
                        </table></td>
                      <tr>
                        <td align="right" valign="middle">Location : </td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;
                                <?=$location?></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Target Work Time :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;<?php echo $target_work_time ;?></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Distance Travelled :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;<?php echo $distance_travelled;?></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Worked Hour :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;<?php echo $worked_hour;?></td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Reason :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;<?php echo $reason;?></td>
                            </tr>
                        </table></td>
                      </tr>
					  
					  <tr>
                        <td align="right" valign="middle">Today's Weather  :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;<?php echo $weather ;?></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><div id="pr">
        <div align="left">
          <input name="button" type="button" onclick="hide();window.print();" value="Print" />
        </div>
      </div>
      <table style="font-size:12px" width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
        <tr>
          <td colspan="7" align="center" bgcolor="#FFFFFF"><strong>List of Worker </strong></td>
        </tr>
        <tr>
		<td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Name</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Dressed</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Start Time </strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>End Time </strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Fooding</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Remarks</strong></td>
        </tr>
<? $sql1="select w.*, p.PBI_NAME from cons_daily_progress_worker_details w, personnel_basic_info p where w.worker_name=p.PBI_ID and w.proj_id = '".$oi_no."'";

$data1=mysql_query($sql1);

$pi=0;

$total=0;

while($info=mysql_fetch_object($data1)){ 

$pi++;?>
        <tr>
          <td align="center" valign="top"><?=$pi?></td>
          <td align="left" valign="top"><?=$info->PBI_NAME?></td>
          <td align="center" valign="top"><?=$info->dress?></td>
          <td align="right" valign="top"><?=$info->start_time?></td>
          <td align="right" valign="top"><?=$info->finish_time?></td>
          <td align="right" valign="top"><?=$info->fooding_expense?></td>
		  <td align="center" valign="top"><?=$info->worker_remarks?></td>
        </tr>
        <? }?>
      </table></td>
  </tr>
  <tr>
    <td><div id="pr">
        <div align="left"></div>
      </div>
      <table  style="font-size:12px" width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
        
        <tr>
          <td style="border: 0" colspan="6" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        
        <tr>
          <td style="border: 0" colspan="6" align="center" bgcolor="#FFFFFF"><strong>Local Purchase </strong></td>
        </tr>
        <tr>
		<td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Description</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Qty</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Rate</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Amount</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Purpose</strong><strong></strong></td>
        </tr>
<? $sql1="select * from cons_daily_progress_purchase_details  where proj_id = '".$oi_no."'";

$data1=mysql_query($sql1);

$pi=0;

$total=0;

while($info=mysql_fetch_object($data1)){ 
$total_amt+=$info->amount;
$pi++;?>
        <tr>
          <td align="center" valign="top"><?=$pi?></td>
          <td align="left" valign="top"><?=$info->description?></td>
          <td align="right" valign="top"><?=$info->qty?></td>
          <td align="right" valign="top"><?=$info->rate?></td>
          <td align="right" valign="top"><?=number_format($info->amount,2)?></td>
		  <td align="right" valign="top"><?=$info->purchase_remarks?></td>
        </tr>
        
        <? }?>
		<tr>
          <td colspan="4" align="right" valign="top">Total : </td>
          <td align="right" valign="top"><?=number_format($total_amt,2)?></td>
          <td align="right" valign="top">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><div id="pr">
        <div style="page-break-after:always" align="left"></div>
      </div>
      <table style="font-size:12px" width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
        <tr>
          <td style="border: 0" colspan="5" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        
        <tr>
          <td  style="border: 0" colspan="5" align="center" bgcolor="#FFFFFF"><strong>Material Status </strong></td>
        </tr>
        <tr>
          <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Material / Particular </strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Required Qty </strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Available Qty </strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Purpose</strong><strong></strong></td>
        </tr>
<? $sql1="select * from cons_daily_progress_material_details  where proj_id = '".$oi_no."'";

$data1=mysql_query($sql1);

$pi=0;

$total=0;

while($info=mysql_fetch_object($data1)){ 

$pi++;?>
        <tr>
          <td align="center" valign="top"><?=$pi?></td>
          <td valign="top"><?=$info->material?></td>
          <td align="right" valign="top"><?=$info->required_qty?></td>
          <td align="right" valign="top"><?=$info->available_qty?></td>
          <td align="right" valign="top"><?=$info->material_remarks?></td>
        </tr>
        <? }?>
      </table></td>
  </tr>
  <tr>
    <td><div id="pr">
        <div align="left"></div>
      </div>
      <table style="font-size:12px" width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
        <tr>
          <td style="border: 0" colspan="6" align="center" bordercolor="#FFFFFF" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        
        <tr>
          <td  style="border: 0" colspan="6" align="center" bgcolor="#FFFFFF"><strong>Work Progress </strong></td>
        </tr>
        <tr>
          <td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Particular</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Location</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Percentage Done Today </strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Target of Tomorrow </strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Purpose</strong><strong></strong></td>
        </tr>
<? $sql1="select * from cons_daily_progress_work_details  where proj_id = '".$oi_no."'";

$data1=mysql_query($sql1);

$pi=0;

$total=0;

while($info=mysql_fetch_object($data1)){ 

$pi++;?>
        <tr>
          <td align="center" valign="top"><?=$pi?></td>
          <td valign="top"><?=$info->particular?></td>
          <td align="left" valign="top"><?=$info->location?></td>
          <td align="right" valign="top"><?=$info->percentage_done_today?></td>
          <td align="right" valign="top"><?=$info->target_of_tomorrow?></td>
          <td align="right" valign="top"><?=$info->work_remarks?></td>
        </tr>
        <? }?>
      </table></td>
  </tr>
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="5" style="font-size:12px">&nbsp;</td>
        </tr>
        
        <tr>
          <td align="center"><span class="style4"><?php echo $prepare_by;?></span></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        
        
        <tr align="center">
          <td>.........................</td>
          <td>.........................</td>
          <td>.........................</td>
          <td>.........................</td>
          <td>.........................</td>
        </tr>
        <tr align="center">
          <td><span class="style4">Prepared By </span></td>
          <td><span class="style4">Report By </span></td>
          <td><span class="style4">Checked By </span></td>
          <td><span class="style4">Sr. Project Engineer </span></td>
          <td><span class="style4">Managing Director </span></td>
        </tr>
      </table>
      <div class="footer1"> </div></td>
  </tr>
</table>
</body>
</html>
