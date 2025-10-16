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

do_calander('#f_date');
do_calander('#t_date');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

//auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','1 and PBI_ORG="'.$_SESSION["user"]["group"].'" and JOB_LOCATION not in("1","") ','PBI_ID');

$table='hrm_iom_info';
$unique='id';
$shown='PBI_ID';
$crud      =new crud($table);


if($_GET['emp_id']>0) $emp_id=$_GET['emp_id'];
if($_POST['PBI_ID']>0) $emp_id=$_POST['PBI_ID'];


if($_GET['emp_id']>0&&$_GET['iom_sl_no']>0)

{		


$sql="delete from hrm_iom_info where id='".$_GET['iom_sl_no']."'";
db_query($sql);

$up_query='update hrm_att_summary set iom_type="", iom_sl_no="", iom_reason="", iom_approved_by="", iom_entry_at="0000-00-00 00:00:00", iom_entry_by="" where iom_sl_no="'.$_GET['iom_sl_no'].'" and emp_id="'.$_GET['emp_id'].'"';
db_query($up_query);

echo 'Deleted';
}


if(prevent_multi_submit()){
if(isset($_POST['search'])&&$_POST['t_date']!=''&&$_POST['f_date']!='')
{		

$iom_type=$_POST['iom_type'];
$iom_reason=$_POST['reason']=$_POST['iom_reason'];
$iom_entry_at=date('Y-m-d H:i:s');
$iom_entry_by=$_SESSION['user']['id'];
$s_date=($_POST['f_date']);
$e_date=($_POST['t_date']);

$from_date=$_REQUEST['s_date']=strtotime($_POST['f_date']);
$to_date=$_REQUEST['e_date']=strtotime($_POST['t_date']);

$old_iom = find_a_field('hrm_att_summary','iom_sl_no',' att_date between "'.$_REQUEST['f_date'].'" and  "'.$_REQUEST['t_date'].'" and  emp_id="'.$emp_id.'" and iom_sl_no>0');
//echo ' att_date between "'.$_REQUEST['s_date'].'" and  "'.$_REQUEST['e_date'].'" and  emp_id="'.$emp_id.'" and iom_sl_no>0';
if($old_iom==0){
$from_dates = date_create($from_date);
$to_dates = date_create($to_date);
$diff = date_diff(date_create($s_date),date_create($e_date)); $total_days =  $diff->format("%a")+1;


$ssql = "INSERT INTO hrm_iom_info (
`dept_head_status` ,
`PBI_ID` ,
`type` ,
`s_date` ,
`e_date` , 
`reason` ,
`total_days`
)
VALUES (  'Approve', '".$emp_id."', 'Regular',  '".$_POST['f_date']."', '".$_POST['t_date']."', '".$iom_reason."','".$total_days."')";
db_query($ssql);
	$iom_sl_no=  mysqli_insert_id();




	for($i=$from_date; $i<=$to_date; $i=$i+86400)
	{
		$att_date=date('Y-m-d',$i);
		
		$found = find_a_field('hrm_att_summary','1','emp_id="'.$emp_id.'" and att_date="'.$att_date.'"');
		
			if($found==0)
			{
				$sql="INSERT INTO hrm_att_summary (emp_id, iom_type, iom_sl_no, iom_reason, att_date, iom_entry_at, iom_entry_by, dayname)
				VALUES ('$emp_id', '$iom_type', '$iom_sl_no', '$iom_reason', '$att_date', '$iom_entry_at', '$iom_entry_by', dayname('".$att_date."'))";
				$query=db_query($sql);
			}
			else
			{
				$sql='update hrm_att_summary set 
				iom_type="'.$iom_type.'", iom_sl_no="'.$iom_sl_no.'", iom_reason="'.$iom_reason.'", dayname=dayname("'.$att_date.'") ,iom_entry_at="'.$iom_entry_at.'", iom_entry_by="'.$iom_entry_by.'"
				where  emp_id="'.$emp_id.'" and att_date="'.$att_date.'" ';
				$query=db_query($sql);
			}
	} 
}
else echo $msggg= "<h2 style='color:#FF0000'>You Can't Add Duplicate IOM</h2>";
}}
		
//		if(isset($$unique))
//{
//$condition=$unique."=".$$unique;
//$data=db_fetch_object($table,$condition);
//foreach($data as $key => $value)
//{ $$key=$value;}
//}
//if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>
<script type="text/javascript"> function DosNav(lk1,lk2){
	window.open('../attendence/iom_entry.php?iom_sl_no='+lk1+'&emp_id='+lk2,'_self');
	}</script>
<style type="text/css">

<!--

.style1 {font-size: 24px}
.style3 {
	font-size: 16px;
	font-weight: bold;
	color: #0000FF;
}

-->

</style>
<div class="oe_view_manager oe_view_manager_current">
  <form action="?"  method="post">
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
                        <table width="80%" border="1" align="center">
                          <tr>
                            <td height="40" colspan="5" bgcolor="#00FF00"><div align="center" class="style1">IOM Entry</div></td>
                          </tr>
                          
                          <tr>
                            <td><div align="right">Employee Code: </div></td>
                            <td><select name="PBI_ID" id="PBI_ID" required="required" class="form-control">
                              <option>
                              <? if(isset($_POST['PBI_ID'])){ echo $_POST['PBI_ID']; }else{echo''; } ?>
                              </option>
                              <?php 
	auto_dropdown("select PBI_ID,concat(PBI_ID,'-',PBI_NAME) from personnel_basic_info 
	where PBI_ORG='".$_SESSION['user']['group']."' and PBI_JOB_STATUS = 'In Service' and JOB_LOCATION not in('1','','70')"); ?>
                            </select></td>
                            <td>&nbsp;</td>
                            <td><input name="view_data" type="submit" id="view_data" value="VIEW" / class="form-control"></td>
                            <td rowspan="3"><img src="../../pic/staff/<?php echo $emp_id;?>.jpg" width="122" height="117" /></td>
                          </tr>
                          <tr>
                            <td align="right"><div align="right">IOM Type </div></td>
                            <td><select name="iom_type" id="iom_type" class="form-control">
                                <option>REGULAR</option>
                              </select></td>
                            <td><div align="right">Reason</div></td>
                            <td><input name="iom_reason"  type="text" id="iom_reason" size="10" onblur="" tabindex="1" style="width:400px;" 
							value="." required="required"/ class="form-control"></td>
                          </tr>
                          <tr>
                            <td width="20%"><div align="right">FROM:</div></td>
                            <td><input type="text" name="f_date" id="f_date" style="width:100px;" value="<?=$f_date?>"  / class="form-control"></td>
                            <td align="right"><div align="right">TO:</div></td>
                            <td><input type="text" name="t_date" id="t_date" style="width:100px;" value="<?=$t_date?>"  / class="form-control"></td>
                          </tr>
                          <tr>
                            <td colspan="5"  style="text-align:center"><label>
                              <div align="center">
                                <input name="search" type="submit" id="search" value="SUBMIT" / class="form-control">
                              </div>
                              </label></td>
                          </tr>
                        </table>
                        <br />
                        <div style="text-align:center">
                          <div class="oe_form_sheetbg">
                            <div class="oe_form_sheet oe_form_sheet_width">
                              <div class="oe_view_manager_view_list">
                                <div class="oe_list oe_view">
                                  <? if($emp_id>0 || $_POST['view_data']){?>
                                  <center>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td align="center"><span class="style3"> <strong>Employee Name: </strong>
                           <? $pbi_date=find_all_field('personnel_basic_info','',' PBI_ID='.$emp_id); echo $pbi_date->PBI_NAME.' ('.$pbi_date->PBI_DESIGNATION.')'; ?>
                                          </span></td>
                                      </tr>
                                    </table>
                                  </center>

 <table class="display dataTable no-footer"><thead><tr class="oe_list_header_columns"><th>Id</th><th>Emp Id</th><th>Iom Type</th>
   <th>Iom No</th>
   <th>Reason</th><th>Att Date</th>
   <th>Entry At</th>
   <th>Action</th>
   </tr></thead><tfoot><tr><td></td><td></td><td></td><td></td><td></td><td></td>
       <td></td>
       <td></td>
       </tr></tfoot><tbody>
<?
$res="SELECT iom_sl_no,id,emp_id, iom_type, iom_sl_no, iom_reason, att_date, iom_entry_at 
FROM hrm_att_summary 
WHERE emp_id=$emp_id and iom_sl_no>0 
and att_date >= '2019-01-01'
order by att_date desc";

$query = db_query($res);
while($data=mysqli_fetch_object($query)){
?>
<tr <?=(++$i%2)?'class="alt"':'';?>>
<td><?=$data->id?></td><td><?=$data->emp_id?></td><td><?=$data->iom_type?></td><td><?=$data->iom_sl_no?></td><td><?=$data->iom_reason?></td><td><?=$data->att_date?></td><td><?=$data->iom_entry_at?></td>
<td><? 	//if(
	//$_SESSION['user']['username']=='faysal'|| // faysal
	//$_SESSION['user']['username']=='9999'		// firoz		
	//){ ?><input type="button" name="button" id="button" value="Delete" onclick="DosNav(<?=$data->iom_sl_no?>,<?=$data->emp_id?>)" /><? //}?>
</td>
</tr>
<? }?></tbody></table>
 <? }?>
                                </div>
                              </div>
                            </div>
                          </div>
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
  </form>
</div>
<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>
