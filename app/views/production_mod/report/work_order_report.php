<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







$title='Production Advance Reports';















do_calander("#f_date");







do_calander("#t_date");







auto_complete_from_db('item_info','item_name','item_id','1','item_id');







?>







<style type="text/css">







<!--







.style1 {







	color: #009933;







	font-weight: bold;







}







-->







</style>




<div class="d-flex justify-content-center">

    <form class="n-form1 fo-width pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1" style="width:90%" >

        <div class="row m-0 p-0">

            <div class="col-sm-6">

                <div align="left">Select Report </div>

                </br>

                <div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report0-btn" value="217" checked="checked" tabindex="1">

                    <label class="form-check-label p-0" for="report0-btn">

                  Production Report(FG) (217)

                    </label>

                </div>

                



                

                <div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report26-btn" value="218" tabindex="1">

                    <label class="form-check-label p-0" for="report26-btn">

                    Consumption Report (218)

                    </label>

                </div>
      <div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report26-btn" value="219" tabindex="1">

                    <label class="form-check-label p-0" for="report26-btn">

                  Production Wise Overhead report (219)

                    </label>

                </div>

<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report26-btn" value="27824" tabindex="1">

                    <label class="form-check-label p-0" for="report26-btn">

                BOM Report (27824)

                    </label>

                </div>
				
				
				<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report26-btn" value="261124" tabindex="1">

                    <label class="form-check-label p-0" for="report26-btn">

                Production VS Consumption report(261124)

                    </label>

                </div>
				

 
            </div>



            <div class="col-sm-6">



				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name:</label>

                    <div class="col-sm-8 p-0">

                    <input type="text" name="item_id" id="item_id" />

                    </div>

                </div>





             





				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Sub Group:</label>

                    <div class="col-sm-8 p-0">

                    <select name="item_sub_group" id="item_sub_group">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>

                    </select>

                    </div>

                </div>





                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date: </label>

                    <div class="col-sm-8 p-0">

                    <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>"  autocomplete="off"/>

                    </div>

                </div>



	<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date: </label>

                    <div class="col-sm-8 p-0">

                    <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"  autocomplete="off"/>

                    </div>

                </div>

                 

                 



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Section Name:</label>

                    <div class="col-sm-8 p-0">

                    <select name="section_id" id="section_id">

                      <option selected="selected"></option>

                      <? foreign_relation('warehouse','warehouse_id','warehouse_name','',' use_type="SC" order by warehouse_name');?>

                    </select>

                    </div>

                </div>



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Floor Name:</label>

                    <div class="col-sm-8 p-0">

                      <select name="warehouse_id" id="warehouse_id">

                          <option selected="selected"></option>

                          <? foreign_relation('warehouse','warehouse_id','warehouse_name','',' use_type="PL" order by warehouse_name');?>

                      </select>

                    </div>

                </div>

<!--

				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center"> Text</label>

                    <div class="col-sm-8 p-0">

                        input

                    </div>

                </div>

-->



            </div>



        </div>

        <div class="n-form-btn-class">

            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report">

            

        </div>

    </form>

</div>















<?/*>



</br>

</br>

</br>

</br>

</br>



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



                                <td><input name="report" type="radio" class="radio" value="111" checked="checked" /></td>



                                <td><div align="left">Recipe And Deduction Report</div></td>



                              </tr>



                              <tr>







                                <td width="6%"><input name="report" type="radio" class="radio" value="1" /></td>







                                <td width="94%"><div align="left">Warehouse Transection Report</div></td>



                              </tr>







							  <tr>







							    <td><input name="report" type="radio" class="radio" value="1008" /></td>







							    <td><div align="left">Warehouse  Purchase  Report</div></td>



						      </tr>

							  

							  

							   <tr>







							    <td><input name="report" type="radio" class="radio" value="091119" /></td>







							    <td><div align="left">Category Wise Stock Report Including Nill Balance</div></td>



						      </tr>

							  

							  

							    <tr>







							    <td><input name="report" type="radio" class="radio" value="09112019" /></td>







							    <td><div align="left">Group & Warehouse wise Stock Report </div></td>



						      </tr>



							 



							



							<tr>







							    <td><input name="report" type="radio" class="radio" value="21082022" /></td>







							    <td><div align="left">Warehouse  Purchase Pending  Report</div></td>



						      </tr>







							



							



							  <tr>







							    <td><input name="report" type="radio" class="radio" value="8" /></td>







							    <td><div align="left">Warehouse  Transection Report (Entry Wise) </div></td>



						      </tr>







							  <tr>



                                <td><input name="report" type="radio" class="radio" value="201916" /></td>



							    <td><div align="left">Warehouse Present Stock Floor details </div></td>



						      </tr>



							  <tr>







                                <td width="6%"><input name="report" type="radio" class="radio" value="21092019" /></td>







                                <td width="94%"><div align="left">Warehouse Present Stock Floor </div></td>



                              </tr>







							  <tr>



                                <td><input name="report" type="radio" class="radio" value="20181223" /></td>



							    <td><div align="left">Warehouse Present Stock CWH </div></td>



						      </tr>



							  <tr>







                                <td width="6%"><input name="report" type="radio" class="radio" value="4" /></td>







                                <td width="94%"><div align="left">Warehouse Present Stock (Finish Goods)</div></td>



                              </tr>



							  



							   <tr>







                                <td width="6%"><input name="report" type="radio" class="radio" value="2019" /></td>







                                <td width="94%"><div align="left">Floor Requisition History Report</div></td>



                              </tr>







							  <tr>







                                <td><input name="report" type="radio" class="radio" value="1004" /></td>







							    <td><div align="left">RM Consumtion Report</div></td>



						      </tr>







							  <tr>







							    <td><input name="report" type="radio" class="radio" value="1005" /></td>







							    <td><div align="left">FG Production Report</div></td>



						      </tr>







							  <tr>







                                <td><input name="report" type="radio" class="radio" value="1001" /></td>







							    <td><div align="left">Stock Valuation Report </div></td>



						      </tr>







							  







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







                                  <td><input name="report" type="radio" class="radio" value="1011" /></td>







								  <td><div align="left">Production Entry Form (Line Wise)</div></td>



							  </tr>







								<tr>







                                  <td><input name="report" type="radio" class="radio" value="10101" /></td>







								  <td><div align="left">Closing Stock Report (Production Line Wise) </div></td>



							  </tr>







								<tr>







                                  <td><input name="report" type="radio" class="radio" value="10102" /></td>







								  <td><div align="left">Closing Stock Report (Production Section Wise) </div></td>



							  </tr>







								<tr>







								  <td>&nbsp;</td>







								  <td>&nbsp;</td>



							  </tr>







								<tr>







								  <td colspan="2"><span class="style1">Advance Report </span></td>



							  </tr>







								<tr>







                                  <td><input name="report" type="radio" class="radio" value="1009" /></td>







								  <td><div align="left">Product IN OUT Report (Line Wise) </div></td>



							  </tr>







								<tr>







                                  <td><input name="report" type="radio" class="radio" value="1010" /></td>







								  <td><div align="left">Production Breif Report (Line Wise)</div></td>



							  </tr>







								







								<tr>







                                  <td><input name="report" type="radio" class="radio" value="1012" /></td>







								  <td><div align="left">Consumption Report (Recipe Wise)</div></td>



							  </tr>







							  <tr>







                                  <td><input name="report" type="radio" class="radio" value="1013" /></td>







								  <td><div align="left">Brief Consumption Report</div></td>



							  </tr>







							  							  <tr>







                                  <td><input name="report" type="radio" class="radio" value="1014" /></td>







								  <td><div align="left">Sales Terget Vs. Production Report(Brief)</div></td>



							  </tr>







							  <tr>







                                  <td><input name="report" type="radio" class="radio" value="1015" /></td>







								  <td><div align="left">Sales Terget Vs. Production Report(ALL)</div></td>



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







                      <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>







                  </tr>







                  <tr>







                    <td>Item Sub Group: </td>







                    <td><select name="item_sub_group" id="item_sub_group">







                      <option></option>







                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>







                    </select></td>







                  </tr>







                  <tr>







                    <td>From:</td>







                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01');?>"/></td>







                  </tr>







                  <tr>







                    <td>To:</td>







                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d');?>"/></td>







                  </tr>







				  <tr>







                    <td>Issue Status: </td>







                    <td><select name="issue_status" id="issue_status">







<option value=""></option>







<option value='Sales'>Sales</option>







<option value='Issue'>Issue</option>







<option value='Sample Issue'>Sample Issue</option>







<option value='Gift Issue'>Gift Issue</option>







<option value='Entertainment Issue'>Entertainment Issue</option>







<option value='R & D Issue'>R & D Issue</option>







<option value='Other Issue'>Other Issue</option>







<option value='Staff Sales'>Staff Sales</option>







<option value='Export Sales'>Export Sales</option>







<option value='Other Sales'>Other Sales</option>







<option value='Consumption'>Consumption</option>







                    </select></td>







                  </tr>







					







				  <tr>







				    <td>Receive Status: </td>







				    <td>







					<select name="receive_status" id="receive_status">







<option value=""></option>







<option value='All_Purchase'>All Purchase</option>







<option value='Purchase'>Purchase</option>







<option value='Receive'>Receive</option>







<option value='Return'>Return</option>







<option value='Opening'>Opening</option>







<option value='Other Receive'>Other Receive</option>







<option value='Local Purchase'>Local Purchase</option>







<option value='Sample Receive'>Sample Receive</option>







<option value='Import'>Import</option>







<option value='Production'>Production</option>







			        </select></td>







			      </tr>







                  <tr>







                    <td>Section Name: </td>







                    <td><select name="section_id" id="section_id">







                        <option selected="selected"></option>







                        <? foreign_relation('warehouse_section','id','section_name','',' 1');?>







                    </select></td>







                  </tr>







                  <tr>







                    <td>Floor Name: </td>







                    <td>







					<select name="warehouse_id" id="warehouse_id">







                      <option selected="selected"></option>







					  <? foreign_relation('warehouse','warehouse_id','warehouse_name','',' use_type="PL" order by warehouse_name');?>







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

<*/ ?>





<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>