<?php
session_start();
ob_start();
require_once "../../../assets/support/inc.all.php";
$title='Sales Order Reports';

do_calander("#f_date");
do_calander("#t_date");
do_calander("#cut_date");
//auto_complete_from_db('dealer_info','concat(dealer_code,"-","-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');
auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 
','item_id');

//auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');

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
                                <td><div align="left">Sales Order Summary Report (Item Wise)</div></td>
                              </tr>
							  
							  
							   <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="546465" /></td>

                                <td width="94%"><div align="left">Sales Order Report(Customer Wise In Amount)</div></td>
                              </tr>
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1010" /></td>
                                <td><div align="left">Daily Sales Report</div></td>
                              </tr>-->
							  
							  
							  
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1991" /></td>
                                <td><div align="left">Sales Order Report (Challan Amount)</div></td>
                              </tr>-->
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="191" /></td>
                                <td><div align="left">Sales Order  Report (Item Wise) </div></td>
                              </tr>
							  
							  
							  


                              <!--<tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Undelivered SO Details Report</div></td>
                              </tr>-->

  								<!--<tr>
                                <td><input name="report" type="radio" class="radio" value="3" /></td>
                          		<td><div align="left">Undelivered SO Report Customer Wise</div></td>
                          		</tr>-->


           					<!--<tr>
                                <td><input name="report" type="radio" class="radio" value="7" /></td>
                                <td><div align="left">Item Wise SO Report</div></td>
                              </tr>-->
							  
							  
							   <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="321" /></td>
                              <td><div align="left">Staff Wise Sales Report at a glance</div></td>

                              </tr>-->
							  
							  <!--<tr>

                           <td><input name="report" type="radio" class="radio" value="2001" /></td>
                           <td><div align="left">Aksid Staff Commission Report</div></td>
                            
						   </tr>
						   
						  <tr>
                           <td><input name="report" type="radio" class="radio" value="200222" /></td>
                           <td><div align="left">Aksid Staff Commission Report New</div></td>
                            
						   </tr>-->
						   
						   
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="701" /></td>
                                <td><div align="left">Item Wise Undelivered SO Report(With Sample)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="7011" /></td>
                                <td><div align="left">Item Wise Undelivered SO Report(Without Sample)</div></td>
                              </tr>-->

                              
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1992" /></td>
                                <td><div align="left">Sales Statement(As Per SO)</div></td>
                              </tr>-->
<!--							  <tr>
                                <td><input name="report" type="radio" class="radio" value="5" /></td>
                                <td><div align="left">Delivery Order Brief Report (Region Wise)</div></td>
                              </tr>-->
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="14" /></td>
                                <td><div align="left">Item DO Report (Region)</div></td>
                              </tr>
-->
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="9" /></td>

                                <td><div align="left">Item DO Report (Region+Zone)</div></td>
                              </tr>-->
                             <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="8" /></td>

                                <td><div align="left">Dealer Performance Report</div></td>
                              </tr>-->
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="10" /></td>
                                <td><div align="left">Daily Collection Summary</div></td>
                              </tr>-->
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="13" /></td>
                                <td><div align="left">Daily Collection Summary (Ext)</div></td>
                              </tr>-->
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="11" /></td>
                                <td><div align="left">Daily Collection &amp; Order Summary</div></td>
                              </tr>-->
                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="1999" /></td>

                                <td><div align="left">DO Report for Scratch Card</div></td>

                              </tr>-->







                          </table></td>







                        </tr>







                    </table></td>







                  </tr>







              </table></td>







              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">


       


                  <!--<tr>
                    <td>Product Name : </td>
                    <td><input type="text" name="item_id" id="item_id" style="margin-left:4px" /></td>
                  </tr>-->

				   

                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>

                  <tr>
                    <td>To : </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>


				  <tr>

                    <td>Customer Name :</td>
                    <td>
                        <input list="del_name" name="dealer_code" id="dealer_code" type="text">
							<datalist id="del_name">
 							<? foreign_relation('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)',$del_name,' 1 order by dealer_code');?>
							</datalist>
                  
                     </td>
                  	</tr>

				  
				  

				  <tr>
                    <td>SO No: </td>
                    <td><input  name="do_no" type="text" id="do_no" value=""/></td>
                  </tr>
                  
                  <tr>
                    <td>Warehouse Name :</td>
                    <td><span class="oe_form_group_cell" >

                      <select name="depot_id" id="depot_id" style="margin-left:4px">
                      <option></option>
                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>
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
include ("../../template/main_layout.php");
?>