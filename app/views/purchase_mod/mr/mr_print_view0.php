<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$req_no 		= $_REQUEST['req_no'];
$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);
$sql="select * from requisition_master where  req_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);

if(isset($_POST['create_po'])){
  
 if($_POST['req_no']>0){
  unset($_SESSION['po_no']);
  $_SESSION['selected_req_no'] = $_POST['req_no'];
  header('location:../po/req_po_create.php');
 }

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="UTF-8">
<title>Requsition Copy</title>
<link href="../css/invoice.css" type="text/css" rel="stylesheet"/>

<script type="text/javascript">
function hide()
{
   document.getElementById("pr").style.display="none";
}
</script>




<style type="text/css">
<!--
.header table tr td table tr td table tr td table tr td {
	color: #000;
}

@font-face {
  font-family: 'MYRIADPRO-REGULAR';
  src: url('MYRIADPRO-REGULAR.OTF'); /* IE9 Compat Modes */

}

@font-face {
  font-family: 'TradeGothicLTStd-Extended';
  src: url('TradeGothicLTStd-Extended.otf'); /* IE9 Compat Modes */

}


@font-face {
  font-family: 'Humaira demo';
  src: url('Humaira demo.otf'); /* IE9 Compat Modes */

}

@media print {
  .brack {page-break-after: always;}
}


		#pr input[type="button"] {
			width: 70px;
			height: 25px;
			background-color: #e4f5ff;
			color: #333;
			font-weight: bolder;
			border-radius: 5px;
			border: 1px solid #333;
			cursor: pointer;
		}
	</style>


</head>
<body style="font-family:Tahoma, Geneva, sans-serif; font-size: 10px;">

<div class="page_brack" >

	<div id="pr">
		<h2 align="center">	<input name="button" type="button" onclick="hide();window.print();" value="Print"/></h2>
	</div>

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">

  
  <thead>
  <tr>
    <td><div class="header" style="margin-top:0; padding: 5px 10px;  border-radius: 5px;  ">
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
    
		  <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="10%">
						<table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									<td>
						  	          <div align="left"><img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png"   style=" width:100%;"  />
						  	            
		  	                          </div></td>
							</tr>
							</table> 
						
						</td>
						
                        <td width="80%" align="center">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
									<tr>
									  <td style="padding-bottom:3px; text-align:center;"><h2 style="margin: 0px;"><?=$group_data->group_name?></h2></td>
							  		</tr>
									
									<tr>
									  <td style="font-size:14px; line-height:24px; text-align:center;"><strong>Address:</strong> <?=$group_data->address?></td>
									</tr>

								  <tr>
									  <td style=" font-size:14px; line-height:24px; text-align:center;"><strong>Phone:</strong> <?=$group_data->mobile;?>, <strong>Email:</strong> <?=$group_data->email;?></td>
								  </tr>
								  
								  <tr>
									  <td style=" font-size:14px; line-height:24px; text-align:center;">
									  		<strong>Web:</strong>  <?=$group_data->website;?>
									  </td>
								  </tr>
						  </table>
						  
						  
						  </td>
                        
                        <td width="10%"> 
						<table width="100%" border="0" cellspacing="0" align="center" cellpadding="0" style="font-size:15px; margin:0; padding:0;">
								
									
									<tr>
									<td>&nbsp;
						  	          </td>
							</tr>
							</table>
							
						</td>
					  </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
        </table>
       </div></td>
  </tr>
  
  

 <tr>
	 <td> <hr/> </td>
 </tr>


 
  
  
  <tr>
	  <td>
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="font-size:12px">
  
  <tr><td>&nbsp;</td></tr>
  
  	<tr height="30">
  	  <td width="25%" valign="top"></td>
  	  <td width="50%"  style="text-align:center; "><span style="color:#FFF; font-size:14px; padding:8px 30px; color:#000000; font-weight:bold; border: 2px solid #000000; border-radius: 5px; ">
	  PURCHASE REQUISITION </span> </td>
  	  <td width="25%" align="right" valign="right">&nbsp;</td>
	  </tr>

	  <tr><td>&nbsp;</td></tr>

  </table>
  </td>
  </tr>
  
  
  
 
	  
	  
	   
  
  
  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  <tr>

		    <td width="80%" valign="top">

		      <table width="100%" border="0" cellspacing="0" cellpadding="3"  style="font-size:13px">
			  
			  
			  
			  
			  
			  
			  
			  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold;" class="style8"> Requisition No :  <?php echo $all->req_no;?> &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px; font-weight:bold; float: left;" class="style8"> Warehouse : 
					  <?php echo find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id);?>
                            
                      &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        

                  <tr>
				  
				  <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span style="font-size:14px;" class="style8">
		               <strong>Requisition Date :</strong>  <?php echo $all->req_date;?>
		              &nbsp;</span></td>
		              </tr>

		            </table></td>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5" style=" ">

		            <tr>

		              <td ><span class="style8" style="font-size:14px;"><strong>Need Before :</strong> <?php echo $all->need_by;?> &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>

		        <tr>

		          <td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8"><strong>Requisition For :</strong> <?php echo $all->req_for;?> &nbsp;</span></td>
		              </tr>

		            </table></td>
					
					<td><table width="100%" border="1" cellspacing="0" cellpadding="5">

		            <tr>

		              <td  valign="top"><span style="font-size:14px; " class="style8"><strong>Note :</strong> <?php echo $all->req_note;?> &nbsp;</span></td>
		              </tr>

		            </table></td>
		          </tr>
				  

                  
		        </table>		      
				</td>

			<td width="20%">
			<table width="100%" border="1" cellspacing="0" cellpadding="0"  style="font-size:12px">
			
			
	

			  <tr>

			    <td align="center" valign="middle" style="padding:5px;">
				<img style="margin:0; padding:0; height: 102px;" src="https://chart.googleapis.com/chart?chs=140x140&cht=qr&chl=<?=$group_data->group_name?>&choe=UTF-8" title="ERP COM BD" /></td>
			    </tr>
				
				
				
				
				
			

			  

			  </table></td>

		  </tr>

		</table></td>

	  </tr>
  
  <tr><td>&nbsp;</td></tr>
  
 
  <tr>
  	<td>
		<div id="pr">
        <div align="left">
<!--          <p>-->
<!--            <input name="button" type="button" onclick="hide();window.print();" value="Print" />-->
<!--          </p>-->

          <nobr>
          <!--<a href="chalan_bill_view.php?v_no=<?=$_REQUEST['v_no']?>">Bill</a>&nbsp;&nbsp;--><!--<a href="do_view.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank"><span style="display:inline-block; font-size:14px; color: #0033FF;">Bill Copy</span></a>-->
          </nobr>

		  <nobr>
          <!--<a href="chalan_bill_distributor_vat_copy.php?v_no=<?=$_REQUEST['v_no']?>" target="_blank">Vat Copy</a>-->
          </nobr>
		</div>
      </div>
	</td>
  
  </tr>
  
  
   </thead>
  
 
  <tbody >
 
  <tr >
    <td valign="top">
      <table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="5"  style="font-size:12px"  >
       
		<tr>
			<th width="5%">SL</th>
			<th width="10%">REQ-ID</th>
			<th width="35%">Description of the Goods</th>
			<th width="10%">Remarks</th>
			<th width="10%">In Stock </th>
			<th width="10%">Last Pur. Date</th>
			<th width="10%">Last Pur. QTY</th>
			<th width="10%">Req QTY</th>
		</tr>

	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from requisition_order where  req_no='$req_no'";
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
$total_qty +=$qty;
?>
      <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$info->id?></td>
        <td align="left" valign="top">Code:<?=$info->item_id?><br><?=$item->item_name.' : '.$item->item_description?></td>
        <td valign="top"><?=$info->item_for?></td>
		<td valign="top"><?=$qoh?></td>
        <td valign="top"><?=$last_p_date?></td>
        <td align="right" valign="top"><?=$last_p_qty?></td>
        <td valign="top"><?=$qty.' '.$item->unit_name?></td>
      </tr>
<? }?>


<tr >
<!-- <td colspan="7">&nbsp;</td>-->
 <td colspan="7" align="right"><strong>Total </strong> </td>

 <td align="right"> <strong><?=number_format($total_qty,2)?></strong></td>
</tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
	<form method="post" action="">
	  <input name="create_po" type="submit" class="btn btn-info" value="Create Purchase Order" style="width:200px; font-weight:bold; font-size:12px; height:30px; color:white; background:cornflowerblue; border:0px; cursor: pointer;" />
	  <input type="hidden" name="req_no" value="<?=$req_no?>" />
	  </form>
	  </td>
  </tr>
 

      </table>      
	  </td>
  </tr>
  
  
  
  
  
  
  
  
  <tr>

	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
		

		  

		</table></td>

	  </tr>
  
  
  </tbody>
  
	
	
	<tfoot >

	<tr>
		<td>
	
	 <div class="footer"> 
	<table width="100%" cellspacing="0" cellpadding="0"   >
	
	

		  

		  <tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		    <td align="center" >&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    <td align="center">&nbsp;</td>
		    </tr>
		  <tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  <tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  <tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  <tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		  <tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		<tr>
		  <td align="center" >&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  </tr>
		   <tr>
		  <td align="center"  style=" font-size:12px;">
		  <?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?>
		  </td>
		  <td align="center"></td>
		  <td align="center"><?=find_a_field('user_activity_management','fname','user_id='.$all->checked_by)?></td>
		  </tr>
		<tr>
		  <td align="center" >---------------------------------</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">---------------------------------</td>
		  </tr>
		<tr>
		  <td align="center"></td>
		  <td align="center"></td>
		  <td align="center"></td>
		  </tr>
		<tr style="font-size:12px">
            <td align="center" width="25%"><strong>Prepared By: </strong></td>
		    <td  align="center" width="25%">&nbsp;</td>
		    <td  align="center" width="25%"><strong>Approved By: </strong></td>
		    </tr>
		<tr style="font-size:12px">
		  <td align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  <td  align="center">&nbsp;</td>
		  </tr>
		
		
		
			
	<!--

	<tr>
            <td colspan="3">  <hr /> </td>
		</tr>

	
          <tr>
            <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:16px; text-transform:uppercase; font-weight:700;" align="center" ><?=$group_data->group_name?></td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000;  font-size:12px; " align="center" ><strong>Address:</strong> <?=$group_data->address?></td>
		</tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" ><strong>Phone:</strong> <?=$group_data->mobile;?>, <strong>Email:</strong> <?=$group_data->email;?></td>
          </tr>
		  <tr>
			 <td colspan="3" style="border:0px;border-color:#FFF; color: #000; font-size:12px; " align="center" ><strong>Web:</strong>  <?=$group_data->website;?></td>
          </tr>-->
		  
	</table>
	
	</div>
	
</td>
	  </tr>
	
	</tfoot>
	
  
</table>


</div>



</body>
</html>
