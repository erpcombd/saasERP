<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
require_once 'csv_object.php';

$title = "Account Ledger Excel Upload";
$excel_file_format = "accounts_ledger_format.csv";



if (isset($_POST['upload']) && isset($_FILES['csv_file']['tmp_name'])) {
  $file = $_FILES['csv_file']['tmp_name'];

  if ($_FILES['csv_file']['size'] > 0) {
    $importer = new TorCsvImporter($file, 'accounts_ledger');

    $importer->setMappings([
      [
        'column' => 'ledger_group_id',
        'source_column' => 'ledger_group_name',
        'table' => 'ledger_group',
        'id_field' => 'group_id',
        'name_field' => 'group_name'
      ],
      [
        'column' => 'acc_class',
        'source_column' => 'acc_class_name',
        'table' => 'acc_class',
        'id_field' => 'id',
        'name_field' => 'class_name'
      ],
      [
        'column' => 'acc_sub_class',
        'source_column' => 'acc_sub_class_name',
        'table' => 'acc_sub_class',
        'id_field' => 'id',
        'name_field' => 'sub_class_name'
      ],
      [
        'column' => 'acc_sub_sub_class',
        'source_column' => 'acc_sub_sub_class_name',
        'table' => 'acc_sub_sub_class',
        'id_field' => 'id',
        'name_field' => 'sub_sub_class_name'
      ]
    ]);

    // ✅ Import Run
    $count = $importer->import();
    header("Location: acc_excel_upload.php?msg=$count rows inserted.");
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
        <button class="btn btn-success d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-sm" onclick="downloadFile()">
            <i class="fas fa-file-excel fa-lg"></i>
            <span class="fw-semibold">Download Format</span>
        </button>
    </div>

  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Upload CSV to Import Accounts Ledger</h4>
    </div>
    <div class="card-body">
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="csv_file" class="form-label">Choose CSV File</label>
          <input class="form-control" type="file" id="csv_file" name="csv_file" accept=".csv" onchange="validateCSV(this)">
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