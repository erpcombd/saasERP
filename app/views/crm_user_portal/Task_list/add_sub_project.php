<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='New Sub Project';
$proj_id=$_SESSION['proj_id'];
$table = 'task_project';
$unique = 'project_id';
$shown = 'project_name';
do_datatable('ac_ledger');
$now=time();
if(isset($_REQUEST['project_name']))
{
	
	
	$id=$_REQUEST['project_id'];
	$name		= mysqli_real_escape_string($_REQUEST['project_name']);
	$name		= str_replace("'","",$name);
	$name		= str_replace("&","",$name);
	$name		= str_replace('"','',$name);
	//end
	if(isset($_POST['nledger']))
	{
		$crud   = new crud($table);
		$_POST['entry_by'] = $_SESSION['user']['id'];
		$_POST['entry_at'] = date('Y-m-d H:i:s');
		$under_project = explode('#',$_POST['under_project']);
		$_POST['under_project'] = $under_project[1];
		$$unique=$_SESSION[$unique]=$crud->insert();
        unset($$unique); 	
	}

//for Modify..................................

	if(isset($_POST['mledger']))
	{
	 $crud   = new crud($table);
	 $under_project = explode('#',$_POST['under_project']);
	 $_POST['under_project'] = $under_project[1];
	 $_POST['udate_by']=$_SESSION['user']['id'];
     $_POST['update_at']=date('Y-m-d H:s:i');
	 $crud->update($unique);

	}

}
	 $sql="select * from task_project where project_id='".$_REQUEST['project_id']."'";
	$query = db_query($sql);
	$data=mysqli_fetch_object($query);

auto_complete_from_db('task_project','project_name','concat(project_name,"#",project_id)','under_project=0','under_project');
?>
<style type="text/css">
<!--
.style3 {color: #FFFFFF; font-weight: bold; }
-->
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>    <td width="66%" style="padding-right:5%">
	<div class="left">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  
								  <tr>
									<td>&nbsp;</td>
								  </tr>
								  <tr>
									<td>
						<table id="ac_ledger" class="table table-striped table-bordered" cellspacing="0">
						<thead>
							  <tr>
								<th bgcolor="#45777B"><span class="style3">Sub Project ID</span></th>
								<th bgcolor="#45777B"><span class="style3">Sub Project</span></th>
								<th bgcolor="#45777B"><span class="style3">Project</span></th>
							  </tr>
						</thead><tbody>
<?php 

$rrr="select a.project_id, a.project_name,under_project FROM task_project a where under_project>0 order by a.project_id desc";

	$report=db_query($rrr);

	while($rp=mysqli_fetch_object($report))
	{$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp->project_id;?>');">
				 				<td><nobr><?=$rp->project_id;?></nobr></td>
								<td><?=$rp->project_name;?></td>
								<td><?=find_a_field('task_project','project_name','project_id="'.$rp->under_project.'"');?></td>
								
							  </tr>
	<?php }?></tbody>
							</table>								</td>
								  </tr>
								</table>

							</div>	</td>    <td valign="top" width="34%" >
	<div class="rights"><form id="form2" name="form2" method="post" action="">
							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box style2" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>
							  
							  
                                <tr>
                                  <td><div class="box style2" style="width:400px;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td>Project Name : </td>
                                        <td>
										<input type="hidden" name="project_id" id="project_id" value="<?=$data->project_id?>" />
										<input name="project_name" type="text" id="project_name" value="<?php echo $data->project_name;?>" class="required" style="width:220px" />
										
										</td>
									  </tr>
									  
									  <tr>
                                        <td>Project Name : </td>
                                        <td>
										<input name="under_project" type="text" id="under_project" value="<?php echo  find_a_field('task_project','project_name','project_id="'.$data->under_project.'"').'#'.$data->under_project;?>" class="required" style="width:220px" />
										
										</td>
									  </tr>

                                  
                                    </table>
                                  </div></td>
                                </tr>
                                
                                
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>
								  <div class="box1">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td> <? if($data->project_id==""){?><input name="nledger" type="submit" id="nledger" value="Record" class="btn btn-success" /><? }?></td>
                                      <td><? if($data->project_id>0){?><input name="mledger" type="submit" id="mledger" value="Modify" class="btn btn-warning" /><? }?></td>
                                      <td><input name="Button" type="button" class="btn btn-warning" value="Clear" onClick="parent.location='add_sub_project.php'"/></td>
                                      <td><? if($_SESSION['user']['level']==10){?><input class="btn btn-danger" name="dledger" type="submit" id="dledger" value="Delete"/><? }?></td>
                                    </tr>
                                  </table>
								  </div>								  </td>
                                </tr>
                              </table>
    </form>
							</div></td>
  </tr>
</table>
<script type="text/javascript">







function Do_Nav()



{



	var URL = 'pop_ledger_selecting_list.php';



	popUp(URL);



}







function DoNav(theUrl)



{



	document.location.href = 'add_sub_project.php?project_id='+theUrl;


}

function popUp(URL) 
{
	day = new Date();
	id = day.getTime();
	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");
}
</script>
<script type="text/javascript">


	document.onkeypress=function(e){
	var e=window.event || e
	var keyunicode=e.charCode || e.keyCode
	if (keyunicode==13)
	{
		return false;
	}
}
</script>
<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>