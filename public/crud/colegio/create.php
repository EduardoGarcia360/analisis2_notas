<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Insertar los datos
    $sql = "INSERT INTO colegio (nombre, direccion, telefono, email) VALUES ('$nombre', '$direccion', '$telefono', '$email')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

?>

<h2>Añadir Colegio</h2>
<form method="POST">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" required><br>
    <label>Dirección:</label><br>
    <input type="text" name="direccion" required><br>
    <label>Teléfono:</label><br>
    <input type="text" name="telefono" required><br>
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>
    <input type="submit" value="Guardar" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
