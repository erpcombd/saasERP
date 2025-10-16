<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Customer Wise Sales Reports';



do_calander("#f_date");

do_calander("#t_date");

create_combobox('item_id');

create_combobox('dealer_code');

auto_complete_from_db('item_info','concat(item_name)','item_id','product_nature="Salable"','item_search');



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

							  															  <td><input name="report" type="radio" class="radio" value="2006020311" checked="checked"/></td>

																							<td><div align="left">DEALER WISE SALES REPORT DETAILS</div></td>
																					 </tr>	 
																					 
																					 
																					 
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="20060203"  /></td>

																							<td><div align="left">CONSOLIDATED SALES REPORT DEALER WISE</div></td>
																					 </tr>
																					 
																					 
																					 
																					 
																					 

																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="211100705" /></td>

																							<td><div align="left">PRODUCT GROUP WISE SALES REPORT (DEALER WISE)</div></td>
																					 </tr>
																					 
																					 
																					 	
																					 
																					 

																					 

																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" value="220307005" /></td>

																							<td><div align="left">PRODUCT MOVEMENT ANALYSIS (DEALER WISE)</div></td>
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

                      <select name="item_mother_group" id="item_mother_group"  onchange="getData2('item_mother_group_update_ajax.php', 'mother_group', this.value, 
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
					<select name="item_group" id="item_group"  onchange="getData2('item_sub_group_update_ajax.php', 'sub_group', this.value, 
document.getElementById('item_group').value);">

                      <option></option>
                      <? foreign_relation('item_group','group_id','group_name',$item_group, 'product_type="Finish Goods" order by group_for, group_name');?>

                    </select>
					</span></td>
                  </tr>
				  
				  
				  
				  <tr>

                    <td>Item Sub Group: </td>

                    <td>
					<span id="sub_group">

					
					
					 <select multiple name="item_sub_group_in[]" id="item_sub_group_in[]" style="height:120px;"  size='5'>)
                      <?
					  $sql = 'select * from item_sub_group where  fg_sub_group="Yes" order by sub_group_sl';
					  $query = db_query($sql);
					  while($info = mysqli_fetch_object($query)){
					  ?><option value="<?=$info->sub_group_id?>" <?=(@in_array($info->sub_group_id, $_POST['sub_group_id']))?'Selected':'';?>><?=$info->sub_group_name?></option>
					  <?
					  }
					  ?>
                    </select>
					
					
					</span></td>
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

                    <td>Sales Type:</td>

                    <td><select name="do_type" id="do_type"  >

                      <option></option>

                      <? foreign_relation('sale_type','sale_type','sale_type',$do_type,' 1 order by id');?>

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
					
					
					<select name="dealer_code" id="dealer_code">

                      <option></option>

                      <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code, "1" );?>

                    </select>

                    </td>

                  </tr>
				  
				  
				  <tr>

                    <td>Item Search:</td>

                    <td>

                    <input  name="item_search" type="text" id="item_search"  />

                    </td>

                  </tr>
				  
				  
				  
				  <tr>

                    <td>Item ID In:</td>

                    <td>

                    
					
					<textarea id="item_id_in" name="item_id_in"  rows="3"    style="height:50px; width:200px; background:#FFFFFF; color: #000000;"></textarea>	

                    </td>

                  </tr>
				  

					


                  <tr>

                    <td>Zone Name:</td>

                    <td><span id="zone"><select name="zone_id" id="zone_id"  onchange="getData2('ajax_area.php', 'area', this.value,  this.value)">

                      <option></option>

                      <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_id,' 1 order by ZONE_NAME');?>

                    </select></span></td>

                  </tr>


				  
				  
				  <tr>

                    <td>Report Type:</td>

                    <td>
					<select name="report_type" id="report_type"  >
                     	 <option></option>
                    	  <? foreign_relation('report_type','id','report_type',$report_type,' 1 order by id');?>
                    </select></td>

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