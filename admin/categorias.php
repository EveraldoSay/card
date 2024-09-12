<?php
ob_start(); // Inicia el almacenamiento en búfer de salida
require_once "../config/conexion.php";
include("includes/header.php");

// Manejo de inserción de nueva categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nombre'])) {
        $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
        
        // Verificar si la categoría ya existe
        $query_verificar = mysqli_query($conexion, "SELECT * FROM categorias WHERE categoria = '$nombre'");
        if (mysqli_num_rows($query_verificar) > 0) {
            // Categoría ya existe
            header('Location: categorias.php?mensaje=ya_existe');
            exit();
        }

        // Insertar la nueva categoría
        $query_insertar = mysqli_query($conexion, "INSERT INTO categorias(categoria) VALUES ('$nombre')");
        if ($query_insertar) {
            header('Location: categorias.php?mensaje=registrado');
            exit();
        } else {
            header('Location: categorias.php?mensaje=error');
            exit();
        }
    } else {
        // Nombre vacío
        header('Location: categorias.php?mensaje=datos_incompletos');
        exit();
    }
}
?>

<!-- Mostrar mensajes -->
<?php
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
    switch ($mensaje) {
        case 'registrado':
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Categoría registrada exitosamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            break;
        case 'editado':
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    Categoría actualizada exitosamente.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            break;
        case 'ya_existe':
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    La categoría ya existe.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            break;
        case 'error':
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Hubo un error al procesar la solicitud. Inténtalo de nuevo.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            break;
        case 'no_encontrada':
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    La categoría no fue encontrada.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            break;
        case 'datos_incompletos':
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Por favor, completa todos los campos.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            break;
        case 'acceso_denegado':
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Acceso denegado.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
            break;
        default:
            // No hacer nada
            break;
    }
}
?>

<!-- Encabezado y Botón para Nueva Categoria -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Categorías</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#categorias"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>

<!-- Tabla de Categorías -->
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM categorias ORDER BY id DESC");
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo htmlspecialchars($data['categoria']); ?></td>
                            <td>
                                <!-- Botón de Editar con ícono -->
                                <button class="btn btn-warning btn-sm editarCategoria" 
                                        data-id="<?php echo $data['id']; ?>" 
                                        data-nombre="<?php echo htmlspecialchars($data['categoria']); ?>">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                
                                <!-- Botón de Eliminar con ícono -->
                                <form method="post" action="eliminar.php?accion=cli&id=<?php echo $data['id']; ?>" class="d-inline eliminar">
                                    <button class="btn btn-danger btn-sm" type="submit">
                                        <i class="fas fa-trash"></i> Eliminar
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

<!-- Modal para Agregar Nueva Categoria -->
<div id="categorias" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="nuevo-categoria-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="categorias.php" method="POST" autocomplete="off">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title" id="nuevo-categoria-title">Nueva Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Categoría" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Editar Categoría -->
<div id="editarCategoriaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editar-categoria-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="editar_categorias.php" method="POST" autocomplete="off">
                <div class="modal-header bg-gradient-warning text-white">
                    <h5 class="modal-title" id="editar-categoria-title">Editar Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editar_nombre">Nombre</label>
                        <input id="editar_nombre" class="form-control" type="text" name="editar_nombre" placeholder="Categoría" required>
                        <input type="hidden" id="editar_id" name="editar_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn btn-warning" type="submit">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Incluye el pie de página -->
<?php include("includes/footer.php"); ?>
<?php ob_end_flush(); // Finaliza el almacenamiento en búfer de salida ?>

<!-- Script para llenar el modal de edición -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.editarCategoria').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            
            document.getElementById('editar_id').value = id;
            document.getElementById('editar_nombre').value = nombre;
            
            $('#editarCategoriaModal').modal('show');
        });
    });
});
</script>
