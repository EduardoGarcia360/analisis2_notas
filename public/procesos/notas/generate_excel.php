<?php
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/includes/simplexlsxgen/SimpleXLSXGen.php'; // Incluir la biblioteca SimpleXLSXGen

// Función para generar el nombre del archivo Excel
function generarNombreExcel() {
    $fecha = date('dmY'); // Día, Mes, Año
    $hora = date('Hisv'); // Hora, Minuto, Segundo, Milisegundo
    $random = rand(1, 10000); // Número aleatorio entre 1 y 10,000
    
    return "NOTAS_{$fecha}_{$hora}_{$random}.xlsx";
}

// Crear un array con los datos para el Excel
$notas = [
    ['Estudiante', 'Curso', 'Nota', 'Fecha'], // Encabezados
];

// Consultar las notas
$sql = "SELECT estudiantes.nombre AS estudiante_nombre, cursos.nombre AS curso_nombre, notas.nota, notas.fecha 
        FROM notas 
        INNER JOIN estudiantes ON notas.id_estudiante = estudiantes.id_estudiante 
        INNER JOIN cursos ON notas.id_curso = cursos.id_curso";
$result = $conn->query($sql);

// Agregar los datos al array
while ($row = $result->fetch_assoc()) {
    $notas[] = [$row['estudiante_nombre'], $row['curso_nombre'], $row['nota'], $row['fecha']];
}

// Crear el archivo Excel
$xlsx = Shuchkin\SimpleXLSXGen::fromArray($notas);
$nombreExcel = generarNombreExcel(); // Usa la función de nombre dinámico

// Descargar el archivo Excel
$xlsx->downloadAs($nombreExcel);
?>
