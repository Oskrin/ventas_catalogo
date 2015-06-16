<?php

    date_default_timezone_set('America/Guayaquil');
    require_once "PHPExcel.php";

    //VARIABLES DE PHP
    $objPHPExcel = new PHPExcel();
    $Archivo = "reporte_agrupados_prov.xls";

    include '../procesos/base.php';
    session_start();
    conectarse();


    // Propiedades de archivo Excel
    $objPHPExcel->getProperties()->setCreator("DYSSA")
            ->setLastModifiedBy("DYSSA")
            ->setTitle("Reporte XLS")
            ->setSubject("REPORTE DE DIRECTOR AGRUPADO POR EMPRESARIO POR FACTURA")
            ->setDescription("")
            ->setKeywords("")
            ->setCategory("");


    //PROPIEDADES DEL  LA CELDA
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Verdana');
    $objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

    //CABECERA DE LA CONSULTA
    $y = 9;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B" . $y, 'Factura Nro')
            ->setCellValue("C" . $y, 'Código')
            ->setCellValue("D" . $y, 'Artículo')
            ->setCellValue("E" . $y, 'Precio Minorista')
            ->setCellValue("F" . $y, 'Precio Mayorista')
            ->setCellValue("G" . $y, 'Stock');


    $objPHPExcel->getActiveSheet()
            ->getStyle('B9:G8')
            ->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFEEEEEE');

    $objPHPExcel->getActiveSheet()
            ->getStyle('B9:G9')->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $borders = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array('argb' => 'FF000000'),
            )
        ),
    );



    //////////////////////CABECERA DE LA CONSULTA
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B2", 'REPORTE DE DIRECTOR AGRUPADO POR EMPRESARIO POR FACTURA');
    $objPHPExcel->getActiveSheet()
            ->getStyle('B2:G2')->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('B2:G2');

    $objPHPExcel->getActiveSheet()
            ->getStyle("B2:G2")
            ->getFont()
            ->setBold(true)
            ->setName('Verdana')
            ->setSize(18);
    //////////////////////////
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("B4", 'Empresa: ' . $_SESSION['empresa'] . '');
    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('B4:C4');

    $objPHPExcel->getActiveSheet()
            ->getStyle("B4:C4")
            ->getFont()
            ->setBold(false)
            ->setName('Verdana')
            ->setSize(12);
    //////////////////////////
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("D4", 'Propietario: ' . $_SESSION['propietario'] . '');
    $objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('D4:E4');

    $objPHPExcel->getActiveSheet()
            ->getStyle("D4:E4")
            ->getFont()
            ->setBold(false)
            ->setName('Verdana')
            ->setSize(12);
    /////////////////////////
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('PHPExcel logo');
    $objDrawing->setDescription('PHPExcel logo');
    $objDrawing->setPath('../images/logo_empresa.jpg');       // 
    $objDrawing->setHeight(50);                 // sets the image 
    $objDrawing->setWidth(150);                 // sets the image 
    $objDrawing->setCoordinates('G4');    // pins the top-left corner 
    $objDrawing->setOffsetX(0);                // pins the top left 
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


    $consulta = pg_query("select id_director, identificacion_dire ,nombres,direccion,telefono,celular from directores where id_director='$_GET[id]'");
    while ($row = pg_fetch_row($consulta)) {

        $objPHPExcel->getActiveSheet()->getStyle('B6:H6:')->applyFromArray($borders);    
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B6", 'RUC/CI: ' . $row[1]);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:C6');
        $objPHPExcel->getActiveSheet()->getStyle("B6:C6")->getFont()->setBold(false)->setName('Verdana')->setSize(12);  
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E6", 'DIRECTOR: ' . $row[2]);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E6:F6');
        $objPHPExcel->getActiveSheet()->getStyle("E6:F6")->getFont()->setBold(false)->setName('Verdana')->setSize(12);    

        $objPHPExcel->getActiveSheet()->getStyle('B7:H7:')->applyFromArray($borders);    
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B7", 'TELF: ' . $row[4]. '-'. $row[5]);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B7:C7');

        $objPHPExcel->getActiveSheet()->getStyle("B7:C7")->getFont()->setBold(false)->setName('Verdana')->setSize(12);  
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E7", 'DIRECCIÓN: ' . $row[3]);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E7:F7');

        $objPHPExcel->getActiveSheet()->getStyle("E7:F7")->getFont()->setBold(false)->setName('Verdana')->setSize(12);  
    }

    $objPHPExcel->getActiveSheet()->getStyle('B9:H9')->applyFromArray($borders);
    $sql = pg_query("select id_cliente, identificacion, nombres_cli from clientes where id_director = '$_GET[id]' order by id_cliente asc;");
    $cont1 = 0;
    $yyy = 9;
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
                     $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':H'.$yyy)->applyFromArray($borders);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$yyy, 'EMPRESARIO ');
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$yyy.':B'.$yyy);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);    

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$yyy, $row2[0]);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$yyy.':D'.$yyy);                    
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':D'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':D'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                      

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$yyy, 'CI/RUC:');
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$yyy.':E'.$yyy);          
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);          
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$yyy, $row2[1]);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);          
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);          
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);  

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$yyy, 'TOTAL VENTA ');
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);                    
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);   
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);      

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$yyy, $total_sql2);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);          
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);          
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);  
                    
                    $cont_sql2 = 1;                                                                                
                    $yyy = $yyy + 1;
                } 


                $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':H'.$yyy)->applyFromArray($borders);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$yyy, 'NRO FACTURA ');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$yyy.':B'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$yyy, 'FECHA ');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$yyy.':C'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':C'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':C'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$yyy, 'FORMA PAGO ');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$yyy.':D'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$yyy.':D'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$yyy.':D'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);    
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$yyy, 'SUBTOTAL ');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$yyy.':E'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$yyy, 'IVA ');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$yyy, 'DESCUENTO ');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$yyy, 'TOTAL VENTA ');
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);    

                $yyy = $yyy + 1;
                /////////////////////////////////
                $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':H'.$yyy)->applyFromArray($borders);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$yyy, $row2[3]);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$yyy.':B'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$yyy, $row2[4]);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$yyy.':C'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':C'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':C'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$yyy, $row2[5]);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$yyy.':D'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$yyy.':D'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$yyy.':D'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);    
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$yyy, $row2[6]);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$yyy.':E'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$yyy, $row2[7]);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$yyy, $row2[8]);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);    

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$yyy, $row2[9]);
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);    

                $yyy = $yyy + 1;             
                $sql3 = pg_query("select codigo,articulo,categoria,marca, cantidad,precio_venta,total_venta,descuento_producto from  detalle_factura_venta,productos where detalle_factura_venta.cod_productos = productos.cod_productos and id_factura_venta = '".$row2[10]."'");                                                           
                $cont_sql3 = 0;
                $cant = 0;
                $valor_uni = 0;
                $valor_tot = 0;
                $desc_tot = 0;
                $desc = 0;
                
                while ($row3 = pg_fetch_row($sql3)) {     
                    if($cont_sql3 == 0){
                        $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':H'.$yyy)->applyFromArray($borders);

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$yyy, 'COD');
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$yyy.':B'.$yyy);
                        $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                        
                        
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$yyy, 'DESCRIPCIÓN');
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$yyy.':C'.$yyy);
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':C'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':C'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$yyy, 'CATEGORÍA');
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$yyy.':D'.$yyy);
                        $objPHPExcel->getActiveSheet()->getStyle('D'.$yyy.':D'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('D'.$yyy.':D'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$yyy, 'MARCA');
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$yyy.':E'.$yyy);
                        $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$yyy, 'CANT');
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
                        $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$yyy, 'VALOR UNI');
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);

                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$yyy, 'VALOR TOT');
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
                        $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);
                        
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$yyy, '- 30%');
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$yyy.':I'.$yyy);
                        $objPHPExcel->getActiveSheet()->getStyle('I'.$yyy.':I'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->getActiveSheet()->getStyle('I'.$yyy.':I'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);
                           
                        $cont_sql3 = 1;
                        $yyy = $yyy + 1;
                    }                    
                    $desc = 0;
                    
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':H'.$yyy)->applyFromArray($borders);

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("B".$yyy, $row3[0]);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$yyy.':B'.$yyy);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$yyy.':B'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                                                                  

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("C".$yyy, $row3[1]);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$yyy.':C'.$yyy);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':C'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$yyy.':C'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);  

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("D".$yyy, $row3[2]);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$yyy.':D'.$yyy);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$yyy.':D'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$yyy.':D'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                                          

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E".$yyy, $row3[3]);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$yyy.':E'.$yyy);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);  

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$yyy, $row3[4]);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                      
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G".$yyy, $row3[5]);
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);  
                    
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H".$yyy, ($row3[4] * $row3[5]));
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                     

                    $desc = ($row3[4] * $row3[5]) * 0.30;
                    $desc = ($row3[4] * $row3[5]) * ($row3[7] / 100);///ver si es 30%
                    $desc = ($row3[4] * $row3[5]) - $desc;

                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("I".$yyy, number_format($desc,3,',','.'));
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$yyy.':I'.$yyy);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$yyy.':I'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$yyy.':I'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);  
                    
                    $cant = $cant + $row3[4];
                    $valor_uni = $valor_uni + $row3[5];
                    $valor_tot = $valor_tot + ($row3[4] * $row3[5]);
                    $desc_tot = $desc_tot + $desc;
                    $total_final = $total_final + $desc;
                    $yyy = $yyy + 1;                                                            
                }
                
                $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':H'.$yyy)->applyFromArray($borders);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("E".$yyy, "TOTALES");
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E'.$yyy.':E'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$yyy.':E'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$yyy, (number_format($cant,2,',','.')));
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$yyy, (number_format($valor_uni,2,',','.')));
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$yyy, (number_format($valor_tot,2,',','.')));
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$yyy, (number_format($desc_tot,2,',','.')));
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I'.$yyy.':I'.$yyy);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$yyy.':I'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$yyy.':I'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                                                 
                $yyy = $yyy + 2;            
            }                 
            $yyy = $yyy + 1;      
        }       
    }
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':H'.$yyy)->applyFromArray($borders);    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$yyy, "RESUMEN DE PEDIDOS");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':H'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':H'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  
    
    $yyy = $yyy + 1;
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':H'.$yyy)->applyFromArray($borders);    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$yyy, "TOTAL DE PEDIDOS DE EMPRESARIAS");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G".$yyy, "YA DESC. SU 30%");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                                                                  

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H".$yyy, number_format($total_final,2,',','.'));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                                                                  

    $yyy = $yyy + 1;
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':H'.$yyy)->applyFromArray($borders);    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$yyy, "DESCUENTO LIDER");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G".$yyy, "10%");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                                                                  

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H".$yyy, $total_final * 0.10);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);  
    
    $yyy = $yyy + 1;
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':H'.$yyy)->applyFromArray($borders);    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$yyy, "SUBTOTAL");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G".$yyy, "");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                                                                  

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H".$yyy, $total_final -($total_final * 0.10));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);  

    $yyy = $yyy + 1;
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':H'.$yyy)->applyFromArray($borders);    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$yyy, "COST0 ENVIO");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G".$yyy, "");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                                                                  

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H".$yyy, "");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);  
    
    $yyy = $yyy + 1;
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':H'.$yyy)->applyFromArray($borders);    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("F".$yyy, "TOTAL A DEPOSITAR");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$yyy.':F'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('F'.$yyy.':F'.$yyy)->getFont()->setBold(true)->setName('Verdana')->setSize(10);                                                                  
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("G".$yyy, "");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$yyy.':G'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G'.$yyy.':G'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);                                                                  

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue("H".$yyy, $total_final -($total_final * 0.10));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$yyy.':H'.$yyy);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H'.$yyy.':H'.$yyy)->getFont()->setBold(false)->setName('Verdana')->setSize(10);     


    //DATOS DE LA SALIDA DEL EXCEL
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $Archivo . '"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');

    exit;
?>