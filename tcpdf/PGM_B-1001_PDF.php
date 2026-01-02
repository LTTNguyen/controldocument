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

    require_once "../funciones/config.php";
    require_once "../tcpdf/tcpdf.php";
    ob_end_clean();
  }

?>
<?php
$i = 0;

function contar($i){
    $i++;
    return $i;
}
$nro_solicitud = $_GET['NumSol'];

$sql1 = "SELECT * FROM orden_pedido INNER JOIN trabajadores ON orden_pedido.RUT_SOLICITANTE = trabajadores.rut_trabajador WHERE orden_pedido.NRO_SOLICITUD = ?";
$sql2 = "SELECT * FROM orden_pedido_movimiento INNER JOIN orden_pedido ON orden_pedido_movimiento.NRO_SOLICITUD = orden_pedido.NRO_SOLICITUD INNER JOIN productos ON productos.producto = orden_pedido_movimiento.producto WHERE orden_pedido.NRO_SOLICITUD = ?";
$sql3 = "SELECT * FROM centro_costos";
$sql4 = "SELECT * FROM unidades";

$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $nro_solicitud);
$stmt->execute();
$resultado = $stmt->get_result();
$datos_solicitud = $resultado->fetch_assoc();

//DATOS SOLICITUD
if(isset($datos_solicitud['nombre'])){
    $nombres_solicitante = $datos_solicitud['nombre'] . " " . $datos_solicitud['apellido'];
}else{
    $nombres_solicitante = "S/D";
}
if(isset($datos_solicitud['FECHA_EMISION'])){
$fecha_emision = date("d-m-Y", strtotime($datos_solicitud['FECHA_EMISION']));
}else{
    $fecha_emision = "S/D";
}

if(isset($datos_solicitud['FECHA_RECEPCION'])){
    $fecha_recepcion = $datos_solicitud['FECHA_RECEPCION'];
}else{
    $fecha_recepcion = "S/D";
}

if(isset($datos_solicitud['contrato'])){
    $CONTRATO = $datos_solicitud['contrato'];
}else{
    $CONTRATO = "S/D";
}

if(isset($datos_solicitud['NRO_SOLICITUD'])){
    $NRO_SOLICITUD = $datos_solicitud['NRO_SOLICITUD'];
}else{
    $NRO_SOLICITUD = "S/D";
}

if(isset($datos_solicitud['BODEGA'])){
    $BODEGA = $datos_solicitud['BODEGA'];
}else{
    $BODEGA = "S/D";
}

if(isset($datos_solicitud['AREA_RESPONSABLE'])){
    $AREA_RESPONSABLE = $datos_solicitud['AREA_RESPONSABLE'];
}else{
    $AREA_RESPONSABLE = "S/D";
}

if(isset($datos_solicitud['TRABAJO_REALIZAR'])){
    $TRABAJO_REALIZAR = $datos_solicitud['TRABAJO_REALIZAR'];
}else{
    $TRABAJO_REALIZAR = "S/D";
}

if(isset($datos_solicitud['ADMINISTRADOR_CONTRATO'])){
    $ADM_CONTRATO = $datos_solicitud['ADMINISTRADOR_CONTRATO'];
}else{
    $ADM_CONTRATO = "S/D";
}

if(isset($datos_solicitud['TIPO_REQUERIMIENTO'])){
    $TIPO = $datos_solicitud['TIPO_REQUERIMIENTO'];
}else{
    $TIPO = "S/D";
}
//FIN DATOS SOLICITUD

$stmt = $conn->prepare($sql2);
$stmt->bind_param("s", $nro_solicitud);
$stmt->execute();
$datos_detalle = $stmt->get_result();


$stmt = $conn->prepare($sql3);
$stmt->execute();
$resultado = $stmt->get_result();


while($row = $resultado->fetch_assoc()){
  $c_costos[] = $row;
}

$stmt = $conn->prepare($sql4);
$stmt->execute();
$resultado = $stmt->get_result();

while($row = $resultado->fetch_assoc()){
  $unidades[] = $row;
}

//$c_costos[n]['descripcion']
//$unidades[n]['descripcion']


//DATOS PÁGINA
header("Content-Type: application/json; charset=UTF-8");
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);//L: Landscape, P: Portrait

class MYPDF extends TCPDF {
    //Cabecera
    public function Header() {
        $this->Cell(0, 15, '<<>>', 0, false, 'C', 0, '', 0, false, 'M', 'M');

    }

    // Pie de página
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'de'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// set document information
$pdf->SetCreator('ANDES Suministros SPA');
$pdf->SetAuthor('ANDES Suministros SPA');
$pdf->SetTitle('Pedido de Materiales');
$pdf->SetSubject('Materiales, Servicios, Herramientas y Equipos');
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
$pdf->SetFont('helvetica', 'B', 20);

// add a page
$pdf->AddPage();
$pdf->setJPEGQuality(75);
$pdf->SetFont('helvetica', '', 8);
$pdf->SetXY(5,5);
$tbl1 = <<<EOD
<table style="width:100%; border: 3px solid black; font-size:15px;">
    <tr>
        <th style="width:10%"></th>

        <th style="text-align:center; border: 3px solid black; width:70%"><h2>PEDIDO DE MATERIALES, SERVICIOS, HERRAMIENTAS Y EQUIPOS</h2></th>
        <th style="width:20%;">CODIGO : T&M-SGI-FO-02<br>VERSION : 1<br>FECHA : 30-12-2024<br></th>
    </tr>
</table>
EOD;
$pdf->writeHTML($tbl1, true, false, false, false, '');
$pdf->SetXY(8,6);
$pdf->Image('../images/LOGO_TYM.jpg', '', '', 19, 19, '', '', '', false, 600, 'T', false, false, 0, false, false, false);

$pdf->SetXY(9,25);
$pdf->Ln(3);
// -----------------------------------------------------------------------------

$tbl = <<<EOD
<table style="width:100%; border: 1px solid black; font-size: 12px; font-weight: bolder;">
        <thead>
            <tr>
                <th style="background-color:#9FE8EF;color:#292924;">Número Contrato:</th>
                <td style="border-bottom: 1px solid #000;">$CONTRATO</td>
                <th style="background-color:#9FE8EF;color:#292924;">Número de Solicitud:</th>
                <td style="border-bottom: 1px solid #000;">$NRO_SOLICITUD</td>
                <th style="background-color:#9FE8EF;color:#292924;">Solicitante:</th>
                <td style="border-bottom: 1px solid #000;">$nombres_solicitante</td>
            </tr>
            <tr>
                <th style="background-color:#9FE8EF;color:#292924;">N° de Obra:</th>
                <td style="border-bottom: 1px solid #000;">$BODEGA</td>
                <th style="background-color:#9FE8EF;color:#292924;">Fecha de Emisión:</th>
                <td style="border-bottom: 1px solid #000;">$fecha_emision</td>
                <th style="background-color:#9FE8EF;color:#292924;">Área Responsable:</th>
                <td style="border-bottom: 1px solid #000;">$AREA_RESPONSABLE</td>
            </tr>
            <tr>
                <th style="background-color:#9FE8EF;color:#292924;">Trabajo a Realizar:</th>
                <td colspan="5" style="font-size: 10px; border-bottom: 1px solid #000;">$TRABAJO_REALIZAR</td>
            </tr>
            <tr>
                <th style="background-color:#9FE8EF;color:#292924;">Adm. Contrato</th>
                <td colspan="5" style="border-bottom: 1px solid #000;">$ADM_CONTRATO</td>
            </tr>
            <tr>
                <th style="background-color:#9FE8EF;color:#292924;">Fecha Recepción:</th>
                <td style="border-bottom: 1px solid #000;">$fecha_recepcion</td>
                <th style="background-color:#9FE8EF;color:#292924;">Tipo REQ:</th>
                <td style="border-bottom: 1px solid #000;">$TIPO</td>
                <th style="background-color:#9FE8EF;color:#292924;">Item Partida (Si Aplica): </th>
                <td style="border-bottom: 1px solid #000;">PENDIENTE</td>
            </tr>
        </thead>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
// ---------------------------------------------------------

$pdf->setTextColor(0,0,0);
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('helvetica','B',8);//B es para negritas
$pdf->Cell(11,3,'ITEM',1,0,'C',1);
$pdf->Cell(15,3,'CODIGO',1,0,'C',1);
$pdf->Cell(100,3,'DESCRIPCION MATERIAL',1,0,'C',1);
$pdf->Cell(25,3,'UNIDAD MEDIDA',1,0,'C',1);
$pdf->Cell(30,3,'CANTIDAD',1,0,'C',1);
$pdf->Cell(30,3,'C.COSTO',1,0,'C',1);
$pdf->Cell(75,3,'OBSERVACIONES',1,1,'C',1);

$pdf->setTextColor(0,0,0);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('helvetica','B',7);
$row = $datos_detalle->fetch_all(MYSQLI_ASSOC);

foreach($row as $fila){
    $cellWidth=100;//tamaño fijo celda
    $cellHeight=3;//tamaño normal del largo de la celda
//revisa si el texto se está desbordando
    if($pdf->GetStringWidth($fila['descripcion'])<$cellWidth){
        //si no, sigue adelante
        $line=1;
    }else{
        //si es así calcular el ancho necesitado para la celda
        //dividiendo el texto para que quepa en el ancho de la celda
        //entonces, contar cuantas lineas se necesaitan para que el texto
        //quepa dentro de la celda... se entiende??
        $textLength=strlen($fila['descripcion']);//largo total del texto
        $errMargin=10;//margen de error, por si acaso :/
        $startChar=0;//posicion de los caracteres para cada linea
        $maxChar=0;//cantidad maxima de caracteres por linea, a incrementar
        $textArray=array();//guarda strings para cada linea
        $tmpString="";//lo mismo de arriba pero tmp

        while($startChar < $textLength){//loop hasta termino del texto
        //loop hasta encontrar el maximo de caracteres para una linea
            while( $pdf->GetStringWidth( $tmpString) < ($cellWidth-$errMargin)&& ($startChar+$maxChar) < $textLength){
                $maxChar++;
                $tmpString=substr($fila['descripcion'],$startChar,$maxChar);
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
    $pdf->Cell(11,$line * $cellHeight,($fila['ITEM']),1,0,'C');//adaptar altura al numero de lineas POR LINEA
    $pdf->Cell(15,$line * $cellHeight,($fila['PRODUCTO']),1,0,'C');
    
    $xPos=$pdf->GetX();
    $yPos=$pdf->GetY();
    $pdf->MultiCell($cellWidth,$cellHeight,$fila['descripcion'], 1, 'L', 1, 0, '', '', true);

    //indicar la posicion para la siguiente celda
    //offset con x en la multicell
    $pdf->SetXY($xPos + $cellWidth , $yPos);

    $pdf->Cell(25,$line * $cellHeight,($fila['unidad']),1,0,'C');
    $pdf->Cell(30,$line * $cellHeight,($fila['CANTIDAD']),1,0,'C');
    $pdf->Cell(30,$line * $cellHeight,($fila['CENTRO_COSTO']),1,0,'C');
    $pdf->Cell(75,$line * $cellHeight,($fila['OBSERVACION']),1,1,'C');
}

$pdf->Ln(5);
$pdf->SetFont('helvetica','',8);
$html = <<<EOD
<table style="border: 2px solid black;">
    <tr>
        <th style="border: 2px solid black;">Notas:</th>
    </tr>
    <tr>
        <th style="border: 2px solid black;">1) Es obligación del solicitante DETALLAR AL MÁXIMO el material, servicio, herramienta o equipo requerido en obra.</th>
    </tr>
    <tr>
        <th style="border: 2px solid black;">2) Será responsabilidad del supervisor de bodega en obra informar la recepción conforme de cada SM generada.</th>
    </tr>
</table>
EOD;

$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Output('Solicitud de Materiales N° '.$nro_solicitud.'.pdf', 'I');


?>