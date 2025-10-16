<?php

session_start();
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$crud=new crud('roll_details');
$inserted = $crud->insert();
$tableHTML = '<table class="table table-bordered table-striped table-hover table-sm" cellspacing="0">
    <thead>
        <tr>
            <th><span>ID</span></th>
            <th><span>Roll Name</span></th>
            <th><span>Module</span></th>
            <th><span>Feature</span></th>
			<th><span>Menu</span></th>
        </tr>
    </thead>
    <tbody>';

$query = 'select r.role_name,m.module_name,f.feature_name,p.page_name from roll_details s,roll_master r,user_module_manage m, user_feature_manage f,user_page_manage p where r.role_id=s.role_id and s.module_id=m.id and s.feature_id=f.id and s.page_id=p.id and r.role_id="'.$_POST['role_id'].'" ';

$report = db_query($query);

$i = 0;
while ($rp = mysqli_fetch_object($report)) {
    $i++;
    $cls = ($i % 2 == 0) ? ' class="alt"' : '';
    $tableHTML .= '<tr' . $cls . '">
        <td>' . ++$i. '</td>
		<td>' . $rp->role_name. '</td>
        <td>' . $rp->module_name . '</td>
        <td>' . $rp->feature_name . '</td>
        <td>' . $rp->page_name . '</td>
    </tr>';
}

$tableHTML .= '</tbody></table>';


$all['tableShow'] = $tableHTML;
echo json_encode($all);
?>

