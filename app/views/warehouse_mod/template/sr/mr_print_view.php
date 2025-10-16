<?php
session_start();
//====================== EOF ===================
//var_dump($_SESSION);
require "../../../warehouse_mod/support/inc.all.php";
require "../../../engine/tools/class.numbertoword.php";



$req_no 		= $_REQUEST['req_no'];

$sql="select * from requisition_master_stationary where  req_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);

$emp = find_all_field('personnel_basic_info','PBI_NAME','PBI_ID='.$all->entry_by);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Requsition Copy</title>
<link href="../../css/invoice.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}

function company_info(val){
  if(val=='Natura'){
    document.getElementById("company_name").innerHTML="Natura Agro Processing Ltd.";
  }else{ 
    document.getElementById("company_name").innerHTML="Jamuna Edible Oil Industries Ltd.";
  }
}
</script>
<style>
.header2_left{
	float:left;
}
.header2_right{
	float:right;
}


</style>
</head>
<body>
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
			
			   <tr>
                <td style="text-align:center">
			<h1 id="company_name" >Jamuna Industrial Agro Group</h1>
			 <h6>Makkah Madina Trade Centre (5<sup>th</sup> & 6<sup>th</sup> Floor), Plot No.88, Sonargaon Janapath Road, Sector 11, Uttara, Dhaka-1230</h6>
			   </td>
               </tr>
	
               <tr>
                <td>
				<div class="header_title" style="text-align:center">
			   <h2>Requisition Form </h2>
				<div class=""
				</div>
	
				</div></td>
              </tr>
			  
	
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td align="center" valign="bottom"><strong>
		     
		    </strong></td>
			</tr>
		</table>		</td>
	  </tr>
    </table>
    </div></td>
  </tr>
  <tr>
    
	<td>	</td>
  </tr>
  <tr>
    <td><div class="line"></div></td>
  </tr>
  <tr>
    <td><div class="header_title">
          <div class="header2_left">
	   
        <p>
		 <strong>Req No:</strong> <?= $all->req_no;?><br /><br />
		<strong>Kind Attention: Honorable Deputy Managing Director</strong><br /><br />
          <strong>Name:</strong> <?php echo $emp->PBI_NAME;?><br /><br />


      
          <strong>Designation:</strong> <?php echo $emp->PBI_DESIGNATION;?><br /><br />
        </p>
      </div>
      <div class="header2_right">
        <p>
		  <strong>Date: <?php echo $all->req_date;?></strong></p>

          <strong>Name of Concern:</strong> <?php echo find_a_field('user_group','group_name','id='.$all->warehouse_id);?><br /><br />
		  <strong>Cell Phone:</strong> <?php echo $emp->PBI_MOBILE;?><br /><br />
          <strong>Department:</strong> <?php echo $emp->PBI_DEPARTMENT;?><br />
        </p>
      </div>
    </div></td>
  </tr>
  <tr>
    <td>
	<div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
	<td><div><select onchange="company_info(this.value)" name="company" id="company">
            <option value="Natura">Natura</option>
            <option value="Jamuna">Jamuna</option>
          </select></div></td>
	
  </tr>
</table>

</form>
</div>
</div>
<table width="100%" style="text-align:center" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="6%" rowspan="2"><strong>SL.</strong></td>
        <td width="27%" rowspan="2"><strong>Particulars</strong></td>
		<td width="11%" rowspan="2"><strong>Quantity</strong></td>
        <td width="22%" rowspan="2"><strong>Last Receive Date </strong></td>
        <td colspan="2"><strong>Office Use Only </strong></td>
        </tr>
       <tr>
         <td width="20%">Rate Approx </td>
         <td width="14%">Remarks</td>
       </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from requisition_order_stationary where  req_no='$req_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$amount=$info->qty*$info->rate;
$total=$total+($info->qty*$info->rate);
$sl=$pi;
$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
$qty=$info->qty;
$qoh=$info->qoh;
$last_p_date=$info->last_p_date;
$last_p_qty=$info->last_p_qty;
$item_for=$info->item_for;
?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top">Code:<?=$info->item_id?><br><?=$item->item_name.' : '.$item->item_description?></td>
        <td valign="top"><?=$qty.' '.$item->unit_name?></td>
		<td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><?=$info->item_for?></td>
        </tr>
<? }?>
    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td align="center">
	<div class="footer1"></div>
	<div class="footer1">
     <table width="100%" border="0">
       <tr>
         <td align="center"><?=$emp->PBI_NAME;?></td>
		  <td align="center"><?php echo find_a_field(' hrm_user_access','user_name','emp_id='.$all->checked_by);?></td>
		  <td align="center"><?php echo find_a_field(' hrm_user_access','user_name','emp_id='.$all->operation_manager);?></td>

         <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->approve_by)?></td>
         <?php /*?><td><?=find_a_field('user_activity_management','fname','user_id='.$all->checked_by)?></td><?php */?>
		 		  <td align="center"></td>

       </tr>
       <tr>
         <td align="center">Prepared By</td>
	     <td align="center">Recommanded By </td>
         <td align="center">Operation Manager</td>
         <td  align="center">Checked By </td>
		 <td align="center">Approved By </td>
       </tr>
     </table>
     </div></td>
  </tr>
</table>
</body>
</html>
