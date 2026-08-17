<?php
// Include database connection
include __DIR__ . "/config.php"; 


// Load PHPSpreadsheet library
require __DIR__ . "/../../vendor/autoload.php";

 // Move one level up

 // Ensure PhpSpreadsheet is installed

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set headers for the Excel file
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Guest');
$sheet->setCellValue('C1', 'Villas');
$sheet->setCellValue('D1', 'Check-In');
$sheet->setCellValue('E1', 'Check-Out');
$sheet->setCellValue('F1', 'Name');
$sheet->setCellValue('G1', 'Email');
$sheet->setCellValue('H1', 'Mobile');

// Fetch data from the database
$sql = "SELECT id, guest, villas, check_in, check_out, name, email, mobile FROM booking ORDER BY id ASC";
$result = $link->query($sql);

$row = 2; // Start from second row
if ($result && $result->num_rows > 0) {
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue("A$row", $data['id']);
        $sheet->setCellValue("B$row", $data['guest']);
        $sheet->setCellValue("C$row", $data['villas']);
        $sheet->setCellValue("D$row", date('d-m-Y', strtotime($data['check_in'])));
        $sheet->setCellValue("E$row", date('d-m-Y', strtotime($data['check_out'])));
        $sheet->setCellValue("F$row", $data['name']);
        $sheet->setCellValue("G$row", $data['email']);
        $sheet->setCellValue("H$row", $data['mobile']);
        $row++;
    }
}

// Set header to force download as an Excel file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="bookings.xlsx"');
header('Cache-Control: max-age=0');

// Write the Excel file and output to browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
