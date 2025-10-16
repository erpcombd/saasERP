<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='BIN Card Reports';

do_calander("#f_date");
do_calander("#t_date");
$tr_type="Show";
$tr_from="Warehouse";
auto_complete_from_db('item_info','concat(finish_goods_code,"#>",item_name,"#>",item_id)','item_id','1 and group_for="'.$_SESSION['user']['group'].'"','item_id');

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
    <form class="n-form1 fo-width pt-4" action="product_transection_report_master.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
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
				
				
				
				
               <!-- <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="33" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        BIN Card Detail (33)
                    </label>
                </div>
				
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="34"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        BIN Card Detail with Rate (34)
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="235"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        BIN Card Detail with Rate (235)
                    </label>
                </div>-->
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn1" value="5" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn1">
                        BIN Card(Finish Goods)(5)
                    </label>
                </div>-->
<!--				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn2" value="1"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn2">
                        BIN Card (Posting Wise)(1)
                    </label>
                </div>-->
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn3" value="4"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn3">
                        BIN Card With SR NO(4)
                    </label>
                </div>-->
				<!--<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn4" value="2"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn4">
                        Product Transection Report Summary(2)
                    </label>
                </div>-->
               

            </div>

            <div class="col-sm-7">
                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Name:</label>
                    <div class="col-sm-8 p-0">
                        <!--<select name="item_id" id="item_id" class="form-control">
                        	<option></option>
                      
							<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                   		 </select>-->
						 
						 <input name="item_id" type="text" id="item_id" class="form-control" />
                    </div>
                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Warehouse:</label>
                    <div class="col-sm-8 p-0">
                        <select name="warehouse_id" id="warehouse_id" class="form-control">
                        	<option></option>
                      
							<? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id);?>
                   		 </select>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        	<input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control">
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control">

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






<?php /*?><form action="product_transection_report_master.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td><input name="report" type="radio" class="radio" checked="checked" value="3"/></td>
                                <td><div align="left">BIN CARD DETAIL (Date Wise)(3)</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="5"/></td>
							    <td><div align="left">BIN CARD(Finish Goods)(5)</div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1"/></td>
                                <td><div align="left">BIN CARD (Posting Wise)(1)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="4"/></td>
                                <td><div align="left">BIN CARD WITH SR NO(4)</div></td>
                              </tr>
                              
                              
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Product Transection Report Summary(2)</div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>Product Name: </td>
                    <td><input type="text" name="item" id="item" style="width:250px" required="required" />
                    </td>
                  </tr>
                  <tr>
                    <td>From: </td>
                    <td><input  name="f_date" type="text" id="f_date" required="required" value="<?=date('Y-m-01')?>"/></td>
                  </tr>
                  <tr>
                    <td>To: </td>
                    <td><input  name="t_date" type="text" id="t_date" required="required" value="<?=date('Y-m-d')?>"/></td>
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
              <td><input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form><?php */?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>