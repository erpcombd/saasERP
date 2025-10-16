<?php
//
//
require "../../config/inc.all.php";
$head = '<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
$title = 'Daily Task List View';
do_calander('#from_date');
do_calander('#to_date');
$table = 'daily_task_master';
$unique = 'task_id';
//$pi_id = $_REQUEST['pi_id'];
$target_url = 'details_task_view.php';
$crud = new crud($table);
?>
<script language="javascript">
    function custom(theUrl)
    {
        window.open('<?= $target_url ?>?<?= $unique ?>=' + theUrl);
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
                    <td bgcolor="#99CCCC"><div align="right"><span style="font-size:14px;">Date Interval  : </span></div></td>
                    <td width="21%" bgcolor="#99CCCC"><div align="center">
                      <input name="from_date" type="text" id="from_date" value="<?=($_REQUEST['from_date']=='')?date('Y-m-01'):$_REQUEST['from_date'];?>" />
                    </div></td>
                    <td width="7%" bgcolor="#99CCCC"><div align="center">---To---</div></td>
                    <td width="21%" bgcolor="#99CCCC"><div align="center">
                      <input name="to_date" type="text" id="to_date" value="<?=($_REQUEST['to_date']=='')?date('Y-m-d'):$_REQUEST['to_date'];?>" />
                    </div></td>
                    <td width="27%" bgcolor="#99CCCC"><div align="center">
                      <input name="show" type="submit" class="style4" id="show" style="width:180px; height:30px; color:#339966; font-weight:bold; font-size:15px;" value="View Available PI" />
                    </div></td>
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
if($_SESSION['employee_selected']>0){
 $res='select m.task_id, m.task_id, m.task_date, b.PBI_NAME as employee_name, p.PROJECT_NAME, m.in_time, m.out_time from daily_task_master m,  project p, personnel_basic_info b where 1 and m.PBI_ID=b.PBI_ID and  m.project_id=p.PROJECT_ID and m.PBI_ID='.$_SESSION['employee_selected'].$con.' order by m.task_date desc';

}else{

$res='select m.task_id, m.task_id, m.task_date, u.fname as employee_name, p.PROJECT_NAME, m.in_time, m.out_time from daily_task_master m,  project p, user_activity_management u where 1 and m.entry_by=u.user_id and  m.project_id=p.PROJECT_ID '.$con.' order by m.task_date desc';}

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
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  
<script>
  $( function() {
    $( "#from_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:"yy-mm-dd"
    });
	 $( "#to_date" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat:"yy-mm-dd"
    });
  } );

});
  </script>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>
