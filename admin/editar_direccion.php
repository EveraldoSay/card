<?php
require_once "../config/conexion.php";

// Obtener el ID de la dirección a editar
$id = $_GET['id'];

// Obtener los datos de la dirección
$query = mysqli_query($conexion, "SELECT * FROM direcciones WHERE id = $id");
$data = mysqli_fetch_assoc($query);

// Manejar la solicitud de actualización
if (isset($_POST) && !empty($_POST)) {
    $id_usuario = $_POST['id_usuario'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];
    $pais = $_POST['pais'];

    $update_query = mysqli_query($conexion, "UPDATE direcciones 
                                             SET id_usuario = '$id_usuario', direccion = '$direccion', ciudad = '$ciudad', codigo_postal = '$codigo_postal', pais = '$pais' 
                                             WHERE id = $id");
    if ($update_query) {
        header('Location: direcciones.php');
    }
}

include("includes/header.php");
?>

<div class="container">
    <h2 class="my-4">Editar Dirección</h2>
    <form action="" method="POST" autocomplete="off">
        <div class="form-group">
            <label for="id_usuario">Usuario</label>
            <select id="id_usuario" class="form-control" name="id_usuario" required>
                <?php
                // Obtener los usuarios para llenar el select
                $usuarios_query = mysqli_query($conexion, "SELECT id, nombre FROM usuarios");
                while ($usuario = mysqli_fetch_assoc($usuarios_query)) {
                    $selected = $usuario['id'] == $data['id_usuario'] ? 'selected' : '';
                    echo "<option value='{$usuario['id']}' $selected>{$usuario['nombre']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input id="direccion" class="form-control" type="text" name="direccion" value="<?php echo $data['direccion']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ciudad">Ciudad</label>
            <input id="ciudad" class="form-control" type="text" name="ciudad" value="<?php echo $data['ciudad']; ?>" required>
        </div>
        <div class="form-group">
            <label for="codigo_postal">Código Postal</label>
            <input id="codigo_postal" class="form-control" type="text" name="codigo_postal" value="<?php echo $data['codigo_postal']; ?>" required>
        </div>
        <div class="form-group">
            <label for="pais">País</label>
            <input id="pais" class="form-control" type="text" name="pais" value="<?php echo $data['pais']; ?>" required>
        </div>
        <button class="btn btn-primary" type="submit">Actualizar</button>
    </form>
</div>

<?php include("includes/footer.php"); ?>
