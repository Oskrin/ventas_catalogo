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
            $this->AddFont('Amble-Regular','','Amble-Regular.php');
            $this->AddFont('Amble-Regular');
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "CLIENTE", 0,1, 'R', 0);      
            $this->SetFont('Arial','B',16);                                                    
            $this->Cell(170, 8, $_SESSION['empresa'], 0,1, 'C',0);                                
            $this->Image('../images/logo_empresa.jpg',1,8,40,30);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['propietario']),0,1, 'C',0);
            $this->Cell(70, 5, "TEL.: ".utf8_decode($_SESSION['telefono']),0,0, 'R',0);
            $this->Cell(60, 5, "CEL.: ".utf8_decode($_SESSION['celular']),0,1, 'C',0);
            $this->Cell(170, 5, "DIR.: ".utf8_decode($_SESSION['direccion']),0,1, 'C',0);
            $this->Cell(170, 5, "SLOGAN.: ".utf8_decode($_SESSION['slogan']),0,1, 'C',0);
            $this->Cell(170, 5, utf8_decode( $_SESSION['pais_ciudad']),0,1, 'C',0);
            $this->SetFont('Arial','B',12);
            $this->Cell(170, 5, utf8_decode("FALTANTE DE PEDIDOS"),0,1, 'C',0);           
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(80, 5, utf8_decode("DESDE: ".$_GET['inicio']),0,0, 'C',0);           
            $this->Cell(80, 5, utf8_decode("HASTA: ".$_GET['fin']),0,1, 'C',0);           
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.3);
            $this->Line(1,50,210,50);
            $this->Ln(5);
            $this->SetX(1);            
            $this->Cell(30, 5, utf8_decode("Código"),1,0, 'C',0);
            $this->Cell(95, 5, utf8_decode("Producto"),1,0, 'C',0);
            $this->Cell(30, 5, utf8_decode("Total Pedido"),1,0, 'C',0);        
            $this->Cell(30, 5, utf8_decode("Stock"),1,0, 'C',0);    
            $this->Cell(20, 5, utf8_decode("Faltante"),1,1, 'C',0);   
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

    $codigo_producto = array();
    $nombre_producto = array();
    $cantidad_producto = array();
    $stock_producto = array();
    $sql = pg_query("select id_proforma from proforma where fecha_actual between '".$_GET['inicio']."' and '".$_GET['fin']."' and estado = 'Activo'");       
    while ($row = pg_fetch_row($sql)) {
        $sql1 = pg_query("select detalle_proforma.cod_productos,cantidad,codigo,productos.articulo,productos.stock from detalle_proforma,productos where detalle_proforma.cod_productos = productos.cod_productos and detalle_proforma.estado = 'Activo' and id_proforma = '".$row[0]."'");                
        while($row1 = pg_fetch_row($sql1)){                        
            $contador;
            $posicion = -1;
            $cont = 0;
            if(count($codigo_producto) > 0){                                
                for($contador=0; $contador < count($codigo_producto); $contador++){
                    if($codigo_producto[$contador] == $row1[2]) {
                        $posicion = $contador;
                        $codigo_producto[$contador] = $row1[2];                
                        $nombre_producto[$contador] = $row1[3];                
                        $cantidad_producto[$contador] = $cantidad_producto[$contador] + $row1[1];                
                        $stock_producto[$contador] = $row1[4];                        
                        $cont = 1;
                        break;
                    }                                        
                }
                if($cont == 0){
                    $codigo_producto[] = $row1[2];                
                    $nombre_producto[] = $row1[3];                
                    $cantidad_producto[] = $row1[1];                
                    $stock_producto[] = $row1[4];                        
                }
            }else{                
                $codigo_producto[] = $row1[2];                
                $nombre_producto[] = $row1[3];                
                $cantidad_producto[] = $row1[1];                
                $stock_producto[] = $row1[4];                
            }          
        }
    }
    //print_r($cantidad_producto);
    $pdf->SetFont('Amble-Regular','',9);   
    $pdf->SetX(5);        
    for($cont_vector = 0; $cont_vector < count($codigo_producto); $cont_vector++){
        $pdf->SetX(1);                  
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(30, 5, utf8_decode($codigo_producto[$cont_vector]),0,0, 'L',0);
        $pdf->Cell(95, 5, maxCaracter(utf8_decode($nombre_producto[$cont_vector]),50),0,0, 'L',0);
        $pdf->Cell(30, 5, utf8_decode($cantidad_producto[$cont_vector]),0,0, 'C',0);        
        $pdf->Cell(30, 5, utf8_decode($stock_producto[$cont_vector]),0,0, 'C',0);                         
        $faltante = $stock_producto[$cont_vector] - $cantidad_producto[$cont_vector];
        if($faltante > 0){
            $pdf->SetTextColor(240,11,11);
            $pdf->Cell(20, 5, utf8_decode('0'),0,0, 'C',0);                             
        }else{
            $pdf->SetTextColor(240,11,11);
            $pdf->Cell(20, 5, utf8_decode(abs($faltante)),0,0, 'C',0);                                 
        }        
        $pdf->Ln(5);                      
    }   
                                                     
    $pdf->Output();
?>

