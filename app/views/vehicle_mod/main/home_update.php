<?php

require_once "../../../assets/template/layout.top.php";

?>

<style type="text/css">

<!--

.style1 {

	font-size: 24px;

	font-weight: bold;

}

.style2 {font-size: 24px}

-->

</style>



<table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" valign="middle">                                    <div align="center">

                                  <p class="style2"><strong>Welcome</strong></p>

                                  <p class="style2"><strong> To </strong></p>

                                  <p class="style1">Sales and Distribution Process Management Software</p>

                                </div></td>

                              </tr>

                            </table>
							
							
<?  
 $to_date =  date("Y-m-d");


    $found=find_a_field('mail_forwarding','do_report','mail_date>="'.$to_date.'"');
  //$fe = "select do_report from hrm_payroll_setup where `year`='".$year."' and mon='".$month."'";
 //$dfdy = mysql_query($fe);
 //$d = mysql_fetch_object(dfdy);
 
  //$d->do_report;

if($found==0){ 
 $start_date = date("Y-m-d",time()-(1*24*60*60));
  $end_date =  date("Y-m-d",time()-(1*24*60*60));
  $cdate = strtotime($start_date);
  $edate = strtotime($end_date);
// $sale='select sum(total_amt) as total_sale_amt from sale_do_details where do_date between '.$start_date.' and '.$end_date.' ';
  //$saleq = mysql_query($sale);
  //$sale_amount = mysql_fetch_object($saleq);
  //$tot_sale = number_format($sale_amount->total_sale_amt,0);
     
	// $str.="(Total Sale In This Period ='".$tot_sale ."' Taka\r\n)";
	
	
   
$str.='<table width="100%" border="1" cellspacing="0" cellpadding="0">

<tr>
    <td colspan="7" align="center" style="border:0px solid #fff"><span style="font-size:20px; font-weight:bold; color:#95b9f4">M. Ahmed Tea & Lands Co. Ltd<br>Daily Sales Report<br><span style="font-weight:bold;">(Date: "'.$start_date.'" To "'.$end_date.'" )</span><br></span></td>
 
  </tr>
  <tr >
    <td width="7%"><div align="center">SL</div></td>
    <td width="20%"><div align="center">Depot Name</div></td>
	<td width="13%"><div align="center">Quantity</div></td>
    <td width="15%"><div align="center">Sale Amount</div></td>
	<td width="11%"><div align="center">Entry By </div></td>
  </tr>';


    $ss = "select w.warehouse_name, sum(c.total_unit) as Quantity, sum(c.total_amt) as total_amt, m.entry_by from sale_do_master m, sale_do_chalan c, warehouse w where m.do_no=c.do_no and c.depot_id=w.warehouse_id and m.do_date between '".$start_date ."' and '".$end_date ."' group by c.depot_id";
	  $query1 = mysql_query($ss);
	 while($data = mysql_fetch_object($query1)){
	 
	 $total_amt = $total_amt+$data->total_amt;
	 $total_qty = $total_qty+$data->Quantity;
	

   	 $str.= '<tr align="center">';
     $str.= '<td>'.++$i.'</td>';
     $str.= '<td><div align="left">'.$data->warehouse_name.'</div></td>';
     $str.= '<td>'.number_format($data->Quantity,2).'</td>';
     $str.= '<td>'.number_format($data->total_amt,2).'</td>';
     $str.= '<td>'.find_a_field('user_activity_management','fname','user_id='.$data->entry_by).'</td>';
     $str.= '</tr>';
    }
   
    $str.='<tr>
    <td width="7%"><div align="center">&nbsp;</div></td>
    <td width="20%"><div align="center">Total =</div></td>
	<td width="13%"><div align="center">'.number_format($total_qty,2).'</div></td>
    <td width="15%"><div align="center">'.number_format($total_amt,2).'</div></td>
	<td width="11%"><div align="center">&nbsp;</div></td>
  </tr></table>';
  

$str.='<table width="100%" border="1" cellspacing="0" cellpadding="0">

<tr>
    <td colspan="7" align="center" style="border:0px solid #fff"><span style="font-size:20px; font-weight:bold; color:#95b9f4">M. Ahmed Tea & Lands Co. Ltd<br>Daily Sales Report<br><span style="font-weight:bold;">(Date: "'.$start_date.'" To "'.$end_date.'" )</span><br></span></td>
 
  </tr>
  <tr >
    <td width="7%"><div align="center">SL</div></td>
    <td width="20%"><div align="center">Depot Name</div></td>
	<td width="13%"><div align="center">Quantity</div></td>
    <td width="15%"><div align="center">Sale Amount</div></td>
	<td width="11%"><div align="center">Entry By </div></td>
  </tr>';


    $ss = "select w.warehouse_name, sum(c.total_unit) as Quantity, sum(c.total_amt) as total_amt, m.entry_by from sale_do_master m, sale_do_chalan c, warehouse w where m.do_no=c.do_no and c.depot_id=w.warehouse_id and m.do_date between '".$start_date ."' and '".$end_date ."' group by c.depot_id";
	  $query1 = mysql_query($ss);
	 while($data = mysql_fetch_object($query1)){
	 
	 $total_amt = $total_amt+$data->total_amt;
	 $total_qty = $total_qty+$data->Quantity;
	

   	 $str.= '<tr align="center">';
     $str.= '<td>'.++$i.'</td>';
     $str.= '<td><div align="left">'.$data->warehouse_name.'</div></td>';
     $str.= '<td>'.number_format($data->Quantity,2).'</td>';
     $str.= '<td>'.number_format($data->total_amt,2).'</td>';
     $str.= '<td>'.find_a_field('user_activity_management','fname','user_id='.$data->entry_by).'</td>';
     $str.= '</tr>';
    }
   
    $str.='<tr>
    <td width="7%"><div align="center">&nbsp;</div></td>
    <td width="20%"><div align="center">Total =</div></td>
	<td width="13%"><div align="center">'.number_format($total_qty,2).'</div></td>
    <td width="15%"><div align="center">'.number_format($total_amt,2).'</div></td>
	<td width="11%"><div align="center">&nbsp;</div></td>
  </tr></table>';
  
 
 
 
     
    
    //$str.="<span style='font-weight:bold;'>Total Sale =(".number_format($total_amt,0).") BDT</span> <br></br>";
   
   $headers .= "MIME-Version: 1.0\r\n";
   $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
   //$to       = 'm.ahmedgroup@gmail.com ';
   
   $to       = 'erp@magnolia-tea.com';

   $subject  = "Daily Sales Report";
   $headers .= "Cc:  faruk@erp.com.bd\r\n";
   $headers .="From: erp@magnolia-tea.com";
   mail($to,$subject,$str,$headers);
  // echo $str;


$up = "INSERT INTO `mail_forwarding` (`do_report`,`mail_date`) VALUES ('1', '".$to_date."')";
$query = mysql_query($up);


}


        
?>

<?



require_once "../../../assets/template/layout.bottom.php";

?>