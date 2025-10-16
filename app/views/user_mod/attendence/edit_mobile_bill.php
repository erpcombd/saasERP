<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#m_date');

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$table='hrm_inout';

$unique='id';

$u_sql="select * from hrm_moblie_bill where year='".$_POST['year']."' and month='".$_POST['mon']."'";
	$u_query=db_query($u_sql);
	while($u_data=mysqli_fetch_object($u_query)){
	if(isset($_POST['update_'.$u_data->id])){
	 $upq="UPDATE `hrm_moblie_bill` SET `mobile_bill`='".$_POST['mobile_bill_'.$u_data->id]."' WHERE id=".$u_data->id;
	db_query($upq);
	}
	}
	
	 
if(isset($_POST['show']))
{
	$mon=$_POST['mon'];
	$dept=$_POST['dept'];
	$year=$_POST['year'];
	$bonus=$_POST['bonus'];
}else{
$mon=date('n');
$year=date('Y');
}
?>





<style type="text/css">

<!--

.style1 {font-size: 24px}

-->

</style>





<div class="oe_view_manager oe_view_manager_current">

        <form action=""  method="post" enctype="multipart/form-data">



        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">

		     

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

            <table width="80%" border="1" align="center">

              <tr>

                <td height="40" colspan="5" bgcolor="#00FF00"><div align="center" class="style1">Edit Mobile Bill  </div></td>
                </tr>

              <tr>

                <td width="20%"><div align="right">Year : </div></td>

                <td><select name="year" style="width:160px;" id="year" required="required">
                    <? foreign_relation('hrm_moblie_bill','year','year',$year,'1 group by year order by year asc')?>
                </select></td>
                <td>Month</td>
                <td><span class="oe_form_group_cell">
                  <select name="mon" style="width:160px;" id="mon" required="required">
                    <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
                    <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
                    <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
                    <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
                    <option value="5" <?=($mon=='5')?'selected':''?>>May</option>
                    <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>
                    <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
                    <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
                    <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
                    <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
                    <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
                    <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
                  </select>
                </span></td>
                <td><input name="show" type="submit" id="show" value="SHOW" /></td>
              </tr>
            </table>

            <br />
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left"><div align="left"><strong>SL</strong></div></td>
    <td align="left"><div align="left"><strong>Employee ID </strong></div></td>
    <td align="left"><div align="left"><strong>Month</strong></div></td>
    <td align="left"><div align="left"><strong>Year</strong></div></td>
    <td align="left"><div align="left"><strong>Mobile No </strong></div></td>
    <td align="left"><div align="left"><strong>Excess Mobile Bill </strong></div></td>
    <td align="left"><div align="left"><strong>Action</strong></div></td>
  </tr>
  <?php
  $sl=1;
  $s_sql="select * from hrm_moblie_bill where year='".$_POST['year']."' and month='".$_POST['mon']."'";
	$s_query=db_query($s_sql);
	while($s_data=mysqli_fetch_object($s_query)){
  ?>
  <tr>
    <td><?=$sl++;?></td>
    <td>
      <?=$s_data->emp_id?>    </td>
    <td>
      <?=$s_data->month?>    </td>
    <td>
      <?=$s_data->year?>    </td>
    <td>
      <?=$s_data->mobile_no?>    </td>
    <td><input name="mobile_bill_<?=$s_data->id?>" type="text" style="width:50px" value="<?=$s_data->mobile_bill?>"/></td>
    <td><input name="update_<?=$s_data->id?>" type="submit" value="UPDATE"/></td>
  </tr>
  <? }?>
</table>

          </div>
          </div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

 </form>   </div>



<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>