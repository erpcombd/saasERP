<div class="print_box">	

						

									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

									  <tr>

										<td>

<form action="SaveToExcel.php" method="post" name="form_excel" target="_blank" id="form_excel" onsubmit='$("#datatodisplay").val( $("<div>").append( $("#grp").eq(0).clone() ).html() )'>

<input  type="image" src="../images/xls_hover.png" width="26" height="26" style="width:26px; height:26px;">

<input type="hidden" id="datatodisplay" name="datatodisplay" />

<input type="hidden" id="page_title" name="page_title" value="<?=$title?>" />

</form>

										</td>

																				

																			    <td>

<!--<form action="ShowForPDF.php" method="post" name="form_pdf" target="_blank" id="form_pdf" onsubmit='$("#datatodisplay2").val( $("<div>").append( $("#grp").eq(0).clone() ).html() )'>

<input  type="image" src="../images/pdf.jpg" width="26" height="26" style="width:26px; height:26px;">

<input type="hidden" id="datatodisplay2" name="datatodisplay2" />

<input type="hidden" id="page_title" name="page_title" value="<?=$title?>" />

<input type="hidden" id="report_detail" name="report_detail" value="<?=$report_detail?>" />

</form>-->

										</td>

									    <td>

<form action="ShowForPrint.php" method="post" name="form_print" target="_blank" id="form_print" onsubmit='$("#datatodisplay1").val( $("<div>").append( $("#grp").eq(0).clone() ).html() )'>

<input  type="image" src="../images/print.png" width="26" height="26" style="width:26px; height:26px;">

<input type="hidden" id="datatodisplay1" name="datatodisplay1" />

<input type="hidden" id="page_title" name="page_title" value="<?=$title?>" />

<input type="hidden" id="report_detail" name="report_detail" value="<?=$report_detail?>" />

</form>

</td>

									  </tr>

									</table>

									</div>