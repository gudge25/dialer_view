<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', '#');
$sheet->setCellValue('B1', 'First');
$sheet->setCellValue('C1', 'Last');
$sheet->setCellValue('D1', 'Handle');


$sheet->setCellValue('A2', 1);
$sheet->setCellValue('B2', 'Mark');
$sheet->setCellValue('C2', 'Jacob');
$sheet->setCellValue('D2', 'Larry');

$sheet->setCellValue('A3', 2);
$sheet->setCellValue('B3', 'Jacob');
$sheet->setCellValue('C3', 'Thornton');
$sheet->setCellValue('D3', '@fat');

$sheet->setCellValue('A4', 3);
$sheet->setCellValue('B4', 'Larry');
$sheet->setCellValue('C4', 'the Bird');
$sheet->setCellValue('D4', '@twitter');


$filename = 'sample-'.time().'.xlsx';
// Redirect output to a client's web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
 
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');