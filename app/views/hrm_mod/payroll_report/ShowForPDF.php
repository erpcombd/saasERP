<?php

session_start();

//

$datatodisplay=$_REQUEST['datatodisplay2'];

$datatodisplay=str_replace('tr style="display: none;"','tr',$datatodisplay);

?>

<html>

<head>

<link href="../../css/report.css" type="text/css" rel="stylesheet"/>

<style type="text/css">

<!--

.style1 {

	font-size: 18px;

	font-weight: bold;

}

-->

</style>

</head>

<body onLoad="window.print()">

<table width="90%" align="center"  cellpadding="0" cellspacing="0">

          <tr>

            

            <td style="border:0px" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td style="border:0px" align="center" class="title">&nbsp;<?=$_SESSION['proj_name']?>&nbsp;</td>

              </tr>


            </table></td>

          </tr>

          

</table>

<br>

<?=$datatodisplay?></body>

</html>

<?php  

$main_content=ob_get_contents();

ob_end_clean();

//define('FPDF_FONTPATH','font/');





$name="print_".time().".pdf";  

// $name name of the PDF generated.  



$html=$main_content;  

// getHTML() function will return the above mention HTML  



//$pdf=new HTML2FPDF();  

//$pdf->AddPage();  

//$pdf->WriteHTML($html);  

//

//$re=$pdf->Output($name,"D");  

require_once('../html2pdf/html2pdf.class.php');
    
	
    $html2pdf = new HTML2PDF('L','A3','fr');
	

    $html2pdf->WriteHTML($html);

    $html2pdf->Output($name);

// Genrate PDF, There few Options  

// 1. D => Download the File  

// 2. I => Send to standard output  

// 3. F => Save to local file  

// 4. S => Return as a string  

?>  