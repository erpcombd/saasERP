<?php

session_start();

ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
$tr_type = "Show";
$title = 'Opening Balance Setup';
do_calander('#odate');

$tr_from = "Warehouse";
?>

<script>
  function getXMLHTTP() { //fuction to return the xml http object



    var xmlhttp = false;



    try {



      xmlhttp = new XMLHttpRequest();



    } catch (e) {



      try {



        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

      } catch (e) {



        try {



          xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



        } catch (e1) {



          xmlhttp = false;



        }



      }



    }







    return xmlhttp;



  }



  function update_value(id)



  {



    var item_id = id; // Rent

    var opkt = (document.getElementById('opkt_' + id).value) * 1;

    var opic = (document.getElementById('opic_' + id).value) * 1;

    var opkt_sz = (document.getElementById('opkt_sz_' + id).value) * 1;

    var warehouse_id = (document.getElementById('warehouse_id').value) * 1;

    var orate = (document.getElementById('orate_' + id).value) * 1;

    var odate = (document.getElementById('odate').value);

    var group_for = (document.getElementById('group_for').value);

    var sub_group = (document.getElementById('sub_group').value);

    var flag = (document.getElementById('flag_' + id).value);
    if (warehouse_id > 0) {
      if (orate > 0) {
        if (opkt > 0 || opic > 0) {
          if (opkt > 0 && (opkt_sz == 0 || opkt_sz == '')) {

            alert("This product haven't any pack size so cartoon qty can't taken!");
            document.getElementById('opkt_' + id).value = 0;

          } else {

            var strURL = "opening_balance_fg_ajax.php?item_id=" + item_id + "&opkt=" + opkt + "&opic=" + opic + "&opkt_sz=" + opkt_sz + "&orate=" + orate + "&odate=" + odate + "&flag=" + flag + "&warehouse_id=" + warehouse_id + "&group_for=" + group_for+"&sub_group="+sub_group;



            var req = getXMLHTTP();



            if (req) {



              req.onreadystatechange = function() {

                if (req.readyState == 4) {

                  // only if "OK"

                  if (req.status == 200) {

                    document.getElementById('divi_' + id).style.display = 'inline';

                    document.getElementById('divi_' + id).innerHTML = req.responseText;

                  } else {

                    alert("There was a problem while using XMLHTTP:\n" + req.statusText);

                  }

                }

              }

              req.open("GET", strURL, true);

              req.send(null);

            }

          }
        } else {
          alert('Qty should not be empty!');
        }
      } else {
        alert('Price Should Not Empty!');
      }
    } else {
      alert('Select Warehouse!');
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
              <input name="odate" type="text" id="odate" value="<?=$_POST['odate'];?>" required autocomplete="off" readonly="" />
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

                foreign_relation('item_sub_group', 'sub_group_id', 'sub_group_name', $_POST['sub_group'], '1 and group_for="' . $_SESSION['user']['group'] . '"');

                ?>
              </select>

            </div>
          </div>
        </div>

        <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Warehouse</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
			 <select name="warehouse_id" id="warehouse_id" value="<?=$_POST['warehouse_id']?>" required class="m-0">
			   <option></option>
			   <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'1')?>
			  </select>
             <!-- <select name="warehouse_id" id="warehouse_id" required>

                <option></option>
               <? user_warehouse_access($warehouse_id);?>
              </select>-->
            </div>
          </div>

        </div>
        <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Company</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
			<select name="group_for" id="group_for" value="<?=$_POST['group_for']?>" required class="m-0">
			   <option></option>
			   <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'1')?>
			  </select>
              <!--<select name="group_for" id="group_for" value="<?=$_POST['group_for'];?>" required>

                <option></option>
                <? user_company_access($group_for); ?>
              </select>-->
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

      if ($_POST['sub_group'] > 0) {

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
          $warehouse_id = $_POST['warehouse_id'];
          $sql = "select distinct id,item_id,item_price,sum(item_in) as item_in,sum(item_ex) as item_ex,warehouse_id from journal_item where warehouse_id='" . $_POST['warehouse_id'] . "' and tr_from = 'Opening' group by item_id,warehouse_id";

          $query = db_query($sql);

          while ($data = mysqli_fetch_object($query)) {

            $item_price[$data->item_id][$data->warehouse_id] = $data->item_price;

            $item_in[$data->item_id][$data->warehouse_id] = $data->item_in;

            $item_ex[$data->item_id][$data->warehouse_id] = $data->item_ex;

            $is_op[$data->item_id][$data->warehouse_id] = $data->id;
          }



          $sql = "select * from item_info where 1 and sub_group_id=" . $_POST['sub_group'];

          $query = db_query($sql);

          while ($data = mysqli_fetch_object($query)) {
            $i++;

            $opkt_sz = $data->pack_size;
            $is_done = $is_op[$data->item_id][$warehouse_id];
            $final_stock = $item_in[$data->item_id][$warehouse_id] - $item_ex[$data->item_id][$warehouse_id];

            $final_price = $item_price[$data->item_id][$warehouse_id];
            if ($data->pack_size > 0) {

              $opkt = (int)($final_stock / $data->pack_size);
              $opic = $final_stock;
            } else {
              $opkt = (int)($final_stock / 1);
              $opic = $final_stock;
            }




          ?>

          <tr>

            <td><?= $data->finish_goods_code; ?></td>

            <td style="text-align:left"><?= $data->item_name ?></td>

            <td><?= $data->pack_unit ?></td>

            <td><?= $data->unit_name ?></td>

            <td><?= $data->pack_size; ?></td>

            <td><?= number_format($final_stock, 2); ?></td>

            <td><?= number_format($final_price, 2); ?></td>

            <td><input name="opkt_<?= $data->item_id ?>" id="opkt_<?= $data->item_id ?>" type="text" size="10" maxlength="10" value="<?= $opkt; ?>" readonly="readonly" /></td>

            <td>
              <input name="opic_<?= $data->item_id ?>" id="opic_<?= $data->item_id ?>" type="text" size="10" maxlength="10" value="<?= $final_stock ?>" />
              <input name="opkt_sz_<?= $data->item_id ?>" id="opkt_sz_<?= $data->item_id ?>" type="hidden" size="10" maxlength="10" value="<?= $opkt_sz; ?>" />
            </td>

            <td><input name="orate_<?= $data->item_id ?>" id="orate_<?= $data->item_id ?>" type="text" size="10" maxlength="10" value="<?= number_format($final_price, 2, '.', ''); ?>" /></td>

            <td>
              <span id="divi_<?= $data->item_id ?>">

                <?

                if ($is_done > 0) { ?>

                <input name="flag_<?= $data->item_id ?>" type="hidden" id="flag_<?= $data->item_id ?>" value="1" />

                <input type="button" name="Button" value="Edit" onclick="update_value(<?= $data->item_id ?>)" class="btn1 btn1-bg-update" />
                <?

                } elseif ($info->id < 1) {

                ?>

                <input name="flag_<?= $data->item_id ?>" type="hidden" id="flag_<?= $data->item_id ?>" value="0" />

                <input type="button" name="Button" value="Save" onclick="update_value(<?= $data->item_id ?>)" class="btn1 btn1-bg-submit" /><? } ?>

              </span>
            </td>

          </tr>

          <? } ?>



        </tbody>
      </table>


      <? } ?>


    </div>
  </form>
</div>





<?

require_once SERVER_CORE . "routing/layout.bottom.php";

?>