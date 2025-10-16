<?php






 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





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





							<!--  <tr>





                                <td><input name="report" type="radio" class="radio" value="1001" /></td>





							    <td><div align="left">Stock Valuation Report </div></td>





						      </tr>-->


							   <tr>





                                 <td width="6%"><input name="report" type="radio" class="radio" value="400001" /></td>





							     <td width="94%"><div align="left">PR Summery Receive Date Wise </div></td>
						      </tr>





                          </table></td>





                        </tr>





                    </table></td>





                  </tr>





              </table></td>





              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">



                  <tr>
                    <td>Item Code  : </td>
                    <td>
					<input type="text" name="item_id" id="item_id"  />                    </td>
                  </tr>
                  <tr>

                    <td>Item Group  : </td>

                    <td>

					<select name="group_id" id="group_id">

					<option></option>

					<?  foreign_relation('item_group','group_id','group_name',$group_id); ?>
					</select>					</td>
                  </tr>

                  <tr>
                    <td>Item Sub Group : </td>
                    <td><select name="sub_group_id" id="sub_group_id">
                      <option></option>
                      <?  foreign_relation('item_sub_group','sub_group_id','sub_group_name',$sub_group_id); ?>
                    </select></td>
                  </tr>
                  <tr>

                    <td>Warehouse Section : </td>

                    <td><select name="warehouse_id" id="warehouse_id">

                      <option></option>

                      <? echo foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id); ?>

                    </select></td>
                  </tr>

                  <tr>





                    <td>From:</td>





                    <td><input  name="f_date" type="text" id="f_date" value=""/></td>
                  </tr>





                  <tr>





                    <td>To:</td>





                    <td><input  name="t_date" type="text" id="t_date" value=""/></td>
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