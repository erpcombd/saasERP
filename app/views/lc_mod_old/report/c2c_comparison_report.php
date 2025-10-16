<?php

//

//

require "../../support/inc.all.php";

$title='Customer to Customer Sales Comparison Reports';



do_calander("#f_date");

do_calander("#t_date");


auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_3');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_4');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_5');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_6');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_7');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_8');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_9');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_10');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_11');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_12');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_13');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_14');
auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_15');




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

                         
																					 
																					 
																					
																					 
																					 
																			<tr>

							  													 <td><input name="report" type="radio" class="radio" value="2006020322"  checked="checked"/></td>

																					<td><div align="left">CUSTOMER TO CUSTOMER COMPARISON (PRODUCT QUANTITY)</div></td>
																			 </tr>
																			 
																			 <tr>

							  													 <td><input name="report" type="radio" class="radio" value="200602032211" /></td>

																					<td><div align="left">CUSTOMER TO CUSTOMER COMPARISON (PRODUCT VALUE)</div></td>
																			 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="2006020333" /></td>

																							<td><div align="left">CUSTOMER TO CUSTOMER COMPARISON (PRODUCT GROUP QUANTITY) </div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="200602033311" /></td>

																							<td><div align="left">CUSTOMER TO CUSTOMER COMPARISON (PRODUCT GROUP VALUE) </div></td>
																					 </tr>
																					 
																					 
																					
																					 
																					



                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                 
				  
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
					<select name="item_sub_group" id="item_sub_group"  onchange="getData2('item_name_ajax.php', 'item_name', this.value, 
document.getElementById('item_sub_group').value);">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, "fg_sub_group='Yes'");?>

                    </select></span></td>
                  </tr>
				  
				  
				  <tr>

                    <td>Item Size: </td>

                    <td>
					<span id="item_name">
					<select name="item_id" id="item_id">

                      <option></option>

                      <? foreign_relation('item_info','item_id','item_name',$item_id, "product_nature='Salable'");?>

                    </select></span></td>
                  </tr>
				  
				  
				  
				  <tr>

                    <td>Item Type:</td>

                    <td><select name="item_type" id="item_type"  >

                      <option></option>

                      <? foreign_relation('item_type','id','item_type',$item_type,' 1 order by item_type');?>

                    </select></td>

                  </tr>
				  
				  
				  <!--<tr>

                    <td>Return Type:</td>

                    <td><select name="return_type" id="return_type"  >

                      <option></option>

                      <? foreign_relation('sale_return_type','id','return_type',$return_type,' 1 order by return_type');?>

                    </select></td>

                  </tr>-->
				  

                  <tr>

                    <td>From: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				  <tr>

                    <td>Customer 1:</td>

                    <td>

                    <input  name="dealer_code" type="text" id="dealer_code" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  
				  
				  <tr>

                    <td>Customer 2:</td>

                    <td>

                    <input  name="dealer_code_to" type="text" id="dealer_code_to" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  
				   <tr>

                    <td>Customer 3:</td>

                    <td>

                    <input  name="dealer_code_3" type="text" id="dealer_code_3" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 4:</td>

                    <td>

                    <input  name="dealer_code_4" type="text" id="dealer_code_4" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  
				  <tr>

                    <td>Customer 5:</td>

                    <td>

                    <input  name="dealer_code_5" type="text" id="dealer_code_5" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 6:</td>

                    <td>

                    <input  name="dealer_code_6" type="text" id="dealer_code_6" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  
				  <tr>

                    <td>Customer 7:</td>

                    <td>

                    <input  name="dealer_code_7" type="text" id="dealer_code_7" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 8:</td>

                    <td>

                    <input  name="dealer_code_8" type="text" id="dealer_code_8" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 9:</td>

                    <td>

                    <input  name="dealer_code_9" type="text" id="dealer_code_9" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 10:</td>

                    <td>

                    <input  name="dealer_code_10" type="text" id="dealer_code_10" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 11:</td>

                    <td>

                    <input  name="dealer_code_11" type="text" id="dealer_code_11" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 12:</td>

                    <td>

                    <input  name="dealer_code_12" type="text" id="dealer_code_12" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 13:</td>

                    <td>

                    <input  name="dealer_code_13" type="text" id="dealer_code_13" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 14:</td>

                    <td>

                    <input  name="dealer_code_14" type="text" id="dealer_code_14" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Customer 15:</td>

                    <td>

                    <input  name="dealer_code_15" type="text" id="dealer_code_15" style="width:200px;"/>

                    </td>

                  </tr>
				  

				 

                  <!--<tr>

                    <td>Zone Name:</td>

                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                      <option></option>

                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_id,' 1 order by ZONE_NAME');?>

                    </select></span></td>

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