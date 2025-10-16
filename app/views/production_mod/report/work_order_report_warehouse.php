<?php




 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Work Order Advence Reports';



do_calander("#f_date");



do_calander("#t_date");



auto_complete_from_db('item_info','item_name','item_id','1','item_id');



?>



<form action="../../../warehouse_mod/pages/report/warehouse_master_report.php" method="post" name="form1" target="_blank" id="form1">



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



                                <td width="6%"><input name="report" type="radio" class="radio" value="100011" checked="checked" /></td>



                                <td width="94%"><div align="left">Warehouse  Transection Report IN </div></td>
                              </tr>



							  <tr>
							    <td><input name="report" type="radio" class="radio" value="112233445566" checked="checked" /></td>
							    <td style="text-align:left;">Consumption Report FG wise </td>
						      </tr>
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="112233445577" checked="checked" /></td>
							    <td style="text-align:left;">Consumption Report Sub gruop wise </td>
						      </tr>
							  
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="112233445588" checked="checked" /></td>
							    <td style="text-align:left;">Sales Report Brand category wise </td>
						      </tr>
							  
							  
							  <tr>
							    <td><input name="report" type="radio" class="radio" value="112233445577" checked="checked" /></td>
							    <td style="text-align:left;">Consumption Report Sub gruop wise </td>
						      </tr>
							  
							  
							  <tr>



                                <td width="6%"><input name="report" type="radio" class="radio" value="200011" /></td>



                                <td style="text-align:left;">Warehouse  Transection Report OUT </td>
                              </tr>



							  	



								<tr>



                               <td width="6%"><input name="report" type="radio" class="radio" value="190625" /></td>



                                <td style="text-align:left;">All Consumption Report details</td>
                              	</tr> 



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="300011" /></td>



							    <td style="text-align:left;">Warehouse  Transection Report IN/OUT </td>
						      </tr>



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="400011" /></td>



							    <td><div align="left">Suplier Wise IN Report </div></td>
						      </tr>



							  



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="190629" /></td>



							    <td><div align="left">All Damage Report</div></td>
						      </tr>



							  



							   <tr>



							    <td><input name="report" type="radio" class="radio" value="201906200" /></td>



							    <td><div align="left">Suplier Wise Reject Report </div></td>
						      </tr>



							  



							   <tr>



							    <td><input name="report" type="radio" class="radio" value="20190620" /></td>



							    <td><div align="left">Sales Return Report</div></td>
						      </tr>



							  



							  



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="1008" /></td>



							    <td><div align="left">Warehouse  Purchase  Report</div></td>
						      </tr>



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="8" /></td>



							    <td><div align="left">Warehouse  Transection Report (Entry Wise) </div></td>
						      </tr>



							<!--  <tr>



                                <td width="6%"><input name="report" type="radio" class="radio" value="22" /></td>



                                <td width="94%"><div align="left">Category Wise Stock Report </div></td>



                              </tr>



-->



							  



							  



							  <tr>



                                <td width="6%"><input name="report" type="radio" class="radio" value="2006" /></td>



                                <td width="94%"><div align="left">Category Wise Stock Report Including Nill Balance </div></td>
                              </tr>

							  

							   <tr>



                                <td width="6%"><input name="report" type="radio" class="radio" value="76" /></td>



                                <td width="94%"><div align="left">Category Wise Stock Report Excluding Nill Balance </div></td>
                              </tr>

							  

							  

							  <tr>



                                <td width="6%"><input name="report" type="radio" class="radio" value="20190821" /></td>



                                <td width="94%"><div align="left">Warehouse Wise Stock Report  </div></td>
                              </tr>



							  

								 <tr>



                                <td width="6%"><input name="report" type="radio" class="radio" value="30092019" /></td>



                                <td width="94%"><div align="left">Group & Warehouse wise Stock Report  </div></td>
                              </tr>

							  



							    <tr>



                                <td width="6%"><input name="report" type="radio" class="radio" value="190623" /></td>



                                <td width="94%"><div align="left">All Opening Stock Report </div></td>
                              </tr>



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="200002" /></td>



							    <td style="text-align:left;">Warehouse Present Stock Closing </td>
						      </tr>



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="400000" /></td>



							    <td style="text-align:left;">ALL Product List </td>
						      </tr>



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="440000" /></td>



							    <td style="text-align:left;">ALL Finish Good Product List </td>
						      </tr>



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="200001" /></td>



							    <td style="text-align:left;">Re Order Level Quantity </td>
						      </tr>



							  



							  <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="4" /></td>

                                <td width="94%"><div align="left">Warehouse Present Stock (Finish Goods)</div></td>
                              </tr>

							  

							   <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="18082019" /></td>

                                <td width="94%"><div align="left"> Warehouse Stock Master Report</div></td>
                              </tr>

								 <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="190808" /></td>

                                <td width="94%"><div align="left">Warehouse FG Production Detail</div></td>
                              </tr>



							  



							   <tr>



							     <td><input name="report" type="radio" class="radio" value="10011" /></td>



							     <td style="text-align:left;">Product Stock Reorder  Level </td>
						      </tr>



							   <tr>



                                 <td><input name="report" type="radio" class="radio" value="10011" /></td>



							     <td><div align="left">Stock Valuation Report (HFL) </div></td>
						      </tr>



							  <tr>



                                <td><input name="report" type="radio" class="radio" value="1004" /></td>



							    <td><div align="left">RM Consumtion Report</div></td>
						      </tr>



							  <tr>



							    <td><input name="report" type="radio" class="radio" value="1005" /></td>



							    <td><div align="left">FG Production Report</div></td>
						      </tr>



							<!--  <tr>



                                <td><input name="report" type="radio" class="radio" value="1001" /></td>



							    <td><div align="left">Stock Valuation Report </div></td>



						      </tr>-->



							  



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



							  



							   <tr>



							     <td><input name="report" type="radio" class="radio" value="1009" /></td>



							     <td><div align="left">Daily Chalan Issue Report</div></td>
						      </tr>



							   <tr>



							     <td><input name="report" type="radio" class="radio" value="1010" /></td>



							     <td><div align="left">Issue Report Person/Department wise </div></td>
						      </tr>



							   <tr>



                                 <td><input name="report" type="radio" class="radio" value="21010" /></td>



							     <td><div align="left">Requisition Status Report </div></td>
						      </tr>



							   <tr>



                                 <td><input name="report" type="radio" class="radio" value="300001" /></td>



							     <td><div align="left">Floor Requisition Report </div></td>
						      </tr>



							   <tr>



                                 <td><input name="report" type="radio" class="radio" value="400001" /></td>



							     <td><div align="left">Floor Stock Report </div></td>
						      </tr>



							   <tr>



                                 <td><input name="report" type="radio" class="radio" value="700001" /></td>



							     <td><div align="left">Production Line Return Report </div></td>
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



                    <td><input type="text" name="item_id" id="item_id"  style="width:250px" /></td>



                  </tr>



                  <tr>



                    <td>Item Group: </td>



                    <td><select name="group_id" id="group_id">



                      <option></option>



                      <? foreign_relation('item_group','group_id','group_name');?>



                    </select></td>



                  </tr>



                  <tr>



                    <td>Item Sub Group: </td>



                    <td><select name="item_sub_group" id="item_sub_group">



                      <option></option>



                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>



                    </select></td>



                  </tr>



                 <!-- <tr>



                    <td>Product Group: </td>



                    <td><select name="sales_item_type" id="sales_item_type">



                      <option></option>



                      <option>A</option>



					  <option>B</option>



					  <option>C</option>



                      <option>D</option>



                    </select></td>



                  </tr>-->



                  <tr>



                    <td>Finish Goods Section </td>



                    <td>



					



					



					<select name="brand_category" id="brand_category">







                                                <option></option>







                                                <option value="Spices">Spices</option>







                                                <option value="Snacks">Snacks</option>







                                                <option value="Rice">Rice</option>







                                                <option value="Oil">Oil</option>







                                                <option value="Bakeries">Bakeries</option>







                                                <option value="Pickle">Pickle</option>







                                                <option value="Drinks & Juice">Drinks & Juice</option>



												



												<option value="Shemai">Shemai & Noodles</option>



												<option value="Trading Product">Trading Product</option>



                                            </select>					</td>



                  </tr>



                  <tr>



                    <td>From:</td>



                    <td><input  name="f_date" type="text" id="f_date" value="<?=date("Y-m-d"); ?>" autocomplete="off"/></td>



                  </tr>



                  <tr>



                    <td>To:</td>



                    <td><input  name="t_date" type="text" id="t_date" value="<?=date("Y-m-d"); ?>" autocomplete="off"/></td>



                  </tr>



				  <tr>



                    <td>Issue Status: </td>



                    <td><select name="issue_status" id="issue_status">



<option value=""></option>



<option value='Sales'>Sales</option>



<option value='Issue'>Issue</option>



<option value='Office Issue'>Office Issue</option>



<option value='Sample Issue'>Sample Issue</option>



<option value='Gift Issue'>Gift Issue</option>



<option value='Entertainment Issue'>Entertainment Issue</option>



<option value='R & D Issue'>R & D Issue</option>



<option value='Other Issue'>Other Issue</option>



<option value='Staff Sales'>Staff Sales</option>



<option value='Export'>Export Sales</option>



<option value='Other Sales'>Other Sales</option>



<option value='Consumption'>Consumption</option>



<option value='Purchase Return'>Purchase Return</option>







                    </select></td>



                  </tr>



					



				  <tr>



				    <td>Receive Status: </td>



				    <td>



					<select name="receive_status" id="receive_status">



<option value=""></option>



<option value='All_Purchase'>All Purchase</option>



<option value='Purchase'>Purchase</option>







<option value='Sales_Floor_Return'>Sales and Floor Return</option>



<option value='Receive'>Receive</option>



<option value='Return'>Return</option>



<option value='Production Return'>Production Return</option>



<option value='Opening'>Opening</option>



<option value='Opening-2016'>Opening FG</option>



<option value='Other Receive'>Other Receive</option>



<option value='Local Purchase'>Local Purchase</option>



<option value='Sales Return'>Sales Return</option>







<option value='Sample Receive'>Sample Receive</option>



<option value='Import'>Import</option>



<option value='Production'>Production</option>



<option value='Production Receive'>Production Receive</option>



			        </select></td>



			      </tr>



                  <tr>



                    <td>Inventory Name: </td>



                    <td><select name="warehouse_id" id="warehouse_id">



                      <option selected="selected"></option>



                      <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1 order by warehouse_name asc');?>



                    </select></td>



                  </tr>



                  <tr>



                    <td>Employee Name : </td>



                    <td><select name="emp_id" id="emp_id">



                      <option selected="selected"></option>



                      <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME','','1 order by PBI_NAME asc');?>



                    </select></td>



                  </tr>



                  <tr>



                    <td>Department :</td>



                    <td><select name="department" id="department">



                      <option selected="selected"></option>



                      <? foreign_relation('department','DEPT_ID','DEPT_DESC','','1 order by DEPT_DESC asc');?>



                    </select></td>



                  </tr>



                  <tr>



                    <td>Vendor : </td>



                    <td><select name="vendor_id" id="vendor_id">



                        <option selected="selected"></option>



                        <? foreign_relation('vendor','vendor_id','vendor_name','','1 order by vendor_name asc');?>



                    </select></td>



                  </tr>



				  



				  <tr>



                    <td>Dealer : </td>



                    <td><select name="dealer_code" id="dealer_code">



                        <option selected="selected"></option>



                        <? foreign_relation(' dealer_info','dealer_code','dealer_name_e','','1 order by dealer_name_e asc');?>



                    </select></td>



                  </tr>



						<?php /*?><tr>



                    <td>Sales Type : </td>



                    <td><select name="gate_pass_type" id="gate_pass_type">



                        <option selected="selected"></option>



                        <? foreign_relation('sale_do_chalan','distinct gate_pass_type','gate_pass_type','','chalan_no!=0');?>



                    </select></td>



                  </tr><?php */?>



                  <tr>



                    <td>Production Line : </td>



                    <td><select name="production_line" id="production_line">



                      <option selected="selected"></option>



                      <? foreign_relation('warehouse','warehouse_id','warehouse_name','','1 and use_type="PL"');?>



                    </select></td>



                  </tr>



				  



				   <tr>



                    <td>FG TYPE : </td>



                    <td><select name="batch_type" id="batch_type">



                      <option selected="selected"></option>



					   <option >Local</option>



					    <option >Foreign</option>



                      



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