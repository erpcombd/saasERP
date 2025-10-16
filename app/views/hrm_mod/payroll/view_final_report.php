<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE . "routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';


$id = $_GET['id'] ?? 0;

// Your db_query-based SELECT query
$sql = "SELECT f.*, 
               e.PBI_NAME AS name, 
               e.PBI_DESIGNATION AS designation,
			   e.PBI_DOJ
        FROM final_settlements f, personnel_basic_info e
        WHERE f.employee_id = e.PBI_ID 
          AND f.id = '$id'
        LIMIT 1";

$query = db_query($sql);

// Fetch as object
$data = mysqli_fetch_object($query);

// Optional: handle no result case
if (!$data) {
    echo "<div class='alert alert-danger'>No data found for ID: $id</div>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Final Settlement Report</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      font-size: 12px;
    }
    .report-container {
      max-width: 700px;
      margin: 0 auto;
      border: 1px solid #ddd;
    }
    .report-header {
      text-align: center;
      padding: 10px;
      font-weight: bold;
      font-size: 16px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 5px 10px;
    }
    th {
      text-align: left;
      background-color: #f2f2f2;
      width: 40%;
    }
    .section-header {
      background-color: #f2f2f2;
      text-align: center;
      font-weight: bold;
      padding: 5px;
    }
    .total-row {
      font-weight: bold;
    }
    .approval-section {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
    }
    .approval-box {
      width: 30%;
      text-align: center;
    }
    .signature-line {
      border-top: 1px solid #000;
      margin-top: 40px;
      padding-top: 5px;
    }
    .employee-section {
      margin-top: 20px;
      border-top: 1px solid #ddd;
      padding-top: 10px;
    }
    .print-btn {
      text-align: right;
      margin: 20px 0;
    }
    @media print {
      .print-btn {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="report-container">
    <div class="report-header">
      EMPLOYEE FINAL SETTLEMENT
    </div>
    
    <table>
      <tr>
        <th>EMPLOYEE NUMBER</th>
        <td><?= $data->employee_id ?? 'Temporary' ?></td>
      </tr>
      <tr>
        <th>EMPLOYEE NAME</th>
        <td><?= $data->name ?></td>
      </tr>
      <tr>
        <th>DESIGNATION</th>
        <td><?= $data->designation ?></td>
      </tr>
      <tr>
        <th>DATE OF JOINING</th>
        <td><?=$data->PBI_DOJ ?? date('d-m-Y') ?></td>
      </tr>
      <tr>
        <th>LAST WORKING DAY</th>
        <td><?= $data->last_working_day ?? date('d-m-Y') ?></td>
      </tr>
    </table>
    
    <div class="section-header">SALARY DETAILS</div>
    <table>
      <tr>
        <th>BASIC SALARY</th>
        <td> <?= number_format($data->basic_salary, 2) ?>/-</td>
      </tr>
      <tr>
        <th>ACCOMMODATION</th>
        <td> <?= number_format($data->house_rent, 2) ?>/-</td>
      </tr>
      <tr>
        <th>TRANSPORTATION</th>
        <td> <?= number_format($data->conveyance, 2) ?>/-</td>
      </tr>
      <tr>
        <th>UTILITIES</th>
        <td> <?= number_format($data->medical, 2) ?>/-</td>
      </tr>
      <tr>
        <th>ALLOWANCE</th>
        <td> <?= number_format(($data->bonus ?? 0), 2) ?>/-</td>
      </tr>
      <tr class="total-row">
        <th>TOTAL SALARY</th>
        <td> <?= number_format(($data->basic_salary + $data->house_rent + $data->conveyance + $data->medical + ($data->bonus ?? 0)), 2) ?>/-</td>
      </tr>
    </table>
    
    <div class="section-header">FINAL SETTLEMENT CALCULATION</div>
    <table>
      <tr>
        <th>SALARY PAYABLE</th>
        <td> <?= number_format(($data->basic_salary ?? 0), 2) ?>/-</td>
      </tr>
      <tr>
        <th>LEAVE SALARY</th>
        <td> <?= number_format(($data->leave_encashment ?? 0), 2) ?>/-</td>
      </tr>
      <tr>
        <th>GRATUITY</th>
        <td> <?= number_format(($data->gratuity ?? 0), 2) ?>/-</td>
      </tr>
      <tr>
        <th>GROSS PAYABLE</th>
        <td> <?= number_format(($data->total_payable + $data->deductions), 2) ?>/-</td>
      </tr>
      <tr>
        <th>DEDUCTIONS</th>
        <td> <?= number_format($data->deductions, 2) ?>/-</td>
      </tr>
      <tr>
        <th>ADDITIONS</th>
        <td> <?= number_format(($data->provident_fund ?? 0), 2) ?>/-</td>
      </tr>
      <tr class="total-row">
        <th>NET PAYABLE</th>
        <td> <?= number_format($data->total_payable, 2) ?>/-</td>
      </tr>
    </table>
    
    <div class="section-header">APPROVALS REQUIRED</div>
    <table>
      <tr>
        <th>Prepared By</th>
        <th>Reviewed By</th>
        <th>Approved By</th>
      </tr>
      <tr>
        <td style="height: 50px;"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th>Date & Signature</th>
        <th>Date & Signature</th>
        <th>Date & Signature</th>
      </tr>
    </table>
    
    <div class="section-header">EMPLOYEE SECTION</div>
    <div style="padding: 15px;">
      <p>I Mr/Ms <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> hereby certify that I have cleared all my dues</p>
      <p>from <?= $data->company_name ?? 'DEMO COMPANY' ?> as on <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>.</p>
      <div style="text-align: center; margin-top: 30px;">
        <div class="signature-line">SIGNATURE</div>
      </div>
    </div>
  </div>
  
  <div class="print-btn">
    <button onclick="window.print()">Print Report</button>
  </div>
</body>
</html>