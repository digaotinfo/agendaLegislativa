<?php
App::import('Vendor', 'fpdf/fpdf');
 
class PDF extends FPDF {
 
    public $titulo;
    public $subtitulo;
 
    function Header() {
 
        $this->Image('img/logo_arearestrita.png', 10, 10, 190);
        $this->Ln();
        $this->Cell(40);
        $this->Cell(30, 4, ($this->titulo));
        $this->Ln(10);
        $this->SetFont('Arial', '', 7);
        $this->Cell(50, 4, ($this->subtitulo), 0, "C");
        $this->Ln(30);
    }
 
    function Footer() {
        $this->SetY(-30);
        // $this->Cell(0, 10, ( "rua, xxxxxxxx, xxx - xxxxxx"));
        // $this->Ln(2.5);
        // $this->Cell(0, 10, "cep: 00000-000, SP-São Paulo");
        // $this->Ln(2.5);
        // $this->Cell(0, 10, "tel: (11) 0000-0000");
        $this->Ln(2.5);
        $this->Cell(0, 10, "", 'B', 16);
        // $this->Cell(0, 10, "E-mail: abear@abear.com.br", 'B', 16);
         
        $this->SetFont('Arial', 'I', 8);
        $this->AliasNbPages();
        $this->Cell(0, 10, utf8_decode(( 'Página ' )) . $this->PageNo() . ' de {nb}', 0, 0, 'R');
        $this->Ln(2.5);
        $this->SetFont('Arial', '', 6);
        $this->Cell(0, 10, 'Data: '. date('d/m/Y'));
    }
}
?>