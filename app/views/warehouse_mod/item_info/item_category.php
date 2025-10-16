<?php




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Product Category';
$proj_id=$_SESSION['proj_id'];
do_datatable('table_head');
$now=time();
$unique='id';
$unique_field='category_name';
$table='item_category';
$page="item_category.php";
$crud      =new crud($table);
$$unique = $_GET[$unique];




if(isset($_POST[$unique_field])){

$$unique = $_POST[$unique];


if(isset($_POST['record'])){


$crud->insert();


$type=1;
$msg='New Entry Successfully Inserted.';

unset($_POST);
unset($$unique);
}



if(isset($_POST['modify'])){

		//$_POST['edit_at']=date('Y-m-d H:i:s');

		//$_POST['edit_by']=$_SESSION['user']['id'];
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
}





//for Delete..................................

if(isset($_POST['delete2'])){		

		$condition=$unique."=".$$unique;
		$crud->delete($condition);
		unset($$unique);
		$type=1;
		$msg='Successfully Deleted.';

}


}



if(isset($$unique)){


$condition=$unique."=".$$unique;	
$data=db_fetch_object($table,$condition);
foreach ($data as $key => $value)
{ $$key=$value;}
}



?>



<script type="text/javascript">


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

<div class="container n-form1">

                    
                    <table id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">

                        <thead>

                        <tr class="bgc-info">
                            <th><span>Product Group </span></th>
                            <th><span>Product  Category </span></th>
                        </tr>
                        </thead>

                        <tbody>

<?php
//if($_POST['item_group']!='') $con .= ' and b.group_id = "'.$_POST['item_group'].'" ';

        $rrr = "select b.id,a.group_name,b.category_name 
                        from item_category b,item_group a 
                        where 1 and a.group_id=b.group_id   order by b.id,b.category_name";

                        $report = db_query($rrr);

                        $i=0;

                        while($rp=mysqli_fetch_object($report)){$i++; ?>

                            <tr<?=$cls?> onclick="DoNav('<?php echo $rp->id;?>');">
                                <td><?=$rp->group_name;?></td>
                                <td><?=$rp->category_name;?></td>
                            </tr>

                        <?php }?>
                        </tbody>
                    </table>

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

<? $sql="select * from item_group where 1 order by group_id";
$query=db_query($sql);
while($datas=mysqli_fetch_object($query)){
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
        <input name="category_name" type="text" id="category_name" value="<?php echo $category_name;?>" class="required" />

    </div>
</div>



<div class="form-group row m-0 pl-3 pr-3">
    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Company</label>
    <div class="col-sm-9 p-0">

        <input name="<?=$unique?>" type="hidden"  id="<?=$unique?>" value="<?=$$unique?>"  />
        <select id="group_for" name="group_for" required >
										<? user_company_access($group_for) ?>
									</select>

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