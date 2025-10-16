<?php



session_start();



ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Dealer Information';







do_calander("#f_date");



do_calander("#t_date");



do_calander("#cut_date");



auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');



auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" ','item_id');?>

<form action="master_report_dealer.php" method="post" name="form1" target="_blank" id="form1">
  <table class="w-100" border="0">
      <th></th>
    <tr>
      <td><div class="box4">
          <table style="width:95%" border="0" class="text-center">
              <th></th>
            <tr>
              <td><table class="w-100" border="0">
                  <th></th>
                  <tr>
                    <td style="vertical-align: top;"><table class="w-100" border="0">
                        <th></th>
                        <tr>
                          <td><table class="w-100" border="0">
                              <th>
                              <tr>
                                <td colspan="2" class="title1"><div style="text-align: left;">Select Report </div></td>
                              </tr>
                              <tr>
                                <td style="weight:6%"><input name="report" type="radio" class="radio" value="1001" /></td>
                                <td style="weight:94%"><div style="text-align: left;">Dealer Report </div></td>
                              </tr>
							  </th>
                              
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td style="vertical-align: top;"><table class="w-100 text-center" border="0">
                  <th><tr> </tr></th>
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
          <table class="w-100 text-center" border="0">
            <th><tr>
              <td><input name="submit" type="submit" class="btn" value="Report" /></td>
            </tr></th>
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
