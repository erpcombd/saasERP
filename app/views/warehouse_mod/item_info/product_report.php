<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Configuration Reports';
$tr_type="Show";
do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');
$tr_from="Warehouse";

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// Build the full URL
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


$trimmed_path = str_replace("https://saaserp.ezzy-erp.com/app/views/", "", $url);
$parts = explode('/', $trimmed_path);

 $mod_name = $parts[0]; 
 $folder_name = $parts[1];
 $page_name = $parts[2]; 


	 $res2 ='SELECT  r.folder_name, r.report_no, r.feature_id,r.page_id, p.id AS page_id, f.id AS feature_id, f.feature_name,  m.id AS module_id,  m.module_name
			FROM  user_page_manage p JOIN  user_feature_manage f ON p.feature_id = f.id JOIN  user_module_manage m ON f.module_id = m.id, report_manage r
			WHERE  m.module_file="'.$mod_name.'" and p.folder_name="'.$folder_name.'" and p.page_link="'.$page_name .'" and r.folder_name="'.$folder_name.'" and r.feature_id=f.id and r.page_id=p.id';

								$query=db_query($res2);
								
								While($row=mysqli_fetch_object($query)){
									$page_file[$row->page_no] = $row->page_id;
								}

?>

<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1" style="width:90%">
        <div class="row m-0 p-0">
            <div class="col-sm-6">
                <div align="left">Select Report </div>
				
				
				
				
				<?
					
							 //$res ='select report_name,page_id,report_no,status from report_manage where page_id="'.$page_file[$row->page_id].'" and status="Yes"';
							 
							 $res ='select r.id,r.report_name,r.page_id,r.report_no,r.status,u.user_id,a.user_id,a.report_id 
							 from report_manage r, user_activity_management u,user_report_access a 
							 where r.page_id="'.$page_file[$row->page_id].'" and a.report_id=r.id and a.user_id=u.user_id and u.user_id="'.$_SESSION['user']['id'].'" and a.access="1" and r.status="Yes"';
									
									$query=db_query($res);
								While($row=mysqli_fetch_object($query)){
								
								?>
               
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn1" value="<?=$row->report_no?>" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn1">
                         <?=$row->report_name?> (<?=$row->report_no?>)
                    </label>
                </div>
<? } ?>
				
				
				
				

                <!--<div class="form-check">
					<input name="report" type="radio" class="radio1" id="report2-btn"  value="888811"  tabindex="2"/>
                    <label class="form-check-label p-0" for="report2-btn">
                        Product Information Report (888811)
                    </label>
                </div>
				
				
				<div class="form-check">
					<input name="report" type="radio" class="radio1" id="report2-btn"  value="888823"  tabindex="2"/>
                    <label class="form-check-label p-0" for="report2-btn">
                        Product Stock Alert Report (888823)
                    </label>
                </div>
				
				<div class="form-check">
					<input name="report" type="radio" class="radio1" id="report3-btn"  value="2019"  tabindex="2"/>
                    <label class="form-check-label p-0" for="report3-btn">
                        Barcode Print Report (2019)
                    </label>
                </div>
				
				<div class="form-check">
					<input name="report" type="radio" class="radio1" id="report3-btn"  value="2025420"  tabindex="2"/>
                    <label class="form-check-label p-0" for="report3-btn">
                        Product Location Report (2025420)
                    </label>
                </div>-->

            </div>

            <div class="col-sm-6">
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Form Date:</label>
                    <div class="col-sm-8 p-0">
                        <input class="m-0" name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/>
                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">
                        <input  class="m-0" name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        <select name="item_id" id="item_id">
                          <option></option>
                          <?=foreign_relation('item_info','item_id','item_name','1');?>
                      </select>
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Group</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">

                          <select name="group_id" id="group_id" tabindex="3" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value,document.getElementById('group_id').value);">

                              <option></option>
                              <? foreign_relation('item_group','group_id','group_name',$group_id,' 1');?>

                          </select>

                        </span>


                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Sub Group</label>
                    <div class="col-sm-8 p-0">
                        <span class="oe_form_group_cell">

                              <select name="item_sub_group" tabindex="4">

                                <option></option>

                                <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, '1');?>

                              </select>


                        </span>

                    </div>
                </div>

 <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Company</label>
                    <div class="col-sm-8 p-0">
                        <span class="oe_form_group_cell">

                              <select name="group_for" id="group_for" tabindex="4">

                                <option></option>

                                <? user_company_access($group_for);?>

                              </select>


                        </span>

                    </div>
                </div>


            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
        </div>
    </form>
</div>




















<?php /*?><form action="master_report.php" method="post" name="form1" target="_blank" id="form1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="box4">
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
                              <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="1" tabindex="1"/></td>
                                <td><div align="left">Finish Good Product List</div></td>
                              </tr>-->
							  
							  
							<!--  <tr>
                                <td><input name="report" type="radio" class="radio" value="888" tabindex="2"/></td>
                                <td><div align="left">Product Information (Rate Changable)</div></td>
                              </tr>-->
							  
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="8888" checked="checked" tabindex="1"/></td>
                                <td><div align="left">Product Price Setup Information</div></td>
								
                              </tr>
							  <tr>
							  
							  <td><input name="report" type="radio" class="radio" value="888833"  tabindex="2"/></td>
                                <td><div align="left">Product Information Report</div></td>
							  </tr>
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="118888"  tabindex="2"/></td>
                                <td><div align="left">Product Information (MINWAL)</div></td>
                              </tr>-->
							  
							  
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="888811" tabindex="2"/></td>
                                <td><div align="left">Turky Sajjada & Swadie Item</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="888822" tabindex="2"/></td>
                                <td><div align="left">Zadi Item Information</div></td>
                              </tr>
							  
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="888833" tabindex="2"/></td>
                                <td><div align="left">Minwal Carpet Item List</div></td>
                              </tr>-->
							  
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="888898" tabindex="2"/></td>
                                <td><div align="left">Warehouse Report</div></td>
                              </tr>-->
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="8889" tabindex="2"/></td>
                                <td><div align="left">Product Rate Change Information</div></td>
                              </tr>-->
							  
							  
							  
							 <!-- <tr>
                                <td><input name="report" type="radio" class="radio" value="8890" tabindex="2"/></td>
                                <td><div align="left">Area and Transport Changes Information</div></td>
                              </tr>-->
							  
							  
							  <!--<tr>
                                <td><input name="report" type="radio" class="radio" value="889" tabindex="2"/></td>
                                <td><div align="left">Product Mesh Size Information </div></td>
                              </tr>-->
							  
		              
							  
							  <!--<tr>


                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>


                                <td width="94%"><div align="left">Product List Details</div></td>


                              </tr>


                              <tr>


                                <td width="6%"><input name="report" type="radio" class="radio" value="3" /></td>


                                <td width="94%"><div align="left">Price List Details</div></td>


                              </tr>-->
                            </table></td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  
                  <!--<tr>
                    <td>Product Nature :</td>
                    <td><span id="branch" class="oe_form_group_cell">
                      <select name="product_nature" id="product_nature">
                        <option></option>
                        <option value="Salable">Salable</option>
                        <option value="Purchasable">Purchasable</option>
                        <option value="Both">Both</option>
                      </select>
                      </span></td>
                  </tr>-->
				  
				  <tr>
                    <td>From :</td>
                    <td><span class="oe_form_group_cell">
                      <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" style="width:250px"/>
                      </span></td>
                  </tr>
				  
				  <tr>
                    <td>To :</td>
                    <td><span class="oe_form_group_cell">
                      <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" style="width:250px"/>
                      </span></td>
                  </tr>
				  
				  
				  
				   <tr>
                    <td>Item Name :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="item_id" id="item_id"  style="width:250px;">
					  	<option></option>
						<?=foreign_relation('item_info','item_id','item_name','1');?>
					  </select>
                      </span>
                    </td>
                  </tr>
				  
				  
				  <tr>

                    <td>Product Group :</td>

                    <td>
                        <span class="oe_form_group_cell">

                      <select name="group_id" id="group_id"  style="width:250px" tabindex="3" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value, 

document.getElementById('group_id').value);">

                        <option></option>

                        <? foreign_relation('item_group','group_id','group_name',$group_id,' 1');?>

                      </select>

                      </span>
                    </td>

                  </tr>
				  
				  
				  <tr>

                    <td>Product Sub Group :</td>

                    <td>
                        <span class="oe_form_group_cell">
					
					<span id="item_sub_group">

                      <select name="item_sub_group" id="item_sub_group" tabindex="4"  style="width:250px">

                        <option></option>

                        <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, '1');?>

                      </select>

                      </span>
                        </span>
                    </td>

                  </tr>
				  
				  <!--<tr>
                    <td>Concern Name :</td>
                    <td><span class="oe_form_group_cell">
                      <select name="group_for" id="group_for" tabindex="5">
                        <option></option>
                        <? foreign_relation('user_group','id','group_name',$group_for);?>
                      </select>
                      </span></td>
                  </tr>-->
          
				  
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
              <td><input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" /></td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
</form><?php */?>
<?


require_once SERVER_CORE."routing/layout.bottom.php";

?>
