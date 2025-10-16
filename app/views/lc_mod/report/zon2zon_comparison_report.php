<?php

//

//

require "../../support/inc.all.php";

$title='Zone to Zone Sales Comparison Reports';



do_calander("#f_date");

do_calander("#t_date");


auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_1');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_2');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_3');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_4');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_5');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_6');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_7');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_8');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_9');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_10');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_11');
auto_complete_from_db('zon','ZONE_CODE','concat(ZONE_CODE,"-",ZONE_NAME)','1','zone_id_12');


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

							  													 <td><input name="report" type="radio" class="radio" value="20112501"  checked="checked"/></td>

																					<td><div align="left">ZONE TO ZONE COMPARISON (PRODUCT QUANTITY)</div></td>
																			 </tr>
																			 
																			 <tr>

							  													 <td><input name="report" type="radio" class="radio" value="20112502" /></td>

																					<td><div align="left">ZONE TO ZONE COMPARISON (PRODUCT VALUE)</div></td>
																			 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20112503" /></td>

																							<td><div align="left">ZONE TO ZONE COMPARISON (PRODUCT GROUP QUANTITY) </div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20112504" /></td>

																							<td><div align="left">ZONE TO ZONE COMPARISON (PRODUCT GROUP VALUE) </div></td>
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

                    <td>Zone 1:</td>

                    <td>

                    <input  name="zone_id_1" type="text" id="zone_id_1" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  
				  
				  <tr>

                    <td>Zone 2:</td>

                    <td>

                    <input  name="zone_id_2" type="text" id="zone_id_2" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  
				   <tr>

                    <td>Zone 3:</td>

                    <td>

                    <input  name="zone_id_3" type="text" id="zone_id_3" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Zone 4:</td>

                    <td>

                    <input  name="zone_id_4" type="text" id="zone_id_4" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  
				  <tr>

                    <td>Zone 5:</td>

                    <td>

                    <input  name="zone_id_5" type="text" id="zone_id_5" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Zone 6:</td>

                    <td>

                    <input  name="zone_id_6" type="text" id="zone_id_6" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  
				  <tr>

                    <td>Zone 7:</td>

                    <td>

                    <input  name="zone_id_7" type="text" id="zone_id_7" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Zone 8:</td>

                    <td>

                    <input  name="zone_id_8" type="text" id="zone_id_8" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Zone 9:</td>

                    <td>

                    <input  name="zone_id_9" type="text" id="zone_id_9" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Zone 10:</td>

                    <td>

                    <input  name="zone_id_10" type="text" id="zone_id_10" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Zone 11:</td>

                    <td>

                    <input  name="zone_id_11" type="text" id="zone_id_11" style="width:200px;"/>

                    </td>

                  </tr>
				  
				  <tr>

                    <td>Zone 12:</td>

                    <td>

                    <input  name="zone_id_12" type="text" id="zone_id_12" style="width:200px;"/>

                    </td>

                  </tr>
				  

        
				  
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