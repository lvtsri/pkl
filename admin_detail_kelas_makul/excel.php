<?php
require_once '../database/koneksi.php';
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$nama_file = "Detail-Makul-" . date('Y-m-d');

$kode_kelas = isset($_GET['data']) ? $_GET['data'] : '';
$query_kelas_mk = mysqli_query($koneksi, "SELECT dkm.*, m.nama, km.nama_kelas 
    FROM tb_detail_kls_mk dkm
    JOIN tb_mahasiswa m ON dkm.nim = m.nim
    JOIN tb_kelas_makul km ON dkm.kode_kelas = km.kode_kelas
    WHERE dkm.kode_kelas = '$kode_kelas';
")or die(mysqli_error($koneksi));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Detail Makul');

// Set header cells
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'NIM');
$sheet->setCellValue('C1', 'Nama');
$sheet->setCellValue('D1', 'Kelas');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:D1')->applyFromArray($styleArray);
$sheet->getStyle('A1:D1')->getFont()->setBold(true);

foreach (array('B', 'C', 'D') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);   //otomatis lebar
}

$no = 1;
$rowNumber = 2;
while ($data = mysqli_fetch_assoc($query_kelas_mk)) {
    $nim = $data['nim'];
    $nama = $data['nama'];
    $nama_kelas = $data['nama_kelas'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $nim);
    $sheet->setCellValue("C" . $rowNumber, $nama);
    $sheet->setCellValue("D" . $rowNumber, $nama_kelas);
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