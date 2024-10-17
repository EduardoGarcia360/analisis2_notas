<?php
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener todos los colegios
$sql = "SELECT * FROM colegio";
$result = $conn->query($sql);
?>
<h2>Lista de Colegios</h2>
<a 
    href="../../../../analisis2_notas/public/crud/colegio/create.php"
    class="btn btn-primary mb-3"
>Añadir Colegio</a>

<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_colegio']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['direccion']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id_colegio']; ?>" class="btn btn-sm">
                    <img src="../../../../analisis2_notas/assets/img/editar.png" alt="Editar" style="width:30px; height:30px;">
                </a>
                <a href="javascript:void(0);" class="btn btn-sm" onclick="confirmDelete(<?php echo $row['id_colegio']; ?>)">
                    <img src="../../../../analisis2_notas/assets/img/eliminar.png" alt="Eliminar" style="width:30px; height:30px;">
                </a>
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

