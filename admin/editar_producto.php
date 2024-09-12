<?php
require_once "../config/conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($conexion, "SELECT * FROM productos WHERE id = $id");
    $data = mysqli_fetch_assoc($query);
}

if (isset($_POST['actualizar'])) {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $p_normal = $_POST['p_normal'];
    $p_rebajado = $_POST['p_rebajado'];
    $categoria = $_POST['categoria'];

    $img = $_FILES['foto'];
    if (!empty($img['name'])) {
        $name = $img['name'];
        $tmpname = $img['tmp_name'];
        $fecha = date("YmdHis");
        $foto = $fecha . ".jpg";
        $destino = "../assets/img/" . $foto;
        move_uploaded_file($tmpname, $destino);
        $query = mysqli_query($conexion, "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio_normal='$p_normal', precio_rebajado='$p_rebajado', cantidad=$cantidad, imagen='$foto', id_categoria=$categoria WHERE id=$id");
    } else {
        $query = mysqli_query($conexion, "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio_normal='$p_normal', precio_rebajado='$p_rebajado', cantidad=$cantidad, id_categoria=$categoria WHERE id=$id");
    }

    if ($query) {
        header('Location: productos.php');
    }
}
?>
<?php include("includes/header.php"); ?>
<div class="container">
    <h2>Editar Producto</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input id="nombre" class="form-control" type="text" name="nombre" value="<?php echo $data['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad</label>
            <input id="cantidad" class="form-control" type="number" name="cantidad" value="<?php echo $data['cantidad']; ?>" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" class="form-control" name="descripcion" rows="3" required><?php echo $data['descripcion']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="p_normal">Precio Normal</label>
            <input id="p_normal" class="form-control" type="text" name="p_normal" value="<?php echo $data['precio_normal']; ?>" required>
        </div>
        <div class="form-group">
            <label for="p_rebajado">Precio Rebajado</label>
            <input id="p_rebajado" class="form-control" type="text" name="p_rebajado" value="<?php echo $data['precio_rebajado']; ?>" required>
        </div>
        <div class="form-group">
            <label for="categoria">Categoría</label>
            <select id="categoria" class="form-control" name="categoria" required>
                <?php
                $categorias = mysqli_query($conexion, "SELECT * FROM categorias");
                foreach ($categorias as $cat) { ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $data['id_categoria'] == $cat['id'] ? 'selected' : ''; ?>><?php echo $cat['categoria']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="imagen">Foto</label>
            <input type="file" class="form-control" name="foto">
        </div>
        <button class="btn btn-primary" type="submit" name="actualizar">Actualizar Producto</button>
    </form>
</div>
<?php include("includes/footer.php"); ?>
