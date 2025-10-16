<?php

session_start();

ob_start();

require_once "../../config/inc.all.php";



// ::::: Edit This Section ::::: 

$title='Show User';			// Page Name and Page Title

$page="show_user.php";		// PHP File Name

$input_page="show_user_input.php";

$root='user';

$table='personnel_basic_info';		// Database Table Name Mainly related to this page

$unique='PBI_ID';			// Primary Key of this Database table

$shown='PBI_NAME';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::

$crud      =new crud($table);



$$unique = $_GET[$unique];



?>

<script type="text/javascript"> 



function DoNav(theUrl)

{

	window.open('detail_report.php?employee_selected='+theUrl);

}

</script>

	</script>

	<style type="text/css">

<!--

.style1 {

	color: #0066CC;

	font-weight: bold;

}

-->

    </style>

	



<form action="" method="post" enctype="multipart/form-data">

<div class="oe_view_manager oe_view_manager_current">

        

    <? include('../../common/title_bar.php');?>

        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">

    <? //include('../../common/report_bar.php');?>

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

		 

		 <table class="oe_form_group " border="0" cellpadding="0" cellspacing="0">

		

                

              <tr class="oe_form_group_row">

			  

					<td bgcolor="#E8E8E8" class="oe_form_group_cell" style="width:100px" ><span class="oe_form_group_cell oe_form_group_cell_label">Company</span></td>

                    <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="width:60px" >

				  

				  <select name="PBI_DOMAIN" style="width:260px">

                    <? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$_POST['PBI_DOMAIN']);?>

                  </select>

			

				  </td>

                

                    <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="width:60px"><span class="oe_form_group_cell oe_form_group_cell_label">Department</span></td>

                  <td bgcolor="#E8E8E8" colspan="" style="width:60px" class="oe_form_group_cell">

				 <select name="department" style="width:130px">

                    <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['department'],' 1 order by DEPT_DESC');?>

                    

                  </select>

				  </td>

				   <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="width:60px"><span class="oe_form_group_cell oe_form_group_cell_label">Designation</span></td>

                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="width:60px" >

				  

				   <select name="designation" style="width:130px">

                     <? foreign_relation('designation','DESG_ID','DESG_DESC',$_POST['designation'],' 1 order by DESG_DESC');?>

                  </select>

				  </td>

				  

				 <td bgcolor="#E8E8E8" class="oe_form_group_cell">

				     <input type="submit" value="Show" id="submit" name="view" style="background:#3079ed;color:#fff; width:100px;"/>

				  </td>

                </tr>

      

          </table>

		  <hr/>

		    

          <?

		    if($_POST['PBI_DOMAIN']>0){

			   $PBI_DOMAIN = $_POST['PBI_DOMAIN'];

			    $con .= ' and a.PBI_DOMAIN='.$PBI_DOMAIN;

			   }

if($_POST['department']>0){

			       $department = $_POST['department'];

				   $con .= ' and a.PBI_DEPARTMENT='.$department;

				   }

			  if($_POST['designation']>0){

			   $designation = $_POST['designation'];

			    $con .= ' and a.PBI_DESIGNATION='.$designation;

			   }

			  			

		  if(isset($_POST['view'])){

?>

<table class="oe_list_content"><thead><tr class="oe_list_header_columns">

  <th>Pic</th>

  <th>ID</th><th>Full Name</th><th>Designation</th><th>Gender</th><th>Section / Team</th><th>Department</th><th>Location</th><th>Date of Joining</th><th>Date of Confirmation</th><th>Date of birth</th><th>Age</th><th>Blood Group</th><th>Active Cell Number</th><th>Present Address</th><th>Permanent Address</th></tr></thead><tfoot><tr>

      <td></td>

      <td></td><td></td><td></td><td></td><td></td><td></td></tr></tfoot><tbody>

<?

		   $res='select 

			a.'.$unique.',PBI_ID as USER_ID, PBI_NAME as Full_Name, EMP_ID, PBI_SEX as Gender, PBI_DOB, PBI_DOJ, PBI_DOC, PBI_PERMANENT_ADD, PBI_PRESENT_ADD, PBI_MOBILE, JOB_LOCATION,  PBI_PRESENT_AGE, d.DOMAIN_DESC as company,PBI_MOBILE as Mobile, b.DEPT_DESC as Department,c.DESG_DESC as Designation 

			from '.$table.' a,department b,designation c, domai d

			where a.PBI_DEPARTMENT=b.DEPT_ID and a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DOMAIN=d.DOMAIN_CODE'.$con.' 

			order by EMP_ID ASC';

			$query = mysql_query($res);

			$count = mysql_num_rows($query);

			while($data = mysql_fetch_object($query)){++$i;

			?>

<tr onclick="DoNav(<?=$data->PBI_ID?>)" <?=($i%2)?'class="alt"':'';?>>

  <td><img src="../../pic/staff/<?=$data->PBI_ID?>.jpg" width="20" height="25" /></td>

  <td><?=$data->EMP_ID?></td><td><?=$data->Full_Name?></td><td><?=$data->Designation?></td><td><?=$data->Gender?></td><td><? ?></td><td><?=$data->Department?></td><td><?=$data->JOB_LOCATION?></td><td><?=$data->PBI_DOJ?></td><td><?=$data->PBI_DOC?></td><td><?=$data->PBI_DOB?></td><td><?=Date2age($data->PBI_DOB)?></td><td><? ?></td><td><?=$data->PBI_MOBILE?></td><td><?=$data->PBI_PRESENT_ADD?></td><td><?=$data->PBI_PERMANENT_ADD?></td></tr>

			<?

			}

			}

			?>





</tbody></table>

          <table width="50%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td><div align="center" class="style1">

                <div align="left">Total Employee Found: 

                  <?=$count?>

                  </div>

              </div></td>

            </tr>

          </table>

          </div></div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

  </div>

</form>

<?

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>