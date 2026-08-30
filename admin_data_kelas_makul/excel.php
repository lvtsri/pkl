<?php
require_once '../database/koneksi.php';
require '../vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

ob_start();

$nama_file = "Data-Kelas-" . date('Y-m-d');
$query_kelas = mysqli_query($koneksi, "SELECT km.*, a.*, mk.*, j.*, d.nama
    FROM tb_kelas_makul km
    JOIN tb_akademik a ON km.kode_akd = a.kode_akd
    JOIN tb_makul mk ON km.kode_makul = mk.kode_makul
    JOIN tb_jurusan j ON km.kode_jurusan = j.kode_jurusan
    JOIN tb_dosen d ON km.nik = d.nik;
")or die(mysqli_error($koneksi));

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data Kelas');

// Set header cells
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama Kelas');
$sheet->setCellValue('C1', 'Periode Akademik');
$sheet->setCellValue('D1', 'Mata Kuliah');
$sheet->setCellValue('E1', 'Jurusan');
$sheet->setCellValue('F1', 'Dosen');

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['rgb' => '808080'],
        ],
    ],
];
$sheet->getStyle('A1:F1')->applyFromArray($styleArray);
$sheet->getStyle('A1:F1')->getFont()->setBold(true);

foreach (array('B', 'C', 'D', 'E', 'F') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);   //otomatis lebar
}

$no = 1;
$rowNumber = 2;
while ($data = mysqli_fetch_assoc($query_kelas)) {
    $nama_kelas = $data['nama_kelas'];
    $tahun = $data['tahun'];
    $semester = $data['semester'];
    $nama_makul = $data['nama_makul'];
    $jurusan = $data['nama_jurusan'];
    $dosen = $data['nama'];

    $sheet->setCellValue("A" . $rowNumber, $no);
    $sheet->setCellValue("B" . $rowNumber, $nama_kelas);
    $sheet->setCellValue("C" . $rowNumber, $tahun . ' - ' . $semester);
    $sheet->setCellValue("D" . $rowNumber, $nama_makul);
    $sheet->setCellValue("E" . $rowNumber, $jurusan);
    $sheet->setCellValue("F" . $rowNumber, $dosen);
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