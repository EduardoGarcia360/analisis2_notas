<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener todos los estudiantes
$sql = "SELECT * FROM estudiantes";
$result = $conn->query($sql);
?>
<h2>Lista de Estudiantes</h2>
<a href="create.php" class="btn btn-primary mb-3">Añadir Estudiante</a>

<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Fecha de Nacimiento</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_estudiante']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['apellido']; ?></td>
            <td><?php echo $row['fecha_nacimiento']; ?></td>
            <td><?php echo $row['direccion']; ?></td>
            <td><?php echo $row['telefono']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id_estudiante']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="javascript:void(0);" 
                    class="btn btn-danger btn-sm" 
                    onclick="confirmDelete(<?php echo $row['id_estudiante']; ?>)"
                    >Eliminar</a>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
    function confirmDelete(id_colegio) {
        // Utilizamos un diálogo simple de confirmación nativo de JavaScript
        var confirmation = confirm("¿Estás seguro de que deseas eliminar este registro?");
        if (confirmation) {
            // Redirigir al script de eliminación si se confirma
            window.location.href = "delete.php?id=" + id_colegio;
        }
    }
</script>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
