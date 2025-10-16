<?php
session_start();
ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Damage Advence Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');
auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');
?>

<form action="master_report_chalan.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>
                                <td><div align="left">Damage Brief Report</div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Item Wise Damage Details Report</div></td>
                              </tr>

                              <tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                                <td><div align="left">Received Damage Report (Damage Wise)</div></td>
                              </tr>
                              
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Damage Order Brief Report (Region Wise)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1004" /></td>
                                <td><div align="left">Warehouse Stock Position Report(Closing)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="21" /></td>
                                <td><div align="left">Item Wise Sales Vs Damage  Report
                                </div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="211" /></td>
                                <td><div align="left">Damage Cause Wise  Damage  Report </div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="212" /></td>
                                <td><div align="left">Damage Cause Wise  Damage  Report (Summary) </div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="6" /></td>
                                <td><div align="left">View Damage Report (Single)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="111" /></td>
                                <td><div align="left">Corporate Damage Summary Brief</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="112" /></td>
                                <td><div align="left">SuperShop Damage Summary Brief</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="107" /></td>
                                <td><div align="left">Regional Sales Vs Damage Report (TK)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="108" /></td>
                                <td><div align="left">Zone Wise Sales Vs Damage Report (TK)(Select Region)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="109" /></td>
                                <td><div align="left">Party Wise  Sales Vs Damage Report (TK)(Select Zone)</div></td>
                              </tr>
                              <tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="110" /></td>
                                <td><div align="left">Sales Vs Damage Report(TK)(Corporate/SuperShop)</div></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="left" style="text-decoration:underline">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td align="left" style="text-decoration:underline">Order Wise Sales Report</td>
                              </tr>
                                                            <tr>
                                <td><input name="report" type="radio" class="radio" value="117" /></td>
                                <td><div align="left">Regional Sales Vs Damage Report (TK)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="118" /></td>
                                <td><div align="left">Zone Wise Sales Vs Damage Report (TK)(Select Region)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="119" /></td>
                                <td><div align="left">Party Wise  Sales Vs Damage Report (TK)(Select Zone)</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="120" /></td>
                                <td><div align="left">Sales Vs Damage Report(TK)(Corporate/SuperShop)</div></td>
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
                    <td>Damage Reason  :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="damage_cause" id="damage_cause">
                        <option></option>
                        <? foreign_relation('damage_cause','id','damage_cause',$damage_cause);?>
                      </select>
                    </span></td>
                  </tr>
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
                                          <option value="NA">NA</option>
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
                    <td>Item Name : </td>
                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>
                  </tr>
                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>
                  </tr>
                  <tr>
                    <td>To : </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>
				  <tr>
                    <td>Dealer Name :</td>
                    <td><input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/></td>
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
                    <td>Damage No: </td>
                    <td><input  name="damage_no" type="text" id="damage_no" value=""/></td>
                  </tr>
                  <tr>
                    <td>Area Name :</td>
                    <td><select name="area_id" id="area_id">
                    <option></option>
                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$PBI_AREA,' 1 order by AREA_NAME');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Zone Name :</td>
                    <td><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">
                    <option></option>
                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$PBI_ZONE,' 1 order by ZONE_NAME');?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Region Name :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="region_id" id="region_id" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">
                      <option></option>
                        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$PBI_BRANCH,' 1 order by BRANCH_NAME');?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>Depot Name :</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select name="depot_id" id="depot_id" style="width:150px;">
                      <option></option>
                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>
                      </select>
                    </span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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