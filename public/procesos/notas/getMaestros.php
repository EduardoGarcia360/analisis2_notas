<?php
include '../../../../analisis2_notas/includes/db.php';

$id_colegio = $_GET['id_colegio'];

$sql = "SELECT id_maestro, nombre FROM maestros WHERE id_colegio='$id_colegio'";
$result = $conn->query($sql);

$maestros = [];
while ($row = $result->fetch_assoc()) {
    $maestros[] = $row;
}

echo json_encode($maestros);
?>
