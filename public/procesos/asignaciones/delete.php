<?php
include '../../../../analisis2_notas/includes/db.php';

// Obtener el ID de la asignación desde la URL
$id_asignacion = $_GET['id'];

// Verificar si el ID existe
if (isset($id_asignacion)) {
    // Consulta para eliminar la asignación
    $sql = "DELETE FROM asignaciones WHERE id_asignacion='$id_asignacion'";
    
    if ($conn->query($sql) === TRUE) {
        // Redirigir al index después de eliminar
        header("Location: index.php");
    } else {
        echo "Error al eliminar: " . $conn->error;
    }
} else {
    // Si no se proporciona el ID, redirigir al index
    header("Location: index.php");
}
?>
