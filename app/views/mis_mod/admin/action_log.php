<?php
session_start();

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title = "Template Configuration";
?>

<div class="container">
    <table class="table1  table-striped table-bordered table-hover table-sm">
        <thead class="thead1">
            <tr class="bgc-info">
                <th>User Name</th>
                <th>Access ID</th>
                <th>Module ID</th>
                <th>Page ID</th>
                <th>Link</th>
                <th>TR ID</th>
                <th>TR From</th>
                <th>TR No</th>
                <th>TR Type</th>
            </tr>
        </thead>
        <tbody>
            <?
            $query = db_query("select * from user_action_log where page_id!=984 order by id DESC limit 50");
            while ($data = mysqli_fetch_object($query)) {

            ?>
                <tr>
                    <td><?= $data->user_fname ?></td>
                    <td><?= $data->access_id ?></td>
                    <td><?= $data->mod_id ?></td>
                    <td><?= $data->page_id ?></td>
                    <td><?= $data->page_link ?></td>
                    <td><?= $data->tr_id ?></td>
                    <td><?= $data->tr_from ?></td>
                    <td><?= $data->tr_no ?></td>
                    <td><?= $data->tr_type ?></td>
                </tr>
            <? } ?>
        </tbody>
    </table>
</div>


<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>