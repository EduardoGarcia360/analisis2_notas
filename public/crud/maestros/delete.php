<?php
include '../../../../analisis2_notas/includes/db.php';

// Obtener el ID del maestro desde la URL
$id_maestro = $_GET['id'];

// Verificar si el ID existe
if (isset($id_maestro)) {
    // Consulta para eliminar el maestro
    $sql = "DELETE FROM maestros WHERE id_maestro='$id_maestro'";
    
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
