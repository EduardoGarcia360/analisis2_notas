<?php
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener todas las notas con los nombres de estudiantes y cursos
$sql = "SELECT notas.id_nota, estudiantes.nombre AS estudiante_nombre, cursos.nombre AS curso_nombre, notas.nota, notas.fecha
        FROM notas
        INNER JOIN estudiantes ON notas.id_estudiante = estudiantes.id_estudiante
        INNER JOIN cursos ON notas.id_curso = cursos.id_curso";
$result = $conn->query($sql);
?>
<h2>Lista de Notas</h2>
<a href="create.php" class="btn btn-primary mb-3">Añadir Nota</a>
<a href="generate_pdf.php" class="btn btn-info mb-3 ms-2">Generar PDF</a>
<a href="generate_excel.php" class="btn btn-success mb-3 ms-2">Generar EXCEL</a>
<table class="table table-striped table-bordered">
    <tr>
        <th>ID</th>
        <th>Estudiante</th>
        <th>Curso</th>
        <th>Nota</th>
        <th>Fecha</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id_nota']; ?></td>
            <td><?php echo $row['estudiante_nombre']; ?></td>
            <td><?php echo $row['curso_nombre']; ?></td>
            <td><?php echo $row['nota']; ?></td>
            <td><?php echo $row['fecha']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id_nota']; ?>" class="btn btn-sm">
                    <img src="../../../../analisis2_notas/assets/img/editar.png" alt="Editar" style="width:30px; height:30px;">
                </a>
                <a href="delete.php?id=<?php echo $row['id_nota']; ?>" class="btn btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta nota?');">
                    <img src="../../../../analisis2_notas/assets/img/eliminar.png" alt="Eliminar" style="width:30px; height:30px;">
                </a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
