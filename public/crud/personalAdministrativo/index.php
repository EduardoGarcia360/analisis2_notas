<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener todo el personal administrativo
$sql = "SELECT * FROM personal_administrativo";
$result = $conn->query($sql);
?>
<h2>Lista de Personal Administrativo</h2>
<a href="create.php" class="btn btn-primary mb-3">Añadir Personal Administrativo</a>

<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Puesto</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_personal']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['apellido']; ?></td>
            <td><?php echo $row['puesto']; ?></td>
            <td><?php echo $row['telefono']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id_personal']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id_personal']; ?>)">Eliminar</a>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
    function confirmDelete(id_personal) {
        var confirmation = confirm("¿Estás seguro de que deseas eliminar este registro?");
        if (confirmation) {
            window.location.href = "delete.php?id=" + id_personal;
        }
    }
</script>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
