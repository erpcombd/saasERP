<?php
session_start();
ob_start();
require_once "../../config/inc.all.php";
require_once 'Excel/reader.php';
function machine_read($data)
{
$flag=1;
for ($i = 2; $i <= $data['numRows']; $i++) {
$employee_id=$data['cells'][$i][3];
$time_day=explode(' ',$data['cells'][$i][2]);
$time_days=explode('/',$time_day[0]);
$time_second=explode(':',$time_day[1]);

$yr=$time_days[2]; $mon=$time_days[0]; $day=$time_days[1];
if($time_day[2]=='PM') $hr=$time_second[0]+12;
else $hr=$time_second[0];
$min=$time_second[1]; $sec=0;
$time_stamp=mktime($hr,$min,$sec,$mon,$day,$yr);


$daytime=date("Y-m-d H:i:s",$time_stamp);
$day=date("Y-m-d",$time_stamp);

if($employee_id>0){
$sch = find_all_field_sql('select p.off_day,s.office_start_time,s.office_end_time from personnel_basic_info p, hrm_schedule_info s where p.PBI_ID="'.$employee_id.'" and p.office_time=s.id');

	$date = date('Ymd',$time_stamp);
	if(date('N',$time_stamp)==$sch->off_day) $info['status'][$date]=0;
	else{
	if($sch->office_start_time == '')	$info['status'][$date]=1;
	else								{$info['late'][$date] = (int)(($time_stamp - strtotime($day.' '.$sch->office_start_time))/60);
	
	if($info['late'][$date]>0) 	$info['status'][$date]=2;
	else 						$info['status'][$date]=1;
	}}

$sql="INSERT INTO hrm_inout(employee_id, access_date, access_time, access_stamp, access_timestamp,off_day,start_time,end_time,status) VALUES ('$employee_id', '$day', '$daytime', '$time_stamp', CURRENT_TIMESTAMP ,'$sch->off_day', '$sch->office_start_time', '$sch->office_end_time', '".$info['status'][$date]."' )";
mysql_query($sql);}
}
}

// ::::: Edit This Section ::::: 
$title='Upload Attendance';			// Page Name and Page Title
$page="upload_attendance.php";		// PHP File Name

$root='attendence';

$table='hrm_inout';		// Database Table Name Mainly related to this page
$unique='id';			// Primary Key of this Database table
$shown='id';				// For a New or Edit Data a must have data field

// ::::: End Edit Section :::::
// ::::: End Edit Section :::::

$crud      =new crud($table);

$$unique = $_GET[$unique];
if(isset($_POST[$shown]))
{
	
$$unique = $_POST[$unique];

if(isset($_POST['insert'])||isset($_POST['insertn']))
{		

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');

	if($_FILES['file']['name']!='')
	{
		$date=time();
		$machine=$_POST['machine'];
		$file_name=$date.'.xls';
		$file_path="Excel/".$file_name;
		
		if(move_uploaded_file($_FILES['file']['tmp_name'],$file_path))
		{
		$data->read($file_path);
		$datas = $data->sheets[0];
		$num_rows = $data->sheets[0]['numRows'];
		 $data->sheets[0]['numCols'];


			machine_read($datas);
			
		$done='1';
		}
	}



$type=1;
$msg='New Entry Successfully Inserted.';

unset($_POST);
unset($$unique);
}


//for Modify..................................

if(isset($_POST['update']))
{

		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';

}
//for Delete..................................

if(isset($_POST['delete']))
{		$condition=$unique."=".$$unique;		$crud->delete($condition);
		unset($$unique);

		$type=1;
		$msg='Successfully Deleted.';
}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=@each($data))
{ $$key=$value;}
}
if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

$$unique = $_GET[$unique];

?>
<script type="text/javascript"> function DoNav(lk){
	document.location.href = '<?=$page?>?<?=$unique?>='+lk;
	}</script>
	<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-weight: bold;
}
-->
    </style>
	


<div class="oe_view_manager oe_view_manager_current">
<form action="" method="post" enctype="multipart/form-data">  
<? include('../../common/title_bar.php');?>
</form>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
    <header>
    <? if(!isset($_GET[$unique])&&($_SESSION['user']['level']>1)){?>
    <span class="oe_form_buttons_edit" style="display: inline;">
      <button name="insert" accesskey="S" class="oe_button oe_form_button_save oe_highlight" type="submit">Upload</button>
    </span>
    <? }?>
 
    <ul class="oe_form_field_status oe_form_status">
    
        <li class="oe_active" data-id="draft">
            <span class="label">Data Successfully Saved</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
        <li class="" data-id="posted">
            <span class="label">Report</span>
            
            <span class="arrow"><span></span></span>
        </li>
    
</ul>
<div class="oe_clear"></div>
</header>
<div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width" style="min-height:100px;">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1>
		  <? if($done==1){?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="30" bgcolor="#66FF99"><div align="center" class="style1">Sucessfully Uploaded. </div></td>
          </tr>
        </table><? }?>
        <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0"><tbody><tr class="oe_form_group_row">
            <td class="oe_form_group_cell"><table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr class="oe_form_group_row">
                  <td colspan="1" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Upload Attendance File(Excel)<strong>:</strong></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell"><input type="file" name="file" />
                    <input type="hidden" name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" />
                    <label for="textfield"></label>
                    <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$_SESSION['employee_selected']?>" /></td>
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell">&nbsp;</td>
                </tr>
<? if($$unique>0){?>
<? }?>
                <tr class="oe_form_group_row">
                  <td colspan="4" class="oe_form_group_cell">&nbsp;</td>
                </tr>
                </tbody></table>
</td>
          </tr></tbody></table>
                  </div>
                </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
        </form>
    </div>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../../template/main_layout.php");
?>