<?php
include '../../../../analisis2_notas/includes/db.php';

// Obtener el ID de la inscripción desde la URL
$id_nota = $_GET['id'];

// Verificar si el ID existe
if (isset($id_inscripcion)) {
    // Consulta para eliminar la inscripción
    $sql = "DELETE FROM notas WHERE id_nota='$id_nota'";
    
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
