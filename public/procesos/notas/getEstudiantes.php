<?php
include '../../../../analisis2_notas/includes/db.php';

// Obtener el ID del curso desde la solicitud
$id_curso = $_GET['id_curso'];

// Consulta para obtener los estudiantes inscritos en el curso
$sql = "SELECT estudiantes.id_estudiante, estudiantes.nombre 
        FROM inscripciones 
        INNER JOIN estudiantes ON inscripciones.id_estudiante = estudiantes.id_estudiante
        WHERE inscripciones.id_curso='$id_curso'";

$result = $conn->query($sql);

$estudiantes = [];
while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

// Devolver los datos en formato JSON
echo json_encode($estudiantes);
?>
