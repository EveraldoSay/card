<?php
require_once "../config/conexion.php";

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['editar_id']) && !empty($_POST['editar_nombre'])) {
        $id = intval($_POST['editar_id']);
        $nombre = mysqli_real_escape_string($conexion, trim($_POST['editar_nombre']));
        
        // Verificar si la categoría ya existe
        $query_verificar = mysqli_query($conexion, "SELECT * FROM categorias WHERE categoria = '$nombre' AND id != $id");
        if (mysqli_num_rows($query_verificar) > 0) {
            // Categoría ya existe
            header('Location: categorias.php?mensaje=ya_existe');
            exit();
        }

        // Actualizar la categoría
        $query_actualizar = mysqli_query($conexion, "UPDATE categorias SET categoria = '$nombre' WHERE id = $id");
        if ($query_actualizar) {
            header('Location: categorias.php?mensaje=editado');
            exit();
        } else {
            header('Location: categorias.php?mensaje=error');
            exit();
        }
    } else {
        // Datos incompletos
        header('Location: categorias.php?mensaje=datos_incompletos');
        exit();
    }
} else {
    // Acceso denegado
    header('Location: categorias.php?mensaje=acceso_denegado');
    exit();
}
?>
