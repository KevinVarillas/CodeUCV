<?php
// Verificar si se recibió el parámetro source y es válido
if (isset($_GET['source']) && $_GET['source'] === 'comentarios') {
    // Incluir el archivo de conexión a la base de datos
    include 'conexion.php';
    require('../fpdf/fpdf.php');

    // Definir la clase extendida de FPDF para el documento PDF
    class PDF extends FPDF
    {
        // Cabecera del reporte
        function Header()
        {
            $this->SetFont('Arial','B',15);
            $this->Cell(0,10,'Reporte de Comentarios',0,1,'C');
            $this->Ln(10);
        }

        // Pie de página del reporte
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
        }

        // Función para mostrar los comentarios con líneas separadoras
        function MostrarComentario($id, $nombre, $comentario)
        {
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, 'ID: ' . $id, 0, 1);
            $this->Cell(0, 10, 'Nombre: ' . utf8_decode($nombre), 0, 1);
            $this->MultiCell(0, 10, 'Comentario: ' . utf8_decode($comentario), 0, 1);
            $this->Ln();
            $this->Cell(190, 0, '', 'T');
            $this->Ln(5); // Espacio adicional después de la línea
        }
    }

    // Crear una instancia de PDF
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // Consultar la base de datos para obtener los comentarios
    $sql = "SELECT id, nombre_usuario, comentarios FROM comentarios";
    $result = $conn->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Mostrar datos de cada comentario con línea separadora
        while ($row = $result->fetch_assoc()) {
            $pdf->MostrarComentario($row["id"], $row["nombre_usuario"], $row["comentarios"]);
        }
    } else {
        // En caso de no haber comentarios
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'No hay comentarios para mostrar.', 0, 1);
    }

    // Descargar el PDF generado con el nombre 'Reporte_Comentarios.pdf'
    $pdf->Output('D', 'Reporte_Comentarios.pdf');

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Manejar el caso donde la fuente no es válida o no se proporciona
    echo "Fuente de datos no válida.";
}
?>
