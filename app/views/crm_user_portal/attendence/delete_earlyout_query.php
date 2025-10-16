<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#m_date');

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$table='hrm_inout';

$unique='id';

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

                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Delete Early Out </div></td>
                </tr>

              <tr>
                <td width="18%">&nbsp;</td>
                <td width="82%" colspan="3">&nbsp;</td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                </tr>
              
              <tr>

                <td colspan="4"><p>SELECT<br />
                  h.id,h.emp_id,p.PBI_NAME,p.PBI_DESIGNATION,p.PBI_DEPARTMENT,u.group_name,h.att_date,h.dayname,h.in_time,h.out_time,h.dayname<br />
                  FROM hrm_att_summary h,office_location l,user_group u,personnel_basic_info p<br />
                  WHERE <br />
                  h.emp_id=p.PBI_ID<br />
                  AND p.PBI_ORG=u.id<br />
                  AND u.id=l.GROUP_ID<br />
                  and h.att_date BETWEEN '2018-04-26' AND '2018-05-17'<br />
                  and h.out_time&lt;concat(att_date,' 18:00:00') <br />
                  and h.dayname !='Friday' <br />
                  and h.leave_id=0 <br />
                  and h.iom_sl_no=0 <br />
                  and p.JOB_LOCATION IN(1,7,15,16,18,21,70)<br />
                  and p.PBI_JOB_STATUS ='IN SERVICE'<br />
                  and p.PBI_DEPARTMENT NOT IN('Admin (Support Service Section)','TRS','GYM')<br />
                  GROUP BY h.id<br />
                  order by h.emp_id,h.att_date;</p>
                  <p>SELECT<br />
                    h.id,h.emp_id,p.PBI_NAME,p.PBI_DESIGNATION,p.PBI_DEPARTMENT,u.group_name,h.att_date,h.dayname,h.in_time,h.out_time,h.dayname<br />
                    FROM hrm_att_summary h,office_location l,user_group u,personnel_basic_info p<br />
                    WHERE <br />
                    h.emp_id=p.PBI_ID<br />
                    AND p.PBI_ORG=u.id<br />
                    AND u.id=l.GROUP_ID<br />
                    and h.att_date BETWEEN '2018-05-18' AND '2018-05-25'<br />
                    and h.out_time&lt;concat(att_date,' 16:30:00') <br />
                    and h.dayname !='Friday' <br />
                    and h.leave_id=0 <br />
                    and h.iom_sl_no=0 <br />
                    and p.JOB_LOCATION IN(1,7,15,16,18,21,70)<br />
                    and p.PBI_JOB_STATUS ='IN SERVICE'<br />
                    and p.PBI_DEPARTMENT NOT IN('Admin (Support Service Section)','TRS','GYM')<br />
                    GROUP BY h.id<br />
                    order by h.emp_id,h.att_date;</p>
                  <p>&nbsp;</p>
                  <p></p>
                  <p align="left">&nbsp;</p>
                    <p>&nbsp;</p>
                    <p>&nbsp;</p>
                    </td></tr>


              <tr>

                <td colspan="4"><label>

                    <div align="center">
                      <p>&nbsp;</p>
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