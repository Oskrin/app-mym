<?php
    require('../../fpdf/fpdf.php');
    include_once('../../admin/class.php');
    include_once('../../admin/funciones_generales.php');
    $class = new constante();   
    date_default_timezone_set('America/Guayaquil'); 
    session_start();

    class PDF extends FPDF {   
        var $widths;
        var $aligns;
        function SetWidths($w) {            
            $this->widths = $w;
        }                       
        function Header() {             
            $this->AddFont('Amble-Regular','','Amble-Regular.php');
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "WINCHAS", 0,1, 'R', 0);      
            $this->SetFont('Arial','B',10);                                                    
            $this->Cell(190, 8, $_SESSION['empresa']['nombre_comercial'], 0,1, 'C',0);
            $imagen = substr($_SESSION['empresa']['imagen'], 1);                                
            $this->Image('../../data/empresa'.$imagen,1,8,40,30);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['empresa']['razon_social']),0,1, 'C',0);                                
            $this->Cell(85, 5, "TEL.: ".utf8_decode($_SESSION['empresa']['telefono1']),0,0, 'R',0);                                
            $this->Cell(60, 5, "CEL.: ".utf8_decode($_SESSION['empresa']['telefono2']),0,1, 'C',0);                                
            $this->Cell(170, 5, utf8_decode( $_SESSION['empresa']['ciudad']),0,1, 'C',0);                                                                                        
            $this->Ln(18);
            $this->SetX(1);
            $this->Cell(50, 5, utf8_decode("Wincha"),1,0, 'C',0);
            $this->Cell(60, 5, utf8_decode("Responsable"),1,0, 'C',0);
            $this->Cell(30, 5, utf8_decode("Cargo"),1,0, 'C',0);        
            $this->Cell(35, 5, utf8_decode("Servicio"),1,0, 'C',0);    
            $this->Cell(20, 5, utf8_decode("Estado"),1,1, 'C',0);   
        }

        function Footer() {            
            $this->SetY(-15);            
            $this->SetFont('Arial','I',8);            
            $this->Cell(0,10,'Pag. '.$this->PageNo().'/{nb}',0,0,'C');
        }               
    }
    $pdf = new PDF('P','mm','a4');
    $pdf->AddPage();
    $pdf->SetMargins(0,0,0,0);
    $pdf->AliasNbPages();
    $pdf->AddFont('Amble-Regular');                    
    $pdf->SetFont('Amble-Regular','',10);       
    $pdf->SetFont('Arial','B',9);   
    $pdf->SetX(5);
    $resultado = $class->consulta("SELECT W.imagen, W.modelo, E.nombres_completos, W.estado FROM winchas W, empleados E WHERE W.id_responsable = E.id");       
    $pdf->SetFont('Amble-Regular','',9);
    $pdf->SetFont('Arial','',8);   
    $pdf->SetX(5);    
    while ($row = $class->fetch_array($resultado)) { 
        $imagen = substr($row[0], 1);               
        $pdf->SetX(1);
        $pdf->Cell(50, 5, maxCaracter(utf8_decode($row[1]),50),0,0, 'L',0);
        $pdf->Cell(60, 5, maxCaracter(utf8_decode($row[2]),50),0,0, 'L',0);
        $pdf->Cell(30, 5, utf8_decode($row[3]),0,0, 'L',0);        
        $pdf->Cell(35, 5, utf8_decode($row[4]),0,0, 'L',0);
        if ($row[5] == 1) {
            $pdf->Cell(20, 5, utf8_decode('Disponible'),0,0, 'L',0);
        } else {
            $pdf->Cell(20, 5, utf8_decode('Ocupado'),0,0, 'L',0);    
        }                         
        $pdf->Ln(5);        
    }    
                                                     
    $pdf->Output();
?>