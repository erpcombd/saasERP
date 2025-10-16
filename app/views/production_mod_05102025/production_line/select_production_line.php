<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Production Line';

$table='production_line';
$unique='id';

?>







  <div class="form-container_large">

    <form action="production_line_fg.php" method="post" name="codz" id="codz">

      <div class="container-fluid bg-form-titel">
        <div class="row">

          <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
            <div class="form-group row m-0">
              <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Select Production Line:	</label>
              <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">

                <select name="line_id" id="line_id">
                  <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL" order by warehouse_name');?>
                </select>

              </div>
            </div>
          </div>

          <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <input type="submit" name="submitit" id="submitit" value="VIEW FINISHED GOODS"  class="btn1 btn1-submit-input" />
          </div>

        </div>
      </div>


    </form>
  </div>










<? /*>
<div class="form-container_large">
<form action="production_line_fg.php" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Select Production Line: </strong></td>
    <td bgcolor="#FF9966"><strong>
      <select name="line_id" id="line_id">
        <? foreign_relation('warehouse','warehouse_id','warehouse_name','','use_type="PL" order by warehouse_name');?>
      </select>
    </strong></td>
    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW FINISHED GOODS" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>

</form>
</div>

  <*/?>






<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>