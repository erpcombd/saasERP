<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Project Info';

//echo $proj_id;
?>

<script type="text/javascript">

function checkUserName()
{	
	var e = document.getElementById('group_name');
	if(e.value=='')
	{
		alert("Invalid Group Name!!!");
		e.focus();
		return false;
	}
	else
	{
		$.ajax({
		  url: 'common/check_entry.php',
		  data: "query_item="+$('#group_name').val()+"&pageid=ledger_group",
		  success: function(data) 
		  	{			
			  if(data=='')
			  	return true;
			  else	
			  	{
				alert(data);
				e.value='';
				e.focus();
				return false;
				}
			}
		});
	}
}
function DoNav(theUrl)
{
	document.location.href = 'ledger_group.php?group_id='+theUrl;
}
</script>

<script type="text/javascript" src="../../js/receipt_install.js"></script>

<div class="box2">
									  <table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													<td>
										          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr>
                                        <td>Project  :</td>
                                        <td><select name="project" id="project">
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                        </select></td>
									  </tr>

                                      <tr>
                                        <td>Builings: </td>
                                        <td><select name="select" id="select">
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                          <option  value="Category">Category</option>
                                        </select></td>
									  </tr>
                                      
                                    </table>													</td>
												  </tr>
												  
												  <tr>
													<td>&nbsp;</td>
												  </tr>
											  </table>											</td>
											<td valign="top">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                     

                                     
                                    </table>											</td>
										  </tr>
										</table>
									  </div>

<div class="box4">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div class="tabledesign2">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <th>Rec No </th>
            <th>Pay Mode</th>
            <th>Cheq No</th>
            <th>Cheq Date</th>
            <th>Bank Name </th>
            <th>Branc</th>
			<th>Amount</th>
          </tr>
          
          <tr class="alt">
            <td>Paycode Des.</td>
            <td>Amount</td>
            <td>Duration</td>
            <td>Total Inst. </td>
            <td>Inst. Amount </td>
            <td>On or before date </td>
			<td>demo Text </td>
          </tr>
          <tr>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
			<td>demo Text </td>
          </tr>
          <tr class="alt">
            <td>Paycode Des.</td>
            <td>Amount</td>
            <td>Duration</td>
            <td>Total Inst. </td>
            <td>Inst. Amount </td>
            <td>On or before date </td>
			<td>demo Text </td>
          </tr>
          <tr>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
			<td>demo Text </td>
          </tr>
          <tr class="alt">
            <td>Paycode Des.</td>
            <td>Amount</td>
            <td>Duration</td>
            <td>Total Inst. </td>
            <td>Inst. Amount </td>
            <td>On or before date </td>
			<td>demo Text </td>
          </tr>
          <tr>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
			<td>demo Text </td>
          </tr>
          <tr class="alt">
            <td>Paycode Des.</td>
            <td>Amount</td>
            <td>Duration</td>
            <td>Total Inst. </td>
            <td>Inst. Amount </td>
            <td>On or before date </td>
			<td>demo Text </td>
          </tr>
          <tr>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
            <td>Demo text </td>
			<td>demo Text </td>
          </tr>
        </table>
      </div></td>
    </tr>
	
	<tr>
	<td>
	
	
	
	
	
	</td>
	
	
	</tr>
	
	
	
	
	
	
    <tr>
      <td><div class="box">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><input type="submit" value="Search " class="btn" /></td>
           
            <td><input type="submit" value="Record" class="btn" /></td>
            <td><input type="submit" value="Close" class="btn" /></td>
          </tr>
        </table>
      </div></td>
    </tr>
  </table>
</div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>