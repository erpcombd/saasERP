<?php
session_start();

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title = "Template Configuration";
?>

<div class="container">

    <h3 class="text-center">User Wise Access Log</h3>

    <form action="" method="post">

        <div class="row justify-content-md-center">



            <div class="col-md-3 form-group">

                <label class="label success" for="PBI_ID">Search With CID : </label>

                <input type="date" name="date" id="date" class="form-control">

            </div>

            <div class="col-md-3 form-group" style="margin-top: 2.5% !important;">

                <button class="btn btn-info" type="submit" name="submit">Search</button>

            </div>

        </div>

    </form>
    <?php
    if (isset($_POST['submit'])) {


    ?>

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Date</th>
                    <th>Total Module Use</th>
                    <th>Journal Hit</th>
                </tr>
            </thead>
            <tbody>
                <?

                echo $sql = "select * from user_action_log where access_date between '" . $_POST['date'] . "'  and '" . $_POST['date'] . "' and user_id!=0 group by user_id";
                $query = db_query($sql);
                while ($data = mysqli_fetch_object($query)) {


                ?>
                    <tr>
                        <td><?= $data->user_fname ?></td>
                        <td><?= $data->access_date ?></td>
                        <td><?= $data->mod_id ?></td>
                        <td><?= $data->mod_id ?></td>
                    </tr>
                <? } ?>
            </tbody>
        </table>

    <? } ?>
</div>


<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>