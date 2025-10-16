<?php

session_start();

ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
$tr_type = "Show";
$title = 'Opening Balance Setup';
//do_calander('#odate');

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

    var room = (document.getElementById('room' + id).value) * 1;

    var rak = (document.getElementById('rak' + id).value) * 1;

    var shelf = (document.getElementById('shelf' + id).value) * 1;

    var warehouse_id = (document.getElementById('warehouse_id').value) * 1;

    var group_for = (document.getElementById('group_for').value);

    var sub_group = (document.getElementById('sub_group').value);

    var flag = (document.getElementById('flag_' + id).value);
    if (warehouse_id > 0) {
     
 
            var strURL = "location_ajax.php?item_id=" + item_id + "&room_no=" + room + "&rak_no=" + rak + "&shelf_no=" + shelf + "&warehouse_id=" + warehouse_id + "&group_for=" + group_for+"&sub_group="+sub_group;



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
              <select name="warehouse_id" id="warehouse_id" required>

                <option></option>
               <? user_warehouse_access($depot_id);?>
              </select>
            </div>
          </div>

        </div>
        <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
          <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text req-input">Company</label>
            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
              <select name="group_for" id="group_for" required>

                <option></option>
                <? user_company_access($group_for); ?>
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

      if ($_POST['sub_group'] > 0) {

      ?>


      <!--        Table start hear-->
      <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
          <tr class="bgc-info">
            <th>FC</th>
            <th>Item Name</th>
            <th>PCU</th>
            <th>Floor</th>
            <th>Room</th>
            <th>Shelf</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody class="tbody1">


          <?
          $warehouse_id = $_POST['warehouse_id'];
          $sql = "select * from item_location_info where 1 group by item_id,warehouse_id";

          $query = db_query($sql);

          while ($data = mysqli_fetch_object($query)) {

            $is_op[$data->item_id][$data->warehouse_id] = $data->id;
          }



          $sql = "select * from item_info where 1 and sub_group_id=" . $_POST['sub_group'];

          $query = db_query($sql);

          while ($data = mysqli_fetch_object($query)) {
            $i++;

            $is_done = $is_op[$data->item_id][$warehouse_id];
            
          ?>

          <tr>

            <td><?= $data->finish_goods_code; ?></td>

            <td style="text-align:left"><?= $data->item_name ?></td>

            <td><?= $data->unit_name ?></td>

            <td><select name="room<?= $data->item_id ?>" id="room<?= $data->item_id ?>">
			<option></option>
			<? foreign_relation('item_location_floor','floor_id','floor_name','1')?>
			</select>			</td>

            <td>
              <select name="rak<?= $data->item_id ?>" id="rak<?= $data->item_id ?>">
			<option></option>
			<? foreign_relation('item_location_room','room_id','room_name','1')?>
			</select>            </td>

            <td><select name="shelf<?= $data->item_id ?>" id="shelf<?= $data->item_id ?>">
			<option></option>
			<? foreign_relation('item_location_shelf','shelf_id','shelf_name','1')?>
			</select></td>

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
              </span>            </td>
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