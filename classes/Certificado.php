<?php

namespace Classes;

use FPDF;

require __DIR__ . '/../vendor/autoload.php';

class Certificado {
    public $nombre;
    public $pasaporte;
    public $codigo;
    public $token;
    public $name_curso;
    public $fecha_fin;
    public $duracion;
    public $plantilla;
    
    public function __construct($datos,$plantilla)
    {
        $this->nombre = (string)$datos["nombre"];
        $this->pasaporte = (string)$datos["pasaporte"];
        $this->codigo = (string)$datos["codigo"];
        $this->token = (string)$datos["token"];
        $this->name_curso = (string)$datos["name_curso"];
        $this->fecha_fin = (string)$datos["fecha_fin"];
        $this->duracion = (string)$datos["duracion"];
        $this->plantilla = (string)$plantilla;
    }

    public function generarCertificado() {
        $pdf = new FPDF('L','mm','A4');
        $pdf->AddPage();
        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/plantillas/'. $this->plantilla .'.jpg','0','0',298,210,'JPG');
        $pdf->SetFont('Arial','',20);
       //Texto de Título
        $pdf->SetXY(10, 27);
        $pdf->SetTextColor(77, 77, 75);
        $pdf->Cell(0, 12, 'INSTITUTO ICADI', 0, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial','B',44);
        $pdf->SetXY(2, 41);
        $pdf->Cell(0, 8, 'CERTIFICADO', 0, 0, 'C');

        $pdf->Ln();
        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/plantillas/img/barra.png','106','51',85,16,'PNG');
        $pdf->SetFont('Arial','',22);
        $pdf->SetXY(12, 57);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->Cell(0, 5, 'CURSO APROBADO', 0, 0, 'C');

        $pdf->SetFont('Arial','',18);
        $pdf->SetXY(80, 76);
        $pdf->SetTextColor(77, 77, 75);
        $pdf->Cell(80, 5, 'SE ENTREGA EL PRESENTE CERTIFICADO A:');

        $pdf->SetFont('Arial','B',44);
        $pdf->SetXY(10, 95);
        $texto_limpio = str_replace(array("á","é","í","ó","ú"), array("a","e","i","o","u"), $this->nombre);
        $pdf->Cell(0, 5, utf8_decode(strtoupper($texto_limpio)), 0, 0, 'C');

        $pdf->SetFont('Arial','',18);
        $pdf->SetXY(10, 116);
        $pdf->Cell(0,5,utf8_decode('Cédula de identidad número '. $this->pasaporte .' por haber aprobado el curso denominado'), 0, 0, 'C');
        $pdf->SetXY(10, 125);
        $pdf->Cell(0,5,utf8_decode('"'.strtoupper($this->name_curso).'" el cual contempla '.$this->duracion.' horas pedagógicas,'), 0, 0, 'C');
        $pdf->SetXY(10, 134);
        $pdf->Cell(0,5,utf8_decode('en consecuencia de lo anterior se registra su aprobación bajo el registro internos número'), 0, 0, 'C');

        $pdf->SetXY(10, 143);
        $pdf->Cell(0,5,utf8_decode($this->codigo.' del año '.date('Y', strtotime($this->fecha_fin))), 0, 0, 'C');

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/plantillas/img/qr.png','9','169',29,29,'PNG');
        $pdf->SetFont('Arial','B',14);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(65, 173);
        $pdf->Cell(50,5,utf8_decode('Santiago, '.obtenerFechaEnLetra($this->fecha_fin)));

        $pdf->SetLineWidth(.5);
        $pdf->Line(77,180,127,180);
        $pdf->Line(172,180,222,180);

        $pdf->SetFont('Arial','',17);
        $pdf->SetTextColor(77, 77, 75);
        $pdf->SetXY(77, 181);
        $pdf->Cell(40,5,utf8_decode('Fecha de Emisión'));

        $pdf->SetXY(174, 181);
        $pdf->Cell(40,4,utf8_decode("José Sánchez N.")); 
        $pdf->SetXY(186, 188);
        $pdf->Cell(40,1,utf8_decode("Director")); 

        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/plantillas/img/firma.png','158','153',68,40,'PNG');
        $pdf->Image($_SERVER['DOCUMENT_ROOT'] . '/plantillas/img/logo.png','230','2',55,27,'PNG');
        $pdf->Close();
        $pdf->Output('D',$this->token.'.pdf');
    }
}