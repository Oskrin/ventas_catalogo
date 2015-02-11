<?php
include '../fdpf/fpdf.php';
include '../procesos/base.php';
conectarse();
//header("Content-Type: text/html; charset=iso-8859-1 ");
date_default_timezone_set('UTC');
$fecha= date("Y-m-d");
class PDF extends FPDF

{
    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function Row($data)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            
            //$this->Rect($x,$y,$w,$h);

            $this->MultiCell( $w,5,$data[$i],0,$a,false);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }
    

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

    
}
date_default_timezone_set('America/Guayaquil');
$fecha=date('Y-m-d H:i:s', time());   

$pdf = new PDF('L','mm',array(210,170));
$pdf->AddPage();
$pdf->SetMargins(0,0,0,0);
$pdf->SetFont('Arial','',10);	   
$sql=pg_query("select id_facturas_novalidas,comprobante,identificacion,nombres_cli,direccion_cli,clientes.telefono,clientes.ciudad,fecha_actual,forma_pago,fecha_actual,nombre_usuario,apellido_usuario,directores.nombres,tarifa0,tarifa12,iva_venta,descuento_venta,total_venta from facturas_novalidas,clientes,usuario,directores where facturas_novalidas.id_cliente=clientes.id_cliente  and facturas_novalidas.id_usuario=usuario.id_usuario and clientes.id_director = directores.id_director and facturas_novalidas.id_facturas_novalidas='$_GET[id]'");    

$tarifa0 = 0;
$tarifa12 = 0;
$iva_venta = 0;
$descuento_venta = 0;
$total_venta = 0;


while($row = pg_fetch_row($sql)){        
    $pdf->SetFont('Arial','',9);	   
    $pdf->Text(25, 37, utf8_decode('' . strtoupper($row[3])), 0, 'C', 0); ////CLIENTE (X,Y) 
    $pdf->Text(155, 37, utf8_decode('' . strtoupper($row[12])), 0, 'C', 0); ////DIRECTOR (X,Y)    
    $pdf->Text(25, 43, utf8_decode('' . strtoupper($row[7])), 0, 'C', 0); ///FECHA (X,Y)  
    $pdf->Text(155, 43, utf8_decode('' . strtoupper($row[2])), 0, 'C', 0); ///RUC CI(X,Y)    
    $pdf->Text(25, 49, utf8_decode('' . strtoupper($row[4])), 0, 'C', 0); ///DIRECCION(X,Y)             
    $pdf->Ln(1);
    
}
$pdf->SetY(60);///PARA LOS DETALLES
$pdf->SetFont('Arial','',9);	   
$pdf->SetWidths(array(10, 120, 25, 35,30));//TAMAÑOS DE LA TABLA DE DETALLES PRODUCTOS
$pdf->SetFillColor(85, 107, 47);
$sql = pg_query("select detalle_facturas_novalidas.cantidad,productos.articulo,detalle_facturas_novalidas.precio_venta,detalle_facturas_novalidas.total_venta,codigo from facturas_novalidas,detalle_facturas_novalidas,productos where facturas_novalidas.id_facturas_novalidas=detalle_facturas_novalidas.id_facturas_novalidas and detalle_facturas_novalidas.cod_productos=productos.cod_productos and detalle_facturas_novalidas.id_facturas_novalidas='$_GET[id]'");
$numfilas = pg_num_rows($sql);
$total_items = 0;
for ($i = 0; $i < $numfilas; $i++) {
    $pdf->SetX(8);
    $fila = pg_fetch_row($sql);
    $pdf->SetFont('Arial','',9);	   
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0);     
    $total_items = $total_items + $fila[0];

    $sub1 =(number_format(($fila[3] / 1.12) / $fila[0],2,',','.'));
    $sub2 = (number_format(($fila[3] / 1.12),2,',','.')); 
    $pdf->Row(array(utf8_decode($fila[0]), utf8_decode($fila[4]).' '.utf8_decode($fila[1]),utf8_decode($fila[2]),$sub1,$sub2));           
}
$pdf->Text(22, 135, utf8_decode('Nro. de Items: ' . $total_items ), 0, 'C', 0); ////SUBTOTAL (X,Y) 
$sql = pg_query("select facturas_novalidas.descuento_venta,facturas_novalidas.tarifa0,facturas_novalidas.tarifa12,facturas_novalidas.iva_venta,facturas_novalidas.total_venta from facturas_novalidas where facturas_novalidas.id_facturas_novalidas='$_GET[id]'");      
while($row = pg_fetch_row($sql))
{
	$pdf->SetFont('Arial','',9);	   
	$pdf->Text(200, 143, utf8_decode('' . strtoupper($row[2])), 0, 'C', 0); ////SUBTOTAL (X,Y)    
	$pdf->Text(200, 149, utf8_decode('' . strtoupper($row[0])), 0, 'C', 0); ////IVA12 (X,Y)    
	$pdf->Text(200, 156, utf8_decode('' . strtoupper($row[3])), 0, 'C', 0); ///IVA0 (X,Y)  
	$pdf->Text(200, 162, utf8_decode('' . strtoupper($row[4])), 0, 'C', 0); ///TOTAL(X,Y)   
}


$pdf->Output();
?>