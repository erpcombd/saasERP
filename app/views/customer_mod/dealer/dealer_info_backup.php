<?php

session_start();

ob_start();

require "../../support/inc.all.php";



// ::::: Edit This Section ::::: 



$title='ADD Customer Information';			// Page Name and Page Title

$page="dealer_info.php";		// PHP File Name



$table='dealer_info';		// Database Table Name Mainly related to this page

$unique='dealer_code';			// Primary Key of this Database table

$shown='dealer_name_e';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];



$crud->insert();

		$id = $_POST['dealer_code'];

$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

		$id = $_POST['dealer_code'];




		$type=1;

		$msg='Successfully Updated.';

}

//for Delete..................................



if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}

}



if(isset($$unique))

{

$condition=$unique."=".$$unique;

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>

<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>
<style type="text/css">
<!--
.style2 {color: #FF0000}
-->
</style>


<div class="form-container_large">
<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>
									<td><form id="form2" name="form2" method="post" action="">
									  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td style="color:#000000;">Company : </td>
                                          <td><select id="group_for" name="group_for">

					 						 



					  							<? foreign_relation('user_group','id','group_name',$_POST['group_for'],'id="'.$_SESSION['user']['group'].'" ');?>

					 						 </select>
					  						</td>
                                          <td align="left"><label>
                                            <input type="submit" name="show" value="Show" style="width:80px; float:left; height:27px;" />
                                            </label>
                                          </td>
                                        </tr>
                                      </table>
                                                                        </form>
									</td>
								  </tr>


  <tr>
    <td valign="top"><div class="left">
        <table width="40%" border="0" cellspacing="0" cellpadding="0">
       
          <tr>
            <td><div class="tabledesign table table-bordered" style="width:123%!important;" >
			
			
			
			
                <? 	
				
				
				if($_POST['group_for']!="")

				$con .= 'and a.group_for="'.$_POST['group_for'].'"';

				
				 $res='select a.'.$unique.', a.'.$unique.' as ID, a.customer_id as customer_code, a.'.$shown.' as customer_name, a.dealer_name_a as Arabic_name, w.warehouse_name from '.$table.' a, user_group u, warehouse w
				where   a.group_for=u.id and a.depot=w.warehouse_id  and a.group_for="'.$_SESSION['user']['group'].'" and a.depot="'.$_SESSION['user']['depot'].'" '.$con.' order by a.dealer_code asc ';

				echo $crud->link_report($res,$link);?>
              </div>
              <?=paging(500);?></td>
          </tr>
        </table>
      </div></td>
    <td valign="top"><form action="" method="post"  enctype="multipart/form-data" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2"><fieldset>
                      <legend>
                      <?=$title?>
                      </legend>
                      <div> </div>
                      <div class="buttonrow"></div>
                      
					  
					   <div>
                        <label><span class="style2">*</span>Customer Code:</label>
						
						<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
                        <input name="dealer_code" type="hidden" id="dealer_code" tabindex="1" value="<?=$dealer_code?>" readonly>
                        
                        <input name="customer_id" required type="text" id="customer_id" tabindex="1" value="<?=$customer_id?>" >
                      </div> 
					  
                      <div>
                        <label> <span class="style2">*</span>Customer Name :</label>
                        <input name="dealer_name_e" required type="text" id="dealer_name_e" tabindex="2" value="<?=$dealer_name_e?>">
                      </div>
					  
					  <div>
                        <label> <span class="style2">*</span>Arabic name :</label>
                        <input name="dealer_name_a" type="text" id="dealer_name_a" tabindex="2" value="<?=$dealer_name_a?>">
                      </div>
					  
					  
                      <div>
                      <label>Propritor's name:</label>
                      <input name="propritor_name_e" type="text" id="propritor_name_e" tabindex="2" value="<?=$propritor_name_e?>">
                      </div>
                      <div></div>
                      <?php /*?><div>
                        <label>Dealer Type:</label>
                        <select name="dealer_type"  id="dealer_type" style="width:150px;"  tabindex="3" required >
                          <option <?=($dealer_type=='Advance')?'selected':'';?>>Advance</option>
                          <option <?=($dealer_type=='Regular')?'selected':'';?>>Regular</option>
                       	 <option <?=($dealer_type=='MAT')?'selected':'';?>>MAT</option>
                        </select>
                      </div><?php */?>
					  
					  
					    <div>
                      <label>Salesman :</label>
                      <select name="se_id"  id="se_id" style="width:200px;" tabindex="7">
					  
					  <option></option>

                      <? foreign_relation('personnel_basic_info','PBI_ID',
					  'concat(PBI_NAME, " - [ID No: ", MEMBER_ID,"]")',$se_id,'
					  PBI_ORG="'.$_SESSION['user']['group'].'" order by PBI_NAME');?>
                    </select>
                      </div>
					  
					  
					  
					    <div>
                      <label><span class="style2">*</span>Region :</label>
                      <select name="region_code" required id="region_code" style="width:200px;" tabindex="7">
					  
					  <option></option>

                      <? foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$region_code,'
					  group_for="'.$_SESSION['user']['group'].'"');?>
                    </select>
                      </div>
					  
					  
                      <div>
                        <label> Address:</label>
                        <input name="address_e" type="text" id="dealer_name_e" tabindex="4" value="<?=$address_e?>">
                      </div>
                      <!--<div>
                        <label> National ID:</label>
                        <input name="national_id" type="text" id="national_id" tabindex="6" value="<?=$national_id?>">
                      </div>-->
					  
					  
					  <!--<div>
                      <label><span class="style2">*</span>Customer Type :</label>
                      <select name="dealer_type" required id="dealer_type" style="width:200px;" tabindex="7">
					  
					  <option></option>

                      <? foreign_relation('dealer_type','id','dealer_type',$dealer_type,'
					  group_for="'.$_SESSION['user']['group'].'"');?>
                    </select>
                      </div>-->
					  
					  <div>
                      <label><span class="style2">*</span>Company :</label>
                      <select name="group_for" required id="group_for" style="width:200px;" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>
                      </div>
					  
					  <div>
                      <label><span class="style2">*</span>Warehouse :</label>
                      <select name="depot" required id="depot" style="width:200px;" tabindex="7">

                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,'
					  warehouse_id="'.$_SESSION['user']['depot'].'"');?>
                    </select>
                      </div>
					  
					  
                      <div>
                      <label>VAT Type :</label>
                      <select name="vat_type" required id="vat_type" style="width:200px;" tabindex="7">
					  <option></option>

                      <? foreign_relation('vat_type','id','vat_type',$vat_type,' 1');?>
                    </select>
                      </div>
					  
					  <div>
                        <label> <span class="style2">*</span>VAT No:</label>
                        <input name="vat" type="text" id="vat" tabindex="8" value="<?=$vat?>">
                      </div>
					  
					  <div>
                        <label> Credit Limit:</label>
                        <input name="credit_limit" type="text" id="credit_limit" tabindex="8" value="<?=$credit_limit?>">
                      </div>
					  
					  
                      <div>
                        <label> Mobile No:</label>
                        <input name="mobile_no" type="text" id="mobile_no" tabindex="8" value="<?=$mobile_no?>" />
                      </div>
					  
					  <div>
                        <label> E-mail:</label>
                        <input name="email" type="text" id="email" tabindex="8" value="<?=$email?>">
						
						<input name="account_code" type="hidden"  id="account_code" tabindex="10" value="1002000100000000" />
						
						
						 <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_SESSION['user']['id']?>" />
                      </div>
					  
                      <div>
                        <label> CR No:</label>
                        <input name="cr_no" type="text" id="cr_no" tabindex="9" value="<?=$cr_no?>">
                      </div>
					  <div>
                        <label> CR Upload:</label>
                        <input style="padding:5px 5px 7px 5px;" name="cr_upload" type="file" id="cr_upload" value="<?=$cr_upload?>" />
                      </div>
					  
					  
                      <div>
                        <label> Latitude:</label>
                        <input name="add_lat" type="text" id="add_lat" tabindex="9" value="<?=$add_lat?>">
                      </div>
					  
					  
                      <div>
                        <label> Longitude:</label>
                        <input name="add_lon" type="text" id="add_lon" tabindex="9" value="<?=$add_lon?>">
                      </div>
					  
					  <div>
                        <iframe 
  width="auto" 
  height="auto" 
  frameborder="0" 
  scrolling="no" 
  marginheight="0" 
  marginwidth="0" 
  src="https://maps.google.com/maps?q=<?=$add_lat?>,<?=$add_lon?>&hl=en&z=12&amp;output=embed">
 </iframe>
                      </div>
					  
                      
					  
					  <!--<div>
                        <label> CR File:</label>
                        <a href="../../images/cr_pic/<?=$dealer_code?>.jpg" target="_blank"><img src="../../images/cr_pic/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="Propiter Photo" /></a>
                      </div>-->
					  
					  
					  
                     <?php /*?> <div>
                      <label>Area</label>
                      <select name="area_code" id="area_code" style="width:200px;" tabindex="11">

                      <? 

					  $sql = 'select a.AREA_CODE,a.AREA_NAME,z.ZONE_NAME,b.BRANCH_NAME from area a,zon z, branch b where a.ZONE_ID = z.ZONE_CODE and z.REGION_ID = b.BRANCH_ID order by a.AREA_NAME';

					  $res=db_query($sql);

					  echo '<option></option>';

					  while($d = mysqli_fetch_row($res)){

if($area_code==$d[0])

echo '<option value="'.$d[0].'" selected>'.$d[1].' [Zone: '.$d[2].'] [Region: '.$d[3].']</option>';

else

echo '<option value="'.$d[0].'">'.$d[1].' [Zone: '.$d[2].'] [Region: '.$d[3].']</option>';

					  }

					  ?>
                      </select>
                      </div>
					  
					  
                      <div>
                      <label>Zone:</label>
                      <select name="zone_code" required id="zone_code" style="width:200px;" tabindex="7">

                   	   <? foreign_relation('zon','ZONE_CODE','ZONE_NAME',$zone_code,'1');?>
                    </select>
                      </div>
					  
					  
					  
                      <div>
					  
                      <label>Transport Charge</label></label>
                      <input name="transport_charge" type="text" id="transport_charge" tabindex="8" value="<?=$transport_charge?>">
                      </div>
					  
					  
                      <div></div>
<div>
  <label>Status:</label>
                        <select name="canceled" id="canceled"  style="width:150px;" tabindex="12">

                      <option <?=($canceled=='Yes')?'Selected':'';?>>Yes</option>

                      <option <?=($canceled=='No')?'Selected':'';?> >No</option>
                    </select>
                    </div>
                      <div></div>
                    </fieldset></td>
                
                </tr><?php */?>
              <!--  <tr>
                <td colspan="2"><a href="../../pp_pic/pp/<?=$dealer_code?>.jpg" target="_blank"><img src="../../pp_pic/pp/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="Propiter Photo" /></a></td>
                        </tr>
						
						<tr>
                <td colspan="2"><a href="../../pp_pic/pp/<?=$dealer_code?>.jpg" target="_blank"><img src="../../pp_pic/pp/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="Propiter Photo" /></a></td>
                        </tr>
						
                        <tr>
                        <td><span class="oe_form_group_cell oe_form_group_cell_label"><label>Propritor Photo:</label></span></td>
                        <td> <input style="padding:5px 5px 7px 5px;" name="pp" type="file" id="pp" value="<?=$pp?>" /> </td>
                        </tr>-->
                      <?php /*?> <tr>
                        <td colspan="3"><a href="../../np_pic/np/<?=$dealer_code?>.jpg" target="_blank"><img src="../../np_pic/np/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="nominee photo" /></a></td>
                  </tr>
                        <tr>
                        <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><label>Nominee Photo:</label></span></td>
                        <td> <input style="padding:5px 5px 7px 5px;" name="np" type="file" id="np" value="<?=$np?>" /> </td>
                        </tr>
                        <tr>
                        <td colspan="3"><a href="../../spp_pic/spp/<?=$dealer_code?>.jpg" target="_blank"><img src="../../spp_pic/spp/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="vendor Trade lisence" /></a></td>
                        </tr>
                        <tr>
                        <td><span class="oe_form_group_cell oe_form_group_cell_label"><label>Propritor's Signature:</label></span></td>
                        <td> <input style="padding:5px 5px 7px 5px;" name="spp" type="file" id="spp" value="<?=$spp?>" /> </td>
                </tr>
                <tr>
                        <td colspan="3"><a href="../../nsp_pic/nsp/<?=$dealer_code?>.jpg" target="_blank"><img src="../../nsp_pic/nsp/<?=$dealer_code?>.jpg" width="100px" height="100px" alt="vendor Trade lisence" /></a></td>
                        </tr>
                        <tr>
                        <td><label>Nominee's Signature</label></td>
                        <td> <input style="padding:5px 5px 7px 5px;" name="nsp" type="file" id="nsp" value="<?=$nsp?>" /> </td>
                </tr><?php */?>
              </table>
			  
			  
			  
			  
			  
			  
			  
			  </td>
          </tr>
          <tr>
            <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="Save" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="Update" class="btn" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" />
                    </div></td>
                  <td>
                  <!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->
                    </td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
</div>
<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>
