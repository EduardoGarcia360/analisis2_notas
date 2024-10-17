<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener todas las inscripciones
$sql = "SELECT inscripciones.id_inscripcion, estudiantes.nombre AS nombre_estudiante, cursos.nombre AS nombre_curso, inscripciones.fecha_inscripcion 
        FROM inscripciones
        JOIN estudiantes ON inscripciones.id_estudiante = estudiantes.id_estudiante
        JOIN cursos ON inscripciones.id_curso = cursos.id_curso";
$result = $conn->query($sql);
?>
<h2>Lista de Inscripciones</h2>
<a href="create.php" class="btn btn-primary mb-3">Añadir Inscripción</a>

<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Estudiante</th>
        <th>Curso</th>
        <th>Fecha de Inscripción</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_inscripcion']; ?></td>
            <td><?php echo $row['nombre_estudiante']; ?></td>
            <td><?php echo $row['nombre_curso']; ?></td>
            <td><?php echo $row['fecha_inscripcion']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id_inscripcion']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id_inscripcion']; ?>)">Eliminar</a>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
    function confirmDelete(id_inscripcion) {
        var confirmation = confirm("¿Estás seguro de que deseas eliminar esta inscripción?");
        if (confirmation) {
            window.location.href = "delete.php?id=" + id_inscripcion;
        }
    }
</script>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
