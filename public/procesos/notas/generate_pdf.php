<?php
require '../../../../analisis2_notas/includes/fpdf186/fpdf.php'; // Ruta a la biblioteca FPDF
include '../../../../analisis2_notas/includes/db.php';

// Función para generar el nombre del archivo
function generarNombrePDF() {
    $fecha = date('dmY'); // Día, Mes, Año
    $hora = date('Hisv'); // Hora, Minuto, Segundo, Milisegundo
    $random = rand(1, 10000); // Número aleatorio entre 1 y 10,000
    
    return "NOTAS_{$fecha}_{$hora}.pdf";
}

// Crear una nueva instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Título del reporte
$pdf->Cell(0, 10, 'Reporte de Notas', 0, 1, 'C');

// Espacio
$pdf->Ln(10);

// Encabezados de la tabla
$pdf->Cell(40, 10, 'Estudiante', 1);
$pdf->Cell(40, 10, 'Curso', 1);
$pdf->Cell(20, 10, 'Nota', 1);
$pdf->Cell(30, 10, 'Fecha', 1);
$pdf->Ln();

// Consultar las notas
$sql = "SELECT estudiantes.nombre AS estudiante_nombre, cursos.nombre AS curso_nombre, notas.nota, notas.fecha 
        FROM notas 
        INNER JOIN estudiantes ON notas.id_estudiante = estudiantes.id_estudiante 
        INNER JOIN cursos ON notas.id_curso = cursos.id_curso";
$result = $conn->query($sql);

// Llenar la tabla con los datos
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['estudiante_nombre'], 1);
    $pdf->Cell(40, 10, $row['curso_nombre'], 1);
    $pdf->Cell(20, 10, $row['nota'], 1);
    $pdf->Cell(30, 10, $row['fecha'], 1);
    $pdf->Ln();
}

// Generar el nombre dinámico del archivo PDF
$nombrePDF = generarNombrePDF();

// Salida del archivo PDF
$pdf->Output('D', $nombrePDF); // 'D' para descargar el archivo directamente
?>
