<?php
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener todos los estudiantes
$sql = "SELECT * FROM estudiantes";
$result = $conn->query($sql);
?>
<h2>Lista de Estudiantes</h2>
<a href="create.php">Añadir Estudiante</a>
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
                <a href="edit.php?id=<?php echo $row['id_estudiante']; ?>">Editar</a> |
                <a href="delete.php?id=<?php echo $row['id_estudiante']; ?>" onclick="return confirm('¿Estás seguro?');">Eliminar</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
