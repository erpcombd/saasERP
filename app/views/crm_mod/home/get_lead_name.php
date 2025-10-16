<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

if (isset($_POST['project_id'])) {
    $projectid = (int) $_POST['project_id']; // safe cast to integer
    $prj = "SELECT id, lead_name FROM crm_project_lead WHERE organization = $projectid";
    $proj = db_query($prj);

    echo '<option value="">Select Lead Name</option>';
    while ($row = mysqli_fetch_assoc($proj)) {
        echo "<option value='{$row['id']}'>{$row['lead_name']}({$row['id']})</option>";
    }
}

?>
