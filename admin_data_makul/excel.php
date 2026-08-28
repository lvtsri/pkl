<?php
require_once '../database/koneksi.php';
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$nama_file = "Data-Mapel-" . date('Y-m-d');
$query_makul = mysqli_query($koneksi, "SELECT * FROM tb_makul")or die(mysqli_error($koneksi));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Mapel');

// Set header cells
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Kode Makul');
$sheet->setCellValue('C1', 'Nama Makul');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:C1')->applyFromArray($styleArray);
$sheet->getStyle('A1:C1')->getFont()->setBold(true);

foreach (array('B', 'C') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);   //otomatis lebar
}

$no = 1;
$rowNumber = 2;
while ($data = mysqli_fetch_assoc($query_makul)) {
    $code = $data['kode_makul'];
    $nama = $data['nama_makul'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $code);
    $sheet->setCellValue("C" . $rowNumber, $nama);
    $rowNumber++;
    $no++;
}

// Buat file excel
$filename = $nama_file . ".xlsx";
$writer = new Xlsx($spreadsheet);

ob_end_clean(); // Bersihkan output buffer

// Atur header untuk pengunduhan file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit();
?>