<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Product Category';

$proj_id=$_SESSION['proj_id'];

do_datatable('table_head');

$now=time();

$unique='sub_group_id';

$unique_field='sub_group_name';

$table='item_sub_group';

$page="item_sub_group.php";

$crud      =new crud($table);

$$unique = $_GET[$unique];





if(isset($_POST[$unique_field]))

{

$$unique = $_POST[$unique];

//for Record..................................



if(isset($_POST['record']))

{

//$_POST['entry_at']=time();

//$_POST['entry_by']=$_SESSION['user']['id'];







$min=number_format($_POST['group_id']+10000, 0, '.', '');

$max=number_format($_POST['group_id']+100000000, 0, '.', '');

$_POST[$unique]=number_format(next_value('sub_group_id','item_sub_group','10000',$min,$min,$max), 0, '.', '');

$crud->insert();



$type=1;

$msg='New Entry Successfully Inserted.';



unset($_POST);

unset($$unique);

}



//for Modify..................................



if(isset($_POST['modify']))



{

		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';

}











//for Delete..................................









if(isset($_POST['delete']))



{		



		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}







}



if(isset($$unique))



{



$condition=$unique."=".$$unique;	

$data=db_fetch_object($table,$condition);

foreach ($data as $key => $value)

{ $$key=$value;}

}





?>



<script type="text/javascript">

function Do_Nav()

{

	var URL = 'pop_ledger_selecting_list.php';

	popUp(URL);

}

$(document).ready(function(){

	

	$("#form1").validate();	

});	

function DoNav(theUrl)

{

	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;

}

function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>


<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							
							
							
							<tr>

								    <td><div class="box"><form id="form1" name="form1" method="post" action=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Product Group:                                       </td>

                                        <td width="60%" align="right">

										<select name="item_group" id="item_group" style="width:250px; float:left"  >

                                          <option ></option>
										  <? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'1 order by group_name');?>
                                        </select>
										
										</td>

                                      </tr>
									
						

                                      

                                      <tr>

                                        <td colspan="2"><div align="center">
                                          <input class="btn" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn" name="cancel" type="submit" id="cancel" value="Cancel" />
                                        </div></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>
							
							

								  <tr>

									<td style="padding-left:10px;line-height:9px;">
									
									
									
									<?php /*?><?

if($_SESSION['item_group']>0){

?>
<?php */?>
									<table id="table_head" class="table table-bordered" cellspacing="0">
									
									<thead>

							  <tr>
							    <th bgcolor="#45777B"><span class="style1">Product Group </span></th>
							    <th bgcolor="#45777B"><span class="style1">Product  Category </span></th>
								<th bgcolor="#45777B"><span class="style1">Description</span></th>
							  </tr>
								</thead>
								
								<tbody>

<?php


if($_POST['item_group']!='')
$con .= ' and b.group_id = "'.$_POST['item_group'].'" ';






	  $rrr = "select b.sub_group_id,b.sub_group_id,a.group_name, b.sub_group_name, b.description from item_sub_group b,item_group a where a.group_id=b.group_id ".$con."  order by a.status";



	$report = db_query($rrr);

	$i=0;

	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

							   <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">
							     <td><?=$rp[2];?></td>
							     <td><?=$rp[3];?></td>
								 <td><?=$rp[4];?></td>
							   </tr>

	<?php }?>
	</tbody>
							</table>
							
							
							<?php /*?><? }?><?php */?>

									<div id="pageNavPosition"></div>									</td>

								  </tr>

		</table>



	</div></td>

    <td valign="top" width="40%"><div class="right"> <form id="form1" name="form1" method="post" action="" onsubmit="return check()">

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

                                  <td width="100%" colspan="2" ><div class="box" >

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                      <tr>
                                        <td>Product Group  :</td>
                                        <td><select name="group_id" id="group_id" required="required" style="width:250px;">
                                            <option></option>
                                            <?	$sql="select * from item_group where 1 order by group_id";

											$query=db_query($sql);

											while($datas=mysqli_fetch_object($query))

										{

										?>
                                            <option <? if($datas->group_id==$group_id) echo 'Selected ';?> value="<?=$datas->group_id?>">
                                            <?=$datas->group_name?>
                                            </option>
                                            <? } ?>
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>

                                        <td>Product Category : </td>

                                        <td>

                                        <input name="<?=$unique?>" type="hidden"  id="<?=$unique?>" value="<?=$$unique?>"  />

                        <input name="sub_group_name" type="text" id="sub_group_name" value="<?php echo $sub_group_name;?>" style="width:250px" maxlength="100" class="required" />
						<input name="group_for" type="hidden" id="group_for" value="<?php echo $_SESSION['user']['group'];?>" style="width:200px" maxlength="100" class="required" />
						<? $_POST['entry_by'] = $_SESSION['user']['id'];?>
						
						 <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_POST['entry_by'];?>" />
						 <input name="entry_at" type="hidden" required id="entry_at" tabindex="10" value="<?=$now=date('Y-m-d H:i:s');?>" />
						</td>
									  </tr>
									  
									  
									  <tr>

                                        <td>Description : </td>

                                        <td>

                                      

                        <input name="description" type="text" id="description" value="<?php echo $description;?>" style="width:250px" maxlength="100" class="required" />
						
						</td>
									  </tr>

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>
                                      </tr>

									 

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>
                                      </tr>
                                    </table>

                                  </div></td>

                                </tr>

                                

                                <tr>

                                  <td colspan="2">&nbsp;</td>

                                </tr>

                                <tr>

                                  <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                                    <tr>

                                      <td><? if($$unique<1){?>

                                        <input name="record" type="submit" id="record" value="Save" onclick="return checkUserName()" class="btn" />

                                        <? }?></td>

                                      <td><? if($$unique>0){?>

                                        <input name="modify" type="submit" id="modify" value="Modify" class="btn" />

                                        <? }?></td>

                                      <td><input name="clear" type="button" class="btn" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>

                                      <!--<td><? if($_SESSION['user']['level']==5){?>

                                        <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>

                                        <? }?></td>-->

                                    </tr>

                                  </table></td>

                                </tr>

                              </table>

    </form>

							</div></td>

  </tr>

</table>

<script type="text/javascript"><!--

    var pager = new Pager('grp', 50);

    pager.init();

    pager.showPageNav('pager', 'pageNavPosition');

    pager.showPage(1);

//--></script>

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

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>