<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Obtener el ID de la nota desde la URL
$id_nota = $_GET['id'];

// Consultar los detalles actuales de la nota
$sql = "SELECT * FROM notas WHERE id_nota='$id_nota'";
$result = $conn->query($sql);
$nota = $result->fetch_assoc();

// Obtener el estudiante, curso, maestro y colegio relacionados con esta nota
$id_estudiante = $nota['id_estudiante'];
$id_curso = $nota['id_curso'];

// Obtener los detalles del estudiante
$sql_estudiante = "SELECT estudiantes.nombre AS estudiante_nombre, estudiantes.id_colegio, asignaciones.id_maestro 
                   FROM estudiantes
                   INNER JOIN inscripciones ON estudiantes.id_estudiante = inscripciones.id_estudiante
                   INNER JOIN asignaciones ON inscripciones.id_curso = asignaciones.id_curso
                   WHERE estudiantes.id_estudiante='$id_estudiante' AND asignaciones.id_curso='$id_curso'";
$result_estudiante = $conn->query($sql_estudiante);
$estudiante_data = $result_estudiante->fetch_assoc();

$id_colegio = $estudiante_data['id_colegio'];
$id_maestro = $estudiante_data['id_maestro'];

// Cargar los colegios
$colegios = $conn->query("SELECT id_colegio, nombre FROM colegio");

// Cargar maestros, cursos y estudiantes según los datos actuales
$maestros = $conn->query("SELECT id_maestro, nombre FROM maestros WHERE id_colegio='$id_colegio'");
$cursos = $conn->query("SELECT cursos.id_curso, cursos.nombre FROM asignaciones 
                        INNER JOIN cursos ON asignaciones.id_curso = cursos.id_curso 
                        WHERE asignaciones.id_maestro='$id_maestro'");
$estudiantes = $conn->query("SELECT estudiantes.id_estudiante, estudiantes.nombre FROM inscripciones 
                             INNER JOIN estudiantes ON inscripciones.id_estudiante = estudiantes.id_estudiante 
                             WHERE inscripciones.id_curso='$id_curso'");
// Verificar si se ha enviado el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_estudiante = $_POST['id_estudiante'];
    $id_curso = $_POST['id_curso'];
    $nota_value = $_POST['nota'];
    $fecha = $_POST['fecha'];

    // Actualizar los datos en la base de datos
    $sql = "UPDATE notas SET id_estudiante='$id_estudiante', id_curso='$id_curso', nota='$nota_value', fecha='$fecha' WHERE id_nota='$id_nota'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}

?>

<h2>Editar Nota</h2>
<form method="POST" id="formNota">
    <label>Colegio:</label><br>
    <select name="id_colegio" id="colegio" required onchange="cargarMaestros()">
        <option value="">Selecciona un colegio</option>
        <?php while ($colegio = $colegios->fetch_assoc()) { ?>
            <option value="<?php echo $colegio['id_colegio']; ?>" <?php if ($id_colegio == $colegio['id_colegio']) echo 'selected'; ?>>
                <?php echo $colegio['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Maestro:</label><br>
    <select name="id_maestro" id="maestro" required onchange="cargarCursos()">
        <option value="">Selecciona un maestro</option>
        <?php while ($maestro = $maestros->fetch_assoc()) { ?>
            <option value="<?php echo $maestro['id_maestro']; ?>" <?php if ($id_maestro == $maestro['id_maestro']) echo 'selected'; ?>>
                <?php echo $maestro['nombre']; ?>
            </option>
        <?php } ?>
    </select><br><br>

    <label>Curso:</label><br>
    <select name="id_curso" id="curso" required onchange="cargarEstudiantes()">
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

    <label>Nota:</label><br>
    <input type="text" name="nota" value="<?php echo $nota['nota']; ?>" required><br>

    <label>Fecha:</label><br>
    <input type="date" name="fecha" value="<?php echo $nota['fecha']; ?>" required><br><br>

    <input type="submit" value="Guardar Cambios" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>

<script>
// Lógica de carga dinámica, igual que en create.php
function cargarMaestros() {
    var colegioId = document.getElementById("colegio").value;
    fetch('getMaestros.php?id_colegio=' + colegioId)
        .then(response => response.json())
        .then(data => {
            var maestroSelect = document.getElementById("maestro");
            maestroSelect.innerHTML = '<option value="">Selecciona un maestro</option>';
            data.forEach(maestro => {
                maestroSelect.innerHTML += '<option value="' + maestro.id_maestro + '">' + maestro.nombre + '</option>';
            });
        });
}

function cargarCursos() {
    var maestroId = document.getElementById("maestro").value;
    fetch('getCursos.php?id_maestro=' + maestroId)
        .then(response => response.json())
        .then(data => {
            var cursoSelect = document.getElementById("curso");
            cursoSelect.innerHTML = '<option value="">Selecciona un curso</option>';
            data.forEach(curso => {
                cursoSelect.innerHTML += '<option value="' + curso.id_curso + '">' + curso.nombre + '</option>';
            });
        });
}

function cargarEstudiantes() {
    var cursoId = document.getElementById("curso").value;
    fetch('getEstudiantes.php?id_curso=' + cursoId)
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
