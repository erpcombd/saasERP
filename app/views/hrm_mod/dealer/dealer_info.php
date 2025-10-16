<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

//::::: Edit This Section::::: 
$title='Dealer Information';		// Page Name and Page Title
$page="dealer_info.php";		// PHP File Name
$input_page="dealer_info.php";
$root='dealer';

$table='dealer_info';		// Database Table Name Mainly related to this page
$unique='dealer_code';			// Primary Key of this Database table
$shown='dealer_name_e';	

do_calander('#app_date');
do_calander('#cancel_date');
//::::: End Edit Section:::::


$crud      =new crud($table);


$required_id=find_a_field($table,$unique,$unique.'='.$_SESSION['dealer_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;

if(isset($_POST[$shown]))
{	if(isset($_POST['insert']))
		{		
				$id = $_POST['dealer_code'];
				
				$path='../../d_pic/np';
				if($_FILES['np']['name']!='')
				$_POST['np']=image_upload_on_id($path,$_FILES['np'],$id);
				
				$path='../../d_pic/pp';
				if($_FILES['pp']['name']!='')
				$_POST['pp']=image_upload_on_id($path,$_FILES['pp'],$id);
				
				$path='../../d_pic/sp';
				if($_FILES['sp']['name']!='')
				$_POST['sp']=image_upload_on_id($path,$_FILES['sp'],$id);
				
				$path='../../d_pic/sa';
				if($_FILES['sa']['name']!='')
				$_POST['sa']=image_upload_on_id($path,$_FILES['sa'],$id);
				
				$path='../../d_pic/sp';
				if($_FILES['sp']['name']!='')
				$_POST['sp']=image_upload_on_id($path,$_FILES['sp'],$id);
				
				$crud->insert();
				
				$type=1;
				$msg='New Entry Successfully Inserted.';
				unset($_POST);
				unset($$unique);
$required_id=find_a_field($table,$unique,$unique.'='.$_SESSION['dealer_selected']);
if($required_id>0)
$$unique = $_GET[$unique] = $required_id;
		}
	//for Modify..................................
	if(isset($_POST['update']))
	{			
				$path='../../d_pic/np';
				if($_FILES['np']['name']!='')
				$_POST['np']=image_upload_on_id($path,$_FILES['np'],$$unique);
				
				$path='../../d_pic/pp';
				if($_FILES['pp']['name']!='')
				$_POST['pp']=image_upload_on_id($path,$_FILES['pp'],$$unique);
				
				$path='../../d_pic/sp';
				if($_FILES['sp']['name']!='')
				$_POST['sp']=image_upload_on_id($path,$_FILES['sp'],$$unique);
				
				$path='../../d_pic/sa';
				if($_FILES['sa']['name']!='')
				$_POST['sa']=image_upload_on_id($path,$_FILES['sa'],$$unique);
				
				$path='../../d_pic/sn';
				if($_FILES['sn']['name']!='')
				$_POST['sn']=image_upload_on_id($path,$_FILES['sn'],$$unique);
				$crud->update($unique);
				$type=1;
	}
}

if(isset($$unique))
{
$condition=$unique."=".$$unique;
$data=db_fetch_object($table,$condition);
while (list($key, $value)=@each($data))
{ $$key=$value;}
}

if($_REQUEST['dealer_selected']>0 && $required_id<1)
$$unique=$_REQUEST['dealer_selected'];
?>
<script type="text/javascript"> function DoNav(lk){
	return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)
	}
    function add_date(cd)
	{
		var arr=cd.split('-');
		var mon = (arr[1]*1)+6;
		var day = (arr[2]*1);
		var yr =  (arr[0]*1);
		if(mon>12)
		{
			mon = mon-12;
			yr  = yr+1;
		}
		var con_date = yr+'-'+mon+'-'+day;
		document.getElementById('PBI_DOC').value=con_date;
	}
    </script>

<form action="" method="post" enctype="multipart/form-data">
<div class="oe_view_manager oe_view_manager_current">
        
    <? include('../../common/title_bar_d.php');?>
        <div class="oe_view_manager_body">
            
                <div  class="oe_view_manager_view_list"></div>
            
                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
        <div class="oe_form_buttons"></div>
        <div class="oe_form_sidebar"></div>
        <div class="oe_form_pager"></div>
        <div class="oe_form_container"><div class="oe_form">
          <div class="">
                      <? include('../common/input_bar.php');?>
                      <div class="oe_form_sheetbg">
                        <div class="oe_form_sheet oe_form_sheet_width">
        <h1><label for="oe-field-input-27" title="" class=" oe_form_label oe_align_right">
        <a href="home2.php" rel = "gb_page_center[940, 600]"><?=$title?></a>
    </label>
          </h1><table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
            <tbody><tr class="oe_form_group_row">
            <td colspan="1" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;" width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="oe_form_group ">
              <tbody>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Dealer Code:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="dealer_code" type="text" id="dealer_code" value="<?=$$unique?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell oe_form_group_cell_label"><label style="min-width:100px;">Dealer Name(E):</label></span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="dealer_name_e" type="text" id="dealer_name_e" value="<?=$dealer_name_e?>" />
                  </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell oe_form_group_cell_label"><label style="min-width:100px;">Dealer Name(B):</label>	</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="dealer_name_b" type="text" id="dealer_name_b" value="<?=$dealer_name_b?>" />
                  </span></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label"><label style="min-width:100px;">&nbsp; Dealer Type:</label></td>
                  <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                  <select name="dealer_type" id="dealer_type" style="width:150px;">
                  <option <?=($dealer_type=='Distributor')?'selected':'';?>>Distributor</option>
				  <option <?=($dealer_type=='SuperShop')?'selected':'';?>>SuperShop</option>
                  <option <?=($dealer_type=='Corporate')?'selected':'';?>>Corporate</option>
                  <option <?=($dealer_type=='TradeFair')?'selected':'';?>>TradeFair</option>
                  <option <?=($dealer_type=='BulkBuyer')?'selected':'';?>>BulkBuyer</option>
                  </select>                  </td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell oe_form_group_cell_label">Propritor Name(E):</span></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><input style="width:150px;" name="propritor_name_e" type="text" id="propritor_name_e" value="<?=$propritor_name_e?>" /></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell oe_form_group_cell_label">Propritor Name(B):</span></td>
                  <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><input style="width:150px;" name="propritor_name_b" type="text" id="propritor_name_b" value="<?=$propritor_name_b?>" /></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Area: </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"> 
                    <select name="area_code" id="area_code" style="width:150px;">
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
                      </select>                </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell oe_form_group_cell_label">Address(E):</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="address_e" type="text" id="address_e" value="<?=$address_e?>" />
                  </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell oe_form_group_cell_label">Address(B):</span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="address_b" type="text" id="address_b" value="<?=$address_b?>" />
                  </span></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp; Product Group:</td>
                  <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><select name="product_group" id="product_group" style="width:150px;">
  <option><?=$product_group?></option>
  <option>A</option>
  <option>B</option>
  <option>C</option>
  <option>D</option>
  <option>M</option>
</select></td>
                  <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell oe_form_group_cell_label">National ID:</span></td>
                  <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="national_id" type="text" id="national_id" value="<?=$national_id?>" />
                  </span></td>
                  <td align="left" bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Depot Name:</td>
                  <td align="left" bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <select name="depot" id="depot" style="width:150px;">
                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$depot,' warehouse_type != "Purchase"');?>
                    </select>
                    </span></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Mobile No:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><input style="width:150px;" name="mobile_no" type="text" id="mobile_no" value="<?=$mobile_no?>" /></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">App Letter Issued:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <select name="app_letter_issued" id="app_letter_issued" style="width:150px;">
                    <option><?=$app_letter_issued?></option>
                    <option>No</option>
                    <option>Yes</option>
                    </select>
                  </span></td>
                  <td align="center" bgcolor="#99CC66" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><strong>Logistics Name</strong></td>
                  <td align="center" bgcolor="#99CC66" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><strong>Quantity</strong></td>
                  </tr>
                <tr bgcolor="#FFFFFF" class="oe_form_group_row">
                  <td colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Tel No:</td>
                  <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><input style="width:150px;" name="tel_no" type="text" id="tel_no" value="<?=$tel_no?>" /></td>
                  <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">App Date:</td>
                  <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="app_date" type="text" id="app_date" value="<?=$app_date?>" />
                  </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Rickshaw Van</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="rickshaw_van" type="text" id="rickshaw_van" value="<?=$rickshaw_van?>" />
                  </span></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Division:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                  <span id="division">
                  <select name="division_code" id="division_code" style="width:150px;"  onchange="getData2('ajax_district.php', 'district', this.value,  this.value)">
                  <? foreign_relation('location','l_id','l_name',$division_code,'l_type="DV" order by l_name');?>
                  </select>
                  </span>                  </td>
                  <td class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Passport No:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="passport_no" type="text" id="passport_no" value="<?=$passport_no?>" />
                  </span></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Motor Van</td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="motor_van" type="text" id="motor_van" value="<?=$motor_van?>" />
                  </span></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#FFFFFF" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;District:</td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                  <span id="district">
                  <select name="district_code" id="district_code" style="width:150px;" onchange="getData2('ajax_thana.php', 'thana', this.value,  this.value)">
                  <? foreign_relation('location','l_id','l_name',$district_code,'l_type="DT" order by l_name');?>
                  </select>
                  </span>                  </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell oe_form_group_cell_label">Security Deposit:</span></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="security_deposit" type="text" id="security_deposit" value="<?=$security_deposit?>" />
                    </span></td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Tempoo</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="tempoo" type="text" id="tempoo" value="<?=$tempoo?>" />
                    </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Thana:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <span id="thana">
                      <select name="thana_code" id="thana_code" style="width:150px;">
                        <? foreign_relation('location','l_id','l_name',$thana_code,"l_type='TH' order by l_name");?>
                        </select>
                      </span>                    </td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Credit Limit:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="credit_limit" type="text" id="credit_limit" value="<?=$credit_limit?>" />
                    </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Boat</td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="boat" type="text" id="PBI_NAME17" value="<?=$boat?>" />
                    </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;&nbsp;Status:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <select name="canceled" id="canceled"  style="width:150px;">
                      <option <?=($canceled=='Yes')?'Selected':'';?>>Yes</option>
                      <option <?=($canceled=='No')?'Selected':'';?> >No</option>
                    </select>
                  </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Status Date:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="cancel_date" type="text" id="cancel_date" value="<?=$cancel_date?>" />
                  </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Others</td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input style="width:150px;" name="others" type="text" id="others" value="<?=$others?>" />
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="3" align="center" bgcolor="#FF0000" class="oe_form_group_cell oe_form_group_cell_label">Account Code : 
                    <input type="text" name="account_code" id="account_code" value="<?=$account_code?>" /></td>
                  <td align="center" bgcolor="#FF0000" class="oe_form_group_cell oe_form_group_cell_label">Under Company: </td>
                  <td colspan="2" align="center" bgcolor="#FF0000" class="oe_form_group_cell oe_form_group_cell_label"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                    <? if($group_for>0) $group_for=$group_for; else $group_for=$_SESSION['user']['group'];?>
                    <select id="group_for" name="group_for">
                    <? foreign_relation('user_group','id','group_name',$group_for,' 1 order by group_name');?>
                    </select>
                  </span></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#FFFFFF" colspan="6" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#FFFFFF" colspan="6" class="oe_form_group_cell oe_form_group_cell_label">&nbsp;</td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td colspan="2" rowspan="6" align="center" bgcolor="#E8E8E8" class="oe_form_group_cell oe_form_group_cell_label" style="text-align:center"><img src="../../d_pic/pp/<?=$$unique.'.jpg';?>" width="170" height="180" /></td>
                  <td colspan="2" rowspan="6" align="center" bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px; text-align:center"><span class="oe_form_group_cell oe_form_group_cell_label" style="text-align:center"><img src="../../d_pic/np/<?=$$unique.'.jpg';?>" width="170" height="180" /></span></td>
                  <td colspan="2" align="center" bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><strong>Signature</strong></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="2" align="center" bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px; text-align:center"><span class="oe_form_group_cell oe_form_group_cell_label"><img src="../../d_pic/sp/<?=$$unique.'.jpg';?>" alt="" width="200" height="50" /></span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Proprietor:</td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><input type="file" style="width:150px;" name="sp" id="sp" /></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="2" align="center" bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px; text-align:center"><span class="oe_form_group_cell oe_form_group_cell_label"><img src="../../d_pic/sa/<?=$$unique.'.jpg';?>" alt="" width="200" height="50" /></span></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Alternate:</td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input type="file" style="width:150px;" name="sa" id="sa" />
                  </span></td>
                </tr>
                <tr class="oe_form_group_row">
                  <td colspan="2" align="center" bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px; text-align:center"><span class="oe_form_group_cell oe_form_group_cell_label"><img src="../../d_pic/sn/<?=$$unique.'.jpg';?>" alt="" width="200" height="50" /></span></td>
                  </tr>
                <tr class="oe_form_group_row">
                  <td bgcolor="#E8E8E8" colspan="1" class="oe_form_group_cell oe_form_group_cell_label">Propritor Photo:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input type="file" style="width:150px;" name="pp" id="pp" />
                  </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Nominee Photo:</td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input type="file" style="width:150px;" name="np" id="np" />
                  </span></td>
                  <td bgcolor="#E8E8E8" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">Nominee:</td>
                  <td bgcolor="#FFFFFF" class="oe_form_group_cell" style="padding: 2px 0 2px 2px;"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <input type="file" style="width:150px;" name="sn" id="sn" />
                  </span></td>
                </tr>
                </tbody></table></td>
            </tr></tbody></table></div>
                      </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
        </div>
    </div>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>