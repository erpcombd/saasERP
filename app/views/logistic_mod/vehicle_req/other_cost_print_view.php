<?

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$tabel = 'vehicle_req_list';

$title = "Cost Report List";

$table = 'vehicle_cost_master';

$cost_no = $_GET["id"];
$req_no = $_GET["req_no"];

$vehicle_qry = 'SELECT * FROM vehicle_information WHERE 1';
$vehicle_res = db_query($vehicle_qry);
while($vehicle_rows = mysqli_fetch_object($vehicle_res)){
    $vehicle_model[$vehicle_rows->id] = $vehicle_rows->vehicle_model;
    $vehicel_reg_no[$vehicle_rows->id] = $vehicle_rows->reg_number;
    $vehicle_customer_id[$vehicle_rows->id] = $vehicle_rows->vehicle_owner;
}

$driver_qry = 'SELECT * FROM  vehicle_driver_info WHERE 1';
$driver_res = db_query($driver_qry);
while($driver_rows = mysqli_fetch_object($driver_res)){
    $driver_name[$driver_rows->id] = $driver_rows->d_name;
}

$costType_qry = 'SELECT * FROM  other_cost_type WHERE 1';
$costType_res = db_query($costType_qry);
while($costType_rows = mysqli_fetch_object($costType_res)){
    $cost_name[$costType_rows->id] = $costType_rows->ot_cost_name;
}

$customer_qry = 'SELECT * FROM  customer_list WHERE 1';
$customer_res = db_query($customer_qry);
while($customer_rows = mysqli_fetch_object($customer_res)){
    $customer_name[$customer_rows->id] = $customer_rows->customer_name;
}
 
$req_info = 'SELECT * FROM vehicle_cost_master  WHERE id = "'.$_GET["id"].'" ';
$req_res=db_query($req_info);
$req_rows = mysqli_fetch_object($req_res);

$cost_qry = 'SELECT * FROM vehicle_other_cost_details WHERE ot_cost_id = "'.$_GET["id"].'" ';
$cost_res=db_query($cost_qry);
 
$c_req_query = 'SELECT * FROM vehicle_other_cost_master  WHERE id = "'.$_GET["id"].'" ';
$c_req_res=db_query($c_req_query);
$c_req_rows = mysqli_fetch_object($c_req_res);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Voucher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            border: 1px solid #000;
            padding: 20px;
        }
        .header {
            text-align: center;
        }
        .header h2 {
            margin: 5px 0;
        }
        .invoice-btn {
            text-align: center;
            margin: 10px 0;
        }
        .invoice-btn button {
            margin: 5px;
            padding: 5px 10px;
        }
        .info {
            border: 1px solid #000;
            padding: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table, .table th, .table td {
            border: 1px solid #000;
        }
        .table th, .table td {
            padding: 10px;
            text-align: left;
        }
        .footer {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Logistic Mod</h2>
            <p>Mirpur Dohs Road 16</p>
            <p>Tel: +880 184 100 000, Email: ceo@erp.com.bd</p>
            <h3>Vehicle Cost Report</h3>
        </div>
        <div class="invoice-btn">
            <!-- <button>Print</button>
            <button>Excel</button>
            <button>Client Copy</button> -->
        </div>
        <div class="info">  
        
            <p>Cost ID: <strong><?=$cost_no?></strong> &nbsp;&nbsp; ENTRY DATE: <strong><?=$req_rows->entry_at?></strong> </p>
            <p>Vehicle :<strong> &nbsp;<?=$vehicle_model[$c_req_rows->vehicle_id]?> :: <?=$vehicel_reg_no[$c_req_rows->vehicle_id]?></strong></p>
            <p>Concern :<strong> &nbsp;<?=$customer_name[$vehicle_customer_id[$c_req_rows->vehicle_id]]?></strong> </p>

        </div>
        <table class="table">
            <tr>
                <th>Other Cost Type</th>
                <th>Note</th>
                <th>Amount</th>
            </tr>
            <? while($cost_rows = mysqli_fetch_object($cost_res)){?>
                <tr>
                    <td><?=$cost_name[$cost_rows->ot_cost_type]?></td>
                    <td><?=$cost_rows->note?></td>
                    <td><?=$cost_rows->amount?></td>
                </tr>
            <? 
                $total_cost += $cost_rows->amount;
                }?>
            <tr>
                <td  colspan="2" style="text-align: right;"><strong>Total Taka:</strong></td>
                <td><strong><?=$total_cost?></strong></td>
            </tr>

            <tr>
                <td  colspan="3" style="text-align: right;"></td>
            </tr>
            
        </table>
    </div>
</body>
</html>