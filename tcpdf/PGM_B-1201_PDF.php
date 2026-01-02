<?php
session_start();
error_reporting(E_ALL);
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){

    header("location: ../index.php");
    exit;
  }else{
    $iniciales = $_SESSION["iniciales"];
    $calidad = $_SESSION["calidad"];
    $rut = $_SESSION["rut"];

    require_once "../../config.php";
    require_once "../tcpdf/tcpdf.php";
    ob_end_clean();
  }

?>
<?php

function formateo_rut($rut_param){
    
    $parte4 = substr($rut_param, -1); // seria solo el numero verificador
    $parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq 
    $parte2 = substr($rut_param, -7,3); 
    $parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq

    return $parte1.".".$parte2.".".$parte3."-".$parte4;
}

$i = 0;

function contar($i){
    $i++;
    return $i;
}
$nro_orden_compra = $_GET['NumOrdenCompra'];

$correo_proveedor = $ciudad_comuna = $bodega = $proveedor = $atencion = $cotizacion = $fecha_emision = $forma_pago = $fecha_entrega = $dias_plazo = $lugar_entrega = $moneda = $subtotal = $porcentaje_descuento = $descuento = $neto = $porcentaje_iva = $iva = $total_gral = $usuario = $observacion = $nombre_proveedor = $direccion_proveedor = $telefono_proveedor = $rut_proveedor = "";

$sql1 = "SELECT * FROM orden_compra INNER JOIN proveedores ON orden_compra.proveedor = proveedores.rut_proveedor INNER JOIN forma_pagos AS f ON f.forma_pago = orden_compra.forma_pago INNER JOIN monedas AS m ON orden_compra.moneda = m.moneda WHERE orden_compra.nro_orden_compra = ?";
$sql2 = "SELECT * FROM orden_compra_movimiento LEFT JOIN orden_compra ON orden_compra_movimiento.nro_orden_compra = orden_compra.nro_orden_compra LEFT JOIN productos ON productos.producto = orden_compra_movimiento.producto LEFT JOIN unidades ON productos.unidad = unidades.unidad LEFT JOIN centro_costos ON productos.centro_costo = centro_costos.centro_costo WHERE orden_compra.nro_orden_compra = ?";

$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $nro_orden_compra);
$stmt->execute();
$resultado = $stmt->get_result();
$datos_orden_compra = $resultado->fetch_row();

//DATOS ORDEN DE COMPRA
if(isset($datos_orden_compra[1])){
    $bodega = $datos_orden_compra[1];
}else{
    $bodega = "S/D";
}
if(isset($datos_orden_compra[2])){
    $proveedor = $datos_orden_compra[2];
}else{
    $proveedor = "S/D";
}
if(isset($datos_orden_compra[3])){
    $atencion = $datos_orden_compra[3];
}else{
    $atencion = "S/D";
}
if(isset($datos_orden_compra[4])){
    $cotizacion = $datos_orden_compra[4];
}else{
    $cotizacion = "S/D";
}
if(isset($datos_orden_compra[5])){
    $fecha_emision = date('d-m-Y', strtotime($datos_orden_compra[5]));
}else{
    $fecha_emision = "S/D";
}
if(isset($datos_orden_compra[31])){
    $forma_pago = $datos_orden_compra[31];
}else{
    $forma_pago = "S/D";
}
if(isset($datos_orden_compra[7])){
    $fecha_entrega = date('d-m-Y', strtotime($datos_orden_compra[7]));
}else{
    $fecha_entrega = "S/D";
}
if(isset($datos_orden_compra[8])){
    $dias_plazo = $datos_orden_compra[8];
}else{
    $dias_plazo = "S/D";
}
if(isset($datos_orden_compra[9])){
    $lugar_entrega = $datos_orden_compra[9];
}else{
    $lugar_entrega = "S/D";
}
if(isset($datos_orden_compra[32])){
    $moneda = $datos_orden_compra[34];
}else{
    $moneda = "S/D";
}
if(isset($datos_orden_compra[11])){
    $subtotal = $datos_orden_compra[11];
}else{
    $subtotal = "S/D";
}
if(isset($datos_orden_compra[12])){
    $porcentaje_descuento = $datos_orden_compra[12];
}else{
    $porcentaje_descuento = "S/D";
}
if(isset($datos_orden_compra[13])){
    $descuento = $datos_orden_compra[13];
}else{
    $descuento = "S/D";
}
if(isset($datos_orden_compra[14])){
    $neto = $datos_orden_compra[14];
}else{
    $neto = "S/D";
}
if(isset($datos_orden_compra[15])){
    $porcentaje_iva = $datos_orden_compra[15];
}else{
    $porcentaje_iva = "S/D";
}
if(isset($datos_orden_compra[16])){
    $iva = $datos_orden_compra[16];
}else{
    $iva = "S/D";
}
if(isset($datos_orden_compra[17])){
    $total_gral = $datos_orden_compra[17];
}else{
    $total_gral = "S/D";
}
if(isset($datos_orden_compra[18])){
    $usuario = $datos_orden_compra[18];
}else{
    $usuario = "S/D";
}
if(isset($datos_orden_compra[19])){
    $observacion = $datos_orden_compra[19];
}else{
    $observacion = "S/D";
}
if(isset($datos_orden_compra[20])){
    $rut_proveedor = formateo_rut($datos_orden_compra[20]);
}else{
    $rut_proveedor = "S/D";
}
if(isset($datos_orden_compra[21])){
    $nombre_proveedor = $datos_orden_compra[21];
}else{
    $nombre_proveedor = "S/D";
}
if(isset($datos_orden_compra[24])){
    $direccion_proveedor = $datos_orden_compra[24];
}else{
    $direccion_proveedor = "S/D";
}
if(isset($datos_orden_compra[26])){
    $ciudad_comuna = $datos_orden_compra[26];
}else{
    $ciudad_comuna = "S/D";
}
if(isset($datos_orden_compra[27])){
    $telefono_proveedor = $datos_orden_compra[27];
}else{
    $telefono_proveedor = "S/D";
}
if(isset($datos_orden_compra[28])){
    $correo_proveedor = $datos_orden_compra[28];
}else{
    $correo_proveedor = "S/D";
}
if(isset($datos_orden_compra[31])){
    $forma_pago = $datos_orden_compra[31];
}else{
    $forma_pago = "S/D";
}
//FIN DATOS ORDEN DE COMPRA

$stmt = $conn->prepare($sql2);
$stmt->bind_param("s", $nro_orden_compra);
$stmt->execute();
$datos_detalle = $stmt->get_result();

//DATOS PÁGINA
header("Content-Type: application/json; charset=UTF-8");
$pdf = new TCPDF('P', PDF_UNIT, 'letter', true, 'UTF-8', false);//L: Landscape, P: Portrait

class MYPDF extends TCPDF {
    //Cabecera
    public function Header() {
        $this->Cell(0, 15, '<<>>', 0, false, 'C', 0, '', 0, false, 'M', 'M');

    }

    // Pie de página en blanco

}

// set document information
$pdf->SetCreator('ANDES Suministros SPA');
$pdf->SetAuthor('ANDES Suministros SPA');
$pdf->SetTitle('Orden de Compra');
$pdf->SetSubject('Orden de Compra');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData('', 20, '');

// set margins
$pdf->SetMargins(5, 20, 5);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setPrintFooter(true);
$pdf->setPrintHeader(false);
// set auto page breaks
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
    require_once(dirname(__FILE__).'/lang/spa.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'B', 15);

// add a page
$pdf->AddPage();
$pdf->setJPEGQuality(75);
$pdf->SetFont('helvetica', '', 8);
$pdf->SetXY(5,5);
$tbl1 = <<<EOD
<table style="width:100%; border: 0px solid white; font-size:10px;">
    <tr>
        <th style="width:10%"></th>
        <th style="font-weight:900; text-align:center; border: 0px solid white; width:70%: font-size: 15px;"><h3>ORDEN DE COMPRA</h3><span style="">Servicios Eléctricos <span style="color: #101F8F;">T <span style="color: #A80000;">&</span> M</span> LTDA</span><br><span>RUT: : 76.313.839-9</span><br></th>
    </tr>
</table>
EOD;
$tbl_head = <<<EOD
<table style="width:100%; border: 1px solid black">
    <tr>
        <th>CODIGO</th>
        <td>T&M-SGI-FO-10</td>
        <th>PÁGINA: 1 de 1</th>
        <th>VERSION : 2</th>
        <th>FECHA : 13-12-2022</th>
    </tr>
</table>
EOD;
$pdf->writeHTML($tbl1, true, false, false, false, '');
$pdf->SetXY(87,21);
$pdf->SetFont('', '', 7);
$pdf->Cell(15,0,'AVDA. BOMBERO VILLALOBOS # 660 - RANCAGUA',0,0,'C',0,'');
$pdf->SetXY(87,24);
$pdf->SetFont('', '', 7);
$pdf->Cell(15,0,'Fabricacion y Reparacion de Equipos electricos',0,0,'C',0,'');

$pdf->SetXY(175,5);
$pdf->Cell(15,4,'CÓDIGO:',1,1,'L',0,'');
$pdf->SetXY(175,9);
$pdf->Cell(15,4,'PÁGINA:',1,1,'L',0,'');
$pdf->SetXY(175,13);
$pdf->Cell(15,4,'VERSIÓN:',1,1,'L',0,'');
$pdf->SetXY(175,17);
$pdf->Cell(15,4,'FECHA:',1,1,'L',0,'');

$pdf->SetXY(175,22);
$pdf->Cell(0,4,'O/C:',1,1,'C',0,'');
$pdf->SetXY(175,26);
$pdf->Cell(15,4,'N°:',1,1,'L',0,'');

$pdf->SetXY(190,26);
$pdf->Cell(15,4,$nro_orden_compra,1,1,'C',0,'');

//-- CÓDIGO SGI
$pdf->SetFont('helvetica','B',5);
$pdf->SetXY(190,5);
$pdf->Cell(15,4,"T&M-SGI-FO-10",1,1,'C',0,'');
$PgNo= $pdf->getAliasNumPage() . " de " . $pdf->getAliasNbPages();
$pdf->SetXY(190,9);
$pdf->Cell(15,4,$PgNo,1,1,'L',0,'');
$pdf->SetXY(190,13);
$pdf->Cell(15,4,"2",1,1,'C',0,'');
$pdf->SetXY(190,17);
$pdf->Cell(15,4,$fecha_emision,1,1,'C',0,'');
//--

$pdf->SetXY(8,6);
$pdf->Image('../images/LOGO_TYM.jpg', '', '', 20, 20, '', '', '', false, 600, 'T', false, false, 0, false, false, false);

$pdf->SetXY(9,30);
$pdf->Ln(3);
// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table style="width:100%; font-size: 7px; font-weight: 300; border-collapse: separate;">
        <thead>
            <tr>
                <th style="color:#292924;">ID Proveedor</th>
                <td style="border: 1px solid #000;">$nombre_proveedor</td>
                <th style="color:#292924;">Atención</th>
                <td style="border: 1px solid #000;">$atencion</td>
            </tr>
            <tr>
                <th style="color:#292924;">Nombre</th>
                <td style="border-bottom: 1px solid #000;">$nombre_proveedor</td>
                <th style="color:#292924;">Cotización</th>
                <td style="border-bottom: 1px solid #000;">$cotizacion</td>
            </tr>
            <tr>
                <th style="color:#292924;">RUT</th>
                <td style="border-bottom: 1px solid #000;">$rut_proveedor</td>
                <th style="color:#292924;">Fecha Emisión</th>
                <td style="border-bottom: 1px solid #000;">$fecha_emision</td>
            </tr>
            <tr>
                <th style="color:#292924;">Dirección</th>
                <td style="border-bottom: 1px solid #000;">$direccion_proveedor</td>
                <th style="color:#292924;">Forma de Pago</th>
                <td style="border-bottom: 1px solid #000;">$forma_pago</td>
            </tr>
            <tr>
                <th style="color:#292924;">Ciudad/Comuna</th>
                <td style="border-bottom: 1px solid #000;">$ciudad_comuna</td>
                <th style="color:#292924;">Días de Plazo Entrega</th>
                <td style="border-bottom: 1px solid #000;">$dias_plazo</td>
            </tr>
            <tr>
                <th style="color:#292924;">Teléfono</th>
                <td style="border-bottom: 1px solid #000;">$telefono_proveedor</td>
                <th style="color:#292924;">Fecha de Entrega</th>
                <td style="border-bottom: 1px solid #000;">$fecha_entrega</td>
            </tr>
            <tr>
                <th style="color:#292924;">Correo</th>
                <td style="border-bottom: 1px solid #000;">$correo_proveedor</td>
                <th style="color:#292924;">Lugar de Entrega</th>
                <td style="border-bottom: 1px solid #000;">$lugar_entrega</td>
            </tr>
        </thead>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
// ---------------------------------------------------------

//DRAW RED LINE ----
$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
$pdf->Line(5, 31, 205, 31, $style);
//

$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(23,28,88);
$pdf->SetFont('helvetica','',5);//B es para negritas
$pdf->SetLineStyle(array('width' => 0.05, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0)));
$pdf->Cell(11,3,'Item',1,0,'C',1);
$pdf->Cell(15,3,'Código',1,0,'C',1);
$pdf->Cell(65,3,'Descripción',1,0,'C',1);
$pdf->Cell(15,3,'Unidad',1,0,'C',1);
$pdf->Cell(20,3,'Cantidad',1,0,'C',1);
$pdf->Cell(15,3,'C.Costo',1,0,'C',1);
$pdf->Cell(30,3,'P.Unitario',1,0,'C',1);
$pdf->Cell(14,3,'Descuento',1,0,'C',1);
$pdf->Cell(15,3,'P.Total',1,1,'C',1);

$pdf->setTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('helvetica','',5);
$row = $datos_detalle->fetch_all(MYSQLI_NUM);

foreach($row as $fila){
    $cellWidth=65;//tamaño fijo celda
    $cellHeight=3;//tamaño normal del largo de la celda
//revisa si el texto se está desbordando
    if($pdf->GetStringWidth($fila[33])<$cellWidth){
        //si no, sigue adelante
        $line=1;
    }else{
        //si es así calcular el ancho necesitado para la celda
        //dividiendo el texto para que quepa en el ancho de la celda
        //entonces, contar cuantas lineas se necesaitan para que el texto
        //quepa dentro de la celda... se entiende??
        $textLength=strlen($fila[33]);//largo total del texto
        $errMargin=10;//margen de error, por si acaso :/
        $startChar=0;//posicion de los caracteres para cada linea
        $maxChar=0;//cantidad maxima de caracteres por linea, a incrementar
        $textArray=array();//guarda strings para cada linea
        $tmpString="";//lo mismo de arriba pero tmp

        while($startChar < $textLength){//loop hasta termino del texto
        //loop hasta encontrar el maximo de caracteres para una linea
            while( $pdf->GetStringWidth( $tmpString) < ($cellWidth-$errMargin)&& ($startChar+$maxChar) < $textLength){
                $maxChar++;
                $tmpString=substr($fila[33],$startChar,$maxChar);
            }
            //mover startChar a la linea siguiente
            $startChar=$startChar+$maxChar;
            //y... añadirlo al arreglo así sabremos cuantas lineas se necesitan
            array_push($textArray,$tmpString);
            //reset maxChar y tmpString's
            $maxChar=0;
            $tmpString='';
        }
        //obtener el n úmero de la línea
        $line=count($textArray);

    }
    $pdf->Cell(11,$line * $cellHeight,($fila[1]),1,0,'C');//adaptar altura al numero de lineas POR LINEA
    $pdf->Cell(15,$line * $cellHeight,($fila[2]),1,0,'C');
    
    $xPos=$pdf->GetX();
    $yPos=$pdf->GetY();

    $pdf->MultiCell($cellWidth,$line * $cellHeight,$fila[33], 1, 'L', 1, 0, '', '', true);

    //indicar la posicion para la siguiente celda
    //offset con x en la multicell
    $pdf->SetXY($xPos + $cellWidth , $yPos);

    $pdf->Cell(15,$line * $cellHeight,($fila[52]),1,0,'C');
    $pdf->Cell(20,$line * $cellHeight,($fila[5]),1,0,'C');
    $pdf->Cell(15,$line * $cellHeight,($fila[56]),1,0,'C');
    $pdf->Cell(30,$line * $cellHeight,($fila[6]),1,0,'C');
    $pdf->Cell(14,$line * $cellHeight,($fila[7]),1,0,'C');
    $pdf->Cell(15,$line * $cellHeight,($fila[8]),1,1,'C');
}

//DRAW RED LINE ----
$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
$pdf->Line(5, 168, 205, 168, $style);
//

$pdf->SetXY(5,170);
$pdf->Cell(15,0,'Notas:',0,1,'L',0,'');

// Draw the square
$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->RoundedRect(15, 172, 130, 20, 1, '0000', 'DF');

$pdf->SetXY(16,173);
$pdf->MultiCell(127,15,$fila[31], 0, 'L', 1, 0, '', '', false);

$pdf->SetFont('helvetica','',7);
$pdf->RoundedRect(170, 172, 35, 20, 1, '0000', 'DF', '',array(154,154,154) );
$pdf->SetXY(172,175);
$pdf->Cell(14,0,'Descuento',0,1,'L',1,'');
$pdf->SetXY(172,178.5);
$pdf->Cell(14,0,'Neto (clp)',0,1,'L',1,'');
$pdf->SetXY(172,182);
$pdf->Cell(14,0,'IVA 19%',0,1,'L',1,'');
$pdf->SetXY(172,188);
$pdf->SetFillColor(114,114,114);
$pdf->Cell(17,0,' TOTAL (clp) ',0,1,'L',1,'');

$pdf->SetFillColor(154,154,154);
$pdf->SetXY(189,175);
$pdf->Cell(14,0,$descuento,0,1,'L',1,'');
$pdf->SetXY(189,178.5);
$pdf->Cell(14,0,$neto,0,1,'L',1,'');
$pdf->SetXY(189,182);
$pdf->Cell(14,0,$iva,0,1,'L',1,'');
$pdf->SetXY(189,188);
$pdf->Cell(14,0,$total_gral,0,1,'L',1,'');
//DRAW RED LINE ----
$style = array('width' => 4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
$pdf->Line(5, 198, 205, 198, $style);
//

$pdf->Ln(5);
$pdf->SetFont('helvetica','',8);
$html = <<<EOD
<table style="font-size: 8px;">
    <tr>
        <th align="center" style="font-weight: bold">POLITICAS Y CONDICIONES GENERALES DE COMPRA</th>
    </tr>
    <tr>
        <br>
        <th style="font-weight: bold;">1.- COLOCAR COMO REFERENCIA EN SU FACTURA EL NUMERO DE ESTA ORDEN DE COMPRA</th>
    </tr>
    <tr>
        <br>
        <th style="font-weight: bold; text-align: justify; text-justify: inter-word;">2.- PLAZO DE ENTREGA DEL SUMINISTRO; Si por algún motivo el Vendedor no completa la entrega de todas las mercancías cubiertas por este pedido dentro del plazo acordado entre las partes, SERVICIOS ELECTRICOS T&M LIMITADAS puede, a su entera discreción, aprobar o desaprobar el programa de entrega revisado, reducir la cantidad total de mercancías cubierta por este pedido en la cantidad de los envíos omitidos, reducir el precio de manera prorrateada o cancelar este pedido con aviso al Vendedor, con respecto a los artículos indicados que todavía no se hayan enviado o los servicios que todavía no se hayan prestado y comprar artículos o servicios sustitutos en otro lugar.
        </th>
    </tr>
    <tr>
        <br>
        <th style="font-weight: bold; text-align: justify; text-justify: inter-word;">3.- ENVÍO: La titularidad y el riesgo de pérdida de todas las mercancías enviadas por el Vendedor, pasarán a SERVICIOS ELECTRICOS T&M LIMITADA una vez que éste inspeccione y acepte las mercancías mencionadas, ya sea en nuestra planta o en cualquier otro lugar acordado. Todas las mercancías entregadas se embalarán y enviarán de acuerdo con las instrucciones o especificaciones de este pedido. En ausencia de instrucciones al respecto, el Vendedor cumplirá con la mejor práctica comercial para asegurar el arribo seguro a destino con el menor coste de transporte. Si, con el fin de cumplir con la fecha de entrega requerida, se hace necesario que el Vendedor envíe a través de un método más caro que el especificado en este pedido, el Vendedor pagará cualquier coste de transporte adicional, excepto si la necesidad de ese cambio de ruta o esa manipulación expedita se debe a una falta o solicitud por parte nuestra.
        </th>
    </tr>
    <tr>
        <br>
        <th style="font-weight: bold; text-align: justify; text-justify: inter-word;">4.- INSPECCIÓN; Todas las mercancías estarán sujetas a la inspección y aceptación por parte del Personal de SERVICIOS ELECTRICOS T&M LIMITADA en su planta o en cualquier otro lugar que así se designe de manera razonable. SERVICIOS ELECTRICOS T&M LIMITADA expresamente se reserva el derecho, sin ninguna responsabilidad a rechazar y a negarse a aceptar mercancías cubiertas que no se ajustan en todos los aspectos a alguna de las instrucciones, especificaciones, los diagramas, los planos o datos suministrados en la OC o adjuntos correspondientes 
        </th>
    </tr>
    <tr>
        <br>
        <th style="font-weight: bold; text-align: justify; text-justify: inter-word;">5.- PAGO; SERVICIOS ELECTRICOS T&M LIMITADA hará respectivamente los pagos de mercancías y/o servicios solicitados según la moneda estipulada en nuestra Orden de Compra. Para aquellos proveedores con los que tenemos Crédito, nuestros pagos se realizaran los días lunes y viernes de cada semana, por lo que se agendara el pago según corresponda el día más próximo al vencimiento de factura.
        </th>
    </tr>
</table>
EOD;
$pdf->SetXY(10,200);
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Output('Orden de Compra N° ' . $nro_orden_compra . '.pdf', 'I');


?>