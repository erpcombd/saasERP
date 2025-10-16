<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Warehouse All Reports';

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
                          <td><table width="92%" border="0" cellspacing="0" cellpadding="0">
                              <tr><td colspan="3" class="title1"><div align="left"><strong>Select Report </strong></div></td>
                              </tr>
                              <tr>
                                <td width="51%"><div align="left"><strong><a href="../ws/product_transection_report.php">Bin Card </a></strong></div></td>
                                <td><div align="left"><strong><a href="../other_receive/or_receive_status.php">Other Receive Report</a></strong></div></td>
                              </tr>
							  <tr>
							    <td><div align="left"><strong><a href="../report/work_order_report.php">Warehouse Reports</a></strong></div></td>
						        <td><div align="left"><strong><a href="../other_issue/other_issue_status.php">All Issue Report</a></strong></div></td>
							  </tr>
							  <tr>
							    <td>&nbsp;</td>
						        <td>&nbsp;</td>
							  </tr>
							  <tr>
							    <td><div align="left"><strong><a href="../pr/purchase_receive_status.php">Purchase Item Receive Report</a></strong></div></td>
							    <td><div align="left"><strong><a href="../SCS/fg_chalan_report.php">FG Chalan Report</a></strong></div></td>
							  </tr>
							  <tr>
							    <td><div align="left"><strong><a href="../other_receive/local_purchase_status.php">Local Purchase Report</a></strong></div></td>
							    <td><div align="left"><strong><a href="../SCS/fg_receive_report.php">FG Receive Report</a></strong></div></td>
							  </tr>
							  <tr>
							    <td><div align="left"><strong><a href="../other_receive/import_status.php">Import Receive Report</a></strong></div></td>
							    <td><div align="left"><strong><a href="../report/sales_report.php">Store to Store Chalan  Reports</a></strong></div></td>
							  </tr>
							  <tr>
							    <td>&nbsp;</td>
							    <td>&nbsp;</td>
							  </tr>
							  <tr>
							    <td><div align="left"><strong><a href="../production_issue/production_issue_status.php">Production Issue Report</a></strong></div></td>
						        <td><div align="left"><strong><a href="../do/item_return_status.php">Sales Return Reports</a></strong></div></td>
							  </tr>
							  <tr>
							    <td><div align="left"><strong><a href="../production_receive/production_receive_status.php">Production Line Receive Report</a></strong></div></td>
						        <td><div align="left"><strong><a href="../do/work_chalan_report.php">Delivery Chalan Reports</a></strong></div></td>
							  </tr>
							  <tr>
							    <td>&nbsp;</td>
						        <td><div align="left"><strong><a href="../chalan_report/work_order_report.php">Delivery Order Reports</a></strong></div></td>
							  </tr>
							  <tr>
							    <td><div align="left"><a href="dealer_list.php"><strong>Dealer Information </strong></a></div></td>
						        <td>&nbsp;</td>
							  </tr>
							  <tr>
							    <td>&nbsp;</td>
						        <td>&nbsp;</td>
							  </tr>
							  <tr>
							    <td>&nbsp;</td>
						      <td>&nbsp;</td></tr>	
							  <tr>
							    <td>&nbsp;</td>
						      <td>&nbsp;</td></tr>
							  
							  
							  
							  
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    
                  </tr>
              </table></td>
            </tr>
          </table>
      </div></td>
    </tr>
    <tr>
      <td><div class="box"></div></td>
    </tr>
  </table>
</form>
<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
?>