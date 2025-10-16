<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

$title='Leave Information';	







?>



<div class="oe_view_manager oe_view_manager_current">

        

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

<div style="text-align:center">

<center><h1>Leave Pending List</h1>

<?php

$table='hrm_leave_info';

$unique='id';

$crud      =new crud($table);

echo $res = "select o.id,o.id,o.PBI_ID as code,a.PBI_NAME ,o.s_date as start_date, o.e_date as end_date,o.reason, o.total_days, o.leave_status,o.entry_at

from personnel_basic_info a, hrm_leave_info o 

where o.PBI_ID=a.PBI_ID 



order by department_head,o.PBI_ID



";



echo $crud->link_report($res,$link);

?>



</div></div></div>



<br> 

<div  class="oe_view_manager_view_list"><div  class="oe_list oe_view"><div style="text-align:center">

<center><h1>IOM Pending List</h1>



<?php

$table='hrm_iom_info';

$unique='id';

$crud      =new crud($table);

echo $res = "select o.id, o.id,o.PBI_ID as code,a.PBI_NAME,o.PBI_DEPT_HEAD as incharge, 

o.s_date as start_date, o.e_date as end_date,o.reason, o.total_days ,o.entry_at

from personnel_basic_info a, hrm_iom_info o 

where a.PBI_ID=o.PBI_ID   

order by o.PBI_ID



";



echo $crud->link_report($res,$link);

?>

</div></div></div>











</div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

</div>



<p>

  <?

require_once SERVER_CORE."routing/layout.bottom.php";

?>





