<?php

namespace App\Helpers;

use Codedge\Fpdf\Fpdf\Fpdf;

class PdfHelper extends Fpdf
{
    function __construct()
    {
        parent::__construct();
        $this->SetAutoPageBreak(true, 10);
        $this->SetMargins(10, 10, 10);
    }

    // Override header untuk menambahkan header default
    function Header()
    {
        // Logo
        $this->Image(public_path('images/logo.png'), 10, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, 'SISTEM INFORMASI ARSIP KTP', 0, 0, 'C');
        // Line break
        $this->Ln(20);
    }

    // Override footer untuk menambahkan footer default
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
