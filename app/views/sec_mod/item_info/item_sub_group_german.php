<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Product Category';

$proj_id=$_SESSION['proj_id'];

do_datatable('table_head');

$now=time();

$unique='sub_group_id';

$unique_field='sub_group_name';

$table='item_sub_group';

$page="item_sub_group_german.php";

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



$cy_id  = find_a_field('accounts_ledger','max(ledger_sl)','ledger_group_id='.$_POST['ledger_group'])+1;

$_POST['ledger_sl'] = sprintf("%04d", $cy_id);

$_POST['item_ledger'] = $_POST['ledger_group'].''.$_POST['ledger_sl'];

$gl_group = find_all_field('ledger_group','','group_id='.$_POST['ledger_group']); 

$_POST['ledger_name'] = $_POST['sub_group_name'];


$crud->insert();


$ledger_gl_found = find_a_field('accounts_ledger','ledger_id','ledger_name='.$_POST['ledger_name']);

if ($ledger_gl_found==0) {
     $acc_ins_led = 'INSERT INTO accounts_ledger (ledger_id, ledger_sl, ledger_name, ledger_group_id, acc_class, acc_sub_class, acc_sub_sub_class, opening_balance, balance_type, depreciation_rate, credit_limit, proj_id, budget_enable, group_for, parent, cost_center, entry_by, entry_at)
  
  VALUES("'.$_POST['item_ledger'].'", "'.$_POST['ledger_sl'].'", "'.$_POST['ledger_name'].'", "'.$_POST['ledger_group'].'", "'.$gl_group->acc_class.'", "'.$gl_group->acc_sub_class.'",
   "'.$gl_group->acc_sub_sub_class.'", "0", "Both", "0", "0", "'.$proj_id.'", "YES", "'.$gl_group->group_for.'", "0", "0", "'.$_POST['entry_by'].'", "'.$_POST['entry_at'].'")';

db_query($acc_ins_led);
}


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




    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-7">
                <div class="container p-0">
                    <form id="form1" name="form1" class="n-form1" method="post" action="">


                        <div class="form-group row m-0 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Product Group:</label>
                            <div class="col-sm-9 p-0">
                                <select name="item_group" id="item_group">
                                    <option ></option>
                                    <? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'1 order by group_name');?>
                                </select>

                            </div>
                        </div>


                        <div class="n-form-btn-class">
                            <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                            <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear" />
                        </div>

                    </form>
                </div>


                <div class="container n-form1">

<?php /*?>                    <?php

                    if($_SESSION['item_group']>0){

                    ?><?php */?>
					<!--test-->
                    
                    <table id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">

                        <thead>

                        <tr class="bgc-info">
                            <th><span>Product Group </span></th>
                            <th><span>Product  Category </span></th>
                            <th><span>Description</span></th>
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


            <?php /*?>        <?php }?><?php */?>



                </div>

            </div>


            <div class="col-sm-5">
                <form id="form1" name="form1" class="n-form" method="post" action="" onsubmit="return check()">
                    <h4 align="center" class="n-form-titel1">  <?=$title?> </h4>

                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Product Group</label>
                        <div class="col-sm-9 p-0">
                            <select name="group_id" id="group_id" required="required">
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

                        </div>
                    </div>

                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Product Category </label>
                        <div class="col-sm-9 p-0">

                            <input name="<?=$unique?>" type="hidden"  id="<?=$unique?>" value="<?=$$unique?>"  />

                            <input name="sub_group_name" type="text" id="sub_group_name" value="<?php echo $sub_group_name;?>" class="required" />
                            <input name="group_for" type="hidden" id="group_for" value="<?php echo $_SESSION['user']['group'];?>"  class="required" />
                            <? $_POST['entry_by'] = $_SESSION['user']['id'];?>

                            <input name="entry_by" type="hidden" required id="entry_by" tabindex="10" value="<?=$_POST['entry_by'];?>" />
                            <input name="entry_at" type="hidden" required id="entry_at" tabindex="10" value="<?=$now=date('Y-m-d H:i:s');?>" />


                        </div>
                    </div>
					
					
					<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">A/C Configuration: </label>
                        <div class="col-sm-9 p-0">

                            	<? if ($item_ledger==0) {?>
									<select name="ledger_group" required="required" id="ledger_group" tabindex="9">

										<option></option>
										<? foreign_relation('ledger_group','group_id','group_name',$ledger_group,'acc_sub_sub_class in(121,111)');?>
									</select>
								<? }?>

								<? if ($item_ledger>0) {?>
									<input name="item_ledger" type="text" id="item_ledger" tabindex="9" value="<?=$item_ledger?>"  readonly=""  />
								<? }?>


                        </div>
                    </div>
					
					
					<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">COGS Ledger: </label>
                        <div class="col-sm-9 p-0">

									<select name="cogs_ledger" id="cogs_ledger" tabindex="9">

										<option></option>
										<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$cogs_ledger,'ledger_group_id=411001');?>
									</select>
								


                        </div>
                    </div>

                    <div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Description </label>
                        <div class="col-sm-9 p-0">

                            <input name="description" type="text" id="description" value="<?php echo $description;?>" class="required" />

                        </div>
                    </div>

                    <div class="n-form-btn-class">
                        <? if($$unique<1){?>

                            <input name="record" type="submit" id="record" value="Save" onclick="return checkUserName()" class="btn1 btn1-bg-submit" />

                        <? }?>

                        <? if($$unique>0){?>

                            <input name="modify" type="submit" id="modify" value="update" class="btn1 btn1-bg-update" />

                        <? }?>

                        <input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/>

                        <!--                                      --><?// if($_SESSION['user']['level']==5){?>
                        <!---->
                        <!--                                        <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>-->
                        <!---->
                        <!--                                        --><?// }?>


                    </div>


                </form>




            </div>

        </div>




    </div>























<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="60%"><div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">



							<tr>

								    <td><div class="box">
                                            <form id="form1" name="form1" method="post" action="">
                                                <table width="100%" border="0" cellspacing="2" cellpadding="0">


									<tr>

                                        <td width="40%" align="right">  Product Group:     </td>

                                        <td width="60%" align="right">

										<select name="item_group" id="item_group" style="width:250px; float:left"  >

                                          <option ></option>
										  <? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'1 order by group_name');?>
                                        </select>

										</td>

                                      </tr>





                                      <tr>

                                        <td colspan="2">
                                            <div align="center">
                                              <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                                              <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />
                                            </div>
                                        </td>

                                      </tr>

                                    </table>

								    </form>

                                        </div>
                                    </td>

						      </tr>



								  <tr>

									<td style="padding-left:10px;line-height:9px;">

									<?php
				
									if($_SESSION['item_group']>0){
				
									?>

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

                    	<?php }?>
					

									<div id="pageNavPosition"></div>									</td>

								  </tr>

		</table>



	</div></td>

    <td valign="top" width="40%"><div class="right">
            <form id="form1" name="form1" method="post" action="" onsubmit="return check()">

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

                                        <input name="record" type="submit" id="record" value="Save" onclick="return checkUserName()" class="btn1 btn1-bg-submit" />

                                        <? }?></td>

                                      <td><? if($$unique>0){?>

                                        <input name="modify" type="submit" id="modify" value="Update" class="btn1 btn1-bg-update" />

                                        <? }?></td>

                                      <td><input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>

                                      <!--<td><? if($_SESSION['user']['level']==5){?>

                                        <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>

                                        <? }?></td>-->

                                    </tr>

                                  </table></td>

                                </tr>

                              </table>

    </form>

							</div>
    </td>

  </tr>

</table><?php */?>






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

require_once SERVER_CORE."routing/layout.bottom.php";

?>