<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='SPARE PARTS STOCK MOVEMENT REPORT';



do_calander("#f_date");

do_calander("#t_date");

create_combobox('item_id');

create_combobox('machine_id');

//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');
?>



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
							  
							  
							  
																				  <tr>
													
																						 <td><input name="report" type="radio" class="radio" value="220411001" checked="checked" /></td>
													
																						<td><div align="left">SPARE PARTS STOCK MOVEMENT REPORT</div></td>
																				 </tr>
																				 
																				 
																				 <tr>
													
																						 <td><input name="report" type="radio" class="radio" value="220411002" /></td>
													
																						<td><div align="left">SPARE PARTS PURCHASE SUMMARY</div></td>
																				 </tr>
																				 
																				 
																				 <tr>
													
																						 <td><input name="report" type="radio" class="radio" value="220411003" /></td>
													
																						<td><div align="left">SPARE PARTS PURCHASE DETAILS</div></td>
																				 </tr>
																				 
																				 
																				 
																				 <tr>
													
																						 <td><input name="report" type="radio" class="radio" value="220411004" /></td>
													
																						<td><div align="left">SPARE PARTS SALES SUMMARY</div></td>
																				 </tr>
																				 
																				 
																				 <tr>
													
																						 <td><input name="report" type="radio" class="radio" value="220411005" /></td>
													
																						<td><div align="left">SPARE PARTS SALES DETAILS</div></td>
																				 </tr>

                           
							 
																					 
																					 
																					<!-- <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20060201" /></td>

																							<td><div align="left">PRODUCT SIZE WISE SALES REPORT</div></td>
																					 </tr>
																					 
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20060202" /></td>

																							<td><div align="left">PRODUCT GROUP WISE SALES REPORT</div></td>
																					 </tr>-->
																					 
																					 
																					 

																					 
																					



                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

				  
				  
				  
				
				   <!--onchange="getData2('item_info_find_ajax.php', 'find_item', this.value, 
document.getElementById('item_sub_group').value);"-->
				  
				  
				    
				  <tr>

                    <td>Item Sub Group: </td>

                    <td>
					<span id="sub_group">
					<select name="item_sub_group" id="item_sub_group" >

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, "group_id='1000000000' order by sub_group_name" );?>

                    </select></span></td>
                  </tr>
				  
				  
				  <tr>

                    <td>Item Name: </td>

                    <td>
					<span id="find_item">
					<select name="item_id" id="item_id">

                      <option></option>

                      <? foreign_relation('item_info i, item_sub_group s','i.item_id','i.item_name',$item_id, "s.group_id='1000000000'  and i.sub_group_id=s.sub_group_id order by i.item_name ");?>

                    </select></span></td>
                  </tr>
				  
				  
				 
				  
				  
				 
				  
				
				  

                  <tr>

                    <td>From: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				  <?php /*?><tr>

                    <td>Dealer Name:</td>

                    <td>

                    <input  name="dealer_code" type="text" id="dealer_code" />

                    </td>

                  </tr><?php */?>
				  
				  
				  
				  

					
<tr>
                    <td>Purchased Manager:</td>
                    <td><span class="oe_form_group_cell" >
                      <select class="form-control" name="purchase_manager" id="purchase_manager" >
					  
					  <option></option>
                       
                        <? foreign_relation('purchase_manager','id','purchase_manager',$purchase_manager,'1');?>
                      </select>
                      </span></td>
                  </tr>
				  
				  
				  
				  <tr>
                    <td>Machine No:</td>
                    <td><span class="oe_form_group_cell" >
                      <select class="form-control" name="machine_id" id="machine_id" >
					  
					  <option></option>
                       
                        <? foreign_relation('machine_info','machine_id','machine_short_name',$machine_id,'1');?>
                      </select>
                      </span></td>
                  </tr>

				  
				  
				  <tr>
                    <td>Location:</td>
                    <td><span class="oe_form_group_cell" >
                      <select  name="warehouse_id" id="warehouse_id" >

						<option></option>	
						<? foreign_relation('spare_parts_sales_location','warehouse_id','warehouse_name',$warehouse_id,'1 order by warehouse_id');?>
					</select>
                      </span></td>
                  </tr>
				  
				

                  
				  
				  <tr>
                    <td>Company:</td>
                    <td><span class="oe_form_group_cell" >
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