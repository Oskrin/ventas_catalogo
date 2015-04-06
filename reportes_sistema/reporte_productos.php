<?php
    require('../fpdf/fpdf.php');
    include '../procesos/base.php';
    include '../procesos/funciones.php';
    conectarse();    
    date_default_timezone_set('America/Guayaquil'); 
    session_start()   ;
    class PDF extends FPDF
    {   
        var $widths;
        var $aligns;
        function SetWidths($w){            
            $this->widths=$w;
        }                       
        function Header(){             
            $this->AddFont('Amble-Regular');
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "CLIENTE", 0,1, 'R', 0);      
            $this->SetFont('Arial','B',16);                                                    
            $this->Cell(190, 8, "EMPRESA: ".$_SESSION['empresa'], 0,1, 'C',0);                                
            $this->Image('../images/logo_empresa.jpg',1,8,40,30);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['propietario']),0,1, 'C',0);                                
            $this->Cell(70, 5, "TEL.: ".utf8_decode($_SESSION['telefono']),0,0, 'R',0);                                
            $this->Cell(60, 5, "CEL.: ".utf8_decode($_SESSION['celular']),0,1, 'C',0);                                
            $this->Cell(170, 5, "DIR.: ".utf8_decode($_SESSION['direccion']),0,1, 'C',0);                                
            $this->Cell(170, 5, "SLOGAN.: ".utf8_decode($_SESSION['slogan']),0,1, 'C',0);                                
            $this->Cell(170, 5, utf8_decode( $_SESSION['pais_ciudad']),0,1, 'C',0);                                                                                        
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.5);
            $this->Line(1,43,210,43);
            $this->Ln(5);
            $this->SetX(1);
            $this->Cell(30, 5, utf8_decode("Código"),1,0, 'C',0);
            $this->Cell(95, 5, utf8_decode("Producto"),1,0, 'C',0);
            $this->Cell(30, 5, utf8_decode("Precio Minorista"),1,0, 'C',0);        
            $this->Cell(30, 5, utf8_decode("Precio Mayorista"),1,0, 'C',0);    
            $this->Cell(20, 5, utf8_decode("Stock"),1,1, 'C',0);   
        }
        function Footer(){            
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
    $sql = pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock from productos");       
    $pdf->SetFont('Amble-Regular','',9);   
    $pdf->SetX(5);    
    while($row = pg_fetch_row($sql)){                
        $pdf->SetX(1);                  
        $pdf->Cell(30, 5, utf8_decode($row[0]),0,0, 'L',0);
        $pdf->Cell(95, 5, maxCaracter(utf8_decode($row[2]),50),0,0, 'L',0);
        $pdf->Cell(30, 5, utf8_decode($row[3]),0,0, 'C',0);        
        $pdf->Cell(30, 5, utf8_decode($row[4]),0,0, 'C',0);                         
        $pdf->Cell(20, 5, utf8_decode($row[5]),0,0, 'C',0);                         
        $pdf->Ln(5);        
    }    
                                                     
    $pdf->Output();
?>

<?php

require('../reportes/dompdf/dompdf_config.inc.php');
session_start();
$codigo = '<html> 
    <head> 
        <link rel="stylesheet" href="../css/estilosAgrupados.css" type="text/css" /> 
    </head> 
    <body>
        <header>
            <img src="../images/logo_empresa.jpg" />
            <div id="me">
                <h2 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['empresa'] . '</h2>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['slogan'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['propietario'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['direccion'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">Telf: ' . $_SESSION['telefono'] . ' Cel:  ' . $_SESSION['celular'] . '</h4>
                <h4 style="text-align:center;border:solid 0px;width:100%;">' . $_SESSION['pais_ciudad'] . '</h4>
            </div>        
    </header>        
    <hr>
    <div id="linea">
        <h3>LISTA DE PRODUCTOS EN EXISTENCIA MÍNIMA</h3>
    </div>';
include '../procesos/base.php';

$sql = pg_query("select codigo,cod_barras,articulo,iva_minorista,iva_mayorista,stock from productos");
$codigo.='<table border=0>';
$codigo.='<tr style="font-weight:bold;">                
    <td style="width:180px;text-align:center;">Código</td>
    <td style="width:300px;text-align:center;">Producto</td>
    <td style="width:100px;text-align:center;">Precio Minorista</td>
    <td style="width:100px;text-align:center;">Precio Mayorista</td>
    <td style="width:60px;text-align:center;">Stock</td>
    </tr>
    <tr><td colspan=6><hr></td></tr>';
while ($row = pg_fetch_row($sql)) {
    $codigo.='<tr style="font-size:10px;">                
        <td style="width:180px;text-align:left;">' . $row[0] . '</td>
        <td style="width:300px;text-align:left;">' . $row[2] . '</td>
        <td style="width:100px;text-align:center;">' . $row[3] . '</td>
        <td style="width:100px;text-align:center;">' . $row[4] . '</td>
        <td style="width:60px;text-align:center;">' . $row[5] . '</td>
        </tr>';
}
$codigo.='</table>';
$codigo.='</body></html>';
$codigo = utf8_decode($codigo);

$dompdf = new DOMPDF();
$dompdf->load_html($codigo);
ini_set("memory_limit", "100M");
$dompdf->set_paper("A4", "portrait");
$dompdf->render();
$dompdf->stream('reporte_agrupados_prov.pdf', array('Attachment' => 0));
?>