<?php
require_once '../database/koneksi.php';
require('../asset_web/fpdf19/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../asset_web/img/logo(2).png', 10, 10, 27);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 7, 'Jurusan Komputer dan Bisnis', 0, 0, 'C');
        // Line break
        $this->Ln(10);

        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 7, 'D3 Teknik Informatika', 0, 2, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 5, 'Alamat: Jl.  Dr. Soetomo No.1, Karangcengis, ', 0, 2, 'C');
        $this->Cell(30, 5, 'Sidakaya, Kec. Cilacap Sel., Kabupaten Cilacap, Jawa Tengah 53212', 0, 0, 'C');
        $this->SetLineWidth(0.5);
        $this->Line(10, 40, 200, 40);
        $this->Ln(15);
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', 'B', 14);
$pdf->Cell(80);
$pdf->Cell(30, 7, 'Data Mata Kuliah', 0, 1, 'C');
$pdf->Ln(5);
$pdf->SetFont('Times', '', 12);
$pdf->Cell(12, 7, 'No', 1, 0, 'C');
$pdf->Cell(50, 7, 'Kode Mata Kuliah', 1, 0, 'C');
$pdf->Cell(98, 7, 'Nama Mata Kuliah', 1, 0, 'C');
$pdf->Cell(15, 7, 'SKS', 1, 0, 'C');
$pdf->Cell(15, 7, 'CPMK', 1, 1, 'C');

$query_ambil_makul = mysqli_query($koneksi, "SELECT * FROM tb_makul")or die(mysqli_error($koneksi));
$rv = mysqli_num_rows($query_ambil_makul);
if($rv > 0){
    $no = 1;
    while($data = mysqli_fetch_array($query_ambil_makul)){
        $pdf->Cell(12, 7, $no++, 1, 0, 'C');
        $pdf->Cell(50, 7, $data['kode_makul'], 1, 0, 'C');
        $pdf->Cell(98, 7, $data['nama_makul'], 1, 0, '');
        $pdf->Cell(15, 7, $data['jml_sks'], 1, 0, 'C');
        $pdf->Cell(15, 7, $data['jml_cpmk'], 1, 1, 'C');
    }
}

$pdf->Output();
?>