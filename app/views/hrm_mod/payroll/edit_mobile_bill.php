<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#m_date');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$table='hrm_inout';

$unique='id';



if(isset($_POST["upload"])){

$filename=$_FILES["mobile_bill"]["tmp_name"];

if($_FILES["mobile_bill"]["tmp_name"]!="")
{
echo 'OK';
$file = fopen($filename, "r");
		while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
		{
		
		//It wiil insert a row to our subject table from our csv file`
		$sql = "INSERT into hrm_moblie_bill (year, month, emp_id, mobile_no, mobile_bill, entry_by, entry_at) 
		values('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."')";
		//we are using mysqli_query function. it returns a resource on true else False on error
		db_query($sql);
		
		}
fclose($file);
 
	}
} 

?>





<style type="text/css">

<!--

.style1 {font-size: 24px}

.style2 {

	color: #FFFFFF;

	font-size: 24px;

	font-weight: bold;

}

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
                  <option <?=($year=='2016')?'selected':''?>>2016</option>
                  <option <?=($year=='2017')?'selected':''?>>2017</option>
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

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>