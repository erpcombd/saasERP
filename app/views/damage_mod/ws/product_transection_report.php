<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Delivery Order Advence Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item');
?>

<form action="product_transection_report_master.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td><input name="report" type="radio" class="radio" value="3"/></td>
                                <td><div align="left">BIN CARD DETAIL (Date Wise)</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="5"/></td>
							    <td><div align="left">BIN CARD(Finish Goods)</div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1"/></td>
                                <td><div align="left">BIN CARD (Posting Wise)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="4"/></td>
                                <td><div align="left">BIN CARD WITH SR NO</div></td>
                              </tr>
                              
                              
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Product Transection Report Summary</div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>Product Name: </td>
                    <td><input type="text" name="item" id="item" style="width:250px" required />
                    </td>
                  </tr>
                  <tr>
                    <td>From: </td>
                    <td><input  name="f_date" type="text" id="f_date" value=""/></td>
                  </tr>
                  <tr>
                    <td>To: </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
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