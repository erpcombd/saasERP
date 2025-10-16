<?php

//
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
//====================== EOF ===================

//var_dump($_SESSION);

require "../../config/inc.all.php";



$task_id 		= $_REQUEST['task_id'];








 $sql1="select m.task_id, m.task_id, m.task_date, p.PROJECT_NAME, m.in_time, m.out_time,b.PBI_NAME from daily_task_master m,  project p, personnel_basic_info b where 1 and m.PBI_ID=b.PBI_ID and  m.project_id=p.PROJECT_ID and m.task_id=".$task_id;
//echo $sql1;
$data1=db_query($sql1);



$pi=0;

$total=0;

while($info=mysqli_fetch_object($data1)){ 

$task_date=$info->task_date;

$project_name=$info->PROJECT_NAME;

$in_time=$info->in_time;

$out_time=$info->out_time;

$employee_name=$info->PBI_NAME;

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: Daily Task Report :.</title>
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
                              <td bgcolor="#FFFFFF" style="text-align:center; color:#FFF; font-size:18px; font-weight:bold;"><span class="style1">Daily Task Report</span></td>
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
                              <td><strong><?php echo $project_name;?></strong>&nbsp;</td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Employee Name : </td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><?php echo $employee_name;?></td>
                            </tr>
                          </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">In Time :</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td><?php echo $in_time;?></td>
                            </tr>
                          </table></td>
                      </tr>
                      
                  </table></td>
                  <td width="46%" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="0"  style="font-size:13px">
                      <tr>
                        <td width="33%" align="right" valign="middle">Date :</td>
                        <td width="67%"><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;<strong><?php echo $task_date;?></strong></td>
                            </tr>
                        </table></td>
                      <tr>
                        <td align="right" valign="middle">&nbsp;</td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                          <tr>
                            <td></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td align="right" valign="middle">Out Time  : </td>
                        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                            <tr>
                              <td>&nbsp;
                                <?=$out_time?></td>
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
<? $prosql1="select distinct project_name from daily_task_details  where task_id=".$task_id;

$prodata1=db_query($prosql1);


while($proinfo=mysqli_fetch_object($prodata1)){ 
?>
      <table style="font-size:12px" width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5">
        <tr>
          <td colspan="4" align="left" bgcolor="#FFFFFF"><strong>Project Name : <?=find_a_field('project','PROJECT_NAME','PROJECT_ID='.$proinfo->project_name);?></strong></td>
        </tr>
        <tr>
		<td align="center" bgcolor="#CCCCCC"><strong>SL</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Module Name</strong> </td>
          <td align="center" bgcolor="#CCCCCC"><strong>Task Name</strong></td>
          <td align="center" bgcolor="#CCCCCC"><strong>Task details </strong></td>
        </tr>
<? $sql1="select * from daily_task_details where project_name=".$proinfo->project_name." and task_id=".$task_id;

$data1=db_query($sql1);

while($info=mysqli_fetch_object($data1)){ 
?>
        <tr>
          <td align="center" valign="top"><?=++$pi?></td>
          <td align="center" valign="top"><?=find_a_field('project_modul','MODUL_NAME','MODUL_ID='.$info->module_id);?></td>
          <td align="center" valign="top"><?=$info->task_name?></td>
          <td align="left" valign="top"><?=str_replace('.','.<br>',$info->task_desc)?></td>
        </tr>
        
        <? }?>
      </table>
	<br><br><br>  
	  <? $pi=0; } ?></td>
  </tr>
  
  
  <tr>
  <td>
  
  
  
  
  
  
                        <?
						$t_id = $_GET['task_id'];
                        $filename1 = './file1/' . $t_id . '.jpg';
                        $filename2 = './file2/' . $t_id . '.jpg';
                        $filename3 = './file3/' . $t_id . '.jpg';
                        if (file_exists($filename1)) {
                            ?>

                            <img src="<?= $filename1 ?>" style="border: 2px solid black; margin-top:10px; width: 100%;"></img>
                        <? } ?>
                        <? if (file_exists($filename2)) { ?>
                            <img src="<?= $filename2 ?>"  style="border: 2px solid black; margin-top:10px; width: 100%;" ></img>

                        <? } ?>
                        <?
                        if (file_exists($filename3)) {
                            ?>

                            <img src="<?= $filename3 ?>"  style="border: 2px solid black; margin-top:10px; width: 100%;" ></img>

                        <? } ?>
  
  
  
  
  
  
  
  
  
  </td>
  </tr>
  
  
  
  
  
  <tr>
    <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="5" style="font-size:12px">&nbsp;</td>
        </tr>
        
        <tr>
          <td align="center"><span class="style4"><?php echo $employee_name;?></span></td>
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
