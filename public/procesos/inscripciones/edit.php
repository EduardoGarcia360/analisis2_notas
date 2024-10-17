<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Obtener el ID de la inscripción desde la URL
$id_inscripcion = $_GET['id'];

// Consultar los detalles actuales de la inscripción, incluyendo el colegio
$sql = "SELECT inscripciones.*, estudiantes.id_colegio 
        FROM inscripciones 
        INNER JOIN estudiantes ON inscripciones.id_estudiante = estudiantes.id_estudiante 
        WHERE inscripciones.id_inscripcion='$id_inscripcion'";
$result = $conn->query($sql);
$inscripcion = $result->fetch_assoc();

$id_estudiante = $inscripcion['id_estudiante'];
$id_curso = $inscripcion['id_curso'];
$id_colegio = $inscripcion['id_colegio'];  // Recuperar el colegio del estudiante
$fecha_inscripcion = $inscripcion['fecha_inscripcion'];  // Recuperar la fecha de inscripción

// Cargar los colegios
$colegios = $conn->query("SELECT id_colegio, nombre FROM colegio");

// Cargar cursos y estudiantes según los datos actuales
$cursos = $conn->query("SELECT cursos.id_curso, cursos.nombre FROM cursos WHERE id_curso='$id_curso'");
$estudiantes = $conn->query("SELECT estudiantes.id_estudiante, estudiantes.nombre FROM estudiantes WHERE id_colegio='$id_colegio'");

// Verificar si se ha enviado el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_estudiante = $_POST['id_estudiante'];
    $id_curso = $_POST['id_curso'];
    $fecha_inscripcion = $_POST['fecha_inscripcion'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE inscripciones SET id_estudiante='$id_estudiante', id_curso='$id_curso', fecha_inscripcion='$fecha_inscripcion' WHERE id_inscripcion='$id_inscripcion'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}
?>

<h2>Editar Inscripción</h2>
<form method="POST">
    <label>Colegio:</label><br>
    <select name="id_colegio" id="colegio" required onchange="cargarEstudiantes()">
        <option value="">Selecciona un colegio</option>
        <?php while ($colegio = $colegios->fetch_assoc()) { ?>
            <option value="<?php echo $colegio['id_colegio']; ?>" <?php if ($id_colegio == $colegio['id_colegio']) echo 'selected'; ?>>
                <?php echo $colegio['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Curso:</label><br>
    <select name="id_curso" id="curso" required>
        <option value="">Selecciona un curso</option>
        <?php while ($curso = $cursos->fetch_assoc()) { ?>
            <option value="<?php echo $curso['id_curso']; ?>" <?php if ($id_curso == $curso['id_curso']) echo 'selected'; ?>>
                <?php echo $curso['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Estudiante:</label><br>
    <select name="id_estudiante" id="estudiante" required>
        <option value="">Selecciona un estudiante</option>
        <?php while ($estudiante = $estudiantes->fetch_assoc()) { ?>
            <option value="<?php echo $estudiante['id_estudiante']; ?>" <?php if ($id_estudiante == $estudiante['id_estudiante']) echo 'selected'; ?>>
                <?php echo $estudiante['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Fecha de Inscripción:</label><br>
    <input type="date" name="fecha_inscripcion" value="<?php echo $fecha_inscripcion; ?>" required><br><br>

    <input type="submit" value="Guardar Cambios" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>

<script>
// Cargar los estudiantes según el colegio seleccionado
function cargarEstudiantes() {
    var colegioId = document.getElementById("colegio").value;
    fetch('getEstudiantes.php?id_colegio=' + colegioId)
        .then(response => response.json())
        .then(data => {
            var estudianteSelect = document.getElementById("estudiante");
            estudianteSelect.innerHTML = '<option value="">Selecciona un estudiante</option>';
            data.forEach(estudiante => {
                estudianteSelect.innerHTML += '<option value="' + estudiante.id_estudiante + '">' + estudiante.nombre + '</option>';
            });
        });
}
</script>
