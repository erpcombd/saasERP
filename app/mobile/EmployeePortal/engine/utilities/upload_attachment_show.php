<?php

define("CONTENT_DISPOSITION", 'Content-Disposition: attachment; filename="' . basename($_GET['name']) . '"');

$filename = htmlspecialchars($_GET["name"]);
$folder = htmlspecialchars($_GET["folder"]);
if ($folder != '') {
    $file = '../../../public/uploads/secondary_sales/' . $folder . '/' . $filename;
} else {
    $file = '../../../public/uploads/secondary_sales/' . $filename;
}

$check = explode('.', $_GET['name']);
$ch = strtolower($check[1]);

if ($ch == 'pdf') {
    header("Content-type:application/pdf");
} elseif (in_array($ch, ['jpg', 'png', 'jpeg'])) {
    header('Content-Type: image/' . $ch);
} elseif ($ch == 'xlsx') {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header(CONTENT_DISPOSITION);
} elseif ($ch == 'docx') {
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header(CONTENT_DISPOSITION);
} elseif ($ch == 'csv') {
    header('Content-Type: text/csv');
    header(CONTENT_DISPOSITION);
}

header('X-Content-Type-Options: nosniff');

readfile($file);
?>
