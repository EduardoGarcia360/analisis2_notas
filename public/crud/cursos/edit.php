<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Obtener el ID del curso desde la URL
$id_curso = $_GET['id'];

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $id_colegio = $_POST['id_colegio'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE cursos SET nombre='$nombre', descripcion='$descripcion', id_colegio='$id_colegio' 
            WHERE id_curso='$id_curso'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
} else {
    // Obtener los datos actuales del curso
    $sql = "SELECT * FROM cursos WHERE id_curso='$id_curso'";
    $result = $conn->query($sql);
    $curso = $result->fetch_assoc();

    // Obtener los colegios para el combo
    $sql_colegios = "SELECT id_colegio, nombre FROM colegio";
    $result_colegios = $conn->query($sql_colegios);
}
?>

<h2>Editar Curso</h2>
<form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo $curso['nombre']; ?>" required><br>
    
    <label>Descripción:</label><br>
    <input type="text" name="descripcion" value="<?php echo $curso['descripcion']; ?>" required><br>
    
    <label>Colegio:</label><br>
    <select name="id_colegio" required>
        <option value="">Selecciona un colegio</option>
        <?php while ($colegio = $result_colegios->fetch_assoc()) { ?>
            <option value="<?php echo $colegio['id_colegio']; ?>" 
                <?php if ($curso['id_colegio'] == $colegio['id_colegio']) echo 'selected'; ?>>
                <?php echo $colegio['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>
    
    <input type="submit" value="Guardar Cambios" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
