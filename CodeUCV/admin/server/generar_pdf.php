<?php
require('../fpdf/fpdf.php');
include 'conexion.php';

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Título
        $this->Cell(0,10,'Reporte de Alumnos',0,1,'C');
        // Salto de línea
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Tabla simple
    function BasicTable($header, $data)
    {
        // Ancho de las columnas
        $columnWidths = array(15, 40, 25, 50, 20); // Ancho de cada columna

        // Cabecera
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($columnWidths[$i], 7, $header[$i], 1, 0, 'C');
        }
        $this->Ln();

        // Datos
        foreach($data as $row)
        {
            for ($i = 0; $i < count($row); $i++) {
                $cellContent = $row[$i];
                // Si la columna es "Correo", ajustar el tamaño de fuente si es necesario
                if ($header[$i] == 'Correo') {
                    $this->SetFont('Arial', '', 10); // Ajuste de tamaño de fuente
                }
                // Ajustar ancho y centrar texto
                $this->Cell($columnWidths[$i], 6, utf8_decode($cellContent), 1, 0, 'C');
                $this->SetFont('Arial', '', 12); // Restaurar tamaño de fuente estándar
            }
            $this->Ln();
        }
    }
}

$pdf = new PDF();
// Títulos de las columnas
$header = array('ID', 'Nombre', 'Género', 'Correo', 'Activo');
// Cargar datos
$data = [];

$sql = "SELECT id, nombre_usuario, genero, correo, activo FROM usuarios";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $activo = $row["activo"] ? 'Activo' : 'Inactivo';
        $data[] = array($row["id"], $row["nombre_usuario"], $row["genero"], $row["correo"], $activo);
    }
}

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->BasicTable($header, $data);
$pdf->Output('D', 'Reporte_Usuarios.pdf');
?>
