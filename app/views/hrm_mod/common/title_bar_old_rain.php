<? if(isset($_POST['button'])){
	$_SESSION['employee_selected'] = $_POST['employee_selected'];
}?>
<table class="oe_view_manager_header">
  <colgroup>
  <col width="20%">
  <col width="35%">
  <col width="15%">
  <col width="30%">
  </colgroup>
  <tbody>
    <tr class="oe_header_row oe_header_row_top">
      <td colspan="2"><!--<h2 class="oe_view_title"> <span class="oe_view_title_text oe_breadcrumb_title"><a href="#" class="oe_breadcrumb_item" data-id="breadcrumb_15">HRM</a> <span class="oe_fade"> >> </span> <span class="oe_breadcrumb_item">
          <?=$title;?>
      </span></span> </h2>--></td>
      <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:25px; vertical-align:middle;">
	   <form action="" method="post">
          <tr>
            <td align="center" valign="middle" bgcolor="#CCCCCC"><strong style="color:Black; font-size:16px;"><em>&nbsp;Employee Identification Number</em></strong></td>
            <td align="center" bgcolor="#CCCCCC"><strong><em>
              <input type="text" name="employee_selected" id="employee_selected" style="height:20px; width:127px; color:#F30; font-weight:bold" value="<?=$_SESSION['employee_selected']?>" />
              </em></strong></td>
            <td align="center" valign="middle" bgcolor="#3399FF"><input type="submit" name="button" class="btn btn-success" id="button" value="Find" style="width:60px; font-weight:bold; border:3px solid #ccc;" /></td>
          </tr>
	 </form>	  
		  <? if($_SESSION['employee_selected']>0){ 
		   $sql =  @db_query("select PBI_NAME,PBI_PICTURE_ATT_PATH,PBI_DEPARTMENT,PBI_DESIGNATION from  personnel_basic_info where PBI_ID = ".$_SESSION['employee_selected']."");
		   $row = @mysqli_fetch_object($sql);
		  ?>
          <tr>
            <td align="center" valign="middle" bgcolor="#CCCCCC"><strong style="color:#FFF; font-size:16px;"><em>
			<img src="<?=$row->PBI_PICTURE_ATT_PATH?>" width="70" height="85" /></em></strong></td>
            <td colspan="2" align="center" bgcolor="#CCCCCC"><?php
				
				  echo "<span style='font-size:24px;'>".' '.$row->PBI_NAME."(".$_SESSION['employee_selected'].")<br/></span>";
				  
				  echo "<span style='font-size:16px; margin-top:10px;'>".find_a_field('designation','DESG_DESC','DESG_ID='.$row->PBI_DESIGNATION)."<br/></span><span style='height:10px;'></span>";
				  echo "<span style='font-size:18px; margin-top:10px;'>".find_a_field('department','DEPT_DESC','DEPT_ID='.$row->PBI_DEPARTMENT)."</span>";
				 
				?>			</td>
         </tr>
          
		  <? }?>
      </table></td>
    
 
  </tbody>
</table>
