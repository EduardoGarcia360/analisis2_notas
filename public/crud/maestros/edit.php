<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Obtener el ID del maestro desde la URL
$id_maestro = $_GET['id'];

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $especialidad = $_POST['especialidad'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id_colegio = $_POST['id_colegio'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE maestros SET nombre='$nombre', apellido='$apellido', especialidad='$especialidad', 
            telefono='$telefono', email='$email', password_hash='$password', id_colegio='$id_colegio' 
            WHERE id_maestro='$id_maestro'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
} else {
    // Obtener los datos actuales del maestro
    $sql = "SELECT * FROM maestros WHERE id_maestro='$id_maestro'";
    $result = $conn->query($sql);
    $maestro = $result->fetch_assoc();

    // Obtener los colegios para el combo
    $sql_colegios = "SELECT id_colegio, nombre FROM colegio";
    $result_colegios = $conn->query($sql_colegios);
}
?>

<h2>Editar Maestro</h2>
<form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?php echo $maestro['nombre']; ?>" required><br>
    
    <label>Apellido:</label><br>
    <input type="text" name="apellido" value="<?php echo $maestro['apellido']; ?>" required><br>
    
    <label>Especialidad:</label><br>
    <input type="text" name="especialidad" value="<?php echo $maestro['especialidad']; ?>" required><br>
    
    <label>Teléfono:</label><br>
    <input type="text" name="telefono" value="<?php echo $maestro['telefono']; ?>" required><br>
    
    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo $maestro['email']; ?>" required><br>
    
    <label>Contraseña:</label><br>
    <input type="password" name="password" value="<?php echo $maestro['password_hash']; ?>" required><br>
    
    <label>Colegio:</label><br>
    <select name="id_colegio" required>
        <option value="">Selecciona un colegio</option>
        <?php while ($colegio = $result_colegios->fetch_assoc()) { ?>
            <option value="<?php echo $colegio['id_colegio']; ?>" 
                <?php if ($maestro['id_colegio'] == $colegio['id_colegio']) echo 'selected'; ?>>
                <?php echo $colegio['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>
    
    <input type="submit" value="Guardar Cambios" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
