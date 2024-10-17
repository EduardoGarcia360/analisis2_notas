<?php
include '../../../../analisis2_notas/includes/db.php';
$colegio_id = $_GET['colegio_id'];
$sql = "SELECT id_estudiante, nombre FROM estudiantes WHERE id_colegio='$colegio_id'";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo "<option value='".$row['id_estudiante']."'>".$row['nombre']."</option>";
}
?>
