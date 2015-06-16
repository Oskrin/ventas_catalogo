<?php
    require('../../fpdf/fpdf.php');
    include '../../procesos/base.php';
    include '../../procesos/funciones.php';
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
            $this->SetFont('Amble-Regular','',10);        
            $fecha = date('Y-m-d', time());
            $this->SetX(1);
            $this->SetY(1);
            $this->Cell(20, 5, $fecha, 0,0, 'C', 0);                         
            $this->Cell(150, 5, "CLIENTE", 0,1, 'R', 0);      
            $this->SetFont('Arial','B',16);                                                    
            $this->Cell(190, 8,$_SESSION['empresa'], 0,1, 'C',0);                                
            $this->Image('../../images/logo_empresa.jpg',5,8,30,28);
            $this->SetFont('Amble-Regular','',10);        
            $this->Cell(180, 5, "PROPIETARIO: ".utf8_decode($_SESSION['propietario']),0,1, 'C',0);
            $this->SetX(1);
            $this->Cell(80, 5, "TEL.: ".utf8_decode($_SESSION['telefono']),0,0, 'R',0);                                
            $this->Cell(80, 5, "CEL.: ".utf8_decode($_SESSION['celular']),0,1, 'C',0);                                
            $this->SetX(1);
            $this->Cell(180, 5, "DIR.: ".utf8_decode($_SESSION['direccion']),0,1, 'C',0);                                
            $this->SetX(1);
            $this->Cell(180, 5, "SLOGAN.: ".utf8_decode($_SESSION['slogan']),0,1, 'C',0);                                
            $this->SetX(1);
            $this->Cell(180, 5, utf8_decode( $_SESSION['pais_ciudad']),0,1, 'C',0);
            $this->SetX(1);                                                                             
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(0.5);
            $this->SetFillColor(120,120,120);
            $this->Line(1,50,210,50);            
            $this->SetFont('Arial','B',12);                                                                
            $this->Cell(190, 5, utf8_decode("REPORTE DE DIRECTOR AGRUPADO POR EMPRESARIO POR FACTURA"),0,1, 'C',0);                                                                                                                
            $this->SetFont('Arial','B',10);                                                                            
            $this->Cell(90, 5, utf8_decode($_GET['inicio']),0,0, 'R',0);                                                                                        
            $this->Cell(40, 5, utf8_decode($_GET['fin']),0,1, 'C',0);                                      
            $this->SetFont('Amble-Regular','',10);                                                                      
            $this->Ln(5);              
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
    $pdf->SetFont('Amble-Regular','',9); 
    
    $consulta = pg_query("select id_director, identificacion_dire ,nombres,direccion,telefono,celular from directores where id_director='$_GET[id]'");
    while ($row = pg_fetch_row($consulta)) {
        $pdf->SetX(1); 
        $pdf->SetFillColor(187, 179, 180);            
        $pdf->Cell(25, 6, maxCaracter(utf8_decode('RUC/CI:'),15),1,0, 'L',0);
        $pdf->Cell(60, 6, maxCaracter(utf8_decode($row[1]),15),1,0, 'L',0);
        $pdf->Cell(25, 6, maxCaracter(utf8_decode('DIRECTOR'),15),1,0, 'L',0);
        $pdf->Cell(95, 6, maxCaracter(utf8_decode($row[2]),50),1,1, 'L',0);
        $pdf->SetX(1); 
        $pdf->Cell(25, 6, maxCaracter(utf8_decode('TELF:'),15),1,0, 'L',0);
        $pdf->Cell(60, 6, maxCaracter(utf8_decode($row[4].'-'.$row[5]),20),1,0, 'L',0);
        $pdf->Cell(25, 6, maxCaracter(utf8_decode('DIRECCIÓN:'),15),1,0, 'L',0);
        $pdf->Cell(95, 6, maxCaracter(utf8_decode($row[3]),50),1,1, 'L',0);
    }    
    $pdf->Ln(3);    
    $pdf->SetX(1);                
    $sql = pg_query("select id_cliente, identificacion, nombres_cli from clientes where id_director = '$_GET[id]' order by id_cliente asc;");
    $cont1 = 0;
    $cont2 = 0;
    $cant = 0;
    $valor_uni = 0;
    $valor_tot = 0;
    $desc_tot = 0;
    $total_final = 0;
    $temp2 = 0;
    while ($row = pg_fetch_row($sql)) {                
        $temp = 0;                     
        $total_sql2 = 0;
        $sql2 = pg_query("select clientes.nombres_cli,identificacion,total_venta,num_factura,fecha_actual,forma_pago,tarifa12,iva_venta,descuento_venta,total_venta,id_factura_venta from factura_venta,clientes where factura_venta.id_cliente = clientes.id_cliente and factura_venta.id_cliente = '".$row[0]."' and fecha_actual between '".$_GET['inicio']."' and '".$_GET['fin']."'"); 
        if(pg_num_rows($sql2)){
            $cont_sql2 = 0;
            while ($row2 = pg_fetch_row($sql2)) {            
                $total_sql2 =$total_sql2 + $row2[2];
                if($cont_sql2 == 0){
                    $pdf->SetX(1);                                    
                    $pdf->SetFillColor(247, 219, 181);
                    $pdf->Cell(25, 6, utf8_decode("EMPRESARI@"),1,0, 'C',1);
                    $pdf->Cell(70, 6, maxCaracter(utf8_decode($row2[0]),40),1,0, 'L',1);
                    $pdf->Cell(20, 6, utf8_decode("CI/RUC"),1,0, 'C',1);        
                    $pdf->Cell(30, 6, maxCaracter(utf8_decode($row2[1]),20),1,0, 'L',1);                            
                    $pdf->Cell(30, 6, utf8_decode("TOTAL VENTA"),1,0, 'C',2);        
                    $pdf->Cell(30, 6, maxCaracter(utf8_decode($total_sql2),15),1,1, 'L',1);                                
                    $cont_sql2 = 1;                                                            
                    $pdf->Ln(3);    
                } 


                $pdf->SetX(1);  
                $pdf->Cell(40, 6, utf8_decode("NRO FACTURA"),1,0, 'C',0);       
                $pdf->Cell(30, 6, utf8_decode("FECHA"),1,0, 'C',0);       
                $pdf->Cell(30, 6, utf8_decode("FORMA PAGO"),1,0, 'C',0);       
                $pdf->Cell(25, 6, utf8_decode("SUBTOTAL"),1,0, 'C',0);       
                $pdf->Cell(25, 6, utf8_decode("IVA"),1,0, 'C',0);       
                $pdf->Cell(30, 6, utf8_decode("DESCUENTO"),1,0, 'C',0);       
                $pdf->Cell(25, 6, utf8_decode("TOTAL VENTA"),1,1, 'C',0);                                       

                $pdf->SetX(1);  
                $pdf->SetFillColor(120,120,120);
                $pdf->Cell(40, 6, maxCaracter(utf8_decode($row2[3]),40),1,0, 'C',1);                            
                $pdf->Cell(30, 6, maxCaracter(utf8_decode($row2[4]),20),1,0, 'C',1);                            
                $pdf->Cell(30, 6, maxCaracter(utf8_decode($row2[5]),20),1,0, 'C',1);                            
                $pdf->Cell(25, 6, maxCaracter(utf8_decode($row2[6]),15),1,0, 'C',1);                            
                $pdf->Cell(25, 6, maxCaracter(utf8_decode($row2[7]),15),1,0, 'C',1);                            
                $pdf->Cell(30, 6, maxCaracter(utf8_decode($row2[8]),15),1,0, 'C',1);                            
                $pdf->Cell(25, 6, maxCaracter(utf8_decode($row2[9]),15),1,1, 'C',1);


                $sql3 = pg_query("select codigo,articulo,categoria,marca, cantidad,precio_venta,total_venta,descuento_producto from  detalle_factura_venta,productos where detalle_factura_venta.cod_productos = productos.cod_productos and id_factura_venta = '".$row2[10]."'");                                                           
                $cont_sql3 = 0;
                $cant = 0;
                $valor_uni = 0;
                $valor_tot = 0;
                $desc_tot = 0;
                $desc = 0;
                while ($row3 = pg_fetch_row($sql3)) {     
                    if($cont_sql3 == 0){
                        $pdf->SetX(1);  
                        $pdf->Cell(25, 6, utf8_decode("COD"),1,0, 'C',0);       
                        $pdf->Cell(60, 6, utf8_decode("DESCRIPCIÓN"),1,0, 'C',0);       
                        $pdf->Cell(20, 6, utf8_decode("CATEGORÍA"),1,0, 'C',0);       
                        $pdf->Cell(20, 6, utf8_decode("MARCA"),1,0, 'C',0);       
                        $pdf->Cell(20, 6, utf8_decode("CANT"),1,0, 'C',0);       
                        $pdf->Cell(20, 6, utf8_decode("VALOR UNI"),1,0, 'C',0);       
                        $pdf->Cell(20, 6, utf8_decode("VALOR TOT"),1,0, 'C',0);       
                        $pdf->Cell(20, 6, utf8_decode("- 30%"),1,1, 'C',0);     
                        $cont_sql3 = 1;
                    }                    
                    $desc = 0;
                    $pdf->SetX(1);  
                    $pdf->Cell(25, 6, maxCaracter(utf8_decode($row3[0]),15),0,0, 'L',0);
                    $pdf->Cell(60, 6, maxCaracter(utf8_decode($row3[1]),30),0,0, 'L',0);
                    $pdf->Cell(20, 6, maxCaracter(utf8_decode($row3[2]),10),0,0, 'L',0);
                    $pdf->Cell(20, 6, maxCaracter(utf8_decode($row3[3]),10),0,0, 'L',0);
                    $pdf->Cell(20, 6, maxCaracter(utf8_decode($row3[4]),50),0,0, 'C',0);
                    $pdf->Cell(20, 6, maxCaracter(utf8_decode($row3[5]),50),0,0, 'C',0);
                    $pdf->Cell(20, 6, maxCaracter(utf8_decode($row3[4] * $row3[5]),50),0,0, 'C',0);
                    //$desc = ($row3[4] * $row3[5]) * 0.30;
                    $desc = ($row3[4] * $row3[5]) * ($row3[7] / 100);///ver si es 30%
                    $desc = ($row3[4] * $row3[5]) - $desc;
                    $pdf->Cell(20, 6, maxCaracter(number_format($desc,3,',','.'),10),0,1, 'C',0);
                    $cant = $cant + $row3[4];
                    $valor_uni = $valor_uni + $row3[5];
                    $valor_tot = $valor_tot + ($row3[4] * $row3[5]);
                    $desc_tot = $desc_tot + $desc;
                    $total_final = $total_final + $desc;
                }
                $pdf->SetX(1);                                             
                $pdf->Cell(205, 0, utf8_decode(""),1,1, 'R',0);
                $pdf->Cell(126, 6, utf8_decode("Totales"),0,0, 'R',0);
                $pdf->Cell(20, 6, maxCaracter((number_format($cant,2,',','.')),20),0,0, 'C',0);
                $pdf->Cell(20, 6, maxCaracter((number_format($valor_uni,2,',','.')),20),0,0, 'C',0);
                $pdf->Cell(20, 6, maxCaracter((number_format($valor_tot,2,',','.')),20),0,0, 'C',0);
                $pdf->Cell(20, 6, maxCaracter((number_format($desc_tot,2,',','.')),20),0,1, 'C',0);
                $pdf->Ln(3);

            }           

            
        }        
    }
    $pdf->SetX(1);                                             
    $pdf->Ln(8);              
    $pdf->Cell(207, 0, utf8_decode(""),1,1, 'R',0);
    $pdf->Cell(207, 6, utf8_decode("RESUMEN DE PEDIDOS"),0,1, 'R',0);

    $pdf->Cell(127, 6, utf8_decode("TOTAL EN PEDIDOS DE EMPRESARIAS"),0,0, 'R',0);
    $pdf->Cell(40, 6, utf8_decode("YA DESC. SU 30%"),1,0, 'C',0);
    $pdf->Cell(40, 6, number_format($total_final,2,',','.'),1,1, 'C',0);

    $pdf->Cell(127, 6, utf8_decode("DESCUENTO LIDER"),0,0, 'R',0);
    $pdf->Cell(40, 6, utf8_decode("10%"),1,0, 'C',0);
    $pdf->Cell(40, 6, utf8_decode($total_final * 0.10),1,1, 'C',0);

    $pdf->Cell(127, 6, utf8_decode("SUBTOTAL"),0,0, 'R',0);
    $pdf->Cell(40, 6, utf8_decode(""),1,0, 'C',0);
    $pdf->Cell(40, 6, $total_final -($total_final * 0.10),1,1, 'C',0);    
    
    $pdf->Cell(127, 6, utf8_decode("COST0 ENVIO"),0,0, 'R',0);
    $pdf->Cell(40, 6, utf8_decode(""),1,0, 'C',0);
    $pdf->Cell(40, 6, utf8_decode(""),1,1, 'C',0);

    $pdf->Cell(127, 6, utf8_decode("TOTAL A DEPOSITAR"),0,0, 'R',0);
    $pdf->Cell(40, 6, '',1,0, 'C',0);
    $pdf->Cell(40, 6, $total_final -($total_final * 0.10),1,1, 'C',0);
                                                        
    $pdf->Ln(3);              
    $pdf->Output();
?>