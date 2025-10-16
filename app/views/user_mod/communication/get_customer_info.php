<?php
//

 
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$select = 'select * from crm_customer_info where 1 and dealer_code="'.$_GET['q'].'"';

$query = db_query($select);

$row = mysqli_fetch_object($query);

$select2 = 'select * from crm_project where PROJECT_ID="'.$row->PROJECT_ID.'"';
$query2 = db_query($select2);

$row2 = mysqli_fetch_object($query2);

?>

<table width="100%" cellpadding="3" cellspacing="0" style="background-color:#C3D7FF; border: 1px solid black;">
<tr>
                  <td width="200px;"  style="padding: 5px;" >Company Name </td>
                  <td style="padding: 5px;">
				 <input type="text" name="PROJECT_DESC" id="PROJECT_DESC" value="<?=$row2->PROJECT_DESC?>" readonly="">
				  </td>
                  <td style="padding: 5px;"> Designation</td>
                  <td style="padding: 5px;">
				 <input type="text" name="project_desg" id="project_desg" value="<?=$row->project_desg?>" readonly=""></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td style="padding: 5px;">Department</td>
                  <td style="padding: 5px;"><input type="text" name="project_dept" id="project_dept" value="<?=$row->project_dept?>" readonly=""></td>
                  <td style="padding: 5px;">&nbsp;</td>
                  <td style="padding: 5px;">&nbsp;</td>
                </tr>
</table>

