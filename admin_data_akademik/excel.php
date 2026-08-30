<?php
require_once '../database/koneksi.php';
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$nama_file = "Data-Periode-Akademik-" . date('Y-m-d');
$query_akademik = mysqli_query($koneksi, "SELECT * FROM tb_akademik")or die(mysqli_error($koneksi));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Periode Akademik');

// Set header cells
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Kode Akademik');
$sheet->setCellValue('C1', 'Semester');
$sheet->setCellValue('D1', 'Tahun');
$sheet->setCellValue('E1', 'Aktif');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:E1')->applyFromArray($styleArray);
$sheet->getStyle('A1:E1')->getFont()->setBold(true);

foreach (array('B', 'C', 'D', 'E') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);   //otomatis lebar
}

$no = 1;
$rowNumber = 2;
while ($data = mysqli_fetch_assoc($query_akademik)) {
    $kode = $data['kode_akd'];
    $sem = $data['semester'];
    $th = $data['tahun'];
    $aktif = $data['is_active'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $kode);
    $sheet->setCellValue("C" . $rowNumber, $sem);
    $sheet->setCellValue("D" . $rowNumber, $th);
    $sheet->setCellValue("E" . $rowNumber, $aktif);
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