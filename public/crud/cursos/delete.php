<?php
include '../../../../analisis2_notas/includes/db.php';

// Obtener el ID del curso desde la URL
$id_curso = $_GET['id'];

// Verificar si el ID existe
if (isset($id_curso)) {
    // Consulta para eliminar el curso
    $sql = "DELETE FROM cursos WHERE id_curso='$id_curso'";
    
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
