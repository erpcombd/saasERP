<?php



//



//



require "../../config/inc.all.php";

$employee = $_SESSION['employee_selected'];
$mon = date('m');
$year = date('Y');

//$pay = 'select s.*,p.PBI_NAME,p.PBI_CODE,p.PBI_EMAIL,(select DESG_DESC from designation where DESG_ID=s.designation) as designation,(select DEPT_DESC from department where DEPT_ID=s.department) as department from salary_attendence s,personnel_basic_info p where s.PBI_ID=p.PBI_ID and p.PBI_ID="'.$employee.'"';


//$qry = db_query($pay);
//$paySlip = mysqli_fetch_object($qry);


//while($paySlip = mysqli_fetch_object($qry)){




?>



  <table width="600" align="center">


<tr>

     <td style="border:0px;" align="left" ><span style="font-size:18px; font-weight:bold;">Under Construction..</span></td>

 </tr>

    <tr>



      <td style="border:0px;" align="left" ><span style="font-size:18px; font-weight:bold;"><?=$_SESSION['company_name']?></span></td>



    </tr>



    <tr>



      <td style="border:0px;" align="left" ><span style="font-size:16px; font-weight:bold;">Pay Slip</span></td>

    </tr>

    <tr>

      <td style="border:0px;" align="left" ><span style="font-size:12px; font-weight:bold;">Period :


        <? /* $test = new DateTime('01-'.$_POST['mon'].'-'.$_POST['year'].' ');




$_SESSION['year'] = $_POST['year'] ; 

 echo date_format($test, 'M-Y');*/?>



        </span></td>



    </tr>
	
	<tr>



      <td style="border:0px;" align="left" ><span style="font-size:14px; font-weight:bold;">Issued by HR Division</span></td>

    </tr>



  </table>



  <table width="600" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:16px;">



   


    <tr>



      <td>Name</td>



      <td align="center">:</td>



      <td colspan="3"><?=$paySlip->PBI_NAME?></td>


    </tr>
	
	 <tr>



      <td>Employee ID</td>



      <td align="center">:</td>



      <td colspan="3"><?=$paySlip->PBI_CODE?></td>


    </tr>
	
	 <tr>



      <td>Designation</td>



      <td align="center">:</td>



      <td colspan="3"><?=$paySlip->designation?></td>


    </tr>
	
	 <tr>



      <td>Email</td>



      <td align="center">:</td>



      <td colspan="3"><?=$paySlip->PBI_EMAIL?></td>


    </tr>


    <tr >



      <td colspan="5">&nbsp;</td>



    </tr>



    <tr >



      <td colspan="2" align="left"><strong>Pay Component Description</strong></td>



      <td><strong>Amount (BDT)</strong></td>



      <td colspan="2"><strong>Subtotal Amount (BDT)</strong></td>



    </tr>
	
	<tr >



      <td colspan="5" align="left" style="font-size:18px;"><strong>Addition (A)</strong></td>



    </tr>
	
	<tr>

      <td colspan="2" align="left">Basic Salary</td>

      <td align="right"><?=number_format($paySlip->basic_salary,0)?></td>

      <td colspan="2" align="right"></td>

    </tr>
	<tr>

      <td colspan="2" align="left">House Rent</td>

      <td align="right"><?=number_format($paySlip->house_rent,0)?></td>

      <td colspan="2" align="right"></td>

    </tr>
	<tr>

      <td colspan="2" align="left">Medical Allowance</td>

      <td align="right"><?=number_format($paySlip->medical_allowance,0)?></td>

      <td colspan="2" align="right"></td>

    </tr>
	<tr>

      <td colspan="2" align="left">Conveyance</td>

      <td align="right"><?=number_format($paySlip->conveyance_allowance,0)?></td>

      <td colspan="2" align="right"></td>

    </tr>
	
	<tr>

      <td colspan="2" align="left"><strong>Gross</strong></td>

      <td align="right"><?=number_format($gross = $paySlip->gross_salary,0)?></td>

      <td colspan="2" align="right"></td>

    </tr>
	
	<tr>

      <td colspan="2" align="left">Arrears</td>

      <td align="right"><? if($paySlip->salary_arrear>0) echo number_format($arrear = $paySlip->salary_arrear,0);?></td>

      <td colspan="2" align="right"></td>

    </tr>
	
	<tr>

      <td colspan="2" align="left">Mobile Bill</td>

      <td align="right"><? if($paySlip->mobile_bill_amt>0) echo number_format($mobile_bill = $paySlip->mobile_bill_amt,0)?></td>

      <td colspan="2" align="right"></td>

    </tr>
	
	<tr>

      <td colspan="2" align="left" style="font-size:16px; font-weight:bold;"><strong>Total Gross</strong></td>

      <td align="right"></td>

      <td colspan="2" align="right"><?=number_format($total_gross = $gross+$arrear+$mobile_bill,0)?></td>

    </tr>
	
	<tr>


      <td colspan="5" align="left" style="font-size:18px;"><strong>Deduction (B)</strong></td>

    </tr>
	
	<tr>

      <td colspan="2" align="left">PF (Employee Contribution)</td>

      <td align="right"><?=number_format($pf = $paySlip->pf_deduction,0)?></td>

      <td colspan="2" align="right"></td>

    </tr>
	
	<tr>

      <td colspan="2" align="left">Income Tax</td>

      <td align="right"><?=number_format($income_tax = $paySlip->income_tax,0)?></td>

      <td colspan="2" align="right"></td>

    </tr>
	
	<tr>

      <td colspan="2" align="left" style="font-size:16px; font-weight:bold;"><strong>Deductions Subtotal</strong></td>

      <td align="right"></td>

      <td colspan="2" align="right"><?=number_format($total_deduction = $income_tax+$pf,0)?></td>

    </tr>


  </table>
  
  <table width="600" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border:0px;" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td style="border:0px;" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td style="border:0px; font-size:16px; font-weight:bold;" align="left">Net Payment (BDT) = </td>
	<td style="border:0px; font-size:16px; font-weight:bold;" align="center">Payments(A) - Deduction(B)</td>
	<td style="border:0px; font-size:16px;" align="right"><input type="text" value="<?=number_format($total_gross-$total_deduction,0)?>" readonly="readonly" style="text-align:right; height:30px; width:120px; font-weight:bold;"></td>
  </tr>
  
  <tr>
    <td style="border:0px;" colspan="3">&nbsp;</td>
  </tr>
   <tr>
    <td style="border:0px;" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td style="border:0px; font-size:12px;" align="left" colspan="3">Note: <br>
•	This is a system generated copy and therefore no authorized signature is required.<br>
•	Net salary payable amount has been transferred to your respective bank account. Please check the above salary statement and inform HR immediately if you detect any error for necessary correction. 
</td>
 </tr>
  <tr>
    <td style="border:0px;" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td style="border:0px;" colspan="3">&nbsp;</td>
  </tr>
  
  </table>
  
   <table width="600" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:16px;">


   
	
	<tr>
	  <td colspan="5" style="font-size:16px;"><strong>Employee Vehicle Support Benefits</strong></td>
	</tr>



    <tr>



      <td colspan="2" align="left">Other Allowance</td>
      <td colspan="3"></td>



    </tr>
	</table>
	

