<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Consulta para obtener los colegios
$sql_colegios = "SELECT id_colegio, nombre FROM colegio";
$result_colegios = $conn->query($sql_colegios);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_estudiante = $_POST['id_estudiante'];
    $id_curso = $_POST['id_curso'];
    $fecha_inscripcion = $_POST['fecha_inscripcion'];

    // Insertar los datos de inscripción
    $sql = "INSERT INTO inscripciones (id_estudiante, id_curso, fecha_inscripcion) 
            VALUES ('$id_estudiante', '$id_curso', '$fecha_inscripcion')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Añadir Inscripción</h2>
<form method="POST" id="inscripcionForm">
    <label>Colegio:</label><br>
    <select name="id_colegio" id="id_colegio" required>
        <option value="">Selecciona un colegio</option>
        <?php while ($colegio = $result_colegios->fetch_assoc()) { ?>
            <option value="<?php echo $colegio['id_colegio']; ?>"><?php echo $colegio['nombre']; ?></option>
        <?php } ?>
    </select><br><br>
    
    <label>Estudiante:</label><br>
    <select name="id_estudiante" id="id_estudiante" required>
        <option value="">Selecciona primero un colegio</option>
    </select><br><br>
    
    <label>Curso:</label><br>
    <select name="id_curso" id="id_curso" required>
        <option value="">Selecciona primero un colegio</option>
    </select><br><br>

    <label>Fecha de Inscripción:</label><br>
    <input type="date" name="fecha_inscripcion" required><br><br>

    <input type="submit" value="Guardar" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<script>
// Función para obtener estudiantes y cursos según el colegio seleccionado
document.getElementById('id_colegio').addEventListener('change', function() {
    var colegio_id = this.value;
    
    // Verifica si se seleccionó un colegio
    if (colegio_id) {
        // Llamada AJAX para obtener estudiantes
        var xhrEstudiantes = new XMLHttpRequest();
        xhrEstudiantes.open('GET', 'get_estudiantes.php?colegio_id=' + colegio_id, true);
        xhrEstudiantes.onload = function() {
            if (this.status === 200) {
                document.getElementById('id_estudiante').innerHTML = this.responseText;
            }
        };
        xhrEstudiantes.send();

        // Llamada AJAX para obtener cursos
        var xhrCursos = new XMLHttpRequest();
        xhrCursos.open('GET', 'get_cursos.php?colegio_id=' + colegio_id, true);
        xhrCursos.onload = function() {
            if (this.status === 200) {
                document.getElementById('id_curso').innerHTML = this.responseText;
            }
        };
        xhrCursos.send();
    } else {
        document.getElementById('id_estudiante').innerHTML = '<option value="">Selecciona primero un colegio</option>';
        document.getElementById('id_curso').innerHTML = '<option value="">Selecciona primero un colegio</option>';
    }
});
</script>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
