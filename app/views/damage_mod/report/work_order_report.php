<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Work Order Advence Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('item_info','item_name','item_id','1','item_id');
?>

<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
          <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td width="94%"><div align="left">Warehouse  Transection Report</div></td>
                              </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="1008" /></td>
							    <td><div align="left">Warehouse  Purchase  Report</div></td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="8" /></td>
							    <td><div align="left">Warehouse  Transection Report (Entry Wise) </div></td>
						      </tr>
							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Warehouse Present Stock</div></td>
                              </tr>
							  <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="4" /></td>
                                <td width="94%"><div align="left">Warehouse Present Stock (Finish Goods)</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1004" /></td>
							    <td><div align="left">RM Consumtion Report</div></td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="1005" /></td>
							    <td><div align="left">FG Production Report</div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1001" /></td>
							    <td><div align="left">Stock Valuation Report </div></td>
						      </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1003" /></td>
							    <td><div align="left">Material Consumption  Report </div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1006" /></td>
							    <td><div align="left">Product Movement Detail Report (FG) </div></td>
						      </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1007" /></td>
							    <td><div align="left">Product Movement Summary Report (FG) </div></td>
						      </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>Item Name:</td>
                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>
                  </tr>
                  <tr>
                    <td>Item Sub Group: </td>
                    <td><select name="item_sub_group" id="item_sub_group">
                      <option></option>
                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>From:</td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>"/></td>
                  </tr>
                  <tr>
                    <td>To:</td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"/></td>
                  </tr>
				  <tr>
                    <td>Issue Status: </td>
                    <td><select name="issue_status" id="issue_status">
<option value=""></option>
<option value='Sales'>Sales</option>
<option value='Issue'>Issue</option>
<option value='Sample Issue'>Sample Issue</option>
<option value='Gift Issue'>Gift Issue</option>
<option value='Entertainment Issue'>Entertainment Issue</option>
<option value='R & D Issue'>R & D Issue</option>
<option value='Other Issue'>Other Issue</option>
<option value='Staff Sales'>Staff Sales</option>
<option value='Export Sales'>Export Sales</option>
<option value='Other Sales'>Other Sales</option>
                    </select></td>
                  </tr>
					
				  <tr>
				    <td>Receive Status: </td>
				    <td>
					<select name="receive_status" id="receive_status">
<option value=""></option>
<option value='All_Purchase'>All Purchase</option>
<option value='Purchase'>Purchase</option>
<option value='Receive'>Receive</option>
<option value='Return'>Return</option>
<option value='Opening'>Opening</option>
<option value='Other Receive'>Other Receive</option>
<option value='Local Purchase'>Local Purchase</option>
<option value='Sample Receive'>Sample Receive</option>
<option value='Import'>Import</option>

			        </select></td>
			      </tr>
                  <tr>
                    <td>Inventory Name: </td>
                    <td><select name="warehouse_id" id="warehouse_id">
                      <option selected="selected"></option>
					  <? foreign_relation('warehouse','warehouse_id','warehouse_name','');?>
                    </select></td>
                  </tr>
              </table></td>
            </tr>
          </table>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><div class="box">
        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td><input name="submit" type="submit" class="btn" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>