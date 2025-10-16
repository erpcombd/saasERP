<?php 
$data = array();

	$data['a'] = $_REQUEST['a'];
	$data['b'] = $_REQUEST['b'];
	$data['c'] = $_REQUEST['c'];
	$data['d'] = $_REQUEST['d'];
	$data['e'] = $_REQUEST['e'];
	$cc_code	= $_REQUEST['cc_code'];
	$count = $_REQUEST['count'];
	//echo '<pre>';
	//print_r($data);
	//echo '</pre>'; 

?>
<style>
.datagtable
{
	border-bottom:1px solid #CCC;
}
.datagtable td
{
	border-left:1px solid #CCC;
}
.datagtable input
{
	border:0;	
}
.editable
{
	background:#FF9;
}

.editable input
{
	border:1px solid #CCC;
	background:#FFF;
}
.deleted, .deleted input
{
	background:#F00;
	color:#FFF;
}
img
{
border:0px;
}
</style>

<table width='100%' border="0"  bgcolor="#FFFFFF" style="border-collapse:collapse" class="datagtable">
	<tr align="left" id="rowid<?php echo $count;?>" height="30">
      <td width="40%">
      	<input name="ledger_id<?php echo $count;?>" id="ledger_id<?php echo $count;?>" type="text" readonly="true" value="<?php echo $data['b'] ?>"  class="input1" style="width:300px;" />
      </td>
      <td width="10%">
      	<input name="cur_bal<?php echo $count;?>" id="cur_bal<?php echo $count;?>" type="text" readonly="true" value="<?php echo $data['c'] ?>" size="10" />
      </td>
      <td width="30%">
      	<input name="detail<?php echo $count;?>" id="detail<?php echo $count;?>" type="text" readonly="true" value="<?php echo $data['d'] ?>" size="50" style="width:220px;" />
      </td>
      <td width="10%">
      	<input name="amount<?php echo $count;?>" id="amount<?php echo $count;?>" type="text" readonly="true" value="<?php echo $data['e'] ?>" onblur="editamount<?php echo $count;?>();" size="10" />
      </td>
      <td width="2%"><a href="#" onclick="editfield<?php echo $count;?>(); return false;"><img src="../images/edit.png" width="16" height="16" /></a></td>
      <td width="5%">
      	<a href="#" onclick="deletethis<?php echo $count;?>();">
        	<img src="../images/delete.png" width="16" height="16" />
        </a>
       </td>
	</tr>		
</table>
<input name="deleted<?php echo $count;?>" id="deleted<?php echo $count;?>" type="hidden" value="no" />
<script type="text/javascript">

function deletethis<?php echo $count;?>()
{
	document.getElementById('rowid<?php echo $count;?>').className='deleted';
	document.getElementById('t_amount').value = (document.getElementById('t_amount').value) - (document.getElementById('amount<?php echo $count;?>').value);
	document.getElementById('deleted<?php echo $count;?>').value='yes';
	document.getElementById('rowid<?php echo $count;?>').style.display='none';
}

function editfield<?php echo $count;?>()
{
	document.getElementById('rowid<?php echo $count;?>').className='editable';
	
	document.getElementById('detail<?php echo $count;?>').readOnly = false;
	document.getElementById('amount<?php echo $count;?>').readOnly = false;
	
}

function editamount<?php echo $count;?>()
{
	/*
	var change<?php echo $count;?> = org_amnt<?php echo $count;?> - (document.getElementById('amount<?php echo $count;?>').value)
	
	var newval<?php echo $count;?> = (org_t_amnt<?php echo $count;?>) - (change<?php echo $count;?>);
	alert(newval<?php echo $count;?>);
	
	document.getElementById('t_amount').value = newval<?php echo $count;?>;
	*/
	
	var i=0;
	var last = document.getElementById('count').value;

	var t_amnt = 0;
	for (i=1;i<=last;i++)
	{
		if(isNaN(document.getElementById('amount'+i).value))
		{
			alert('Invalid number on ('+ i +') number row.');
		}
		else
		{
			t_amnt = +t_amnt + (+document.getElementById('amount'+i).value)
		}
	}
	document.getElementById('t_amount').value = t_amnt;
}
</script>