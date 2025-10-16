<?php

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

if (isset($_POST['table_name']) && !empty($_POST['table_name'])) {
    $table = $_POST['table_name'];

    // Check if table exists in the database
    $checkTable = db_query("SHOW TABLES LIKE '$table'");
    if (mysqli_num_rows($checkTable) == 0) {
        echo "<tr><td colspan='3'>Table not found!</td></tr>";
        exit;
    }

    // Fetch table data with limit to avoid overloading
    $result = db_query("SELECT * FROM `$table` LIMIT 100");

    if (mysqli_num_rows($result) == 0) {
        echo "<tr><td colspan='3'>No data available.</td></tr>";
        exit;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        // Try to get primary key or first column as ID
        $id = isset($row['id']) ? $row['id'] : reset($row);

        echo "<tr>
                <td><input type='checkbox' name='delete_ids[]' value='$id'></td>
                <td>$id</td>
                <td>" . htmlentities(json_encode($row)) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='3'>Invalid table name.</td></tr>";
}




?>