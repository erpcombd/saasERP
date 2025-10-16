<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$tr_type="Show";
$title='Opening Balance Setup';
do_calander('#odate');

$tr_from="Warehouse";
?>

<script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }



	function update_value(id)



	{



var item_id=id; // Rent

var opkt=(document.getElementById('opkt_'+id).value)*1;

var opic=(document.getElementById('opic_'+id).value)*1;

var opkt_sz=(document.getElementById('opkt_sz_'+id).value)*1;



var orate=(document.getElementById('orate_'+id).value)*1; 

var odate=(document.getElementById('odate').value); 

var flag=(document.getElementById('flag_'+id).value); 

if(opkt>0 || opic>0){
if(opkt>0 && (opkt_sz==0 || opkt_sz=='')){
 
 alert("This product haven't any pack size so cartoon qty can't taken!");
 document.getElementById('opkt_'+id).value = 0;

}else{

var strURL="opening_balance_fg_ajax.php?item_id="+item_id+"&opkt="+opkt+"&opic="+opic+"&opkt_sz="+opkt_sz+"&orate="+orate+"&odate="+odate+"&flag="+flag;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	

}
}else{
alert('Qty should not be empty!');
}
}



</script>






  <div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">
      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Opening Date</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <input name="odate" type="text" id="odate"  value="<?=$_POST['odate']?>" required autocomplete="off"/>
              </div>
            </div>

          </div>
          <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
            <div class="form-group row m-0">
              <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Product Sub Group</label>
              <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                <select name="sub_group" id="sub_group">

                  <option></option>


                  <?

                  foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'1 and group_for="'.$_SESSION['user']['group'].'"');

                  ?>
                </select>

              </div>
            </div>
          </div>

          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <input type="submit" name="submitit" id="submitit" value="Open Balance" class="btn1 btn1-submit-input" />
          </div>

        </div>
      </div>






<!--      Start Table code hear-->
      <div class="container-fluid pt-5 p-0 ">



        <?

        if($_POST['sub_group']>0){

          ?>


<!--        Table start hear-->
        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
          <tr class="bgc-info">
            <th>FC</th>
            <th>Item Name</th>
            <th>PKU</th>

            <th>PCU</th>
            <th>PKS</th>
            <th>PQty</th>

            <th>PRate</th>
            <th>Crt</th>
            <th>Pcs</th>
            <th>ORate</th>
            <th>Action</th>
          </tr>
          </thead>

          <tbody class="tbody1">


          <?

          $sql = "select distinct item_id,item_price,item_in,item_ex from journal_item where warehouse_id='".$_SESSION['user']['depot']."' and tr_from = 'Opening' ";

          $query = db_query($sql);

          while($data=mysqli_fetch_object($query)){

            $item_price[$data->item_id] = $data->item_price;

            $item_in[$data->item_id] = $data->item_in;

            $item_ex[$data->item_id] = $data->item_ex;

          }



          $sql = "select * from item_info where  sub_group_id=".$_POST['sub_group'];

          $query = db_query($sql);

          while($data=mysqli_fetch_object($query)){$i++;

            $opkt_sz=$data->pack_size;

            $final_stock = $item_in[$data->item_id] - $item_ex[$data->item_id];

            $final_price = $item_price[$data->item_id];
if($data->pack_size>0){
    
     $opkt = (int)($final_stock/$data->pack_size);
      $opic = @($final_stock%$data->pack_size);
}
else{
    $opkt=0;
     $opic=0;
}
             

           

            ?>

            <tr>

              <td><?=$data->finish_goods_code;?></td>

              <td style="text-align:left"><?=$data->item_name?></td>

              <td><?=$data->pack_unit?></td>

              <td><?=$data->unit_name?></td>

              <td><?=$data->pack_size;?></td>

              <td><?=number_format($final_stock,2);?></td>

              <td><?=number_format($final_price,2);?></td>

              <td><input name="opkt_<?=$data->item_id?>" id="opkt_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$opkt;?>"  /></td>

              <td>
                <input name="opic_<?=$data->item_id?>" id="opic_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$opic?>"  />
                <input name="opkt_sz_<?=$data->item_id?>" id="opkt_sz_<?=$data->item_id?>" type="hidden" size="10" maxlength="10" value="<?=$opkt_sz;?>"/>
              </td>

              <td><input name="orate_<?=$data->item_id?>" id="orate_<?=$data->item_id?>" type="text"  size="10" maxlength="10" value="<? if($_SESSION['user']['depot']==5) echo number_format($data->p_price,2); else echo number_format($data->f_price,2);?>" /></td>

              <td>
                <span id="divi_<?=$data->item_id?>">

            <?

            if(($op->id>0)&&($op->id==$info->id))

            {?>

              <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />

              <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" class="btn1 btn1-bg-update" /><?

            }

            elseif($info->id<1)

            {

              ?>

              <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />

              <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" class="btn1 btn1-bg-submit"/><? }?>

          </span>
              </td>

            </tr>

          <? }?>



          </tbody>
        </table>


        <? }?>


      </div>
    </form>
  </div>



















  <?php /*?><div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>
  </tr>



  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Opening Date: </strong></td>

    <td bgcolor="#FF9966">
      <input name="odate" type="text" id="odate" style="width:107px; background-color:white;" value="<?=$_POST['odate']?>" required />
    </td>

    <td rowspan="2" bgcolor="#FF9966"><strong>

      <input type="submit" name="submitit" id="submitit" value="Open Balance" class="btn1 btn1-submit-input" />

    </strong></td>
  </tr>

  <tr>

    <td align="right" bgcolor="#FF9966"><strong>Product Sub Group: </strong></td>

    <td bgcolor="#FF9966">

	<select name="sub_group" id="sub_group">
    
	<option></option>
	

<?

foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'1');

?>
    </select>

    </td>
    </tr>
</table>

<br /><br />

<?

if($_POST['sub_group']>0){

?>

<div class="tabledesign2" style="width:100%">

<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">

  <tr>

    <th><div align="center">FC</div></th>

    <th><div align="center">Item Name </div></th>

    <th>PKU</th>

    <th>PCU</th>

    <th>PKS</th>

    <th><div align="center">PQty</div></th>

    <th><div align="center">PRate</div></th>

    <th><div align="center">Crt</div></th>

    <th><div align="center">Pcs</div></th>

    <th><div align="center">ORate</div></th>

    <th><div align="center">Action</div></th>

  </tr>

  <?

  $sql = "select distinct item_id,item_price,item_in,item_ex from journal_item where warehouse_id='".$_SESSION['user']['depot']."' and tr_from = 'Opening' ";

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){

  $item_price[$data->item_id] = $data->item_price;

  $item_in[$data->item_id] = $data->item_in;

  $item_ex[$data->item_id] = $data->item_ex;

  }

  

  $sql = "select * from item_info where finish_goods_code!=2002 and sub_group_id=".$_POST['sub_group'];

  $query = db_query($sql);

  while($data=mysqli_fetch_object($query)){$i++;

  $opkt_sz=$data->pack_size;

  $final_stock = $item_in[$data->item_id] - $item_ex[$data->item_id];

  $final_price = $item_price[$data->item_id];

  $opkt = (int)@($final_stock/$data->pack_size);

  $opic = @($final_stock%$data->pack_size)

  ?>

  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">

    <td><?=($data->finish_goods_code>0)?$data->finish_goods_code:'';?></td>

    <td><?=$data->item_name?></td>

    <td><?=$data->pack_unit?></td>

    <td><?=$data->unit_name?></td>

    <td><?=$data->pack_size;?></td>

    <td><?=number_format($final_stock,2);?></td>

    <td><?=number_format($final_price,2);?></td>

    <td><input name="opkt_<?=$data->item_id?>" id="opkt_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$opkt;?>" style="width:100px;" /></td>

    <td><input name="opic_<?=$data->item_id?>" id="opic_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=$opic?>" style="width:100px;" />

	    <input name="opkt_sz_<?=$data->item_id?>" id="opkt_sz_<?=$data->item_id?>" type="hidden" size="10" maxlength="10" value="<?=$opkt_sz;?>"/></td>

    <td><input name="orate_<?=$data->item_id?>" id="orate_<?=$data->item_id?>" type="text"  size="10" maxlength="10" value="<? if($_SESSION['user']['depot']==5) echo number_format($data->p_price,2); else echo number_format($data->f_price,2);?>" style="width:100px;" /></td>

    <td><span id="divi_<?=$data->item_id?>">

            <? 

			  if(($op->id>0)&&($op->id==$info->id))

			  {?>

			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />

			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" class="btn1 btn1-bg-update" /><?

			  }

			  elseif($info->id<1)

			  {

			  ?>

			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />

			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" class="btn1 btn1-bg-submit"/><? }?>

          </span>&nbsp;</td>

  </tr>

  <? }?>

</table>

</div>

<? }?>

<p>&nbsp;</p>

</form>

</div><?php */?>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>