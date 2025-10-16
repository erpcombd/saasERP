<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');


header('Content-Type: application/json');


// Check if all required parameters are present
if (isset($_GET['gross_salary']) && isset($_GET['basic_salary']) && isset($_GET['gender'])) {
    $gross_salary = (float)$_GET['gross_salary'];
    $basic_salary = (float)$_GET['basic_salary'];
    $gender = strtolower(trim($_GET['gender'])); // Convert to lowercase and trim spaces

    // Check valid gender input
    if ($gender !== 'male' && $gender !== 'female') {
        echo json_encode(['success' => false, 'message' => "Invalid gender input. Please enter either 'Male' or 'Female'."]);
        exit;
    }

    // Total income calculation
    $totalIncome = $gross_salary * 12 + $basic_salary * 2;

    // Tax-free income calculation
    $taxFreeIncome = $totalIncome / 3;

    // Taxable income calculation with new condition
    if ($taxFreeIncome > 450000) {
        $taxableIncome = $totalIncome - 450000;
    } else {
        $taxableIncome = $totalIncome - $taxFreeIncome;
    }

    if ($taxableIncome <= 0) {
        echo json_encode(['success' => true, 'tax' => 0]); // No tax if taxable income is less than or equal to 0
        exit;
    }

    // Determine slab 1 threshold based on gender
    $slab1_threshold = ($gender == 'male') ? 350000 : 400000;

    // Tax calculation based on slabs
    $remainingIncome = $taxableIncome;
    $totalTax = 0;

    // Slab 1: 0% up to slab1_threshold
    if ($remainingIncome > $slab1_threshold) {
        $remainingIncome -= $slab1_threshold;
    } else {
        $remainingIncome = 0;
    }

    // Slab 2: 5% for up to 100,000
    if ($remainingIncome > 100000) {
        $totalTax += 100000 * 0.05;
        $remainingIncome -= 100000;
    } else {
        $totalTax += $remainingIncome * 0.05;
        $remainingIncome = 0;
    }

    // Slab 3: 10% for next 300,000
    if ($remainingIncome > 400000) {
        $totalTax += 400000 * 0.10;
        $remainingIncome -= 400000;
    } else {
        $totalTax += $remainingIncome * 0.10;
        $remainingIncome = 0;
    }

    // Slab 4: 15% for next 400,000
    if ($remainingIncome > 500000) {
        $totalTax += 500000 * 0.15;
        $remainingIncome -= 500000;
    } else {
        $totalTax += $remainingIncome * 0.15;
        $remainingIncome = 0;
    }

    // Slab 5: 20% for next 500,000
    if ($remainingIncome > 500000) {
        $totalTax += 500000 * 0.20;
        $remainingIncome -= 500000;
    } else {
        $totalTax += $remainingIncome * 0.20;
        $remainingIncome = 0;
    }

    // Final slab: 25% for remaining amount
    if ($remainingIncome > 0) {
        $totalTax += $remainingIncome * 0.25;
    }

    // Calculate monthly tax amount
    $monthlyTax = $totalTax / 12;
    
    $actual_tax = round($monthlyTax * 0.75);
    
    
   
    if ($actual_tax > 0 && $actual_tax < 417) {
        $actual_tax = 417;
    }

    // Return the monthly tax amount in JSON format
    echo json_encode(['success' => true, 'tax' => $actual_tax]);
} else {
    // Return error message if required parameters are missing
    echo json_encode(['success' => false, 'message' => 'Invalid parameters']);
}



		
		
		
?>
