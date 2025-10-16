<?php

//

//

require "../../support/inc.all.php";

$title='Comparison Sales Reports';



do_calander("#f_date");

do_calander("#t_date");



//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');

auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>



<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>


      <td><div class="box4" style="width:950px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>

                             <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="100" /></td>

                                <td><div align="left">Dealer Perfromance Report</div></td>
                              </tr>

							                                <tr>

                                <td><input name="report" type="radio" class="radio" value="501" /></td>

                                <td><div align="left">Dealer Sales Report(Brand Wise)</div></td>
                              </tr>

                              <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="101" /></td>
                                <td width="94%"><div align="left">Four(4) Months Comparison Report(CTR) </div></td>
                              </tr>

							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="102" /></td>

                                <td width="94%"><div align="left">Four(4) Months Comparison Report(TK)</div></td>
                              </tr>

							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="103" /></td>

                                <td width="94%"><div align="left">Four(4) Months Regional Report(CTR)</div></td>
                              </tr>

							  							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="104" /></td>

                                <td width="94%"><div align="left">Four(4) Months Regional Report(TK)</div></td>
                              </tr>

							  							  							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="105" /></td>

                                <td width="94%"><div align="left">Four(4) Months Area Report(CTR)</div></td>
                              </tr>

							  							                              

							  							                              <tr>

                                                                                        <td><input name="report" type="radio" class="radio" value="106" /></td>

							  							                                <td><div align="left">Four(4) Months Area Report(TK)</div></td>
                              </tr>

							  							                              <tr>

                                                                                        <td><input name="report" type="radio" class="radio" value="116" /></td>

							  							                                <td><div align="left">Single Item Sales Report(Zone Wise)</div></td>
                              </tr>

							  							                              <tr>

							  							                                <td>&nbsp;</td>

							  							                                <td>&nbsp;</td>
                              </tr>

							  							                              <tr>

							  							                                <td><input name="report" type="radio" class="radio" value="2002" /></td>

							  							                                <td><div align="left">Last Year Vs This Year Item Wise Sales Report (Periodical) </div></td>
                              </tr>

							  							                              <tr>

                                                                                        <td><input name="report" type="radio" class="radio" value="2003" /></td>

							  							                                <td><div align="left">Last Year Vs This Year Party Wise Sales Report (Select Item) </div></td>
                              </tr>

							  							                              <tr>

                                                                                        <td><input name="report" type="radio" class="radio" value="20031" /></td>

							  							                                <td><div align="left">Last Year Vs This Year Region Wise Sales Report (Select Item) </div></td>
                              </tr>

							  							                              <tr>

                                                                                        <td><input name="report" type="radio" class="radio" value="107" /></td>

							  							                                <td><div align="left">Yearly Regional Sales Report(TK)</div></td>
                             														 </tr>-->
																					 
																					  <!--<tr>

                                                                                        <td><input name="report" type="radio" class="radio" value="1007"  checked="checked"/></td>

							  							                                <td><div align="left">MONTH ON MONTH PRODUCT QTY WISE SALES REPORT</div></td>
                             														 </tr>
																					 
																					 <tr>

                                                                                        <td><input name="report" type="radio" class="radio" value="1008" /></td>

							  							                                <td><div align="left">MONTH ON MONTH PRODUCT VALUE WISE SALES REPORT</div></td>
                             														 </tr>
																					 
																					 
																					 <tr>

                                                                                        <td><input name="report" type="radio" class="radio" value="1009" /></td>

							  							                                <td><div align="left">MONTH ON MONTH DISTRIBUTOR WISE SALES REPORT</div></td>
                             														 </tr>-->
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="3333" checked="checked" /></td>

																							<td><div align="left">MONTHLY DEALER WISE SALES REPORT (VALUE) </div></td>
																					 </tr>
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="333311" /></td>

																							<td><div align="left">MONTHLY DEALER WISE SALES REPORT (QUANTITY) </div></td>
																					 </tr>
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="333333" /></td>

																							<td><div align="left">MONTHLY PRODUCT VALUE WISE SALES REPORT</div></td>
																					 </tr>
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="33333311" /></td>

																							<td><div align="left">MONTHLY PRODUCT QTY WISE SALES REPORT</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="33333322" /></td>

																							<td><div align="left">MONTHLY PRODUCT GROUP WISE SALES REPORT (VALUE)</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="33333344" /></td>

																							<td><div align="left">MONTHLY PRODUCT GROUP WISE SALES REPORT (QUANTITY)</div></td>
																					 </tr>
																					 
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20060201" /></td>

																							<td><div align="left">PRODUCT WISE SALES REPORT</div></td>
																					 </tr>
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20060202" /></td>

																							<td><div align="left">PRODUCT GROUP WISE SALES REPORT</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20060203" /></td>

																							<td><div align="left">CONSOLIDATED SALES REPORT DEALER WISE</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="2006020311" /></td>

																							<td><div align="left">DEALER WISE SALES REPORT DETAIL</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="2006020322" /></td>

																							<td><div align="left">CUSTOMER TO CUSTOMER COMPARISON (PRODUCT WISE)</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="2006020333" /></td>

																							<td><div align="left">CUSTOMER TO CUSTOMER COMPARISON (PRODUCT GROUP WISE) </div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="2006020344" /></td>

																							<td><div align="left">CUSTOMER TO CUSTOMER SALES REPORT (PRODUCT WISE)</div></td>
																					 </tr>
																					 
																					 <!--<tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="101" /></td>
                                <td width="94%"><div align="left">Four(4) Months Comparison Report(CTR) </div></td>
                              </tr>-->
																					 
																					 
																					 
																																										 
																					 
																					 
																					 
																					
																					 

							  							                             <!-- <tr>

                                                                                        <td><input name="report" type="radio" class="radio" value="108" /></td>

							  							                                <td><div align="left">Yearly Regional Sales Report(Per Item)(CTN)</div></td>
                              </tr>

<tr>

	<td><input name="report" type="radio" class="radio" value="109" /></td>

	<td><div align="left">Yearly Regional Sales Report(Per Item)(TK)</div></td>
</tr>



<tr>

	<td><input name="report" type="radio" class="radio" value="110" /></td>

	<td><div align="left">Yearly Zone Wise Sales Report(TK)(Select Region)</div></td>
</tr>



<tr>

	<td><input name="report" type="radio" class="radio" value="111" /></td>

	<td><div align="left">Yearly Zone Wise Sales Report(Per Item)(CTN)(Select Region)</div></td>
</tr>



<tr>

	<td><input name="report" type="radio" class="radio" value="112" /></td>

	<td><div align="left">Yearly Zone Wise Sales Report(Per Item)(TK)(Select Region)</div></td>
</tr>



<tr>

  <td><input name="report" type="radio" class="radio" value="1130" /></td>

  <td>Corporate Party Wise Sales Report YEARLY</td>
</tr>

<tr>

	<td><input name="report" type="radio" class="radio" value="11301" /></td>

	<td><div align="left">Super Shop Party Wise Sales Report YEARLY</div></td>
</tr>



<tr>

	<td><input name="report" type="radio" class="radio" value="113" /></td>

	<td><div align="left">Yearly Dealer Wise Sales Report(TK)(Select Zone)</div></td>
</tr>



<tr>

	<td><input name="report" type="radio" class="radio" value="114" /></td>

	<td><div align="left">Yearly Dealer Wise Sales Report(Per Item)(CTN)(Select Zone)</div></td>
</tr>



<tr>

	<td><input name="report" type="radio" class="radio" value="115" /></td>

	<td><div align="left">Yearly Dealer Wise Sales Report(Per Item)(TK)(Select Zone)</div></td>
</tr>-->



                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                 <!-- <tr>

                    <td>Product Sales Group:</td>

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

                  </tr>-->

                  <!--<tr>

                    <td>Product Name : </td>

                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>

                  </tr>-->
				  
				  <tr>

                    <td>Item Mother Group:</td>

                    <td><span class="oe_form_group_cell">

                      <select name="item_mother_group" id="item_mother_group"  onchange="getData2('item_mother_group_ajax.php', 'mother_group', this.value, 
document.getElementById('item_mother_group').value);">

                      <option></option>

                        <? foreign_relation('item_mother_group','id','mother_group_name',$item_mother_group);?>

                      </select>

                    </span></td>

                  </tr>
				  
				  <tr>

                    <td>Item Group: </td>

                    <td>
					<span id="mother_group">
					<select name="item_group" id="item_group"  onchange="getData2('item_sub_group_ajax.php', 'sub_group', this.value, 
document.getElementById('item_group').value);">

                      <option></option>
                      <? foreign_relation('item_group','group_id','group_name',$item_group, 'product_type="Finish Goods"');?>

                    </select>
					</span></td>
                  </tr>
				  
				  
				  
				  <tr>

                    <td>Item Sub Group: </td>

                    <td>
					<span id="sub_group">
					<select name="item_sub_group" id="item_sub_group">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, "fg_sub_group='Yes'");?>

                    </select></span></td>
                  </tr>
				  
				  <tr>

                    <td>Item Type:</td>

                    <td><select name="item_type" id="item_type"  >

                      <option></option>

                      <? foreign_relation('item_type','id','item_type',$item_type,' 1 order by item_type');?>

                    </select></td>

                  </tr>
				  
				  
				  <tr>

                    <td>Return Type:</td>

                    <td><select name="return_type" id="return_type"  >

                      <option></option>

                      <? foreign_relation('sale_return_type','id','return_type',$return_type,' 1 order by return_type');?>

                    </select></td>

                  </tr>
				  

                  <tr>

                    <td>From: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				  <tr>

                    <td>Dealer Name:</td>

                    <td>

                    <input  name="dealer_code" type="text" id="dealer_code" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  
				  
				  

					

				  <!--<tr>

				    <td>Dealer Type :</td>

				    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

				      <select name="dealer_type" id="dealer_type" style="width:150px;">

				        <option selected="selected">Distributor</option>

				        <option>Corporate</option>

			          </select>

				    </span></td>

			      </tr>-->

				  <!--<tr>

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

                  </tr>-->

                  <!--<tr>

                    <td>Division Name:</td>

                    <td><span id="branch" class="oe_form_group_cell">

                      <select name="region_id" id="region_id" onchange="getData2('ajax_zone.php', 'zone', this.value,  this.value)">

                        <option></option>

                        <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$region_id,' 1 order by BRANCH_ID');?>

                      </select>

                    </span></td>

                  </tr>-->

                  <tr>

                    <td>Zone Name:</td>

                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                      <option></option>

                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_id,' 1 order by ZONE_NAME');?>

                    </select></span></td>

                  </tr>

                  <!--<tr>

                    <td>Area Name:</td>

                    <td><span id="area"><select name="area_id" id="area_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                    <option></option>

                      <? foreign_relation('area','AREA_CODE','AREA_NAME',$area_id,' 1 order by AREA_NAME');?>

                    </select></span></td>

                  </tr>-->

                  <!--<tr>

                    <td>Depot Name:</td>

                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                      <select name="depot_id" id="depot_id" >
					  
					  <option></option>


                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot_id,'1');?>

                      </select>

                    </span></td>

                  </tr>-->
				  
				  
				  <tr>
                    <td>Company:</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select class="form-control" name="group_for" id="group_for" >
                        <option></option>
                        <? foreign_relation('user_group','id','group_name',$group_for,'1');?>
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

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>