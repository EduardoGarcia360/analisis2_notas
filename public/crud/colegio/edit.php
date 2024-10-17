<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Obtener el ID del colegio desde la URL
$id_colegio = $_GET['id'];

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE colegio SET nombre='$nombre', direccion='$direccion', telefono='$telefono', email='$email' WHERE id_colegio='$id_colegio'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
} else {
    // Obtener los datos actuales del colegio para mostrarlos en el formulario
    $sql = "SELECT * FROM colegio WHERE id_colegio='$id_colegio'";
    $result = $conn->query($sql);
    $colegio = $result->fetch_assoc();
}

?>

<h2>Editar Colegio</h2>
<form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo $colegio['nombre']; ?>" required><br>
    <label>Dirección:</label><br>
    <input type="text" name="direccion" value="<?php echo $colegio['direccion']; ?>" required><br>
    <label>Teléfono:</label><br>
    <input type="text" name="telefono" value="<?php echo $colegio['telefono']; ?>" required><br>
    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $colegio['email']; ?>" required><br><br>
    <input type="submit" value="Actualizar" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
