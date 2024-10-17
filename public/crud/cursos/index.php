<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener todos los cursos
$sql = "SELECT * FROM cursos";
$result = $conn->query($sql);
?>
<h2>Lista de Cursos</h2>
<a href="create.php" class="btn btn-primary mb-3">Añadir Curso</a>

<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_curso']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['descripcion']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id_curso']; ?>" class="btn btn-sm">
                    <img src="../../../../analisis2_notas/assets/img/editar.png" alt="Editar" style="width:30px; height:30px;">
                </a>
                <a href="javascript:void(0);" class="btn btn-sm" onclick="confirmDelete(<?php echo $row['id_curso']; ?>)">
                    <img src="../../../../analisis2_notas/assets/img/eliminar.png" alt="Eliminar" style="width:30px; height:30px;">
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
    function confirmDelete(id_curso) {
        var confirmation = confirm("¿Estás seguro de que deseas eliminar este registro?");
        if (confirmation) {
            window.location.href = "delete.php?id=" + id_curso;
        }
    }
</script>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
