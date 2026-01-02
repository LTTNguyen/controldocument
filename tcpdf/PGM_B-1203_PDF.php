<?php
session_start();
error_reporting(E_ALL);
header("Content-Type: application/json; charset=UTF-8");
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
$ingreso = $salida = $transito = "";

function formateo_rut($rut_param){
    
    $parte4 = substr($rut_param, -1); // seria solo el numero verificador
    $parte3 = substr($rut_param, -4,3); // la cuenta va de derecha a izq 
    $parte2 = substr($rut_param, -7,3); 
    $parte1 = substr($rut_param, 0,-7); //de esta manera toma todos los caracteres desde el 8 hacia la izq

    return $parte1.".".$parte2.".".$parte3."-".$parte4;
}
// ----- RECOPILACION DE DATOS
$nro_guia_bienes = $_GET['NroGuiaBienes'];

$sql1="SELECT * FROM guia_bienes LEFT JOIN vehiculos ON guia_bienes.PATENTE = vehiculos.patente LEFT JOIN trabajadores ON guia_bienes.RUT_TRABAJADOR = trabajadores.rut_trabajador LEFT JOIN bodegas ON guia_bienes.BODEGA = bodegas.bodega WHERE NRO_GUIA_BIENES = ?";
$sql2="SELECT * FROM guia_bienes_movimiento LEFT JOIN productos ON guia_bienes_movimiento.PRODUCTO = productos.producto WHERE NRO_GUIA_BIENES = ?";

$stmt = $conn->prepare($sql1);
$stmt->bind_param("s", $nro_guia_bienes);
$stmt->execute();
$resultado = $stmt->get_result();
$datos_guia = $resultado->fetch_row();

$stmt = $conn->prepare($sql2);
$stmt->bind_param("s", $nro_guia_bienes);
$stmt->execute();
$resultado_datos = $stmt->get_result();

$actividad = $datos_guia[1];
$empresa = $datos_guia[2];
$bodega = $datos_guia[3];
$lugar = $datos_guia[4];
$fecha = strtotime($datos_guia[5]);
$fecha_format = date("d-m-Y", $fecha);
$patente = $datos_guia[6];
$descripcion_vehiculo = $datos_guia[11];
$rut_chofer = formateo_rut($datos_guia[7]);
$total_bien = $datos_guia[8];
$contrato = $datos_guia[29];

if($datos_guia[18] == ""||$datos_guia[19] == ""){
    $conductor = "S/I";
}else{
$conductor = $datos_guia[18].' '.$datos_guia[19];
}
switch ($actividad) {
    case "INGRESO":
        $ingreso = "X";
        break;
    case "SALIDA":
        $salida = "X";
        break;
    case "EN TRANSITO":
        $transito = "X";
        break;
}

// ----- RECOPILACION DE DATOS

//DATOS PÁGINA
$pdf = new TCPDF('P', PDF_UNIT, 'letter', true, 'UTF-8', false);//L: Landscape, P: Portrait

class MYPDF extends TCPDF {
    //Cabecera
    public function Header() {
        $this->Cell(0, 15, '<<>>', 0, false, 'C', 0, '', 0, false, 'M', 'M');

    }

    // Pie de página en blanco

}

// set document information
$filename = 'Guia de Bienes Contratista N° '. $nro_guia_bienes .'.pdf';
$pdf->SetCreator('ANDES Suministros SPA');
$pdf->SetAuthor('ANDES Suministros SPA');
$pdf->SetTitle($filename);
$pdf->SetSubject('Guía de Bienes Contratista');
$pdf->SetKeywords('');

// set default header data
$pdf->SetHeaderData('', 20, '');

// set margins
$pdf->SetMargins(5, 20, 5);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetFooterMargin(5);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
// set auto page breaks
$pdf->SetAutoPageBreak(false, 5);

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

// -----------------------------------------------------------------------------
$style = array('width' => 0.4, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(31, 50, 233));

$pdf->Line(5, 5, 205, 5, $style);
$pdf->Line(205, 293, 205, 5, $style);
$pdf->Line(5, 293, 5, 5, $style);
$pdf->Line(5, 293, 205, 293, $style);
// ---------------------------------------------------------
$pdf->StartTransform();
$pdf->SetXY(209,5);
$pdf->Rotate(-90);
$pdf->SetTextColor(31,50,233);
$pdf->SetFont('courier', 'B', 9);
$pdf->Cell(0,0,'ESTE FORMULARIO NO REEMPLAZA LA GUIA DE DESPACHO DEL SERVICIO DE IMPUESTOS INTERNOS',0,1,'L',0,'');
$pdf->StopTransform();
// ---------------------------------------------------------

// PAGE
$pdf->SetXY(170,10);
$pdf->SetFont('helvetica', 'B', 16);
$pdf->SetTextColor(31,50,233);
$pdf->Cell(30,0,$nro_guia_bienes,0,0,'R',0,'');

$pdf->SetFont('helvetica', 'B', 8);
$pdf->SetXY(10,10);
$pdf->Cell(30,0,'SERVICIOS ELÉCTRICOS TYM LTDA',0,0,'L',0,'');
$pdf->SetXY(80,10);
$pdf->Cell(20,0,'INGRESO',0,0,'R',0,'');
$pdf->Cell(20,0,$ingreso,1,0,'C',0,'');
$pdf->SetXY(10,16);
$pdf->Cell(30,0,'RUT: 76.313.839-9',0,0,'L',0,'');
$pdf->SetXY(80,16);
$pdf->Cell(20,0,'SALIDA',0,0,'R',0,'');
$pdf->Cell(20,0,$salida,1,0,'C',0,'');
$pdf->SetXY(10,22);
$pdf->Cell(30,0,'FORMULARIO BIENES CONTRATISTAS',0,0,'L',0,'');
$pdf->SetXY(80,22);
$pdf->Cell(20,0,'EN TRANSITO',0,0,'R',0,'');
$pdf->Cell(20,0,$transito,1,0,'C',0,'');

$pdf->SetXY(10,30);
$pdf->Cell(8,0,'Empresa',0,0,'L',0,'');
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,0,$empresa,0,0,'C',0,'');
$pdf->SetXY(10,35);
$pdf->SetTextColor(31,50,233);
$pdf->Cell(8,0,'Lugar',0,0,'L',0,'');
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,0,$lugar,0,0,'C',0,'');
$pdf->SetTextColor(31,50,233);
$pdf->SetXY(10,40);
$pdf->Cell(8,0,'Tipo de Vehiculo',0,0,'L',0,'');
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,0,$descripcion_vehiculo,0,0,'C',0,'');
$pdf->SetTextColor(31,50,233);
$pdf->SetXY(10,45);
$pdf->Cell(8,0,'Conductor',0,0,'L',0,'');
$pdf->SetTextColor(0,0,0);
$pdf->Cell(100,0,$conductor,0,0,'C',0,'');

$pdf->SetTextColor(31,50,233);
$pdf->SetXY(115,30);
$pdf->Cell(8,0,'N° Contrato',0,0,'R',0,'');
$pdf->SetXY(150,30);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(20,0,$contrato,0,0,'C',0,'');
$pdf->SetTextColor(31,50,233);
$pdf->SetXY(115,35);
$pdf->Cell(8,0,'Fecha',0,0,'R',0,'');
$pdf->SetXY(150,35);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(20,0,$fecha_format,0,0,'C',0,'');
$pdf->SetTextColor(31,50,233);
$pdf->SetXY(115,40);
$pdf->Cell(8,0,'Patente',0,0,'R',0,'');
$pdf->SetXY(150,40);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(20,0,$patente,0,0,'C',0,'');
$pdf->SetTextColor(31,50,233);
$pdf->SetXY(115,45);
$pdf->Cell(8,0,'R.U.N. Chofer',0,0,'R',0,'');
$pdf->SetXY(150,45);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(20,0,$rut_chofer,0,0,'C',0,'');
$pdf->SetTextColor(31,50,233);

$pdf->Line(34, 34, 100, 34, $style);
$pdf->Line(34, 39, 100, 39, $style);
$pdf->Line(34, 44, 100, 44, $style);
$pdf->Line(34, 49, 100, 49, $style);

$pdf->Line(200, 34, 123, 34, $style);
$pdf->Line(200, 39, 123, 39, $style);
$pdf->Line(200, 44, 123, 44, $style);
$pdf->Line(200, 49, 123, 49, $style);

$pdf->SetFont('helvetica','',9);//B es para negritas
$pdf->SetXY(10,54);
$pdf->Cell(11,11,'ITEM',1,0,'C',0);
$pdf->Cell(20,11,'CANTIDAD',1,0,'C',0);
$pdf->Cell(125,11, 'DESCRIPCION DEL BIEN', 1, $ln=0, 'C', 0, '', 0, false, 'T', 'T');
$pdf->Cell(33,11, 'FOLIO - ITEM', 1, $ln=0, 'C', 0, '', 0, false, 'T', 'T');

$pdf->SetXY(99,58);
$pdf->Cell(8,0,'(Marca, Modelo, Serie, etc.)',0,0,'C',0,'');
$pdf->SetXY(179,58);
$pdf->Cell(8,0,'Referencia',0,0,'C',0,'');

$pdf->SetFont('helvetica','B',12);//B es para negritas

$row = $resultado_datos->fetch_all(MYSQLI_NUM);
$j = 58;

for ($i=1; $i < 29; $i++) {
    $k = $j;
    $l = $j;
    $m = $j;
    $pdf->SetXY(10,$j+=7);
    $pdf->Cell(11,7,$i,1,0,'C',0);
    $pdf->SetXY(21,$k+=7);
    $pdf->Cell(20,7,'',1,0,'C',0);
    $pdf->SetXY(41,$l+=7);
    $pdf->Cell(125,7,'',1,0,'C',0);
    $pdf->SetXY(166,$m+=7);
    $pdf->Cell(33,7,'',1,0,'C',0);
}
// --- DETALLES GUIA--- //
$j = 58;
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('helvetica','B',8);//B es para negritas
foreach($row as $fila){
    $k = $j;
    $l = $j;
    $m = $j;
    $pdf->SetXY(21,$j+=7);
    $pdf->Cell(20,7,$fila[3],0,0,'C',0);
    $pdf->SetXY(41,$k+=7);
    $pdf->Cell(125,7,$fila[18],0,0,'L',0);
    $pdf->SetXY(166,$l+=7);
    if($fila[7] == "0"||$fila[7] == null){
        $folio = "";
    }
    $pdf->Cell(33,7,$folio,1,0,'C',0);
}
// --- FIN DETALLES --- //

$pdf->SetTextColor(31,50,233);
$pdf->SetXY(10,261);
$pdf->SetFont('helvetica','B',8);//B es para negritas
$pdf->Cell(11,7,'TOTAL',1,0,'C',0,'');
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('helvetica','B',12);//B es para negritas
$pdf->Cell(20,7,$total_bien,1,0,'C',0,'');
$pdf->Cell(158,7,'',1,0,'C',0,'');
$pdf->SetFont('helvetica','B',8);//B es para negritas
$pdf->SetTextColor(31,50,233);

$pdf->SetXY(41,268);
$pdf->Cell(15,7,'N°Código',1,0,'C',0,'');
$pdf->Cell(35,7,'Firma',1,0,'C',0,'');
$pdf->Cell(36,7,'Firma','LB',0,'L',0,'');
$pdf->Cell(36,7,'Fecha','B',0,'C',0,'');
$pdf->Cell(36,7,'Hora','RB',0,'C',0,'');

$pdf->SetXY(10,268);
$pdf->Cell(31,22,'',1,1,'C',0,'');

$pdf->SetXY(41,275);
$pdf->Cell(50,10,'',1,1,'C',0,'');

$pdf->SetXY(91,275);
$pdf->Cell(108,10,'',1,1,'C',0,'');

$pdf->SetXY(41,285);
$pdf->Cell(50,5,'Nombre Coordinador',1,0,'C',0,'');
$pdf->Cell(54,5,'Nombre',1,0,'C',0,'');
$pdf->Cell(54,5,'Timbre Resguardo y Control',1,0,'C',0,'');

$pdf->Output($filename, 'I');
// ---------------------------------------------------------

?>