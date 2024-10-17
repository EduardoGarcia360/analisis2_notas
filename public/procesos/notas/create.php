<?php
ob_start();
include '../../../../analisis2_notas/includes/db.php';
include '../../../../analisis2_notas/public/header.php';

// Variables para almacenar los valores seleccionados
$colegios = $conn->query("SELECT id_colegio, nombre FROM colegio");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_estudiante = $_POST['id_estudiante'];
    $id_curso = $_POST['id_curso'];
    $nota = $_POST['nota'];
    $fecha = $_POST['fecha'];

    // Insertar los datos
    $sql = "INSERT INTO notas (id_estudiante, id_curso, nota, fecha) 
            VALUES ('$id_estudiante', '$id_curso', '$nota', '$fecha')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<h2>Añadir Nota</h2>
<form method="POST" id="formNota">
    <label>Colegio:</label><br>
    <select name="id_colegio" id="colegio" required onchange="cargarMaestros()">
        <option value="">Selecciona un colegio</option>
        <?php while ($colegio = $colegios->fetch_assoc()) { ?>
            <option value="<?php echo $colegio['id_colegio']; ?>"><?php echo $colegio['nombre']; ?></option>
        <?php } ?>
    </select><br><br>

    <label>Maestro:</label><br>
    <select name="id_maestro" id="maestro" required onchange="cargarCursos()">
        <option value="">Selecciona un maestro</option>
    </select><br><br>

    <label>Curso:</label><br>
    <select name="id_curso" id="curso" required onchange="cargarEstudiantes()">
        <option value="">Selecciona un curso</option>
    </select><br><br>

    <label>Estudiante:</label><br>
    <select name="id_estudiante" id="estudiante" required>
        <option value="">Selecciona un estudiante</option>
    </select><br><br>

    <label>Nota:</label><br>
    <input type="text" name="nota" required><br>

    <label>Fecha:</label><br>
    <input type="date" name="fecha" required><br><br>

    <input type="submit" value="Guardar" class="btn btn-success">
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include '../../../../analisis2_notas/public/footer.php'; ?>

<script>
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
