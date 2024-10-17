<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener los colegios
$sql_colegios = "SELECT id_colegio, nombre FROM colegio";
$result_colegios = $conn->query($sql_colegios);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_curso = $_POST['id_curso'];
    $id_maestro = $_POST['id_maestro'];

    // Insertar los datos de la asignación
    $sql = "INSERT INTO asignaciones (id_curso, id_maestro) 
            VALUES ('$id_curso', '$id_maestro')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Añadir Asignación</h2>
<form method="POST">
    <label>Colegio:</label><br>
    <select name="id_colegio" id="id_colegio" required>
        <option value="">Selecciona un colegio</option>
        <?php while ($colegio = $result_colegios->fetch_assoc()) { ?>
            <option value="<?php echo $colegio['id_colegio']; ?>"><?php echo $colegio['nombre']; ?></option>
        <?php } ?>
    </select><br><br>
    
    <label>Curso:</label><br>
    <select name="id_curso" id="id_curso" required>
        <option value="">Selecciona primero un colegio</option>
    </select><br><br>
    
    <label>Maestro:</label><br>
    <select name="id_maestro" id="id_maestro" required>
        <option value="">Selecciona primero un colegio</option>
    </select><br><br>
    
    <input type="submit" value="Guardar" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<script>
// Función para obtener cursos y maestros según el colegio seleccionado
document.getElementById('id_colegio').addEventListener('change', function() {
    var colegio_id = this.value;
    
    if (colegio_id) {
        // Llamada AJAX para obtener cursos
        var xhrCursos = new XMLHttpRequest();
        xhrCursos.open('GET', 'get_cursos.php?colegio_id=' + colegio_id, true);
        xhrCursos.onload = function() {
            if (this.status === 200) {
                document.getElementById('id_curso').innerHTML = this.responseText;
            }
        };
        xhrCursos.send();

        // Llamada AJAX para obtener maestros
        var xhrMaestros = new XMLHttpRequest();
        xhrMaestros.open('GET', 'get_maestros.php?colegio_id=' + colegio_id, true);
        xhrMaestros.onload = function() {
            if (this.status === 200) {
                document.getElementById('id_maestro').innerHTML = this.responseText;
            }
        };
        xhrMaestros.send();
    } else {
        document.getElementById('id_curso').innerHTML = '<option value="">Selecciona primero un colegio</option>';
        document.getElementById('id_maestro').innerHTML = '<option value="">Selecciona primero un colegio</option>';
    }
});
</script>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
