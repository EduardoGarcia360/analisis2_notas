<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Obtener el ID de la inscripción desde la URL
$id_inscripcion = $_GET['id'];

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_estudiante = $_POST['id_estudiante'];
    $id_curso = $_POST['id_curso'];
    $fecha_inscripcion = $_POST['fecha_inscripcion'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE inscripciones SET id_estudiante='$id_estudiante', id_curso='$id_curso', fecha_inscripcion='$fecha_inscripcion' 
            WHERE id_inscripcion='$id_inscripcion'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
} else {
    // Obtener los datos actuales de la inscripción
    $sql = "SELECT * FROM inscripciones WHERE id_inscripcion='$id_inscripcion'";
    $result = $conn->query($sql);
    $inscripcion = $result->fetch_assoc();

    // Obtener los colegios
    $sql_colegios = "SELECT id_colegio, nombre FROM colegio";
    $result_colegios = $conn->query($sql_colegios);

    // Obtener estudiantes y cursos asociados al colegio de la inscripción
    $sql_estudiantes = "SELECT id_estudiante, nombre FROM estudiantes WHERE id_colegio=(SELECT id_colegio FROM cursos WHERE id_curso='".$inscripcion['id_curso']."')";
    $result_estudiantes = $conn->query($sql_estudiantes);

    $sql_cursos = "SELECT id_curso, nombre FROM cursos WHERE id_colegio=(SELECT id_colegio FROM cursos WHERE id_curso='".$inscripcion['id_curso']."')";
    $result_cursos = $conn->query($sql_cursos);
}
?>

<h2>Editar Inscripción</h2>
<form method="POST">
    <label>Colegio:</label><br>
    <select name="id_colegio" id="id_colegio" required>
        <option value="">Selecciona un colegio</option>
        <?php while ($colegio = $result_colegios->fetch_assoc()) { ?>
            <option value="<?php echo $colegio['id_colegio']; ?>" <?php if ($colegio['id_colegio'] == $inscripcion['id_colegio']) echo 'selected'; ?>>
                <?php echo $colegio['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Estudiante:</label><br>
    <select name="id_estudiante" id="id_estudiante" required>
        <?php while ($estudiante = $result_estudiantes->fetch_assoc()) { ?>
            <option value="<?php echo $estudiante['id_estudiante']; ?>" <?php if ($estudiante['id_estudiante'] == $inscripcion['id_estudiante']) echo 'selected'; ?>>
                <?php echo $estudiante['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Curso:</label><br>
    <select name="id_curso" id="id_curso" required>
        <?php while ($curso = $result_cursos->fetch_assoc()) { ?>
            <option value="<?php echo $curso['id_curso']; ?>" <?php if ($curso['id_curso'] == $inscripcion['id_curso']) echo 'selected'; ?>>
                <?php echo $curso['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Fecha de Inscripción:</label><br>
    <input type="date" name="fecha_inscripcion" value="<?php echo $inscripcion['fecha_inscripcion']; ?>" required><br><br>

    <input type="submit" value="Guardar Cambios" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<script>
// Función para actualizar estudiantes y cursos según el colegio seleccionado
document.getElementById('id_colegio').addEventListener('change', function() {
    var colegio_id = this.value;

    if (colegio_id) {
        var xhrEstudiantes = new XMLHttpRequest();
        xhrEstudiantes.open('GET', 'get_estudiantes.php?colegio_id=' + colegio_id, true);
        xhrEstudiantes.onload = function() {
            if (this.status === 200) {
                document.getElementById('id_estudiante').innerHTML = this.responseText;
            }
        };
        xhrEstudiantes.send();

        var xhrCursos = new XMLHttpRequest();
        xhrCursos.open('GET', 'get_cursos.php?colegio_id=' + colegio_id, true);
        xhrCursos.onload = function() {
            if (this.status === 200) {
                document.getElementById('id_curso').innerHTML = this.responseText;
            }
        };
        xhrCursos.send();
    }
});
</script>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
