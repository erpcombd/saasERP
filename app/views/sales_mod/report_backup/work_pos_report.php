<?php


 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Pos Sales Advance Reports';



do_calander("#f_date");

do_calander("#t_date");

do_calander("#cut_date");

auto_complete_from_db('dealer_info','concat(dealer_code,"-",team_name,"-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>



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

                                <td><input name="report" type="radio" class="radio" value="150" checked="checked" /></td>

                                <td><div align="left">Pos Sales Brief Report</div></td>
                              </tr>

                            <!--  <tr>
							  
							  
							   <td><input name="report" type="radio" class="radio" value="1111" /></td>

                                <td><div align="left">Monthly Sales Statement</div></td>
							  

                               <td><input name="report" type="radio" class="radio" value="101" /></td>

                                <td><div align="left">Delivery Order wise Chalan Brief Report</div></td>
                              </tr>

                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1112" /></td>
                                <td><div align="left">National Sales Statement</div></td>
                              </tr>
                              <tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1113" /></td>
                                <td><div align="left">National Sales Statement (Item Wise)</div></td>
                              </tr>
                              <tr>-->
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1114" /></td>
                                <td><div align="left">SR Wise Contribution </div></td>
                              </tr>
							  
							  
                              <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>

                                <td width="94%"><div align="left">Item Wise Challan  Details Report</div></td>
                              </tr>
							  
							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="1115" /></td>

                                <td width="94%"><div align="left">Gift Item Challan  Details Report</div></td>
                              </tr>

                              

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="3" /></td>

                                <td><div align="left">Delivered Challan Report (Chalan Wise)</div></td>
                              </tr>
							  
							  <tr>

                                <td><input name="report" type="radio" class="radio" value="30" /></td>

                                <td><div align="left">Day by Day Product Wise Chalan</div></td>
                              </tr>-->

                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="4" /></td>

                                <td><div align="left">Chalan Report(Chalan Date Wise)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="5" /></td>

                                <td><div align="left">Delivery Order Brief Report (Region Wise)</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="1004" /></td>

                                <td><div align="left">Warehouse Stock Position Report(Closing)</div></td>

                              </tr>

							                                <tr>

                                <td><input name="report" type="radio" class="radio" value="1005" /></td>

                                <td><div align="left">Warehouse Stock Position Report(Promotion)</div></td>

                              </tr>

							  

                              <tr>
                                <td><input name="report" type="radio" class="radio" value="1001" /></td>
                                <td><div align="left">Delivered Challan Vat Report</div></td>
                              </tr>-->
                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="6" /></td>

                                <td><div align="left">View Challan Report (Single)</div></td>
                              </tr>-->

                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>
                              </tr>

                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>
                              </tr>

                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="111" /></td>

                                <td><div align="left">Corporate Chalan Summary Brief</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="112" /></td>

                                <td><div align="left">SuperShop Chalan Summary Brief</div></td>

                              </tr>-->

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

                    <td>Product Name : </td>

                    <td><input type="text" name="item_id" id="item_id" class="form-control" /></td>
                  </tr>

                  <tr>

                    <td>From : </td>

                    <td><input class="form-control"  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>
                  </tr>

                  <tr>

                    <td>To : </td>

                    <td><input class="form-control"  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>

				  <tr>

                    <td>Dealer Name :</td>

                    <td><input  name="dealer_code" type="text" id="dealer_code" class="form-control"/></td>
                  </tr>

					

				 <!-- <tr>

				    <td>Dealer Type :</td>

				    <td><span class="oe_form_group_cell" >

				      <select name="dealer_type" id="dealer_type" class="form-control" style="margin-left:4px">

					  <option></option>

                        <option value="Distributor" >Distributor</option>

						<!--<option value="Corporate" >Corporate</option>

						<option value="SuperShop" >SuperShop</option>
                      </select>

				    </span></td>
			      </tr>-->

				  <tr>

				    <td>Pos Status :</td>

				    <td><select name="status" id="status" class="form-control" style="margin-left:4px">

					    <option></option>

                        <option value="COMPLETED">Completed</option>

                        <option value="MANUAL">Suspended</option>

			        </select></td>
			      </tr>

				  <tr>

                    <td>Pos No: </td>

                    <td><input  name="pos_id" type="text" id="pos_id" value="" class="form-control" /></td>
                  </tr>
				  
				  


               
                  <tr>

                    <td>Depot Name :</td>

                    <td><span class="oe_form_group_cell">

                      <select name="depot_id" id="depot_id" class="form-control" style="margin-left:4px">

                      <option></option>

                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'center_depot="Yes"');?>
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

require_once SERVER_CORE."routing/layout.bottom.php";

?>