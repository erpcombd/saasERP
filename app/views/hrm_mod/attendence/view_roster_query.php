<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

do_calander('#m_date');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

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

                <td height="40" colspan="4" bgcolor="#00FF00"><div align="center" class="style1">Query of Roster Process </div></td>
                </tr>

              <tr>
                <td width="14%"><p>Late delete</p>
                  <p>select h.*</p></td>
                <td width="86%" colspan="3"><p>delete h<br />
                    from hrm_att_summary h, hrm_roster_allocation ro<br />
                    where<br />
                    h.emp_id=ro.PBI_ID<br />
                    and h.leave_id=0<br />
                    and h.att_date=ro.roster_date<br />
                    and h.in_time &gt; concat(h.att_date,' ',h.sch_in_time)<br />
                    and h.att_date BETWEEN '2018-08-26' AND '2018-09-25'                  </p>                  </td>
                </tr>
              <tr>
                <td>Early out delete</td>
                <td colspan="3"><p>####################### </p>
                  <p>Delete h<br />
                    FROM hrm_att_summary h,personnel_basic_info p<br />
                    WHERE <br />
                    h.emp_id=p.PBI_ID<br />
                    and h.out_time&lt;concat(DATE_ADD(h.att_date, INTERVAL 1 DAY),' ',h.sch_out_time) <br />
                    and h.sch_out_time&lt;='06:00:00'<br />
                    and h.leave_id=0 <br />
                    and h.iom_sl_no=0 <br />
                    and p.JOB_LOCATION IN(79,80)<br />
                    and p.PBI_JOB_STATUS ='IN SERVICE'<br />
                    and p.PBI_DEPARTMENT NOT IN('Admin (Support Service Section)','TRS','GYM')
                  <br>and h.att_date BETWEEN '2018-08-26' AND '2018-09-25';
                  <p>Delete h
                    <br />
                    FROM hrm_att_summary h,personnel_basic_info p<br />
                    WHERE <br />
                    h.emp_id=p.PBI_ID
                    <br />
                    and h.out_time&lt;concat(h.att_date,' ',h.sch_out_time) <br />
                    and h.sch_out_time&gt;'06:00:00'<br />
                    and h.leave_id=0 <br />
                    and h.iom_sl_no=0 <br />
                    and p.JOB_LOCATION IN(79,80)<br />
                    and p.PBI_JOB_STATUS ='IN SERVICE'<br />
                    and p.PBI_DEPARTMENT NOT IN('Admin (Support Service Section)','TRS','GYM')<br />
                    and h.att_date BETWEEN '2018-08-26' AND '2018-09-25';</p>
                  </td>
              </tr>


              <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td colspan="3">&nbsp;</td>
                </tr>
              
              <tr>

                <td colspan="4">&nbsp;</td></tr>


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

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>