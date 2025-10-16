<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Product Wise Sales Reports';



do_calander("#f_date");

do_calander("#t_date");

create_combobox('item_id');


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

                           
							 
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="210501001" checked="checked" /></td>

																							<td><div align="left">PRODUCT SIZE WISE PRODUCTION REPORT</div></td>
																					 </tr>
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="210501002" /></td>

																							<td><div align="left">PRODUCT GROUP WISE PRODUCTION REPORT</div></td>
																					 </tr>
																					 
																					 <!--<tr>

							  															  <td><input name="report" type="radio" class="radio" value="210501003" /></td>

																							<td><div align="left">MR CONSUMPTION REPORT</div></td>
																					 </tr>-->
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="210501004" /></td>

																							<td><div align="left">MONTHLY PRODUCT SIZE WISE PRODUCTION REPORT </div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="210501005" /></td>

																							<td><div align="left">MONTHLY PRODUCT GROUP WISE PRODUCTION REPORT</div></td>
																					 </tr>
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="210501006" /></td>

																							<td><div align="left">TWISTING WAGES REPORT</div></td>
																					 </tr>
	
																					
																					 
																					 
																					 
																					 
																					



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
					<select name="item_sub_group" id="item_sub_group"  onchange="getData2('item_info_find_ajax.php', 'find_item', this.value, 
document.getElementById('item_sub_group').value);">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, "fg_sub_group='Yes' order by sub_group_sl" );?>

                    </select></span></td>
                  </tr>
				  
				  
				  <tr>

                    <td>Item Name: </td>

                    <td>
					<span id="find_item">
					<select name="item_id" id="item_id">

                      <option></option>

                      <? foreign_relation('item_info i, item_sub_group s','i.item_id','i.item_name',$item_id, "i.product_nature='Salable' and s.fg_sub_group='Yes' and i.sub_group_id=s.sub_group_id order by s.sub_group_sl,  i.item_name ");?>

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

                    <td>From: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

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