<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Opening Stock Adjustment  ';
$tr_type="Show";
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

var warehouse_id=(document.getElementById('warehouse_id').value);
var oqty=(document.getElementById('oqty_'+id).value)*1; 
var orate=(document.getElementById('orate_'+id).value)*1; 
var orate1=(document.getElementById('orate1_'+id).value)*1; 
var odate=(document.getElementById('odate').value); 
var flag=(document.getElementById('flag_'+id).value); 
var sub_group =(document.getElementById('sub_group').value);
var group_for = (document.getElementById('group_for_get').value);
var ledger_id = (document.getElementById('ledger_id_'+id).value);

var strURL="opening_balance_adjustment_ajax.php?item_id="+item_id+"&oqty="+oqty+"&orate="+orate+"&orate1="+orate1+"&odate="+odate+"&warehouse_id="+warehouse_id+"&flag="+flag+"&sub_group="+sub_group+"&group_for="+group_for+"&ledger_id="+ledger_id;

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

</script>






  <div class="form-container_large">
    <form action="" method="post" name="codz" id="codz">

      <div class="container-fluid bg-form-titel">
        <div class="row">
          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <?
            if(isset($_POST['odate']))
              $odate = $_SESSION['odate'] = $_POST['odate'];
            elseif($_SESSION['odate']!='')
              $odate = $_SESSION['odate'];
            else
              $odate = date('Y-m-d');

            ?>
            <div class="form-group row m-0">
              <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Audit Date:	</label>
              <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                <input name="odate" type="text" id="odate" style="width:100px;" value="<?=$odate?>"  readonly/>

              </div>
            </div>

          </div>
          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <div class="row">
            <div class="form-group row m-0">
                  <label class="col-sm-6 col-md-6 col-lg-6 col-xl-6 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sub Group:</label>
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">
                    <select name="sub_group" id="sub_group">

                      <?
                      foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'1');
                      ?>
                    </select>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <div class="row">
            <div class="form-group row m-0">
                  <label class="col-sm-6 col-md-6 col-lg-6 col-xl-6 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse :</label>
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">
                    <select name="warehouse_id" id="warehouse_id" required="required">
                   
					
					
					<option></option>
                  <? foreign_relation('warehouse w, warehouse_define d','w.warehouse_id','w.warehouse_name',$_POST['warehouse_id'],'w.warehouse_id=d.warehouse_id and d.user_id="'.$_SESSION['user']['id'].'" and d.status="Active"');?>
                    </select>


                  </div>
                </div>
            </div>
          </div>
          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <div class="row">
            <div class="form-group row m-0">
                  <label class="col-sm-6 col-md-6 col-lg-6 col-xl-6 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company:</label>
                  <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 p-0">
                  <select name="group_for" id="group_for" required>
                  
				  
				  
				  
				  	<option></option>
                  <? foreign_relation('user_group w, company_define d','w.id','w.group_name',$_POST['group_for'],'w.id=d.company_id and d.user_id="'.$_SESSION['user']['id'].'" and d.status="Active"');?>
                    </select>
				  
                  </div>
                </div>
            </div>
          </div>
          <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <input type="submit" name="submitit" id="submitit" value="Open Item" class="btn1 btn1-submit-input"/>

          </div>

        </div>
      </div>



      <?
      if($_POST['sub_group']>0){
      ?>
      <!--Table start-->
      <div class="container-fluid pt-5 p-0 ">

        <table class="table1  table-striped table-bordered table-hover table-sm">
          <thead class="thead1">
          <tr class="bgc-info">
            <th>Item Code </th>
            <th>Item Name </th>
            <th>Unit</th>
            <th>Pre Stock </th>
            <th>Adjustment</th>
            <th>Ledger</th>
            <th>Rate/Unit</th>
            <th>New Stock </th>
            <th>Action</th>
          </tr>
          </thead>

          <tbody class="tbody1">

          <?


          //if($_POST['warehouse_id']!='')
          //$con.=' and warehouse_id = "'.$_POST['warehouse_id'].'"';


          $sql = "select * from item_info where sub_group_id=".$_POST['sub_group']."   order by finish_goods_code,item_name";
          $query = db_query($sql);
          while($data=mysqli_fetch_object($query)){$i++;

            $stock=find_a_field('journal_item','sum(item_in)-sum(item_ex)','warehouse_id="'.$_POST['warehouse_id'].'" and item_id = "'.$data->item_id.'" and ji_date<="'.$_POST['odate'].'" and tr_from!="Opening Adjustment" ');

            $ssql = 'select item_price, item_in-item_ex as unit_qty from journal_item where warehouse_id="'.$_POST['warehouse_id'].'" and item_id = "'.$data->item_id.'" and tr_from="Opening Adjustment" and
ji_date="'.$_POST['odate'].'"';
            $ssssql = @db_query($ssql);
            $flag = mysqli_num_rows($ssssql);
            $sss = @mysqli_fetch_object(($ssssql));
            $adjustment = $sss->unit_qty;
            $adjustment_rate = $sss->item_price;
            ?>
            <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
              <td><?=$data->finish_goods_code?></td>
              <td><?=$data->item_name?></td>
              <td><?=$data->unit_name?></td>
              <td><?=$stock;?>
              </td>

              <td><input list="ledger_ids" name="ledger_id_<?=$data->item_id?>" id="ledger_id_<?=$data->item_id?>"  autocomplete="off" required />
                <datalist id="ledger_ids">
                  <option></option>
                  <? foreign_relation('accounts_ledger','ledger_id','ledger_name','1');?>
                </datalist>
              </td>

              <td><?=$adjustment;?><input type="hidden" name="orate_<?=$data->item_id?>" id="orate_<?=$data->item_id?>" value="<?=($stock)?>" /></td>



              <td><input type="text" name="orate1_<?=$data->item_id?>" id="orate1_<?=$data->item_id?>" value="<?=($_SESSION['user']['depot']!=5&&$adjustment_rate==0)?$data->f_price:number_format($adjustment_rate,4);?>" /></td>

              <td><input name="oqty_<?=$data->item_id?>" id="oqty_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=($stock+$adjustment)?>"  /></td>

              <td>
                <span id="divi_<?=$data->item_id?>">
            <?
            if($adjustment_rate>0||$adjustment>0)
            {?>
              <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
              <input type="button" name="Button" value="Edit"  class="btn1 btn1-bg-update" onclick="update_value(<?=$data->item_id?>)"/><?
            }
            else
            {
              ?>
              <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
              <input type="button" name="Button" value="Save"  class="btn1 btn1-bg-submit" onclick="update_value(<?=$data->item_id?>)"/><? }?>
          </span>&nbsp;</td>
            </tr>
          <? }?>


          </tbody>
        </table>



      </div>
      <? }?>
	    <input name="group_for_get" type="hidden" id="group_for_get" style="width:100px;" value="<?=$_POST['group_for'];?>"  readonly/>
    </form>
  </div>




<?/*>
  <br/>
<br/>
<br/>
<br/>
<br/>

<div class="form-container_large">
<form action="" method="post" name="codz" id="codz">
<table width="80%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?
  if(isset($_POST['odate']))
  $odate = $_SESSION['odate'] = $_POST['odate'];
  elseif($_SESSION['odate']!='')
  $odate = $_SESSION['odate'];
  else
  $odate = date('Y-m-d');
  
  ?>

  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Audit Date: </strong></td>
    <td bgcolor="#FF9966"><input name="odate" type="text" id="odate" style="width:100px;" value="<?=$odate?>" />
    </td>
    <td bgcolor="#FF9966">&nbsp;</td>
  </tr>

  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Select Product Sub Group: </strong></td>
    <td bgcolor="#FF9966">
	<select name="sub_group" id="sub_group">
	
<?
foreign_relation('item_sub_group','sub_group_id','sub_group_name',$_POST['sub_group'],'1');
?>
    </select>    </td>

    <td rowspan="2" bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="Open Item" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FF9966"><strong>Warehouse</strong>:</td>
    <td bgcolor="#FF9966"><strong>
      <select name="warehouse_id" id="warehouse_id" required="required">
        <option></option>
        <?
foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1');
?>
      </select>
    </strong></td>
  </tr>
</table>
<br /><br />

<?
if($_POST['sub_group']>0){
?>
<div class="tabledesign2" style="width:100%">
<table width="100%" border="0" align="center" id="grp" cellpadding="0" cellspacing="0">
  <tr>
    <th><div align="center">Item Code </div></th>
    <th><div align="center">Item Name </div></th>
    <th>Unit</th>
    <th><div align="center">Pre Stock </div></th>
    <th><div align="center">Adjustment</div></th>
    <th><div align="center">Rate/Unit</div></th>
    <th><div align="center">New Stock </div></th>
    <th><div align="center">Action</div></th>
  </tr>

  <?
  
  
  	//if($_POST['warehouse_id']!='')
	//$con.=' and warehouse_id = "'.$_POST['warehouse_id'].'"';
  
  
$sql = "select * from item_info where sub_group_id=".$_POST['sub_group']."   order by finish_goods_code,item_name";
  $query = db_query($sql);
  while($data=mysqli_fetch_object($query)){$i++;
  
$stock=find_a_field('journal_item','sum(item_in)-sum(item_ex)','warehouse_id="'.$_POST['warehouse_id'].'" and item_id = "'.$data->item_id.'" and ji_date<="'.$_POST['odate'].'" and tr_from!="Opening Adjustment" ');

$ssql = 'select item_price, item_in-item_ex as unit_qty from journal_item where warehouse_id="'.$_POST['warehouse_id'].'" and item_id = "'.$data->item_id.'" and tr_from="Opening Adjustment" and 
ji_date="'.$_POST['odate'].'"';
$ssssql = @db_query($ssql);
$flag = mysqli_num_rows($ssssql);
$sss = @mysqli_fetch_object(($ssssql));
 $adjustment = $sss->unit_qty;
$adjustment_rate = $sss->item_price;
  ?>
  <tr bgcolor="<?=($i%2)?'#E8F3FF':'#fff';?>">
    <td><?=$data->finish_goods_code?></td>
    <td><?=$data->item_name?></td>
    <td><?=$data->unit_name?></td>
    <td><?=$stock;?>
      </td>
    <td><?=$adjustment;?><input type="hidden" name="orate_<?=$data->item_id?>" id="orate_<?=$data->item_id?>" value="<?=($stock)?>" style="width:70px;"/></td>
    <td><input name="orate1_<?=$data->item_id?>" id="orate1_<?=$data->item_id?>" value="<?=($_SESSION['user']['depot']!=5&&$adjustment_rate==0)?$data->f_price:number_format($adjustment_rate,4);?>" style="width:70px;"/></td>
    <td><input name="oqty_<?=$data->item_id?>" id="oqty_<?=$data->item_id?>" type="text" size="10" maxlength="10" value="<?=($stock+$adjustment)?>" style="width:60px;" /></td>
    <td><span id="divi_<?=$data->item_id?>">
            <? 
			  if($adjustment_rate>0||$adjustment>0)
			  {?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
			  <input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:30px; background-color:#FF3366"/><?
			  }
			  else
			  {
			  ?>
			  <input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
			  <input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" style="width:40px; height:30px;background-color:#66CC66"/><? }?>
          </span>&nbsp;</td>
  </tr>
  <? }?>
</table>
</div>
<? }?>
<p>&nbsp;</p>
</form>
</div>

  <*/?>



<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>