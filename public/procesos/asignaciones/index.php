<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener todas las asignaciones
$sql = "SELECT asignaciones.id_asignacion, cursos.nombre AS nombre_curso, maestros.nombre AS nombre_maestro 
        FROM asignaciones
        JOIN cursos ON asignaciones.id_curso = cursos.id_curso
        JOIN maestros ON asignaciones.id_maestro = maestros.id_maestro";
$result = $conn->query($sql);
?>
<h2>Lista de Asignaciones</h2>
<a href="create.php" class="btn btn-primary mb-3">Añadir Asignación</a>

<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Curso</th>
        <th>Maestro</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_asignacion']; ?></td>
            <td><?php echo $row['nombre_curso']; ?></td>
            <td><?php echo $row['nombre_maestro']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id_asignacion']; ?>" class="btn btn-sm">
                    <img src="../../../../analisis2_notas/assets/img/editar.png" alt="Editar" style="width:30px; height:30px;">
                </a>
                <a href="javascript:void(0);" class="btn btn-sm" onclick="confirmDelete(<?php echo $row['id_asignacion']; ?>)">
                    <img src="../../../../analisis2_notas/assets/img/eliminar.png" alt="Eliminar" style="width:30px; height:30px;">
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
    function confirmDelete(id_asignacion) {
        var confirmation = confirm("¿Estás seguro de que deseas eliminar esta asignación?");
        if (confirmation) {
            window.location.href = "delete.php?id=" + id_asignacion;
        }
    }
</script>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
