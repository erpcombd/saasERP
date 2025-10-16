<table width="100%" class="oe_view_manager_header">

          <colgroup>

		  <col width="20%">

          <col width="35%">

          <col width="15%">

          <col width="30%">

          </colgroup>

		  <tbody>

		  <tr class="oe_header_row oe_header_row_top">

            <td colspan="2">

                

                

              <h2 class="oe_view_title">

<span class="oe_view_title_text oe_breadcrumb_title">

<a href="#" class="oe_breadcrumb_item" data-id="breadcrumb_15">HRM</a> 

<span class="oe_fade"> >> </span> <span class="oe_breadcrumb_item">

<?=$title;?>

<? $unique_id =  $_GET['id'];?>

</span>

</span>

 </h2>

                

                

            </td>

            <td colspan="2">
			
			<?
			  if($unique_id>0){
			  $unique_pbi_id = find_a_field('hrm_leave_info','PBI_ID','id='.$unique_id);
			?>

			<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="height:25px; float:right">

              <? if($unique_pbi_id>0){?>

              <tr>

                <td width="80" align="center" valign="middle" bgcolor="#CCCCFF"><strong style="color:#FFF; font-size:16px;"><em><img src="../../../hrm_mods/pic/staff/<?=$unique_pbi_id?>.jpeg" width="70" height="85" hspace="5" vspace="0" /></em></strong></td>

                <td width="400" align="left" style="background:#CCCCFF;color:#000; font-family:Tahoma;" >

				

                    <?php

				$sql =  @mysql_query("select PBI_NAME, PBI_DEPARTMENT, PBI_DESIGNATION,JOB_LOCATION, PBI_CODE from personnel_basic_info where PBI_ID = ".$unique_pbi_id."");

				  $row = @mysql_fetch_object($sql);
				$dept = find_a_field('department','DEPT_DESC','DEPT_ID='.$row->PBI_DEPARTMENT);
				
				   if($row->PBI_DEPARTMENT == 13){
				   $proj_dept = find_a_field('project','PROJECT_DESC','PROJECT_ID='.$row->JOB_LOCATION);
				   }else{
				   $proj_dept = find_a_field('department','DEPT_DESC','DEPT_ID='.$row->PBI_DEPARTMENT);
				   }

				  if($row->PBI_NAME!='') echo "<span style='font-size:24px;'>".$row->PBI_NAME."<br/></span>";
				  
				  echo "<span style='font-size:16px;'>ID - ".$row->PBI_CODE."<br/></span>";

				   echo "<span style='font-size:16px; margin-top:10px;'>".find_a_field('designation','DESG_DESC','DESG_ID='.$row->PBI_DESIGNATION)."<br/></span><span style='height:10px;'></span>";

				  echo "<span style='font-size:18px; margin-top:10px;'>".$proj_dept."</span>";

				 

				?>

                </td>

              </tr><? }?>



            </table>
			
			
			<? } else{?>
			<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="height:25px; float:right">

              <? if($_SESSION['employee_selected']>0){?>

              <tr>

                <td width="80" align="center" valign="middle" bgcolor="#CCCCFF"><strong style="color:#FFF; font-size:16px;"><em><img src="../../../hrm_mods/pic/staff/<?=$_SESSION['employee_selected']?>.jpeg" width="70" height="85" hspace="5" vspace="0" /></em></strong></td>

                <td width="400" align="left" style="background:#CCCCFF;color:#000; font-family:Tahoma;" >

				

                    <?php

				$sql =  @mysql_query("select PBI_NAME, PBI_DEPARTMENT, PBI_DESIGNATION,JOB_LOCATION, PBI_ID from personnel_basic_info where PBI_ID = ".$_SESSION['employee_selected']."");

				  $row = @mysql_fetch_object($sql);
				$dept = find_a_field('department','DEPT_DESC','DEPT_ID='.$row->PBI_DEPARTMENT);
				
				   if($row->PBI_DEPARTMENT == 13){
				   $proj_dept = find_a_field('project','PROJECT_DESC','PROJECT_ID='.$row->JOB_LOCATION);
				   }else{
				   $proj_dept = find_a_field('department','DEPT_DESC','DEPT_ID='.$row->PBI_DEPARTMENT);
				   }

				  if($row->PBI_NAME!='') echo "<span style='font-size:24px;'>".$row->PBI_NAME."<br/></span>";
				  
				  echo "<span style='font-size:16px;'>ID - ".$row->PBI_ID."<br/></span>";

				   echo "<span style='font-size:16px; margin-top:10px;'>".find_a_field('designation','DESG_DESC','DESG_ID='.$row->PBI_DESIGNATION)."<br/></span><span style='height:10px;'></span>";

				  echo "<span style='font-size:18px; margin-top:10px;'>".$proj_dept."</span>";

				 

				?>

                </td>

              </tr><? }?>



            </table>
			<? } ?>

			                

</td>

            </tr>

  </tbody></table>