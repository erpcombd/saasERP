<?php
//
//
require "../../config/inc.all.php";
$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title = 'Given Task List';
do_calander('#from_date');
do_calander('#to_date');
$table = 'daily_give_task_master';
$unique = 'task_id';
//$pi_id = $_REQUEST['pi_id'];
$target_url = 'add_task.php';
$crud = new crud($table);
?>
<script language="javascript">
    function custom(theUrl)
    {
        window.open('<?= $target_url ?>?untask_id=' + theUrl);
    }
</script>

<div class="form-container_large" style="">
  <form action="" method="post" name="codz" id="codz">
    <div class="oe_view_manager oe_view_manager_current">
      <? include('../../common/title/title_bar_lc.php');?>
      <div class="oe_form_sheetbg">
        <div style="min-height:35px;" class="oe_form_sheet oe_form_sheet_width">
          <div class="oe_view_manager_view_list">
            <div class="oe_list oe_view">
              <table width="100%" height="35px;" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                    <td width="24%" bgcolor="#99CCCC"><div align="right"><span style="font-size:14px;">Date Interval  :</span></div></td>
                    <td width="21%" bgcolor="#99CCCC"><div align="center">
                      <input name="from_date" type="text" id="from_date" value="<?=($_REQUEST['from_date']=='')?date('Y-m-01'):$_REQUEST['from_date'];?>" />
                    </div></td>
                    <td width="10%" bgcolor="#99CCCC"><div align="center">---TO---</div></td>
                    <td width="24%" bgcolor="#99CCCC"><div align="center">
                      <input name="to_date" type="text" id="to_date" value="<?=($_REQUEST['to_date']=='')?date('Y-m-d'):$_REQUEST['to_date'];?>" />
                    </div></td>
                    <td width="21%" bgcolor="#99CCCC"><input name="show" type="submit" class="style4" id="show" style="width:180px; height:30px; color:#339966; font-weight:bold; font-size:15px;" value="View List" /></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<? if($_POST['show']){?>
<div class="oe_form_sheetbg">
  <div class="oe_form_sheet oe_form_sheet_width">
    <div  class="oe_view_manager_view_list">
      <div  class="oe_list oe_view">
<? 
if($_POST['from_date'] !=''  && $_POST['from_date'] !='')
$con.= ' and m.task_date BETWEEN  "'.$_POST['from_date'].'" and "'.$_POST['to_date']. '"';											

$res='select m.task_id, m.task_id, m.task_date, p.PROJECT_NAME,b.PBI_NAME,m.status from daily_give_task_master m,  project p,personnel_basic_info b where m.given_to=b.PBI_ID and  m.project_id=p.PROJECT_ID '.$con.' order by m.task_date desc';


//echo $res; 
//echo mysqli_error();
echo link_report($res,$link);


?>
      </div>
    </div>
  </div>
</div>
<? }
?>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>
