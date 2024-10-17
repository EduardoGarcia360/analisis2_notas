<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Obtener el ID de la asignación desde la URL
$id_asignacion = $_GET['id'];

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_curso = $_POST['id_curso'];
    $id_maestro = $_POST['id_maestro'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE asignaciones SET id_curso='$id_curso', id_maestro='$id_maestro' WHERE id_asignacion='$id_asignacion'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
} else {
    // Obtener los datos actuales de la asignación, incluyendo el colegio a través del curso
    $sql = "SELECT asignaciones.id_curso, asignaciones.id_maestro, cursos.id_colegio 
            FROM asignaciones 
            INNER JOIN cursos ON asignaciones.id_curso = cursos.id_curso 
            WHERE asignaciones.id_asignacion='$id_asignacion'";
    $result = $conn->query($sql);
    $asignacion = $result->fetch_assoc();

    $id_colegio = $asignacion['id_colegio'];

    // Obtener los colegios
    $sql_colegios = "SELECT id_colegio, nombre FROM colegio";
    $result_colegios = $conn->query($sql_colegios);

    // Obtener cursos y maestros según el colegio de la asignación
    $sql_cursos = "SELECT id_curso, nombre FROM cursos WHERE id_colegio='$id_colegio'";
    $result_cursos = $conn->query($sql_cursos);

    $sql_maestros = "SELECT id_maestro, nombre FROM maestros WHERE id_colegio='$id_colegio'";
    $result_maestros = $conn->query($sql_maestros);
}
?>

<h2>Editar Asignación</h2>
<form method="POST">
    <label>Colegio:</label><br>
    <select name="id_colegio" id="id_colegio" required>
        <option value="">Selecciona un colegio</option>
        <?php while ($colegio = $result_colegios->fetch_assoc()) { ?>
            <option value="<?php echo $colegio['id_colegio']; ?>" <?php if ($colegio['id_colegio'] == $id_colegio) echo 'selected'; ?>>
                <?php echo $colegio['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Curso:</label><br>
    <select name="id_curso" id="id_curso" required>
        <?php while ($curso = $result_cursos->fetch_assoc()) { ?>
            <option value="<?php echo $curso['id_curso']; ?>" <?php if ($curso['id_curso'] == $asignacion['id_curso']) echo 'selected'; ?>>
                <?php echo $curso['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Maestro:</label><br>
    <select name="id_maestro" id="id_maestro" required>
        <?php while ($maestro = $result_maestros->fetch_assoc()) { ?>
            <option value="<?php echo $maestro['id_maestro']; ?>" <?php if ($maestro['id_maestro'] == $asignacion['id_maestro']) echo 'selected'; ?>>
                <?php echo $maestro['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <input type="submit" value="Guardar Cambios" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<script>
// Función para actualizar cursos y maestros según el colegio seleccionado
document.getElementById('id_colegio').addEventListener('change', function() {
    var colegio_id = this.value;

    if (colegio_id) {
        var xhrCursos = new XMLHttpRequest();
        xhrCursos.open('GET', 'get_cursos.php?colegio_id=' + colegio_id, true);
        xhrCursos.onload = function() {
            if (this.status === 200) {
                document.getElementById('id_curso').innerHTML = this.responseText;
            }
        };
        xhrCursos.send();

        var xhrMaestros = new XMLHttpRequest();
        xhrMaestros.open('GET', 'get_maestros.php?colegio_id=' + colegio_id, true);
        xhrMaestros.onload = function() {
            if (this.status === 200) {
                document.getElementById('id_maestro').innerHTML = this.responseText;
            }
        };
        xhrMaestros.send();
    }
});
</script>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>
