<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";

require_once 'csv_object_pbi.php';

$title = "Personal Information Excel Upload";
$excel_file_format = "pbi_information_format.csv";
$page = "pbi_excel_upload.php";


if (isset($_POST['upload']) && isset($_FILES['csv_file']['tmp_name'])) {
  $file = $_FILES['csv_file']['tmp_name'];

  if ($_FILES['csv_file']['size'] > 0) {
    $importer = new TorCsvImporterpbi($file, 'personnel_basic_info');

    $importer->setMappings([
      [
        'column' => 'DEPT_ID',
        'source_column' => 'PBI_DEPARTMENT',
        'table' => 'department',
        'id_field' => 'DEPT_ID',
        'name_field' => 'DEPT_DESC'
      ],
      [
        'column' => 'LEAVE_RULE_ID',
        'source_column' => 'LEAVE_RULE_NAME',
        'table' => 'hrm_leave_rull_manage',
        'id_field' => 'id',
        'name_field' => 'rule_name'
      ],
      [
        'column' => 'employee_type',
        'source_column' => 'employee_type_name',
        'table' => 'hrm_employee_type',
        'id_field' => 'id',
        'name_field' => 'employee_type'
      ],
      [
        'column' => 'DESG_ID',
        'source_column' => 'PBI_DESIGNATION',
        'table' => 'designation',
        'id_field' => 'DESG_ID',
        'name_field' => 'DESG_DESC'
      ],
      [
        'column' => 'PBI_ZONE',
        'source_column' => 'PBI_ZONE_NAME',
        'table' => 'zon',
        'id_field' => 'ZONE_CODE',
        'name_field' => 'ZONE_NAME'
      ],
      [
        'column' => 'PBI_AREA',
        'source_column' => 'PBI_AREA_NAME',
        'table' => 'area',
        'id_field' => 'AREA_CODE',
        'name_field' => 'AREA_NAME'
      ],
      [
        'column' => 'PBI_BRANCH',
        'source_column' => 'PBI_BRANCH_NAME',
        'table' => 'branch',
        'id_field' => 'BRANCH_ID',
        'name_field' => 'BRANCH_NAME'
      ],
      [
        'column' => 'institute_id',
        'source_column' => 'institute_name',
        'table' => 'university',
        'id_field' => 'UNIVERSITY_CODE',
        'name_field' => 'UNIVERSITY_NAME'
      ],
      [
        'column' => 'JOB_LOCATION',
        'source_column' => 'JOB_LOCATION_NAME',
        'table' => 'project',
        'id_field' => 'PROJECT_ID',
        'name_field' => 'PROJECT_DESC'
      ],
      [
        'column' => 'grace_type',
        'source_column' => 'grace_type_name',
        'table' => 'grace_type',
        'id_field' => 'ID',
        'name_field' => 'grace_type'
      ],
      [
        'column' => 'PBI_ORG',
        'source_column' => 'PBI_ORG_NAME',
        'table' => 'user_group',
        'id_field' => 'id',
        'name_field' => 'group_name'
      ],
      [
        'column' => 'define_schedule',
        'source_column' => 'define_schedule_name',
        'table' => 'hrm_schedule_info',
        'id_field' => 'id',
        'name_field' => 'schedule_name'
      ],
      [
        'column' => 'incharge_id',
        'source_column' => 'incharge_name',
        'table' => 'personnel_basic_info',
        'id_field' => 'PBI_ID',
        'name_field' => 'PBI_NAME'
      ],
      [
        'column' => 'incharge_id2',
        'source_column' => 'incharge_name_2',
        'table' => 'personnel_basic_info',
        'id_field' => 'PBI_ID',
        'name_field' => 'PBI_NAME'
      ],

    ]);
    $count = $importer->import();


    header("Location: $page?msg=$count rows inserted.");
  }
}





?>

<?php if (isset($_GET['msg'])): ?>
<div class="alert alert-info"><?= htmlspecialchars($_GET['msg']) ?></div>
<?php endif; ?>

<div class="container mt-5">
    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <span style="color: red; font-weight: bold; animation: blink 1s steps(2, start) infinite;">
                Don't change Any of Excel Heading.
            </span>
            <style>
            @keyframes blink {
                to {
                    visibility: hidden;
                }
            }
            </style>
            <button class="btn btn-success d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-sm"
                onclick="downloadFile()">
                <i class="fas fa-file-excel fa-lg"></i>
                <span class="fw-semibold">Download Format</span>
            </button>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Upload CSV to Personal Basic Information</h4>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="csv_file" class="form-label">Choose CSV File</label>
                        <input class="form-control" type="file" id="csv_file" name="csv_file" accept=".csv"
                            onchange="validateCSV(this)">
                    </div>
                    <button type="submit" name="upload" class="btn btn-success">Upload CSV</button>
                </form>
            </div>
        </div>
    </div>

    <?php

  require_once SERVER_CORE . "routing/layout.bottom.php";

  ?>
    <script>
    function downloadFile() {
        const link = document.createElement('a');
        link.href = '<?= $excel_file_format ?>'; // e.g., 'files/report.xlsx'
        link.download = '<?= $excel_file_format ?>'; // Optional: custom download name
        link.click();
    }

    function validateCSV(input) {
        const file = input.files[0];

        if (!file) return;

        const allowedFileName = '<?= $excel_file_format ?>';

        const actualFileName = file.name.toLowerCase();

        if (actualFileName !== allowedFileName) {
            alert("Only file named '<?= $excel_file_format ?>' is allowed!");
            input.value = ""; // Clear the file
        } else {
            // Optional: hide warning message or do nothing
            console.log("File is valid.");
        }
    }
    </script>