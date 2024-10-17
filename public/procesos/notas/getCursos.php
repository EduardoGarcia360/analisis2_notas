<?php
include '../../../../analisis2_notas/includes/db.php';

// Obtener el ID del maestro desde la solicitud
$id_maestro = $_GET['id_maestro'];

// Consulta para obtener los cursos asignados al maestro
$sql = "SELECT cursos.id_curso, cursos.nombre 
        FROM asignaciones 
        INNER JOIN cursos ON asignaciones.id_curso = cursos.id_curso
        WHERE asignaciones.id_maestro='$id_maestro'";

$result = $conn->query($sql);

$cursos = [];
while ($row = $result->fetch_assoc()) {
    $cursos[] = $row;
}

// Devolver los datos en formato JSON
echo json_encode($cursos);
?>
