<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#m_date');
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');
$table='hrm_inout';
$unique='id';

if(isset($_POST["upload"]))
{

$filename=$_FILES["mobile_bill"]["tmp_name"];

	if($_FILES["mobile_bill"]["tmp_name"]!="")
	{
	echo '<span style="color: red;">Excel File Successfully Imported</span>';
	$file = fopen($filename, "r");
			while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
			{
			$s_sql="select * from hrm_other_bill where year=$emapData[0] and month=$emapData[1] and emp_id=$emapData[4]";
			$s_query=db_query($s_sql);
			$s_num_row=mysqli_num_rows($s_query);
			
				if($s_num_row==0)
				{
				//db_query('delete from hrm_moblie_bill where year = "'.$emapData[0].'" and month = "'.$emapData[1].'" and emp_id ="'.$emapData[2].'" ');
$sql = "INSERT into hrm_other_bill (year, month, batch_no, roll_no, emp_id, other_bill, entry_by, entry_at) 
values('".$emapData[0]."','".$emapData[1]."','".$emapData[2]."','".$emapData[3]."','".$emapData[4]."','".$emapData[5]."','".$_SESSION['user']['id']."','".date('Y-m-d H:i:s')."')";
db_query($sql);
				}
				else
				{
$sql = 'update hrm_other_bill set  batch_no = "'.$emapData[2].'",roll_no = "'.$emapData[3].'", other_bill = "'.$emapData[5].'",edit_by = "'.$_SESSION['user']['id'].'",edit_at = "'.date('Y-m-d H:i:s').'"
where year = "'.$emapData[0].'" and month = "'.$emapData[1].'" and emp_id ="'.$emapData[4].'"';
db_query($sql);
				}
			}
			
	}
fclose($file);
 

} 

?>





<style type="text/css">

<!--

.style1 {font-size: 24px}
.style2 {
	color: #FF66CC;
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

                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Upload Other Bill  </div></td>
                </tr>

              <tr>

                <td width="20%"><div align="right">Upload File : </div></td>

                <td><input name="mobile_bill"  type="file" id="mobile_bill"/></td>
                <td><input name="upload" type="submit" id="upload" value="Upload File" /></td>
                <td>&nbsp;</td>
              </tr>


              <tr>

                <td colspan="4"><label>

                    <div align="center">
                      <p>&nbsp;</p>
                      <p align="left" class="style2">Note: File must be at CSV format. Example: other.csv </p>
                      <p align="left" class="style2"> And Filed example: 2019 | 8 | batch | roll| code | 200</p>
                    </div>

                    </label></td>
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

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>