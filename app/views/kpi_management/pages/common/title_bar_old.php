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

</span>

</span>

 </h2>

                

                

            </td>

            <td colspan="2">

			<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="height:25px; float:right">

              <? if($_SESSION['employee_selected']>0){?>

              <tr>

                <td width="80" align="center" valign="middle" bgcolor="#CCCCFF"><strong style="color:#FFF; font-size:16px;"><em><img src="../../pic/staff/<?=$_SESSION['employee_selected']?>.jpg" width="70" height="85" hspace="5" vspace="0" /></em></strong></td>

                <td width="400" align="left" style="background:#CCCCFF;color:#000; font-family:Tahoma;" >

				

                    <?php

				$sql =  @mysql_query("select PBI_NAME, PBI_DEPARTMENT, PBI_DESIGNATION,EMP_ID from personnel_basic_info where PBI_ID = ".$_SESSION['employee_selected']."");

				  $row = @mysql_fetch_object($sql);

				  if($row->PBI_NAME!='') echo "<span style='font-size:24px;'>".' '.$row->PBI_NAME."(".$row->EMP_ID.")<br/></span>";

				   echo "<span style='font-size:16px; margin-top:10px;'>".find_a_field('designation','DESG_DESC','DESG_ID='.$row->PBI_DESIGNATION)."<br/></span><span style='height:10px;'></span>";

				  echo "<span style='font-size:18px; margin-top:10px;'>".find_a_field('department','DEPT_DESC','DEPT_ID='.$row->PBI_DEPARTMENT)."</span>";

				 

				?>

                </td>

              </tr><? }?>



            </table>

			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:25px; vertical-align:middle;">

              

			  <tr>

                <td width="30%" align="center" valign="middle" bgcolor="#3399FF">

				<strong style="color:#FFF; font-size:16px;"><em>&nbsp;Employee ID</em>:				</strong>				</td>

                <td width="1" align="right" bgcolor="#3399FF">

                  <strong>

				  <em>

                  <input name="employee_selected1" type="text" id="employee_selected1" style="height:20px; width:30px; color:#F30; font-weight:bold" value="RA-" maxlength="3" />

               	  </em></strong>

			    </td>

                  <td align="left" bgcolor="#3399FF"> <strong><em>

                  <input name="employee_selected2" type="text" id="employee_selected2" style="height:20px; width:70px; color:#F30; font-weight:bold" value="<?=(isset($_SESSION['employee_selected2']))?sprintf("%'04d", $_SESSION['employee_selected2']):'';?>" maxlength="5" />

               </em>

			   </strong>

			   </td>

                <td align="center" valign="middle" bgcolor="#3399FF">

				<input type="submit" name="button" id="button" value="Find" style="width:60px; font-weight:bold" />

				</td>

              </tr>

			  

</table>                

</td>

            </tr>

  </tbody></table>