<?php



session_start();



ob_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='Product Item Information';



$proj_id=$_SESSION['proj_id'];





$active='item';

$now=time();



$unique='item_id';



$unique_field='item_name';



$table='item_info';



$page="item_info_add.php";



$crud      =new crud($table);



$$unique = $_GET[$unique];











if(isset($_POST[$unique_field]))



{



$$unique = $_POST[$unique];



//for Record..................................



$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);



$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);







$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);







$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);



$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);



if(isset($_POST['record']))



{



$_POST['entry_at']=time();



$_POST['entry_by']=$_SESSION['user']['id'];







$min=number_format($_POST['sub_group_id'] + 1, 0, '.', '');



$max=number_format($_POST['sub_group_id'] + 10000, 0, '.', '');



$_POST[$unique]=number_format(next_value('item_id','item_info','1',$min,$min,$max), 0, '.', '');



$crud->insert();







$type=1;



$msg='New Entry Successfully Inserted.';







unset($_POST);



unset($$unique);



}







//for Modify..................................







if(isset($_POST['modify']))



{



		



$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);



$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);







$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);







$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);



$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);







		$_POST['edit_at']=time();



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



	foreach ($data as $key => $value){ $$key=$value;}



}











//for Modify..................................



if($_REQUEST['item_group']>0){$_SESSION['item_group'] = $_REQUEST['item_group'];}



if($_REQUEST['src_sub_group_id']>0){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}



if($_REQUEST['item_brand_n']!=""){$_SESSION['item_brand_n'] = $_REQUEST['item_brand_n'];}



if($_REQUEST['src_item_id']!=''){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}



if($_REQUEST['fg_code']!=''){$_SESSION['fg_code'] = $_REQUEST['fg_code'];$_SESSION['fg_code'] = $_REQUEST['fg_code'];}







if(isset($_REQUEST['cancel'])){unset($_SESSION['item_group']); unset($_SESSION['item_brand_n']); unset($_SESSION['src_sub_group_id']);unset($_SESSION['src_item_id']);unset($_SESSION['fg_code']);}









if($_SESSION['item_group']>0){



$item_group = $_SESSION['item_group'];



$con .='and b.group_id=g.group_id and g.group_id="'.$item_group.'" ';}







if($_SESSION['src_sub_group_id']>0){



$src_sub_group_id = $_SESSION['src_sub_group_id'];



$con .='and b.group_id=g.group_id and a.sub_group_id="'.$src_sub_group_id.'" ';}





if($_SESSION['item_brand_n'] !=""){



$item_brand_n = $_SESSION['item_brand_n'];



$con .='and b.group_id=g.group_id and a.item_brand="'.$item_brand_n.'" ';}





if($_SESSION['src_item_id']!=''){



$src_item_id = $_SESSION['src_item_id'];



$con .='and b.group_id=g.group_id and a.item_name like "%'.$src_item_id.'%" ';}







if($_SESSION['fg_code']>0){



$fg_code = $_SESSION['fg_code'];



$con .='and b.group_id=g.group_id and a.finish_goods_code="'.$fg_code.'" ';}



?>

<script type="text/javascript">



$(function() {



		$("#fdate").datepicker({



			changeMonth: true,



			changeYear: true,



			dateFormat: 'yy-mm-dd'



		});



});



function Do_Nav()



{



	var URL = 'pop_ledger_selecting_list.php';



	popUp(URL);



}







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



<table class="table table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="box">

        <form id="form1" name="form1" method="post" action="">

          <table width="100%" border="0" cellspacing="2" cellpadding="0">

            <!--<tr>



                                       <td width="40%" align="right"> Group:  </td>

                                       <td width="60%" align="right">



										<select name="item_group" id="item_group"><option></option>



											<?php



												$g2="select group_id, group_name from item_group";



												//echo $a2;



												$g1=db_query($g2);







												while($g=mysqli_fetch_row($g1))



												{



												if($g[0]==$item_group)



												echo "<option value=\"".$g[0]."\" selected>".$g[1]."</option>";



												else



												echo "<option value=\"".$g[0]."\">".$g[1]."</option>";



												}



												?>

												</select>

												</td>

												

                                      </tr>-->

            <tr>

              <td width="40%" align="right"> Sub Group:</td>

              <td width="60%" align="left"><select name="src_sub_group_id" class="form-control" style="max-width:250px;" id="src_sub_group_id">

                  <option></option>

                  <?php



$a2="select sub_group_id, sub_group_name from item_sub_group";



//echo $a2;



$a1=db_query($a2);







while($a=mysqli_fetch_row($a1))



{



if($a[0]==$src_sub_group_id)



echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";



else



echo "<option value=\"".$a[0]."\">".$a[1]."</option>";



}



?>

                </select></td>

            </tr>

            <!-- <tr>

                                        <td align="right">Micro Segment :</td>

										

                                        <td align="right"><select name="item_brand_n" id="item_brand_n">

                                            <option value="">

                                            </option>

                                            <option value="Jasmin Coconut Oil Tin" <?= ($_REQUEST['item_brand_n']=="Jasmin Coconut Oil Tin")?"selected":""?>>Jasmin Coconut Oil Tin</option>

                                            <option value="Jasmin Nonsticky Hair Oil" <?= ($_REQUEST['item_brand_n']=="Jasmin Nonsticky Hair Oil")?"selected":""?>>Jasmin Nonsticky Hair Oil </option>

                                            <option value="Jasmin Vaseline"<?= ($_REQUEST['item_brand_n']=="Jasmin Vaseline")?"selected":""?>>Jasmin Vaseline</option>

                                            <option value="Jasmin Lipgel"<?= ($_REQUEST['item_brand_n']=="Jasmin Lipgel")?"selected":""?>>Jasmin Lipgel</option>

                                            <option value="Jasmin Lip Bam"<?= ($_REQUEST['item_brand_n']=="Jasmin Lip Bam")?"selected":""?>>Jasmin Lip Bam</option>

                                            <option value="Jasmin Pomade"<?= ($_REQUEST['item_brand_n']=="Jasmin Pomade")?"selected":""?>>Jasmin Pomade</option>

                                            <option value="Jasmin Glycerin"<?= ($_REQUEST['item_brand_n']=="Jasmin Glycerin")?"selected":""?>>Jasmin Glycerin</option>

                                            <option value="Jasmin Glycerin N"<?= ($_REQUEST['item_brand_n']=="Jasmin Glycerin N")?"selected":""?>>Jasmin Glycerin N</option>

                                            <option value="Jasmin Glycerin N.T"<?= ($_REQUEST['item_brand_n']=="Jasmin Glycerin N.T")?"selected":""?>>Jasmin Glycerin N.T</option>

                                            <option value="Jasmin Acqua Glycerin"<?= ($_REQUEST['item_brand_n']=="Jasmin Acqua Glycerin")?"selected":""?>>Jasmin Acqua Glycerin</option>

                                            <option value="Jasmin Talcum Powder"<?= ($_REQUEST['item_brand_n']=="Jasmin Talcum Powder")?"selected":""?>>Jasmin Talcum Powder</option>

                                            <option value="Jasmin Luxary Talcum Powder"<?= ($_REQUEST['item_brand_n']=="Jasmin Luxary Talcum Powder")?"selected":""?>>Jasmin Luxary Talcum Powder</option>

                                            <option value="Jasmin Pricklyheat Powder"<?= ($_REQUEST['item_brand_n']=="Jasmin Pricklyheat Powder")?"selected":""?>>Jasmin Pricklyheat Powder</option>

                                            <option value="Super Cool Pricklyheat Powder"<?= ($_REQUEST['item_brand_n']=="Super Cool Pricklyheat Powder")?"selected":""?>>Super Cool Pricklyheat Powder</option>

                                            <option value="Jasmin Power White"<?= ($_REQUEST['item_brand_n']=="Jasmin Power White")?"selected":""?>>Jasmin Power White</option>

                                            <option value="Jasmin Detergent Powder"<?= ($_REQUEST['item_brand_n']=="Jasmin Detergent Powder")?"selected":""?>>Jasmin Detergent Powder </option>

                                            <option value="Jasmin Laundry Soap"<?= ($_REQUEST['item_brand_n']=="Jasmin Laundry Soap")?"selected":""?>>Jasmin Laundry Soap</option>

                                            <option value="Jasmin Nailpolish Remover"<?= ($_REQUEST['item_brand_n']=="Jasmin Nailpolish Remover")?"selected":""?>>Jasmin Nailpolish Remover</option>

                                            <option value="Neat Hair Remover"<?= ($_REQUEST['item_brand_n']=="Neat Hair Remover")?"selected":""?>>Neat Hair Remover</option>

                                            <option value="Jasmin Hair Oil"<?= ($_REQUEST['item_brand_n']=="Jasmin Hair Oil")?"selected":""?>>Jasmin Hair Oil </option>

                                            <option value="Jasmin Super  Soap  Box"<?= ($_REQUEST['item_brand_n']=="Jasmin Super  Soap  Box")?"selected":""?>>Jasmin Super  Soap  Box</option>

                                            <option value="Jasmin Fairness Soap"<?= ($_REQUEST['item_brand_n']=="Jasmin Fairness Soap")?"selected":""?>>Jasmin Fairness Soap</option>

                                            <option value="Jasmin Beauty Soap Box"<?= ($_REQUEST['item_brand_n']=="Jasmin Beauty Soap Box")?"selected":""?>>Jasmin Beauty Soap Box</option>

                                            <option value="Jasmin Sandal Soap"<?= ($_REQUEST['item_brand_n']=="Jasmin Sandal Soap")?"selected":""?>>Jasmin Sandal Soap</option>

                                            <option value="Jasmin Attar"<?= ($_REQUEST['item_brand_n']=="Jasmin Attar")?"selected":""?>>Jasmin Attar</option>

                                            <option value="Jasmin Attar New"<?= ($_REQUEST['item_brand_n']=="Jasmin Attar New")?"selected":""?>>Jasmin Attar New</option>

                                            <option value="Jasmin Darshan Agarbati"<?= ($_REQUEST['item_brand_n']=="Jasmin Darshan Agarbati")?"selected":""?>>Jasmin Darshan Agarbati </option>

                                            <option value="Jasmin Mahendi Gold"<?= ($_REQUEST['item_brand_n']=="Jasmin Mahendi Gold")?"selected":""?>>Jasmin Mahendi Gold</option>

                                            <option value="Just Hair Color Tube Black"<?= ($_REQUEST['item_brand_n']=="Just Hair Color Tube Black")?"selected":""?>>Just Hair Color Tube Black</option>

                                            <option value="Just Hair Color Shache (Black)"<?= ($_REQUEST['item_brand_n']=="Just Hair Color Shache (Black)")?"selected":""?>>Just Hair Color Shache (Black)</option>

                                            <option value="Just Hair Color Shache (Brown)"<?= ($_REQUEST['item_brand_n']=="Just Hair Color Shache (Brown)")?"selected":""?>>Just Hair Color Shache (Brown)</option>

                                            <option value="Just Hair Dai Black"<?= ($_REQUEST['item_brand_n']=="Just Hair Dai Black")?"selected":""?>>Just Hair Dai Black</option>

                                            <option value="Extreme Perfume"<?= ($_REQUEST['item_brand_n']=="Extreme Perfume")?"selected":""?>>Extreme Perfume</option>

                                            <option value="Jasmin Perfume"<?= ($_REQUEST['item_brand_n']=="Jasmin Perfume")?"selected":""?>>Jasmin Perfume</option>

                                            <option value="Gift Perfume"<?= ($_REQUEST['item_brand_n']=="Gift Perfume")?"selected":""?>>Gift Perfume</option>

                                            <option value="Orchid Perfume"<?= ($_REQUEST['item_brand_n']=="Orchid Perfume")?"selected":""?>>Orchid Perfume</option>

                                            <option value="Angel Perfume"<?= ($_REQUEST['item_brand_n']=="Angel Perfume")?"selected":""?>>Angel Perfume</option>

                                            <option value="Spider Coil (Large)"<?= ($_REQUEST['item_brand_n']=="Spider Coil (Large)")?"selected":""?>>Spider Coil (Large)</option>

                                            <option value="Just Baby Lotion"<?= ($_REQUEST['item_brand_n']=="Just Baby Lotion")?"selected":""?>>Just Baby Lotion</option>

                                            <option value="Just Aftershave Lotion"<?= ($_REQUEST['item_brand_n']=="Just Aftershave Lotion")?"selected":""?>>Just Aftershave Lotion</option>

                                            <option value="Jasmin Mustard Oil"<?= ($_REQUEST['item_brand_n']=="Jasmin Mustard Oil")?"selected":""?>>Jasmin Mustard Oil</option>

                                            <option value="Just Mazoni (Spring)"<?= ($_REQUEST['item_brand_n']=="Just Mazoni (Spring)")?"selected":""?>>Just Mazoni (Spring)</option>

                                            <option value="Just Mazoni (Net)"<?= ($_REQUEST['item_brand_n']=="Just Mazoni (Net)")?"selected":""?>>Just Mazoni (Net)</option>

                                            <option value="Just Tooth Powder"<?= ($_REQUEST['item_brand_n']=="Just Tooth Powder")?"selected":""?>>Just Tooth Powder</option>

                                            <option value="Just Bulb (Clear)"<?= ($_REQUEST['item_brand_n']=="Just Bulb (Clear)")?"selected":""?>>Just Bulb (Clear)</option>

                                            <option value="Just Energy Saving Lamp"<?= ($_REQUEST['item_brand_n']=="Just Energy Saving Lamp")?"selected":""?>>Just Energy Saving Lamp</option>

                                        </select></td>

                                      </tr>-->

            <tr>

              <td align="right">Item Name: </td>

              <td align="left"><input name="src_item_id" style="max-width:250px;" type="text" id="src_item_id" value="<?php echo $_SESSION['src_item_id']; ?>" size="30" /></td>

            </tr>

            <tr>

              <td align="right">Finish Goods Code: </td>

              <td align="left"><input name="fg_code" style="max-width:250px;" type="text" id="fg_code" value="<?php echo $_SESSION['fg_code']; ?>" size="30" /></td>

            </tr>

            <tr>

              <td colspan="2" class="text-center"><input class="btn" name="search" type="submit" id="search" value="Show" />

                <input class="btn" name="cancel" type="submit" id="cancel" value="Cancel" /></td>

            </tr>

          </table>

        </form>

      </div></td>

  </tr>

 

  <tr>

    <td><?



if($_SESSION['item_group']>0 || $_SESSION['src_sub_group_id']>0 || $_SESSION['src_item_id']!='' || $_SESSION['item_brand_n'] !='' || $_SESSION['fg_code']>0){



?>

<table class="table table-bordered" border="0" cellspacing="0" cellpadding="0" id="data_table_inner" class="display" >
<thead>
        <tr>

          <th>FG Code </th>

          <th>Item Name</th>

          <th>Sub Group</th>

          <th>Item Details</th>

        </tr>
</thead><tbody>
        <?php



$td="select a.item_id,a.item_name,b.sub_group_name,  a.item_description,a.finish_goods_code FROM item_info a, item_sub_group b, item_group g where b.sub_group_id=a.sub_group_id ".$con." order by a.finish_goods_code";

//echo $td;

$report=db_query($td);



while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

        <tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

          <td><?=$rp[4];?></td>

          <td><?=$rp[1];?></td>

          <td><?=$rp[2];?></td>

          <td><?=$rp[3];?></td>

        </tr>

        <?php }?>
</tbody>
      </table>

      <? }?>



  </tr>

</table>


<?



$main_content=ob_get_contents();



ob_end_clean();



include ("../../template/main_layout2.php");



?>

