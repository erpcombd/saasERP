<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
do_calander('#m_date');
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');





if(isset($_POST["upload"])){

$filename=$_FILES["mobile_bill"]["tmp_name"];

	if($_FILES["mobile_bill"]["tmp_name"]!="")
	{
	echo '<span style="color: red;">Successfully Update. Please check...</span>';
	$file = fopen($filename, "r");
			while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
					{
$sql = 'update personnel_basic_info set  PBI_EMAIL = "'.$emapData[2].'" where PBI_ID ="'.$emapData[0].'"';
db_query($sql);

$sql = 'update personnel_basic_info set  PBI_MOBILE =  "'.$emapData[1].'" where PBI_ID ="'.$emapData[0].'"';
db_query($sql);


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

                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Upload eMail and Mobile No </div></td>
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
                      <p align="left" class="style2">Note: File must be at CSV format. Example: email.csv </p>
                      <p align="left" class="style2"> And Filed example: 1234 | 88017xxxxx | xyz@sajeebgroup.com.bd </p>
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

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>