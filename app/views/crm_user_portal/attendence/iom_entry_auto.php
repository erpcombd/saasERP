<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#f_date');
do_calander('#t_date');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';


if(isset($_POST['confirm'])){

if($_POST['PBI_ID']) $emp_id_in=$_POST['PBI_ID'];

$group_for=$_POST['group_for'];
$iom_type=$_POST['iom_type'];
$iom_reason=$_POST['iom_reason'];
$iom_entry_at=date('Y-m-d H:i:s');
$iom_entry_by=$_SESSION['user']['id'];
$s_date=($_POST['f_date']);
$e_date=($_POST['t_date']);

$from_date=$_REQUEST['s_date']=strtotime($_POST['f_date']);
$to_date=$_REQUEST['e_date']=strtotime($_POST['t_date']);	


$sqlaa = 'select PBI_ID as code,PBI_NAME from personnel_basic_info where PBI_ID IN ('.$emp_id_in.') 
and PBI_ORG="'.$group_for.'"';
$queryaa = db_query($sqlaa);
while($dataaa = mysqli_fetch_object($queryaa)){



$old_iom = find_a_field('hrm_att_summary','iom_sl_no',' att_date between "'.$_REQUEST['f_date'].'" and  "'.$_REQUEST['t_date'].'" 
and  emp_id="'.$dataaa->code.'" and iom_sl_no>0');
//echo ' att_date between "'.$_REQUEST['s_date'].'" and  "'.$_REQUEST['e_date'].'" and  emp_id="'.$code.'" and iom_sl_no>0';

if($old_iom==0){
$from_dates = date_create($from_date);
$to_dates = date_create($to_date);
$diff = date_diff(date_create($s_date),date_create($e_date)); $total_days =  $diff->format("%a")+1;


$ssql = "INSERT INTO hrm_iom_info (dept_head_status ,PBI_ID ,type ,s_date ,e_date , reason ,total_days)
VALUES (  'Approve', '".$dataaa->code."', 'Regular',  '".$_POST['f_date']."', '".$_POST['t_date']."', '".$iom_reason."','".$total_days."')";
db_query($ssql);
	$iom_sl_no=  db_insert_id();


	for($i=$from_date; $i<=$to_date; $i=$i+86400){
	
		$att_date=date('Y-m-d',$i);
		$found = find_a_field('hrm_att_summary','1','emp_id="'.$dataaa->code.'" and att_date="'.$att_date.'"');
			if($found==0){
			
				$sql="INSERT INTO hrm_att_summary (emp_id, iom_type, iom_sl_no, iom_reason, att_date, iom_entry_at, iom_entry_by, dayname)
				VALUES ('$dataaa->code', '$iom_type', '$iom_sl_no', '$iom_reason', '$att_date', '$iom_entry_at', '$iom_entry_by', dayname('".$att_date."'))";
				$query=db_query($sql);
			}
			else
			{
				$sql='update hrm_att_summary set 
				iom_type="'.$iom_type.'", iom_sl_no="'.$iom_sl_no.'", iom_reason="'.$iom_reason.'", dayname=dayname("'.$att_date.'") ,iom_entry_at="'.$iom_entry_at.'", iom_entry_by="'.$iom_entry_by.'"
				where  emp_id="'.$dataaa->code.'" and att_date="'.$att_date.'" ';
				$query=db_query($sql);
			}
	} // end for
	
//echo $msggg= "<h2 style='color:#FF0000'>Done. Code: ".$dataaa->code."</h2>";
} else {echo $msggg= "<h2 style='color:#FF0000'>You Can't Add Duplicate IOM Code $dataaa->code </h2>";
echo $att_date;
}


} // while
echo "IOM Entry Complete";
} // if


		






?>
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
  <form action=""  method="post">
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
                            <td height="40" colspan="5" bgcolor="#00FF00"><div align="center" class="style1">IOM Entry Auto </div></td>
                          </tr>
                          
                          <tr>
                            <td><div align="right">Company: </div></td>
                            <td colspan="3"><select name="group_for" id="group_for"  required="required">
<? foreign_relation('user_group', 'id', 'group_name',$_POST['group_for'],'1 ')?>
                            </select></td>
                            <td rowspan="6">&nbsp;</td>
                          </tr>
                          <tr>
                            <td><div align="right">Employee Code: </div></td>
<td colspan="3"><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" 
style="width:600px; height:50px;" 
value="1867,12205,5060" required="required"/></td>
                          </tr>
                          <tr>
                            <td align="right">&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="right"><div align="right">IOM Type </div></td>
                            <td><select name="iom_type" id="iom_type">
                                <option>REGULAR</option>
                              </select></td>
                            <td><div align="right">Reason</div></td>
                            <td><input name="iom_reason"  type="text" id="iom_reason" size="10" onblur="" tabindex="1" style="width:400px;" 
							value="Sajeeb Cricket Game" /></td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="right">&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>

<td width="20%"><div align="right">FROM:</div></td>
<td><input type="text" name="f_date" id="f_date" style="width:100px;" 
value="<? if(isset($_POST['f_date'])){ echo $_POST['f_date'];}else{ echo date('Y-m-d');}?>"  /></td>
                            
<td align="right"><div align="right">TO:</div></td>
<td><input type="text" name="t_date" id="t_date" style="width:100px;" 
value="<? if(isset($_POST['t_date'])){ echo $_POST['t_date'];}else{ echo date('Y-m-d');}?>"  /></td>
                          </tr>
                          <tr>
                            <td colspan="5">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="5"><label>
                              <div align="center">
                                <input name="confirm" type="submit" id="confirm" value="SUBMIT" />
                              </div>
                              </label></td>
                          </tr>
                        </table>
                        <br />


Note: This is for Bulk IOM System. 
<br>But remember, Roaster Person must be fillup Roaster Schedule at first, Other wise it not effect in Salary Sheet


                        
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

require_once SERVER_CORE."routing/layout.bottom.php";
?>
