<?php

//

//

require "../../support/inc.all.php";

$title='Advanced Reports';
create_combobox('item_id');
create_combobox('dealer_code');



do_calander("#f_date");

do_calander("#t_date");



//auto_complete_from_db('dealer_info','concat(dealer_code,"-",dealer_name_e)','dealer_code','canceled="Yes"','dealer_code');

//auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code');

//auto_complete_from_db('dealer_info','dealer_code','concat(dealer_code,"-",dealer_name_e)','1','dealer_code_to');

//auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" and finish_goods_code>0 and finish_goods_code<5000','item_id');?>




<style>

/*.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 220px;
    height: 40px;
	float:left;
    border-radius: 0px !important;
}



</style>


<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>


      <td><div class="box4" style="width:950px;">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td width="47%"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>
                              </tr>

                         
																					 
																					 
																					 
																					 
																					 
																					 
																					 <!--<tr>

							  															  <td><input name="report" type="radio" class="radio" value="250421001" checked="checked" /></td>

																							<td><div align="left">PRODUCTION DETAILS REPORT</div></td>
																					 </tr>-->
																					 
																					 
																					 
																					
																					 
																					 
																					 
																					 <tr>

							  															  <td><input name="report" type="radio" class="radio" checked="checked" value="250421003"  /></td>

																							<td><div align="left">SCANE WISE SALES ORDER</div></td>
																					 </tr>
																					 
																					 
																					
																					 
																					
																					 
																					
																					 
																					 
																					
																					 
																					


                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td width="53%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

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
				  
				 <?php /*?> <tr>

                    <td width="44%">Item Mother Group:</td>

                    <td width="56%"><span class="oe_form_group_cell">

                      <select name="item_mother_group" id="item_mother_group"  onchange="getData2('item_mother_group_ajax.php', 'mother_group', this.value, 
document.getElementById('item_mother_group').value);" >

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
document.getElementById('item_group').value);"  >

                      <option></option>
                      <? foreign_relation('item_group','group_id','group_name',$item_group, 'product_type="Finish Goods"');?>

                    </select>
					</span></td>
                  </tr>
				  
				  
				  
				  <tr>

                    <td>Item Sub Group: </td>

                    <td>
					<span id="sub_group">
					<select name="item_sub_group" id="item_sub_group" >

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, "fg_sub_group='Yes'");?>

                    </select></span></td>
                  </tr><?php */?>
				  
				  
				  <?php /*?><tr>

                    <td>Item Name: </td>

                    <td>
					
					<select name="item_id" id="item_id" style="width:220px">

                      <option></option>

                      <? foreign_relation('item_info','item_id','item_name',$item_id, "product_nature='Salable' ");?>

                    </select></td>
                  </tr><?php */?>
				  
				  
				  
				  
				  <!--<tr>

                    <td>Return Type:</td>

                    <td><select name="return_type" id="return_type"  >

                      <option></option>

                      <? foreign_relation('sale_return_type','id','return_type',$return_type,' 1 order by return_type');?>

                    </select></td>

                  </tr>-->
				  
				  
				  <tr>
                    <td>Dealer:</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select class="form-control" name="dealer_code" id="dealer_code" >
                        <option></option>
                        <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$dealer_code,'1');?>
                      </select>
                      </span></td>
                  </tr>
				  

                  

                  <tr>

                    <td>Sale Date: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"  style="width:220px"/></td>

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
				  
				  
				  
				  <?php /*?><tr>
                    <td>Warehouse:</td>
                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                      <select class="form-control" name="warehouse_id" id="warehouse_id" >
                        <option></option>
                        <? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'use_type="WH"');?>
                      </select>
                      </span></td>
                  </tr><?php */?>

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