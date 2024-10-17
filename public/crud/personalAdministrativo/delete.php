<?php
include '../../../../analisis2_notas/includes/db.php';

// Obtener el ID del personal administrativo desde la URL
$id_personal = $_GET['id'];

// Verificar si el ID existe
if (isset($id_personal)) {
    // Consulta para eliminar el personal administrativo
    $sql = "DELETE FROM personal_administrativo WHERE id_personal='$id_personal'";
    
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
