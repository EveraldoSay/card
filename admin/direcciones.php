<?php
require_once "../config/conexion.php";

// Manejo de la solicitud de inserción
if (isset($_POST) && !empty($_POST)) {
    $id_usuario = $_POST['id_usuario'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $codigo_postal = $_POST['codigo_postal'];
    $pais = $_POST['pais'];

    $query = mysqli_query($conexion, "INSERT INTO direcciones(id_usuario, direccion, ciudad, codigo_postal, pais) 
                                      VALUES ('$id_usuario', '$direccion', '$ciudad', '$codigo_postal', '$pais')");
    if ($query) {
        header('Location: direcciones.php');
    }
}

include("includes/header.php");
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Direcciones</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirDireccion"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Dirección</th>
                        <th>Ciudad</th>
                        <th>Código Postal</th>
                        <th>País</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conexion, "SELECT d.id, d.direccion, d.ciudad, d.codigo_postal, d.pais, u.nombre as usuario 
                                                      FROM direcciones d 
                                                      JOIN usuarios u ON d.id_usuario = u.id 
                                                      ORDER BY d.id DESC");
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['usuario']; ?></td>
                            <td><?php echo $data['direccion']; ?></td>
                            <td><?php echo $data['ciudad']; ?></td>
                            <td><?php echo $data['codigo_postal']; ?></td>
                            <td><?php echo $data['pais']; ?></td>
                            <td>
                                <!-- Botón para editar -->
                                <a href="editar_direccion.php?id=<?php echo $data['id']; ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                <!-- Botón para eliminar -->
                                <form method="post" action="eliminar.php?accion=direccion&id=<?php echo $data['id']; ?>" class="d-inline eliminar">
                                    <button class="btn btn-danger" type="submit">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="direcciones" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Nueva Dirección</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="id_usuario">Usuario</label>
                        <select id="id_usuario" class="form-control" name="id_usuario" required>
                            <?php
                            // Obtener los usuarios para llenar el select
                            $usuarios_query = mysqli_query($conexion, "SELECT id, nombre FROM usuarios");
                            while ($usuario = mysqli_fetch_assoc($usuarios_query)) {
                                echo "<option value='{$usuario['id']}'>{$usuario['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Dirección" required>
                    </div>
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input id="ciudad" class="form-control" type="text" name="ciudad" placeholder="Ciudad" required>
                    </div>
                    <div class="form-group">
                        <label for="codigo_postal">Código Postal</label>
                        <input id="codigo_postal" class="form-control" type="text" name="codigo_postal" placeholder="Código Postal" required>
                    </div>
                    <div class="form-group">
                        <label for="pais">País</label>
                        <input id="pais" class="form-control" type="text" name="pais" placeholder="País" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>