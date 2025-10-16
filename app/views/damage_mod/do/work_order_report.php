<?php
session_start();
ob_start();
require "../../support/inc.all.php";
$title='Delivery Order Advence Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');
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
                                <td><input name="report" type="radio" class="radio" value="1" /></td>
                                <td><div align="left">Delivery Order Brief Report</div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Undelivered Do Details Report</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Undelivered Do Report Dealer Wise</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="4" /></td>
                                <td><div align="left">Chalan Report(Chalan Date Wise)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Delivery Order Brief Report (Region Wise)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="7" /></td>
                                <td><div align="left">Item Wise DO Report</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="9" /></td>
                                <td><div align="left">Item Report (Region Wise)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">View Chalan Report (Single)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="8" /></td>
                                <td><div align="left">Dealer Performance Report</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="10" /></td>
                                <td><div align="left">Daily Collection Summary</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="13" /></td>
                                <td><div align="left">Daily Collection Summary (Ext)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="11" /></td>
                                <td><div align="left">Daily Collection &amp; Order Summary</div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>Product Sales Group :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="product_group" id="product_group">
                      <option></option>
                        <? foreign_relation('product_group','group_name','group_name',$PBI_GROUP);?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Product Brand : </td>
                    <td><select name="item_brand" id="item_brand">
                                          <option></option>
                                          <option value="Tang">Tang</option>
                                          <option value="Bourn Vita">Bourn Vita</option>
                                          <option value="Oreo">Oreo</option>
                                          <option value="Shezan">Shezan</option>
                                          <option value="Promotional">Promotional</option>
                                          <option value="Top">Top</option>
                                          <option value="Kolson">Kolson</option>
                                          <option value="Nocilla">Nocilla</option>
                                          <option value="Sajeeb">Sajeeb</option>
                                        </select></td>
                  </tr>
                  <tr>
                    <td>Product Name : </td>
                    <td><select name="item_id" id="item_id">
                        <option></option>
                        <? foreign_relation('item_info','item_id','item_name',$data->item_id,'product_nature="Salable"');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>
                  <tr>
                    <td>To : </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>
				  <tr>
                    <td>Dealer Name :</td>
                    <td>
                    <input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/>
                    </td>
                  </tr>
					
				  <tr>
				    <td>Dealer Type :</td>
				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
				      <select name="dealer_type" id="dealer_type" style="width:150px;">
                        <option></option>
                        <option value="Distributor" >Distributor</option>
                        <option value="Corporate" >Corporate</option>
                        <option value="SuperShop" >SuperShop</option>
                      </select>
				    </span></td>
			      </tr>
				  <tr>
				    <td>DO Status :</td>
				    <td><select name="status" id="status">
					    <option value="">All</option>
                        <option value="CHECKED">PROCESSION</option>
                        <option value="UNCHECKED">UNCHECKED</option>
					    <option value="DONE">DONE</option>
			        </select></td>
			      </tr>
				  <tr>
                    <td>DO No: </td>
                    <td><input  name="do_no" type="text" id="do_no" value=""/></td>
                  </tr>
                  <tr>
                    <td>Region Name :</td>
                    <td><span id="branch" class="oe_form_group_cell">
                      <select name="region_id" id="region_id" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                        <option></option>
                        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Zone Name :</td>
                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                      <option></option>
                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');?>
                    </select></span></td>
                  </tr>
                  <tr>
                    <td>Area Name :</td>
                    <td><span id="area"><select name="area_id" id="area_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                    <option></option>
                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                    </select></span></td>
                  </tr>
                  <tr>
                    <td>Depot Name :</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select name="depot_id" id="depot_id" style="width:150px;">
                        <option value="<?=$_SESSION['user']['depot']?>">
                          <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_SESSION['user']['depot'])?>
                        </option>
                      </select>
                    </span></td>
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